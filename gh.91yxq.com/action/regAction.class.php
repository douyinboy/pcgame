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

    //团长导量分析
    public function regAnalysis(){
        $postData = getRequest();
        $where ='';
        if($postData['game_id'] >0){
            $where .='  AND game_id='.intval($postData['game_id']);  
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] >0){
            $where .='  AND server_id='.intval($postData['server_id']);  
        }
        $gamelist = parent::getGameList();
        $sql ="SELECT * FROM ".PAYDB.'.'.SERVERLIST." WHERE is_open >0".$where." ORDER BY game_id DESC, server_id DESC";
        $res = $this ->model ->db ->find($sql); 
        $data =array();
        $month = date("Ym");
        foreach($res as $v){
            $year = date("Y",strtotime($v['create_date']));
            //当日注册
            $sql ="SELECT count(*) as totalReg FROM ".USERDB.".".REGINDEX.$year." WHERE agent_id =".$this ->adminfo['uid']." AND game_id=".$v['game_id']." AND server_id=".$v['server_id'];
            $regnum = $this ->model ->db ->count($sql);
            if($regnum > 0){
                $row = array(
                    'serverdate' =>substr($v['create_date'], 0, 10),
                    'game_id' =>$v['game_id'],
                    'server_id' => $v['server_id'],
                    'game_name' =>$gamelist[$v['game_id']]['name'],
                    'reg_num'   =>$regnum
                );
                //次日留存率/3日活跃人数/7日活跃人数
                $t = strtotime($v['create_date'])+86400;
                $cr = date("Ym",$t);
                $d = date("Y-m-d", $t);
                if($month >= $cr){
                    $sql ="SELECT count(distinct user_name) FROM db_5399_logs.game_login_info_".$cr." WHERE agent_id=".$this ->adminfo['uid']." AND game_id=".$v['game_id']." AND server_id =".$v['server_id']." AND 
                    login_time>=".strtotime($d.' 00:00:00')." AND login_time <=".strtotime($d.' 23:59:59');
                    
                    $crlc = $this ->model ->db ->count($sql);
                    $row['crlcl'] = round(($crlc/$regnum), 3)*100;
                }else{
                    $row['crlcl'] = 0;
                }
                $cr2 = date("Ym",strtotime($v['create_date'])+86400*2);
                if($month >= $cr2){
                    $d2 = date("Y-m-d", strtotime($v['create_date'])+86400*2);
                    $sql ="SELECT count(distinct user_name) FROM db_5399_logs.game_login_info_".$cr2." WHERE agent_id=".$this ->adminfo['uid']." AND game_id=".$v['game_id']." AND server_id =".$v['server_id']." AND 
                    login_time>=".strtotime($d2.' 00:00:00')." AND login_time <=".strtotime($d2.' 23:59:59');
                    $row['crlcl3'] = $this ->model ->db ->count($sql);
                }else{
                    $row['crlcl3'] = 0;
                }
                $cr3 = date("Ym",strtotime($v['create_date'])+86400*6);
                if($month >= $cr3){
                    $d3 = date("Y-m-d", strtotime($v['create_date'])+86400*6);
                    $sql ="SELECT count(distinct user_name) FROM db_5399_logs.game_login_info_".$cr3." WHERE agent_id=".$this ->adminfo['uid']." AND game_id=".$v['game_id']." AND server_id =".$v['server_id']." AND 
                    login_time>=".strtotime($d3.' 00:00:00')." AND login_time <=".strtotime($d3.' 23:59:59');
                    $row['crlcl7'] = $this ->model ->db ->count($sql);
                }else{
                    $row['crlcl7'] = 0;
                }            
                //付费人数\付费率\付费金额
                $sql = "SELECT COUNT(distinct user_name) as totalpayusers, SUM(round(paid_amount, 2)) AS totalpay FROM ".PAYDB.'.'.PAYLIST." WHERE 
                    reg_game_id=game_id AND agent_id=".$this ->adminfo['uid']."
                        AND game_id=".$v['game_id']." AND server_id=".$v['server_id'];
                
                $rs = $this ->model ->db ->get($sql);
                $row['paymoney'] = $rs['totalpay'];
                $row['paypersent'] = round($rs['totalpayusers']/$regnum, 3)*100;
                $row['payusers'] = $rs['totalpayusers'];
                array_push($data, $row);
            }
        }
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('data', $data);
    }
    
    //今日注册
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
        $where = ' WHERE agent_id='.$this ->adminfo['uid'];
        if($postData['start_date'] ==''){
            $postData['start_date'] = date("Y"."-01-01");
        }
        if($postData['end_date'] ==''){
           $postData['end_date']  = date("Y-m-d");
        }
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['game_id'] >0){
            $where .='  AND game_id='.intval($postData['game_id']);  
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] >0){
            $where .='  AND server_id='.intval($postData['server_id']);
        }
        if($postData['placeid'] >0){
            $where .='  AND placeid='.intval($postData['placeid']);
        }
        if($searchYear !=$Year_end){
			 $sql = "SELECT COUNT(*) AS total FROM ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59'); 
            $pageInfo['a'] = $this ->model ->db ->count($sql); 
            $sql = "SELECT COUNT(*) AS total FROM ".USERDB.".".REGINDEX.$Year_end.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59'); 
            $pageInfo['b'] = $this ->model ->db ->count($sql);
            $pageInfo['totalcount']=$pageInfo['a'] + $pageInfo['b'];
            
            $sql ="SELECT * FROM  ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." ORDER BY reg_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
            $res1 = $this ->model ->db ->find($sql);
            $sql ="SELECT * FROM  ".USERDB.".".REGINDEX.$Year_end.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." ORDER BY reg_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
            $res2 = $this ->model ->db ->find($sql);
            $res=array_merge($res1,$res2);
		}else{
             $sql = "SELECT COUNT(*) AS total FROM ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND                reg_time <=". strtotime($postData['end_date'].' 23:59:59'); 
             $pageInfo['totalcount'] = $this ->model ->db ->count($sql); 
             $sql ="SELECT * FROM  ".USERDB.".".REGINDEX.$searchYear.$where." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=".                 strtotime($postData['end_date'].' 23:59:59')." ORDER BY reg_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).",           ".$pageInfo['numperpage'];
             $res = $this ->model ->db ->find($sql);
		}
        $data =array();
        $gamelist = parent::getGameList();
        foreach($res as $k =>$v){
           $data[$k] = $v;
           $user2 = $this ->guildmembers[$v['placeid']]['author'];
           $user2 =='' && $user2 = $_SESSION['user']['name'];
           
           $data[$k]['reg_time'] = date("Y-m-d H:i:s",$data[$k]['reg_time']);
           $data[$k]['reg_ip'] = long2ip($data[$k]['reg_ip']);
           $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
           $data[$k]['membername'] = $user2;
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildmembers', $this ->guildmembers);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']); 
    }
    
    //游戏注册充值
    public function gameRegPay(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =  "WHERE  game_id !=0 AND server_id !=0  AND game_id = reg_game_id";
        $where2 = ' WHERE 1';
        if($postData['end_date'] !=''){
           $where .= " AND pay_date <='".$postData['end_date']." 23:59:59'";
        }else{
           $postData['end_date']  = date("Y-m-d");
           $where .= " AND pay_date <='".$postData['end_date']." 23:59:59'"; 
        }
        if($postData['start_date'] !=''){
            $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00'";
         }else{
            $postData['start_date'] = date("Y", strtotime($postData['end_date']))."-01-01";
            $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00'"; 
         }
         $searchYear = date("Y", strtotime($postData['start_date']));
       //  if($searchYear != date("Y", strtotime($postData['end_date']))){
        //     ajaxReturn(C('Error:ParamCantBeyondYear'), 300);
       //  }
         if($postData['game_id'] >0 ){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $where2 .=' AND agent_id ='.intval($postData['agentid']);
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        //获取游戏列表
        $gamelist = parent::getGameList();
        $sql = "SELECT SUM(paid_amount) as pay_total, agent_id FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY game_id";
        $restmp = $this ->model ->db ->find($sql);
        $res = array();
        foreach($restmp as $k => $v){
            $res[$v['agent_id']] = $v['pay_total'];
        }
       //查询期间公会注册人数
        $sql ="SELECT COUNT(*) as total_num, agent_id FROM  ".USERDB.".".REGINDEX.$searchYear.$where2." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59');
        $res2tmp = $this ->model ->db ->find($sql); 
        $res2 = array();
        foreach($res2tmp as $k => $v){
            $res2[$v['agent_id']] = $v['total_num'];
        }
        //整理统计
        $data = array();
        foreach($this ->guildlist as $v){
          $v['reg_count'] = $res2[$v['id']]['total_num'];
          $v['pay_total'] = $res[$v['id']]['pay_total'];
          $data[] = $v;
        }
        //按充值排序
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }  
}