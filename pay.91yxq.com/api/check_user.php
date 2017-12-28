<?php
function get_curl($url) {      
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL,$url);     
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);     
		$result = curl_exec($ch);        
		curl_close($ch);
		unset($ch);      
		return $result;    
}
	
$user_name = urldecode(trim($_GET['user_name']));
$act = $_GET['act'];
if ( $act =='check_user' && $user_name!='' ) {
	 $userid    = get_curl("http://api.91yxq.com/api/get_userid.php?user_name=".urlencode(strtolower($user_name)));
	 if ( $userid > 0 ) {
	      echo "ok";exit;
	 } else {
	      echo "no";exit;
	 } 
} else {
     echo "no";exit;
}
?>