<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Snmp;

use NoFlash\MathSet\DTO\IntegerSet;

final class TreeNode
{
    /** Raw type of the node */
    private int $type;

    /** Friendly OOP type */
    private NodeType $nodeType;

    /** Branch/leaf OID part */
    public int $subId;

    /** Name/label of the node */
    public string $label;

    /** Description of the node (if any) */
    public ?string $description = null;

    /** Raw access level of the node */
    private int $access;

    /** Friendly OOP access */
    public NodeAccess $nodeAccess;

    /**
     * List of indexes (if any).
     *
     * This is expected only for tables as per RFC 2578
     *
     * @see https://tools.ietf.org/html/rfc2578#section-7.7
     * @var string[]
     */
    private array $indexes = [];

    /**
     * Augments (if any)
     *
     * @see https://tools.ietf.org/html/rfc2578#section-7.8
     */
    private ?string $augments = null;

    /**
     * Human-readable information of what's expected in the variable
     *
     * @see https://tools.ietf.org/html/rfc2579
     * @var string|null
     */
    public ?string $txtConvention = null;

    /**
     * @var array<int, string> Map for enumValue => enumTag
     */
    private array $enums = [];

    /**
     * For numeric types it's a real range, for string types (OCTETSTR & OPAQUE) it's a possible text size
     *
     * @var IntegerSet[]
     */
    public array $ranges = [];

    /**
     * List of children (if any)
     *
     * @var NodeType[]
     */
    public array $children = [];

    public function __construct(int $type, int $subId, string $label, int $access)
    {
        $this->type = $type;
        $this->subId = $subId;
        $this->label = $label;
        $this->access = $access;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getNodeType(): NodeType
    {
        $this->nodeType ??= new NodeType($this->type);

        return $this->nodeType;
    }

    public function getAccess(): int
    {
        return $this->access;
    }

    public function getNodeAccess(): NodeAccess
    {
        $this->nodeAccess ??= new NodeAccess($this->access);

        return $this->nodeAccess;
    }

    /**
     * @return NodeType[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function addFirstChild(TreeNode $node): void
    {
        \array_unshift($this->children, $node);
    }

    /**
     * @return string[]
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }

    public function addIndex(string $index): void
    {
        $this->indexes[] = $index;
    }

    /**
     * Adds mapping between ENUM value and it's label/tag
     */
    public function setEnumMapping(int $value, string $label): void
    {
        $this->enums[$value] = $label;
    }

    /**
     * @return array<int, string> Value => Label mapping
     */
    public function getEnums(): array
    {
        return $this->enums;
    }

    /**
     * @return IntegerSet[]
     */
    public function getRanges(): array
    {
        return $this->ranges;
    }

    public function addRange(int $from, int $to): void
    {
        $this->ranges[] = new IntegerSet($from, $to, true, true);
    }

    /**
     * Checks if this node is a table row
     *
     * This exploits the fact that table row MUST contain at least one index or augments, where other ones cannot.
     *
     * @see https://tools.ietf.org/html/rfc2578#section-7.7
     */
    public function isTableRow(): bool
    {
        return isset($this->augments) || \count($this->indexes) > 0;
    }
}
