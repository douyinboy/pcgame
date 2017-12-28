<?php
class AccessGroup extends SqlMap
{

				public function AccessGroup( )
				{
								$this->_basefile = __FILE__;
				}

				public function getAll( &$oas )
				{
								$oas->setTransactionID( time( ) );
								$oas->setDataEncode( FALSE );
								$return = $oas->call( "GetAllGroup" );
								if ( $return === FALSE )
								{
												$oas->error( );
								}
								else
								{
												$groupList = $oas->unserialize( $return['List'] );
								}
								foreach ( $groupList as $key => $var )
								{
												$this->startTransaction( );
												$this->addData( "GroupID", $var['GroupID'] );
												$groupList[$key] = array_merge( $var, ( array )$this->queryForObject( "getAccessInfoByGroupID" ) );
								}
								return $groupList;
				}

				public function getInfo( $aId, &$oas )
				{
								if ( empty( $aId ) )
								{
												return FALSE;
								}
								$this->startTransaction( );
								$this->addData( "AccessID", $aId );
								$groupInfo = $this->queryForObject( "getAccessInfoByAccessID" );
								$oas->setTransactionID( time( ) );
								$oas->setDataEncode( FALSE );
								$params['GroupID'] = $groupInfo['OwnerID'];
								$return = $oas->call( "GetGroupInfo", $params );
								if ( $return === FALSE )
								{
												$oas->error( );
								}
								else
								{
												$groupInfo = array_merge( $groupInfo, $oas->unserialize( $return['Info'] ) );
								}
								$this->startTransaction( );
								$this->addData( "AccessID", $aId );
								$accessMap = $this->queryForList( "getAccessMapByAccessID" );
								foreach ( $accessMap as $var )
								{
												$groupInfo[$var['PermissionKey']] = $var['AccessNodeIDs'];
								}
								return $groupInfo;
				}

}

?>
