<?php

class pluginsetting extends idata
{

	function getlicensekey( $plugin_Path )
	{
		global $db;
		global $table;
		$result = $db->getrow( "SELECT LicenseKey FROM {$table->plugins} where  Path='{$plugin_Path}'" );
		return $result['LicenseKey'];
	}

	function voteupdatelicense( $LicenseKey, $plugin_Path )
	{
		global $db;
		global $table;
		$result = $db->query( "UPdATE {$table->plugins} set LicenseKey='{$LicenseKey}' WHERE Path='{$plugin_Path}'" );
		return $result;
	}

	function license_check( $License )
	{
		$License_vote = explode( "|", $License );
		$msg = 1;
		if ( base64_encode( md5( $_SERVER['HTTP_HOST']."|".$License_vote['1']."|".$License_vote['0'] ) ) != $License_vote['2'] )
		{
			$msg = 2;
		}
		else if ( $License_vote['0'] + 86400 * $License_vote['1'] < time( ) && $License_vote['1'] )
		{
			$msg = 3;
		}
		return $msg;
	}

	function getalltitleinfo( )
	{
		global $plugin_table;
		global $db;
		global $table;
		$sql = "select * from {$plugin_table['vote']['title']} order by sequence desc";
		$result = $db->execute( $sql );
		while ( !$result->EOF )
		{
			$data[] = $result->fields;
			$result->movenext( );
		}
		return $data;
	}

	function getoptinfo( $title_id )
	{
		global $plugin_table;
		global $db;
		global $table;
		$sql = "\r\n\t\t\t\t\tselect t1.*,t2.topic_name \r\n\t\t\t\t\tfrom {$plugin_table['vote']['option']} as t1,{$plugin_table['vote']['title']} as t2 \r\n\t\t\t\t\twhere t1.anclassid='{$title_id}' AND t1.anclassid=t2.id\r\n\t\t\t\t\torder by t1.sequence desc\r\n\t\t\t\t\t\t";
		$result = $db->execute( $sql );
		while ( !$result->EOF )
		{
			$data[] = $result->fields;
			$result->movenext( );
		}
		return $data;
	}

	function votetitleadd( $topic_name, $choose, $sequence, $createdate, $sId, $cheat, $voteTPL, $resultsTPL )
	{
		global $plugin_table;
		global $db;
		global $table;
		$result = $db->getrow( "SELECT sUserName FROM {$table->admin_sessions} where  sId='{$sId}'" );
		$createid = $result['sUserName'];
		$sql = "\r\n\t\tinsert into {$plugin_table['vote']['title']} (topic_name,choose,sequence,createdate,createid,cheat,voteTPL,resultsTPL) \r\n\t\tvalues ('{$topic_name}','{$choose}','{$sequence}','{$createdate}','{$createid}','{$cheat}','{$voteTPL}','{$resultsTPL}')\r\n\t\t\t";
		$result = $db->query( $sql );
		$msg_vote = $result ? "添加成功" : "添加失败";
		echo "<script> alert(' {$topic_name} {$msg_vote} ！'); </script>";
	}

	function votetitleupdata( $setid, $topic_name, $choose, $sequence, $editdate, $sId, $cheat, $voteTPL, $resultsTPL, $temp )
	{
		global $plugin_table;
		global $db;
		global $table;
		$result = $db->getrow( "SELECT sUserName FROM {$table->admin_sessions} where  sId='{$sId}'" );
		$editid = $result['sUserName'];
		$i = 0;
		for ( ;	$i < sizeof( $setid );	++$i	)
		{
			$flag = $temp[$setid[$i]];
			$sql = "\r\n\t\tupdate {$plugin_table['vote']['title']} \r\n\t\tset topic_name='{$topic_name[$flag]}',choose='{$choose[$flag]}',sequence='{$sequence[$flag]}',editdate='{$editdate}',editid='{$editid}',cheat='{$cheat[$flag]}',voteTPL='{$voteTPL[$flag]}',resultsTPL='{$resultsTPL[$flag]}'  \r\n\t\twhere id='{$setid[$i]}'\r\n\t\t\t";
			$result = $db->query( $sql );
		}
	}

	function voteoptionadd( $nclass, $sequence, $anclassid, $votenum, $createdate, $sId )
	{
		global $plugin_table;
		global $db;
		global $table;
		$result = $db->getrow( "SELECT sUserName FROM {$table->admin_sessions} where  sId='{$sId}'" );
		$createid = $result['sUserName'];
		$sql = "\r\n\t\tinsert into {$plugin_table['vote']['option']} (nclass,sequence,votenum,anclassid,createdate,createid) \r\n\t\tvalues ('{$nclass}','{$sequence}','{$votenum}','{$anclassid}','{$createdate}','{$createid}')\r\n\t\t\t";
		$result = $db->query( $sql );
		$msg_vote = $result ? "添加成功" : "添加失败";
		echo "<script> alert(' {$nclass} {$msg_vote} ！'); </script>";
	}

	function voteoptionupdata( $setid, $nclass, $sequence, $anclassid, $votenum, $editdate, $sId, $temp )
	{
		global $plugin_table;
		global $db;
		global $table;
		$result = $db->getrow( "SELECT sUserName FROM {$table->admin_sessions} where  sId='{$sId}'" );
		$editid = $result['sUserName'];
		$i = 0;
		for ( ;	$i < sizeof( $setid );	++$i	)
		{
			$flag = $temp[$setid[$i]];
			$sql = "\r\n\t\tupdate {$plugin_table['vote']['option']} \r\n\t\tset nclass='{$nclass[$flag]}',sequence='{$sequence[$flag]}',anclassid='{$anclassid[$flag]}',votenum='{$votenum[$flag]}',editid='{$editid}',editdate='{$editdate}' \r\n\t\twhere id='{$setid[$i]}'\r\n\t\t\t";
			$result = $db->query( $sql );
		}
	}

	function votedel( $delid, $vot_table )
	{
		global $plugin_table;
		global $db;
		global $table;
		if ( $vot_table == "title" )
		{
			$vot_table = $plugin_table['vote']['title'];
		}
		else
		{
			$vot_table = $plugin_table['vote']['option'];
		}
		$i = 0;
		for ( ;	$i < sizeof( $delid );	++$i	)
		{
			$result = $db->query( "delete from {$vot_table} where id={$delid[$i]}" );
		}
		return $result;
	}

}

?>
