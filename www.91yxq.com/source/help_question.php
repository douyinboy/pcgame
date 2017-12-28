<?php
$loginname=$_SESSION["login"]["username"];

$getSvrPath = SYS_ROOT . 'config/gameSvrData.php';
if($_REQUEST['gslt'] == 'getSvrLst'){//  获取游戏服务器列表 0 参数缺失；
	
	$gameID = $_REQUEST['gid'] ? $_REQUEST['gid']:die('0');//
	include($getSvrPath);
	$gameData = json_decode($gameData,true);
	$SvrData = json_decode($SvrData,true);
	$svrLstData =  $SvrData[$gameID];
	$svrHtml = '<option value="0" selected="selected">请选择服务器</option>';
	foreach($svrLstData as $val){
		if($val['svrID'] && $val['svrName']){ 
			$svrHtml .= '<option value="'.$val['svrID'].'">'.$val['svrName'].'</option>';
		}
	}
// 	$svrHtml = '<select name="data[server_id]" id="server_id" >'.$svrHtml.'</select>';	

	
	die($svrHtml);	
}
elseif($_POST['stage']=='yes'){
	if(!$loginname) {
		echoTurn('登录超时，您必须登录才能提交问题!',$root_url . '.main.php?act=login&forward='.urlencode('help.php?act=question'));
	}
	$data=$_POST['data'];
	if(trim($data['username'])=='') {
		echoTurn('发生异常情况的帐号不能为空','back');
	}
	if(trim($data['rolename'])=='') {
		echoTurn('发生异常帐号的角色名不能为空','back');
	}
	if(is_numeric($data['server_id'])==0) {
		echoTurn('发生异常所在服务器不能为空','back');
	}
	if(trim($data['title'])=='') {
		echoTurn('问题标题不能为空','back');
	}
	if(trim($data['content'])=='') {
		echoTurn('发生异常问题内容不能为空','back');
	}
	$f=$_FILES['img'];
	if( $f['error'] ==0 && $f['name']!='' ){
		$types=Array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');  //图片类型
		$size=2097152;   //图片大小2M      
		$ym=date('Ym').'/';
		$filepath = dirname( dirname(__FILE__) ) . '/media/upload/'.$ym;	
		if(!file_exists($filepath)){
			mkdir($filepath,0777);
		}   	    
		$arr=explode('.',$f['name']);
		$i=count($arr)-1;
		$t=time();
		$filepath=$filepath.$t.'.'.$arr[$i];
		$img = rtrim($root_url,'/').'/media/upload/'.$ym.$t.'.'.$arr[$i];      
		if($f["size"]>$size){
			echoTurn('图片上传失败,该图片大小超出2M限制!','back');
		} 
		if(!in_array($f["type"],$types)){
			echoTurn('图片上传失败,只能上传图片!','back');
		}
		if(@move_uploaded_file($f["tmp_name"],$filepath)){
			$data['img']=$img;
		} else {
			echoTurn($filepath.'图片上传失败,没有写入权限，请联系管理员。','back');
		}	
	}
	else{
		echoTurn('上传出错,error:'.$f['error'].'.','back');
	}
	$data['loginname']= $loginname;
	$data['qtime']=date('Y-m-d H:i:s');
	$data['ip']=GetIP();
	$i=0;
	foreach($data as $k=>$v){
		if($i==0){
			$field=$k;
			$value="'".htmlspecialchars(trim($v))."'";
		} else {
			$field.=",$k";
			$value.=",'".htmlspecialchars(trim($v))."'";
		}
		$i++;
	}
	
	$sql="insert into help_question ($field) values ($value)";
	if($db->query($sql)){
		echoTurn('问题提交成功,等待客服人员回复!', $root_url . '/help.php?act=question_result');
	}
}
else{
	if(!$loginname) {
		echoTurn('您必须登录才能提交问题!',$root_url . 'main.php?act=login&forward='.urlencode('help.php?act=question'));
	}
	require($getSvrPath);
	$gameData = json_decode($gameData,true);
	$SvrData = json_decode($SvrData,true);
	$smarty->assign('gameData',$gameData);
}
$smarty->assign('username',$loginname);