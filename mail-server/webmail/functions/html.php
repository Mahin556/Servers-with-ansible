<?php

/**
 * html.php
 *
 * The idea is to inlcude here some functions to make easier
 * the right to left implementation by "functionize" some
 * html outputs.
 *
 * @copyright 1999-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: html.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @package squirrelmail
 * @since 1.3.0
 */

/**
 * Generate html tags
 *
 * NOTE!  If $val is non-empty, a closing tag will be added after $val
 *        Otherwise, NO closing tag is provided!
 *
 * @param string $tag Tag to output
 * @param string $val Value between tags
 * @param string $align Alignment (left, center, etc)
 * @param string $bgcolor Back color in hexadecimal
 * @param string $xtra Extra options
 * @return string HTML ready for output
 */
function html_tag( $tag,                // Tag to output
                       $val = '',           // Value between tags
                       $align = '',         // Alignment
                       $bgcolor = '',       // Back color
                       $xtra = '' ) {       // Extra options

        GLOBAL $languages, $squirrelmail_language;

        $align = strtolower( $align );
        $bgc = '';
        $tag = strtolower( $tag );

        if ( isset( $languages[$squirrelmail_language]['DIR']) ) {
            $dir = $languages[$squirrelmail_language]['DIR'];
        } else {
            $dir = 'ltr';
        }

        if ( $dir == 'ltr' ) {
            $rgt = 'right';
            $lft = 'left';
        } else {
            $rgt = 'left';
            $lft = 'right';
        }

        if ( $bgcolor <> '' ) {
            $bgc = " bgcolor=\"$bgcolor\"";
        }

        switch ( $align ) {
            case '':
                $alg = '';
                break;
            case 'right':
                $alg = " align=\"$rgt\"";
                break;
            case 'left':
                $alg = " align=\"$lft\"";
                break;
            default:
                $alg = " align=\"$align\"";
                break;
        }

        $ret = "<$tag";

        if ( $dir <> 'ltr' ) {
            $ret .= " dir=\"$dir\"";
        }
        $ret .= $bgc . $alg;

        if ( $xtra <> '' ) {
            $ret .= " $xtra";
        }

        if ( $val <> '' ) {
            $ret .= ">$val</$tag>\n";
        } else {
            $ret .= '>' . "\n";
        }

        return( $ret );
    }

/**
 * This function is used to add, modify or delete GET variables in a URL. 
 * It is especially useful when $url = $PHP_SELF
 *
 * Set $val to NULL to remove $var from $url.
 * To ensure compatibility with older versions, use $val='0' to set $var to 0. 
 *
 * @param string $url url that must be modified
 * @param string $var GET variable name
 * @param string $val variable value (CANNOT be an array)
 * @param boolean $link controls sanitizing of ampersand in urls (since 1.3.2)
 * @param boolean $treat_as_array When TRUE, if $var is an array (it occurs one
 *                                or more times with square brackets after it,
 *                                e.g. "var[1]"), the whole array will be removed
 *                                (when $val is NULL) or the given value will be
 *                                added to the next array slot (@since 1.4.23/1.5.2)
 *
 * @return string $url modified url
 *
 * @since 1.3.0
 *
 */
function set_url_var($url, $var, $val=null, $link=true, $treat_as_array=false) {
    $url = str_replace('&amp;','&',$url);

    if (strpos($url, '?') === false) {
        $url .= '?';
    }   

    list($uri, $params) = explode('?', $url, 2);
        
    $newpar = array(); 
    $params = explode('&', $params);
    $array_names = array();
   
    foreach ($params as $p) {
        if (trim($p)) {
            $p = explode('=', $p);
            $newpar[$p[0]] = (isset($p[1]) ? $p[1] : '');
            if ($treat_as_array && preg_match('/(.*)\[(\d+)]$/', $p[0], $matches)) {
               if (!isset($array_names[$matches[1]])) $array_names[$matches[1]] = array();
               $array_names[$matches[1]][$matches[2]] = $p[1];
            }
        }
    }

    if (is_null($val)) {
        if ($treat_as_array && !empty($array_names[$var])) {
            foreach ($array_names[$var] as $key => $ignore)
                unset($newpar[$var . '[' . $key . ']']);
        } else {
            unset($newpar[$var]);
        }
    } else {
        if ($treat_as_array && !empty($array_names[$var])) {
            $max_key = 0;
            foreach ($array_names[$var] as $key => $ignore)
                if ($key >= $max_key) $max_key = $key + 1;
            $newpar[$var . '[' . $max_key . ']'] = $val;
        } else {
            $newpar[$var] = $val;
        }
    }

    if (!count($newpar)) {
        return $uri;
    }
   
    $url = $uri . '?';
    foreach ($newpar as $name => $value) {
        $url .= "$name=$value&";
    }
     
    $url = substr($url, 0, -1);
    if ($link) {
        $url = str_replace('&','&amp;',$url);
    }
    
    return $url;
}

    /* Temporary test function to proces template vars with formatting.
     * I use it for viewing the message_header (view_header.php) with
     * a sort of template.
     */
    function echo_template_var($var, $format_ar = array() ) {
        $frm_last = count($format_ar) -1;

        if (isset($format_ar[0])) echo $format_ar[0];
            $i = 1;

        switch (true) {
            case (is_string($var)):
                echo $var;
                break;
            case (is_array($var)):
                $frm_a = array_slice($format_ar,1,$frm_last-1);
                foreach ($var as $a_el) {
                    if (is_array($a_el)) {
                        echo_template_var($a_el,$frm_a);
                    } else {
                        echo $a_el;
                        if (isset($format_ar[$i])) {
                            echo $format_ar[$i];
                        }
                        $i++;
                    }
                }
                break;
            default:
                break;
        }
        if (isset($format_ar[$frm_last]) && $frm_last>$i ) {
            echo $format_ar[$frm_last];
        }
    }
