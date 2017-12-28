<?php
switch($_REQUEST['do']){
	case "passwd":   //密码修改
		 $re=$mysqli->query("select uid,id,user_pwd from ".usertab($_POST['username'])." where user_name='".$_POST['username']."'")->fetch_assoc();
		 $oldpwd=md5($re['uid'].$_POST['passwd']);
		  if($re['user_pwd']!=$oldpwd){
		      echo 'no';exit;
		  } else {
			  $newpwd=md5($re['uid'].$_POST['newpw']);
			  $back = $mysqli->query("update ".usertab($_POST['username'])." set user_pwd='".$newpwd."' where id='".$re['id']."'");
			  if(! $back){
				  echo 'no';exit;
			   }else{
				   $info="uid=".$re['uid']."&newpwd=".$newpwd;
				   $result=long_login_bbs($info,"pwd");
				  echo 'ok';exit;
			  }
		 }
	break;
	case "state":   //帐号状态 封停，锁定，防老板
		if($_POST['type']=='flb'){
			$re=$mysqli->query("update ".usertab($_POST['username'])." set defendboss='".$_POST['defendboss']."',state='".$_POST['state']."' where user_name='".$_POST['username']."'");
		} else {
			$re=$mysqli->query("update ".usertab($_POST['username'])." set state='".$_POST['state']."' where user_name='".$_POST['username']."'");
		}
		//$rc = mysql_affected_rows();
		if($re){
			echo 'ok';exit;
		}else{
			echo 'no';exit;
		}
	break;
	case "edit":  //通用信息更新
                //$arr=$_POST;
                $arr=unserialize(str_replace('\\','',$_POST['info']));
                $field_str='';
                $i=0;
                foreach($arr as $field=>$val){
                        if(!in_array($field,array('sex','nick_name','true_name','question', 'answer', 'id_card', 'user_pwd', 'email', 'integral','state', 'qq', 'birthday', 'mobile','userPayPw','money_plat','ptb_open')) || !$val){ continue; }
                        if($i>0){ $field_str.=','; }
                        $field_str.=$field."='$val'";
                        $i++;
                }
                $rc=$mysqli->query("update ".usertab($_POST['username'])." set $field_str where user_name='".$_POST['username']."'");
                if($rc<=0){
                        echo 'no';exit;
                }else{
                        echo 'ok';exit;
                }
	break;
	case "game_login_log":  //游戏登陆日志
		$u_obj = new users();
        $u_obj->updateGameLogin($_POST['game_id'],$_POST['server_id'],$_POST['username'],$_POST['ip'],'');//玩家登录日志
        echo 'ok';exit;
	break;
}
?>
