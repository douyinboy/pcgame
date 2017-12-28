<?php
//ini_set('display_errors','On');
//error_reporting(E_ALL);

//用于提取游戏信息和服务器信息
//参数 type
//101:返回所有游戏信息
//201：返回指定游戏所有服务器信息
$type    = $_REQUEST["type"] + 0;
$game_id = $_REQUEST["game_id"] + 0;
require(substr(__DIR__, 0, -3) . 'config/gameSvrData.php');
$games   = json_decode($gameData,true);
$servers = json_decode($SvrData,true);
//dump($servers[$game_id]);

if($type == 101){
	$str='<select name="game_id" id="game_id" style="width:90px;" onchange="get_server(this.value);">';
	foreach($games as $key=>$val){
		$str.='<option value="'.$val['gameID'].'">'.$val['nameCn'].'</option>';
	}
	$str.='</select>';
	
	echo $str;
}

if($type == 201){
	if($game_id<0) $game_id=1;
	$str='<select name="server_id" id="server_id" style="width:120px;">';
	if(!is_array($servers[$game_id])){
		$str.='<option value="">请选择服务器</option>';
	}else{
		foreach($servers[$game_id] as $key=>$val){
			$str.='<option value="'.$val['svrID'].'">('.$val['svrID'].'服)'.$val['svrName'].'</option>';
		}
	}
	$str.='</select>';
	
	echo $str;
}



// 浏览器友好的变量输出
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

?>