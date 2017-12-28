<?php

function cms_vote( $cms_var )
{
	global $db;
	global $db_config;
	global $TPL;
	$pre_plugin_vote_title = $db_config['table_pre']."plugin_vote_title";
	$pre_plugin_vote_option = $db_config['table_pre']."plugin_vote_option";
	$sql = "\r\n\t\t\t\t\tselect t1.*,t2.topic_name,t2.choose \r\n\t\t\t\t\tfrom {$pre_plugin_vote_option} as t1,{$pre_plugin_vote_title} as t2 \r\n\t\t\t\t\twhere t1.anclassid='{$cms_var['topic_id']}' AND t1.anclassid=t2.id\r\n\t\t\t\t\torder by t1.sequence desc\r\n\t\t\t\t\t\t";
	$result = $db->execute( $sql );
	while ( !$result->EOF )
	{
		$data[] = $result->fields;
		$result->movenext( );
	}
	$sum = 0;
	$i = 0;
	for ( ;	$i < sizeof( $data );	++$i	)
	{
		$sum += $data[$i]['votenum'];
	}
	$i = 0;
	for ( ;	$i < sizeof( $data );	++$i	)
	{
		$data[$i]['rate'] = round( $data[$i]['votenum'] * 100 / $sum, 1 )."%";
	}
	$TPL->assign( "vote_topic", $data[0]['topic_name'] );
	$TPL->assign( "vote_totle", $sum );
	return $data;
}

?>
