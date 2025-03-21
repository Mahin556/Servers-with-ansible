<?php

/**
  * SquirrelMail Test Plugin
  * @copyright 2006-2025 The SquirrelMail Project Team
  * @license http://opensource.org/licenses/gpl-license.php GNU Public License
  * @version $Id: functions.php 15030 2025-01-02 02:06:04Z pdontthink $
  * @package plugins
  * @subpackage test
  */

/**
  * Add link to menu at top of content pane
  *
  * @return void
  *
  */
function test_menuline_do() {

    displayInternalLink('plugins/test/test.php', 'Test', 'right');
    echo "&nbsp;&nbsp;\n";

}


