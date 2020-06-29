<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Exception;

/**
 * Should be used when you expect e.g. numeric OID and you get a name
 */
class UnexpectedOidException extends \InvalidArgumentException
{

}
