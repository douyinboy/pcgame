<?php
 /**=====================================
  * 后台访问入口文件
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 公会会长后台管理系统
 ========================================*/
define('ACCESS_GRANT', TRUE);
error_reporting(0);
include("./common/common.php");
$getData = checkRData($_GET);
session_start();
$mUser = $_SESSION['member'];
//执行中转 action参数决定去向文件，opt参数决定调用模块函数
$actionModule = $getData['action'] != '' ? strtolower($getData['action']).'Action' : '';
if(is_action($actionModule)){
    $func = empty($getData['opt'])? 'index' : $getData['opt'];
    include(ACTION_DIR . $actionModule . '.class.php');
    $act = new $actionModule;
    if(!method_exists($act, $func)){
        if(isAjax())
            ajaxReturn(C('Error:404'), 300);
        header("Location: ".URL_INDEX."?action=public&opt=error404");
    }
    if(in_array($getData['action'], $publicModule) || (checkgrant(strtolower($getData['action']), $getData['opt']) && $mUser['uid'] >0)){//权限过滤
        $act ->$func();
        $smarty ->display(strtolower($getData['action'])."/".$func.".html");
    }else{
        if(isAjax())
            ajaxReturn(C("Error:LoginTimeOut"), 301);
        header("Location: ".URL_INDEX."?action=public&opt=login");
    }
}else{
    if(isAjax())
        ajaxReturn(C('Error:LoginRequestModeError'), 300);
    if($mUser['uid'] < 1)
        header("Location: ".URL_INDEX."?action=public&opt=login");
    include(ACTION_DIR . 'sysmanageAction.class.php');
    $act = new sysmanageAction;
    $act ->index();
    $act ->leftMenu();
    $smarty->display('index.html');
}
?>