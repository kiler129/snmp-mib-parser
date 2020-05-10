<?php
declare(strict_types=1);

namespace NoFlash\MibParser\Factory;

use NoFlash\MibParser\FFI\DefaultStore;
use NoFlash\MibParser\FFI\NetSnmpBridge;

class NetSnmpBridgeFactory
{
    private const NET_SNMP_HEADERS = __DIR__ . '/../../resources/headers/net-snmp.h';

    static public function createBridge(): NetSnmpBridge
    {
        $ctx = self::createFfiContext();
        self::initNetSnmp($ctx);

        return new NetSnmpBridge($ctx);
    }

    static private function createFfiContext(): \FFI
    {
        return \FFI::load(self::NET_SNMP_HEADERS);
    }

    static private function initNetSnmp(\FFI $ffiCtx): void
    {
        //According to php-src init_snmp() may damage locale. While I wasn't able to confirm that better stay safe than
        // sorry: https://github.com/php/php-src/blob/c34d29db33593def717b3668aa60e2b425aaa634/ext/snmp/snmp.c#L1975
        $localeBackup = \setlocale(\LC_CTYPE, 0);
        $ffiCtx->init_snmp('snmpapp'); //magic method to load all environment-related stuff
        \setlocale(\LC_CTYPE, $localeBackup);

        //Just in case - prevent permanent modifications of the config
        $ffiCtx->netsnmp_ds_set_boolean(
            DefaultStore::NETSNMP_DS_LIBRARY_ID,
            DefaultStore::NETSNMP_DS_LIB_DONT_PERSIST_STATE,
            1
        );
    }
}
