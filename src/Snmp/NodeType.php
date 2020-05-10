<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Snmp;

/**
 * Immutable OO representation of MIB tree node type
 */
final class NodeType
{
    /** Undetermined (simple type) */
    public const OTHER = 0;

    /** OID (simple type) */
    public const OBJID = 1;

    /** String (simple type) */
    public const OCTETSTR = 2;

    /** Signed 32-bit integer (simple type) */
    public const INTEGER = 3;

    /** ? (simple type) */
    public const NETADDR = 4;

    /** IPv4 address in dotted notation (simple type) */
    public const IPADDR = 5;

    /**
     * Unsigned 32-bit integer (simple type)
     *
     * In theory it should always increase until it gets to 4294967295 and then wraps around starting from 0. In
     * practice this is not followed and the value should be treated as non-negative integers.
     */
    public const COUNTER = 6;

    /**
     * Unsigned bound 32-bit integer (simple type)
     *
     * Can change in any direction (unlike COUNTER). It should contain boundaries/range between which it changed. When
     * reaches values above 32-bit it's expected to NOT wrap aroun (unlike e.g. UNSIGNED32).
     */
    public const GAUGE = 7;

    /**
     * Unsigned 32-bit integer denoting time (simple type)
     *
     * Counts time in 1/100s of a second since a predefined point (usually unix epoch or device start)
     */
    public const TIMETICKS = 8;

    /** String, application-specific semantics (simple type) */
    public const OPAQUE = 9;

    /** NULL value (simple type) */
    public const NULL = 10;

    /**
     * Unsigned 64-bit integer (simple type)
     *
     * In theory it should always increase until it gets to (2^64)-1 and then wraps around starting from 0. In
     * practice this is not followed and the value should be treated as non-negative integers.
     */
    public const COUNTER64 = 11;

    /**
     * String (simple type)
     *
     * @deprecated Defined in RFC 1442 (SNMPv2 draft), obsoleted by RFC 1902 & RFC 257. Use OCTETSTR.
     */
    public const BITSTRING = 12;

    /** ? (simple type) */
    public const NSAPADDRESS = 13;

    /** Unsigned 32-bit integer (simple type) */
    public const UINTEGER = 14;

    /** Unsigned 32-bit integer (simple type) */
    public const UNSIGNED32 = 15;

    /** Signed 32-bit (simple type) */
    public const INTEGER32 = 16;

    /** Last simple type number (left in conformance with original parse.h */
    public const SIMPLE_LAST = 16;

    /*=================================================================================*/
    /******************************* END OF SIMPLE TYPES *******************************/
    /*=================================================================================*/

    /** @see https://tools.ietf.org/html/rfc1215 */
    public const TRAP = 20;

    /** @see https://tools.ietf.org/html/rfc2578#page-34 */
    public const NOTIFICATION_TYPE = 21;

    /** @see https://stackoverflow.com/a/40916606 */
    public const OBJECT_GROUP = 22;

    /** @see https://tools.ietf.org/html/rfc2580#section-4 */
    public const NOTIFICATION_GROUP = 23;

    /** @see https://stackoverflow.com/q/20703582 */
    public const MODID = 24;

    /** @see https://tools.ietf.org/html/rfc2580#section-6 */
    public const AGENT_CAPABILITIES = 25;

    /**
     * @see https://tools.ietf.org/html/rfc2580#page-5
     * @see https://stackoverflow.com/questions/40884135/snmp-purpose-of-object-group-module-compliance-with-regards-to-object-types
     */
    public const MODULE_COMPLIANCE = 26;

    /** ??? */
    public const OBJIDENTITY = 27;

    /**
     * Maps native Net-SNMP data types to PHPs data types
     */
    private const NETSNMP_TO_PHP_MAP = [
        self::OTHER => 'string',
        self::OBJID => 'string',
        self::OCTETSTR => 'string',
        self::INTEGER => 'int',
        self::NETADDR => 'string',
        self::IPADDR => 'string',
        self::COUNTER => 'int',
        self::GAUGE => 'int',
        self::TIMETICKS => 'int',
        self::OPAQUE => 'string',
        self::NULL => 'null',
        self::COUNTER64 => 'int',
        self::BITSTRING => 'string',
        self::NSAPADDRESS => 'string',
        self::UINTEGER => 'int',
        self::UNSIGNED32 => 'int',
        self::INTEGER32 => 'int',
    ];

    /**
     * Maps native Net-SNMP data types to their names
     * This is kept in sync with mib.c::print_tree_node() for compatibility reasons
     */
    private const NETSNMP_TO_STRING_MAP = [
        self::OBJID => 'OBJECT IDENTIFIER',
        self::OCTETSTR => 'OCTET STRING',
        self::INTEGER => 'INTEGER', //This is sometimes distinguished between EnumVal and INTEGER
        self::NETADDR => 'NetworkAddress',
        self::IPADDR => 'IpAddress',
        self::COUNTER => 'Counter32',
        self::GAUGE => 'Gauge32',
        self::TIMETICKS => 'TimeTicks',
        self::OPAQUE => 'Opaque',
        self::NULL => 'NULL',
        self::COUNTER64 => 'Counter64',
        self::BITSTRING => 'BITS',
        self::NSAPADDRESS => 'NsapAddress',
        self::UINTEGER => 'UInteger32',
        self::UNSIGNED32 => 'Unsigned32',
        self::INTEGER32 => 'Integer32',

        /* Additional types not mapped by Net-SNMP */
        self::OTHER => 'Unknown/Other',
        self::TRAP => 'Trap',
        self::NOTIFICATION_TYPE => 'NOTIFICATION-TYPE',
        self::OBJECT_GROUP => 'OBJECT-GROUP',
        self::NOTIFICATION_GROUP => 'NOTIFICATION-GROUP',
        self::MODID => 'MODULE-IDENTITY',
        self::AGENT_CAPABILITIES => 'AGENT-CAPABILITIES',
        self::MODULE_COMPLIANCE => 'MODULE-COMPLIANCE',
        self::OBJIDENTITY => 'OBJIDENTITY', //??
    ];

    private int $netSnmpType;

    public function __construct(int $netSnmpType)
    {
        $this->netSnmpType = $netSnmpType;
    }

    public function isSimple(): bool
    {
        return $this->netSnmpType <= self::SIMPLE_LAST;
    }

    public function isContainer(): bool
    {
        //See parse.c::print_mib_leaves()
        return $this->netSnmpType === self::OTHER || $this->netSnmpType > self::SIMPLE_LAST;
    }

    public function getPhpTypeName(): ?string
    {
        return self::NETSNMP_TO_PHP_MAP[$this->netSnmpType] ?? null;
    }

    /**
     * Gets string representation of the type
     *
     * This method returns the same values as Net-SNMP's mib.c::print_tree_node(). For types
     * not originally returned by Net-SNMP it will return most logical representation.
     */
    public function asString(): string
    {
        return self::NETSNMP_TO_STRING_MAP[$this->netSnmpType] ?? 'UNKNOWN_' . $this->netSnmpType;
    }
}
