<?php
class publishAuthAdmin extends iData
{

				public function add( )
				{
								global $table;
								if ( $this->dataInsert( $table->pubadminmasks ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function del( $pId )
				{
								global $table;
								$which = "pId";
								if ( $this->dataDel( $table->pubadminmasks, $which, $pId, $method = "=" ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function update( $pId )
				{
								global $table;
								$where = "where pId=".$pId;
								if ( $this->dataUpdate( $table->pubadminmasks, $where ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getInfo( $pId, $field = "*" )
				{
								global $table;
								global $db;
								$sql = "SELECT {$field} FROM {$table->pubadminmasks}  WHERE pId='{$pId}'";
								$result = $db->getRow( $sql );
								if ( $field == "*" )
								{
												return $result;
								}
								else
								{
												return $result[$field];
								}
				}

				public static function getAll( )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->pubadminmasks}";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								return $data;
				}

				public function haveSon( $cId )
				{
								global $table;
								global $db;
								$sql = "SELECT count(*) as nr FROM {$table->site}  WHERE ParentID='{$cId}'  AND Disabled=0";
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

}

?>
