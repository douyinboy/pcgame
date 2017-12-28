<?php
$loginname = $_SESSION["login"]["username"];
if(! $loginname) {
     echoTurn('您还没有登录,请先登录!',$root_url . 'main.php?act=login&href='.path_url_params());
}
$question_state = array(
    '1'=>'未回复',
    '2'=>'正在处理',
    '3'=>'已处理',
);

$qid=trim($_REQUEST['qid']);
	$sql="select count(*) as num from `help_question` where loginname='$loginname'";
	$re = $db->get($sql);
	$total = $re['num'];
	$page=trim($_REQUEST['page'])+0;

	$pagesize=10;
	$pagecount=ceil($total/$pagesize);
	if($page>$pagecount) {
		$page=$pagecount;
	}
	if($page<1) {
		$page=1;
	}

	$begin=($page-1)*$pagesize;
	$sql="select id,title,state,qtime from help_question where loginname='$loginname' and qid=0 order by qtime desc limit $begin,$pagesize";
	$qlist=$db->find($sql);
	foreach($qlist as $k=>$v){
		$qlist[$k]['result']=$question_state[$v['state']];
		$qlist[$k]['xid']=$k+1;
	}
	
	$smarty->assign('qlist',$qlist);
	$smarty->assign('total',$total+0);
	$smarty->assign('page',$page+0);
	$smarty->assign('pagecount',$pagecount+0);
	$smarty->assign('pagesize',$pagesize+0);
	$smarty->assign('username',$_SESSION["login"]["username"]);
?>