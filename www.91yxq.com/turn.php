<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL ^ E_NOTICE);

include(__DIR__ . '/include/common.inc.php');
$smarty = new Smarty;
$smarty->template_dir = SYS_ROOT . 'template';
$smarty->compile_dir = SYS_ROOT . 'templates_c';
$smarty->left_delimiter = '{%';
$smarty->right_delimiter = '%}';

$act = htmlspecialchars($_GET['act']);
! $act && $act = 'index';
$sourcefile = SYS_ROOT . 'source/' . $act . '.php';
if (file_exists($sourcefile)) {
    include $sourcefile;
}
$tmpFName = SYS_ROOT . 'template/' . $act . '.html';
! file_exists($tmpFName) && $act = 'index';
$smarty->assign('chinese_title',$chinese_title);
$smarty->assign('image_url',$image_url);
$smarty->assign('pay_url', 'http://pay' . $cookiedomain);
$smarty->assign('root_url', $root_url);
$smarty->assign('company_title', $company_title);
$smarty->assign('icp', $icp);
$smarty->assign('js_url',$js_url);
//$smarty->assign('link_title', $link_title);
if ($act == 'index') {
    echo file_get_contents('index.html');
} else {
    $smarty->display($act.'.html');
}