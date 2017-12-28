<?php
require_once( "common.php" );
if ( empty( $IN['NodeID'] ) )
{
				shutdown( "NodeID empty" );
}
$NodeID = $IN['NodeID'];
$NodeInfo = $iWPC->loadNodeInfo( $NodeID );
if ( !$NodeInfo )
{
				shutdown( "InValid NodeID , can not find it " );
}
switch ( $IN['o'] )
{
case "add_submit" :
				if ( in_array( basename( __FILE__ ), $EnableAccessInterceptorOAS ) )
				{
								if ( !$Access->canAccess( $NodeID, "WriteContent" ) )
								{
												$TPL->assign( "deny_code", $Access->deny_code );
												$TPL->display( $OAS_SETTING['AccessDenyTpl'] );
												exit( );
								}
				}
				require_once( INCLUDE_PATH."admin/publishAdmin.class.php" );
				require_once( INCLUDE_PATH."admin/content_table_admin.class.php" );
				require_once( INCLUDE_PATH."admin/tplAdmin.class.php" );
				require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
				require_once( INCLUDE_PATH."admin/site_admin.class.php" );
				require_once( INCLUDE_PATH."cms.class.php" );
				require_once( INCLUDE_PATH."cms.func.php" );
				require_once( SETTING_DIR."cms.ini.php" );
				require_once( INCLUDE_PATH."encoding/encoding.inc.php" );
				require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
				require_once( INCLUDE_PATH."admin/plugin.class.php" );
				require_once( INCLUDE_PATH."admin/task.class.php" );
				require_once( INCLUDE_PATH."image.class.php" );
				require_once( INCLUDE_PATH."admin/extra_publish_admin.class.php" );
				$time = time( );
				$Plugin = new Plugin( );
				$publish = new publishAdmin( );
				$site = new site_admin( );
				$publish->flushData( );
				foreach ( $CONTENT_MODEL_INFO[$NodeInfo['TableID']]['Model'] as $var )
				{
								$publish->addData( $var['FieldName'], $IN[$var['FieldName']] );
				}
				if ( $NodeInfo['NodeClassMark'] == "bbs" )
				{
								$publish->addData( "LastPoster", $UserSession['UserName'] );
								$publish->addData( "LastPostTime", $time );
				}
				$publish->addData( "CreationDate", $time );
				$publish->addData( "ModifiedDate", $time );
				$publish->addData( "CreationUserID", $UserSession['UserID'] );
				$publish->addData( "LastModifiedUserID", $UserSession['UserID'] );
				$IndexInfo = array(
								"PublishDate" => $time
				);
				if ( $publish->contentAdd( $NodeID, $IndexInfo ) )
				{
								refreshsite( );
								redirect( "post success!" );
				}
				else
				{
								redirect( "post failed!" );
				}
				break;
case "edit_submit" :
				$IndexID = intval( $IN['IndexID'] );
				require_once( LIB_PATH."SqlMap.class.php" );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "IndexID", $IndexID );
				$table_content = $db_config['table_pre'].$db_config['table_content_pre']."_".$NodeInfo[TableID];
				$sqlMap->addData( "table_content", $table_content );
				$IndexInfo = $sqlMap->queryForObject( "getContentInfo" );
				if ( $IndexInfo['CreationUserID'] != $UserSession['UserID'] )
				{
								redirect( "Access Denid! You are not the Author of IndexID=[{$IN['IndexID']}]." );
				}
				$NodeID = $IndexInfo['NodeID'];
				if ( in_array( basename( __FILE__ ), $EnableAccessInterceptorOAS ) )
				{
								if ( !$Access->canAccess( $NodeID, "WriteContent" ) )
								{
												$TPL->assign( "deny_code", $Access->deny_code );
												$TPL->display( $OAS_SETTING['AccessDenyTpl'] );
												exit( );
								}
				}
				require_once( INCLUDE_PATH."admin/publishAdmin.class.php" );
				require_once( INCLUDE_PATH."admin/content_table_admin.class.php" );
				require_once( INCLUDE_PATH."admin/tplAdmin.class.php" );
				require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
				require_once( INCLUDE_PATH."admin/site_admin.class.php" );
				require_once( INCLUDE_PATH."cms.class.php" );
				require_once( INCLUDE_PATH."cms.func.php" );
				require_once( SETTING_DIR."cms.ini.php" );
				require_once( INCLUDE_PATH."encoding/encoding.inc.php" );
				require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
				require_once( INCLUDE_PATH."admin/plugin.class.php" );
				require_once( INCLUDE_PATH."admin/task.class.php" );
				require_once( INCLUDE_PATH."image.class.php" );
				require_once( INCLUDE_PATH."admin/extra_publish_admin.class.php" );
				$time = time( );
				$Plugin = new Plugin( );
				$publish = new publishAdmin( );
				$site = new site_admin( );
				$publish->flushData( );
				foreach ( $CONTENT_MODEL_INFO[$NodeInfo['TableID']]['Model'] as $var )
				{
								$publish->addData( $var['FieldName'], $IN[$var['FieldName']] );
				}
				$publish->addData( "ModifiedDate", $time );
				$publish->addData( "LastModifiedUserID", $UserSession['UserID'] );
				$IndexInfo = array(
								"PublishDate" => $IndexInfo['PublishDate']
				);
				if ( $publish->contentEdit( $IndexID, $IndexInfo ) )
				{
								refreshsite( );
								redirect( "edit success!" );
				}
				else
				{
								redirect( "edit failed!" );
				}
				break;
case "reply_submit" :
				require_once( ROOT_PATH."plugins/base/plugin.config.php" );
				require_once( OAS_PATH."comment.lang.php" );
				if ( empty( $IN['IndexID'] ) )
				{
								shutdown( "IndexID empty" );
				}
				else
				{
								$IndexID = intval( $IN['IndexID'] );
				}
				require_once( LIB_PATH."SqlMap.class.php" );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "IndexID", $IndexID );
				$CountInfo = $sqlMap->queryForObject( "getCountInfo" );
				if ( empty( $CountInfo['NodeID'] ) )
				{
								exit( "Invalid IndexID" );
				}
				else
				{
								$NodeInfo = $iWPC->loadNodeInfo( $CountInfo['NodeID'] );
								$NodeID = $NodeInfo['NodeID'];
				}
				if ( in_array( basename( __FILE__ ), $EnableAccessInterceptorOAS ) )
				{
								if ( !$Access->canAccess( $NodeID, "PostComment" ) )
								{
												$TPL->assign( "deny_code", $Access->deny_code );
												$TPL->display( $OAS_SETTING['AccessDenyTpl'] );
												exit( );
								}
				}
				if ( !empty( $IN['content'] ) )
				{
								if ( $OAS_SETTING['Comment_enableComment'] != 1 )
								{
												goback( "comment.disabled" );
								}
								$content = trim( addslashes( htmlspecialchars( $IN['content'] ) ) );
								$IN['username'] = empty( $Access->oas->session['UserName'] ) ? $_LANG_ADMIN['guest'] : $Access->oas->session['UserName'];
								if ( $OAS_SETTING['Comment_contentMaxLength'] < strlen( $content ) )
								{
												goback( "comment.length.overflow", array(
																$OAS_SETTING['Comment_contentMaxLength']
												) );
								}
								if ( strlen( $content ) <= $OAS_SETTING['Comment_contentMinLength'] )
								{
												goback( "comment.length.less", array(
																$OAS_SETTING['Comment_contentMinLength']
												) );
								}
								if ( !empty( $OAS_SETTING['Comment_filterMode'] ) )
								{
												$bannedWords = explode( ",", $OAS_SETTING['Comment_filterWords'] );
												$content_todo = str_replace( " ", "", $IN['content'] );
												$username_todo = str_replace( " ", "", $IN['username'] );
												foreach ( $bannedWords as $var )
												{
																$posA = strpos( $content_todo, $var );
																$posB = strpos( $username_todo, $var );
																if ( $posA === false && $posB === false )
																{
																}
																else if ( $OAS_SETTING['Comment_filterMode'] == 1 )
																{
																				goback( "comment.badwords", array(
																								$var
																				) );
																}
																else
																{
																				$replace = str_repeat( $OAS_SETTING['Comment_replaceWord'], ceil( strlen( $var ) / 2 ) );
																				$content = str_replace( $var, $replace, $content );
																}
												}
								}
								$sqlMap->startTransaction( );
								$sqlMap->addData( "IndexID", $IndexID );
								$sqlMap->addData( "ContentID", $CountInfo['ContentID'] );
								$sqlMap->addData( "NodeID", $CountInfo['NodeID'] );
								$sqlMap->addData( "Author", $IN['username'] );
								$sqlMap->addData( "CreationDate", time( ) );
								$sqlMap->addData( "Ip", $IN['IP_ADDRESS'] );
								$sqlMap->addData( "Comment", $content );
								$sqlMap->addData( "UserID", $UserSession['UserID'] );
								if ( !( $sqlMap->dataInsert( "comment" ) && $sqlMap->update( "updateCommentNum" ) ) )
								{
												break;
								}
								if ( $NodeInfo['NodeClassMark'] == "bbs" )
								{
												require_once( INCLUDE_PATH."admin/publishAdmin.class.php" );
												require_once( INCLUDE_PATH."admin/content_table_admin.class.php" );
												require_once( INCLUDE_PATH."admin/tplAdmin.class.php" );
												require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
												require_once( INCLUDE_PATH."admin/site_admin.class.php" );
												require_once( INCLUDE_PATH."cms.class.php" );
												require_once( INCLUDE_PATH."cms.func.php" );
												require_once( SETTING_DIR."cms.ini.php" );
												require_once( INCLUDE_PATH."encoding/encoding.inc.php" );
												require_once( INCLUDE_PATH."admin/psn_admin.class.php" );
												require_once( INCLUDE_PATH."admin/plugin.class.php" );
												require_once( INCLUDE_PATH."admin/task.class.php" );
												require_once( INCLUDE_PATH."image.class.php" );
												require_once( INCLUDE_PATH."admin/extra_publish_admin.class.php" );
												$Plugin = new Plugin( );
												$publish = new publishAdmin( );
												$site = new site_admin( );
												$publish->flushData( );
												$publish->addData( "LastPoster", $UserSession['UserName'] );
												$publish->addData( "LastPostTime", time( ) );
												$publish->contentEdit( $IndexID );
								}
								refreshsite( );
								if ( $OAS_SETTING['Comment_enableCommentApprove'] == 0 )
								{
												redirect( $_LANG_ADMIN['post_ok'] );
								}
								else
								{
												redirect( $_LANG_ADMIN['post_ok_approve'] );
								}
				}
				else
				{
								goback( "comment_null" );
				}
				break;
case "edit_reply_submit" :
				require_once( ROOT_PATH."plugins/base/plugin.config.php" );
				require_once( OAS_PATH."comment.lang.php" );
				require_once( LIB_PATH."SqlMap.class.php" );
				$CommentID = intval( $IN['CommentID'] );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "CommentID", $CommentID );
				$CommentInfo = $sqlMap->queryForObject( "getCommentInfo" );
				if ( $CommentInfo['UserID'] != $UserSession['UserID'] )
				{
								redirect( "Access Denid! You are not the Author of CommentID=[{$IN['CommentID']}]." );
				}
				if ( in_array( basename( __FILE__ ), $EnableAccessInterceptorOAS ) )
				{
								if ( !$Access->canAccess( $CommentInfo['NodeID'], "PostComment" ) )
								{
												$TPL->assign( "deny_code", $Access->deny_code );
												$TPL->display( $OAS_SETTING['AccessDenyTpl'] );
												exit( );
								}
				}
				if ( !empty( $IN['content'] ) )
				{
								if ( $OAS_SETTING['Comment_enableComment'] != 1 )
								{
												goback( "comment.disabled" );
								}
								$content = trim( addslashes( htmlspecialchars( $IN['content'] ) ) );
								if ( $OAS_SETTING['Comment_contentMaxLength'] < strlen( $content ) )
								{
												goback( "comment.length.overflow", array(
																$OAS_SETTING['Comment_contentMaxLength']
												) );
								}
								if ( strlen( $content ) <= $OAS_SETTING['Comment_contentMinLength'] )
								{
												goback( "comment.length.less", array(
																$OAS_SETTING['Comment_contentMinLength']
												) );
								}
								if ( !empty( $OAS_SETTING['Comment_filterMode'] ) )
								{
												$bannedWords = explode( ",", $OAS_SETTING['Comment_filterWords'] );
												$content_todo = str_replace( " ", "", $IN['content'] );
												$username_todo = str_replace( " ", "", $IN['username'] );
												foreach ( $bannedWords as $var )
												{
																$posA = strpos( $content_todo, $var );
																$posB = strpos( $username_todo, $var );
																if ( $posA === false && $posB === false )
																{
																}
																else if ( $OAS_SETTING['Comment_filterMode'] == 1 )
																{
																				goback( "comment.badwords", array(
																								$var
																				) );
																}
																else
																{
																				$replace = str_repeat( $OAS_SETTING['Comment_replaceWord'], ceil( strlen( $var ) / 2 ) );
																				$content = str_replace( $var, $replace, $content );
																}
												}
								}
								$sqlMap->startTransaction( );
								$sqlMap->addData( "Comment", $content );
								$sqlMap->addData( "CommentID", $CommentID );
								if ( !$sqlMap->update( "updateCommentInfo" ) )
								{
												break;
								}
								refreshsite( );
								if ( $OAS_SETTING['Comment_enableCommentApprove'] == 0 )
								{
												redirect( $_LANG_ADMIN['post_ok'] );
								}
								else
								{
												redirect( $_LANG_ADMIN['post_ok_approve'] );
								}
				}
				else
				{
								goback( "comment_null" );
				}
				break;
case "reply" :
				require_once( LIB_PATH."SqlMap.class.php" );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "IndexID", intval( $IN['IndexID'] ) );
				$table_publish = $db_config['table_pre'].$db_config['table_publish_pre']."_".$NodeInfo[TableID];
				$table_content = $db_config['table_pre'].$db_config['table_content_pre']."_".$NodeInfo[TableID];
				$sqlMap->addData( "table_publish", $table_publish );
				$sqlMap->addData( "table_content", $table_content );
				$IndexInfo = $sqlMap->queryForObject( "getPublishInfo" );
				$tpl = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/".$NodeInfo['NodeClassMark']."/reply.html";
				$TPL->assign_by_ref( "NodeInfo", $NodeInfo );
				$TPL->assign( "IndexID", $IN['IndexID'] );
				$TPL->assign_by_ref( "PublishInfo", $IndexInfo );
				$TPL->display( $tpl );
				break;
case "edit" :
				require_once( LIB_PATH."SqlMap.class.php" );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "IndexID", intval( $IN['IndexID'] ) );
				$table_content = $db_config['table_pre'].$db_config['table_content_pre']."_".$NodeInfo[TableID];
				$sqlMap->addData( "table_content", $table_content );
				$IndexInfo = $sqlMap->queryForObject( "getContentInfo" );
				if ( $IndexInfo['CreationUserID'] != $UserSession['UserID'] )
				{
								redirect( "Access Denid! You are not the Author of IndexID=[{$IN['IndexID']}]." );
				}
				$tpl = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/".$NodeInfo['NodeClassMark']."/post_edit.html";
				$TPL->assign_by_ref( "NodeInfo", $NodeInfo );
				$TPL->assign( "IndexID", $IN['IndexID'] );
				$TPL->assign_by_ref( "ContentInfo", $IndexInfo );
				$TPL->display( $tpl );
				break;
case "edit_reply" :
				require_once( LIB_PATH."SqlMap.class.php" );
				$sqlMap = new SqlMap( dirname( __FILE__ )."/sqlmap.php" );
				$sqlMap->startTransaction( );
				$sqlMap->addData( "CommentID", intval( $IN['CommentID'] ) );
				$CommentInfo = $sqlMap->queryForObject( "getCommentInfo" );
				if ( $CommentInfo['UserID'] != $UserSession['UserID'] )
				{
								redirect( "Access Denid! You are not the Author of CommentID=[{$IN['CommentID']}]." );
				}
				if ( in_array( basename( __FILE__ ), $EnableAccessInterceptorOAS ) )
				{
								if ( !$Access->canAccess( $CommentInfo['NodeID'], "PostComment" ) )
								{
												$TPL->assign( "deny_code", $Access->deny_code );
												$TPL->display( $OAS_SETTING['AccessDenyTpl'] );
												exit( );
								}
				}
				$tpl = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/".$NodeInfo['NodeClassMark']."/reply_edit.html";
				$TPL->assign_by_ref( "NodeInfo", $NodeInfo );
				$TPL->assign( "CommentID", $IN['CommentID'] );
				$TPL->assign_by_ref( "CommentInfo", $CommentInfo );
				$TPL->display( $tpl );
				break;
case "add" :
default :
				$tpl = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/".$NodeInfo['NodeClassMark']."/post.html";
				$TPL->assign_by_ref( "NodeInfo", $NodeInfo );
				$TPL->display( $tpl );
				break;
}
include( "debug.php" );
?>
