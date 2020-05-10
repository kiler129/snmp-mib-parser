<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Snmp;

/**
 * Immutable OO representation of MIB tree node access level
 */
final class NodeAccess
{
    /** Node can be read */
    public const READONLY = 18;

    /** Node can be read or changed */
    public const READWRITE = 19;

    /** Node can be changed only */
    public const WRITEONLY = 20;

    /** No access to the node value */
    public const NOACCESS = 21;

    /** Can be read only for notify */
    public const NOTIFY = 67;

    /** Can be created and read (despite the name) */
    public const CREATE = 48;

    /**
     * Maps Net-SNMP access type to MIB-complaint string (used in MAX-ACCESS declarations)
     */
    private const NETSNMP_TO_STRING_MAP = [
        self::READONLY => 'read-only',
        self::READWRITE => 'read-write',
        self::WRITEONLY => 'write-only',
        self::NOACCESS => 'not-accessible',
        self::NOTIFY => 'accessible-for-notify',
        self::CREATE => 'read-create',
    ];

    private int $netSnmpAccess;

    public function __construct(int $netSnmpAccess)
    {
        $this->netSnmpAccess = $netSnmpAccess;
    }

    public function isAccessible(): bool
    {
        return $this->netSnmpAccess !== self::NOACCESS;
    }

    public function isReadable(): bool
    {
        return $this->netSnmpAccess === self::READONLY || $this->netSnmpAccess === self::READWRITE ||
               $this->netSnmpAccess === self::CREATE;
    }

    public function isWritable(): bool
    {
        return $this->netSnmpAccess === self::WRITEONLY || $this->netSnmpAccess === self::READWRITE;
    }

    public function isNotify(): bool
    {
        return $this->netSnmpAccess === self::NOTIFY;
    }

    public function isCreatable(): bool
    {
        return $this->netSnmpAccess === self::CREATE;
    }

    /**
     * Gets string representation of node type
     *
     * This method returns the same values as used by MAX-ACCESS and by Net-SNMP's mib.c::print_tree_node()
     */
    public function asString(): string
    {
        return self::NETSNMP_TO_STRING_MAP[$this->netSnmpAccess] ?? 'UNKNOWN_' . $this->netSnmpAccess;
    }
}
