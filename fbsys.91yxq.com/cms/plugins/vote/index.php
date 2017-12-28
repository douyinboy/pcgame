<?php

if ( !defined( "IN_CMSWARE" ) )
{
	exit( "Access Denied" );
}
require_once( PLUGIN_PATH."include/setting.class.php" );
require_once( INCLUDE_PATH."admin/site_admin.class.php" );
$site = new site_admin( );
$TPL->assign( "vote_path", $IN['plugin'] );

switch ( $action )
{
case "menu" :
	$TPL->display( "menu.html" );
	break;
case "license" :
	if ( $IN['LicenseKey'] != "" )
	{
		pluginsetting::voteupdatelicense( $IN['LicenseKey'], $IN['plugin'] );
	}
	$get_license = pluginsetting::getlicensekey( $IN['plugin'] );
	$License_vote = explode( "|", $get_license );
	$TPL->assign( "license_key", $get_license );
	$TPL->assign( "license_check", pluginsetting::license_check( $get_license ) );
	$TPL->assign( "my_domain", $_SERVER['HTTP_HOST'] );
	$TPL->assign( "start_time", date( "Y年m月d日", $License_vote['0'] ) );
	$TPL->assign( "end_time", date( "Y年m月d日", $License_vote['0'] + 86400 * $License_vote['1'] ) );
	$TPL->display( "license.html" );
	break;
case "setting" :
	if ( $_REQUEST['vot_act'] == "vote_title_add" )
	{
		pluginsetting::votetitleadd( $_REQUEST['topic_name'], $_REQUEST['choose'], $_REQUEST['sequence'], time( ), $_REQUEST['sId'], $_REQUEST['cheat'], $_REQUEST['voteTPL'], $_REQUEST['resultsTPL'] );
	}
	if ( $_REQUEST['vot_act'] == "vote_title_updata" )
	{
		pluginsetting::votetitleupdata( $_REQUEST['deal_id'], $_REQUEST['topic_name'], $_REQUEST['choose'], $_REQUEST['sequence'], time( ), $_REQUEST['sId'], $_REQUEST['cheat'], $_REQUEST['voteTPL'], $_REQUEST['resultsTPL'], $_REQUEST['temp'] );
	}
	if ( $_REQUEST['vot_act'] == "vote_title_del" )
	{
		pluginsetting::votedel( $_REQUEST['deal_id'], "title" );
	}
	$TPL->assign( "title_info", pluginsetting::getalltitleinfo( ) );
	$TPL->display( "setting.html" );
	break;
case "setting_opt" :
	if ( $_REQUEST['vot_act'] == "vote_option_add" )
	{
		pluginsetting::voteoptionadd( $_REQUEST['nclass'], $_REQUEST['sequence'], $_REQUEST['anclassid'], $_REQUEST['votenum'], time( ), $_REQUEST['sId'] );
	}
	if ( $_REQUEST['vot_act'] == "vote_option_updata" )
	{
		pluginsetting::voteoptionupdata( $_REQUEST['deal_id'], $_REQUEST['nclass'], $_REQUEST['sequence'], $_REQUEST['anclassid'], $_REQUEST['votenum'], time( ), $_REQUEST['sId'], $_REQUEST['temp'] );
	}
	if ( $_REQUEST['vot_act'] == "vote_option_del" )
	{
		pluginsetting::votedel( $_REQUEST['deal_id'], "option" );
	}
	$TPL->assign( "title_info", pluginsetting::getoptinfo( $_REQUEST['title_id'] ) );
	$TPL->display( "setting_vote_opt.html" );
	break;
}
?>
