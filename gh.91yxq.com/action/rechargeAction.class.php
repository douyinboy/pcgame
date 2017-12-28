<?php
 /**================================
  *付费记录（rechargeAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class rechargeAction extends Action{
    //每日业绩查询
    public function dayData(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
        //如果是查询明细
        if($postData['detail']==1){
            $where3 =" AND game_id !=0 AND server_id !=0  AND pay_date >= '".$postData['sdate']." 00:00:00' AND pay_date <='".$postData['sdate']." 23:59:59' AND game_id=".intval($postData['game_id']);
            $postData['server_id'] >0 && $where3 .= ' AND server_id='.intval($postData['server_id']);
            $sql = "SELECT *  FROM ".PAYDB.'.'.PAYLIST." WHERE game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['uid']." AND game_id = reg_game_id ".$where3." ORDER BY pay_date DESC";
            $data = $this ->model ->db ->find($sql);
            foreach($data as $k => $v){
                $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            }
            $this ->smarty ->assign('data', $data);
            $this ->smarty ->display('pay/payDataDetail.html');
            exit;
        }
        $where =" WHERE game_id !=0 AND server_id !=0 AND  agent_id=".$this ->adminfo['uid']." AND game_id = reg_game_id AND game_id !=0 AND server_id !=0";
        $where2 = ' AND agent_id='.$this ->adminfo['uid'];
        if(empty($postData['start_date'])){
            $postData['start_date'] = date("Y-m")."-01";
         }
        if(empty($postData['end_date'])){
            $postData['end_date'] = date("Y-m-d");
        }
        $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00' AND  pay_date <= '".$postData['end_date']." 23:59:59'"; 
        $searchYear = date("Y", strtotime($postData['start_date']));
	$Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['game_id'] > 0){
           $where .= " AND game_id=".intval($postData['game_id']);
           $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
           $this ->smarty ->assign('serverlist',$serverlist);
           $where2 .= ' AND game_id='.$postData['game_id'];
        }
        if($postData['server_id'] > 0){
           $where .= " AND server_id=".$postData['server_id'];
           $where2 .= ' AND server_id='.$postData['server_id'];
        }
        if($postData['placeid'] > 0){
           $where .= " AND placeid=".$postData['placeid'];
           $where2 .= " AND placeid=".$postData['placeid'];
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $sql = 'SELECT date_format(pay_date, "%Y-%m-%d") as pt FROM '.PAYDB.'.'.PAYLIST.$where.' GROUP BY game_id, pt';
        $pageInfo['totalcount'] = count($this ->model ->db ->find($sql));
        //期间游戏每日充值
        $sql = 'SELECT COUNT(distinct user_name) as payusers, game_id, SUM(paid_amount) as paymoney, date_format(pay_date, "%Y-%m-%d") as paydate   FROM '.PAYDB.'.'.PAYLIST.$where.' GROUP BY game_id, paydate ORDER BY paymoney DESC LIMIT '.(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).', '.$pageInfo['numperpage'];     
        $data = $this ->model ->db ->find($sql);
        $heji = array();;
        foreach($data as $k => $v){
            //新增注册数(跨年)
            if($searchYear !=$Year_end){
                $sql =" SELECT count(distinct reg_ip) as totalip, sum(1) as total_num  FROM ( ".
                        " SELECT game_id,reg_time,agent_id,reg_ip  FROM ".USERDB.".".REGINDEX.$searchYear.
                        " UNION SELECT game_id,reg_time,agent_id,reg_ip FROM ".USERDB.".".REGINDEX.$Year_end.") as reg ".
                        " WHERE game_id=".$v['game_id']." AND reg_time >=".strtotime($v['paydate']." 00:00:00")." AND reg_time <=".strtotime($v['paydate']." 23:59:59").$where2;
            }else{
                $sql ="SELECT count(distinct reg_ip) as totalip, sum(1) as total_num  FROM  ".USERDB.".".REGINDEX.$searchYear." WHERE game_id=".$v['game_id']." AND reg_time >=".strtotime($v['paydate']." 00:00:00")." AND reg_time <=".strtotime($v['paydate']." 23:59:59").$where2;
            }
            $r3 = $this ->model ->db ->get($sql);
            $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['paymoney'] = round($v['paymoney'],2);
            $data[$k]['regips'] = $r3['totalip'];
            $data[$k]['regusers'] = $r3['total_num'];
            
            $heji['paymoney'] +=  $data[$k]['paymoney'];
            $heji['regusers'] +=  $data[$k]['total_num'];
            $heji['regips']   +=  $data[$k]['regips'];
            $heji['payusers'] +=  $data[$k]['payusers'];
        }
        //期间游戏总充值
        $sql = 'SELECT round(SUM(paid_amount),2) as paymoney FROM '.PAYDB.'.'.PAYLIST.$where;
        $res = $this ->model ->db ->get($sql);
        $guildmembers = parent::getGuildMembers(array('id' =>$this ->adminfo['uid']));
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('totalmoney', $res['paymoney']);
        $this ->smarty ->assign('guildmembers', $guildmembers);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //员工业绩查询
    public function memberPayData(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
        $where =" WHERE game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['uid']." AND game_id = reg_game_id ";
        $where2 = ' AND agent_id='.$this ->adminfo['uid'];
        if($postData['start_date'] ==''){
            $postData['start_date'] = date("Y-m")."-01";
        }
        if($postData['end_date'] ==''){
            $postData['end_date'] = date("Y-m-d");
        }
        $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00' AND  pay_date <= '".$postData['end_date']." 23:59:59'"; 
        //如果是查询明细
        if($postData['detail']==1){
            $where3 =" AND game_id !=0 AND server_id !=0 AND  pay_date >= '".$postData['start_date']." 00:00:00' AND pay_date <='".$postData['end_date']." 23:59:59' AND placeid=".intval($postData['placeid']);
            $postData['game_id'] >0 && $where3 .= ' AND game_id='.intval($postData['game_id']);
            $postData['server_id'] >0 && $where3 .= ' AND server_id='.intval($postData['server_id']);
            $sql = "SELECT *  FROM ".PAYDB.'.'.PAYLIST." WHERE  game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['uid']." AND game_id = reg_game_id ".$where3." ORDER BY pay_date DESC";
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
        if($postData['placeid'] > 0){
           $where .= " AND placeid=".$postData['placeid'];
           $where2 .= " AND placeid=".$postData['placeid'];
        }
        //期间游戏每日充值
        $sql = 'SELECT COUNT(distinct user_name) as payusers, SUM(paid_amount) as paymoney, placeid FROM '.PAYDB.'.'.PAYLIST.$where.' GROUP BY placeid ';
        $datatmp = $this ->model ->db ->find($sql);
        $data2 = array();
        foreach($datatmp as $v){
            $data2[$v['placeid']] = array('payusers' =>$v['payusers'], 'paymoney' =>$v['paymoney']);
        }
         //新增注册数
        if($searchYear !=$Year_end){
            $sql ="SELECT count(distinct reg_ip) as totalip, placeid  FROM (".
                " SELECT reg_ip,placeid,reg_time,agent_id FROM ".USERDB.".".REGINDEX.$searchYear.
                " UNION SELECT reg_ip,placeid,reg_time,agent_id  FROM  ".USERDB.".".REGINDEX.$Year_end." ) as reg ".
                " WHERE reg_time >=".strtotime($postData['start_date']." 00:00:00")." AND reg_time <=".strtotime($postData['end_date']." 23:59:59").
                  $where2." GROUP BY placeid";
        }else {
            $sql ="SELECT count(distinct reg_ip) as totalip, placeid  FROM  ".USERDB.".".REGINDEX.$searchYear. 
                  " WHERE reg_time >=".strtotime($postData['start_date']." 00:00:00")." AND reg_time <=".strtotime($postData['end_date']." 23:59:59").
                  $where2." GROUP BY placeid";
        }
        $datatmp2 = $this ->model ->db ->find($sql);
        foreach($datatmp2 as $v){
            $data2[$v['placeid']]['totalip'] = $v['totalip'];
        }
        $guildmembers = parent::getGuildMembers(array('id' =>$this ->adminfo['uid']));
        $data = $row=$heji=array();
        $row['placeid'] = $this->adminfo['uid'];
        $row['membername'] = "公会会长";
        $row['paymoney'] = $data2[0]['paymoney'] >0?round($data2[0]['paymoney']):0;
        $row['payusers'] = $data2[0]['payusers'] >0?$data2[0]['payusers']:0;
        $row['regips'] = $data2[0]['totalip'] >0?$data2[0]['totalip']:0;
        $data[] = $row;
        
        $heji['paymoney']+= $row['paymoney'];
        $heji['regips']+= $row['regips'];
        $heji['payusers']+= $row['payusers'];
        foreach($guildmembers as $k =>$v){
            $row['placeid'] = $k;
            $row['membername'] = $v['author'];
            $row['paymoney'] = $data2[$k]['paymoney'] >0?round($data2[$k]['paymoney']):0;
            $row['payusers'] = $data2[$k]['payusers'] >0?$data2[$k]['payusers']:0;
            $row['regips'] = $data2[$k]['totalip'] >0?$data2[$k]['totalip']:0;
            array_push($data,$row);
            $heji['paymoney']+= $row['paymoney'];
            $heji['regips']+= $row['regips'];
            $heji['payusers']+= $row['payusers'];
        } 
    //期间游戏总充值
        $sql = 'SELECT round(SUM(paid_amount)) as paymoney FROM '.PAYDB.'.'.PAYLIST.$where;
        $res = $this ->model ->db ->get($sql);
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('totalmoney', $res['paymoney']);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('data', $data);
    }

    //首充记录
    public function firstPay(){
        set_time_limit(300);
        $postData = getRequest();
        $ip= getIP();
        //获取游戏列表
        $gamelist = parent::getGameList();
        $guildmembers = parent::getGuildMembers(array('id' =>$this ->adminfo['uid']));
        if($postData['api']=='add'){
            if($postData['sub']==1){
            //统计今天操作的次数
                $sql=" select count(*) as number from ".PAYDB.'.'.PAYFIRST." where pay_time >=".strtotime(date('Y-m-d')." 00:00:00")." and admin_id >0 and agent_id=".$this ->adminfo['uid'];
                $red=$this ->model ->db ->get($sql);
                if($red['number'] >30){
                  //  ajaxReturn('每天只能操作30！',300);
                }
                $game = $gamelist[$postData['game_id']]; 
                if(!is_array($game) || $postData['server_id'] <1 || $postData['account_list'] ==''){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                $userlist = explode("\r\n", $postData['account_list']);
                if(count($userlist) >50){
                    ajaxReturn('账号不能超过50个！',300);
                }
                $hint=array(); //记录各个发放状态的账号数组
                foreach($userlist as $v){
                        if(trim($v) == ''){
                            continue;
                        }
                        $ltime = strtotime(date("Y-m-d")." 00:00:00");
                        $user_name = trim($v);
                        $sql =" SELECT * FROM ".PAYDB.'.'.PAYFIRST." WHERE state =1 AND pay_time >=".$ltime." AND user_name='".$user_name."' AND game_id=".$postData['game_id'];
                        $user = $this ->model ->db ->get($sql);
                        if($user['id'] > 0){
                            $hint['got'].=$user_name." "; //今天已发过
                            continue;
                        }
                        $sql =" SELECT count(*) as total FROM ".PAYDB.'.'.PAYFIRST." WHERE state =1 AND user_name='".$user_name."'";
                        $paytimes = $this ->model ->db ->count($sql);
                        if($paytimes >7 && in_array($game_id, $firstGameid)){
                            $hint['beyond'].=$user_name." "; //特殊游戏账号已发过7次
                            continue;
                        }
                        $orderid = 'F9494'.date("YmdHis"). mt_rand(1000000, 9999999);
                        $game_id = $postData['game_id'];
                       
                        $b_num = $money*$game['exchange_rate'];
                        $time = time();
                        $pay_ip = GetIP();
                        $server_id= $postData['server_id'];

                        $flag = md5($time.KEY_HDPAY.$user_name.$game_id.$server_id.$pay_ip);
                        $post_str = "user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&flag=".$flag."&pay_ip=".$pay_ip."&orderid=".$orderid;
                        $ch = curl_init( );
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch, CURLOPT_URL, PAYGLOD_URL);
                        curl_setopt( $ch, CURLOPT_POST, TRUE);
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
                        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                        $contents = curl_exec( $ch );
                        curl_close( $ch );
                        unset($ch);
                        $contents ==1 ? $hint['success'].=$user_name." ":$hint['error'].=$user_name." ";  //记录相应结果（成功 or 失败）
                        $sql ="INSERT INTO ".PAYDB.'.'.PAYFIRST." SET orderid='".$orderid."', user_name='".$user_name."', agent_id=".$this->adminfo['uid'].", place_id=".$postData['placeid'].",
                            game_id=".$game_id.", server_id=".$server_id.", money=".$money.", gold=".$b_num.", pay_time=".time().", admin_id=".$this ->adminfo['uid'].",ip='".$ip."', state=".intval($contents);
                        $this ->model ->db ->query($sql);
                }
                !empty($hint['got']) ? $hint_date="今天已发过的账号:".$hint['got']."<br/>":$hint_date="";
                !empty($hint['beyond']) ? $hint_date.="发放超过7次的账号：".$hint['beyond']."<br/>":$hint_date.='';
                !empty($hint['success']) ? $hint_date.="发放成功的账号：".$hint['success']."<br/>":$hint_date.='';
                !empty($hint['error']) ? $hint_date.="发放失败的账号：".$hint['error']."<br/>":$hint_date.='';
                ajaxReturn($hint_date,200);
            }
            if($postData['game_id'] > 0){
                $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
                $this ->smarty ->assign('serverlist', $serverlist);
            }
            if($postData['game_id'] > 0 && $postData['server_id'] > 0){
                $sql ="SELECT user_name FROM ".USERDB.".5399_agent_reg_".date("Y")." WHERE 1 AND agent_id=".$this ->adminfo['uid']." AND game_id=".$postData['game_id']." AND server_id=".$postData['server_id'];
                $data2 = $this ->model ->db ->find($sql);
                $p = array();
                foreach($data2 as $v){
                    array_push($p, $v['user_name']);
                }
                $str ='';
                if(count($p) >0){
                    $str = implode("\r\n", $p);
                }
            }
            $this ->smarty ->assign('str', $str);
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addFirstPay.html");
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
        $where =' WHERE agent_id ='.$this ->adminfo['uid'];

        if($postData['placeid'] >0){
           $where .= " AND place_id =".$postData['placeid'];
        }
        if($postData['game_id'] >0){
            $where .= " AND game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['server_id'] >0){
           $where .= " AND server_id =".$postData['server_id'];
        }
        if(!empty($postData['user_name'])){
            $where .= " AND user_name like '%".$postData['user_name']."%' ";
        }
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYFIRST.$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYFIRST.$where." ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['membername'] = $guildmembers[$v['placeid']];
            $data[] = $v;
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildmembers', $guildmembers);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
   
    //公会充值返还结算查询
    public function innerPay(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.".".PAYINNER." WHERE agent_id=".$this ->adminfo['uid']." AND pay_type =2 AND state=1";  
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.".".PAYINNER." WHERE agent_id=".$this ->adminfo['uid']." AND pay_type =2 AND state=1 ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
         //获取游戏列表
        $gamelist = parent::getGameList();
        foreach($data as $k =>$v){
            $data[$k]['game'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['pay_time'] = date("Y-m-d H:i:s", $v['pay_time']);
        }
        $sql = "SELECT  sum(money) as paymoney FROM ".PAYDB.".".PAYINNER." WHERE agent_id=".$this ->adminfo['uid']." AND pay_type =2 AND state=1 ";
        $res = $this ->model ->db ->get($sql);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('totalmoney', $res['paymoney']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    
    //公会充值返还结算查询
    public function settleAccounts(){
        $postData = getRequest();

        if($postData['api']=='detail'){
            $sql ="SELECT subre FROM ".PAYDB.'.'.PAYJIE." WHERE id=".intval($postData['id'])." AND agent_id=".$this ->adminfo['uid'];
            $row = $this ->model ->db ->get($sql);
            if($row['subre']){
                //获取游戏列表
                $gamelist = parent::getGameList();
                $res = unserialize($row['subre']);
                $data = array();
                foreach($res['paymoney'] as $k =>$v){
                    $tmp= array();
                    $tmp['game'] = $gamelist[$k]['name'];
                    $tmp['paymoney'] = $v;
                    $tmp['payinner'] = $res['payinner'][$k];
                    $tmp['payjie'] = $res['payjie'][$k];
                    array_push($data, $tmp);
                }
                $this ->smarty ->assign('data', $data);
                $this ->smarty ->assign('start', $res['start_date']);
                $this ->smarty ->assign('end', $res['end_date']);
            }
            $this ->smarty ->display($postData['action']."/detailJie.html");
            exit;
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where=" where 1 ";
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.".".PAYJIE.$where;  
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);      
        $sql = "SELECT * FROM ".PAYDB.".".PAYJIE.$where." ORDER BY jieTime DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //渠道充值数据统计
    public function theGuildPayData(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
    //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =" WHERE game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['uid']." AND game_id = reg_game_id ";
        ! $postData['start_date'] && $postData['start_date'] = date("Y-m-01");
        ! $postData['end_date'] && $postData['end_date'] = date("Y-m-d");
        $where .= " AND pay_date <='".$postData['end_date']." 23:59:59'  AND  pay_date >= '".$postData['start_date']." 00:00:00'"; 
        $searchYear = date("Y", strtotime($postData['start_date']));
        $Year_end = date("Y", strtotime($postData['end_date']));
        if($postData['game_id'] > 0){
           $where .= " AND game_id=".intval($postData['game_id']);
           $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
           $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] > 0){
           $where .= " AND server_id=".$postData['server_id'];
        }
        //如果是查询明细
        if($postData['detail']==1){
            $sql = "SELECT *  FROM ".PAYDB.'.'.PAYLIST.$where." ORDER BY pay_date DESC";
            $data = $this ->model ->db ->find($sql);
            foreach($data as $k => $v){
                    $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            }
            unset($k, $v);
            $this ->smarty ->assign('data', $data);
            $this ->smarty ->display($postData['action'].'/payDetail.html');
            exit;
        }   
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.'.'.PAYLIST.$where; 
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        //期间充值总金额
        $sql = "SELECT COUNT(distinct user_name) as payusers, game_id, server_id, round(SUM(paid_amount),2) as paymoney  FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY game_id, server_id ORDER BY paymoney DESC  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $totaldata = array('totalusers' =>0, 'totalpay' =>0, 'totaladd'=>0);
        if ($searchYear != $Year_end) {
            foreach($data as $k => $v){
            //新增注册数
                $sql ="SELECT COUNT(id) as total_num FROM  ".USERDB.".".REGINDEX.$searchYear." WHERE  game_id=".$v['game_id']." AND server_id=".$v['server_id']." AND reg_time >=".strtotime($postData['start_date'])." AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
                $data_start = $this ->model ->db ->count($sql);
                $sql ="SELECT COUNT(id) as total_num FROM  ".USERDB.".".REGINDEX.$Year_end." WHERE game_id=".$v['game_id']." AND server_id=".$v['server_id']." AND reg_time >=".strtotime($postData['start_date'])." AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
                
                $data_end = $this ->model ->db ->count($sql);
                $data[$k]['addusers'] = $data_start + $data_end;

                $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
                $data[$k]['paymoney'] = round($v['paymoney'],2);
                $totaldata['totalusers'] +=$v['payusers'];
                $totaldata['totalpay'] +=round($v['paymoney'],2);
                $totaldata['totaladd'] +=$data[$k]['addusers'];
            }
        } else {
            foreach($data as $k => $v){
            //新增注册数
                $sql ="SELECT COUNT(id) as total_num FROM  ".USERDB.".".REGINDEX.$searchYear." WHERE  game_id=".$v['game_id']." AND server_id=".$v['server_id']." AND reg_time >=".strtotime($postData['start_date'])." AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
                $data[$k]['addusers'] = $this ->model ->db ->count($sql);
                
                $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
                $data[$k]['paymoney'] = round($v['paymoney'],2);
                $totaldata['totalusers'] +=$v['payusers'];
                $totaldata['totalpay'] +=round($v['paymoney'],2);
                $totaldata['totaladd'] +=$data[$k]['addusers'];
            }
        }
        unset($k, $v);
        //期间充值总金额
        $sql = "SELECT  round(SUM(paid_amount),2) as paymoney  FROM ".PAYDB.'.'.PAYLIST.$where;
        $reg = $this ->model ->db ->get($sql);
        
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('totalmoney', $reg['paymoney']);
        $this ->smarty ->assign('totaldata', $totaldata);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    
    //公会业绩查询
    public function theGuildPay(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE game_id !=0 AND server_id !=0 AND agent_id='.$this ->adminfo['uid']." AND game_id = reg_game_id ";        
        if($postData['placeid']>0){
            $where .= ' AND placeid ='.$postData['placeid'];
        }
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
         }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00' AND pay_date <='".$postData['end_date']." 23:59:59'";
        if($postData['game_id'] >0){
            $where .='  AND game_id='.intval($postData['game_id']);  
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] >0){
            $where .='  AND server_id='.intval($postData['server_id']);
        }
        if($postData['user_name'] !=''){
            $where .="  AND user_name='".trim($postData['user_name'])."'";
        }
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.'.'.PAYLIST.$where; 
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        //期间充值总金额
        $sql = "SELECT SUM(paid_amount) FROM ".PAYDB.'.'.PAYLIST.$where; 
        $totalmoney = round($this ->model ->db ->count($sql), 2);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYLIST.$where." ORDER BY pay_date DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $gamelist = parent::getGameList();
        $hj=array();
        foreach($data as $k => $v){
            $user = $this ->guildmembers[$v['placeid']]['sitename'];
            $user =='' && $user = $_SESSION['user']['name'];
            $data[$k]['game'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['paid_amount'] = round($data[$k]['paid_amount'], 2);
            $data[$k]['membername'] = $user;
            $hj['paid_amount']+=round($data[$k]['paid_amount'], 2);
        }
        $sql = "SELECT round(sum(paid_amount),2) as money FROM ".PAYDB.'.'.PAYLIST.$where;
        $red = $this ->model ->db ->get($sql);
        
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('totalmoney', $totalmoney);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('money', $red['money']);
        $this ->smarty ->assign('guildmembers', $this ->guildmembers);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
	
    //申请内充
    public function applyInnerpay(){
        date_default_timezone_set("Asia/Shanghai");
        $postData = getRequest();
        $postData['reason'] = mysql_real_escape_string(strip_tags(trim($postData['reason'])));
        $postData['user_name'] = mysql_real_escape_string(strip_tags(trim($postData['user_name'])));
        $postData['user_role'] = mysql_real_escape_string(strip_tags(trim($postData['user_role'])));
        $postData['game_id'] += 0;
        $postData['server_id'] += 0;
        $gamelist = parent::getGameList();
        if($postData['api'] =='add'){
            if($postData['sub']==1){
                if($postData['pay_type'] <=0){
                    ajaxReturn('请选择充值类型!',300);
                }
                $game = $gamelist[$postData['game_id']]; 
                $sql =" select agent_id  from ".USERDB.".".USERS." where user_name='".$postData['user_name']."'";
                $guildid=$this ->model ->db ->get($sql);
                if($guildid['agent_id'] !=$_SESSION['user']['uid']){
                    ajaxReturn(C("Error:GuildNameError"),300);  
                }else{
                        $orderid = 'N9494'.date("YmdHis"). mt_rand(1000000, 9999999);
                        $money = intval($postData['pay_money']);
                        $b_num = $money*$game['exchange_rate'];
                        $sql=" insert into  ".PAYDB.".".GUILDINNER." SET orderid='".$orderid."',reason='".$postData['reason'].
                                "',user_name='".$postData['user_name']."',user_role='".$postData['user_role'].
                                "',agent_id=".$_SESSION['user']['uid'].",place_id=".$_SESSION['user']['uid'].",game_id=".$postData['game_id'].",server_id=".$postData['server_id'].",money=".$money.",gold=".$b_num.
                                ",pay_time=".time().",state=0"; 
                        $this ->model ->db ->find($sql);
                        ajaxReturn(C("Ok:InnerPay")); 
					}
            }
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildmembers', $this ->guildmembers);
            $this ->smarty ->display($postData['action']."/addinnerpay.html");
        }
        $where =" where state= 0 AND agent_id=".$_SESSION['user']['uid'];
        if($postData['game'] >0){
            $where.=" AND game_id=".$postData['game'];
        }
        if($postData['server_id'] >0){
            $where.=" AND server_id=".$postData['server_id'];
        }
        if($postData['start_date'] >0){
            $where.=" AND pay_time >=".strtotime($postData['start_date']);
        }
        if($postData['end_date'] >0){
             $where.=" AND pay_time <=".strtotime($postData['end_date']." 23:59:59");
        }
        $sql ="select * from ".GUILDINFO;
        $agent=$this ->model ->db ->find($sql);
        $guild =array();
        foreach ($agent as $v){
            $guild[$v['id']]=$v['agentname'];
        }
        $sql=" select * from ".PAYDB.".".GUILDINNER.$where;
        $applyinner=$this ->model ->db ->find($sql);
        $inner = $data =array();
        foreach ($applyinner as $v){
            $inner['orderid'] = $v['orderid'];
            $inner['user_name'] = $v['user_name'];
            $inner['user_role'] = $v['user_role'];
            $inner['gamename'] =$gamelist[$v['game_id']]['name']; 
            $inner['server_id'] = $v['server_id'];
            $inner['money'] =$v['money'];
            $inner['gold']=$v['gold'];
            $inner['agentname'] =$guild[$v['agent_id']];
            $inner['pay_time'] = $v['pay_time'];
            $inner['pay_type'] = $v['pay_type'];
            $inner['state'] = $v['state'];
            $data[]=$inner;
        } 
        $this ->smarty ->assign('data',$data);
        $this ->smarty ->assign('gamelist', $gamelist);
    }
    
}