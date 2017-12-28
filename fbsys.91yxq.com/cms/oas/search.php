<?php
require_once( "common.php" );
require_once( ROOT_PATH."plugins/base/plugin.config.php" );
require_once( "search.lang.php" );
$TableID = empty( $IN['TableID'] ) ? 1 : intval( $IN['TableID'] );
$Setting = $db->getRow( "SELECT * FROM {$plugin_table['base']['setting']}  WHERE TableID={$TableID} " );
if ( empty( $Setting['TableID'] ) )
{
				goback( "invalid_tableid_setting" );
}
if ( empty( $IN['Tpl'] ) )
{
				if ( preg_match( "/\\{TID:([0-9]+)\\}/isU", $Setting['SearchTpl'], $matches ) )
				{
								require_once( INCLUDE_PATH."admin/cate_tpl_admin.class.php" );
								if ( !isset( $cate_tpl ) )
								{
												$cate_tpl = new cate_tpl_admin( );
												$TID = $matches[1];
												$TInfo = $cate_tpl->getInfo( $TID );
												$Setting['SearchTpl'] = "/ROOT/".$TInfo[TCID]."/".$TInfo[TID].".tpl";
								}
				}
				$tpl =& $Setting['SearchTpl'];
}
else
{
				$tpl = str_replace( "..", "", $IN['Tpl'] );
}
$TPL->registerPreFilter( "CMS_Parser" );
$Setting['SearchProTpl'] = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/oas/search.html";
$Setting['SearchTpl'] = "/TPL-LITE/style/".$SYS_ENV['SiteStyle']."/oas/search_result.html";
$TPL->caching = true;
$TPL->cache_lifetime = "3600";
switch ( $IN['o'] )
{
case "pro" :
				if ( empty( $IN['Tpl'] ) )
				{
								$tpl =& $Setting['SearchProTpl'];
				}
				else
				{
								$tpl = str_replace( "..", "", $IN['Tpl'] );
				}
				include_once( CACHE_DIR."Cache_CateList.php" );
				$TPL->assign( "Cate_List", $NODE_LIST );
				$TPL->assign( "TableID", $IN['TableID'] );
				$cache_id = "search";
				if ( $TPL->caching && $TPL->is_cached( $tpl, $cache_id ) )
				{
								$TPL->run_cache( $tpl, $cache_id );
				}
				else
				{
								include_once( OAS_PATH."publish_loading.php" );
								$TPL->run_cache( $tpl, $cache_id );
				}
				break;
case "search" :
				$table_publish = $db_config['table_pre'].$db_config['table_publish_pre']."_".$TableID;
				$table_count =& $plugin_table['base']['count'];
				if ( empty( $IN['Keywords'] ) )
				{
								goback( "please_input_keywords" );
				}
				if ( empty( $IN['Field'] ) )
				{
								goback( "please_input_field" );
				}
				$validFields = explode( ",", $Setting['AllowSearchField'] );
				if ( empty( $Setting['AllowSearchField'] ) )
				{
				}
				else if ( !in_array( $IN['Field'], $validFields ) )
				{
								goback( "invalid_field" );
				}
				if ( !is_array( $IN['Field'] ) )
				{
								$IN['Field'] = addslashes( $IN['Field'] );
								$IN['Field'] = explode( ",", $IN['Field'] );
				}
				if ( !is_array( $IN['Keywords'] ) )
				{
								$IN['Keywords'] = addslashes( $IN['Keywords'] );
								$IN['Keywords'] = explode( ",", $IN['Keywords'] );
				}
				$isAndor = false;
				if ( isset( $IN['Andor'] ) )
				{
								if ( !is_array( $IN['Andor'] ) )
								{
												$IN['Andor'] = addslashes( $IN['Andor'] );
												$IN['Andor'] = explode( ",", $IN['Andor'] );
												$isAndor = true;
								}
				}
				$field_where = "";
				$field_list = "";
				$keywords_list = "";
				$andor_list = "";
				foreach ( $IN['Field'] as $key => $var )
				{
								if ( !empty( $IN['Field'][$key] ) && !empty( $IN['Keywords'][$key] ) )
								{
												if ( $field_where == "" )
												{
																$field_where = $IN['Field'][$key]." LIKE '%".str_replace( " ", "%", $IN['Keywords'][$key] )."%'";
																$field_list = $IN['Field'][$key];
																$keywords_list = $IN['Keywords'][$key];
												}
												else
												{
																if ( $isAndor && in_array( strtoupper( $IN['Andor'][$key - 1] ), array( "AND", "OR" ) ) )
																{
																				$andor_list .= ( empty( $andor_list ) ? "" : "," ).$IN['Andor'][$key - 1];
																				$field_where .= " ".$IN['Andor'][$key - 1]." ".$IN['Field'][$key]." LIKE '%".str_replace( " ", "%", $IN['Keywords'][$key] )."%'";
																}
																else
																{
																				$field_where .= " AND ".$IN['Field'][$key]." LIKE '%".str_replace( " ", "%", $IN['Keywords'][$key] )."%'";
																}
																$field_list .= ",".$IN['Field'][$key];
																$keywords_list .= ",".$IN['Keywords'][$key];
												}
								}
				}
				$isAndor = !empty( $andor_list );
				$node_list = "";
				if ( empty( $IN['NodeID'] ) )
				{
								$node_where_count = "";
								$node_where_execute = "";
				}
				else
				{
								if ( is_array( $IN['NodeID'] ) )
								{
												$NodeIDs = $IN['NodeID'];
												foreach ( $NodeIDs as $key => $var )
												{
																if ( $key == 0 )
																{
																				$IN['NodeID'] = $var;
																}
																else
																{
																				$IN['NodeID'] .= ",".$var;
																}
												}
								}
								else
								{
												$NodeIDs = explode( ",", $IN['NodeID'] );
								}
								if ( $IN['Sub'] == 1 )
								{
												foreach ( $NodeIDs as $key => $var )
												{
																$var = intval( $var );
																$NodeInfo = $iWPC->loadNodeInfo( $var );
																$subnode = str_replace( "%", ",", $NodeInfo['SubNodeID'] );
																if ( $key == 0 )
																{
																				$node_where = $subnode;
																}
																else
																{
																				$node_where .= ",".$subnode;
																}
												}
								}
								else
								{
												foreach ( $NodeIDs as $key => $var )
												{
																$var = intval( $var );
																if ( $key == 0 )
																{
																				$node_where = $var;
																}
																else
																{
																				$node_where .= ",".$var;
																}
												}
								}
								$node_list = $node_where;
								$node_where = "AND p.NodeID IN({$node_where})";
				}
				$offset =& $Setting['SearchPageOffset'];
				$Page = empty( $IN['Page'] ) ? 1 : intval( $IN['Page'] );
				$Time = empty( $IN['Time'] ) ? 0 : intval( $IN['Time'] );
				if ( $Time == 0 )
				{
								$time_where = "";
				}
				else
				{
								$timestamp = time( ) - $Time * 60 * 60 * 24;
								$time_where = "AND p.PublishDate > ".$timestamp;
				}
				$isOrderby = !empty( $IN['Orderby'] );
				$Orderby = empty( $IN['Orderby'] ) ? "p.PublishDate DESC, p.IndexID DESC" : $IN['Orderby'];
				$result = $db->getRow( "SELECT COUNT(*) as nr  From {$table_publish} p WHERE  {$field_where} {$node_where} {$time_where}" );
				$num = intval( $result[nr] );
				$pagenum = ceil( $num / $offset );
				$start = ( $Page - 1 ) * $offset;
				$field_where = str_replace( ";", "", $field_where );
				$keywords_where = str_replace( ";", "", $keywords_where );
				$node_where = str_replace( ";", "", $node_where );
				$time_where = str_replace( ";", "", $time_where );
				$Orderby = str_replace( ";", "", $Orderby );
				$sql = "SELECT p.*,co.* From {$table_publish} p left join {$table_count} co ON p.IndexID=co.IndexID  WHERE  {$field_where} {$node_where} {$time_where} ORDER BY {$Orderby} Limit {$start}, {$offset} ";
				$result = $db->Execute( $sql );
				while ( !$result->EOF )
				{
								$data[] = $result->fields;
								$result->MoveNext( );
				}
				$sendVar = "search.php?o=search&amp;TableID=".$TableID."&amp;Keywords=".urlencode( $keywords_list )."&amp;Field=".$field_list;
				if ( $isAndor )
				{
								$sendVar .= "&amp;Andor=".$andor_list;
				}
				if ( $isOrderby )
				{
								$sendVar .= "&amp;Orderby=".$Orderby;
				}
				if ( !empty( $node_list ) )
				{
								$sendVar .= "&amp;NodeID=".$node_list;
				}
				if ( !empty( $IN['Sub'] ) )
				{
								$sendVar .= "&amp;Sub=".$IN['Sub'];
				}
				if ( !empty( $IN['Time'] ) )
				{
								$sendVar .= "&amp;Time=".$IN['Time'];
				}
				if ( !empty( $IN['Tpl'] ) )
				{
								$sendVar .= "&amp;Tpl=".$tpl;
				}
				$pagelist = search_page( $pagenum, $Page, $sendVar );
				$searchResultInfo = array(
								"num" => $num,
								"from" => $start + 1,
								"to" => $start + $offset,
								"pageNum" => $pagenum
				);
				$tmpkeywords = explode( ",", $keywords_list );
				$keywordslist = str_replace( ",", " ", $keywords_list );
				if ( $IN['DEBUG'] === "YES" )
				{
								print_r( $GLOBALS );
								exit( );
				}
				$TPL->assign( "searchResult", $data );
				$TPL->assign( "pageList", $pagelist );
				if ( $searchResultInfo[num] < $searchResultInfo[to] )
				{
								$searchResultInfo[to] = $searchResultInfo[num];
				}
				$TPL->assign( "TableID", $IN['TableID'] );
				$TPL->assign_by_ref( "searchResultInfo", $searchResultInfo );
				$TPL->assign_by_ref( "searchKeywords", $tmpkeywords[0] );
				$TPL->assign_by_ref( "KeywordsList", $keywordslist );
				$TPL->assign_by_ref( "IN", $IN );
				$cache_id = "search_result";
				if ( $TPL->caching && $TPL->is_cached( $tpl, $cache_id ) )
				{
								$TPL->run_cache( $tpl, $cache_id );
				}
				else
				{
								include_once( OAS_PATH."publish_loading.php" );
								$TPL->run_cache( $tpl, $cache_id );
								break;
				}
default :
				$cache_id = "search_default";
				if ( $TPL->caching && $TPL->is_cached( $tpl, $cache_id ) )
				{
								$TPL->run_cache( $tpl, $cache_id );
				}
				else
				{
								include_once( OAS_PATH."publish_loading.php" );
								$TPL->run_cache( $tpl, $cache_id );
								break;
				}
}
include( "debug.php" );
?>
