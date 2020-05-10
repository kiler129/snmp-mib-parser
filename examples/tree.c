/*
 * This file contains a simplest C source code to print the OID tree in console
 *
 * You don't need this file - it's provided for reference only to compare
 * implementations. The "print_mib_tree()" used here doesn't allow for any
 * information extraction and does what is says: prints an ASCII tree to
 * console.
 *
 *
 * Compilation:
 *   gcc -lnetsnmp -o native-tree tree.c
 *
 * Usage:
 *  chmod +x native-tree
 *  ./native-tree 'SNMPv2-MIB::system'
 */
#include <stdlib.h>
#include <net-snmp/net-snmp-config.h>
#include <net-snmp/mib_api.h>

int main(int argc, char *argv[])
{
    oid          oid[MAX_OID_LEN];
    size_t       oidLen = MAX_OID_LEN;
    char        *humanOid = argv[1];
    struct tree *workTree;


    if (argc != 2) {
        fprintf(stderr, "Usage: %s oid\n", argv[0]);
        exit(2);
    }

    //Magic Net-SNMP call to load configuration, MIBs, etc.
    init_snmp("snmpapp");

    //Convert name to OID structure
    if (!read_objid(humanOid, oid, &oidLen)) {
        fprintf(stderr, "Failed to get OID for \"%s\"\n", humanOid);
        exit(2);
    }

    //Get pointer to the sub-tree where our OID is
    workTree = get_tree(oid, oidLen, get_tree_head());
    if (workTree == NULL) {
        fprintf(stderr, "Tree does not contain \"%s\"\n", humanOid);
        exit(1);
    }

    print_mib_tree(stdout, workTree, 80);
}
