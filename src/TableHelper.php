<?php
declare(strict_types=1);

namespace NoFlash\MibParser;

use NoFlash\MathSet\DTO\IntegerSet;
use NoFlash\MibParser\Exception\MalformedMibException;
use NoFlash\MibParser\Exception\UnexpectedOidException;
use NoFlash\MibParser\Snmp\TreeBuilder;
use NoFlash\MibParser\Snmp\TreeNode;

/**
 * Alleviates pain while dealing with SNMP tables
 *
 * Tables in SNMP are... well, not really designed but feel like placed in the standard as an afterthought. That's why
 * dealing with them often requires mind-twisting tricks. This class tries to abstract some of them.
 */
class TableHelper
{
    private TreeBuilder $treeBuilder;

    private array $tableEntryCache = [];

    public function __construct(TreeBuilder $treeBuilder)
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * Gets the range of rows expected for a retrieved table
     *
     * Each table must contain at least one index (in practice it's always one). This index defines a field which is
     * used like an index while records are returned. Given index field is always numeric (TECHNICALLY it can be an
     * enum or any other field but I never seen this supported anywhere) and counts up from some value. In response for
     * a table SNMP agent returns fields (yes, fields, since tables aren't real in SNMP...) like "ifDescr.0",
     * "ifDescr.1" etc. The trick is you never know if ".0" is first or ".1".... or maybe the MIB author was born on the
     * 13th so it fucking starts counting from "ifYolo.13", because why count from 0 if you can count from any number?!
     * ...and yes, while Linux usually counts from 0, e.g. Synology DSM counts their proprietary stuff from 1. FML.
     *
     * @param string $tableOid
     *
     * @return IntegerSet|null
     */
    public function getTableIndexRange(string $tableOid): ?IntegerSet
    {
        $entry = $this->getTableEntry($tableOid);

        //Not really care about the case of $indexes >1 - this is something which even Net-SNMP doesn't implement in
        // their tools. It seems like they had an idea but never followed (technically a table can have multiple indexes
        // but only the first one is used)
        $indexLabel = $entry->getIndexes()[0]; //Table entries are guaranteed to have at least one index, so this is safe

        $indexNode = null;
        foreach ($entry->getChildren() as $child) {
            if ($child->label === $indexLabel) {
                $indexNode = $child;
                break;
            }
        }

        //This means that the MIB is broken out right - a field which doesn't exist was specified as index (?!)
        if ($indexNode === null) {
            throw new MalformedMibException(
                \sprintf(
                    'OID=%s table entry defines index "%s" but no such field is defined (?!). Your MIB is broken.',
                    $tableOid,
                    $indexLabel
                )
            );
        }

        //Compress multiple ranges to one
        $minLeft = null;
        $maxRight = null;
        foreach ($indexNode->getRanges() as $range) {
            $left = $range->getLeft();
            if ($left !== null && ($minLeft === null || $left < $minLeft)) {
                $minLeft = $left;
            }

            $right = $range->getRight();
            if ($right !== null && ($maxRight === null || $left > $maxRight)) {
                $maxRight = $right;
            }
        }

        return $minLeft === null ? null : new IntegerSet($minLeft, $maxRight);
    }

    /**
     * Gets table entry template
     *
     * Again, tables aren't real in SNMP... and this is another quirk resulting from that. In order to define the
     * structure of expected response tables in MIBs are defined in a very particular way. First a table entry with type
     * OTHER (NodeType::OTHER) is made (e.g. IF-MIB has ifTable). Then underneath you MUST have another node which is
     * called an "entry" which corresponds to a "conceptual row" (RFC wording). This imaginary row contains fields which
     * are expected to be returned when you ask an agent for the table. Such imaginary row definition MUST contain an
     * index (or augments, but this is not implemented as never seen in the wild) which defines a field which is a
     * counter for rows (see getTableIndexRange()) and usually hidden by all the tools.
     * This method returns this entry node with all its fields. Since fields should not contain children (because SNMP
     * tables are one-dimensional) this method WILL limit the depth of MIB scanning (since if the MIB is broken it's
     * broken ffs).
     *
     * Example for IF-MIB::ifTable (first 2 fields only):
     * 📂  ifTable @ 2 (NT=0)
     *  📂  ifEntry @ 1 (🗄 {ifIndex}, NT=0)
     *  📜 (Integer32 | int)  ifIndex @ 1 (r/w: ✅/❌, 🔢[1,2147483647], 📝InterfaceIndex, NT=16)
     *  📜 (OCTET STRING | string)  ifDescr @ 2 (r/w: ✅/❌, 🔢[0,255], 📝DisplayString, NT=2)
     *
     * @param string $tableOid
     *
     * @return TreeNode
     */
    private function getTableEntry(string $tableOid): TreeNode
    {
        if (!isset($this->tableEntryCache[$tableOid])) {
            //By RFC tables must be defined as branches which when traversed in MIB form (i.e. not in the final output)
            // yield entry template which then contains all the columns underneath.
            //Also, the entry/row template should contain an index which specifies range used later to build the results.
            $node = $this->treeBuilder->buildFromOid($tableOid, 2); //Reads table->entry->fields
            $entry = null;
            foreach ($node->getChildren() as $child) {
                //This should (ideally) yield only one child entry and never return false for isTableRow() *IF* the MIB is
                // up to spec [some aren't]
                if ($child->isTableRow()) {
                    $entry = $child;
                    break;
                }
            }

            if ($entry === null) {
                throw new UnexpectedOidException(
                    \sprintf('OID=%s does not look like a table - no entry point found', $tableOid)
                );
            }

            $this->tableEntryCache[$tableOid] = $entry;
        }

        return $this->tableEntryCache[$tableOid];
    }

    /**
     * Some operations are extensive and thus use caching - this frees it.
     */
    public function freeCache(): void
    {
        $this->tableEntryCache = [];
    }
}
