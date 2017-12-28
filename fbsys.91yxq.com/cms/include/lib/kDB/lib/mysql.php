<?php
class mysql
{

				public $connection = NULL;
				public $fields = array( );
				public $EOF = 0;
				public $FetchMode = "assoc";
				public $charset = "";
				public $result = NULL;
				public $debug = false;
				public $TotalQueryTime = 0;
				public $TotalQueryNum = 0;
				public $TotalCacheum = 0;
				public $QueryLog = array( );
				public $Cache_ExecuteRecord = array( );
				public $isCached_ExecuteRecord = false;
				public $cache_dir = NULL;
				public $db_version = 0;

				public function connect( $params )
				{
								if ( !( $this->connection = mysql_connect( $params['db_host'], $params['db_user'], $params['db_password'] ) ) )
								{
												exit( "<b>kDB Error:</b> Connecting to MySQL failed,please contact to your administrator" );
								}
								if ( !empty( $params['db_name'] ) )
								{
												if ( mysql_select_db( $params['db_name'] ) )
												{
																$this->cache_dir = SYS_PATH."sysdata/cache/";
																$this->setCharset( $params['db_charset'] );
												}
												else
												{
																printf( "<b>kDB Error:</b> Database {$params['db_name']} does not exists, please contact to your administrator" );
												}
								}
				}

				public function getDbVersion( )
				{
								return $this->db_version;
				}

				public function getServerInfo( )
				{
								return mysql_get_server_info( );
				}

				public function setCharset( $charset )
				{
								$this->charset = $charset;
								$serverVersion = mysql_get_server_info( $this->connection );
								$version = explode( ".", $serverVersion );
								if ( $version[0] == 4 && 0 < $version[1] )
								{
												$this->db_version = 41;
								}
								else if ( 4 < $version[0] )
								{
												$this->db_version = 5;
								}
								else
								{
												$this->db_version = 0;
								}
								if ( $version[0] < 4 )
								{
												return;
								}
								if ( $this->charset == "utf-8" || $this->charset == "UTF-8" )
								{
												$this->charset = "utf8";
								}
								$result = mysql_query( "SHOW CHARACTER SET like '".$this->charset."'", $this->connection );
								if ( is_resource( $result ) )
								{
												if ( mysql_num_rows( $result ) <= 0 )
												{
																return;
												}
								}
								else
								{
												return;
								}
								mysql_query( "SET NAMES '".$this->charset."'", $this->connection );
				}

				public function db_close( )
				{
								mysql_close( $this->connection );
				}

				public function Close( )
				{
				}

				public function &query( $query )
				{
								if ( $this->debug )
								{
												$this->startTimer( );
								}
								if ( $this->db_version == 5 )
								{
												$query = preg_replace( "/!=[\\s]*NULL/", " IS NOT NULL", $query );
								}
								$QueryResult = mysql_query( $query );
								if ( $this->debug )
								{
												$time = $this->endTimer( );
												$this->TotalQueryTime = $this->TotalQueryTime + $time;
												$this->QueryLog[] = array(
																"query" => $query,
																"time" => $time
												);
								}
								if ( !$QueryResult )
								{
												$this->halt( "MySQL Query Error", $query );
								}
								$this->TotalQueryNum++;
								return $QueryResult;
				}

				public function halt( $message = "", $sql = "" )
				{
								require( KDB_DIR."lib/mysql_error.php" );
				}

				public function setDebug( $debug )
				{
								$this->debug = $debug;
				}

				public function &Execute( $query, $cache = 0, $cache_time = 600 )
				{
								$recordset = new DBRecordSet( $this );
								$recordset->isCached_ExecuteRecord = false;
								$queryKey = md5( $query );
								if ( $cache == 1 )
								{
												if ( isset( $this->Cache_ExecuteRecord[$queryKey] ) )
												{
																if ( $this->debug )
																{
																				$this->startTimer( );
																}
																$recordset->result = $this->Cache_ExecuteRecord[$queryKey];
																$this->TotalCacheNum++;
																if ( $this->debug )
																{
																				$time = $this->endTimer( );
																				$this->TotalQueryTime = $this->TotalQueryTime + $time;
																				$this->QueryLog[] = array(
																								"query" => $query,
																								"time" => $time,
																								"cache" => "Cached-1 "
																				);
																}
																$recordset->isCached_ExecuteRecord = true;
												}
												else
												{
																$recordset->result =& $this->query( $query );
												}
								}
								else if ( $cache == 2 )
								{
												$cache_filename = $this->cache_dir.$queryKey.".db.php";
												$cache_file_exists = false;
												if ( file_exists( $cache_filename ) )
												{
																if ( time( ) - filemtime( $cache_filename ) < $cache_time )
																{
																				if ( $this->debug )
																				{
																								$this->startTimer( );
																				}
																				if ( isset( $this->Cache_ExecuteRecord[$queryKey] ) )
																				{
																								$recordset->result = $this->Cache_ExecuteRecord[$queryKey];
																				}
																				else
																				{
																								include( $cache_filename );
																								$recordset->result = $CacheData;
																								$this->Cache_ExecuteRecord[$queryKey] = $CacheData;
																				}
																				$this->TotalCacheNum++;
																				if ( $this->debug )
																				{
																								$time = $this->endTimer( );
																								$this->TotalQueryTime = $this->TotalQueryTime + $time;
																								$this->QueryLog[] = array(
																												"query" => $query,
																												"time" => $time,
																												"cache" => "Cached-2 "
																								);
																				}
																				$recordset->isCached_ExecuteRecord = true;
																				$cache_file_exists = true;
																}
																else
																{
																				if ( file_exists( $cache_filename ) )
																				{
																								unlink( $cache_filename );
																				}
																				$recordset->result =& $this->query( $query );
																}
												}
												else
												{
																$recordset->result =& $this->query( $query );
												}
								}
								else if ( $cache == 3 )
								{
												if ( isset( $_SESSION['DB_QUERY_CACHE'][$queryKey] ) )
												{
																if ( time( ) < $_SESSION['DB_QUERY_CACHE'][$queryKey]['expire'] )
																{
																				if ( $this->debug )
																				{
																								$this->startTimer( );
																				}
																				$this->TotalCacheNum++;
																				$recordset->result = $_SESSION['DB_QUERY_CACHE'][$queryKey]['data'];
																				if ( $this->debug )
																				{
																								$time = $this->endTimer( );
																								$this->TotalQueryTime = $this->TotalQueryTime + $time;
																								$this->QueryLog[] = array(
																												"query" => $query,
																												"time" => $time,
																												"cache" => "Cached-3 "
																								);
																				}
																				$recordset->isCached_ExecuteRecord = true;
																}
																else
																{
																				unset( $this->DB_QUERY_CACHE[$queryKey] );
																				$recordset->result =& $this->query( $query );
																}
												}
												else
												{
																$recordset->result =& $this->query( $query );
												}
								}
								else
								{
												$recordset->result =& $this->query( $query );
								}
								if ( $recordset->result )
								{
												if ( $recordset->FetchMode == "num" )
												{
																if ( $recordset->fields = $recordset->fetch_array( $recordset->result, MYSQL_NUM ) )
																{
																				$recordset->EOF = 0;
																}
																else
																{
																				$recordset->EOF = 1;
																				$recordset->free_result( $recordset->result );
																}
												}
												else if ( $recordset->FetchMode == "assoc" )
												{
																if ( $recordset->fields = $recordset->fetch_array( $recordset->result, MYSQL_ASSOC ) )
																{
																				$recordset->EOF = 0;
																}
																else
																{
																				$recordset->EOF = 1;
																				$recordset->free_result( $recordset->result );
																}
												}
												else if ( $recordset->fields = $recordset->fetch_array( $recordset->result ) )
												{
																$recordset->EOF = 0;
												}
												else
												{
																$recordset->EOF = 1;
																$recordset->free_result( $recordset->result );
												}
								}
								else
								{
												$recordset->EOF = 1;
												$recordset->free_result( $recordset->result );
								}
								if ( $cache == 1 )
								{
												if ( !isset( $this->Cache_ExecuteRecord[$queryKey] ) )
												{
																while ( !$recordset->EOF )
																{
																				$this->Cache_ExecuteRecord[$queryKey][] = $recordset->fields;
																				$recordset->MoveNext( );
																}
																$recordset->result = $this->Cache_ExecuteRecord[$queryKey];
																$recordset->isCached_ExecuteRecord = true;
																if ( $recordset->fields = $recordset->fetch_array( $recordset->result ) )
																{
																				$recordset->EOF = 0;
																}
																else
																{
																				$recordset->EOF = 1;
																				$recordset->free_result( $recordset->result );
																}
												}
								}
								else if ( $cache == 2 )
								{
												if ( !$cache_file_exists )
												{
																while ( !$recordset->EOF )
																{
																				$CacheData[] = $recordset->fields;
																				$recordset->MoveNext( );
																}
																$recordset->result = $CacheData;
																$this->writeCache( $cache_filename, $CacheData );
																$recordset->isCached_ExecuteRecord = true;
																if ( $recordset->fields = $recordset->fetch_array( $recordset->result ) )
																{
																				$recordset->EOF = 0;
																}
																else
																{
																				$recordset->EOF = 1;
																				$recordset->free_result( $recordset->result );
																}
												}
								}
								else if ( $cache == 3 && !isset( $_SESSION['DB_QUERY_CACHE'][$queryKey] ) )
								{
												while ( !$recordset->EOF )
												{
																$_SESSION['DB_QUERY_CACHE'][$queryKey]['data'][] = $recordset->fields;
																$recordset->MoveNext( );
												}
												$recordset->result = $_SESSION['DB_QUERY_CACHE'][$queryKey]['data'];
												$_SESSION['DB_QUERY_CACHE'][$queryKey]['expire'] = time( ) + $cache_time;
												$recordset->isCached_ExecuteRecord = true;
												if ( $recordset->fields = $recordset->fetch_array( $recordset->result ) )
												{
																$recordset->EOF = 0;
												}
												else
												{
																$recordset->EOF = 1;
																$recordset->free_result( $recordset->result );
												}
								}
								return $recordset;
				}

				public function &getRow( $query, $cache = 0, $cache_time = 1800 )
				{
								global $_SESSION;
								$queryKey = md5( $query );
								if ( $cache == 1 )
								{
												if ( isset( $this->Cache_ExecuteRecord[$queryKey] ) )
												{
																if ( $this->debug )
																{
																				$this->startTimer( );
																}
																$returnRow = $this->Cache_ExecuteRecord[$queryKey];
																$this->TotalCacheNum++;
																if ( $this->debug )
																{
																				$time = $this->endTimer( );
																				$this->TotalQueryTime = $this->TotalQueryTime + $time;
																				$this->QueryLog[] = array(
																								"query" => $query,
																								"time" => $time,
																								"cache" => "Cached-1 "
																				);
																}
												}
												else
												{
																$result =& $this->query( $query );
																$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
																$this->Cache_ExecuteRecord[$queryKey] = $returnRow;
																$this->free_result( $result );
												}
								}
								else if ( $cache == 2 )
								{
												$cache_filename = $this->cache_dir.$queryKey.".db.php";
												$cache_file_exists = false;
												if ( file_exists( $cache_filename ) )
												{
																if ( time( ) - filemtime( $cache_filename ) < $cache_time )
																{
																				if ( $this->debug )
																				{
																								$this->startTimer( );
																				}
																				if ( isset( $this->Cache_ExecuteRecord[$queryKey] ) )
																				{
																								$returnRow = $this->Cache_ExecuteRecord[$queryKey];
																				}
																				else
																				{
																								include( $cache_filename );
																								$returnRow = $CacheData;
																								$this->Cache_ExecuteRecord[$queryKey] = $returnRow;
																				}
																				$this->TotalCacheNum++;
																				if ( $this->debug )
																				{
																								$time = $this->endTimer( );
																								$this->TotalQueryTime = $this->TotalQueryTime + $time;
																								$this->QueryLog[] = array(
																												"query" => $query,
																												"time" => $time,
																												"cache" => "Cached-2 "
																								);
																				}
																}
																else
																{
																				if ( file_exists( $cache_filename ) )
																				{
																								unlink( $cache_filename );
																				}
																				$result =& $this->query( $query );
																				$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
																				$this->writeCache( $cache_filename, $returnRow );
																				$this->free_result( $result );
																}
												}
												else
												{
																$result =& $this->query( $query );
																$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
																$this->writeCache( $cache_filename, $returnRow );
																$this->free_result( $result );
												}
								}
								else if ( $cache == 3 )
								{
												if ( isset( $_SESSION['DB_QUERY_CACHE'][$queryKey] ) )
												{
																if ( time( ) < $_SESSION['DB_QUERY_CACHE'][$queryKey]['expire'] )
																{
																				if ( $this->debug )
																				{
																								$this->startTimer( );
																				}
																				$this->TotalCacheNum++;
																				$returnRow = $_SESSION['DB_QUERY_CACHE'][$queryKey]['data'];
																				if ( $this->debug )
																				{
																								$time = $this->endTimer( );
																								$this->TotalQueryTime = $this->TotalQueryTime + $time;
																								$this->QueryLog[] = array(
																												"query" => $query,
																												"time" => $time,
																												"cache" => "Cached-3 "
																								);
																				}
																}
																else
																{
																				unset( $this->DB_QUERY_CACHE[$queryKey] );
																				$result =& $this->query( $query );
																				$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
																				$_SESSION['DB_QUERY_CACHE'][$queryKey]['data'] = $returnRow;
																				$_SESSION['DB_QUERY_CACHE'][$queryKey]['expire'] = time( ) + $cache_time;
																				$this->free_result( $result );
																}
												}
												else
												{
																$result =& $this->query( $query );
																$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
																$_SESSION['DB_QUERY_CACHE'][$queryKey]['data'] = $returnRow;
																$_SESSION['DB_QUERY_CACHE'][$queryKey]['expire'] = time( ) + $cache_time;
																$this->free_result( $result );
												}
								}
								else
								{
												$result =& $this->query( $query );
												$returnRow = mysql_fetch_array( $result, MYSQL_ASSOC );
												$this->free_result( $result );
								}
								return $returnRow;
				}

				public function FieldCount( )
				{
								if ( $this->result )
								{
												return mysql_num_fields( $this->result );
								}
				}

				public function FetchRow( )
				{
								return mysql_fetch_array( $this->result, MYSQL_ASSOC );
				}

				public function RecordCount( )
				{
								return mysql_num_rows( $this->result );
				}

				public function free_result( $result )
				{
								if ( $result )
								{
												mysql_free_result( $result );
								}
				}

				public function Insert_ID( )
				{
								return mysql_insert_id( );
				}

				public function errormsg( )
				{
								$result['message'] = mysql_error( $this->connection );
								$result['code'] = mysql_errno( $this->connection );
								return $result;
				}

				public function error( )
				{
								return mysql_error( );
				}

				public function errno( )
				{
								return mysql_errno( );
				}

				public function escape_string( $string )
				{
								return mysql_real_escape_string( $string );
				}

				public function SetFetchMode( $mode )
				{
								$this->FetchMode = $mode;
				}

				public function info( )
				{
								return mysql_get_server_info( );
				}

				public function startTimer( )
				{
								global $db_starttime;
								$mtime = microtime( );
								$mtime = explode( " ", $mtime );
								$mtime = $mtime[1] + $mtime[0];
								$db_starttime = $mtime;
				}

				public function endTimer( )
				{
								global $db_starttime;
								$mtime = microtime( );
								$mtime = explode( " ", $mtime );
								$mtime = $mtime[1] + $mtime[0];
								$endtime = $mtime;
								$totaltime = round( $endtime - $db_starttime, 5 );
								return $totaltime;
				}

				public function writeCache( $cache_filename, $cacheData )
				{
								$CacheFileHeader = "<?php\n//kDB cache file, DO NOT modify me!\n//Created on ";
								$CacheFileFooter = "\n?>";
								$writeData = var_export( $cacheData, true );
								$writeData = "\$CacheData = ".$writeData.";";
								$writeData = $CacheFileHeader.date( "F j, Y, H:i" )."\n\n".$writeData.$CacheFileFooter;
								if ( $fp = fopen( $cache_filename, "w" ) )
								{
												fwrite( $fp, $writeData );
												fclose( $fp );
								}
								else
								{
												exit( "<b>kDB error:</b> Unable to write cache file : <b>".$cache_filename."</b>" );
								}
				}

}

class DBRecordSet extends mysql
{

				public function DBRecordSet( &$mysql )
				{
								$this->fields = $mysql->fields;
								$this->FetchMode = $mysql->FetchMode;
								$this->debug = $mysql->debug;
								$this->cache_dir = $mysql->cache_dir;
				}

				public function &fetch_array( &$result, $MODE = MYSQL_ASSOC )
				{
								if ( $this->isCached_ExecuteRecord )
								{
												if ( !empty( $result ) )
												{
																$return = array_shift( $result );
																return $return;
												}
												else
												{
																return false;
												}
								}
								else
								{
												if ( $MODE == MYSQL_ASSOC )
												{
																$Query = mysql_fetch_array( $result, MYSQL_ASSOC );
												}
												else if ( $MODE == MYSQL_NUM )
												{
																$Query = mysql_fetch_array( $result, MYSQL_NUM );
												}
												else
												{
																$Query = mysql_fetch_array( $result );
												}
												return $Query;
								}
				}

				public function MoveNext( )
				{
								if ( $this->FetchMode == "num" )
								{
												if ( $this->fields = $this->fetch_array( $this->result, MYSQL_NUM ) )
												{
																$this->EOF = 0;
												}
												else
												{
																$this->EOF = 1;
																$this->free_result( $this->result );
												}
								}
								else if ( $this->FetchMode == "assoc" )
								{
												if ( $this->fields = $this->fetch_array( $this->result, MYSQL_ASSOC ) )
												{
																$this->EOF = 0;
												}
												else
												{
																$this->EOF = 1;
																$this->free_result( $this->result );
												}
								}
								else if ( $this->fields = $this->fetch_array( $this->result ) )
								{
												$this->EOF = 0;
								}
								else
								{
												$this->EOF = 1;
												$this->free_result( $this->result );
								}
				}

				public function FieldCount( )
				{
								if ( $this->result )
								{
												return mysql_num_fields( $this->result );
								}
								else
								{
												return false;
								}
				}

				public function setCharset( $charset )
				{
								$this->charset = $charset;
				}

}

?>
