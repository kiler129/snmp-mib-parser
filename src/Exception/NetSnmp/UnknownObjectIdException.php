<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Exception\NetSnmp;

use NoFlash\MibParser\FFI\SnmpApi;

final class UnknownObjectIdException extends NetSnmpException
{
    protected function __construct(?string $message = null, ?\Throwable $previous = null)
    {
        parent::__construct($message ?? 'OID does not exist', SnmpApi::SNMPERR_UNKNOWN_OBJID, $previous);
    }
}
