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

/* -- get links in string
 *
 */
function anchory_get_links_in_str($str, $filter = ""){
	
	$links = array();
	$filter = strtoupper($filter);
	
	preg_match_all('/<a\s[^>]*href\s*=\s*(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU', $str, $links, PREG_SET_ORDER);	
 		
 	return $links;
	
}

?>