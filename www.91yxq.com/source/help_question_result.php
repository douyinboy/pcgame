<?php

$loginname=$_SESSION["login"]["username"];
// if(!$loginname) {
   	// echoTurn('您还没有登录,请先登录!',$root_url . 'main.php?act=login&forward=help.php?act=question_result');
// }
$qtype_arr=array(1=>'帐号问题',2=>'充值问题',3=>'游戏问题');
$qstate_arr=array(
		'1'=>'未回复',
		'2'=>'正在处理',
		'3'=>'已处理',
);

$qid=trim($_REQUEST['qid']);
$stage=trim($_POST['stage']);
$flage=1;
if($stage=='yes'){

	$result = array();

	if(!$loginname) {
		//echoTurn('您还没有登录,请先登录!',$root_url . 'main.php?act=login&forward=help.php?act=question_result');
		$result['status'] = -1;
		$result['info'] = '您还没有登录,请先登录!';
		$result['location'] = $root_url . 'main.php?act=login&forward='.urlencode('help.php?act=question_result');
		exit(json_encode($result));
	}
	if(empty($qid)){
		//echoTurn('继续提问的问题不存在!',$_SERVER['HTTP_REFERER']);
		$result['status'] = 0;
		$result['info'] = '继续提问的问题不存在';
		exit(json_encode($result));
	}
	$content=htmlspecialchars(trim($_POST['content']));
	$title=htmlspecialchars(trim($_POST['title']));
	if(empty($title) || empty($content)){
		//echoTurn('请填写问题标题与内容',$_SERVER['HTTP_REFERER']);
		$result['status'] = 0;
		$result['info'] = '请填写问题标题与内容';
		exit(json_encode($result));
	}
	$ip=GetIP();
	$sql="insert into `help_question` (qid,title,content,loginname,qtime,ip,rstype) values ('$qid','$title','$content','$loginname',now(),'$ip',1)";
	$upd1 = $db->query($sql);
	$sql="update `help_question` set state = 1 where id= ".$qid;
	$upd2 = $db->query($sql);		
	//echoTurn('问题提交成功!',$root_url . 'help.php?act=question_result&qid='.$qid);
	if( $upd1 !== false && $upd2 !== false  ){
		$result['status'] = 1;
		$result['info'] = '问题提交成功!';
		
		$sql="select * from `help_question` where id=".$qid;
		$qre=$db->get($sql);
		
		if( empty($qre) ){
			$result['status'] = 0;
			$result['info'] = '问题不存在或已被删除';
		}
		elseif($qre['loginname']!=$loginname){
			//echoTurn('您只能查看您自己提问的问题',$root_url . help.php?act=question_result');
			
			$result['status'] = 0;
			$result['info'] = '您只能查看您自己提问的问题';
		} else {
			$qre['qtype']=$qtype_arr[$qre['type']];
			$qre['qstate']=$qstate_arr[$qre['state']];
				
			$sql="select * from help_question where qid=".$qid." order by qtime asc";
			//$are=$db->sql_fetchrowset($db->sql_query($sql));
			$are=$db->find($sql);
			foreach( $are as $key=>$val ){
				$are[$key]['qstate'] = $qstate_arr[$are[$key]['state']];
			}
			
			// $result['status'] = 1;
			// $result['info'] = '查询问题成功';
			$result['qid'] = $qid;
			$result['qre'] = $qre;
			$result['are'] = $are;
			
		}
		
		exit( json_encode($result) );
	}
	else{
		$result['status'] = 0;
		$result['info'] = '数据库错误!';
		exit( json_encode($result) );
	}
}
elseif(!empty($qid)) {
	$result = array();
	if(!$loginname) {
		//echoTurn('您还没有登录,请先登录!',$root_url . 'main.php?act=login&forward=help.php?act=question_result');
		$result['status'] = -1;
		$result['info'] = '您还没有登录,请先登录!';
		$result['location'] = $root_url . 'main.php?act=login&forward='.urlencode('help.php?act=question_result');
		exit(json_encode($result));
	}
	
	/*
	$sql="select * from db_5399_www.help_question where id=".$qid;
	$qre=$db->sql_fetchrowset($db->sql_query($sql));
	if($qre['loginname']!=$loginname){
		echoTurn('您只能查看您自己提问的问题','/help.php?act=question_result');
	} else {
		$qre['qtype']=$qtype_arr[$qre['type']];
			
		$sql="select * from db_5399_www.help_question where qid=".$qid;
		$are=$db->sql_fetchrowset($db->sql_query($sql));
		$i=0;
		
// 		print_r($qre);
	
		$smarty->assign('qre',$qre);
		$smarty->assign('are',$are);	
		$smarty->assign('qid',$qid);	
		$smarty->assign('qstate_arr',$qstate_arr);
	}*/
	
	$sql="select * from `help_question` where id=".$qid;
	$qre=$db->get($sql);
	$result = array();
	if( empty($qre) ){
		$result['status'] = 0;
		$result['info'] = '问题不存在或已被删除';
	}
	elseif($qre['loginname']!=$loginname){
		//echoTurn('您只能查看您自己提问的问题','/help.php?act=question_result');
		
		$result['status'] = 0;
		$result['info'] = '您只能查看您自己提问的问题';
	} else {
		$qre['qtype']=$qtype_arr[$qre['type']];
		$qre['qstate']=$qstate_arr[$qre['state']];
			
		$sql="select * from `help_question` where qid=".$qid." order by qtime asc";
		$are=$db->find($sql);
		foreach( $are as $key=>$val ){
			$are[$key]['qstate'] = $qstate_arr[$are[$key]['state']];
		}
		
		$result['status'] = 1;
		$result['info'] = '查询问题成功';
		$result['qid'] = $qid;
		$result['qre'] = $qre;
		$result['are'] = $are;
		
		

	}
	
	exit( json_encode($result) );
}
else{
	if(!$loginname) {
		echoTurn('您还没有登录,请先登录!',$root_url . 'main.php?act=login');
	}
	//var_dump(file_exists('./include/class/Paging.class.php'));
	include(CLASS_PATH . 'Paging.class.php');
	$flage = 0;
	
	$sql="select count(*) as num from `help_question` where loginname='$loginname'  and qid=0 ";
	$re = $db->get($sql);
	
	$total = $re['num'];
	$page=trim($_REQUEST['page'])+0;
	
	$pagesize=10;
	//$pagecount=ceil($total/$pagesize);
	// if($page>$pagecount) {
		// $page=$pagecount;
	// }
	// if($page<1) {
		// $page=1;
	// }
	$paging = new Paging($total,$page,$pagesize);
	function pagingUrl($pageNo){
                global $root_url;
		return $root_url . "help.php?act=question_result&page=".$pageNo;
	}
	
	//$begin=($page-1)*$pagesize;
	$sql="select id,title,type,state,qtime from `help_question` where loginname='$loginname' and qid=0 order by qtime desc limit ".$paging->limit;//$begin,$pagesize";
	// echo "<pre>";
	// print_r($paging->abbrList('pagingUrl',null,7,1,1));
	// print_r($paging->prevInfo('pagingUrl',null));
	// print_r($paging->nextInfo('pagingUrl',null));
	// echo "</pre>";
	
	$qlist=$db->find($sql);
	foreach($qlist as $k=>$v){
		$qlist[$k]['qstate']=$qstate_arr[$v['state']];
		$qlist[$k]['qtype']=$qtype_arr[$v['type']];
		$qlist[$k]['xid']=$k+1;
	}
	
	$smarty->assign('qlist',$qlist);
	// $smarty->assign('total',$total+0);
	// $smarty->assign('page',$page+0);
	// $smarty->assign('pagecount',$pagecount+0);
	// $smarty->assign('pagesize',$pagesize+0);
	$smarty->assign('pagingList',$paging->abbrList('pagingUrl',null,5,1,1) );
	$smarty->assign('prevPage',$paging->prevInfo('pagingUrl',null) );
	$smarty->assign('nextPage',$paging->nextInfo('pagingUrl',null) );
	$smarty->assign('username',$_SESSION["login"]["username"]);
}
$smarty->assign('flage',$flage);
$smarty->assign('username',$loginname);
?>