<?php
header("Content-type: text/html; charset=utf-8"); 
session_start();
if (!$_SESSION['admin']) {
    $_SESSION = array();
    session_destroy();
    header("Location: ".URL_INDEX."?action=public&opt=login");
    exit;
}
$sql="select gGrants from ".ADMINGROUP." where gId=".$_SESSION['admin']['gId'];
$menu_arr=$db ->get($sql);
if($menu_arr['gGrants'] !='all'){
    $menu_id=0;
    $file_name=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);  //文件名
    $file_str=substr($file_name,0,-4);
    include(DATA_DIR . 'grantlist.php');
    foreach ($allGrants as $v){
        if(!empty($v['menu'])){
            if($file_str ==$v['menu']){
                $menu_id=$v['key'];
                continue;
            }  
        }
    }
    $menuid=unserialize($menu_arr['gGrants']);
    if(!in_array($menu_id, $menuid))
        backError();

}
function  backError(){
    echo "您的权限不够，请联系管理员！";
    exit();
}

?>