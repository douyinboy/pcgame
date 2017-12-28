<?php
class keywordsAdmin extends iData
{

				public function add( )
				{
								global $table;
								if ( $this->dataInsert( $table->keywords ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function del( $kId )
				{
								global $table;
								$which = "kId";
								if ( $this->dataDel( $table->keywords, $which, $kId, $method = "=" ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function update( $kId )
				{
								global $table;
								$where = "where kId=".$kId;
								if ( $this->dataUpdate( $table->keywords, $where ) )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getAll( )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->keywords} ";
								$result = $db->Execute( $sql, 2, 10000 );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								return $data;
				}

				public function getLimit( $start = 0, $offset = 15 )
				{
								global $table;
								global $db;
								if ( $start == "" )
								{
												$start = 0;
								}
								if ( $offset == "" )
								{
												$offset = 15;
								}
								$sql = "SELECT * FROM {$table->keywords}  ORDER BY kId DESC LIMIT {$start}, {$offset}";
								$result = $db->Execute( $sql );
								while ( !$result->EOF )
								{
												$data[] = $result->fields;
												$result->MoveNext( );
								}
								return $data;
				}

				public function getRecordNum( )
				{
								global $table;
								global $db;
								$sql = "SELECT COUNT(*) as nr  FROM {$table->keywords} ";
								$result = $db->getRow( $sql );
								return $result[nr];
				}

				public function getInfo( $kId )
				{
								global $table;
								global $db;
								$sql = "SELECT * FROM {$table->keywords}   WHERE kId='{$kId}'";
								$result = $db->getRow( $sql );
								return $result;
				}

}

?>
