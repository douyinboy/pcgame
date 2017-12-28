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
    protected $guildmembers; //公会的成员列表
    public function __construct(){
        global $mUser, $smarty;
        $this ->model = new comModel;
        $this ->smarty = $smarty;
        $this ->adminfo = $mUser;
        $this ->admgrantkeys = $_SESSION['grant_key'];
        $this ->admgrants = $_SESSION['grant_list'];
        $this ->guildmembers = $this ->getGuildMembers(array('id' =>$mUser['uid']));
    }
    /**
     * 设置用户权限内的公会列表
     */
    protected function getUserGuildList(){
        $this ->model ->setTable(GUILDINFO);
        $this ->model ->fields = array('id', 'agentname');
        $this ->model ->where['state'] = 1;
        if($this ->adminfo['guilds']){
            $this ->model ->where = $this ->adminfo['guilds'];
        }
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
        if($p['id'] <1){
            return array();
        }
        $this ->model ->setTable(GUILDMEMBER);
        $this ->model ->fields = array('site_id', 'author','aAccount');
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
    protected function getGameList(){
        $sql ="SELECT * FROM ".PAYDB.".".GAMELIST." WHERE is_open=1 ORDER BY gTop DESC";
        $res = $this ->model ->db ->find($sql);
        $data= array();
        foreach($res as $v){
            $data[$v['id']] = $v;
        }
        return $data;
    }

        /**
     * 获取游戏开服列表
     * @param $id   int  游戏id
     * @return $res  array  返回该游戏开服列表信息
     */
    protected function getGameServers($id, $w = array()){
        $this ->model ->setTable(PAYDB.'.'.SERVERLIST);
        $this ->model ->fields = array('server_id', 'name');
        $where = array('game_id' =>$id);
        $this ->model ->where = array_merge($where, $w);
        $this ->model ->sort = " server_id  DESC ";
        $this ->model ->csSql();
        $res = $this ->model ->find();
        $data = array();
        foreach($res as $k => $v){
          $data[$v['server_id']] = $v;
        }
        return $data;
    }
    
    /**
     * 创建连接指定数据库的对象
     * @param $dbInfo    数据库权限信息
     * @return  object   数据库连接对象
     */
    protected function newDb($dbInfo){  
        return new Mysql($dbInfo);
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
    
//短链接 【备用】
    protected function getShotUrl1($reg) {   //短链接【备用】
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://dwz.cn/create.php");
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $data=array('url'=>$reg);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $strRes=curl_exec($ch);
        curl_close($ch);
        $arrResponse=json_decode($strRes,true);
        return $arrResponse['tinyurl'];
        
         if($arrResponse['status']!=0)
            {
                $url=file_get_contents('http://api.t.sina.com.cn/short_url/shorten.json?source=3271760578&url_long='.$reg);
                $shorurl=json_decode($url,true);
                return $shorurl[0]['url_short'];
            }else{
                return $arrResponse['tinyurl'];  
            }
    }
    //短链接
  protected  function getShotUrl($reg){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, "http://www.v3l.cn/api/shoturl.php");
        $data=array('url'=>$reg);
        curl_setopt($ch, CURLOPT_GET, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIEJAR);
        curl_setopt($ch, CURLOPT_TIMEOUT, TIMEOUT);
        ob_start();
        curl_exec($ch);
        $contents = ob_get_contents();
        ob_end_clean();
        curl_close($ch);
        if(empty($contents)){
            $contents=$this ->getShotUrl1($reg);
        }
        return $contents;
    }
    
//获取公会最后登录地址
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