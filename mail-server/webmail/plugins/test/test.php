<?php

/**
 * SquirrelMail Test Plugin
 * @copyright 2006-2025 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: test.php 15030 2025-01-02 02:06:04Z pdontthink $
 * @package plugins
 * @subpackage test
 */


define('SM_PATH', '../../');
include_once(SM_PATH . 'include/validate.php');

global $color;
displayPageHeader($color, 'none');

?>

<strong>Tests:</strong>
<br />
<br />
<p><a href="decodeheader.php">decodeHeader() test</a></p>
<p><a href="ngettext.php">ngettext() test</a></p>

</body>
</html>

