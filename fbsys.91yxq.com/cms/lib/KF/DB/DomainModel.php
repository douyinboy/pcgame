<?php
import( "KF.Util.Observable" );
class KF_DB_DomainModel extends KF_Util_Observable
{

				public $_vars = NULL;
				public $_vars_loaded = false;

				public function create( )
				{
				}

				public function update( $IndexID )
				{
				}

				public function del( $IndexID )
				{
				}

				public function get( $IndexID )
				{
				}

				public function updateBy( $params )
				{
				}

				public function delBy( $params )
				{
				}

				public function getBy( $params )
				{
				}

				public function findAll( $params, $start = 0, $end = 0 )
				{
				}

				public function findOne( $params, $kql = "" )
				{
				}

				public function _init( )
				{
								if ( $this->_vars_loaded === true )
								{
												return true;
								}
								$this->_vars = get_object_vars( $this );
								$this->_vars_loaded = true;
								return true;
				}

				public function setVar( $varName, $varValue )
				{
				}

				public function getVar( $varName )
				{
				}

				public function toArray( )
				{
								$return = array( );
								foreach ( $this->_vars as $var )
								{
												if ( substr( $var, 1 ) == "_" )
												{
																continue;
												}
												$return[$var] = $this->$var;
								}
								return $return;
				}

}

?>
