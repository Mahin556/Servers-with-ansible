<?php

/**
 * options_identities.php
 *
 * Display Identities Options
 *
 * @copyright 1999-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: options_identities.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @package squirrelmail
 * @subpackage prefs
 * @since 1.1.3
 */

/** This is the options_identities page */
define('PAGE_NAME', 'options_identities');

/**
 * Path for SquirrelMail required files.
 * @ignore
 */
define('SM_PATH','../');

/* SquirrelMail required files. */
require_once(SM_PATH . 'include/validate.php');
include_once(SM_PATH . 'functions/global.php');
include_once(SM_PATH . 'functions/display_messages.php');
include_once(SM_PATH . 'functions/html.php');
include_once(SM_PATH . 'functions/forms.php');
include_once(SM_PATH . 'functions/identity.php');

if (!sqgetGlobalVar('identities', $identities, SQ_SESSION)) {
    $identities = get_identities();
}

/* make sure that page is not available when $edit_identity is false */
$cnt = count($identities);
if ($cnt < 2 && !$edit_identity) {
    error_box(_("Editing identities is disabled."),$color);
    die('</body></html>');
}

sqgetGlobalVar('newidentities', $newidentities, SQ_POST);
sqgetGlobalVar('smaction', $smaction, SQ_POST);
sqgetGlobalVar('return', $return, SQ_POST);

if (!sqgetGlobalVar('smtoken',$submitted_token, SQ_POST)) {
    $submitted_token = '';
}

// First lets see if there are any actions to perform //
if (!empty($smaction) && is_array($smaction)) {

    // first do a security check
    sm_validate_security_token($submitted_token, -1, TRUE);

    $doaction = '';
    $identid = 0;

    foreach($smaction as $action=>$row) {
        // we only need to extract the action and the identity we are
        // altering

        foreach($row as $iKey=>$data) {
            $identid = $iKey;
        }

        $doaction = $action;
    }

    $identities = sqfixidentities( $newidentities , $identid , $action );
    save_identities($identities);
    // save_identities() can also alter the identities, so:
    $identities = get_identities();
}

if (!empty($return)) {
    header('Location: ' . get_location() . '/options_personal.php');
    exit;
}

displayPageHeader($color, 'None');

do_hook('options_identities_top');

$td_str = '<form name="f" action="options_identities.php" method="post"><br />' . "\n"
        . addHidden('smtoken', sm_generate_security_token()) . "\n"
        . '<table border="0" cellspacing="0" cellpadding="2" width="100%">' . "\n";
$cnt = count($identities); // $identities may have changed, so we need to count again
foreach( $identities as $iKey=>$ident ) {

    if ($iKey == 0) {
        $hdr_str = _("Default Identity");
    } else {
        $hdr_str = sprintf( _("Alternate Identity %d"), $iKey);
    }

    $td_str .= ShowIdentityInfo( $hdr_str, $ident, $iKey );

}

if ($edit_identity)
    $td_str .= ShowIdentityInfo( _("Add a New Identity"), array('full_name'=>'','email_address'=>'','reply_to'=>'','signature'=>''), $cnt);
$td_str .= '</table>' . "\n";
$td_str .= '</form>';

echo '<br /> ' . "\n" .
    html_tag('table', "\n" .
        html_tag('tr', "\n" .
            html_tag('td' , "\n" .
            '<b>' . _("Options") . ' - ' . _("Advanced Identities") . '</b><br />' .
            html_tag('table', "\n" .
                html_tag('tr', "\n" .
                    html_tag('td', "\n" .
                        html_tag('table' , "\n" .
                            html_tag('tr' , "\n" .
                                html_tag('td', "\n" .  $td_str ,'','', 'style="text-align:center;"')
                            ),
                        '', '', 'width="80%" cellpadding="2" cellspacing="0" border="0"' ) ,
                    'center', $color[4])
                ),
            '', '', 'width="100%" border="0" cellpadding="1" cellspacing="1"' )) ,
        'center', $color[0]),
    'center', '', 'width="95%" border="0" cellpadding="2" cellspacing="0"' ) . '</body></html>';


function ShowIdentityInfo($title, $identity, $id ) {
    global $color, $edit_identity, $edit_name, $edit_reply_to, $cnt;

    if (empty($identity['full_name']) && empty($identity['email_address']) && empty($identity['reply_to']) && empty($identity['signature'])) {
        $bg = '';
        $empty = true;
    } else {
        $bg = ' style="background-color:' . $color[0] . ';"';
        $empty = false;
    }

    $name = 'newidentities[%d][%s]';


    $return_str = '';

    $return_str .= '<tr>' . "\n";
    $return_str .= '  <th style="text-align:center;background-color:' . $color[9] . ';" colspan="2">' . $title . '</th> '. "\n";
    $return_str .= '</tr>' . "\n";
    $return_str .= sti_input( _("Full Name") , sprintf($name, $id, 'full_name'), $identity['full_name'], $bg, ($edit_identity || ($cnt > 1 && $edit_name)));
    $return_str .= sti_input( _("E-Mail Address") , sprintf($name, $id, 'email_address'), $identity['email_address'], $bg, $edit_identity);
    // don't show reply-to AT ALL if it's not editable
    if ($edit_identity || ($cnt > 1 && $edit_reply_to))
        $return_str .= sti_input( _("Reply To"), sprintf($name, $id, 'reply_to'), $identity['reply_to'], $bg, ($edit_identity || ($cnt > 1 && $edit_reply_to)));
    $return_str .= sti_textarea( _("Signature"), sprintf($name, $id, 'signature'), $identity['signature'], $bg);
    $return_str .= concat_hook_function('options_identities_table', array($bg, $empty, $id));
    $return_str .= '<tr' . $bg . '> ' . "\n";
    $return_str .= '  <td> &nbsp; </td>' . "\n";
    $return_str .= '  <td>' . "\n";
    $return_str .= '    <input type="submit" name="smaction[save][' . $id . ']" value="' . _("Save / Update") . '" />' . "\n";

    if (!$empty && $id > 0) {
        $return_str .= '    <input type="submit" name="smaction[makedefault][' . $id . ']" value="' . _("Make Default") . '" />' . "\n";
        if ($edit_identity)
            $return_str .= '    <input type="submit" name="smaction[delete]['.$id.']" value="' . _("Delete") . '" />' . "\n";

        if ($id > 1) {
            $return_str .= '    <input type="submit" name="smaction[move]['.$id.']" value="' . _("Move Up") . '" />' . "\n";
        }

    }

    $return_str .= concat_hook_function('options_identities_buttons', array($empty, $id));
    $return_str .= '  </td>' . "\n";
    $return_str .= '</tr>' . "\n";
    $return_str .= '<tr>' . "\n";
    $return_str .= '  <td colspan="2"> &nbsp; </td>' . "\n";
    $return_str .= '</tr>';

    return $return_str;

}

function sti_input( $title, $name, $data, $bgcolor, $can_edit ) {
    $str = '';
    $str .= '<tr' . $bgcolor . ">\n";
    $str .= '  <td style="white-space: nowrap;text-align:right;">' . $title . ': </td>' . "\n";
    if ($can_edit)
        $str .= '  <td> <input type="text" name="' . $name . '" size="50" value="'. sm_encode_html_special_chars($data) . '"> </td>' . "\n";
    else
        $str .= '  <td>&nbsp;' . sm_encode_html_special_chars($data) . ' </td>' . "\n";
    $str .= '</tr>';

    return $str;

}

function sti_textarea( $title, $name, $data, $bgcolor ) {
    $str = '';
    $str .= '<tr' . $bgcolor . ">\n";
    $str .= '  <td style="white-space: nowrap;text-align:right;">' . $title . ': </td>' . "\n";
    $str .= '  <td> <textarea name="' . $name . '" cols="50" rows="5">'. "\n" . sm_encode_html_special_chars($data) . '</textarea> </td>' . "\n";
    $str .= '</tr>';

    return $str;

}

