<?php
require_once('../common/common.php');
include('include/isLogin.php');
require_once('include/ip.php');
$question_state=array(1=>'未处理',2=>'正在处理',3=>'已经处理',4=>'等待玩家回复');
$question_type=array(1=>'帐号相关',2=>'充值相关',3=>'游戏相关');
$color_arr=array(1=>'',2=>'green',3=>'blue',4=>'red');
if($_POST['stage']=='yes'){
    $content=trim($_POST['content']);
    if(!empty($content)) {
        $sql="insert into ".WWWPLAT.".".UQUSETION." (qid,loginname,title,content,qtime) values('".$_POST['reqid']."','".$_POST['name']."','Re:".$_POST['retitle']."','".$_POST['content']."',now())";
        $db ->query($sql);
    }
    $sql="update ".WWWPLAT.".".UQUSETION." set state=".$_POST['state']." where id=".$_POST['reqid'];
    $db ->query($sql);
    echo '回复成功！';
}
$f='';
if($_POST['act']=='serach'){
    if($_POST['user_name']) {
        $f.=" and loginname='".$_POST['user_name']."'";
    }
    if($_POST['keyword']) {
        $f.=" and title like '%".$_POST['keyword']."%'";
    }
    if($_POST['state']) {
        $f.=" and state=".$_POST['state'];
    }
    if($_POST['game_id']) {
        $f.=" and game_id=".$_POST['game_id'];
    }
} else {
	$f.=' and state!=3';
}
$sql="SELECT * FROM ".WWWPLAT.".".UQUSETION." WHERE qid=0 $f order by qtime desc";
$question_list = $db->find($sql);
$qid=$_GET['qid'];
if($qid>0){
    $sql="select * from ".WWWPLAT.".".UQUSETION." WHERE id=$qid";
    $ques=$db ->get($sql);
    $sql="select * from ".WWWPLAT.".".UQUSETION." WHERE qid=$qid order by qtime";
    $answer_arr=$db ->find($sql);
}
$sql="SELECT id,name FROM ".PAYDB.".".GAMELIST." where is_open=1 ";
$game_list_arr = $db ->find($sql);
foreach($game_list_arr as $game_list){
	$game_arr[$game_list['id']]=$game_list['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML><HEAD><TITLE>玩家问题</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?>
</HEAD>
<BODY>
<?php 
if($qid>0){
        $QQWry=new QQWry;
        $area ='';
        $ifErr=$QQWry->QQWry($ques['ip']);
        $area=$QQWry->Country."&nbsp;".$QQWry->Local;
?>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
              <TBODY>
              <TR class=trEven>
                <TD>提问玩家：</TD>
                <TD><?=$ques['loginname']?> &nbsp; <?=$ques['qtime']?></TD></TR> 
                <TR class=trEven>
                    <TD>问题标题：</TD>
                    <TD><?=$ques['title']?></TD>
                </TR>
                <TR class=trEven>
                <TD>玩家IP：</TD>
                <TD><?=$ques['ip']?> <?php if($area){ echo iconv("gb2312","utf-8",$area); } ?></TD></TR>
              <TR class=trEven>
                <TD>提问内容：</TD>
                <TD>
                <?php
                    if($ques['username']){ echo '问题帐号：<font color="blue">'.$ques['username'].'</font><br>'; }
                    if($ques['rolename']){ echo '问题角色：<font color="blue">'.$ques['rolename'].'</font><br>'; }
                    if($ques['game_id']){ echo '游戏：<font color="blue">《'.$game_arr[$ques['game_id']].'》 第'.$ques['server_id'].'服</font><br>'; }
                    echo '提问内容：<font color="blue">'.$ques['content'].'</font><br>';
                    if($ques['email']){ echo '联系邮箱：<font color="blue">'.$ques['email'].'</font><br>'; }
                    if($ques['telephone']){ echo '联系电话：<font color="blue">'.$ques['telephone'].'</font><br>'; }
                    if($ques['img']){ echo '截图：<img src="'.INDEX_URL.$ques['img'].'"><br>'; }
                ?>
                   </TD></TR> 
<?php foreach($answer_arr as $awq){ ?>
             <TR class=trEven>
                <TD>回答内容：</TD>
                <TD>
            <?php
                echo '回答者：'.$awq['loginname'].'<br>';
                echo '回答时间：'.$awq['qtime'].'<br>';
                echo $awq['content'].'<br>';
                if($awq['img']){ echo '截图：<img src="'.INDEX_URL.$awq['img'].'"><br>'; }
            ?>
                   </TD>
             </TR> 
<?php } ?>
              </TBODY>
              </TABLE>
<form action="" method="post">
<input type="hidden" name="stage" value="yes"> 
<input type="hidden" name="reqid" value="<?=$ques['id']?>">
<input type="hidden" name="retitle" value="<?=$ques['title']?>"> 
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
<TR class=trEven>
    <TD  rowspan="3">
      回复玩家问题
      </TD>
    <TD  rowspan="3">
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
       <TR class=trEven>
    <TD>
      回答客服：<input type="text" name="name" value="91yxq客服">
      </TD>
</TR>
  <TR class=trEven>
    <TD>
      <textarea name="content" id="content" cols="36" rows="5" class="area"></textarea>
      </TD>
</TR>
  <TR class=trEven>
    <TD>
      <input name="state" value="1" type="radio" <?php if($ques['state']==1){ echo 'checked=checked'; } ?> >未处理<input name="state" value="2" type="radio" <?php if($ques['state']==2){ echo 'checked=checked'; } ?> >正在处理<input name="state" value="3" type="radio" <?php if($ques['state']==3){ echo 'checked=checked'; } ?> >已经处理<input name="state" value="4" type="radio" <?php if($ques['state']==4){ echo 'checked=checked'; } ?> >等待玩家回复
      </TD>
    </TR>
  <TR class=trEven>
    <TD>
      <input name="回答" value="回答" type="submit">
      </TD>
    </TR>
</TABLE>
      </TD>
    </TR>
  </TBODY>
</TABLE>
</form>
<?php } ?>
<p>
<DIV align=left>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
      <FORM id="myform" method="post" name="myform" action="">
      <INPUT id="act" type=hidden name="act" value="serach" >
      <select name="state"><option value="0">全部</option><option value='1' <?php if($_POST['state']==1){ echo 'selected=selected'; } ?> >未处理</option><option value='2' <?php if($_POST['state']==2){ echo 'selected=selected'; } ?> >正在处理</option><option value='3' <?php if($_POST['state']==3){ echo 'selected=selected'; } ?> >已经处理</option><option value='4' <?php if($_POST['state']==4){ echo 'selected=selected'; } ?> >等待玩家提供信息</option></select>
		&nbsp;&nbsp;游戏：
 		<select name="game_id"><option value="0">全部</option><?php foreach($game_arr as $key=>$val){ ?><option value='<?=$key?>' <?php if($_POST['game_id']==$key){ echo 'selected=selected'; } ?>><?=$val?></option> <?php } ?></select>
      &nbsp;&nbsp;玩家帐号：
      <INPUT  value="<?=$_POST['user_name']?>" name="user_name" id="user_name" size=20 >
      &nbsp;&nbsp;标题关键字:
      <INPUT  value="<?=$_POST['keyword']?>" size=15 name="keyword" id="keyword">
        <input class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
		</FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
      玩家问题列表<BR>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1004 height=40>
  <TBODY>
  
  <TR class=table_list_head>
    <TD width="4%" align=middle>序号</TD>
    <TD width="9%" align=middle>玩家帐号</TD>
    <TD width="20%" align=middle>问题标题</TD>
   <TD width="10%" align=middle>所属游戏</TD>
    <TD width="13%" align=middle>提问时间</TD>
 	<TD width="8%" align=middle>问题类型</TD>
    <TD width="8%" align=middle>问题状态</TD>
  </TR>
<?php
foreach($question_list as $val){
?>
  <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
    <TD align=middle><?=$val['id']?></TD>
    <TD align=middle><?=$val['loginname']?></TD>
    <TD align=middle><a href="usersQuestion.php?qid=<?=$val['id']?>"><?=$val['title']?></a></TD>
    <TD align=middle><?=$game_arr[$val['game_id']]?></TD>
 <TD align=middle><?=$val['qtime']?></TD>
 	<TD align=middle><?=$question_type[$val['type']]?></TD>
    <TD align=middle><font color="<?=$color_arr[$val['state']]?>"><?=$question_state[$val['state']]?></font></TD>
  </TR>
  <?php  } ?>
</TBODY></TABLE>
</DIV></BODY></HTML>
