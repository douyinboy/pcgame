<?php
class kDB
{

				public $driver_path = "driver/";
				public $Driver = NULL;
				public $connection = NULL;
				public $debug = false;

				public function kDB( $type = NULL )
				{
								$this->driver_path = KDB_DIR.$this->driver_path;
								$this->_regDriver( $type );
				}

				public function _regDriver( $type = NULL )
				{
								$driver = $this->driver_path.$type.".php";
								if ( file_exists( $driver ) )
								{
												include_once( $driver );
												$this->Driver = new $type( );
												return true;
								}
								else
								{
												return false;
								}
				}

				public function getDbVersion( )
				{
								return $this->Driver->getDbVersion( );
				}

				public function connect( $params )
				{
								return $this->Driver->connect( $params );
				}

				public function close( )
				{
								return $this->Driver->close( );
				}

				public function query( $queryStr )
				{
								return $this->Driver->query( $queryStr );
				}

				public function &Execute( $query, $cache = false )
				{
								$rs =& $this->Driver->Execute( $query, $cache );
								return $rs;
				}

				public function selectLimit( $query, $start, $offset )
				{
								return $this->Driver->selectLimit( $query, $start, $offset );
				}

				public function getRow( $res, $cache = false )
				{
								return $this->Driver->getRow( $res, $cache );
				}

				public function getRowsNum( $res )
				{
								return $this->Driver->getRowsNum( $res );
				}

				public function errormsg( )
				{
								return $this->Driver->errormsg( );
				}

				public function Insert_ID( )
				{
								return $this->Driver->Insert_ID( );
				}

				public function escape_string( $string )
				{
								return $this->Driver->escape_string( $string );
				}

				public function SetFetchMode( $mode )
				{
								$this->Driver->SetFetchMode( $mode );
				}

				public function setDebug( $debug )
				{
								$this->debug = $debug;
								$this->Driver->setDebug( $debug );
				}

				public function setCacheDir( $cache_dir )
				{
								$this->Driver->setCacheDir( $cache_dir );
				}

				public function info( )
				{
								return $this->Driver->info( );
				}

				public function errno( )
				{
								return $this->Driver->errno( );
				}

				public function getTotalQueryTime( )
				{
								return $this->Driver->getTotalQueryTime( );
				}

				public function getTotalQueryNum( )
				{
								return $this->Driver->getTotalQueryNum( );
				}

				public function getTotalCacheNum( )
				{
								return $this->Driver->getTotalCacheNum( );
				}

				public function getQueryLog( )
				{
								return $this->Driver->getQueryLog( );
				}

				public function setCharset( $charset )
				{
								return $this->Driver->setCharset( $charset );
				}

				public function getServerInfo( )
				{
								return $this->Driver->getServerInfo( );
				}

}

?>
