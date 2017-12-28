<?php
 /**================================
  *综合后台整合【iframe】进来
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会总后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class colligateAction extends Action{
    public function index(){   
        $postData = getRequest(); 
        $url=MANAGE_URL."colligate/".$postData['menu'].".php";
        $this ->smarty ->assign('URL', $url);
    }
}


