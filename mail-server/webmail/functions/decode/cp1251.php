<?php

/**
 * decode/cp1251.php
 *
 * This file contains cp1251 decoding function that is needed to read
 * cp1251 encoded mails in non-cp1251 locale.
 *
 * Original data taken from:
 *  ftp://ftp.unicode.org/Public/MAPPINGS/VENDORS/MICSFT/WINDOWS/CP1250.TXT
 *
 *   Name:     cp1251 to Unicode table
 *   Unicode version: 2.0
 *   Table version: 2.01
 *   Table format:  Format A
 *   Date:          04/15/98
 *   Contact:       cpxlate@microsoft.com
 *
 * @copyright 2003-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: cp1251.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @package squirrelmail
 * @subpackage decode
 */

/**
 * Decode cp1251-encoded string
 * @param string $string Encoded string
 * @return string $string Decoded string
 */
function charset_decode_cp1251 ($string) {
    // don't do decoding when there are no 8bit symbols
    if (! sq_is8bit($string,'windows-1251'))
        return $string;

    $cp1251 = array(
        "\x80" => '&#1026;',
        "\x81" => '&#1027;',
        "\x82" => '&#8218;',
        "\x83" => '&#1107;',
        "\x84" => '&#8222;',
        "\x85" => '&#8230;',
        "\x86" => '&#8224;',
        "\x87" => '&#8225;',
        "\x88" => '&#8364;',
        "\x89" => '&#8240;',
        "\x8A" => '&#1033;',
        "\x8B" => '&#8249;',
        "\x8C" => '&#1034;',
        "\x8D" => '&#1036;',
        "\x8E" => '&#1035;',
        "\x8F" => '&#1039;',
        "\x90" => '&#1106;',
        "\x91" => '&#8216;',
        "\x92" => '&#8217;',
        "\x93" => '&#8220;',
        "\x94" => '&#8221;',
        "\x95" => '&#8226;',
        "\x96" => '&#8211;',
        "\x97" => '&#8212;',
        "\x98" => '&#65533;',
        "\x99" => '&#8482;',
        "\x9A" => '&#1113;',
        "\x9B" => '&#8250;',
        "\x9C" => '&#1114;',
        "\x9D" => '&#1116;',
        "\x9E" => '&#1115;',
        "\x9F" => '&#1119;',
        "\xA0" => '&#160;',
        "\xA1" => '&#1038;',
        "\xA2" => '&#1118;',
        "\xA3" => '&#1032;',
        "\xA4" => '&#164;',
        "\xA5" => '&#1168;',
        "\xA6" => '&#166;',
        "\xA7" => '&#167;',
        "\xA8" => '&#1025;',
        "\xA9" => '&#169;',
        "\xAA" => '&#1028;',
        "\xAB" => '&#171;',
        "\xAC" => '&#172;',
        "\xAD" => '&#173;',
        "\xAE" => '&#174;',
        "\xAF" => '&#1031;',
        "\xB0" => '&#176;',
        "\xB1" => '&#177;',
        "\xB2" => '&#1030;',
        "\xB3" => '&#1110;',
        "\xB4" => '&#1169;',
        "\xB5" => '&#181;',
        "\xB6" => '&#182;',
        "\xB7" => '&#183;',
        "\xB8" => '&#1105;',
        "\xB9" => '&#8470;',
        "\xBA" => '&#1108;',
        "\xBB" => '&#187;',
        "\xBC" => '&#1112;',
        "\xBD" => '&#1029;',
        "\xBE" => '&#1109;',
        "\xBF" => '&#1111;',
        "\xC0" => '&#1040;',
        "\xC1" => '&#1041;',
        "\xC2" => '&#1042;',
        "\xC3" => '&#1043;',
        "\xC4" => '&#1044;',
        "\xC5" => '&#1045;',
        "\xC6" => '&#1046;',
        "\xC7" => '&#1047;',
        "\xC8" => '&#1048;',
        "\xC9" => '&#1049;',
        "\xCA" => '&#1050;',
        "\xCB" => '&#1051;',
        "\xCC" => '&#1052;',
        "\xCD" => '&#1053;',
        "\xCE" => '&#1054;',
        "\xCF" => '&#1055;',
        "\xD0" => '&#1056;',
        "\xD1" => '&#1057;',
        "\xD2" => '&#1058;',
        "\xD3" => '&#1059;',
        "\xD4" => '&#1060;',
        "\xD5" => '&#1061;',
        "\xD6" => '&#1062;',
        "\xD7" => '&#1063;',
        "\xD8" => '&#1064;',
        "\xD9" => '&#1065;',
        "\xDA" => '&#1066;',
        "\xDB" => '&#1067;',
        "\xDC" => '&#1068;',
        "\xDD" => '&#1069;',
        "\xDE" => '&#1070;',
        "\xDF" => '&#1071;',
        "\xE0" => '&#1072;',
        "\xE1" => '&#1073;',
        "\xE2" => '&#1074;',
        "\xE3" => '&#1075;',
        "\xE4" => '&#1076;',
        "\xE5" => '&#1077;',
        "\xE6" => '&#1078;',
        "\xE7" => '&#1079;',
        "\xE8" => '&#1080;',
        "\xE9" => '&#1081;',
        "\xEA" => '&#1082;',
        "\xEB" => '&#1083;',
        "\xEC" => '&#1084;',
        "\xED" => '&#1085;',
        "\xEE" => '&#1086;',
        "\xEF" => '&#1087;',
        "\xF0" => '&#1088;',
        "\xF1" => '&#1089;',
        "\xF2" => '&#1090;',
        "\xF3" => '&#1091;',
        "\xF4" => '&#1092;',
        "\xF5" => '&#1093;',
        "\xF6" => '&#1094;',
        "\xF7" => '&#1095;',
        "\xF8" => '&#1096;',
        "\xF9" => '&#1097;',
        "\xFA" => '&#1098;',
        "\xFB" => '&#1099;',
        "\xFC" => '&#1100;',
        "\xFD" => '&#1101;',
        "\xFE" => '&#1102;',
        "\xFF" => '&#1103;'
    );

    $string = str_replace(array_keys($cp1251), array_values($cp1251), $string);

    return $string;
}

