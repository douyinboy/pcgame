<?php
class db
{

				public $db = NULL;
				public $charset = NULL;

				public function connect( $params )
				{
								switch ( $params['db_type'] )
								{
								case "mysql" :
												require_once( KDB_DIR."lib/mysql.php" );
												if ( file_exists( KDB_DIR."data/mysql.data.class.php" ) )
												{
																require_once( KDB_DIR."data/mysql.data.class.php" );
												}
												$this->db = new mysql( );
												$this->db->charset = $this->charset;
												return $this->db->connect( $params );
												break;
								case "pgsql" :
												break;
								case "oracle" :
												break;
								case "sqlserver" :
												break;
								}
				}

				public function &Execute( $query, $cache = false )
				{
								$rs =& $this->db->Execute( $query, $cache );
								return $rs;
				}

				public function query( $query )
				{
								return $this->db->query( $query );
				}

				public function fetch_array( $result )
				{
								return $this->db->fetch_array( $result );
				}

				public function getDbVersion( )
				{
								return $this->db->getDbVersion( );
				}

				public function close( )
				{
								return $this->db->db_close( );
				}

				public function getRow( $query, $cache = false )
				{
								return $this->db->getRow( $query, $cache );
				}

				public function errormsg( )
				{
								return $this->db->errormsg( );
				}

				public function Insert_ID( )
				{
								return $this->db->Insert_ID( );
				}

				public function escape_string( $string )
				{
								return $this->db->escape_string( $string );
				}

				public function SetFetchMode( $mode )
				{
								$this->db->SetFetchMode( $mode );
				}

				public function setDebug( $debug )
				{
								$this->db->setDebug( $debug );
				}

				public function info( )
				{
								return $this->db->info( );
				}

				public function errno( )
				{
								return $this->db->errno( );
				}

				public function getTotalQueryTime( )
				{
								return $this->db->TotalQueryTime;
				}

				public function getTotalQueryNum( )
				{
								return $this->db->TotalQueryNum;
				}

				public function getTotalCacheNum( )
				{
								return $this->db->TotalCacheNum;
				}

				public function getQueryLog( )
				{
								return $this->db->QueryLog;
				}

				public function setCacheDir( $cache_dir )
				{
								$this->db->cache_dir = $cache_dir;
				}

				public function setCharset( $charset )
				{
								return $this->db->setCharset( $charset );
				}

				public function getServerInfo( )
				{
								return $this->db->getServerInfo( );
				}

}

?>
