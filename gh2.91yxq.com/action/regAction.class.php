<?php
 /**================================
  *注册模块（regAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class regAction extends Action{
    //最近注册
    public function todayReg(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where = ' WHERE agent_id='.$this ->adminfo['agent_id'].' AND placeid='.$this ->adminfo['uid'];
        if($postData['start_date'] ==''){
            $postData['start_date'] = date("Y-m"."-01");
        }
        if($postData['end_date'] ==''){
           $postData['end_date']  = date("Y-m-d");
        }
        $searchYear = date("Y", strtotime($postData['start_date']));
        if($searchYear != date("Y", strtotime($postData['end_date']))){
            ajaxReturn(C('Error:ParamCantBeyondYear'), 300);
        }
        if($postData['game_id'] >0){
            $where .='  AND game_id='.intval($postData['game_id']);  
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] >0){
            $where .='  AND server_id='.intval($postData['server_id']);
        }
        $sql = "SELECT COUNT(*) AS total FROM ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59'); 
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql); 
        $sql ="SELECT * FROM  ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." ORDER BY reg_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql); 
        $data =array();
        $gamelist = parent::getGameList();
        foreach($res as $k =>$v){
           $data[$k] = $v;
           $data[$k]['reg_time'] = date("Y-m-d H:i:s",$data[$k]['reg_time']);
           $data[$k]['reg_ip'] = long2ip($data[$k]['reg_ip']);
           $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
           $data[$k]['membername'] = $this ->adminfo['name'];
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']); 
    }
}