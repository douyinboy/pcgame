<?php
	//获取玩家游戏内角色等级
	$user_name = strip_tags(trim($_REQUEST['user_name']));
	$serverid = $_REQUEST['serverid'] + 0;
	$game_id = $_REQUEST['game_id'] + 0;
	
	if(!$user_name || !$serverid || !$game_id){
		exit('parameter error');
	}

	function get_curl($url) {      
                        $ch = curl_init();    
                        curl_setopt($ch, CURLOPT_URL,$url);     
                        curl_setopt($ch, CURLOPT_HEADER, 0);    
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);     
                        $result = curl_exec($ch);        
                        curl_close($ch);
                        unset($ch);      
                        return $result;    
        }
		
	function get_userid($user_name){
            $userid = get_curl("http://api.91yxq.com/api/get_userid.php?user_name=".urlencode(strtolower($user_name)));
            if ( $userid ) {
                return $userid;
            } else {
                return false;
            }
	}
	$t = '';
	switch($game_id){
		case 28:
			$t = 'jxtcj_role';
			break;
		default:
			$result = 'no';
			break;
	}	
	
	function jxtcj_role($serverid,$user_name){
			$key = 'NzY2rIiIDingZ2liuanNmdDnvZ2lu$hwan';
			$post = array();
			$post['platform'] = '91yxq';
			$post['gkey'] = '9x';
			$post['uid'] = get_userid($user_name);
			$post['time'] = time();
			$post['skey'] = 's'.$serverid;
			$post['sign'] = md5($post['uid'].$post['platform'].$post['gkey'].$post['skey'].$post['time'].'#'.$key);
			$url='http://s'.$serverid.'.9x.gate.91yxq.com/checkuser.html?'.http_build_query($post);
			$res2 = file_get_contents($url);
			$res = json_decode($res2,true);
			if ($res['errno'] == 0) {
                $result = $res['data'][0]['level'];
            } else {
                $result='no';
            }
			return $result;
		}
	if($t != ''){
		$result = $t($serverid,$user_name);
	}
	if($result == 'no'){
		exit('未获取到角色等级');
	}else{
		exit($result);
	}
?>