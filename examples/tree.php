#!/usr/bin/env php
<?php
declare(strict_types=1);
/*
 * This file contains a simplest PHP source code to print the OID tree in console
 *
 * Usage:
 *  ./tree.php 'SNMPv2-MIB::system'
 *  or
 *  php ./tree.php 'SNMPv2-MIB::system'
 */

use NoFlash\MibParser\Factory\NetSnmpBridgeFactory;
use NoFlash\MibParser\Snmp\TreeBuilder;
use NoFlash\MibParser\Snmp\TreeNode;

require __DIR__ . '/../vendor/autoload.php';

if ($argc !== 2) {
    printf("Usage: %s oid\n", $argv[0]);
    exit(2);
}

$oid = \trim($argv[1]);
if (\strlen($oid) === 0) {
    print("OID cannot be empty!\n");
    exit(1);
}

$bridge = NetSnmpBridgeFactory::createBridge();
$treeBuilder = new TreeBuilder($bridge);
printNodeRecursively($treeBuilder->buildFromOid($oid));

function printNodeRecursively(TreeNode $node, int $level = 0): void
{
    echo \str_repeat('  ', $level); //Padding for every level

    $extraInfo = [];
    $type = $node->getNodeType();
    if ($type->isContainer()) { //Checking if it may have kids (not if it does)
        \printf('📂 ');
    } else {
        \printf("📜 \e[2m(%s | %s)\e[0m ", $type->asString(), $type->getPhpTypeName());

        $access = $node->getNodeAccess();
        $extraInfo[] = \sprintf('r/w: %s/%s',
            ($access->isReadable() ? '✅' : '❌'),
            ($access->isWritable() ? '✅' : '❌')
        );
    }

    \printf(" \e[1m%s\e[0m @ %d", $node->label, $node->subId); //Make label bold

    $idx = $node->getIndexes();
    if (\count($idx) > 0) {
        $extraInfo[] = \sprintf('🗄 {%s}', \implode(', ', $idx));
    }

    $ranges = $node->ranges;
    if (\count($ranges) > 0) {
        $extraInfo[] = '🔢' . \implode('/', $ranges);
    }

    if ($node->txtConvention !== null) {
        $extraInfo[] = '📝' . $node->txtConvention;
    }

    if (isset($extraInfo[0])) {
        printf(" \e[3m(%s)\e[0m", \implode(', ', $extraInfo)); //Make extras italic
    }

    echo "\n";
    foreach ($node->children as $child) {
        printNodeRecursively($child, $level+1);
    }
}
