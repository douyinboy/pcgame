<?php
 /**================================
  *系统管理模块（sysmanage）
  * 该模块的权限开放给所有登录玩家
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class sysmanageAction extends Action{
    //管理首页
    public function index(){
        
    }
    //获取公会信息
    public function myInfo(){
       $this ->model ->setTable(GUILDINFO);
       $this ->model ->setKey('id');
       $info = $this ->model ->getOneRecordByKey($this ->adminfo['uid']);
       $this ->smarty ->assign('info', $info);
    }
    
    //json返回平台服务器列表
    public function  getServers(){
        $res = array();
        $res[] = array('0', "请选择");
        $getData = getRequest();
        if($getData['game_id'] > 0){
           $w = array('is_open' =>1);
           $servers = parent::getGameServers($getData['game_id'], $w); 
           if(count($servers) > 0){
               foreach($servers as $v){
                   array_push($res, array($v['server_id'], $v['name']));
               }
           }  
        }
        echo json_encode($res);
        exit();
    }
    //json返回指定公会成员列表
    public function  getMembers(){
        $res = array();
        $res[] = array('0', "请选择");
        $getData = getRequest();
        $agentid = $getData['agentid'];
        if($agentid > 0 && is_array($this ->guildlist[$agentid])){
           $w = array('state' =>1);
           $members = parent::getGuildMembers($this ->guildlist[$agentid], $w); 
           if(count($members) > 0){
               foreach($members as $v){
                   array_push($res, array($v['site_id'], $v['author']));
               }
           }  
        }
        echo json_encode($res);
        exit();
    }
    
    //修改管理者个人资料及密码
    public function cmdata(){
        //$getData = checkRData($_POST);
        $this ->model ->setTable(GUILDMEMBER);
        $this ->model ->setKey('site_id');
        $postData = getPost();
        if($postData['account']){
            $field = array();
            $field['site_id'] = $this ->adminfo['uid'];
            if($postData['newpass'] !=''){
                if($postData['newpass'] != $postData['newpassagain'])
                    ajaxReturn(C('Error:PassNoSame'), 300);
                $field['aPass'] = $postData['newpass'];
                $this ->model ->upRecordByKey($field);
            }
            ajaxReturn(C('Ok:Update'), 200);
        }
        $data = $this ->model ->getOneRecordByKey($this ->adminfo['uid']);
        $this ->smarty ->assign('data', $data);
    }
    //加载左边栏
    public function leftMenu(){
        global $getData;
        include(DATA_DIR . 'grantlist.php');
        //过滤权限
        $userGrants = array();
        foreach($allGrants as $key =>$v){
            if($this ->admgrantkeys == 'all' || in_array($v['key'],$this ->admgrantkeys)){
                array_push($userGrants, $v);
            }
        }
        $topMenu = $this ->getUserTopMenu($userGrants);
        $leftMenu = array();
        if(count($topMenu) > 0){
            $topInfo = array();
            if(isset($getData['tid'])){
                 foreach($topMenu as $val){
                     if($val['key'] == $getData['tid'])
                        $topInfo = $val;
                 }              
            }else{
                 $topInfo = $topMenu[0];
            }
            if(isset($topInfo['key'])){
                $leftMenu = $this ->getUserLeftMenu($topInfo, $userGrants);
            }else{
                if(isAjax())
                    ajaxReturn( C('Error:AccountUnnormal'), 300 );
            }
        }
        $this ->smarty ->assign('theModule', $topInfo);
        $this ->smarty ->assign('topMenu', $topMenu);
        $this ->smarty ->assign('leftMenu', $leftMenu);
    }    
    //获取用户左边菜单栏
    private function getUserLeftMenu($topInfo, $userGrants){
        $leftMenu = array();
        foreach($userGrants as $val){
            if(floor(($val['key'] - $topInfo['key'])/1000) == 0 && $val['key'] != $topInfo['key'])
                array_push($leftMenu, $val);
        }
        //划分等级
        $data = $this ->divideGrade($leftMenu);
        return $data;
    }
    //划分权限等级
    private function divideGrade($userLeftMenu, $data = array()){
        $data = array();
         foreach($userLeftMenu as $val){
            if(fmod(($val['key']), 100) == 0){
                foreach($userLeftMenu as $v){
                    $c = $v['key'] - $val['key'];
                    if(($c) >0 && ($c) <10)
                       $val['sonfunc'][$v['key']] = $v;
                    if(($c) >=10 && ($c) <100)
                        if(fmod($c, 10) == 0)
                            $val['sondir'][$v['key']] = $v;
                        else
                            $val['sondir'][floor($v['key']/10)*10]['sonfunc'][] = $v;
                }
                $data[$val['key']] = $val;
            }
        }
        return $data;
    }
    //获取用户顶部导航
    private function getUserTopMenu($userGrants){
        $topMenu = array();
        foreach($userGrants as $val){
            if(fmod($val['key'], 1000)==0)
                array_push($topMenu, $val);
        }
        return $topMenu;
    }
}