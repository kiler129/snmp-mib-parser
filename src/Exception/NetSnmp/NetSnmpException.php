<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Exception\NetSnmp;

use NoFlash\MibParser\FFI\SnmpApi;
use RuntimeException;

class NetSnmpException extends RuntimeException
{
    private const EXCEPTION_MAP = [
        SnmpApi::SNMPERR_UNKNOWN_OBJID => UnknownObjectIdException::class
    ];

    protected function __construct(?string $message = null, int $code = SnmpApi::SNMPERR_GENERR, ?\Throwable $previous = null)
    {
        if ($message === null) {
            $message = SnmpApi::SNMPERR_NUM_TO_TEXT[$code] ?? ('UNKNOWN_' . $code);
            $message .= ' Net-SNMP error (' . $code . ')';
        }

        parent::__construct($message, $code, $previous);
    }

    static public function create(int $code, ?string $message = null, ?\Throwable $previous = null): NetSnmpException
    {
        if (isset(self::EXCEPTION_MAP[$code])) {
            return new (self::EXCEPTION_MAP[$code])($message, $previous);
        }

        return new (self::class)($message, $code, $previous);
    }
}
