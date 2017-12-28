<?php
require_once('../common/common.php');
include('include/isLogin.php');
$stage=trim($_POST['stage']);
if($stage=='info'){
    $username=trim($_POST['user_name']);
    $t=time();
    if(empty($username)){
        $error='玩家帐号不能为空';
    } else {
        $infos = getUserInfo($username);
        if($infos['uid'] >0){
            $error=$username.'已被人肉出来';
            $logs = array();
            $sql="select * from ".WWWPLAT.".".USERLOGS." where username='{$infos['user_name']}' and log_type>0 order by log_time desc";
            $logs=$db->find($sql);
        } else {
            $error='查询失败';
        }
    }
}
$acts=array(0=>'登陆帐号',1=>'<font color="#436EEE">完善资料</font>',2=>'<font color="red">修改密码</font>',3=>'<font color="#8F8F8F">找回密码</font>',4=>'<font color="#9400D3">身份认证</font>',5=>'<font color="greed">帐号锁定</font>',6=>'<font color="green">密保问题</font>',7=>'<font color="#FF00FF">封停账号</font>',8=>'<font color="red">手机绑定</font>',9=>'<font color="red">邮箱绑定</font>');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>查询用户资料</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?> 
</HEAD>
<BODY>
<DIV align=center>
    <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=400 style="border-width:0;margin:100px 300px;">
  <TBODY>
  <TR>
    <TD vAlign=top>
      <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
        <TBODY>
        <TR>
          <TD vAlign=top>
         <div align="center"><font color="red"><?=$error?></font></div>
         <?php if($infos || $logs){ ?>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
              <TBODY>
                <TR class=trEven>
                    <TD>玩家帐号(ID)：</TD>
                    <TD><?=$infos['user_name']?>(<?=$infos['uid']?>)</TD>
                </TR>
                <TR class=trEven>
                    <TD>注册时间：</TD>
                    <TD><?=date("Y-m-d H:i:s",$infos['reg_time'])?></TD>
                </TR>
                <TR class=trEven>
                    <TD>邮箱：</TD>
                    <TD><?=$infos['email']?></TD>
                </TR>
                <TR class=trEven>
                    <TD>密保问题：</TD>
                    <TD><?=empty($infos['question']) ? "---":$infos['question']?></TD>
                </TR>
                <TR class=trEven>
                    <TD>密保答案：</TD>
                    <TD><?=empty($infos['answer']) ? "---":$infos['answer']?></TD></TR>
                <TR class=trEven>
                    <TD>真实姓名：</TD>
                    <TD><?=$infos['true_name']?></TD>
                </TR>
              <TR class=trEven>
                <TD>身份证号：</TD>
                <TD><?=$infos['id_card']?></TD>
              </TR>
              <TR class=trEven>
                <TD>操作记录：</TD>
                <TD align='left'>
                <?php foreach($logs as $v){
                        if($v['log_state']==1){
                            $memo=$v['memo'];
                            if(mb_strlen($memo,'utf8')==strlen($str) && $v['log_type']==3){
                                $memo='(邮箱找回密码:邮件发送成功)';
                            } else if($memo!='') {
                                $memo='('.$memo.')';
                            }
                            $state='<font color="green">成功</font>'.$memo;
                        } else {
                            $memo=$v['memo'];
                            if(mb_strlen($memo,'utf8')==strlen($str) && $v['log_type']==3){
                                    $memo='(邮箱找回密码:邮件发送失败)';
                            } else if($memo!='') {
                                $memo='('.$memo.')';
                            }
                            $state='<font color="red">失败</font>'.$memo;                       
                        }
                        echo $v['log_time'].' &nbsp;'.$acts[$v['log_type']].' &nbsp;'.$state.' &nbsp;(ip:'.$v['log_ip'].')<br>';
                   }
                  ?>
                   </TD></TR>
              </TBODY>
              </TABLE>
         <?php } else { ?>
            <TABLE class=table_list_auto border=0 cellSpacing=1 cellPadding=3>
                <form action="" name="myform" id="myform" method="post">
                    <INPUT value="info" type="hidden" name="stage"> 
                        <TBODY>
                            <TR class=trEven>
                            <TD colspan="2" align="center"><font color=blue>查询玩家资料</font></TD>
                            </TR>
                          <TR class=trEven>
                            <TD>玩家帐号：</TD>
                            <TD><INPUT name="user_name" id="user_name" ></TD></TR>  
                          <TR class=trEven>
                            <TD>&nbsp;</TD>
                            <TD align=center><INPUT value="人肉搜索" type="submit" name="sub"></TD>
                          </TR>
                        </TBODY>
              </form>
              </TABLE>
  	    <?php } ?>
        </TABLE></TD></TR></TBODY></TABLE></DIV></BODY></HTML>
