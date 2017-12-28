<?php
require_once('../common/common.php');
include('include/isLogin.php');
$stage=trim($_POST['stage']);
$username=trim($_POST['user_name']);
if($stage=='pwd'){  //修改密码
	$passwd=trim($_POST['passwd']);
	if(empty($username) || empty($passwd)){
            $error='玩家名和新密码不能为空！';
	} else {
            $tab_number=usertab($username);
            $sql="SELECT uid FROM ".USERDB.".".REGCHILDTAB.$tab_number." WHERE user_name='{$username}'";
            $arr_uid=$db ->get($sql);
            if($arr_uid[0] >0){
                $user_uid=$arr_uid[0];
                $user_new_pw=md5($user_uid.md5($passwd));
                $sql="UPDATE ".USERDB.".".REGCHILDTAB.$tab_number." SET user_pwd='{$user_new_pw}' WHERE user_name='{$username}'";
                $db ->query($sql);
                $error='密码修改成功！';
            }else{
                $error='账号不存在，请重新输入！';
            }
	}
}
if($stage=='em'){   //修改邮箱
    $email=trim($_POST['email']);
    if(empty($username) || empty($email)){
        $error='玩家名和邮箱不能为空';
    } else {
        $tab_number=usertab($username);
        $result =mysql_num_rows($db ->query("SHOW TABLES LIKE '".USERDB.".".REGCHILDTAB.$tab_number."'"));
        if($result !=1){
            $error='帐号输入有误，请重新输入！';
        }else{
            $sql=" select uid from ".USERDB.".".REGCHILDTAB.$tab_number." where user_name='".$username."'";
            $uid=$db ->get($sql);
            if($uid['uid'] >0){
                $sql="UPDATE ".USERDB.".".REGCHILDTAB.$tab_number." SET email = '{$email}' WHERE user_name = '{$username}'";
                $db ->query($sql);
                $error='邮箱修改成功！';
            }else{
                $error='账号不存在，请重新输入！';
            }
        }
    }
}
if($stage=='card'){ //修改身份证
    $truename=trim($_POST['truename']);
    $idcard=trim($_POST['idcard']);
    $t=time();
    if(empty($username) || empty($truename) || empty($idcard)){
        $error='玩家名和真实姓名和身份证号不能为空';
    } else {
        $tab_number=usertab($username);
        $sql=" select uid from ".USERDB.".".REGCHILDTAB.$tab_number." where user_name='".$username."'";
        $uid=$db ->get($sql);
        if($uid['uid'] >0){
            $sql="UPDATE ".USERDB.".".REGCHILDTAB.$tab_number." SET true_name = '{$truename}',id_card='{$idcard}' WHERE user_name = '{$username}'";
            $db ->query($sql);
            $error='身份证修改成功！';
        }else{
            $error='账号不存在，请重新输入！';
        }
    }
}
if($stage=='question'){  //密保问题
	$question=trim($_POST['question']);
	$answer=trim($_POST['answer']);
	$t=time();
	if(empty($username) || empty($question) || empty($answer)){
		$error='玩家名和安全问题和问题答案不能为空';
	} else {
            $tab_number=usertab($username);
            $sql=" select uid from ".USERDB.".".REGCHILDTAB.$tab_number." where user_name='".$username."'";
            $uid=$db ->get($sql);
            if($uid['uid'] >0){
                $sql_em="UPDATE ".USERDB.".".REGCHILDTAB.$tab_number." SET question = '{$question}',answer='{$answer}' WHERE user_name = '{$username}'";
                $db ->query($sql_em);
                $error='密保问题修改成功！';
            }else{
                $error='账号不存在，请重新输入！';
            }
	}
}
if($stage=='stop'){  //禁/解玩家账号
	$memo=trim($_POST['memo']);
	$state=intval($_POST['state'])+0;
	$state_arr=array(0=>'封停',1=>'解封');
	$ip=GetIP();
	if(empty($username) || empty($memo)){
		$error='玩家名或备注不能为空';
	} else {
            $tab_number=usertab($username);
            $sql=" select uid from ".USERDB.".".REGCHILDTAB.$tab_number." where user_name='".$username."'";
            $uid=$db ->get($sql);
            if($uid['uid'] >0){
                $result=banUndo($username,$state);
            }
            if($result==1){
                $error='成功'.$state_arr[$state].'玩家帐号：'.$username;
            } else {
                $error=$state_arr[$state]."帐号：".$username." 失败！";
            }
            $sql="insert into ".YYDB.".".OPERATELOG."(user_name,op_date,op_content,ip,url) values('".$_SESSION['uName']."',now(),'".$error."，备注：".$memo."','$ip','http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF']."')";
            $db->query($sql);
            $sql="insert into ".WWWPLAT.".".USERLOGS." (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),7,1,'客服".$_SESSION['uName'].$state_arr[$state]."账号，原因：$memo')";
            $db->query($sql);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>修改用户资料</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?> 
<script type="text/javascript" >
function showtb(tab){
    $("#error").empty();
    for(var i=1;i<6;i++){
        document.getElementById("info"+i).style.display='none';
    }
    document.getElementById("info"+tab).style.display='';
}
</script>
</HEAD>
<BODY>
<DIV align=center>
    <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=400 style="border-width:0;">
  <TBODY>
  <TR>
    <TD vAlign=top>
        <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3 style="margin:100px 300px;">
        <TBODY>
        <TR>
          <TD vAlign=top>
         <div align="center"><font color="red" id="error"><?=$error?></font></div>
         请选择操作类型：<div align="center"><input name="type" type="radio" onClick="showtb(1)">修改密码<input name="type" type="radio" onClick="showtb(2)">修改邮箱<input name="type" type="radio" onClick="showtb(3)">认证资料<br><input name="type" type="radio" onClick="showtb(4)">密保问题<input name="type" type="radio" onClick="showtb(5)">封停帐号</div>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3  id="info1" style="display:">
                <form action="" name="myform" id="myform" method="post">
			  <INPUT value="pwd" type="hidden" name="stage"> 
              <TBODY>
                <TR class=trEven>
                <TD colspan="2" align="center"><font color=blue>修改玩家密码</font></TD>
                </TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name" ></TD></TR>
                  <TR class=trEven>
                <TD>新密码：</TD>
                <TD><INPUT name="passwd" id="passwd" ></TD></TR>        
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="修改玩家密码" type="submit" name="sub"></TD>
              </TR>
              </TBODY>
              </form>
              </TABLE>

            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3 id="info2" style="display:none">
			<form action="" name="myform" id="myform" method="post">
			  <INPUT value="em" type="hidden" name="stage"> 
              <TBODY>
 						<TR class=trEven>
                <TD colspan="2" align="center"><font color=blue>修改玩家邮箱</font></TD>
                </TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name"  ></TD></TR>
                  <TR class=trEven>
                <TD>玩家邮箱：</TD>
                <TD><INPUT name="email" id="email"  ></TD></TR>        
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="修改玩家邮箱" type="submit" name="sub"></TD>
              </TR>
              </TBODY></form></TABLE>
              
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3 id="info3" style="display:none">
			<form action="" name="myform" id="myform" method="post">
			  <INPUT value="card" type="hidden" name="stage"> 
              <TBODY>
 						<TR class=trEven>
                <TD colspan="2" align="center"><font color=blue>修改玩家身份认证资料</font></TD>
                </TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name"  ></TD></TR>
                  <TR class=trEven>
                <TD>玩家姓名：</TD>
                <TD><INPUT name="truename" id="truename"  ></TD></TR> 
 					<TR class=trEven>
                <TD>身份证号码：</TD>
                <TD><INPUT name="idcard" id="idcard"  ></TD></TR>        
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="修改玩家认证资料" type="submit" name="sub"></TD>
              </TR>
              </TBODY>
              </form></TABLE>
              
              <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3 id="info4" style="display:none">
			<form action="" name="myform" id="myform" method="post">
			  <INPUT value="question" type="hidden" name="stage"> 
              <TBODY>
 						<TR class=trEven>
                <TD colspan="2" align="center"><font color=blue>修改玩家密保问题</font></TD>
                </TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name"  ></TD></TR>
                  <TR class=trEven>
                <TD>安全问题：</TD>
                <TD><INPUT name="question" id="question"  ></TD></TR> 
 					<TR class=trEven>
                <TD>问题答案：</TD>
                <TD><INPUT name="answer" id="answer"  ></TD></TR>        
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="修改玩家密保问题" type="submit" name="sub"></TD>
              </TR>
              </TBODY>
              </form></TABLE>
              
               <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3 id="info5" style="display:none">
			<form action="" name="myform" id="myform" method="post">
			  <INPUT value="stop" type="hidden" name="stage"> 
              <TBODY>
 						<TR class=trEven>
                <TD colspan="2" align="center"><font color=blue>封停帐号</font></TD>
                </TR>
               <TR class=trEven>
                <TD></TD>
                <TD><INPUT name="state" value="0" type="radio" checked="checked" >封停<INPUT name="state" value="1" type="radio" >解封</TD></TR>
              <TR class=trEven>
                <TD>玩家帐号：</TD>
                <TD><INPUT name="user_name" id="user_name" ></TD></TR>
               <TR class=trEven>
                <TD>备注：</TD>
                <TD><textarea name="memo" rows="4" cols="18"></textarea></TD></TR> 
              <TR class=trEven>
                <TD>&nbsp;</TD>
                <TD><INPUT value="封停帐号" type="submit" name="sub"></TD>
              </TR>
              </TBODY>
              </form></TABLE>
        </TABLE></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
