<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Exception\NetSnmp;

use NoFlash\MibParser\FFI\SnmpApi;

class GeneralErrorException extends NetSnmpException
{
    protected function __construct(?string $message = null, ?\Throwable $previous = null)
    {
        parent::__construct($message ?? 'General Error', SnmpApi::SNMPERR_GENERR, $previous);
    }
}
