<?php
class site_admin extends iData
{

				public function add( )
				{
								global $table;
								global $sys;
								site_admin::isvalid( );
								$this->addData( "CreationUserID", $sys->session['sUId'] );
								if ( $this->dataInsert( $table->site ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function destroy( $NodeID )
				{
								global $table;
								global $iWPC;
								global $db;
								$publish = new publishAdmin( );
								$publish->empty_recycle_bin( $NodeID );
								$sql = "SELECT IndexID FROM {$table->content_index}  where NodeID='".$NodeID."' ";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$publish->destroy( $result->fields['IndexID'] );
												$result->MoveNext( );
								}
								unset( $publish );
								$which = "NodeID";
								if ( $this->dataDel( $table->site, $which, $NodeID, "=" ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function restore( $NodeID, $targetNodeID )
				{
								global $table;
								global $iWPC;
								global $db;
								$sql = "UPDATE {$table->site} SET `Disabled`=0 , `ParentID`='".$targetNodeID."' WHERE NodeID=".$NodeID;
								if ( $db->query( $sql ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function empty_recycle_bin( )
				{
								global $table;
								global $iWPC;
								$list = $this->getAll4RecycleBin( );
								foreach ( $list as $key => $var )
								{
												$result = $this->destroy( $var['NodeID'] );
								}
								if ( $result )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getAll4RecycleBin( )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->site} where  Disabled=1 ";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								return $data;
				}

				public function del( $NodeID )
				{
								global $table;
								global $iWPC;
								global $db;
								$sql = "UPDATE {$table->site} SET `Disabled`=1 WHERE NodeID={$NodeID}";
								if ( $db->query( $sql ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function delTree( $NodeID )
				{
								global $table;
								global $db;
								$return = $this->del( $NodeID );
								$sql = "SELECT NodeID FROM {$table->site} where  ParentID={$NodeID} ";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$return = $this->delTree( $result->fields['NodeID'] );
												$result->MoveNext( );
								}
								return $return;
				}

				public function isValid( $add = 0 )
				{
								global $table;
								global $db;
								global $NODE_LIST;
								require( SYS_PATH."/license.php" );
								$license_array = $License;
								unset( $License );
								if ( !empty( $NODE_LIST ) )
								{
												$result[nr] = count( $NODE_LIST );
								}
								else
								{
												$sql = "SELECT count(*) as nr FROM {$table->site}  WHERE  Disabled=0";
												$result = $db->getRow( $sql );
								}
								if ( $license_array['Node-num'] < $result[nr] + $add && $license_array['Node-num'] != 0 )
								{
												goback( "license_node_num_overflow" );
								}
				}

				public function update( $NodeID )
				{
								global $table;
								global $iWPC;
								$where = "where NodeID=".$NodeID;
								if ( $this->dataUpdate( $table->site, $where ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getNodeInfo( $NodeID )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->site}  WHERE NodeID='{$NodeID}' ";
								$result = $db->getRow( $sql );
								return $result;
				}

				public function getAll( $ParentID = 0 )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->site} where ParentID={$ParentID}  AND Disabled=0 Order by NodeSort DESC";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								return $data;
				}

				public function haveSon( $NodeID )
				{
								global $table;
								global $db;
								$sql = "SELECT count(*) as nr FROM {$table->site}  WHERE ParentID='{$NodeID}'  AND Disabled=0";
								$result = $db->getRow( $sql );
								if ( 0 < $result[nr] )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getAll4Tree( $ParentID = 0 )
				{
								global $table;
								global $db;
								if ( empty( $ParentID ) )
								{
												$ParentID = 0;
								}
								$sql = "SELECT * FROM {$table->site} where ParentID={$ParentID}  AND Disabled=0 Order by NodeSort DESC";
								$result = $db->Execute( $sql );
								$i = 1;
								while ( !$result->EOF )
								{
												if ( $this->haveSon( $result->fields[NodeID] ) )
												{
																$haveSon = 1;
												}
												else
												{
																$haveSon = 0;
												}
												$data[$i] = $result->fields;
												$data[$i]['haveSon'] = $haveSon;
												++$i;
												$result->MoveNext( );
								}
								return $data;
				}

				public function getRecycleBin( )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->site} where  Disabled=1 Order by NodeSort DESC";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								$result = $db->Execute( "SELECT * FROM {$table->site} where  Disabled=0 AND ParentID!=0" );
								while ( !$result->EOF )
								{
												$ParentNodeInfo = $this->getNodeInfo( $result->fields['ParentID'] );
												if ( empty( $ParentNodeInfo['NodeID'] ) || $ParentNodeInfo['Disabled'] == 1 )
												{
																$data[] = $result->fields;
												}
												$result->MoveNext( );
								}
								return $data;
				}

				public function getSonNode( $NodeID )
				{
								global $table;
								global $db;
								$sql = "SELECT NodeID FROM {$table->site} where InheritNodeID={$NodeID}  AND Disabled=0";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields['NodeID'];
												$result->MoveNext( );
								}
								return $data;
				}

				public function isSiteAdmin( )
				{
								global $sys;
								if ( $sys->session['sGIsAdmin'] == 1 )
								{
												return true;
								}
								if ( $sys->Auth[canNode] )
								{
												return true;
								}
								return false;
				}

				public function canAccess( &$NodeInfo, $mode )
				{
								global $sys;
								global $iWPC;
								if ( $sys->session['sGIsAdmin'] == 1 )
								{
												return true;
								}
								if ( $sys->Auth[canNode] )
								{
												return true;
								}
								if ( $this->isCreationUser( $NodeInfo ) )
								{
												return true;
								}
								if ( $NodeInfo['PermissionInherit'] == 1 )
								{
												$ParentNodeInfo = $iWPC->loadNodeInfo( $NodeInfo['ParentID'] );
												return $this->canAccess( $ParentNodeInfo, $mode );
								}
								if ( !empty( $NodeInfo['PermissionManageG'] ) )
								{
												$posMG = strpos( ",".$NodeInfo['PermissionManageG'].",", ",".$sys->session['sGId']."," );
												if ( $posMG === false )
												{
												}
												else
												{
																return true;
												}
								}
								if ( !empty( $NodeInfo['PermissionManageU'] ) )
								{
												$posMU = strpos( ",".$NodeInfo['PermissionManageU'].",", ",".$sys->session['sUId']."," );
												if ( $posMU === false )
												{
												}
												else
												{
																return true;
												}
								}
								if ( !empty( $NodeInfo["Permission".$mode."G"] ) )
								{
												$posG = strpos( ",".$NodeInfo["Permission".$mode."G"].",", ",".$sys->session['sGId']."," );
								}
								else
								{
												$posG = false;
								}
								if ( $posG === false )
								{
												if ( !empty( $NodeInfo["Permission".$mode."U"] ) )
												{
																$posU = strpos( ",".$NodeInfo["Permission".$mode."U"].",", ",".$sys->session['sUId']."," );
												}
												else
												{
																return false;
												}
												if ( $posU === false )
												{
																return false;
												}
												else
												{
																return true;
												}
								}
								else
								{
												return true;
								}
				}

				public function isCreationUser( &$NodeInfo )
				{
								global $sys;
								if ( $sys->session['sGIsAdmin'] == 1 )
								{
												return true;
								}
								if ( $sys->Auth[canNode] )
								{
												return true;
								}
								if ( $NodeInfo['CreationUserID'] == $sys->session['sUId'] )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function publishPermissionDetector( $o, $NodeID, &$IN )
				{
								global $sys;
								global $iWPC;
								global $_LANG_ADMIN;
								$NodeInfo = $iWPC->loadNodeInfo( $NodeID );
								switch ( $o )
								{
								case "list" :
								case "content_header" :
								case "content_list" :
								case "content_editor_frameset" :
								case "content_editor_header" :
								case "add" :
								case "edit" :
								case "view" :
								case "refresh" :
								case "IsRecordExists" :
								case "viewLinkState" :
								case "siteRefresh" :
								case "sitePublish" :
								case "recycle_bin" :
								case "viewpublish" :
								case "editContentLink" :
								case "picker_content" :
												if ( $this->canAccess( $NodeInfo, "Read" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_read'], $NodeInfo['Name'] ), 1 );
												break;
								case "add_submit" :
								case "edit_submit" :
								case "del" :
								case "cut" :
								case "topIt" :
								case "topIt_submit" :
								case "pinkIt" :
								case "pinkIt_submit" :
								case "sortIt" :
								case "sortIt_submit" :
								case "restore" :
								case "node_resync" :
								case "planPublish" :
												if ( $this->canAccess( $NodeInfo, "Write" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_write'], $NodeInfo['Name'] ), 1 );
												break;
								case "createLink" :
								case "createIndexLink" :
								case "copy" :
												if ( !$this->canAccess( $NodeInfo, "Read" ) )
												{
																goback( sprintf( $_LANG_ADMIN['site_permission_deny_read'], $NodeInfo['Name'] ), 1 );
												}
												$targetNodeInfo = $iWPC->loadNodeInfo( $IN[targetNodeID] );
												if ( $this->canAccess( $targetNodeInfo, "Write" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_write'], $targetNodeInfo['Name'] ), 1 );
												break;
								case "publish" :
								case "unpublish" :
												if ( $this->canAccess( $NodeInfo, "Publish" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_publish'], $NodeInfo['Name'] ), 1 );
												break;
								case "destroy" :
								case "empty_recycle_bin" :
												if ( !$this->canAccess( $NodeInfo, "Manage" ) )
												{
															//	break;
												}
												//goback( sprintf( $_LANG_ADMIN['site_permission_deny_manage'], $NodeInfo['Name'] ), 1 );
												//break;
								}
				}

				public function contributionPermissionDetector( $o, $NodeID, &$IN )
				{
								global $sys;
								global $iWPC;
								global $_LANG_ADMIN;
								$NodeInfo = $iWPC->loadNodeInfo( $NodeID );
								switch ( $o )
								{
								case "list" :
								case "content_header" :
								case "content_list" :
								case "contribution_editor_frameset" :
								case "contribution_editor_header" :
								case "edit" :
								case "view" :
								case "viewNote" :
								case "workflow" :
												if ( $this->canAccess( $NodeInfo, "Read" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_read'], $NodeInfo['Name'] ), 1 );
												break;
								case "edit_submit" :
								case "approve" :
								case "callback" :
												if ( !$this->canAccess( $NodeInfo, "Write" ) )
												{
																break;
												}
												goback( sprintf( $_LANG_ADMIN['site_permission_deny_write'], $NodeInfo['Name'] ), 1 );
												break;
								}
				}

				public function getAllFieldsInfo( )
				{
								global $table;
								global $db;
								global $NODE_FIELDS_INFO;
								if ( !empty( $FIELDS_INFO ) )
								{
												return $FIELDS_INFO;
								}
								$sql = "SELECT * FROM {$table->node_fields}  Order By FieldOrder";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								$NODE_FIELDS_INFO = $data;
								return $data;
				}

				public function addField( $data )
				{
								global $table;
								global $db_config;
								global $db;
								if ( $data[FieldSize] != "" && $data[FieldType] != "text" && $data[FieldType] != "mediumtext" && $data[FieldType] != "longtext" && $data[FieldType] != "contentlink" )
								{
												$length = "({$data[FieldSize]})";
								}
								$sql = "ALTER TABLE {$table->site} ADD `{$data[FieldName]}` {$data[FieldType]} {$length}   default NULL";
								if ( $db->query( $sql ) )
								{
												$this->flushData( );
												$this->addData( $data );
												if ( $this->_add_field( ) )
												{
																return true;
												}
												else
												{
																return false;
												}
								}
								else
								{
												return false;
								}
				}

				public function _add_field( )
				{
								global $table;
								if ( $this->dataInsert( $table->node_fields ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function _edit_field( $FieldID )
				{
								global $table;
								$where = "where FieldID=".$FieldID;
								if ( $this->dataUpdate( $table->node_fields, $where ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function editField( $FieldID, $data )
				{
								global $table;
								global $db_config;
								global $db;
								$fieldInfo = $this->getFieldInfo( $FieldID );
								if ( $data[FieldSize] != "" && $data[FieldType] != "text" && $data[FieldType] != "mediumtext" && $data[FieldType] != "longtext" && $data[FieldType] != "contentlink" )
								{
												$length = "({$data[FieldSize]})";
								}
								$sql = "ALTER TABLE {$table->site} CHANGE `{$fieldInfo[FieldName]}` `{$data[FieldName]}` {$data[FieldType]} {$length}   default NULL";
								if ( $db->query( $sql ) )
								{
												$this->flushData( );
												$this->addData( $data );
												if ( $this->_edit_field( $FieldID ) )
												{
																return true;
												}
												else
												{
																return false;
												}
								}
								else
								{
												return false;
								}
				}

				public function getFieldInfo( $FieldID )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->node_fields} where FieldID='{$FieldID}'";
								$data = $db->getRow( $sql );
								return $data;
				}

				public function delField( $FieldID )
				{
								global $table;
								global $db;
								global $db_config;
								$info = $this->getFieldInfo( $FieldID );
								$sql = "ALTER TABLE {$table->site} DROP `{$info[FieldName]}`";
								if ( $db->query( $sql ) )
								{
												if ( $this->_del_data( $FieldID ) )
												{
																return true;
												}
												else
												{
																return false;
												}
								}
								else
								{
												return false;
								}
				}

				public function _del_data( $FieldID )
				{
								global $table;
								$which = "FieldID";
								if ( $this->dataDel( $table->node_fields, $which, $FieldID, $method = "=" ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function isFieldNameExists( $FieldName, $FieldID = 0 )
				{
								global $table;
								global $db;
								$sql = "SELECT FieldID FROM {$table->node_fields}  where  FieldName='{$FieldName}' AND FieldID!='{$FieldID}' ";
								$result = $db->getRow( $sql );
								if ( empty( $result[FieldID] ) )
								{
												return false;
								}
								else
								{
												return true;
								}
				}

}

?>
