<?php
declare(strict_types=1);

namespace NoFlash\MibParser\FFI;

/**
 * Constants as defined in net-snmp/include/net-snmp/library/default_store.h
 *
 * @internal
 */
final class DefaultStore
{
    public const NETSNMP_DS_MAX_IDS                     = 3;
    public const NETSNMP_DS_MAX_SUBIDS                  = 48; // needs to be a multiple of 8
    public const NETSNMP_DS_LIBRARY_ID                  = 0;
    public const NETSNMP_DS_APPLICATION_ID              = 1;
    public const NETSNMP_DS_TOKEN_ID                    = 2;
    public const NETSNMP_DS_LIB_MIB_ERRORS              = 0;
    public const NETSNMP_DS_LIB_SAVE_MIB_DESCRS         = 1;
    public const NETSNMP_DS_LIB_MIB_COMMENT_TERM        = 2;
    public const NETSNMP_DS_LIB_MIB_PARSE_LABEL         = 3;
    public const NETSNMP_DS_LIB_DUMP_PACKET             = 4;
    public const NETSNMP_DS_LIB_LOG_TIMESTAMP           = 5;
    public const NETSNMP_DS_LIB_DONT_READ_CONFIGS       = 6; // don't read normal config files
    public const NETSNMP_DS_LIB_DISABLE_CONFIG_LOAD     = self::NETSNMP_DS_LIB_DONT_READ_CONFIGS;
    public const NETSNMP_DS_LIB_MIB_REPLACE             = 7; // replace objects from latest module
    public const NETSNMP_DS_LIB_PRINT_NUMERIC_ENUM      = 8; // print only numeric enum values
    public const NETSNMP_DS_LIB_PRINT_NUMERIC_OIDS      = 9; // print only numeric enum values
    public const NETSNMP_DS_LIB_DONT_BREAKDOWN_OIDS     = 10; // dont print oid indexes specially
    public const NETSNMP_DS_LIB_ALARM_DONT_USE_SIG      = 11; // don't use the alarm() signal
    public const NETSNMP_DS_LIB_PRINT_FULL_OID          = 12; // print fully qualified oids
    public const NETSNMP_DS_LIB_QUICK_PRINT             = 13; // print very brief output for parsing
    public const NETSNMP_DS_LIB_RANDOM_ACCESS           = 14; // random access to oid labels
    public const NETSNMP_DS_LIB_REGEX_ACCESS            = 15; // regex matching to oid labels
    public const NETSNMP_DS_LIB_DONT_CHECK_RANGE        = 16; // don't check values for ranges on send
    public const NETSNMP_DS_LIB_NO_TOKEN_WARNINGS       = 17; // no warn about unknown config tokens
    public const NETSNMP_DS_LIB_NUMERIC_TIMETICKS       = 18; // print timeticks as a number
    public const NETSNMP_DS_LIB_ESCAPE_QUOTES           = 19; // shell escape quote marks in oids
    public const NETSNMP_DS_LIB_REVERSE_ENCODE          = 20; // encode packets from back to front
    public const NETSNMP_DS_LIB_PRINT_BARE_VALUE        = 21; // just print value (not OID = value)
    public const NETSNMP_DS_LIB_EXTENDED_INDEX          = 22; // print extended index format [x1][x2]
    public const NETSNMP_DS_LIB_PRINT_HEX_TEXT          = 23; // print ASCII text along with hex strings
    public const NETSNMP_DS_LIB_PRINT_UCD_STYLE_OID     = 24; // print OID's using the UCD-style prefix suppression
    public const NETSNMP_DS_LIB_READ_UCD_STYLE_OID      = 25; // require top-level OIDs to be prefixed with a dot
    public const NETSNMP_DS_LIB_HAVE_READ_PREMIB_CONFIG = 26;     // have the pre-mib parsing config tokens been processed
    public const NETSNMP_DS_LIB_HAVE_READ_CONFIG        = 27; // have the config tokens been processed
    public const NETSNMP_DS_LIB_QUICKE_PRINT            = 28;
    public const NETSNMP_DS_LIB_DONT_PRINT_UNITS        = 29; // don't print UNITS suffix
    public const NETSNMP_DS_LIB_NO_DISPLAY_HINT         = 30; // don't apply DISPLAY-HINTs
    public const NETSNMP_DS_LIB_16BIT_IDS               = 31;   // restrict requestIDs, etc to 16-bit values
    public const NETSNMP_DS_LIB_DONT_PERSIST_STATE      = 32;    // don't load config and don't load/save persistent file
    public const NETSNMP_DS_LIB_2DIGIT_HEX_OUTPUT       = 33;    // print a leading 0 on hex values <= 'f'
    public const NETSNMP_DS_LIB_IGNORE_NO_COMMUNITY     = 34;    // don't complain if no community is specified in the command arguments
    public const NETSNMP_DS_LIB_DISABLE_PERSISTENT_LOAD = 35; // don't load persistent file
    public const NETSNMP_DS_LIB_DISABLE_PERSISTENT_SAVE = 36; // don't save persistent file
    public const NETSNMP_DS_LIB_APPEND_LOGFILES         = 37; // append, don't overwrite, log files
    public const NETSNMP_DS_LIB_NO_DISCOVERY            = 38; // don't support RFC5343 contextEngineID discovery
    public const NETSNMP_DS_LIB_TSM_USE_PREFIX          = 39; // TSM's simple security name mapping
    public const NETSNMP_DS_LIB_DONT_LOAD_HOST_FILES    = 40; // don't read host.conf files
    public const NETSNMP_DS_LIB_DNSSEC_WARN_ONLY        = 41; // tread DNSSEC errors as warnings
    public const NETSNMP_DS_LIB_MAX_BOOL_ID             = 48; // match NETSNMP_DS_MAX_SUBIDS
    public const NETSNMP_DS_LIB_MIB_WARNINGS            = 0;
    public const NETSNMP_DS_LIB_SECLEVEL                = 1;
    public const NETSNMP_DS_LIB_SNMPVERSION             = 2;
    public const NETSNMP_DS_LIB_DEFAULT_PORT            = 3;
    public const NETSNMP_DS_LIB_OID_OUTPUT_FORMAT       = 4;
    public const NETSNMP_DS_LIB_PRINT_SUFFIX_ONLY       = self::NETSNMP_DS_LIB_OID_OUTPUT_FORMAT;
    public const NETSNMP_DS_LIB_STRING_OUTPUT_FORMAT    = 5;
    public const NETSNMP_DS_LIB_HEX_OUTPUT_LENGTH       = 6;
    public const NETSNMP_DS_LIB_SERVERSENDBUF           = 7; // send buffer (server)
    public const NETSNMP_DS_LIB_SERVERRECVBUF           = 8; // receive buffer (server)
    public const NETSNMP_DS_LIB_CLIENTSENDBUF           = 9; // send buffer (client)
    public const NETSNMP_DS_LIB_CLIENTRECVBUF           = 10; // receive buffer (client)
    public const NETSNMP_DS_SSHDOMAIN_SOCK_PERM         = 11;
    public const NETSNMP_DS_SSHDOMAIN_DIR_PERM          = 12;
    public const NETSNMP_DS_SSHDOMAIN_SOCK_USER         = 12;
    public const NETSNMP_DS_SSHDOMAIN_SOCK_GROUP        = 13;
    public const NETSNMP_DS_LIB_TIMEOUT                 = 14;
    public const NETSNMP_DS_LIB_RETRIES                 = 15;
    public const NETSNMP_DS_LIB_MAX_INT_ID              = 48; // match NETSNMP_DS_MAX_SUBIDS
    public const NETSNMP_DS_SNMP_VERSION_1              = 128; // bogus
    public const NETSNMP_DS_SNMP_VERSION_2c             = 1; // real
    public const NETSNMP_DS_SNMP_VERSION_3              = 3; // real
    public const NETSNMP_DS_LIB_SECNAME                 = 0;
    public const NETSNMP_DS_LIB_CONTEXT                 = 1;
    public const NETSNMP_DS_LIB_PASSPHRASE              = 2;
    public const NETSNMP_DS_LIB_AUTHPASSPHRASE          = 3;
    public const NETSNMP_DS_LIB_PRIVPASSPHRASE          = 4;
    public const NETSNMP_DS_LIB_OPTIONALCONFIG          = 5;
    public const NETSNMP_DS_LIB_APPTYPE                 = 6;
    public const NETSNMP_DS_LIB_COMMUNITY               = 7;
    public const NETSNMP_DS_LIB_PERSISTENT_DIR          = 8;
    public const NETSNMP_DS_LIB_CONFIGURATION_DIR       = 9;
    public const NETSNMP_DS_LIB_SECMODEL                = 10;
    public const NETSNMP_DS_LIB_MIBDIRS                 = 11;
    public const NETSNMP_DS_LIB_OIDSUFFIX               = 12;
    public const NETSNMP_DS_LIB_OIDPREFIX               = 13;
    public const NETSNMP_DS_LIB_CLIENT_ADDR             = 14;
    public const NETSNMP_DS_LIB_TEMP_FILE_PATTERN       = 15;
    public const NETSNMP_DS_LIB_AUTHMASTERKEY           = 16;
    public const NETSNMP_DS_LIB_PRIVMASTERKEY           = 17;
    public const NETSNMP_DS_LIB_AUTHLOCALIZEDKEY        = 18;
    public const NETSNMP_DS_LIB_PRIVLOCALIZEDKEY        = 19;
    public const NETSNMP_DS_LIB_APPTYPES                = 20;
    public const NETSNMP_DS_LIB_KSM_KEYTAB              = 21;
    public const NETSNMP_DS_LIB_KSM_SERVICE_NAME        = 22;
    public const NETSNMP_DS_LIB_X509_CLIENT_PUB         = 23;
    public const NETSNMP_DS_LIB_X509_SERVER_PUB         = 24;
    public const NETSNMP_DS_LIB_SSHTOSNMP_SOCKET        = 25;
    public const NETSNMP_DS_LIB_CERT_EXTRA_SUBDIR       = 26;
    public const NETSNMP_DS_LIB_HOSTNAME                = 27;
    public const NETSNMP_DS_LIB_X509_CRL_FILE           = 28;
    public const NETSNMP_DS_LIB_TLS_ALGORITMS           = 29;
    public const NETSNMP_DS_LIB_TLS_LOCAL_CERT          = 30;
    public const NETSNMP_DS_LIB_TLS_PEER_CERT           = 31;
    public const NETSNMP_DS_LIB_SSH_USERNAME            = 32;
    public const NETSNMP_DS_LIB_SSH_PUBKEY              = 33;
    public const NETSNMP_DS_LIB_SSH_PRIVKEY             = 34;
    public const NETSNMP_DS_LIB_MAX_STR_ID              = 48; // match NETSNMP_DS_MAX_SUBIDS

    private function __construct()
    {
        //Resource class
    }
}
