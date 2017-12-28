<?php
class SoapOAS
{

				public $server_address = NULL;
				public $Version = "1.5";
				public $SoapDataforSend = "";
				public $DataEncode = true;
				public $TransactionID = "";
				public $TransactionAccessKey = "";
				public $doLog = false;
				public $logFile = "oas.log.txt";
				public $Response = array( );
				public $ReqCharset = "utf8";
				public $RespCharset = "utf8";
				public $errorCode = 0;
				public $ActionRespData = "";
				public $transferEncrypt = false;
				public $OASID = 0;
				public $OASUID = null;

				public function SoapOAS( $server_address )
				{
								$this->server_address = $server_address;
								$this->ActionReqTpl = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><SOAP-ENV:Envelope  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:SOAP-ENC=\"http://schemas.xmlsoap.org/soap/encoding/\"><SOAP-ENV:Header>    <TransactionID xmlns=\"http://www.cmsware.com/passport/schemas/\">{TransactionID}</TransactionID>    <TransactionAccessKey xmlns=\"http://www.cmsware.com/passport/schemas/\">{TransactionAccessKey}</TransactionAccessKey>    <TransactionEncrypt xmlns=\"http://www.cmsware.com/passport/schemas/\">{TransactionEncrypt}</TransactionEncrypt><TransactionOASID xmlns=\"http://www.cmsware.com/passport/schemas/\">{OASID}</TransactionOASID><TransactionOASUID xmlns=\"http://www.cmsware.com/passport/schemas/\">{OASUID}</TransactionOASUID></SOAP-ENV:Header><SOAP-ENV:Body><ActionReq xmlns=\"http://www.cmsware.com/passport/schemas/\"><Version>".$this->Version."</Version>"."<Encoding>{Encoding}</Encoding>"."<Action>{Action}</Action>"."<Params>{Params}</Params>"."<ReqCharset>{ReqCharset}</ReqCharset>"."<RespCharset>{RespCharset}</RespCharset>"."</ActionReq>"."</SOAP-ENV:Body>"."</SOAP-ENV:Envelope>";
				}

				public function call( $action, $params = NULL )
				{
								$this->SoapDataforSend = $this->ActionReqTpl;
								$this->SoapDataforSend = str_replace( "{TransactionID}", $this->TransactionID, $this->SoapDataforSend );
								$this->SoapDataforSend = str_replace( "{TransactionAccessKey}", $this->oas_encode( $this->TransactionAccessKey ), $this->SoapDataforSend );
								$this->SoapDataforSend = str_replace( "{Action}", $action, $this->SoapDataforSend );
								$this->SoapDataforSend = str_replace( "{OASID}", $this->OASID, $this->SoapDataforSend );
								$this->SoapDataforSend = str_replace( "{OASUID}", $this->OASUID, $this->SoapDataforSend );
								if ( $this->transferEncrypt )
								{
												$this->SoapDataforSend = str_replace( "{TransactionEncrypt}", "1", $this->SoapDataforSend );
								}
								else
								{
												$this->SoapDataforSend = str_replace( "{TransactionEncrypt}", "0", $this->SoapDataforSend );
								}
								$this->SoapDataforSend = str_replace( "{ReqCharset}", $this->ReqCharset, $this->SoapDataforSend );
								$this->SoapDataforSend = str_replace( "{RespCharset}", $this->RespCharset, $this->SoapDataforSend );
								if ( !empty( $params ) && is_array( $params ) )
								{
												foreach ( $params as $key => $var )
												{
																if ( $this->DataEncode )
																{
																				$tmp .= "<{$key}>".base64_encode( $this->oas_encode( $var ) )."</{$key}>\n";
																}
																else
																{
																				$tmp .= "<{$key}>".$this->oas_encode( $var )."</{$key}>\n";
																}
												}
								}
								if ( $this->DataEncode )
								{
												$this->SoapDataforSend = str_replace( "{Encoding}", 1, $this->SoapDataforSend );
								}
								else
								{
												$this->SoapDataforSend = str_replace( "{Encoding}", 0, $this->SoapDataforSend );
								}
								$this->SoapDataforSend = str_replace( "{Params}", $tmp, $this->SoapDataforSend );
								return $this->sendSoapData( $this->SoapDataforSend );
				}

				public function setTransactionID( $TransactionID )
				{
								$this->TransactionID = $TransactionID;
				}

				public function setTransactionAccessKey( $TransactionAccessKey )
				{
								$this->TransactionAccessKey = $TransactionAccessKey;
								$this->publicKey = $TransactionAccessKey;
				}

				public function setOASID( $_oasid )
				{
								$this->OASID = $_oasid;
				}

				public function setOASUID( $_oasuid )
				{
								$this->OASUID = $_oasuid;
				}

				public function setDataEncode( $_encode = true )
				{
								$this->DataEncode = $_encode;
				}

				public function setLog( $_dolog = true )
				{
								$this->doLog = $_dolog;
				}

				public function setLogFile( $_logfile )
				{
								$this->logFile = $_logfile;
				}

				public function setReqCharset( $_ReqCharset )
				{
								$this->ReqCharset = $_ReqCharset;
				}

				public function setRespCharset( $_RespCharset )
				{
								$this->RespCharset = $_RespCharset;
				}

				public function setPublicEncryptKey( $_key )
				{
				}

				public function setTransferEncrypt( $_how = true )
				{
								$this->transferEncrypt = $_how;
				}

				public function oas_encode( $str )
				{
								if ( $this->transferEncrypt )
								{
												return oas_encrypt( $str, $this->publicKey );
								}
								return $str;
				}

				public function oas_decode( $str )
				{
								if ( $this->transferEncrypt )
								{
												return oas_decrypt( $str, $this->publicKey );
								}
								return $str;
				}

				public function getErrorCode( )
				{
								return $this->errorCode;
				}

				public function getResponse( )
				{
								return $this->Response;
				}

				public function sendSoapData( &$SoapData )
				{
								$info = parse_url( $this->server_address );
								$port = empty( $info['port'] ) ? 80 : $info['port'];
								$host = $info[host];
								$path = $info[path];
								$msg = "POST {$path} HTTP/1.0\r\n"."Host: {$host}\r\n"."Content-Type: application/x-www-form-urlencoded\r\n"."Content-Length: ".strlen( $SoapData )."\r\n\r\n";
								$ActionRespData = "";
								$f = fsockopen( $host, $port, $errno, $errstr, 1 );
								if ( $f )
								{
												fputs( $f, $msg.$SoapData );
												while ( !feof( $f ) )
												{
																$ActionRespData .= fread( $f, 32000 );
												}
												fclose( $f );
								}
								if ( $this->doLog )
								{
												$this->LogData( $msg.$SoapData."\r\n\r\n\r\n".$ActionRespData );
								}
								$this->ActionRespData = $ActionRespData;
								$this->parseActionResp( $ActionRespData );
								if ( $this->Response['TransactionID'] != $this->TransactionID )
								{
												$this->errorCode = SOAP_Response_TransactionID_Error;
												return false;
								}
								else if ( $this->Response['hRet'] != SOAP_OK )
								{
												$this->errorCode = $this->Response['hRet'];
												return false;
								}
								else
								{
												return $this->Response['Return'];
								}
				}

				public function parseActionResp( &$str )
				{
								preg_match( "/<TransactionID[^>]+>(.*)<\\/TransactionID>/isU", $str, $TransactionIDMatch );
								$this->Response['TransactionID'] = $TransactionIDMatch[1];
								if ( preg_match( "/<ActionResp[^>]+>(.*)<\\/ActionResp>/isU", $str, $match ) )
								{
												preg_match( "/<Version>(.*)<\\/Version>/isU", $match[1], $VersionMatch );
												$this->Response['Version'] = $VersionMatch[1];
												preg_match( "/<hRet>(.*)<\\/hRet>/isU", $match[1], $hRetMatch );
												$this->Response['hRet'] = $hRetMatch[1];
												preg_match( "/<FeatureStr>(.*)<\\/FeatureStr>/isU", $match[1], $FeatureStrMatch );
												$this->Response['FeatureStr'] = $FeatureStrMatch[1];
												preg_match( "/<Encoding>(.*)<\\/Encoding>/isU", $match[1], $EncodingMatch );
												$this->Response['Encoding'] = $EncodingMatch[1];
												if ( preg_match( "/<Return>(.*)<\\/Return>/isU", $match[1], $ReturnMatch ) )
												{
																if ( preg_match_all( "/<([^>]+)>([^><]*)<\\/([^>]+)>/isU", $ReturnMatch[1], $matches ) )
																{
																				foreach ( $matches[0] as $key => $var )
																				{
																								if ( $this->Response['Encoding'] == "1" )
																								{
																												$this->Response['Return'][$matches[1][$key]] = $this->oas_decode( base64_decode( $matches[2][$key] ) );
																								}
																								else
																								{
																												$this->Response['Return'][$matches[1][$key]] = $this->oas_decode( $matches[2][$key] );
																								}
																				}
																}
																return false;
												}
								}
								else
								{
												return false;
								}
				}

				public function LogData( $data )
				{
								if ( $handle = fopen( $this->logFile, "a" ) )
								{
												fwrite( $handle, "- - - - - - - - - - - - - - - -\r\n".$data."\r\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ".date( "Y-m-d H:i:s" )." \r\n\r\n\r\n" );
												fclose( $handle );
								}
				}

				public function unserialize( $_data )
				{
								return unserialize( $_data );
				}

				public function error( )
				{
								trigger_error( "ActionReq Error : [".$this->errorCode."] ".$this->Response['FeatureStr'], E_USER_WARNING );
				}

}

function oas_encrypt( $txt, $key )
{
				srand( ( double )microtime( ) * 1000000 );
				$encrypt_key = md5( rand( 0, 32000 ) );
				$ctr = 0;
				$tmp = "";
				$i = 0;
				for ( ;	$i < strlen( $txt );	++$i	)
				{
								$ctr = $ctr == strlen( $encrypt_key ) ? 0 : $ctr;
								$tmp .= $encrypt_key[$ctr].( $txt[$i] ^ $encrypt_key[$ctr++] );
				}
				return base64_encode( oas_key( $tmp, $key ) );
}

function oas_decrypt( $txt, $key )
{
				$txt = oas_key( base64_decode( $txt ), $key );
				$tmp = "";
				$i = 0;
				for ( ;	$i < strlen( $txt );	++$i	)
				{
								$md5 = $txt[$i];
								$tmp .= $txt[++$i] ^ $md5;
				}
				return $tmp;
}

function oas_key( $txt, $encrypt_key )
{
				$encrypt_key = md5( $encrypt_key );
				$ctr = 0;
				$tmp = "";
				$i = 0;
				for ( ;	$i < strlen( $txt );	++$i	)
				{
								$ctr = $ctr == strlen( $encrypt_key ) ? 0 : $ctr;
								$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
				}
				return $tmp;
}

define( "SOAP_OK", 0 );
define( "SOAP_UNKNOWN_ERROR", 1 );
define( "SOAP_LOGIC_ERROR", 2 );
define( "SOAP_OAS_IP_Invalid", 4000 );
define( "SOAP_TransactionAccessKey_Error", 4001 );
define( "SOAP_Action_Null", 4002 );
define( "SOAP_Action_NotRegistered", 4003 );
define( "SOAP_Action_NotExists", 4004 );
define( "SOAP_Response_TransactionID_Error", 4005 );
define( "SOAP_DB_ERROR", 9000 );
?>
