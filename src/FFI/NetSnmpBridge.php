<?php
declare(strict_types=1);

namespace NoFlash\MibParser\FFI;

use NoFlash\MibParser\Exception\NetSnmp\NetSnmpException;

/**
 * @internal
 */
class NetSnmpBridge
{
    private \FFI $ffi;

    public function __construct(\FFI $ffi)
    {
        $this->ffi = $ffi;
    }

    /**
     * Converts OID name for use with other methods expecting native OID structure
     *
     * @param string $oidName
     *
     * @return array 2 element array, first will be FFI instance of OID array, second will be int with array OID length
     */
    public function getOidByName(string $oidName): array
    {
        $oid = $this->ffi->new('oid[128]');
        $oidLen = $this->ffi->new('size_t');
        $oidLen->cdata = 128; //max legal OID length by the RFC

        $this->ffi->snmp_errno = SnmpApi::SNMPERR_SUCCESS; //Reset error beforehand
        $status = $this->ffi->read_objid($oidName, $oid, \FFI::addr($oidLen));

        if ($status !== 1) {
            throw NetSnmpException::create($this->ffi->snmp_errno);
        }

        return [$oid, $oidLen->cdata];
    }

    /**
     * Return pointer to head/root of the tree
     *
     * @return \FFI\CData Pointer to "struct tree"
     */
    public function getRootTree(): \FFI\CData
    {
        return $this->ffi->get_tree_head();
    }

    /**
     * Gets pointer to subtree
     *
     * @param \FFI\CData $nativeOid Use getOidByName() to get it
     * @param int        $oidLen    Use getOidByName() to get it
     *
     * @return \FFI\CData Pointer to "struct tree"
     */
    public function getSubtree(\FFI\CData $nativeOid, int $oidLen): \FFI\CData
    {
        $tree = $this->ffi->get_tree($nativeOid, $oidLen, $this->getRootTree());
        if ($tree === null) {
            throw NetSnmpException::create(SnmpApi::SNMPERR_GENERR, 'Failed to get subtree (get_tree() null pointer)');
        }

        return $tree;
    }

    public function getTextualConversionDescriptionByIndex(int $index): string
    {
        $desc = $this->ffi->get_tc_descriptor($index);
        if ($desc === null) {
            throw NetSnmpException::create(
                SnmpApi::SNMPERR_GENERR,
                'Failed to get TC description (get_tc_descriptor() null pointer)'
            );
        }

        return $desc;
    }
}
