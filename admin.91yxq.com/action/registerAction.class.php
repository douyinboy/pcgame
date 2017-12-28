<?php
 /**================================
  *注册模块（regAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class registerAction extends Action{
    //游戏收入注册统计分析
    public function regStatutics(){
        set_time_limit(0);
        $postData = getRequest();
	$guildlist=$this ->guildlist;
        $where = ' WHERE 1';
        if(empty($postData['end_date'])){
            $postData['end_date']  = date("Y-m-d");
        }
        if(empty($postData['start_date'])){
            $postData['start_date'] = date("Y-m")."-01";
         }
        $where .= " AND reg_time <=".strtotime($postData['end_date']." 23:59:59")." AND  reg_time >= ".strtotime($postData['start_date']." 00:00:00"); 
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['game_id'] >0 ){
            $where .=' AND game_id ='.intval($postData['game_id']);
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['server_id'] >0 ){
             $where .=' AND server_id ='.intval($postData['server_id']);
        }
        if($postData['agent_id'] >0 ){
             $where .=' AND agent_id ='.intval($postData['agent_id']);
        } 
          //公会专员查询
        if($postData['guild_name'] >0){   
            $sql="select id  from ".GUILDINFO." where addUid=".intval($postData['guild_name']);
            $gh = $this ->model ->db ->find($sql);
            if(!empty($gh)){
                foreach ($gh as $v){
                    $zuid.=$v['id'].",";
                }
                $where.=" AND agent_id IN (".substr($zuid, 0,-1).")";    
            }
        }   
        //公会添加人
        $sql=" select * from ".GUILDINFO;
        $addagent=$this ->model ->db ->find($sql);
        $addagentname=array();
        foreach ($addagent as $v){
            $addagentname[$v['id']]=$v['addUser'];
        }
        $gamelist = parent::getGameList();
            if($searchYear !=$Year_end){
            //跨年期间公会各个游戏服区注册   
                $sql ="SELECT COUNT(distinct reg_ip) as total_ip, count(user_name) as total_reg, agent_id, game_id, server_id FROM ( ".
                        " SELECT reg_ip,user_name,agent_id, game_id, server_id ,reg_time FROM ".USERDB.".".REGINDEX.$searchYear.
                        " UNION SELECT  reg_ip,user_name,agent_id, game_id, server_id ,reg_time FROM  ".USERDB.".".REGINDEX.$Year_end." ) as reg ".
                        $where." GROUP BY agent_id, game_id, server_id"; 
            }else {
                //期间公会各个游戏服区注册       
                $sql = "SELECT count(distinct reg_ip) as total_ip , count(user_name) as total_reg, agent_id, game_id, server_id FROM ".USERDB.'.'.REGINDEX.$searchYear.$where." GROUP BY agent_id, game_id, server_id";        
            }
            $datatmp = $this ->model ->db ->find($sql);
            $data2 = array();
            foreach($datatmp as $v){
                $data2[$v['agent_id']][$v['game_id']][$v['server_id']] = array('total_ip' =>$v['total_ip'], 'total_reg' =>$v['total_reg']);
            }              
            //期间公会各游戏服区显示充值
            $data3 = array();
            $sql = "SELECT SUM(paid_amount) as totalmoney, agent_id, game_id, server_id  FROM ".PAYDB.".pay_list WHERE game_id = reg_game_id
                    AND reg_date >='".$postData['start_date']." 00:00:00' AND reg_date <='".$postData['end_date']." 23:59:59' GROUP BY agent_id, game_id, server_id";
            $datatmp2 = $this ->model ->db ->find($sql);
             foreach($datatmp2 as $v){
                $data3[$v['agent_id']][$v['game_id']][$v['server_id']] = array('totalmoney' =>$v['totalmoney']);
            }
            $data = array();  
            $heji = $heji2 = $heji3 = 0;
            foreach($this ->guildlist as $k =>$v){                
                if($postData['agent_id'] >0 && $postData['agent_id'] !=$k){
                    continue;
                }
                //判断管理的公会列表的公会id  是否与所查条件一致            
                if($postData['guild_name'] >0 && !in_array($k, $pay)){  
                    continue; 
                }  
                foreach($gamelist as $k2 =>$v2){
                    if($postData['game_id'] >0 && $postData['game_id'] !=$k2){
                        continue;
                    }                
                    $servers = parent::getGameServers($k2, array('is_open' =>1));
                    foreach($servers as $k3 =>$v3){                    
                        if($postData['server_id'] >0 && $postData['server_id'] !=$k3){
                            continue;
                        }                  
                        if($data2[$k][$k2][$k3]['total_ip'] >0 || $data2[$k][$k2][$k3]['total_reg'] >0 || $data3[$k][$k2][$k3]['totalmoney'] >0){
                            $row = array();
                            $data3[$k][$k2][$k3]['totalmoney'] =='' && $data3[$k][$k2][$k3]['totalmoney'] =0;                        
                            $row['agent_id'] =$k; 
                            $row['adduser']=$addagentname[$k];
                            $row['game_id'] =$k2;
                            $row['server_id'] =$k3;
                            $row['agent'] =$v['agentname'];
                            $row['game'] = $v2['name'];
                            $row['total_ip'] = $data2[$k][$k2][$k3]['total_ip'];
                            $row['total_reg'] = $data2[$k][$k2][$k3]['total_reg'];
                            $row['total_pay'] =round($data3[$k][$k2][$k3]['totalmoney'], 2);
                            $data[] = $row;
                            $heji['total_pay'] +=  $row['total_pay'];
                            $heji['total_reg'] +=  $row['total_reg'];
                            $heji3['total_ip'] +=  $row['total_ip'];
                        }
                    }  
                }
            }
            $vals = array();
            $postData['orderField'] ==''&& $postData['orderField'] ='total_ip';

            $postData['orderDirection'] ==''&& $postData['orderDirection'] ='desc';
            foreach ($data as $key => $r){
                $vals[$key] = $r[$postData['orderField']];
            }
            if($postData['orderDirection'] =='desc'){
                array_multisort($vals, SORT_DESC, $data);
            }else{
                array_multisort($vals, SORT_ASC, $data);
            }
        
        $sql = "SELECT distinct(addUid) as uid,addUser FROM ".GUILDINFO." group by uid";  
        $guilds = $this ->model ->db ->find($sql);;
        $this ->smarty ->assign('guilds',$guilds);
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('data', $data); 
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $guildlist); 
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
    }
    
	//公会注册充值汇总
   public function regPayCount(){
        date_default_timezone_set("Asia/Shanghai");
        $datetime=strtotime(date('Y-m-d H:i:s'));
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE agenttype =1';
        if($postData['start_date'] >0){
            $where .= " AND reg_date >'".$postData['reg_date']." 00:00:00'";
        }
        if($postData['end_date'] >0){
            $where .= " AND reg_date <'".$postData['end_date']." 23:59:59'";
        }
        //充值统计
        $sql=" SELECT SUM(paid_amount)as pay_total,agent_id FROM ".PAYDB.".".PAYLIST." WHERE game_id !=0 AND server_id !=0 group by agent_id";
        $total=$this ->model ->db ->find($sql);
        $pay_total=array();
        foreach ($total as $v){
            $pay_total[$v['agent_id']]=round($v['pay_total'],2);
        }
        //注册统计
            $sql=" SELECT COUNT(*) as reg_count,Max(reg_time) as max_time,agent_id FROM ( SELECT agent_id,user_name,reg_time FROM ".USERDB.".".REGINDEX.
                    "2014 UNION SELECT agent_id,user_name,reg_time FROM ".USERDB.".".REGINDEX."2015) AS reg group by agent_id";
           $reg1=$this ->model ->db ->find($sql);
           $max_time=array();
           $reg_count=array();
           foreach ($reg1 as $v){
               $reg_count[$v['agent_id']]=$v['reg_count'];
               $max_time[$v['agent_id']]=$v['max_time'];
           }
        $sql = "SELECT COUNT(*) AS total FROM ".GUILDINFO.$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT * FROM ".GUILDINFO.$where." ORDER BY reg_date DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data1 = $this ->model ->db ->find($sql);
        $data=array();
        $row=array();              
        foreach ($data1 as $v){  
            $row['id']=$v['id'];
            $row['agentname']=$v['agentname'];
            $row['qq']=$v['qq'];
            $row['bank']=$v['bank'];
            $row['account_name']=$v['account_name'];
            $row['account']=$v['account'];
            $row['pay_total']=$pay_total[$v['id']];
            $row['reg_count']=$reg_count[$v['id']];
            $day1=strtotime($v['reg_date']);
            $row['reg_date']=round(($datetime-$day1)/86400,1);
            if($max_time[$v['id']] ==null){
                 $row['max_time']=-1;
            }else{
                $row['max_time']=round(($datetime-$max_time[$v['id']])/86400,1);
            }
            $data[]=$row;                     
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
   }
   //公会充值注册统计分析
    public function guildRegPay(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where = ' WHERE game_id !=0 AND server_id !=0 AND game_id = reg_game_id ';
        $where2  =' WHERE 1 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $where2 .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if(empty($postData['end_date'])){
            $postData['end_date'] = date("Y-m-d");
        }
        if(empty($postData['start_date'])){
            $postData['start_date']  = date("Y-m")."-01";
        }
        $where .= " AND pay_date <='".$postData['end_date']." 23:59:59' AND pay_date >='".$postData['start_date']." 00:00:00'";
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));

        $sql = "SELECT round(SUM(paid_amount),2) as pay_total, agent_id FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY agent_id";
        $restmp = $this ->model ->db ->find($sql);
        $res = array();
        foreach($restmp as $k => $v){
            $res[$v['agent_id']] = round($v['pay_total']);
        }
       if($searchYear !=$Year_end){
           //跨年查询期间公会注册人数
            $sql ="SELECT COUNT(*) as total_num, agent_id FROM ( ".
                    " SELECT id,agent_id,reg_time FROM ".USERDB.".".REGINDEX.$searchYear.
                    " UNION SELECT id,agent_id,reg_time FROM  ".USERDB.".".REGINDEX.$Year_end.") as reg ".
                    $where2." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." GROUP BY agent_id";
        //跨年查询公会独立注册ip数
            $sql1 ="SELECT COUNT(distinct reg_ip) as totalip, agent_id FROM ( ".
                    " SELECT reg_ip,agent_id,reg_time FROM ".USERDB.".".REGINDEX.$searchYear.
                    " UNION SELECT reg_ip,agent_id,reg_time FROM  ".USERDB.".".REGINDEX.$Year_end." ) as reg ".
                    $where2." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." GROUP BY agent_id";
        }else{
        //查询期间公会注册人数
           $sql ="SELECT COUNT(*) as total_num, agent_id FROM  ".USERDB.".".REGINDEX.$searchYear.$where2." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." GROUP BY agent_id";
        //查询公会独立注册ip数
            $sql1 ="SELECT COUNT(distinct reg_ip) as totalip, agent_id FROM  ".USERDB.".".REGINDEX.$searchYear.$where2." AND reg_time >=".  strtotime($postData['start_date'])." AND reg_time <=". strtotime($postData['end_date'].' 23:59:59')." GROUP BY agent_id";
        }
        $res2tmp = $this ->model ->db ->find($sql); 
        $res3tmp = $this ->model ->db ->find($sql1);
        $res2 = $res3=array();
        foreach($res2tmp as $k => $v){
            $res2[$v['agent_id']] = $v['total_num'];
        }
        foreach($res3tmp as $k => $v){
            $res3[$v['agent_id']] = $v['totalip'];
        }
    //首充
        $sql=" SELECT  round(SUM(money),2) as pay_first,agent_id  FROM ".PAYDB.".".PAYFIRST.$where2."    AND  state =1 and pay_time >=".strtotime($postData['start_date'])." AND  pay_time <=".strtotime($postData['end_date'].' 23:59:59')."  GROUP BY agent_id";
        $paytmp=$this ->model ->db ->find($sql);
        $firstpay=$innerpay1=$innerpay2=array();
        foreach ($paytmp as $v){
            $firstpay[$v['agent_id']]= $v['pay_first'];
        }  
    //平台垫付
        $sql=" SELECT  round(SUM(money),2) as pay_pt,agent_id FROM ".PAYDB.".".PAYINNER.$where2."  AND  pay_type IN(1,3) AND state =1 and pay_time >=".strtotime($postData['start_date'])." AND  pay_time <=".strtotime($postData['end_date'].' 23:59:59')."  GROUP BY agent_id";
        $paytmp1=$this ->model ->db ->find($sql);
        foreach ($paytmp1 as $v){
            $innerpay1[$v['agent_id']]= $v['pay_pt'];
        }
    //公会垫付
        $sql=" SELECT  round(SUM(money),2) as pay_gh,agent_id FROM ".PAYDB.".".PAYINNER.$where2."  AND  pay_type=2 AND state =1 and pay_time >=".strtotime($postData['start_date'])." AND  pay_time <=".strtotime($postData['end_date'].' 23:59:59')."  GROUP BY agent_id";
        $paytmp2=$this ->model ->db ->find($sql);
        foreach ($paytmp2 as $v){
            $innerpay2[$v['agent_id']]= $v['pay_gh'];
        }
    //总充值【净值】
        $sql = "SELECT round(SUM(paid_amount),2) AS totalMoney FROM ".PAYDB.'.'.PAYLIST.$where;
        $res1 = $this ->model ->db ->get($sql);  
        //整理统计
        $data = array();
        $hj=array('pay' =>$res1['totalMoney'],'first'=>0,'innerpay1' =>0,'innerpay2' =>0);
        if($postData['agentid'] >0){
            $agentid=$postData['agentid'];
            $data[0] = $this ->guildlist[$agentid]['agentname'];
            $data[0]['reg_ips'] = $res3[$agentid];
            $data[0]['reg_count'] = $res2[$agentid];
            $data[0]['pay_total'] = $res[$agentid];
            $data[0]['pay_first']=$firstpay[$agentid];
            $data[0]['pay_pt']=$innerpay1[$agentid];
            $data[0]['pay_gh']=$innerpay2[$agentid];

            $hj['first']+= $firstpay[$postData['agentid']];
            $hj['innerpay1']+= $innerpay1[$postData['agentid']];
            $hj['innerpay2']+= $innerpay2[$postData['agentid']];
        }else{
            foreach($this ->guildlist as $v){             
                $v['reg_ips'] = $res3[$v['id']];
                $v['reg_count'] = $res2[$v['id']];
                $v['pay_total'] = $res[$v['id']];
                $v['pay_first']=$firstpay[$v['id']];
                $v['pay_pt']=$innerpay1[$v['id']];
                $v['pay_gh']=$innerpay2[$v['id']];

                $hj['first']+= $firstpay[$v['id']];
                $hj['innerpay1']+= $innerpay1[$v['id']];
                $hj['innerpay2']+= $innerpay2[$v['id']];
                $data[] = $v;
            }
        }
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
	//游戏周期注册充值
    public function regPayByDate(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
        $guildlist=$this ->guildlist;
        $where = $where2 = '';
        if($postData['end_date'] !=''){
           $where .= " AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
        }else{
           $postData['end_date']  = date("Y-m-d");
        }
        if($postData['start_date'] !=''){
            $where .= " AND  reg_time >= ".strtotime($postData['start_date']." 00:00:00");
         }else{
            $postData['start_date'] = date("Y-m", strtotime($postData['end_date']))."-01";
            $where .= " AND  reg_time >= ".strtotime($postData['start_date']." 00:00:00"); 
         }
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['agentid'] >0 ){
             $where .=' AND agent_id ='.intval($postData['agentid']);
        }
        if($postData['game_id'] >0){
            $where .=' AND game_id ='.intval($postData['game_id']);
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
         if($postData['server_id'] >0 ){
             $where .=' AND server_id ='.intval($postData['server_id']);
         } 
         //注册数据(跨年)
         if($searchYear !=$Year_end){
            $sql="SELECT agent_id, game_id, server_id, sum(1) as total_ip FROM ( ".
                    "select agent_id,game_id,server_id ,reg_time from ".USERDB.".5399_agent_reg_".$searchYear.
                    " UNION SELECT agent_id,game_id,server_id ,reg_time from ".USERDB.".5399_agent_reg_".$Year_end.
                    ") as reg  WHERE 1 ".$where." group by agent_id, game_id,server_id";
         }else {            //注册数据
            $sql="SELECT agent_id, game_id, server_id, sum(1) as total_ip FROM  ".USERDB.".5399_agent_reg_".$searchYear."  WHERE 1 ".$where." group by agent_id, game_id, server_id";
         }
        $data3t = $this ->model ->db ->find($sql);
        $data3 = array();
        foreach($data3t as $v){
            $data3[$v['agent_id']][$v['game_id']][$v['server_id']] = $v['total_ip'];
        }
        if($postData['end_date_2'] !=''){
           $where2 .= " AND pay_date <='".$postData['end_date_2']." 23:59:59'";
        }
        if($postData['start_date_2'] !=''){
            $where2 .= " AND  pay_date >= '".$postData['start_date_2']." 00:00:00'";
         }
        //充值数据
        $sql="SELECT agent_id, game_id, server_id, sum(paid_amount) as total_pay  
            FROM  ".PAYDB.".pay_list 
            WHERE reg_game_id=game_id ".$where2." group by agent_id, game_id, server_id";
        $data2t = $this ->model ->db ->find($sql);
        $data2 = array();
        foreach($data2t as $v){
            $data2[$v['agent_id']][$v['game_id']][$v['server_id']] = $v['total_pay'];
        }
        $heji=$heji2 =0;
        $data = array();
        foreach($guildlist as $k => $v){
            if($postData['agent_id'] >0 && $postData['agent_id'] !=$v['id']){
                continue;
            }
            foreach ($gamelist as $k2 =>$v2){
                if($postData['game_id'] >0 && $postData['game_id'] !=$k2){
                    continue;
                }
                $servers = parent::getGameServers($v2['id']);
                foreach($servers  as $k3 =>$v3){
                    if($postData['server_id'] >0 && $postData['server_id'] !=$v3['server_id']){
                        continue;
                    }
                    if($data2[$k][$k2][$k3] >0 || $data3[$k][$k2][$k3] >0 ){
                       $row = array();
                       $row['agent_id'] = $k;
                       $row['agent'] = $guildlist[$k]['agentname'];
                       
                       $row['game_id'] = $k2;
                       $row['game'] = $gamelist[$k2]['name'];
                       
                       $row['server_id'] = $k3;
                       
                       $row['total_pay'] = round($data2[$k][$k2][$k3],2);
                       $row['total_ip']= $data3[$k][$k2][$k3];
                       $heji += $row['total_pay'];
                       $heji2 += $row['total_ip'];
                       $data[] = $row;
                    }
                }
            }
        }
        $vals = array();
        $postData['orderField'] ==''&& $postData['orderField'] ='total_ip';
        
        $postData['orderDirection'] ==''&& $postData['orderDirection'] ='desc';
        foreach ($data as $key => $r){
            $vals[$key] = $r[$postData['orderField']];
        }
        if($postData['orderDirection'] =='desc'){
            array_multisort($vals, SORT_DESC, $data);
        }else{
            array_multisort($vals, SORT_ASC, $data);
        }
	}
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('heji2', $heji2);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('start_date_2', $postData['start_date_2']);
        $this ->smarty ->assign('end_date_2', $postData['end_date_2']);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('game_list', $gamelist);
        $this ->smarty ->assign('guildlist', $guildlist);   
    }
	
}