<?php
if (!empty($_COOKIE['bbs_place_id1'])) {var_dump(1111);die;
    $agent_id = 10021;
    $placeid = $_COOKIE['bbs_place_id'];
}
var_dump($_COOKIE['bbs_place_id1']);die;
var_dump($_COOKIE);die;
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
include(__DIR__ . '/include/common.inc.php');

$smarty = new Smarty;
$smarty->template_dir = SYS_ROOT . 'template/';
$smarty->left_delimiter = '{%';
$smarty->right_delimiter = '%}';

$smarty->assign('acthelp',1);
$smarty->assign('actuser',0);

$act = htmlspecialchars($_GET['act']);
if( empty($act) ){
	header('Location:' . $root_url . '/help/');
	exit;
}
$sourcefile = SYS_ROOT . 'source/help_'.$act.'.php';
$smarty->assign('last_logintime',$_SESSION['users'][16]);
if( file_exists($sourcefile) ){
   include($sourcefile);
}
$tmpFName = SYS_ROOT.'template/help_'.$act.'.html';
if( !file_exists($tmpFName) ){
	header("Location:{$root_url}/help/");
	exit;
}

$smarty->assign('act',$act);
$smarty->assign('js_url',$js_url);
$smarty->assign('chinese_title',$chinese_title);
$smarty->assign('image_url',$image_url);
$smarty->assign('root_url', $root_url);
$smarty->assign('company_title', $company_title);
$smarty->assign('icp', $icp);
//$smarty->assign('link_title', $link_title);
$smarty->assign('entrance', $entrance);
$smarty->display('help_' . $act . '.html');