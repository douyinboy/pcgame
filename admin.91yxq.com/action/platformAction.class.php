<?php
 /**================================
  *特别处理模块（spaciousAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class platformAction extends Action{
    //公会成员业绩查询
    public function guildMemberScoreData(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
        $where =" WHERE game_id !=0 AND server_id !=0 AND game_id = reg_game_id ";
        $where2 = ' AND 1';
        if(empty($postData['start_date'])){
            $postData['start_date'] = date("Y-m")."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date'] = date("Y-m-d");
        }
        $where .= " AND  pay_date <= '".$postData['end_date']." 23:59:59' AND  pay_date >= '".$postData['start_date']." 00:00:00'"; 
        //如果是查询明细
        if($postData['detail']==1){
            $where3 =" AND pay_date >= '".$postData['start_date']." 00:00:00' AND pay_date <='".$postData['end_date']." 23:59:59' AND placeid=".intval($postData['placeid']);
            $postData['game_id'] >0 && $where3 .= ' AND game_id='.intval($postData['game_id']);
            $postData['server_id'] >0 && $where3 .= ' AND server_id='.intval($postData['server_id']);
            $sql = "SELECT *  FROM ".PAYDB.'.'.PAYLIST." WHERE game_id !=0 AND server_id !=0 AND agent_id=".$postData['agent_id']." AND game_id = reg_game_id ".$where3." ORDER BY pay_date DESC";
            $data = $this ->model ->db ->find($sql);
            foreach($data as $k => $v){
                $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            }
            $this ->smarty ->assign('data', $data);
            $this ->smarty ->display($postData['action'].'/payDataDetail.html');
            exit;
        }
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['game_id'] > 0){
           $where .= " AND game_id=".intval($postData['game_id']);
           $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
           $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] > 0){
           $where .= " AND server_id=".$postData['server_id'];
           $where2 .= " AND server_id=".$postData['server_id'];
        }
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $where2 .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['placeid']>0){
            $where .= ' AND placeid ='.$postData['placeid'];
            $where2 .= " AND placeid=".$postData['placeid'];
        }
        //期间游戏每日充值
        $sql = 'SELECT COUNT(distinct user_name) as payusers, round(SUM(paid_amount),2) as paymoney, agent_id, placeid FROM '.PAYDB.'.'.PAYLIST.$where.' GROUP BY agent_id, placeid ';
        $datatmp = $this ->model ->db ->find($sql);
        $data2 = array();
        foreach($datatmp as $v){
            $data2[$v['agent_id']][$v['placeid']] = array('payusers' =>$v['payusers'], 'paymoney' =>$v['paymoney']);
        }
         if($searchYear !=$Year_end){
            //新增注册数(跨年)
            $sql ="SELECT count(distinct reg_ip) as totalip, agent_id, placeid FROM ( ".
                    "SELECT reg_ip,agent_id, placeid,reg_time FROM ".USERDB.".".REGINDEX.$searchYear.
                    " UNION SELECT reg_ip,agent_id, placeid,reg_time FROM  ".USERDB.".".REGINDEX.$Year_end.") as reg ".
                    " WHERE reg_time >=".strtotime($postData['start_date']." 00:00:00")." AND reg_time <=".strtotime($postData['end_date']." 23:59:59").
                     $where2." GROUP BY agent_id, placeid";
        }else {
        //新增注册数
        $sql ="SELECT count(distinct reg_ip) as totalip, agent_id, placeid  FROM  ".USERDB.".".REGINDEX.$searchYear." 
                WHERE reg_time >=".strtotime($postData['start_date']." 00:00:00")." AND reg_time <=".strtotime($postData['end_date']." 23:59:59").
                $where2." GROUP BY agent_id, placeid";
        }
        $datatmp2 = $this ->model ->db ->find($sql);
        foreach($datatmp2 as $v){
            $data2[$v['agent_id']][$v['placeid']]['totalip'] = $v['totalip'];
        }
        $heji =array('paymoney' =>0,'regips' =>0,'payusers'=>0);
        $data = array();
        foreach($this ->guildlist as $ve){
            if($postData['agent_id'] >0 && $postData['agent_id'] !=$ve['id']){
                continue;
            }
            $guildmembers = parent::getGuildMembers(array('id' =>$ve['id']));
            if($postData['placeid'] < 1){
                $row = array();
                $row['agentid'] = $ve['id'];
                $row['agentname'] = $ve['agentname'];
                $row['placeid'] = 0;
                $row['membername'] = "公会会长";
                $row['paymoney'] = $data2[$ve['id']][0]['paymoney'] >0?round($data2[$ve['id']][0]['paymoney']):0;
                $row['payusers'] = $data2[$ve['id']][0]['payusers'] >0?$data2[$ve['id']][0]['payusers']:0;
                $row['regips'] = $data2[$ve['id']][0]['totalip'] >0?$data2[$ve['id']][0]['totalip']:0;
                $data[] = $row;
                $heji['paymoney']+=  $row['paymoney'];
                $heji['regips']+=  $row['regips'];
                $heji['payusers']+=  $row['payusers'];
            }
            foreach($guildmembers as $k =>$v){
                if($postData['placeid'] >0 && $postData['placeid'] !=$k){
                    continue;
                }
                $row = array();
                $row['agentid'] = $ve['id'];
                $row['agentname'] = $ve['agentname'];
                $row['placeid'] = $k;
                $row['membername'] = $v['sitename'];
                $row['paymoney'] = $data2[$ve['id']][$k]['paymoney'] >0?round($data2[$ve['id']][$k]['paymoney']):0;
                $row['payusers'] = $data2[$ve['id']][$k]['payusers'] >0?$data2[$ve['id']][$k]['payusers']:0;
                $row['regips'] = $data2[$ve['id']][$k]['totalip'] >0?$data2[$ve['id']][$k]['totalip']:0;
                $data[] = $row;
                $heji['paymoney']+=  $row['paymoney'];
                $heji['regips']+=  $row['regips'];
                $heji['payusers']+=  $row['payusers'];
            }
        }
        $vals = array();
        foreach ($data as $key => $r){
            $vals[$key] = $r['paymoney'];
        }
        array_multisort($vals, SORT_DESC, $data);
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('guildmembers', $guildmembers);
        $this ->smarty ->assign('gamelist', $gamelist);
    }
    //公会各游戏数据分析
    public function guildScoreData(){
        $postData = getRequest();
        $where = ' WHERE 1';
        if(empty($postData['end_date'])){
            $postData['end_date']  = date("Y-m-d");
        }
        if(empty($postData['start_date'])){
            $postData['start_date'] = date("Y-m")."-01";
        }
        $where .= " AND reg_time <=".strtotime($postData['end_date']." 23:59:59")." and reg_time >=".strtotime($postData['start_date']." 00:00:00");
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
        if($postData['agentid'] >0 ){
             $where .=' AND agent_id ='.intval($postData['agentid']);
        }
        $gamelist = parent::getGameList();
        if($searchYear !=$Year_end){
        //期间公会各个游戏服区注册(跨年)
            $sql ="SELECT count(distinct reg_ip) as total_ip, count(user_name) as total_reg, agent_id, game_id, server_id FROM ( ".
                    "SELECT  reg_ip,user_name, agent_id, game_id, server_id,reg_time FROM ".USERDB.".".REGINDEX.$searchYear.
                    " UNION SELECT reg_ip,user_name, agent_id, game_id, server_id,reg_time FROM  ".USERDB.".".REGINDEX.$Year_end.") as reg ".
                    $where." GROUP BY agent_id, game_id, server_id";
        }else{
        //期间公会各个游戏服区注册
            $sql = "SELECT count(distinct reg_ip) as total_ip, count(user_name) as total_reg, agent_id, game_id, server_id FROM ".USERDB.'.'.REGINDEX.$searchYear.$where." GROUP BY agent_id, game_id, server_id";
        }
        $datatmp = $this ->model ->db ->find($sql);
        $data2 = array();
        foreach($datatmp as $v){
            $data2[$v['agent_id']][$v['game_id']][$v['server_id']] = array('total_ip' =>$v['total_ip'], 'total_reg' =>$v['total_reg']);
        }
        //期间公会各游戏服区显示充值
        $data3 = array();
        $sql = "SELECT SUM(paid_amount) as totalmoney, agent_id, game_id, server_id  FROM ".PAYDB.".".PAYLIST."  WHERE game_id = reg_game_id
                AND reg_date >='".$postData['start_date']." 00:00:00' AND reg_date <='".$postData['end_date']." 23:59:59' GROUP BY agent_id, game_id, server_id";       
        $datatmp2 = $this ->model ->db ->find($sql);
         foreach($datatmp2 as $v){
            $data3[$v['agent_id']][$v['game_id']][$v['server_id']] = array('totalmoney' =>$v['totalmoney']);
        }
        $data4 = array();
         if($searchYear !=$Year_end){
             //期间公会各游戏服区实际充值(跨年)
            $sql = "SELECT SUM(a.paid_amount) as totalmoney, a.agent_id, a.game_id, a.server_id  FROM ".PAYDB.".pay_list as a, ( select user_name from ".
                    USERDB.'.'.REGINDEX.$searchYear." UNION select user_name from ".
                    USERDB.'.'.REGINDEX.$Year_end.") as  b  WHERE a.user_name=b.user_name 
                AND a.reg_date >='".$postData['start_date']." 00:00:00' AND a.reg_date <='".$postData['end_date']." 23:59:59' GROUP BY a.agent_id, a.game_id, a.server_id";               
            $datatmp3 = $this ->model ->db ->find($sql);
        }else {
             //期间公会各游戏服区实际充值
            $sql = "SELECT SUM(a.paid_amount) as totalmoney, a.agent_id, a.game_id, a.server_id  FROM ".PAYDB.".pay_list a, ".USERDB.'.'.REGINDEX.$searchYear." b  WHERE a.user_name=b.user_name 
                    AND a.reg_date >='".$postData['start_date']." 00:00:00' AND a.reg_date <='".$postData['end_date']." 23:59:59' GROUP BY a.agent_id, a.game_id, a.server_id";               
            $datatmp3 = $this ->model ->db ->find($sql);
        }
        foreach($datatmp3 as $v){
            $data4[$v['agent_id']][$v['game_id']][$v['server_id']] = array('infact_pay' =>$v['totalmoney']);
        }
        $data = array();
        $heji =array('infact_pay' =>0,'total_reg'=>0,'total_ip'=>0);       
        foreach($this ->guildlist as $k =>$v){
            if($postData['agentid'] >0 && $postData['agentid'] !=$k){
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
                    if($data2[$k][$k2][$k3]['total_ip'] >0 || $data2[$k][$k2][$k3]['total_reg'] || $data3[$k][$k2][$k3]['totalmoney'] >0 || $data4[$k][$k2][$k3]['infact_pay'] >0){
                        $row = array();
                        $data3[$k][$k2][$k3]['totalmoney'] =='' && $data3[$k][$k2][$k3]['totalmoney'] =0;
                        $row['agent_id'] =$k;
                        $row['game_id'] =$k2;
                        $row['server_id'] =$k3;
                        $row['agent'] =$v['agentname'];
                        $row['game'] = $v2['name'];
                        $row['total_ip'] = $data2[$k][$k2][$k3]['total_ip'];
                        $row['total_reg'] = $data2[$k][$k2][$k3]['total_reg'];
                        $row['total_pay'] =round($data3[$k][$k2][$k3]['totalmoney'], 2);
                        $row['infact_pay'] =round($data4[$k][$k2][$k3]['infact_pay'], 2);
                        $data[] = $row;
                        $heji['infact_pay'] +=  $row['infact_pay'];
                        $heji['total_reg'] += $row['total_reg'];
                        $heji['total_ip'] += $row['total_ip'];
                    }
                }  
            }
        }
        $vals = array();
        foreach ($data as $key => $r){
            $vals[$key] = $r['infact_pay'];
        }
        array_multisort($vals, SORT_DESC, $data);
        $this ->smarty ->assign('heji', $heji);    
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist); 
    }
    //屏蔽链接【公会、游戏】
    public function shieldUrl(){
       $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        if($postData['api']=='add'){
            if($postData['sub']==1){
                if($postData['agentid'] < 1 || $postData['game_id'] < 1|| $postData['server_id'] < 1){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $year = date("Y");               
                $da = array();
                for($i=2015;$year >= $i; $i++){
                    if($postData['placeid'] > 0){
                       $sql ="SELECT user_name FROM ".USERDB.".".REGINDEX.$i." WHERE agent_id=".intval($postData['agentid']).
                            " AND placeid=".  intval($postData['placeid'])." AND game_id=".intval($postData['game_id'])." AND server_id=".intval($postData['server_id']); 
                    }else{
                        $sql ="SELECT user_name FROM ".USERDB.".".REGINDEX.$i." WHERE agent_id=".intval($postData['agentid']).
                            " AND game_id=".intval($postData['game_id'])." AND server_id=".intval($postData['server_id']);                                       
                    }                                                         
                    $tmpdata = $this ->model ->db ->find($sql);
                    if(is_array($tmpdata) && count($tmpdata) >0){
                        foreach($tmpdata as $v){
                            array_push($da, $v['user_name']);
                        }
                    }
                }
                if(count($da) >0){
                    foreach($da as $v2){
                        $sql ="UPDATE ".USERDB.".".USERS." SET agent_id=100, place_id=100 WHERE user_name='".trim($v2)."'";
                        $this ->model ->db ->query($sql);
                    }
                    $sql ="INSERT INTO ".BOUNDRECORD." SET opUserList='".serialize($da)."', agent_id=".intval($postData['agentid']).",placeid=".intval($postData['placeid']).",  game_id=".intval($postData['game_id']).", server_id=".intval($postData['server_id']).", addUid=".$this ->adminfo['uid'].", addUser='".$this ->adminfo['name']."', addTime=".time();
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:Operate"));  
                }
                ajaxReturn(C('Error:AccountNotExisted'), 300);
            }
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addRecord.html");
            exit();
        }else if($postData['api'] =='forback'){
            if($postData['id'] >0){
                $sql = "SELECT * FROM ".BOUNDRECORD." WHERE id=".intval($postData['id']);
                $row = $this ->model ->db ->get($sql);
                if($row['id'] >0){
                    $users = unserialize($row['opUserList']);
                    foreach($users as $v){
                        //恢复玩家链接
                        $sql ="UPDATE ".USERDB.".".USERS." SET agent_id=".$row['agent_id'].", place_id=".$row['placeid']." WHERE user_name='".trim($v)."'";
                        $this ->model ->db ->query($sql);
                        //恢复玩家充值
                        $sql ="UPDATE ".PAYDB.".".PAYLIST." SET agent_id=".$row['agent_id'].", placeid=".$row['placeid']." WHERE user_name='".trim($v)."' AND pay_date >='".date("Y-m-d H:i:s", $row['addTime'])."'";
                        $this ->model ->db ->query($sql);
                     //修改记录表
                        $sql="insert into user_agent_amend set uid=".$this ->adminfo['uid'].",addtime=".time().",user_name='".trim($v)."'";
                        $this ->model ->db ->query($sql);
                    }
                    //设置为已还原
                    $sql ="UPDATE ".BOUNDRECORD." SET ifback=1 WHERE id=".$row['id'];
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:Operate"));
                }
            }
            ajaxReturn(C("Error:ParamNotIsNull"), 300);
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }                             
        $sql = "SELECT count(*) FROM ".BOUNDRECORD;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".BOUNDRECORD." ORDER BY addTime DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        //相差金额（公会链接删除后的充值）
        foreach ($res as $key => $v){
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['game'] = $gamelist[$v['game_id']]['name']; 
            if($v['ifback'] ==0){ 
                $sql="SELECT round(SUM(paid_amount),1) as last_money FROM  ".PAYDB.".".PAYLIST." where  agent_id=100  AND game_id= ".$v['game_id']." AND server_id="
                      .$v['server_id']."  AND pay_date >="."'".date("Y-m-d H:i:s", $v['addTime'])."'";             
                $last=$this -> model ->db ->get($sql);                                
                $v['last_money']=$last['last_money'];
            }
            $data[]=$v;
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']); 
    }
    //绑定玩家到公会
    public function regCorrect(){
        $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        if($postData['api']=='add'){
            if($postData['sub']==1){
                if($postData['account_list'] ==''|| $postData['agentid'] < 1|| $postData['game_id'] < 1|| $postData['server_id'] < 1){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $user = explode("\r\n", $postData['account_list']);
                $userlist=array_unique($user);
                $hint=array('success'=>0,'error'=>0,'errorarr'=>''); //记录各个操作状态
                foreach($userlist as $v){
                    $result=" ";
                    if(trim($v) != ''){
                        $sql ="SELECT * FROM ".USERDB.".".USERS." WHERE user_name='".trim($v)."'";
                        $userInfo = $this ->model ->db ->get($sql);  
                        if($userInfo['uid'] > 0){
                            $sql ="UPDATE ".USERDB.".".USERS." SET agent_id=".intval($postData['agentid']).", place_id=".  intval($postData['placeid'])." WHERE user_name='".trim($v)."'";
                            $this ->model ->db ->query($sql);
                            $year =date('Y', $userInfo['reg_time']);
                            $year < 2015 && $year=2015;
                            $sql ="UPDATE ".USERDB.".".REGINDEX.$year." SET agent_id=".intval($postData['agentid']).", placeid=".  intval($postData['placeid']).", game_id=".intval($postData['game_id']).", server_id=".intval($postData['server_id'])." WHERE user_name='".trim($v)."'";
                            $this ->model ->db ->query($sql);
                        //充值数据
                            $sql ="UPDATE ".PAYDB.".".PAYLIST." SET agent_id=".intval($postData['agentid']).", placeid=".  intval($postData['placeid'])."  WHERE user_name='".trim($v)."'";;
                            $this ->model ->db ->query($sql);
                        //内充数据
                            $start = date("Y-m-d H:i:s",mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))); //本周星期一
                            $end = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))); //本周星期日
                            $sql ="UPDATE ".PAYDB.".".PAYINNER." SET agent_id=".intval($postData['agentid']).", place_id=".  intval($postData['placeid'])."  WHERE user_name='".trim($v)."' and pay_time >=".strtotime($start)." and pay_time <=".strtotime($end);
                            $this ->model ->db ->query($sql); 
                            $hint['success']++; //成功个数
                            $result=",regTime=".$userInfo['reg_time'];
                        }else{
                            $hint['error']++; //失败个数
                            $hint['errorarr'].=$v." ";
                            $result=",result='该账号不存在'";
                        }
                        $sql ="INSERT INTO ".BOUNDUSER." SET user_name='".trim($v)."', agent_id=".intval($postData['agentid']).", game_id=".intval($postData['game_id']).", server_id=".intval($postData['server_id']).", uid=".$this ->adminfo['uid'].", bTime=".time().$result;
                        $this ->model ->db ->query($sql);
                    }
                }
                $hint_date="成功绑定:".$hint['success']."个<br/>";
                $hint['error'] >0 ? $hint_date.="绑定失败：".$hint['error']."个<br/>分别为：<br/>".$hint['errorarr']:$hint_date.=" ";
                ajaxReturn($hint_date,200);
            }
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addNew.html");
            exit();
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        
        $sql = "SELECT count(*) FROM ".BOUNDUSER;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".BOUNDUSER." ORDER BY bTime DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['game'] = $gamelist[$v['game_id']]['name'];
            $data[] = $v;
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //用户列表
    public function usersRelated(){
        $postData = getRequest();
        if($postData['api']=='qie'){  //绑定到官网
            if($postData['id']>0){
                $sql="UPDATE ".USERDB.'.'.USERS." SET agent_id=100, place_id=100 WHERE uid =".intval($postData['id']);
                $this ->model ->db ->query($sql);
                ajaxReturn(C('Ok:Operate'));
            }
            ajaxReturn(C('Error:ParamError'), 300);
        }else if($postData['api']=='jie'){ //还原回原来渠道 
            if($postData['id']>0){
                $sql="SELECT user_name, reg_time FROM  ".USERDB.'.'.USERS." WHERE uid =".intval($postData['id']);
                $user = $this ->model ->db ->get($sql);
                if($user){
                    $year=$user['reg_time']>0 ? date("Y", $user['reg_time']):2015;
                    $sql ="SELECT agent_id, placeid FROM ".USERDB.'.'.REGINDEX.$year." WHERE user_name ='".$user['user_name']."'";
                    $row = $this ->model ->db ->get($sql);
                    if($row){
                        if($row['agent_id'] !=100){
                            $sql="UPDATE ".USERDB.'.'.USERS." SET agent_id=".$row['agent_id'].", place_id=".$row['placeid']." WHERE uid =".intval($postData['id']);
                            $this ->model ->db ->query($sql);
                            ajaxReturn(C('Ok:Operate'));
                        }
                    }
                }
            }
            ajaxReturn(C('Error:OprateHaveNoEffect'), 300);
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE 1';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        
        if($postData['placeid']>0){
            $where .= ' AND place_id ='.$postData['placeid'];
        }
        if(!empty($postData['start_date'])){
            $where .= " AND  reg_time >= ".strtotime($postData['start_date'].' 00:00:00');
        }
        if(!empty($postData['end_date'])){
            $where .= " AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
        }
        if($postData['name'] !=''){
           $where .= " AND user_name ='".$postData['name']."'";
        }
        $sql = "SELECT COUNT(*) AS total FROM ".USERDB.'.'.USERS.$where; 
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT * FROM ".USERDB.'.'.USERS.$where." ORDER BY reg_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        foreach($data as $k => $v){
            $data[$k]['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
}