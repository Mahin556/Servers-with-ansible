<?php
/**
 * lang_setup.mod
 * ---------------
 * Squirrelspell module
 *
 * Copyright (c) 1999-2025 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This module displays available dictionaries to the user and lets
 * him/her choose which ones s/he wants to check messages with.
 *
 * @author Konstantin Riabitsev <icon@duke.edu>
 * @version $Id: lang_setup.mod 15030 2025-01-02 02:06:04Z pdontthink $
 * @package plugins
 * @subpackage squirrelspell
 */

global $SQSPELL_APP, $squirrelmail_language;

// this is a hack to avoid having to change the strings
// in all our translations for this misspelled word
if (strpos($squirrelmail_language, 'en_') === 0)
    $msg = '<p>Please check any available international dictionaries which you would like to use when spell checking:';
else
    $msg = '<p>' . _("Please check any available international dictionaries which you would like to use when spellchecking:");
$msg .= '</p>'
  . '<form method="post">'
  . '<input type="hidden" name="MOD" value="lang_change" />'
  . '<input type="hidden" name="smtoken" value="' . sm_generate_security_token() . '" />'
  . '<blockquote><p>';
/**
 * Present a nice listing.
 */
$langs = sqspell_getSettings(null);
$add = '<p>'
  . _("Make this dictionary my default selection:")
  . " <select name=\"lang_default\">\n";
foreach ($SQSPELL_APP as $avail_lang => $ignore){
  $msg .= "<input type=\"checkbox\" name=\"use_langs[]\" "
    . "value=\"$avail_lang\"";
  if (in_array($avail_lang, $langs)) {
    $msg .= ' checked="checked"';
  }
  $msg .= ' /> ' . _($avail_lang) . "<br />\n";
  $add .= "<option";
  if ($avail_lang==$langs[0]) {
    $add .= ' selected="selected"';
  }
  $add .= " value=\"$avail_lang\" >" . _($avail_lang) . "</option>\n";
}
$msg .= "</p>\n" . $add . "</select>\n";
$msg .= "</p></blockquote><p><input type=\"submit\" value=\" "
  . _("Make these changes") . " \" /></p></form>";
sqspell_makePage(_("Add International Dictionaries"), null, $msg);

/**
 * For Emacs weenies:
 * Local variables:
 * mode: php
 * End:
 * vim: syntax=php
 */

