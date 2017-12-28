<?php
function parse_incoming( )
{
				global $_GET;
				global $_POST;
				global $HTTP_CLIENT_IP;
				global $REQUEST_METHOD;
				global $REMOTE_ADDR;
				global $HTTP_PROXY_USER;
				global $HTTP_X_FORWARDED_FOR;
				$return = array( );
				reset( $_GET );
				reset( $_POST );
				if ( is_array( $HTTP_GET_VARS ) )
				{
								while ( list( $k, $v ) = each( $HTTP_GET_VARS ) )
								{
												if ( is_array( $HTTP_GET_VARS[$k] ) )
												{
																do
																{
																				if ( list( $k2, $v2 ) = each( $HTTP_GET_VARS[$k] ) )
																				{
																								$return[$k][clean_key( $k2 )] = clean_value( $v2 );
																				}
																} while ( 1 );
												}
												else
												{
																$return[$k] = clean_value( $v );
												}
								}
				}
				if ( is_array( $HTTP_POST_VARS ) )
				{
								while ( list( $k2, $v2 ) = each( $HTTP_GET_VARS[$k] ) )
								{
												if ( is_array( $HTTP_POST_VARS[$k] ) )
												{
																do
																{
																				if ( list( $k, $v ) = each( $HTTP_POST_VARS ) )
																				{
																								$return[$k][clean_key( $k2 )] = clean_value( $v2 );
																				}
																} while ( 1 );
												}
												else
												{
																$return[$k] = clean_value( $v );
												}
								}
				}
				$addrs = array( );
				foreach ( array_reverse( explode( ",", $HTTP_X_FORWARDED_FOR ) ) as $x_f )
				{
								$x_f = trim( $x_f );
								if ( preg_match( "/^\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\$/", $x_f ) )
								{
												$addrs[] = $x_f;
								}
				}
				$addrs[] = $_SERVER['REMOTE_ADDR'];
				$addrs[] = $HTTP_PROXY_USER;
				$addrs[] = $REMOTE_ADDR;
				$return['IP_ADDRESS'] = select_var( $addrs );
				$return['IP_ADDRESS'] = preg_replace( "/^([0-9]{1,3})\\.([0-9]{1,3})\\.([0-9]{1,3})\\.([0-9]{1,3})/", "\\1.\\2.\\3.\\4", $return['IP_ADDRESS'] );
				$return['request_method'] = $_SERVER['REQUEST_METHOD'] != "" ? strtolower( $_SERVER['REQUEST_METHOD'] ) : strtolower( $REQUEST_METHOD );
				$data = explode( ";", $return[op] );
				foreach ( $data as $key => $var )
				{
								$data1 = explode( "::", $var );
								$return["{$data1[0]}"] = $data1[1];
				}
				return $return;
}

function clean_key( $key )
{
				if ( $key == "" )
				{
								return "";
				}
				$key = preg_replace( "/\\.\\./", "", $key );
				$key = preg_replace( "/\\_\\_(.+?)\\_\\_/", "", $key );
				$key = preg_replace( "/^([\\w\\.\\-\\_]+)\$/", "\$1", $key );
				return $key;
}

function clean_value( $val )
{
				if ( $val == "" )
				{
								return "";
				}
				if ( get_magic_quotes_gpc( ) )
				{
								$val = stripslashes( $val );
				}
				return $val;
}

function select_var( $array )
{
				if ( !is_array( $array ) )
				{
								return -1;
				}
				ksort( $array );
				$chosen = -1;
				foreach ( $array as $k => $v )
				{
								if ( isset( $v ) )
								{
												$chosen = $v;
												break;
								}
				}
				return $chosen;
}

function _addslashes( $string )
{
				if ( !$magic_quotes_gpc )
				{
								if ( is_array( $string ) )
								{
												foreach ( $string as $key => $val )
												{
																$string[$key] = _addslashes( $val );
												}
								}
								else
								{
												$string = addslashes( $string );
								}
				}
				return $string;
}

?>
