<?php
// register module name
//DO NOT USE SPECIAL CHARS HERE, NO WHITE SPACES, USE LOWER CASE!!!
$_module_name 			= 'anchory';

// module type - defines where used
// 0 = BE and FE, 1 = BE only, 2 = FE only
$_module_type 			= 2;

// Set if it should be listed as content part
// has content part: true or false
$_module_contentpart	= false;

$_module_fe_render		= true;
$_module_fe_init		= true;
$_module_fe_search		= false;
$_module_fe_setting		= false;

$_module_version = "0.2";


$anchory_path = __DIR__;

include_once $anchory_path.'/inc/mod.init.php';
include_once $anchory_path.'/inc/inject.editor.php';


?>