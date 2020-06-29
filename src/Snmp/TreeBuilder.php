<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Snmp;

use NoFlash\MibParser\Exception\HeapTooDeepException;
use NoFlash\MibParser\FFI\NetSnmpBridge;

class TreeBuilder
{
    private const DEFAULT_MAX_DEPTH = 4096;

    private NetSnmpBridge $ffiBridge;

    public function __construct(NetSnmpBridge $ffiBridge)
    {
        $this->ffiBridge = $ffiBridge;
    }

    public function buildFromOid(string $oid, int $maxDepth = \PHP_INT_MAX): TreeNode
    {
        [$oid, $oidLen] = $this->ffiBridge->getOidByName($oid);

        return $this->buildNode($this->ffiBridge->getSubtree($oid, $oidLen), $maxDepth);
    }

    private function buildNode(
        \FFI\CData $tree,
        int $softHeapLimit = \PHP_INT_MAX,
        int $hardHeapLimit = self::DEFAULT_MAX_DEPTH
    ): TreeNode {
        if ($hardHeapLimit <= 0) {
            throw new HeapTooDeepException('Too many nesting levels while processing tree');
        }

        $node = new TreeNode($tree->type, $tree->subid, \FFI::string($tree->label), $tree->access);

        $nodeType = $tree->type;
        if ($nodeType === NodeType::OTHER || $nodeType > NodeType::SIMPLE_LAST) {
            $this->fillBranchNode($tree, $node);
        } else {
            $this->fillLeafNode($tree, $node);
        }


        //Soft heap limit IGNORES anything below certain depth, while hard heap limit ensures we don't consume huge
        // amounts of memory with very deep (or most likely looped) trees
        if (--$softHeapLimit < 0) {
            return $node;
        }

        for ($ntp = $tree->child_list; $ntp !== null; $ntp = $ntp->next_peer) {
            $node->addFirstChild($this->buildNode($ntp, $softHeapLimit, $hardHeapLimit - 1));
        }

        return $node;
    }

    private function fillBranchNode(\FFI\CData $tree, TreeNode $node): void
    {
        $index = $tree->indexes;
        while ($index !== null) {
            $node->addIndex(\FFI::string($index->ilabel));
            $index = $index->next;
        }
    }

    private function fillLeafNode(\FFI\CData $tree, TreeNode $node): void
    {
        $nodeType = $tree->type;

        if ($tree->tc_index >= 0) {
            $node->txtConvention = $this->ffiBridge->getTextualConversionDescriptionByIndex($tree->tc_index);
        }

        $enum = $tree->enums;
        while ($enum !== null) {
            $node->setEnumMapping($enum->value, \FFI::string($enum->label));
            $enum = $enum->next;
        }

        //If this is a string-like type it has a size, otherwise it's a range (parse.c::print_mib_leaves())
        $range = $tree->ranges;
        while ($range !== null) {
            $low = $range->low;
            $high = $range->high;

            //Handling for unsigned types is slightly opaque
            // if you get value of e.g. "-1" it means overflow from 32 bit int: -1 => 4294967295
            if ($nodeType === NodeType::UNSIGNED32 || $nodeType === NodeType::OCTETSTR ||
                $nodeType === NodeType::GAUGE || $nodeType === NodeType::UINTEGER) {
                //This is an equivalent of (unsigned) cast in C. Doing bitshifts is also funky on 64 bit
                if ($low < 0) {
                    $low = 4_294_967_296 + $low;
                }

                if ($high < 0) {
                    $high = 4_294_967_296 + $high;
                }
            }

            $node->addRange($low, $high);
            $range = $range->next;
        }
    }
}
