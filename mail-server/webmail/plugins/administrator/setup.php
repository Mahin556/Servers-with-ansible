<?php
/**
 * Administrator plugin - Setup script
 *
 * Plugin allows remote administration.
 *
 * @version $Id: setup.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @author Philippe Mingo
 * @copyright (c) 1999-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package plugins
 * @subpackage administrator
 */

/** add SM_PATH */
if (!defined('SM_PATH'))  {
    define('SM_PATH','../../');
}

/** @ignore */
require_once(SM_PATH . 'plugins/administrator/auth.php');

/**
 * Init the plugin
 * @access private
 */
function squirrelmail_plugin_init_administrator() {
    global $squirrelmail_plugin_hooks;

    if ( adm_check_user() ) {        
        $squirrelmail_plugin_hooks['optpage_register_block']['administrator'] =
                                  'squirrelmail_administrator_optpage_register_block';
    }
}

/**
 * Register option block
 * @access private
 */
function squirrelmail_administrator_optpage_register_block() {
    global $optpage_blocks;

    $optpage_blocks[] = array(
        'name' => _("Administration"),
        'url'  => '../plugins/administrator/options.php',
        'desc' => _("This module allows administrators to manage SquirrelMail main configuration remotely."),
        'js'   => false
    );
}
