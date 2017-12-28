<?php

define( "SYS_PATH", ROOT_PATH );
require( SYS_PATH."plugins/".$Vote_plugin_name."/plugin.config.php" );
require( SYS_PATH."include/cms.class.php" );
require( SYS_PATH."include/cms.func.php" );
if ( file_exists( SYS_PATH."setting/cms.ini.php" ) )
{
	include_once( SYS_PATH."setting/cms.ini.php" );
}
if ( !function_exists( "CMS_VOTE" ) )
{
	include_once( SYS_PATH."plugins/".$Vote_plugin_name."/include/function_ext.php" );
}
$TPL->registerprefilter( "CMS_Parser" );
if ( !( $TPL_address = $db->getrow( "SELECT cheat,voteTPL,resultsTPL FROM {$plugin_table['vote']['title']} where  id='{$_REQUEST['id']}'" ) ) )
{
	echo "该ID不存在！！";
	exit( );
}
else
{
	if ( !file_exists( $TPL->template_dir.$TPL_address['resultsTPL'] ) || !file_exists( $TPL->template_dir.$TPL_address['voteTPL'] ) || $TPL_address['resultsTPL'] == "" || $TPL_address['voteTPL'] == "" )
	{
		echo "请先到投票插件中设置好该ID的模板路径！";
		exit( );
	}
}
$TPL->assign( "id", $_REQUEST['id'] );
switch ( $_GET['act'] )
{
case "results" :
	if ( array_key_exists( "vote_id", $_POST ) )
	{
		if ( $db->getrow( "SELECT * FROM {$plugin_table['vote']['ipaddress']} where  vote_ip='{$_SERVER['REMOTE_ADDR']}' and topic_id='{$_REQUEST['id']}' and vote_time>'".( time( ) - 3600 * $TPL_address['cheat'] )."'" ) )
		{
			echo "<script> alert(' 你已经投过票了，这次投票无效 ！'); </script>";
		}
		else
		{
			$i = 0;
			for ( ;	$i < sizeof( $_POST['vote_id'] );	++$i	)
			{
				$result = $db->query( "UPDATE `{$plugin_table['vote']['option']}` SET `votenum` = votenum+1 WHERE `id` = '{$_POST['vote_id'][$i]}' " );
			}
			$db->query( "INSERT into {$plugin_table['vote']['ipaddress']} (vote_ip,vote_time,topic_id) values ('{$_SERVER['REMOTE_ADDR']}','".time( )."','{$_REQUEST['id']}')" );
			$db->query( ( "delete from {$plugin_table['vote']['ipaddress']} where vote_time<'".( time( ) - 604800 ) )."' " );
		}
	}
	$TPL->display( $TPL_address['resultsTPL'] );
	break;
default :
	$TPL->display( $TPL_address['voteTPL'] );
}
?>
