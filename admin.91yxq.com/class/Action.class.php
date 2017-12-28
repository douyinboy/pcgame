<?php
 /**==============================
  * 行为操作基础类
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ===============================*/
ACCESS_GRANT != true && exit('forbiden!');
class Action{
    protected $model;
    protected $smarty;
    protected $adminfo;
    protected $admgrantkeys;
    protected $admgrants;
    protected $guildlist; //管理的公会列表
    public function __construct(){
        global $mUser, $smarty;
        $this ->model = new comModel;
        $this ->smarty = $smarty;
        $this ->adminfo = $mUser;
        $this ->admgrantkeys = $_SESSION['grant_key'];
        $this ->admgrants = $_SESSION['grant_list'];
        $this ->getUserGuildList();
    }
    /*管理员列表*/
    protected function getUserList(){
        $sql=" select * from ".ADMINUSERS." where uLoginState=1 ";
        $rs = $this ->model ->db->find($sql);
        $res = array();
        foreach ($rs as $v){
            $res[$v['uid']]= $v;
        }
        return $res;
    }

    /**
     * 设置用户权限内的公会列表
     */
    protected function getUserGuildList(){
        $this ->model ->setTable(GUILDINFO);
        $this ->model ->fields = array('id', 'agentname', 'user_name','account_name','account','bank','city','bank_son','province','adduid');
        $this ->model ->where['state'] = 1;
        $this ->model ->sort = "";
        $this ->model ->csSql();
        $rs = $this ->model ->find();
        $res = array();
        foreach ($rs as $v){
            $res[$v['id']] = $v;
        }
        $this ->guildlist = $res;
    }
    /**
     * 获取指定公会成员列表
     * @param $p   int  公会信息
     * @return $res  array  返回该公会所有成员信息
     */
    protected function getGuildMembers($p, $w = array()){
        if(!is_array($this ->guildlist[$p['id']])){
            return array();
        }
        $this ->model ->setTable(GUILDMEMBER);
        $this ->model ->fields = array('site_id', 'author', 'aAccount');
        $where = array('agent_id' =>$p['id']);
        $this ->model ->where = array_merge($where, $w);
        $this ->model ->sort = "";
        $this ->model ->csSql();
        $res = $this ->model ->find();
        $data = array();
        foreach($res as $k => $v){
          $data[$v['site_id']] = $v;
        }
        return $data;
    }
    //游戏列表
    protected function getGameList(){
        $sql ="SELECT * FROM ".PAYDB.".".GAMELIST." WHERE is_open=1 ORDER BY gTop DESC";
        $res = $this ->model ->db ->find($sql);
        $data= array();
        foreach($res as $v){
            $data[$v['id']] = $v;
        }
        return $data;
    }

    /** 获取游戏开服列表*/
    protected function getGameServers($id, $w = array()){
        $this ->model ->setTable(PAYDB.'.'.SERVERLIST);
        $this ->model ->fields = array('server_id', 'name');
        $where = array('game_id' =>$id);
        $this ->model ->where = array_merge($where, $w);
        $this ->model ->sort = " server_id DESC ";
        $this ->model ->csSql();
        $res = $this ->model ->find();
        $data = array();
        foreach($res as $k => $v){
          $data[$v['server_id']] = $v;
        }
        return $data;
    }
    /**
     * 检测管理者是否拥有管理该公会权限
     * @param $gid   int  公会ID
     * @return  true or false 
     */
    protected function checkVisitGuildGrant($gid){
        foreach($this ->platlist as $v){
            if($v['id'] == $gid){
                return true;
            }
        }
        return false;
    }
    //根据ip获取地址
    protected function getplace($lastip) {
      $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$lastip;    
      $ch = curl_init($url);     
      curl_setopt($ch,CURLOPT_ENCODING ,'utf8');     
      curl_setopt($ch, CURLOPT_TIMEOUT, 5);   
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
      $location = curl_exec($ch);    
      $location = json_decode($location);    
      curl_close($ch);         
      $loc = "";   
      if($location===FALSE) return "";     
      if (empty($location->desc)) {    
          $loc = $location->province.$location->city.$location->district.$location->isp;  
      }else{        
          $loc = $location->desc;    
           }
      return $loc;
   }
    

}