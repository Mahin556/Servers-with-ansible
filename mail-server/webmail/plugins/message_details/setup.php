<?php

/**
 * Message Details plugin - main setup script
 *
 * Plugin to view the RFC822 raw message output and the bodystructure of a message
 *
 * @author Marc Groot Koerkamp
 * @copyright 2002 Marc Groot Koerkamp, The Netherlands
 * @copyright 2002-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: setup.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @package plugins
 * @subpackage message_details
 **/

/**
 * Initialize the plugin
 * @access private
 */
function squirrelmail_plugin_init_message_details()
{
  global $squirrelmail_plugin_hooks;

  $squirrelmail_plugin_hooks['read_body_header_right']['message_details'] = 'show_message_details';
}

/**
 * Add message details link in message view
 * @access private
 */
function show_message_details() {
    global $passed_id, $mailbox, $passed_ent_id, $color,
           $javascript_on;

    if (strlen(trim($mailbox)) < 1) {
        $mailbox = 'INBOX';
    }

    $params = '?passed_ent_id=' . $passed_ent_id .
              '&mailbox=' . urlencode($mailbox) .
              '&passed_id=' . $passed_id;

    $print_text = _("View Message Details");

    $result = '';
    /* Output the link. */
    if ($javascript_on) {
        $result = '<script type="text/javascript" language="javascript">' . "\n" .
                '<!--' . "\n" .
                "  function MessageSource() {\n" .
                '    window.open("../plugins/message_details/message_details_main.php' .
                        $params . '","MessageDetails","width=800,height=600");' . "\n".
                "  }\n" .
                "// -->\n" .
                "</script>" .
                "&nbsp;| <a href=\"javascript:MessageSource();\" style=\"white-space: nowrap;\">$print_text</a>";
    }
    echo $result;
}

