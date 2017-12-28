<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL ^ E_NOTICE);
define('USER_ACCESS', TRUE);

require(__DIR__ . '/include/common.inc.php');
$username = $_SESSION["login"]["username"];

! $username && echoTurn('', $root_url . 'turn.php?act=login');

$smarty = new Smarty;
$smarty->template_dir = SYS_ROOT . 'template';
$smarty->compile_dir = SYS_ROOT . 'templates_c';
$smarty->left_delimiter = '{%';
$smarty->right_delimiter = '%}';
$smarty->assign('acthelp', 0);
$smarty->assign('actuser', 1);

$act = htmlspecialchars($_GET['act']);

! $act && $act = 'index';

if (! $_SESSION['users']) {
    $info = "username=" . $username;
    $results = long_login($info, time(),'info');
    $_SESSION['users'] = explode('_@@_',$results);
    $shuju23 = $_SESSION['users'][23];
    $shuju24 = $_SESSION['users'][24];
    $shuju25 = $_SESSION['users'][25];
    /***
    1：邮箱    2：昵称   3：真实姓名  4：身份证号码
    5：性别    6：生日   7：省份      8：城市
    9：手机    10：地址  11：密保问题   12：密保答案
    13：qq     14：头像   15：登录ip   16：登录时间
    17：uid    18：论坛id  19：帐号状态(0:封停1:正常2:锁定3:防老板)
    20：防老板标题   21：注册时间  22:用户积分
    23：密保状态  24：手机绑定状态 25：邮箱绑定状态  26：防沉迷验证状态
    27:安全级别  28:资料完善度   29: 支付密码  30:平台币值  31:平台币激活状态（1为激活，0为未激活）
    注意：数据表里原来只有到22的数据  ，现在需要加入29~31的数据，
    因而增加了3条数据（23~25），与实际23~25的数据有冲突 ；
    鉴于此  用     a=b,c=a,c=b  方式替换，注意！
    ***/
    $dc=new DataCheck;

    $_SESSION['users'][27]=1;
    $_SESSION['users'][28]=0;	
    //格式化登录时间
    $_SESSION['users'][16]=date('Y-m-d H:i:s',$_SESSION['users'][16]);	
    //校对密保状态
    if($_SESSION['users'][11] && $_SESSION['users'][12]){
            $_SESSION['users'][23]=1;
            $_SESSION['users'][27]++;
            $_SESSION['users'][28]++;
    } else {
            $_SESSION['users'][23]=0;
    }
    //校对手机绑定状态
    if($dc->chkMobile($_SESSION['users'][9])){
            $_SESSION['users'][24]=1;
            $_SESSION['users'][27]++;
            $_SESSION['users'][28]++;
    } else {
            $_SESSION['users'][24]=0;
    } 
    //校对邮箱绑定状态
    if($dc -> chkEmail($_SESSION['users'][1])){
            $_SESSION['users'][25]=1;
            $_SESSION['users'][27]++;
            $_SESSION['users'][28]++;
    } else {
            $_SESSION['users'][25]=0;
    }

    //校对防沉迷状态
    if(preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$_SESSION['users'][3]) && strlen($_SESSION['users'][3])>5 && check_idcard($_SESSION['users'][4])){
            $_SESSION['users'][26]=1;
            $_SESSION['users'][27]++;
            $_SESSION['users'][28]++;
    } else {
            $_SESSION['users'][26]=0;
    }
    //校对 资料完善度
    if($_SESSION['users'][2]){
            $_SESSION['users'][28]++;
    }
    if($_SESSION['users'][5]){
            $_SESSION['users'][28]++;
    }
    if($_SESSION['users'][6]){
            $_SESSION['users'][28]++;
    }
    if($_SESSION['users'][9]){
            $_SESSION['users'][28]++;
    }
    if($_SESSION['users'][10]){
            $_SESSION['users'][28]++;
    }
    if($_SESSION['users'][13]){
            $_SESSION['users'][28]++;
    }


    $_SESSION['users'][29]=$shuju23;
    $_SESSION['users'][30]=$shuju24;
    $_SESSION['users'][31]=$shuju25;
            //校对支付密码状态
    if($_SESSION['users'][29]){
            $_SESSION['users'][27]++;
            $_SESSION['users'][28]++;
    }
}
$sourcefile = SYS_ROOT . 'source/user_'.$act.'.php';
if (file_exists($sourcefile)) {
   include $sourcefile;
}

$tmpFName = SYS_ROOT . 'template/user_'.$act.'.html';

! file_exists($tmpFName) && $act = 'index';
$smarty->assign('uname',@preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,1}).*#s','$1',$_SESSION['users'][3]));
$smarty->assign('users',$_SESSION['users']);
$smarty->assign('username',$username);
$smarty->assign('act',$act);
$smarty->assign('chinese_title',$chinese_title);
$smarty->assign('image_url',$image_url);
$smarty->assign('pay_url', 'http://pay' . $cookiedomain);
$smarty->assign('root_url', $root_url);
$smarty->assign('company_title', $company_title);
$smarty->assign('icp', $icp);
$smarty->assign('js_url',$js_url);
//$smarty->assign('link_title', $link_title);
$smarty->assign('entrance', $entrance);
$smarty->display('user_'.$act.'.html');

?>