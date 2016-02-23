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


/* --- Replacementtag: [LINKHREF $id/$alias]Text[/LINKHREF] --- */
// ----------------------------------------------------------------
$content["all"] = preg_replace_callback("/\[LINKHREF(.*?)\]/m", 'anchory_href_to', $content["all"]);

$content["all"] = preg_replace_callback("/\[LINKHREF(.*?)\](.*?)\[\/LINKHREF\]/m", 'anchory_href_to', $content["all"]);
$content["all"] = preg_replace_callback("/\[LINKHREF(.*?)\]/m", 'anchory_href_to', $content["all"]);

// ---- clean dead HREFLINKs (dead LINKHREFs, which could not rendered)
$content["all"] = preg_replace("/<a\s+(?:[^>]*?\s+)?href=\"\[LINKHREF(.*?)\]\">(.*?)<\/a>/m", "$2", $content["all"]);


/* --- Replacementtag: [LINK $id/$alias]Text[/LINK] --- */
// ----------------------------------------------------------------
$content["all"] = preg_replace_callback("/\[LINK(.*?)\](.*?)\[\/LINK\]/m", 'anchory_link_to', $content["all"]);
$content["all"] = preg_replace_callback("/\[LINK(.*?)\]/m", 'anchory_link_to', $content["all"]);


function anchory_link_to($para){
	
	if(!is_array($para)) return "";
	
	$id = 0;
	$alias = "";
	if(isset($para[2])){
		$text = $para[2];
	} else {
		$text = "";	
	}
	
	$link = $text;
	
	// clean $par 1
	$para[1] = trim(str_replace('&nbsp;', '', $para[1]));
	
	// link or alias?
	if(is_numeric(trim($para[1]))){
		$id = intval(trim($para[1]));
	} else {
		$alias = trim($para[1]);		
	}
	
	// Artikel suchen
    // Original querry: K.Heermann (flip-flop)planmatrix.de 
    $sql  = "SELECT article_id, article_cid, article_alias,  article_title, article_subtitle ";
    $sql .= "FROM ".DB_PREPEND."phpwcms_article ";
    if($id == 0){
  	  $sql .= "WHERE article_alias='".$alias."' ";
    } else {
  	  $sql .= "WHERE article_id=".$id." ";	    
    }    
    $sql .= "AND article_public=1 AND article_aktiv=1 AND article_deleted=0 ";
    $sql .= "AND (article_archive_status=1 AND article_begin<NOW() ";
    $sql .= "OR article_archive_status=0 AND article_end>NOW()) ";
    $sql .= " LIMIT 1";
    $result = _dbQuery($sql);
    
 	if(is_array($result) && isset($result[0])){
   	 	$result = $result[0];   
    }
    
    if(isset($result['article_alias'])){
		if($text == "") $text = $result['article_title'];
		$link = '<a href="index.php?'.$result['article_alias'].'" title="'.$text.'">'.$text.'</a>';    
    } else {
	    $link = $text; // article id / alias unknown? render content
	}
     
              
	return $link;
	
}

function anchory_href_to($para){

	if(!is_array($para)) return "";
	
	$id = 0;
	$alias = "";
	// clean $par 1
	$para[1] = trim(str_replace('&nbsp;', '', $para[1]));	
	// link or alias?
	if($para[1] != ""){
		if(is_numeric(trim($para[1]))){
			$id = intval(trim($para[1]));
		} else {
			$alias = trim($para[1]);		
		}
	}
	if(isset($para[2])) $para[2] = trim(str_replace('&nbsp;', '', $para[2]));
	if($id == 0 && $alias == "" && isset($para[2]) && $para[2] != ""){
		if(is_numeric(trim($para[2]))){
			$id = intval(trim($para[2]));
		} else {
			$alias = trim($para[2]);		
		}
	}

	
	// Artikel suchen
    // Original querry: K.Heermann (flip-flop)planmatrix.de 
    $sql  = "SELECT article_id, article_cid, article_alias,  article_title, article_subtitle ";
    $sql .= "FROM ".DB_PREPEND."phpwcms_article ";
    if($id == 0){
  	  $sql .= "WHERE article_alias='".$alias."' ";
    } else {
  	  $sql .= "WHERE article_id=".$id." ";	    
    }    
    $sql .= "AND article_public=1 AND article_aktiv=1 AND article_deleted=0 ";
    $sql .= "AND (article_archive_status=1 AND article_begin<NOW() ";
    $sql .= "OR article_archive_status=0 AND article_end>NOW()) ";
    $sql .= " LIMIT 1";
    $result = _dbQuery($sql);
 	
 	if(is_array($result) && isset($result[0])){
	 	 $result = $result[0];   
	 	 $link = $para[0];
	} 	 
    
    if(isset($result['article_alias'])){
		$link = 'index.php?'.$result['article_alias'];    
    } else {
	    $link = "[LINKHREF 0]"; // null link, so the next regex will clear the complete anchor element
    }
             
	return $link;
	
}


?>