<?php
declare(strict_types=1);

namespace NoFlash\MibParser\FFI;

/**
 * Constants as defined in net-snmp/include/net-snmp/library/snmp_api.h
 *
 * @internal
 */
final class SnmpApi
{
    public const SNMPERR_SUCCESS                      = 0;
    public const SNMPERR_GENERR                       = -1;
    public const SNMPERR_BAD_LOCPORT                  = -2;
    public const SNMPERR_BAD_ADDRESS                  = -3;
    public const SNMPERR_BAD_SESSION                  = -4;
    public const SNMPERR_TOO_LONG                     = -5;
    public const SNMPERR_NO_SOCKET                    = -6;
    public const SNMPERR_V2_IN_V1                     = -7;
    public const SNMPERR_V1_IN_V2                     = -8;
    public const SNMPERR_BAD_REPEATERS                = -9;
    public const SNMPERR_BAD_REPETITIONS              = -10;
    public const SNMPERR_BAD_ASN1_BUILD               = -11;
    public const SNMPERR_BAD_SENDTO                   = -12;
    public const SNMPERR_BAD_PARSE                    = -13;
    public const SNMPERR_BAD_VERSION                  = -14;
    public const SNMPERR_BAD_SRC_PARTY                = -15;
    public const SNMPERR_BAD_DST_PARTY                = -16;
    public const SNMPERR_BAD_CONTEXT                  = -17;
    public const SNMPERR_BAD_COMMUNITY                = -18;
    public const SNMPERR_NOAUTH_DESPRIV               = -19;
    public const SNMPERR_BAD_ACL                      = -20;
    public const SNMPERR_BAD_PARTY                    = -21;
    public const SNMPERR_ABORT                        = -22;
    public const SNMPERR_UNKNOWN_PDU                  = -23;
    public const SNMPERR_TIMEOUT                      = -24;
    public const SNMPERR_BAD_RECVFROM                 = -25;
    public const SNMPERR_BAD_ENG_ID                   = -26;
    public const SNMPERR_BAD_SEC_NAME                 = -27;
    public const SNMPERR_BAD_SEC_LEVEL                = -28;
    public const SNMPERR_ASN_PARSE_ERR                = -29;
    public const SNMPERR_UNKNOWN_SEC_MODEL            = -30;
    public const SNMPERR_INVALID_MSG                  = -31;
    public const SNMPERR_UNKNOWN_ENG_ID               = -32;
    public const SNMPERR_UNKNOWN_USER_NAME            = -33;
    public const SNMPERR_UNSUPPORTED_SEC_LEVEL        = -34;
    public const SNMPERR_AUTHENTICATION_FAILURE       = -35;
    public const SNMPERR_NOT_IN_TIME_WINDOW           = -36;
    public const SNMPERR_DECRYPTION_ERR               = -37;
    public const SNMPERR_SC_GENERAL_FAILURE           = -38;
    public const SNMPERR_SC_NOT_CONFIGURED            = -39;
    public const SNMPERR_KT_NOT_AVAILABLE             = -40;
    public const SNMPERR_UNKNOWN_REPORT               = -41;
    public const SNMPERR_USM_GENERICERROR             = -42;
    public const SNMPERR_USM_UNKNOWNSECURITYNAME      = -43;
    public const SNMPERR_USM_UNSUPPORTEDSECURITYLEVEL = -44;
    public const SNMPERR_USM_ENCRYPTIONERROR          = -45;
    public const SNMPERR_USM_AUTHENTICATIONFAILURE    = -46;
    public const SNMPERR_USM_PARSEERROR               = -47;
    public const SNMPERR_USM_UNKNOWNENGINEID          = -48;
    public const SNMPERR_USM_NOTINTIMEWINDOW          = -49;
    public const SNMPERR_USM_DECRYPTIONERROR          = -50;
    public const SNMPERR_NOMIB                        = -51;
    public const SNMPERR_RANGE                        = -52;
    public const SNMPERR_MAX_SUBID                    = -53;
    public const SNMPERR_BAD_SUBID                    = -54;
    public const SNMPERR_LONG_OID                     = -55;
    public const SNMPERR_BAD_NAME                     = -56;
    public const SNMPERR_VALUE                        = -57;
    public const SNMPERR_UNKNOWN_OBJID                = -58;
    public const SNMPERR_NULL_PDU                     = -59;
    public const SNMPERR_NO_VARS                      = -60;
    public const SNMPERR_VAR_TYPE                     = -61;
    public const SNMPERR_MALLOC                       = -62;
    public const SNMPERR_KRB5                         = -63;
    public const SNMPERR_PROTOCOL                     = -64;
    public const SNMPERR_OID_NONINCREASING            = -65;
    public const SNMPERR_JUST_A_CONTEXT_PROBE         = -66;
    public const SNMPERR_TRANSPORT_NO_CONFIG          = -67;
    public const SNMPERR_TRANSPORT_CONFIG_ERROR       = -68;
    public const SNMPERR_TLS_NO_CERTIFICATE           = -69;
    public const SNMPERR_MAX                          = -69;

    public const SNMPERR_NUM_TO_TEXT = [
        self::SNMPERR_SUCCESS => 'SNMPERR_SUCCESS',
        self::SNMPERR_GENERR => 'SNMPERR_GENERR',
        self::SNMPERR_BAD_LOCPORT => 'SNMPERR_BAD_LOCPORT',
        self::SNMPERR_BAD_ADDRESS => 'SNMPERR_BAD_ADDRESS',
        self::SNMPERR_BAD_SESSION => 'SNMPERR_BAD_SESSION',
        self::SNMPERR_TOO_LONG => 'SNMPERR_TOO_LONG',
        self::SNMPERR_NO_SOCKET => 'SNMPERR_NO_SOCKET',
        self::SNMPERR_V2_IN_V1 => 'SNMPERR_V2_IN_V1',
        self::SNMPERR_V1_IN_V2 => 'SNMPERR_V1_IN_V2',
        self::SNMPERR_BAD_REPEATERS => 'SNMPERR_BAD_REPEATERS',
        self::SNMPERR_BAD_REPETITIONS => 'SNMPERR_BAD_REPETITIONS',
        self::SNMPERR_BAD_ASN1_BUILD => 'SNMPERR_BAD_ASN1_BUILD',
        self::SNMPERR_BAD_SENDTO => 'SNMPERR_BAD_SENDTO',
        self::SNMPERR_BAD_PARSE => 'SNMPERR_BAD_PARSE',
        self::SNMPERR_BAD_VERSION => 'SNMPERR_BAD_VERSION',
        self::SNMPERR_BAD_SRC_PARTY => 'SNMPERR_BAD_SRC_PARTY',
        self::SNMPERR_BAD_DST_PARTY => 'SNMPERR_BAD_DST_PARTY',
        self::SNMPERR_BAD_CONTEXT => 'SNMPERR_BAD_CONTEXT',
        self::SNMPERR_BAD_COMMUNITY => 'SNMPERR_BAD_COMMUNITY',
        self::SNMPERR_NOAUTH_DESPRIV => 'SNMPERR_NOAUTH_DESPRIV',
        self::SNMPERR_BAD_ACL => 'SNMPERR_BAD_ACL',
        self::SNMPERR_BAD_PARTY => 'SNMPERR_BAD_PARTY',
        self::SNMPERR_ABORT => 'SNMPERR_ABORT',
        self::SNMPERR_UNKNOWN_PDU => 'SNMPERR_UNKNOWN_PDU',
        self::SNMPERR_TIMEOUT => 'SNMPERR_TIMEOUT',
        self::SNMPERR_BAD_RECVFROM => 'SNMPERR_BAD_RECVFROM',
        self::SNMPERR_BAD_ENG_ID => 'SNMPERR_BAD_ENG_ID',
        self::SNMPERR_BAD_SEC_NAME => 'SNMPERR_BAD_SEC_NAME',
        self::SNMPERR_BAD_SEC_LEVEL => 'SNMPERR_BAD_SEC_LEVEL',
        self::SNMPERR_ASN_PARSE_ERR => 'SNMPERR_ASN_PARSE_ERR',
        self::SNMPERR_UNKNOWN_SEC_MODEL => 'SNMPERR_UNKNOWN_SEC_MODEL',
        self::SNMPERR_INVALID_MSG => 'SNMPERR_INVALID_MSG',
        self::SNMPERR_UNKNOWN_ENG_ID => 'SNMPERR_UNKNOWN_ENG_ID',
        self::SNMPERR_UNKNOWN_USER_NAME => 'SNMPERR_UNKNOWN_USER_NAME',
        self::SNMPERR_UNSUPPORTED_SEC_LEVEL => 'SNMPERR_UNSUPPORTED_SEC_LEVEL',
        self::SNMPERR_AUTHENTICATION_FAILURE => 'SNMPERR_AUTHENTICATION_FAILURE',
        self::SNMPERR_NOT_IN_TIME_WINDOW => 'SNMPERR_NOT_IN_TIME_WINDOW',
        self::SNMPERR_DECRYPTION_ERR => 'SNMPERR_DECRYPTION_ERR',
        self::SNMPERR_SC_GENERAL_FAILURE => 'SNMPERR_SC_GENERAL_FAILURE',
        self::SNMPERR_SC_NOT_CONFIGURED => 'SNMPERR_SC_NOT_CONFIGURED',
        self::SNMPERR_KT_NOT_AVAILABLE => 'SNMPERR_KT_NOT_AVAILABLE',
        self::SNMPERR_UNKNOWN_REPORT => 'SNMPERR_UNKNOWN_REPORT',
        self::SNMPERR_USM_GENERICERROR => 'SNMPERR_USM_GENERICERROR',
        self::SNMPERR_USM_UNKNOWNSECURITYNAME => 'SNMPERR_USM_UNKNOWNSECURITYNAME',
        self::SNMPERR_USM_UNSUPPORTEDSECURITYLEVEL => 'SNMPERR_USM_UNSUPPORTEDSECURITYLEVEL',
        self::SNMPERR_USM_ENCRYPTIONERROR => 'SNMPERR_USM_ENCRYPTIONERROR',
        self::SNMPERR_USM_AUTHENTICATIONFAILURE => 'SNMPERR_USM_AUTHENTICATIONFAILURE',
        self::SNMPERR_USM_PARSEERROR => 'SNMPERR_USM_PARSEERROR',
        self::SNMPERR_USM_UNKNOWNENGINEID => 'SNMPERR_USM_UNKNOWNENGINEID',
        self::SNMPERR_USM_NOTINTIMEWINDOW => 'SNMPERR_USM_NOTINTIMEWINDOW',
        self::SNMPERR_USM_DECRYPTIONERROR => 'SNMPERR_USM_DECRYPTIONERROR',
        self::SNMPERR_NOMIB => 'SNMPERR_NOMIB',
        self::SNMPERR_RANGE => 'SNMPERR_RANGE',
        self::SNMPERR_MAX_SUBID => 'SNMPERR_MAX_SUBID',
        self::SNMPERR_BAD_SUBID => 'SNMPERR_BAD_SUBID',
        self::SNMPERR_LONG_OID => 'SNMPERR_LONG_OID',
        self::SNMPERR_BAD_NAME => 'SNMPERR_BAD_NAME',
        self::SNMPERR_VALUE => 'SNMPERR_VALUE',
        self::SNMPERR_UNKNOWN_OBJID => 'SNMPERR_UNKNOWN_OBJID',
        self::SNMPERR_NULL_PDU => 'SNMPERR_NULL_PDU',
        self::SNMPERR_NO_VARS => 'SNMPERR_NO_VARS',
        self::SNMPERR_VAR_TYPE => 'SNMPERR_VAR_TYPE',
        self::SNMPERR_MALLOC => 'SNMPERR_MALLOC',
        self::SNMPERR_KRB5 => 'SNMPERR_KRB5',
        self::SNMPERR_PROTOCOL => 'SNMPERR_PROTOCOL',
        self::SNMPERR_OID_NONINCREASING => 'SNMPERR_OID_NONINCREASING',
        self::SNMPERR_JUST_A_CONTEXT_PROBE => 'SNMPERR_JUST_A_CONTEXT_PROBE',
        self::SNMPERR_TRANSPORT_NO_CONFIG => 'SNMPERR_TRANSPORT_NO_CONFIG',
        self::SNMPERR_TRANSPORT_CONFIG_ERROR => 'SNMPERR_TRANSPORT_CONFIG_ERROR',
        self::SNMPERR_TLS_NO_CERTIFICATE => 'SNMPERR_TLS_NO_CERTIFICATE',
        self::SNMPERR_MAX => 'SNMPERR_MAX',
    ];

    private function __construct()
    {
        //Resource class
    }
}
