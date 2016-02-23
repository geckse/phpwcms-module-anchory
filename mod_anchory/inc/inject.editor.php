<?php

	$BE['HEADER']['anchory_ck_editor.js'] = '<!-- Anchory CK-Editor Injection -->'.PHP_EOL.'<script src="include/inc_module/mod_anchory/inc/ckeditor_injection/anchory_cke.js"></script>';
	
	$articles = anchory_get_article_struct();
	$BE['HEADER']['anchory_ck_editor_articles.js'] = '<script type="text/javascript"> var anchory_articles = '.json_encode($articles).'; </script>';



/* -- get articles in a article-struct-form
 *	based on phpwcms-function: struct_select_list
 */	
function anchory_get_article_struct($counter=0, $struct_id=0, $prev = "") {

	global $db;
	
	$output = ($prev != "" ? $prev : "");
	$struct_id	= intval($struct_id);
	$counter	= intval($counter) + 1;
	
	if($prev == "" && $struct_id == 0){
		$sql="SELECT article_id, article_title, article_cid, article_sort FROM ".DB_PREPEND."phpwcms_article WHERE article_deleted='0' AND article_cid='0' ORDER BY article_sort ASC";
		$indexresult = _dbQuery($sql);
		foreach($indexresult as $article){
			$output .= '<option value="[LINKHREF '.$article['article_id'].']">'.$article['article_title'].' [ID:'.$article['article_id'].']</option>'."\n";
		}
			
	}		

	$sql = "SELECT acat_id,acat_name,acat_alias FROM ".DB_PREPEND."phpwcms_articlecat WHERE acat_trash=0 AND acat_struct=".$struct_id." ORDER BY acat_sort;";
	if($result = mysql_query($sql, $db)) {
		$sx=0;
		while($row = mysql_fetch_assoc($result)) {
			$struct[$sx] = $row;
			$sx++;
		}
		mysql_free_result($result);
	}
	if(isset($struct[0])) {
		foreach($struct as $key => $value) {
			
			$sql="SELECT article_id, article_title, article_cid, article_sort FROM ".DB_PREPEND."phpwcms_article WHERE article_deleted='0' AND article_cid='".$struct[$key]["acat_id"]."' ORDER BY article_sort ASC";
			$articleresult = _dbQuery($sql);
			
			foreach($articleresult as $article){
				$output .= '<option value="[LINKHREF '.$article['article_id'].']">'.str_repeat("&#8212;", $counter).' '.$article['article_title'].' [ID:'.$article['article_id'].']</option>'."\n";
			}
			$output = (anchory_get_article_struct($counter, $struct[$key]["acat_id"],$output));
		}
	}
	return $output;
}


?>
