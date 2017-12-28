<?php
class Auth
{

				public $session = array( );
				public $sId = NULL;
				public $fromCWPS = false;

				public function Auth( )
				{
								session_start( );
								$this->session =& $_SESSION;
				}

				public function init( )
				{
								global $SYS_ENV;
								$this->cookie_name_sid = $SYS_ENV['CookiePre']."sid";
								$this->sId = isset( $_GET['sId'] ) ? $_GET['sId'] : isset( $_POST['sId'] ) ? $_POST['sId'] : $_COOKIE[$this->cookie_name_sid];
								$this->Ip = $IN['IP_ADDRESS'];
								if ( substr( $this->sId, 0, 6 ) == "CWPS::" )
								{
												$this->sId = substr( $this->sId, 6 );
												$this->fromCWPS = true;
								}
								if ( !$this->isLogin( ) )
								{
												$this->tryLogin( $this->sId, $this->Ip );
								}
				}

				public function isLogin( )
				{
								if ( empty( $this->session['UserID'] ) )
								{
												return false;
								}
								else
								{
												return true;
								}
				}

				public function ActiveCWPSSession( $activeTime )
				{
								global $SYS_ENV;
								if ( time( ) - $this->session['SessionActiveTime'] < $activeTime )
								{
												return true;
								}
								$oas = new SoapOAS( $SYS_ENV['CWPS_Address'] );
								$oas->setTransactionAccessKey( $SYS_ENV['TransactionAccessKey'] );
								$oas->doLog = true;
								$oas->logFile = "oas.log.".date( "Y-m-d" ).".txt";
								$oas->setTransactionID( time( ) );
								$Action = "ActiveSession";
								$params = array(
												"sId" => $this->sId
								);
								$return = $oas->call( $Action, $params );
								if ( $return === false )
								{
												return false;
								}
								else
								{
												$this->session['SessionActiveTime'] = time( );
												return true;
								}
				}

				public function tryLogin( $sId, $ip )
				{
								global $SYS_ENV;
								if ( empty( $sId ) )
								{
												return false;
								}
								$oas = new SoapOAS( $SYS_ENV['CWPS_Address'] );
								$oas->setTransactionAccessKey( $SYS_ENV['TransactionAccessKey'] );
								$oas->doLog = true;
								$oas->logFile = "oas.log.".date( "Y-m-d" ).".txt";
								$oas->setTransactionID( time( ) );
								$Action = "QueryUserSession";
								$params = array(
												"sId" => $sId,
												"Ip" => $ip
								);
								$return = $oas->call( $Action, $params );
								if ( $return === false )
								{
												return false;
								}
								else
								{
												$this->session = $return;
												$this->session['SessionActiveTime'] = time( );
												return true;
								}
				}

				public function login( )
				{
								global $SYS_ENV;
								global $PageInterface;
								$this->goCWPS( $PageInterface['Login'] );
				}

				public function logout( $referer = "" )
				{
								global $SYS_ENV;
								global $PageInterface;
								session_destroy( );
								$this->goCWPS( $PageInterface['Logout'], $referer );
				}

				public function isLoginCWPS( )
				{
								global $SYS_ENV;
								global $PageInterface;
								$this->goCWPS( $PageInterface['IsLogin'] );
				}

				public function goCWPS( $url, $referer = "" )
				{
								if ( empty( $referer ) )
								{
												$port = $_SERVER['SERVER_PORT'] == 80 ? "" : $_SERVER['SERVER_PORT'];
												$referer = "http://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
								}
								$pos = strpos( $url, "?" );
								if ( $pos === false )
								{
												$url = $url."?&referer=OAS::".urlencode( $referer );
								}
								else
								{
												$url = $url."&referer=OAS::".urlencode( $referer );
								}
								header( "Location: {$url}" );
								exit( );
				}

}

?>
