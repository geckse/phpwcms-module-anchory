<?php
/**
 * phpwcms content management system
 * plugin anchory
 * 
 * @author Marcel Claus <m.claus@q23.de>
 * @copyright Copyright (c)
 * @link http://www.geckse.de
 *
 **/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------

$anchory_path = __DIR__;

include_once $anchory_path.'/inc/mod.init.php';

/* --- Scan links in all Contentparts
 *
 */	
function anchory_cp_trigger($text, & $data) {
 	$links = array();
 	$links = anchory_get_links_in_str($text);
 	 	
   return $text;
}

// register cp_trigger - currently unused
//register_cp_trigger('anchory_cp_trigger','LAST');


?>