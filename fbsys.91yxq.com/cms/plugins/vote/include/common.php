<?php

define( "Error_Display", "text" );
set_magic_quotes_runtime( 0 );
set_time_limit( 20 );
$magic_quotes_gpc = get_magic_quotes_gpc( );
require_once( "config.php" );
define( "PWD_PATH", getcwd( ) );
if ( !chdir( ROOT_PATH."admin" ) )
{
	exit( "请正确设置publish/config.php中的 <b>\$ROOT_PATH = '../'; </b>" );
}
define( "SYS_PATH", "../" );
define( "INCLUDE_PATH", SYS_PATH."include/" );
define( "KTPL_DIR", INCLUDE_PATH."lib/kTemplate/" );
define( "LANG_PATH", SYS_PATH."language/" );
define( "IN_IWPC", true );
define( "CACHE_DIR", SYS_PATH."sysdata/" );
define( "KDB_DIR", INCLUDE_PATH."lib/kDB/" );
define( "SETTING_DIR", SYS_PATH."setting/" );
define( "CMSWARE_VERSION", "CMSware 2.0" );
require_once( SYS_PATH."config.php" );
require_once( INCLUDE_PATH."functions.php" );
$debugger = new debug( );
$debugger->starttimer( );
require_once( INCLUDE_PATH."data.class.php" );
require_once( KTPL_DIR."kTemplate.class.php" );
require_once( KDB_DIR."kDB.php" );
$db = new kdb( $db_config['db_driver'] );
$db->connect( $db_config );
$IN = parse_incoming( );
$iWPC = new iwpc( );
if ( !$IN[referer] )
{
	$referer = _addslashes( $HTTP_SERVER_VARS[HTTP_REFERER] );
}
else
{
	$referer = $IN[referer];
}
$TPL = new ktemplate( );
$TPL->template_dir = SYS_PATH."templates";
$TPL->compile_dir = CACHE_DIR."templates_c/";
$TPL->cache_dir = CACHE_DIR."cache/";
$TPL->assign( "referer", $referer );
$TPL->assign( "URL_SELF", "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );
$TPL->assign( "cmsware_version", CMSWARE_VERSION );
require( "../license.php" );
$license_array = $License;
unset( $License );
$SYS_ENV['CMSware_Mark'] = str_replace( "{date}", date( "Y-m-d H:i:s", time( ) ), $license_array['Publish-Marker'] );
$SYS_ENV['CMSware_Mark'] = str_replace( "{version}", CMSWARE_VERSION, $SYS_ENV['CMSware_Mark'] );
if ( !class_exists( "TplVarsAdmin" ) )
{
	require_once( INCLUDE_PATH."admin/TplVarsAdmin.class.php" );
}
$tpl_vars = tplvarsadmin::getall( );
foreach ( $tpl_vars as $key => $var )
{
	$TPL->assign( $var['VarName'], $var['VarValue'] );
}
?>
