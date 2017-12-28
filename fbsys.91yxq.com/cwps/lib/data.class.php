<?php
class iData
{

				public $insData = NULL;
				public $checkpass = true;
				public $errinfo = NULL;
				public $db_insert_id = NULL;
				public $db_debug = false;

				public function filterData( $IN )
				{
								if ( !is_array( $IN ) )
								{
												return false;
								}
								foreach ( $IN as $key => $var )
								{
												$header = substr( $key, 0, 5 );
												if ( $header == "data_" )
												{
																$field = substr( $key, 5 );
																$this->addData( $field, $var );
												}
								}
				}

				public function iDataO( )
				{
								$this->checkpass = true;
				}

				public function getForm( $tmpArray )
				{
								foreach ( $tmpArray as $key => $val )
								{
												$this->insData[$key] = $val;
								}
				}

				public function debugData( )
				{
								foreach ( $this->insData as $key => $val )
								{
												echo "{$key} -- {$val} \n<br>";
								}
								exit( );
				}

				public function getData( $key = NULL )
				{
								if ( !empty( $key ) )
								{
												return $this->insData[$key];
								}
								else
								{
												return $this->insData;
								}
				}

				public function addData( $data, $val = NULL )
				{
								global $db;
								if ( is_array( $data ) )
								{
												foreach ( $data as $key => $var )
												{
																if ( is_array( $var ) )
																{
																				$this->insData[$key] = $db->escape_string( $this->array2str( $var ) );
																}
																else
																{
																				$this->insData[$key] = $db->escape_string( $var );
																}
												}
								}
								else if ( is_array( $val ) )
								{
												$this->insData[$data] = $db->escape_string( $this->array2str( $val ) );
								}
								else
								{
												$this->insData[$data] = $db->escape_string( $val );
								}
				}

				public function array2str( $array )
				{
								if ( is_array( $array ) )
								{
												$i = 0;
												foreach ( $array as $key => $var )
												{
																if ( $i === 0 )
																{
																				$return = $var;
																}
																else
																{
																				$return .= ",".$var;
																}
																++$i;
												}
												return $return;
								}
								else
								{
												return $array;
								}
				}

				public function delData( $key )
				{
								unset( $this->insData[$key] );
				}

				public function flushData( )
				{
								unset( $this->insData );
				}

				public function chgData( $key, $val )
				{
								$this->insData[$key] = $val;
				}

				public function dataInsert( $Table )
				{
								if ( !$this->checkpass )
								{
												return 0;
								}
								else
								{
												global $db;
												$insData_Num = count( $this->insData );
												$Foreach_I = 0;
												$query = "Insert into ".$Table." \n(\n";
												$query_key = "";
												$query_val = "";
												foreach ( $this->insData as $key => $val )
												{
																if ( 0 < strlen( $val ) )
																{
																				if ( $Foreach_I == 0 )
																				{
																								$query_key .= "`".$key."`";
																								$query_val .= "'".$this->ensql( $val )."'";
																				}
																				else
																				{
																								$query_key .= ",\n`".$key."`";
																								$query_val .= ",\n'".$this->ensql( $val )."'";
																				}
																				$Foreach_I += 1;
																}
												}
												$query .= $query_key."\n) \nValues \n(\n".$query_val."\n)";
												if ( $result = $db->query( $query ) )
												{
																$this->db_insert_id = $db->Insert_ID( );
																return true;
												}
												else
												{
																$result = $db->errormsg( );
																$db->errorinfo[] = "<P>数据库错误:数据更新失败。MySQL_ERRNO:".$result[code].".&nbsp;&nbsp;MySQL_ERROR:".$result[message]."</P>";
																$db->report = phphighlite( "{$query}" );
																return false;
												}
								}
				}

				public function dataUpdate( $table, $where )
				{
								if ( !$this->checkpass )
								{
												return 0;
								}
								else
								{
												global $db;
												$Foreach_I = 0;
												$query = "update ".$table." set ";
												$query_key = "";
												$query_val = "";
												foreach ( $this->insData as $key => $val )
												{
																if ( 0 <= strlen( $val ) )
																{
																				if ( $Foreach_I == 0 )
																				{
																								$query_key = "`".$key."`";
																								$query_val = "='".$this->ensql( $val )."'";
																								$query .= $query_key.$query_val;
																				}
																				else
																				{
																								$query_key = ",`".$key."`";
																								$query_val = "='".$this->ensql( $val )."'";
																								$query .= $query_key.$query_val;
																				}
																				$Foreach_I += 1;
																}
												}
												$query .= " {$where}";
												if ( $db->query( $query ) )
												{
																return true;
												}
												else
												{
																$result = $db->errormsg( );
																$db->errorinfo[] = "<P>数据库错误:数据更新失败。MySQL_ERRNO:".$result[code].".&nbsp;&nbsp;MySQL_ERROR:".$result[message]."</P>";
																$db->report = phphighlite( "{$query}" );
																return false;
												}
								}
				}

				public function dataDel( $table, $which, $id, $method = "=" )
				{
								if ( !$this->checkpass )
								{
												return 0;
								}
								else
								{
												global $db;
												$query = "Delete From ".$table." where ".$which.$method."'".$id."'";
												if ( $db->query( $query ) )
												{
																return true;
												}
												else
												{
																$result = $db->errormsg( );
																$db->errorinfo[] = "<P>数据库错误:数据更新失败。MySQL_ERRNO:".$result[code].".&nbsp;&nbsp;MySQL_ERROR:".$result[message]."</P>";
																$db->report = phphighlite( "{$query}" );
																return false;
												}
								}
				}

				public function dataExists( $table, $method, $field, $var )
				{
								global $db;
								$query = "select COUNT(*) as nr From ".$table." where ".$field.$method.$var;
								$result = $db->Execute( $query );
								if ( $result )
								{
												return true;
								}
								else
								{
												return false;
								}
				}

				public function ensql( $string )
				{
								return $string;
				}

				public function chkTel( $strPhoneNumber )
				{
								if ( strspn( $strPhoneNumber, "0123456789-" ) )
								{
												$errinfo[] = "Telphone number input error.";
												$checkpass = False;
								}
				}

				public function chkStrIsNull( $chkStr, $strName )
				{
								if ( 0 < !strlen( $chkStr ) )
								{
												$this->errinfo[] = $strName."不能为空.";
												$this->checkpass = False;
								}
				}

}

?>
