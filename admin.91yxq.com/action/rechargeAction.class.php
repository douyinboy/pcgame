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
    //公会工资查询
    public function guildPaySearch(){
        $postData = getRequest();
        $gamelist = parent::getGameList();//获取游戏列表
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        //充值
        $where =" WHERE game_id !=0 AND server_id !=0 AND game_id=reg_game_id AND pay_date >='".$postData['start_date']." 00:00:00' AND pay_date <= '".$postData['end_date']." 23:59:59'";
        $sql ="SELECT SUM(paid_amount) as totalMoney, agent_id, game_id FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY agent_id, game_id";
        $data1tmp = $this ->model ->db ->find($sql);
        $data1 = array();
        foreach($data1tmp as $v){
            $data1[$v['agent_id']]['totalMoney'] += round($v['totalMoney'], 2);
            $data1[$v['agent_id']]['jiePay'] += round($v['totalMoney']*$gamelist[$v['game_id']]['fuildfc']/100, 2);
        }
        //内充
        $sql ="SELECT SUM(money) as tot, agent_id FROM ".PAYDB.'.'.PAYINNER." WHERE state =1 AND pay_type=2 AND pay_time>=".
            strtotime($postData['start_date'].' 00:00:00') . " AND pay_time<=".strtotime($postData['end_date'].' 23:59:59')." GROUP BY agent_id";
        $data2tmp = $this ->model ->db ->find($sql);
        $data2 = array();
        foreach($data2tmp as $v){
            $data2[$v['agent_id']]['innerPay'] += round($v['tot'], 2);
        }
        //公会数据
        $data = $vals=array();
        $hj=array('totalMoney' =>0,'totayInner' =>0,'totalJie' =>0);
        foreach($this ->guildlist as $k =>$v){
            $v['totalMoney'] = $data1[$k]['totalMoney'];
            $v['totayInner'] = $data2[$k]['innerPay'];
            $v['jieMoney'] = floor($data1[$k]['jiePay'] - round($data2[$k]['innerPay']*35/100));
            $data[] = $v;
            $hj['totalJie'] += $v['jieMoney'];
            $hj['totayInner'] += $v['totayInner'];
            $hj['totalMoney'] += $v['totalMoney'];
            $vals[$k] = $v['jieMoney']; //排序数组
        }
        array_multisort($vals, SORT_DESC, $data);
        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=pay_data.xls");
            echo   iconv("UTF-8", "GBK", $postData['start_date'])."\t";
            echo   iconv("UTF-8", "GBK", "至")."\t";
            echo   iconv("UTF-8", "GBK", $postData['end_date'])."\t";
            echo   "\n\n";
            echo   iconv("UTF-8", "GBK", "公会ID")."\t";
            echo   iconv("UTF-8", "GBK", "公会名")."\t";
            echo   iconv("UTF-8", "GBK", "充值总额")."\t";
            echo   iconv("UTF-8", "GBK", "内充金额")."\t";
            echo   iconv("UTF-8", "GBK", "结算金额")."\t";
            echo   iconv("UTF-8", "GBK", "开户人")."\t";
            echo   iconv("UTF-8", "GBK", "银行账户")."\t";
            echo   iconv("UTF-8", "GBK", "开户银行")."\t";
            echo   "\n";
            foreach($data as $v){
                if($v['totalMoney'] >0 or $v['totayInner']){
                    echo   $v['id']."\t";
                    echo   iconv("UTF-8", "GBK", $v['agentname'])."\t";
                    echo   $v['totalMoney']."\t";
                    echo   $v['totayInner']."\t";
                    echo   $v['jieMoney']."\t";
                    echo   iconv("UTF-8", "GBK", $v['account_name'])."\t";
                    echo   iconv("UTF-8", "GBK", "'".$v['account'])."\t";
                    echo   iconv("UTF-8", "GBK", $v['bank'])."\t";
                    echo   "\n";
                }
            }
            echo   iconv("UTF-8", "GBK", "合计：")."\t";
            echo   "\t";
            echo   $hj['totalMoney']."\t";
            echo   $hj['totayInner']."\t";
            echo   $hj['totalJie']."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   "\n";
            exit();
        }
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['start_date']);
    }
    //公会工资对账结算
    public function payjieToguild(){
        $postData = getRequest();
        if($postData['api']=='add'){
            $hj=array('totalpay' =>0,'totalinnerpay' =>0,'totalMoneyAll'=>0,'jie' =>0,'innerpay'=>0);
            if($postData['agentid'] > 0 && $postData['start_date']!=''&& $postData['end_date']!=''){
                $where =" WHERE game_id !=0 AND server_id !=0 AND agent_id=".$postData['agentid']." AND game_id=reg_game_id AND pay_date >='".$postData['start_date']." 00:00:00' AND pay_date <= '".$postData['end_date']." 23:59:59'";
                $sql ="SELECT SUM(money) as tot, game_id FROM ".PAYDB.'.'.PAYINNER." WHERE state =1 AND agent_id=".$postData['agentid']." AND pay_type=2  AND pay_time>=".
                    strtotime($postData['start_date'].' 00:00:00') . " AND pay_time<=".strtotime($postData['end_date'].' 23:59:59')." GROUP BY  game_id";
                $inner = $this ->model ->db ->find($sql);
                $inner_pay=array();
                foreach ($inner as $v){
                    $inner_pay[$v['game_id']]=$v['tot'];
                }
                $sql ="SELECT SUM(paid_amount) as totalMoney, game_id FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY  game_id";
                $list= $this ->model ->db ->find($sql);
                $pay_list=array();
                foreach ($list as $v){
                    $pay_list[$v['game_id']]=$v['totalMoney'];
                }
                $sql=" select * from ".PAYDB.".".GAMELIST." where is_open=1";
                $gameid=$this ->model ->db ->find($sql);
                $gamelist=array();;
                foreach ($gameid as $v){
                    $gamelist[]=$v;
                }
                $data=$pay=array();
                foreach ($gameid as $v){
                    $pay['game_id']=$v['id'];
                    $pay['fanliv'] = $v['fuildfc'];
                    $pay['gamename'] =$v['name'];
                    $pay['totalMoney'] = round($pay_list[$v['id']], 2);
                    $pay['fanli'] = round($pay['totalMoney']*$v['fuildfc']/100, 2);
                    $pay['innerpay'] = $inner_pay[$v['id']];
                    $pay['innerpayfl'] = round($pay['innerpay']*0.35, 2);
                    $pay['jie'] = round($pay['fanli']-$pay['innerpayfl'],2);
                    $hj['totalpay'] += $pay['totalMoney'];
                    $hj['totalinnerpay'] += $pay['innerpay'];
                    $hj['jie'] += $pay['jie'];
                    $hj['totalMoneyAll'] +=$pay['totalMoney'];
                    $hj['innerpay'] += $pay['innerpayfl'];
                    $data[]=$pay;
                }
                $this ->smarty ->assign('data', $data);
                if($postData['sub']==1){
                    $totalpayjie = 0;
                    if(is_array($postData['payjie'])){
                        foreach ($postData['payjie'] as $v2){
                            $totalpayjie += $v2;
                        }
                    }
                    $sql ="INSERT INTO ".PAYDB.'.'.PAYJIE." SET agent_id=".$postData['agentid'].", sDate='".$postData['start_date']."', 
                        eDate='".$postData['end_date']."', payMoney=".$hj['totalpay'].", 
                        innerMoney=".floor($hj['totalinnerpay']).", jieMoney=".floor($totalpayjie).", jieTu='".$postData['fileUrl']."', subre='".serialize($postData)."',  
                        jieTime=".time().", admin_id=".$this ->adminfo['uid'];
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:EndOp"));
                }
            }
            $this ->smarty ->assign('hj',$hj);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addToGuildJie.html");
            exit();
        }else if($postData['api']=='detail'){
            $sql ="SELECT subre FROM ".PAYDB.'.'.PAYJIE." WHERE id=".intval($postData['id']);
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
                $this ->smarty ->assign('date_time', $res);
            }
            $this ->smarty ->display($postData['action']."/GuildDetailJie.html");
            exit;
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1,'totalMoney' =>0);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE 1 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .='AND agent_id ='.intval($postData['agentid']);
        }
        if($postData['start_date'] !=''){
            $where .= " AND sDate >='".$postData['start_date']."'";
        }
        if($postData['end_date'] !=''){
            $where .= " AND sDate <= '".$postData['end_date']."'";
        }
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYJIE.$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYJIE.$where." ORDER BY jieTime DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            if(!empty($v['intotime'])){
                $v['jieTime']=$v['intotime'];
            }else{
                $v['jieTime'] =date("Y-m-d H:i:s", $v['jieTime']);
            }
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $data[] = $v;
        }
        // 充值总金额统计
        $sql = "SELECT sum(jieMoney) as jieMoney FROM ".PAYDB.'.'.PAYJIE.$where;
        $tmp2 = $this ->model ->db ->get($sql);
        $totalMoney = $tmp2['jieMoney'];
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('totalMoney', $totalMoney);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }

    //发放VIP
    public function extendVipPay(){
        set_time_limit(300);
        $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        $where1=" where 1";
        if($postData['api']=='add'){
            if($postData['sub']==1){
                if($postData['pay_money'] >10 || $postData['pay_money'] <1){
                    ajaxReturn('金额必须在1~10以内！',300);
                }
                $game = $gamelist[$postData['game_id']];
                if(!is_array($game) || $postData['server_id'] <1 || $postData['agentid'] <1 || $postData['account_list'] ==''){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                $userlist = explode("\r\n", $postData['account_list']);
                foreach($userlist as $v){
                    if(trim($v) != ''){
                        $user_name = trim($v);
                        $sql =" SELECT * FROM ".PAYDB.'.'.PAYVIP." WHERE state =1 AND user_name='".$user_name."' AND game_id=".$postData['game_id']." AND server_id=".$postData['server_id'];
                        $user = $this ->model ->db ->get($sql);
                        if(is_array($user) && $user['id'] > 0){
                            continue;
                        }
                        $orderid = 'V9494'.date("YmdHis"). mt_rand(1000000, 9999999);
                        $money = $postData['pay_money'];
                        $b_num = $money*$game['exchange_rate'];
                        $time = time();
                        $pay_ip = GetIP();
                        $game_id = $postData['game_id'];
                        $server_id= $postData['server_id'];
                        $flag = md5($time.KEY_HDPAY.$user_name.$game_id.$server_id.$pay_ip);
                        $post_str = "user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&flag=".$flag."&pay_ip=".$pay_ip."&orderid=".$orderid;
                        $ch = curl_init( );
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch, CURLOPT_URL, PAYGLOD_URL);
                        curl_setopt( $ch, CURLOPT_POST, TRUE);
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
                        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                        $contents = curl_exec( $ch );
                        curl_close( $ch );
                        unset($ch);
                        $sql ="INSERT INTO ".PAYDB.'.'.PAYVIP." SET orderid='".$orderid."', user_name='".$user_name."', agent_id=".$postData['agentid'].", place_id=".$postData['placeid'].",
                            game_id=".$game_id.", server_id=".$server_id.", money='".$money."', gold=".$b_num.", pay_time=".time().", admin_id=".$this ->adminfo['uid'].", state=".intval($contents);
                        $this ->model ->db ->query($sql);
                    }
                }
                ajaxReturn(C("Ok:EndOp"));
            }
            if($postData['game_id'] > 0){
                $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
                $this ->smarty ->assign('serverlist', $serverlist);
            }
            if($postData['agentid'] >0 && $postData['game_id'] > 0 && $postData['server_id'] > 0){
                $sql ="SELECT user_name FROM ".USERDB.".".REGINDEX.date("Y")." WHERE 1 AND agent_id=".$postData['agentid']." AND game_id=".$postData['game_id']." AND server_id=".$postData['server_id'];
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
            $this ->smarty ->display($postData['action']."/addVipPay.html");
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
        $where =' WHERE 1 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND a.agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['placeid'] >0){
            $where .= " AND a.place_id =".$postData['placeid'];
        }
        if($postData['game_id'] >0){
            $where .= " AND a.game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['server_id'] >0){
            $where .= " AND a.server_id =".$postData['server_id'];
        }
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        $where .= " AND  a.pay_time >= '".strtotime($postData['start_date']." 00:00:00")."' AND a.pay_time <='".strtotime($postData['end_date']."23:59:59")."'";

        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYVIP." as a ".$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYVIP." as a ".$where." ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        $userlist=  parent::getUserList();
        foreach ($res as $v){
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['addUser']=$userlist[$this ->guildlist[$v['agent_id']]['adduid']]['uName'];
            $v['pay_date']=date('Y-m-d H:i:s',$v['pay_time']);
            $data[] = $v;
        }
        //导出查询
        $sql = mysql_query( " select a.orderid,a.user_name,b.name,a.server_id,a.money,a.gold, c.agentname,c.addUser,FROM_UNIXTIME(a.pay_time),a.state from ".PAYDB.'.'.PAYVIP." as a "
            ."left join ".PAYDB.'.'.GAMELIST." as b on a.game_id=b.id "
            ."left join ".GUILDINFO." as c on a.agent_id=c.id AND c.id=a.agent_id "
            .$where);
        $myrow=$myrow = mysql_fetch_assoc($sql);
        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=pay_data.xls");
            echo   iconv("UTF-8", "GBK", "订单号")."\t";
            echo   iconv("UTF-8", "GBK", "充值账号")."\t";
            echo   iconv("UTF-8", "GBK", "充值游戏")."\t";
            echo   iconv("UTF-8", "GBK", "服区")."\t";
            echo   iconv("UTF-8", "GBK", "充值金额")."\t";
            echo   iconv("UTF-8", "GBK", "充值元宝")."\t";
            echo   iconv("UTF-8", "GBK", "充值公会")."\t";
            echo   iconv("UTF-8", "GBK", "公会添加人")."\t";
            echo   iconv("UTF-8", "GBK", "充值时间")."\t";
            echo   iconv("UTF-8", "GBK", "结果（1为成功，0为失败）")."\t";
            echo   "\n";
            while ($myrow=  mysql_fetch_assoc($sql)){
                foreach($myrow as  $v){
                    echo   iconv("UTF-8", "GBK",$v)."\t";
                }
                echo   "\n";
            }
            exit();
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //首充记录
    public function extendFirstPay(){
        set_time_limit(300);
        $postData = getRequest();
        $gamelist = parent::getGameList();
        if($postData['api']=='add'){
            if($postData['sub']==1){
                $game = $gamelist[$postData['game_id']];
                if(!is_array($game) || $postData['server_id'] <1 || $postData['agentid'] <1 || $postData['account_list'] ==''){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                $userlist = explode("\r\n", $postData['account_list']);
                foreach($userlist as $v){
                    if(trim($v) != ''){
                        $ltime = strtotime(date("Y-m-d")." 00:00:00");
                        $user_name = trim($v);
                        $sql =" SELECT count(*) as total FROM ".PAYDB.'.'.PAYFIRST." WHERE state =1 AND pay_time >".$ltime." AND user_name='".$user_name."' AND game_id=".$postData['game_id']." AND server_id=".$postData['server_id'];
                        $co2 = $this ->model ->db ->count($sql);
                        if($co2 >0){
                            continue;
                        }
                        $sql =" SELECT count(*) as total FROM ".PAYDB.'.'.PAYFIRST." WHERE state =1 AND user_name='".$user_name."'";
                        $user = $this ->model ->db ->get($sql);
                        //该账号发过5次首冲
                        if($user['total'] > 7){
                            continue;
                        }
                        $orderid = 'F9494'.date("YmdHis"). mt_rand(1000000, 9999999);
                        $game_id = $postData['game_id'];
                        $money = 1;
                        $b_num = $money*$game['exchange_rate'];
                        $time = time();
                        $pay_ip = GetIP();
                        $server_id= $postData['server_id'];
                        $flag = md5($time.KEY_HDPAY.$user_name.$game_id.$server_id.$pay_ip);
                        $post_str = "user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&flag=".$flag."&pay_ip=".$pay_ip."&orderid=".$orderid;
                        $ch = curl_init( );
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                        curl_setopt( $ch, CURLOPT_URL, PAYGLOD_URL );
                        curl_setopt( $ch, CURLOPT_POST, TRUE);
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
                        curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                        $contents = curl_exec( $ch );
                        curl_close( $ch );
                        unset($ch);
                        $sql ="INSERT INTO ".PAYDB.'.'.PAYFIRST." SET orderid='".$orderid."', user_name='".$user_name."', agent_id=".$postData['agentid'].", place_id=".$postData['placeid'].",
                            game_id=".$game_id.", server_id=".$server_id.", money=".$money.", gold=".$b_num.", pay_time=".time().", admin_id=".$this ->adminfo['uid'].", state=".intval($contents);
                        $this ->model ->db ->query($sql);
                    }
                }
                ajaxReturn(C("Ok:EndOp"));
            }
            if($postData['game_id'] > 0){
                $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
                $this ->smarty ->assign('serverlist', $serverlist);
            }
            if($postData['agentid'] >0 && $postData['game_id'] > 0 && $postData['server_id'] > 0){
                $sql ="SELECT user_name FROM ".USERDB.".".REGINDEX.date("Y")." WHERE  agent_id=".$postData['agentid']." AND game_id=".$postData['game_id']." AND server_id=".$postData['server_id'];
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
            $this ->smarty ->assign('guildlist', $this->guildlist);
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
        $where =' WHERE 1 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND a.agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['placeid'] >0){
            $where .= " AND a.place_id =".$postData['placeid'];
        }
        if($postData['game_id'] >0){
            $where .= " AND a.game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['server_id'] >0){
            $where .= " AND a.server_id =".$postData['server_id'];
        }
        if($postData['adm_id'] ==10000){ //公会发放
            $where .= " AND a.admin_id >= 10000";
        }else if($postData['adm_id'] >0){
            $where .= " AND a.admin_id =".$postData['adm_id'];
        }
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        $where .= " AND  a.pay_time >= '".strtotime($postData['start_date']." 00:00:00")."' AND a.pay_time <='".strtotime($postData['end_date']."23:59:59")."'";
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYFIRST." as a ".$where." and a.state=1";
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYFIRST." as a ".$where." ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        $userlist=  parent::getUserList();
        foreach ($res as $v){
            if($v['admin_id'] >=10000){
                $v['checker'] = '公会发放';
            }elseif($v['admin_id'] ==0){
                $v['checker'] ="玩家领取（".$v['user_name'].")";//玩家领取
            }else{
                $v['checker'] =$userlist[$v['admin_id']]['uName'];
            }
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['pay_date']=date('Y-m-d H:i:s',$v['pay_time']);
            $v['adduser']=$userlist[$this ->guildlist[$v['agent_id']]['adduid']]['uName'];
            $data[] = $v;
        }
        //导数数据查询
        if($postData['api'] =='export'){
            $sql  = " SELECT a.orderid, a.user_name, b.name,a.server_id,a.money,a.gold,c.agentname,FROM_UNIXTIME(a.pay_time),d.uName,c.addUser,a.state FROM ".PAYDB.'.'.PAYFIRST." as a 
                    left join ".PAYDB.'.'.GAMELIST." as b on a.game_id=b.id 
                    left join ".GUILDINFO." as c on  c.id=a.agent_id
                    left join ".ADMINUSERS." as d on d.uid=a.admin_id ".$where." and a.state=1";
            $result=mysql_query($sql);
        }
        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=firstpay_data.xls");
            echo   iconv("UTF-8", "GBK", "订单号")."\t";
            echo   iconv("UTF-8", "GBK", "充值账号")."\t";
            echo   iconv("UTF-8", "GBK", "充值游戏")."\t";
            echo   iconv("UTF-8", "GBK", "服区")."\t";
            echo   iconv("UTF-8", "GBK", "充值金额")."\t";
            echo   iconv("UTF-8", "GBK", "充值元宝")."\t";
            echo   iconv("UTF-8", "GBK", "充值公会")."\t";
            echo   iconv("UTF-8", "GBK", "充值时间")."\t";
            echo   iconv("UTF-8", "GBK", "操作人")."\t";
            echo   iconv("UTF-8", "GBK", "添加人")."\t";
            echo   iconv("UTF-8", "GBK", "状态(0为失败，1为成功)")."\t";
            echo   "\n";
            while($myrow = mysql_fetch_assoc($result)){
                foreach($myrow as  $v){
                    if($v ==''){
                        echo   iconv("UTF-8", "GBK", "公会会长")."\t";
                    }else{
                        echo   iconv("UTF-8", "GBK", $v)."\t";
                    }
                }
                echo   "\n";
            }
            exit();
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('userlist', $userlist);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }

    //审核内部充值
    public function examineInnerPay(){
        $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        if($postData['api']=='add'){
            if($postData['id'] <1){
                ajaxReturn(C("Error:ParamNotIsNull"), 300);
            }
            $sql ="SELECT * FROM ".PAYDB.'.'.PAYINNER." WHERE id=".intval($postData['id'])." AND state=0";
            $oInfo = $this ->model ->db ->get($sql);
            if($oInfo['id'] <1){
                ajaxReturn(C("Error:ParamNotIsNull"), 300);
            }
            if($postData['sub']==1){
                $game = $gamelist[$postData['game_id']];
                if(!is_array($game) || $postData['server_id'] <1 || $postData['pay_money'] <1 || $postData['account'] ==''|| $postData['user_role']==''){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                if($postData['pay_money'] > 1000){
                    ajaxReturn(C("Error:PayOutOfMax"), 300);
                }
                if($postData['pay_pass'] !=PASSWORD_PAY){
                    ajaxReturn(C("Error:PassError"), 300);
                }
                $user_name = trim($postData['account']);
                //判断所选公会是否是该玩家的当前注册渠道公会
                $sql ="SELECT * FROM ".USERDB.".".USERS." WHERE user_name='".$user_name."'";
                $user2 = $this ->model ->db ->get($sql);
                if($user2['agent_id']!=$postData['agentid']){
                    ajaxReturn(C("Error:AgentSelected"), 300);
                }
                //判断结束
                $orderid = $oInfo['orderid'];
                $money = intval($postData['pay_money']);
                $b_num = $money*$game['exchange_rate'];
                $time = time();
                $pay_ip = GetIP();
                $game_id = $postData['game_id'];
                $server_id= $postData['server_id'];
                $flag = md5($time.KEY_HDPAY.$user_name.$game_id.$server_id.$pay_ip);
                $post_str = "user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&flag=".$flag."&pay_ip=".$pay_ip."&orderid=".$orderid;
                $ch = curl_init( );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch, CURLOPT_URL, PAYGLOD_URL );
                curl_setopt( $ch, CURLOPT_POST, TRUE);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
                curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                $contents = curl_exec( $ch );
                curl_close( $ch );
                unset($ch);
                if($contents ==1){
                    $sql ="UPDATE ".PAYDB.'.'.PAYINNER." SET orderid='".$orderid."', reason='".$postData['reason']."', pay_type=".intval($postData['pay_type']).", user_name='".$user_name."',user_role='".$postData['user_role']."', agent_id=".$postData['agentid'].", place_id=".$postData['placeid'].",
                        game_id=".$game_id.", server_id=".$server_id.", money=".$money.", gold=".$b_num.", check_time=".time().", check_uid=".$this ->adminfo['uid'].", state=1 where id=".$postData['id'];
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:InnerPay"));
                }else{
                    ajaxReturn(C("Error:OprateFail"), 300);
                }
            }
            //游戏区服列表
            $serverlist = parent::getGameServers($oInfo['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
            //公会成员列表
            $guildmembers = parent::getGuildMembers($this ->guildlist[$oInfo['agent_id']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
            $this ->smarty ->assign('info', $oInfo);
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addexamineInnerPay.html");
            exit();
        } if($postData['api'] =='refuse'){  //拒绝内充
            if($postData['id'] >0){
                $sql ="UPDATE ".PAYDB.'.'.PAYINNER." SET state=2,check_uid=".$this->adminfo['uid'].",check_time=".time()." WHERE id=".$postData['id'];
                $this ->model ->db ->query($sql);
                ajaxReturn(C("Ok:EndOp"));
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
        $where =' WHERE state=0  ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['placeid'] >0){
            $where .= " AND place_id =".$postData['placeid'];
        }
        if($postData['game_id'] >0){
            $where .= " AND game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['pay_type'] >0){
            $where .= " AND pay_type =".$postData['pay_type'];
        }
        if($postData['server_id'] >0){
            $where .= " AND server_id =".$postData['server_id'];
        }
        if($postData['start_date'] !=''){
            $where .= " AND pay_time >=".strtotime($postData['start_date']);
        }
        if($postData['end_date'] !=''){
            $where .= " AND pay_time <=".strtotime($postData['end_date']." 23:59:59");
        }
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYINNER.$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYINNER.$where." ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $data[] = $v;
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }

    //内部充值
    public function applyInnerPay(){
        $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        $userslist=  parent::getUserList();
        $where1=" where 1";
        if($postData['api']=='add'){
            if($postData['sub']==1){
                $game = $gamelist[$postData['game_id']];
                if(!is_array($game) || $postData['server_id'] <1 || $postData['pay_money'] <1 || $postData['account'] ==''|| $postData['user_role']=='' || $postData['to_uid']==0){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                if($postData['pay_money'] > 1000){
                    ajaxReturn(C("Error:PayOutOfMax"), 300);
                }
                $user_name = trim($postData['account']);
                //判断所选公会是否是该玩家的当前注册渠道公会
                $sql ="SELECT * FROM ".USERDB.".".USERS." WHERE user_name='".$user_name."'";
                $user2 = $this ->model ->db ->get($sql);
                if($user2['agent_id']!=$postData['agentid']){
                    ajaxReturn(C("Error:AgentSelected"), 300);
                }
                //判断结束
                $orderid = 'N9494'.date("YmdHis"). mt_rand(1000000, 9999999);
                $money = intval($postData['pay_money']);
                $b_num = $money*$game['exchange_rate'];
                $time = time();
                $pay_ip = GetIP();
                $game_id = $postData['game_id'];
                $server_id= $postData['server_id'];
                $contents =0;
                $sql ="INSERT INTO ".PAYDB.'.'.PAYINNER." SET orderid='".$orderid."', reason='".trim($postData['reason'])."', 
                    pay_type=".intval($postData['pay_type']).", user_name='".$user_name."',user_role='".$postData['user_role']."',
                    agent_id=".$postData['agentid'].", place_id=".$postData['placeid'].", to_uid=".$postData['to_uid'].",
                    game_id=".$game_id.", server_id=".$server_id.", money=".$money.", gold=".$b_num.", pay_time=".time().", admin_id=".$this ->adminfo['uid'].", state=".$contents;
                $this ->model ->db ->query($sql);
                ajaxReturn(C("Ok:InnerPay"));
            }
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addapplyInnerPay.html");
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
        $where =' WHERE  state >0 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['state'] !=''){
            $postData['state'] == -1 &&  $where .= " AND state =0";
            $postData['state'] >0 && $where .= " AND state =".$postData['state'];
        }
        if($postData['admin_uid'] >0){
            $where .= " AND admin_id =".$postData['admin_uid'];
        }
        if($postData['game_id'] >0){
            $where .= " AND game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['pay_type'] >0){
            $where .= " AND pay_type =".$postData['pay_type'];
        }
        if($postData['server_id'] >0){
            $where .= " AND server_id =".$postData['server_id'];
        }
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        $where .= " AND pay_time >=".strtotime($postData['start_date']." 00:00:00")." AND pay_time <=".strtotime($postData['end_date']." 23:59:59");
        $sql = "SELECT sum(money) as totalMoney FROM ".PAYDB.'.'.PAYINNER.$where;
        $tmp2 = $this ->model ->db ->get($sql);
        $tot = $tmp2['totalMoney'];
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYINNER.$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        if($postData['api'] =='export'){
            $limit ='';
            if($pageInfo['totalcount'] >10000){$limit = " LIMIT 10000";}
            $sql = "SELECT * FROM ".PAYDB.'.'.PAYINNER.$where." and `state` <>0 ORDER BY pay_time DESC".$limit;
        }else{
            $sql = "SELECT * FROM ".PAYDB.'.'.PAYINNER.$where." ORDER BY pay_time DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        }
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            $v['time']=  date('Y-m-d H:i:s',$v['pay_time']);
            $v['reasonshot'] = csubstr(preg_replace("/(\r\n|\n|\r|\t)/i", '', $v['reason']), 0, 8);
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['checkuser'] = $userslist[$v['check_uid']]['uName'];
            $data[] = $v;
        }
        //导数据
        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=pay_inner.xls");
            echo   iconv("UTF-8", "GBK", "订单号")."\t";
            echo   iconv("UTF-8", "GBK", "充值账号")."\t";
            echo   iconv("UTF-8", "GBK", "角色名")."\t";
            echo   iconv("UTF-8", "GBK", "充值游戏")."\t";
            echo   iconv("UTF-8", "GBK", "服区")."\t";
            echo   iconv("UTF-8", "GBK", "充值金额")."\t";
            echo   iconv("UTF-8", "GBK", "充值元宝")."\t";
            echo   iconv("UTF-8", "GBK", "充值公会")."\t";
            echo   iconv("UTF-8", "GBK", "充值时间")."\t";
            echo   iconv("UTF-8", "GBK", "充值类型")."\t";
            echo   iconv("UTF-8", "GBK", "申请人")."\t";
            echo   iconv("UTF-8", "GBK", "充值结果")."\t";
            echo   iconv("UTF-8", "GBK", "审核人")."\t";
            echo   iconv("UTF-8", "GBK", "备注")."\t";
            echo   "\n";
            foreach($data as  $v){
                echo   iconv("UTF-8", "GBK",$v['orderid'])."\t";
                echo   $v['user_name']."\t";
                echo   iconv("UTF-8", "GBK", $v['user_role'])."\t";
                echo   iconv("UTF-8", "GBK",$v['gamename'])."\t";
                echo   iconv("UTF-8", "GBK","S".$v['server_id'])."\t";
                echo   $v['money']."\t";
                echo   $v['gold']."\t";
                echo   iconv("UTF-8", "GBK", $v['agentname'])."\t";
                echo   $v['time']."\t";
                if($v['pay_type']==2){echo   iconv("UTF-8", "GBK", "公会赔付")."\t";}
                else {echo   iconv("UTF-8", "GBK", "平台垫付")."\t";}
                if($v['is_guild']==0){
                    echo   iconv("UTF-8", "GBK", $v['to_user'])."\t";
                }else{
                    echo   iconv("UTF-8", "GBK", $v['agentname'])."\t";
                }
                if($v['state']==1){echo   iconv("UTF-8", "GBK", "已成功发放")."\t";}
                else if($v['state']==2){echo   iconv("UTF-8", "GBK", "该申请被拒绝")."\t";}
                echo   iconv("UTF-8", "GBK", $v['checkuser'])."\t";
                echo   iconv("UTF-8", "GBK", $v['reasonshot'])."\t";
                echo   "\n";
            }
            exit();
        }

        $this ->smarty ->assign('tot', $tot);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('userslist', $userslist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }

    //玩家充值统计
    public function rechargeListData(){
        $postData = getRequest();
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE a.game_id !=0 AND a.server_id !=0 ';
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND a.agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        if($postData['placeid']>0){
            $where .= ' AND a.placeid ='.$postData['placeid'];
        }
        if(empty($postData['start_date'])){
            $postData['start_date']=date('Y-m')."-01";
        }
        if(empty($postData['end_date'])){
            $postData['end_date']=date('Y-m-d');
        }
        $where .= " AND  a.pay_date >= '".$postData['start_date']." 00:00:00'  AND a.pay_date <='".$postData['end_date']." 23:59:59'";
        if($postData['game_id'] >0){
            $where .= " AND a.game_id =".$postData['game_id'];
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist', $serverlist);
        }
        if($postData['server_id'] >0){
            $where .= " AND a.server_id =".intval($postData['server_id']);
        }
        if($postData['user_role'] !=''){
            $where .= " AND (a.user_role ='".$postData['user_role']."' or a.user_name ='".$postData['user_role']."')";
        }
        if($postData['pay_way_id'] > 0){
            $where .= " AND (a.pay_way_id ='".$postData['pay_way_id']."')";
        }
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.'.'.PAYLIST." as a ".$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];

        $sql = "SELECT * FROM ".PAYDB.'.'.PAYLIST." as a ".$where." ORDER BY pay_date DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $gamelist = parent::getGameList();   //获取游戏列表
        $userslist=  parent::getUserList(); //管理员列表
        include(ROOT . 'configs/pay_way.inc.php');//加载充值渠道配置
        foreach($data as $k => $v){
            $data[$k]['reggamename'] = $gamelist[$v['reg_game_id']]['name'];
            $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['pay_way_name'] = $pay_way_arr[$v['pay_way_id']]['payname'];
            $data[$k]['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $data[$k]['addUser']=$userslist[$this ->guildlist[$v['agent_id']]['adduid']]['uName'];
        }
        //统计总金额
        $sql = "SELECT SUM(paid_amount) AS totalMoney FROM ".PAYDB.'.'.PAYLIST." as a ".$where;
        $res2 = $this ->model ->db ->get($sql);
        array_multisort($res2, SORT_DESC, $data);
        //导数数据查询
        $sql  =" select a.orderid,a.user_name,b.name,a.server_id,a.user_role,a.paid_amount,c.agentname,c.adduid,a.pay_date from  ".PAYDB.'.'.PAYLIST." as a "
            . " left join ".PAYDB.'.'.GAMELIST." as b on a.game_id=b.id "
            . " left join ".GUILDINFO." as c on a.agent_id=c.id AND c.id=a.agent_id ".$where;
        $myrow = mysql_query($sql);
        //导出信息
        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=pay_data.xls");
            echo   iconv("UTF-8", "GBK", "订单号")."\t";
            echo   iconv("UTF-8", "GBK", "充值账号")."\t";
            echo   iconv("UTF-8", "GBK", "游戏")."\t";
            echo   iconv("UTF-8", "GBK", "服区")."\t";
            echo   iconv("UTF-8", "GBK", "玩家角色")."\t";
            echo   iconv("UTF-8", "GBK", "充值金额")."\t";
            echo   iconv("UTF-8", "GBK", "公会名")."\t";
            echo   iconv("UTF-8", "GBK", "添加人")."\t";
            echo   iconv("UTF-8", "GBK", "到账时间")."\t";
            echo   "\n";
            while ($row = mysql_fetch_assoc($myrow)){
                foreach($row as $k => $v){
                    if ($k == 'adduid') {
                        echo   iconv("UTF-8", "GBK", $userslist[$v]['uName'])."\t";
                    } else {
                        echo   iconv("UTF-8", "GBK",$v)."\t";
                    }
                }
                echo "\n";
            }
            echo   iconv("UTF-8", "GBK", "合计：")."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   "----"."\t";
            echo   round($res2['totalMoney'],2)."\t";
            echo   "\n";
            exit();
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('totalMoney', round($res2['totalMoney'],2));
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
        $this ->smarty ->assign('pay_way_arr', $pay_way_arr);
    }
    //审核公会申请内充
    public function examineInnerGuild(){
        date_default_timezone_set("Asia/Shanghai");
        $postData = getRequest();
        $guildlist=$this ->guildlist;
        $gamelist = parent::getGameList();
        if($postData['api'] =='add'){
            if($postData['id'] >0){
                $sql="select * from ".PAYDB.".".INNERGUILD." where id=".$postData['id']." and state =0";
                $data2=$this ->model ->db ->find($sql);
                $inner =array();
                foreach ($data2 as $v){
                    $v['uAccount_name'] = $v['user_name'];
                    $v['gamename'] =$gamelist[$v['game_id']]['name'];
                    $v['agentname'] =$guildlist[$v['agent_id']]['agentname'];
                    $inner[]=$v;
                }
            }
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->assign('inner',$inner);
            if($postData['sub']==1){
                $game = $gamelist[$postData['game_id']];
                if(!is_array($game) || $postData['server_id'] <1 || $postData['pay_money'] <1 || $postData['user_name'] ==''|| $postData['user_role']==''){
                    ajaxReturn(C("Error:ParamNotIsNull"), 300);
                }
                $postData['placeid'] <1 && $postData['placeid'] =0;
                if($postData['pay_money'] > 1000){
                    ajaxReturn(C("Error:PayOutOfMax"), 300);
                }
                if($postData['pay_pass'] !=PASSWORD_PAY){
                    ajaxReturn(C("Error:PassError"), 300);
                }
                $user_name = trim($postData['user_name']);
                //判断所选公会是否是该玩家的当前注册渠道公会
                $sql ="SELECT * FROM ".USERDB.".".USERS." WHERE user_name='".$user_name."'";
                $user2 = $this ->model ->db ->get($sql);
                if($user2['agent_id']!=$postData['agent_id']){
                    ajaxReturn(C("Error:AgentSelected"), 300);
                }
                //判断结束
                $orderid = $postData['orderid'];
                $money = intval($postData['pay_money']);
                $b_num = $money*$game['exchange_rate'];
                $time = time();
                $pay_ip = GetIP();
                $game_id = $postData['game_id'];
                $server_id= $postData['server_id'];
                $flag = md5($time.KEY_HDPAY.$user_name.$game_id.$server_id.$pay_ip);
                $post_str = "user_name=".$user_name."&time=".$time."&game_id=".$game_id."&server_id=".$server_id."&b_num=".$b_num."&money=".$money."&flag=".$flag."&pay_ip=".$pay_ip."&orderid=".$orderid;
                $ch = curl_init( );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch, CURLOPT_URL, PAYGLOD_URL);
                curl_setopt( $ch, CURLOPT_POST, TRUE);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_str);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
                curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                $contents = curl_exec( $ch );
                curl_close( $ch );
                unset($ch);
                if($contents ==1){
                    $sql=" select id from ".PAYDB.'.'.PAYINNER." where orderid='".$postData['orderid']."'";
                    $hav=$this ->model ->db ->get($sql);
                    if($hav['id'] >0){
                        $sql ="update ".PAYDB.'.'.PAYINNER." SET  check_time=".time().", check_uid=".$this ->adminfo['uid'].", state=".$contents." where id=".$hav['id'];
                    }else{
                        $sql ="INSERT ".PAYDB.'.'.PAYINNER." SET orderid='".$postData['orderid']."', reason='".$postData['reason']."', pay_type=2, user_name='".$postData['user_name']."',user_role='".$postData['user_role']."', agent_id=".$postData['agent_id'].", place_id=".$postData['agent_id'].
                            ",game_id=".$postData['game_id'].", server_id=".$postData['server_id'].", money=".$postData['pay_money'].", gold=".$postData['gold'].",pay_time=".$postData['pay_time'].", check_time=".time().", check_uid=".$this ->adminfo['uid'].",is_guild=1, state=".$contents;
                    }
                    $this ->model ->db ->query($sql);
                    $sql ="UPDATE ".PAYDB.'.'.INNERGUILD." SET state=".$contents.",check_uid=".$this ->adminfo['uid'].",check_time=".time()." where id=".$postData['id'];
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:InnerPay"));
                }else{
                    ajaxReturn(C("Error:OprateFail"), 300);
                }
            }
            $this ->smarty ->display($postData['action']."/addInnerGuild.html");
            exit();
        }elseif ($postData['api'] =='refuse') {  //拒绝
            if($postData['id'] >0){
                $sql="select * from ".PAYDB.".".INNERGUILD." where id=".$postData['id'];
                $upinner= $this ->model ->db ->get($sql);

                $sql ="INSERT ".PAYDB.'.'.PAYINNER." SET orderid='".$upinner['orderid']."', reason='".$upinner['reason']."', pay_type=2, user_name='".$upinner['user_name']."',user_role='".$upinner['user_role']."', agent_id=".$upinner['agent_id'].", place_id=".$upinner['agent_id'].",
                       game_id=".$upinner['game_id'].", server_id=".$upinner['server_id'].", money=".$upinner['money'].", gold=".$upinner['gold'].",pay_time=".$upinner['pay_time'].", check_time=".time().", check_uid=".$this ->adminfo['uid'].",is_guild=1, state=2";
                $this ->model ->db ->query($sql);
                $sql ="UPDATE ".PAYDB.'.'.INNERGUILD." SET state=2,check_uid=".$this ->adminfo['uid'].",check_time=".time()." where id=".$postData['id'];
                $this ->model ->db ->query($sql);
                ajaxReturn(C("Ok:EndOp"));
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
        $where=" where state=0 ";
        if(!empty($postData['start_date'])){
            $where.=" and a.pay_time >=".strtotime($postData['start_date']." 00:00:00");
        }
        if(!empty($postData['end_date'])){
            $where.=" and a.pay_time <=".strtotime($postData['end_date']." 23:59:59");
        }
        if($postData['game_id'] >0){
            $where.=" and a.game_id =".$postData['game_id'];
        }
        if($postData['server_id'] >0){
            $where.=" and a.server_id =".$postData['server_id'];
        }
        if($postData['agentid'] >0){
            $where.=" and a.agent_id =".$postData['agentid'];
        }
        //总数
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.".".INNERGUILD." as a ".$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];

        $sql="select * from ".PAYDB.".".INNERGUILD.$where." LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data1=$this ->model->db ->find($sql);
        $data =array();
        foreach ($data1 as $v){
            $v['gamename'] =$gamelist[$v['game_id']]['name'];
            $v['agentname'] =$guildlist[$v['agent_id']]['agentname'];
            $data[]=$v;
        }
        $this ->smarty ->assign('data',$data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //公会上周工资查询统计
    public function guildWeekJieSearch() {
        $postData = getRequest();
        $gamelist=  parent::getGameList();
        if($postData['start_date'] ==''){
            $postData['start_date']=date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))); //上周一
        }
        if($postData['end_date'] ==''){
            $postData['end_date']=date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))); //上周日
        }
        if($postData['api'] =='detail'){
            if($postData['agentid'] >0){
                $sql=" select game_id ,sum(pay_amount) as paymoney,sum(pay_inner) as innerpay,fc,sum(pay_jie) as pay_jie from ".PAYDB.'.'.GUILDWEEK.
                    " where agent_id =".$postData['agentid']." and wsdate >=".str_replace('-','',$postData['wsdate'])." and wedate <=".str_replace('-','',$postData['wedate'])." group by game_id";
                $info=$this ->model ->db ->find($sql);
                $data=$hj=array();;
                foreach ($info  as $v){
                    $v['stime']=$postData['wsdate'];
                    $v['etime']=$postData['wedate'];
                    $v['gamename']=$gamelist[$v['game_id']]['name'];
                    $v['pay']=$v['paymoney'] * $v['fc']/100;
                    $v['inner']=$v['innerpay'] * 0.35;
                    $data[]=$v;
                    $hj['heji'] +=$v['paymoney'];
                    $hj['payinner'] +=$v['inner'];
                    $hj['pay_jie'] +=$v['pay_jie'];
                }
            }
            $this ->smarty ->assign('data', $data);
            $this ->smarty ->assign('hj', $hj);
            $this ->smarty ->display($postData['action']."/guildMoney.html");
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
        $where =" WHERE  wsdate >= ".str_replace('-','',$postData['start_date'])." and wedate <=".str_replace('-','',$postData['end_date']); //数据条件
        if($postData['agentid'] >0 && is_array($this ->guildlist[$postData['agentid']])){
            $where .=' AND agent_id ='.intval($postData['agentid']);
            $guildmembers = parent::getGuildMembers($this ->guildlist[$postData['agentid']]);
            $this ->smarty ->assign('guildmembers', $guildmembers);
        }
        $sql = "SELECT COUNT(distinct(agent_id)) AS total FROM ".PAYDB.'.'.GUILDWEEK.$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        if($postData['api']=='export'){
            $sqld=" update ".PAYDB.'.'.GUILDWEEK." set state=1 ".$where." and state=0";
            $this ->model ->db ->query($sqld);
            $sql = "SELECT  wsdate,wedate,agent_id,sum(pay_amount) as paymoney,sum(pay_first) as payfirst,sum(pay_inner) as payinner,sum(pay_vip) payvip,sum(pay_jie) as payjie FROM ".PAYDB.'.'.GUILDWEEK.$where." group by agent_id  order by payjie desc";
        }else{
            $sql = "SELECT  wsdate,wedate,agent_id,sum(pay_amount) as paymoney,sum(pay_inner) as payinner,sum(pay_jie) as payjie,state FROM ".PAYDB.'.'.GUILDWEEK.$where." group by agent_id order by payjie desc LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        }
        $row= $this ->model ->db ->find($sql);
        $data=array();
        foreach($row as  $v){
            $v['starttime']=$postData['start_date'];
            $v['endtime']=$postData['end_date'];
            $v['agentname'] = $this ->guildlist[$v['agent_id']]['agentname'];
            $v['account_name']=$this ->guildlist[$v['agent_id']]['account_name'];
            $v['account']=$this ->guildlist[$v['agent_id']]['account'];
            $v['bank']=$this ->guildlist[$v['agent_id']]['bank'];
            $v['bank']=$this ->guildlist[$v['agent_id']]['bank'];
            $v['province']=$this ->guildlist[$v['agent_id']]['province'];
            $v['city']=$this ->guildlist[$v['agent_id']]['city'];
            $v['bank_son']=$this ->guildlist[$v['agent_id']]['bank_son'];
            $data[]=$v;
        }

        $sql = "SELECT SUM(pay_jie) AS totalMoney FROM ".PAYDB.'.'.GUILDWEEK." WHERE  wsdate >= ".str_replace('-','',$postData['start_date'])." and wedate <=".str_replace('-','',$postData['end_date'])." and puid=0"; //数据条件
        $res2 = $this ->model ->db ->get($sql);

        if($postData['api'] =='export'){
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=agent_data.xls");
            echo   iconv("UTF-8", "GBK", "公会ID")."\t";
            echo   iconv("UTF-8", "GBK", "公会名称")."\t";
            echo   iconv("UTF-8", "GBK", "充值总流水")."\t";
            echo   iconv("UTF-8", "GBK", "内充总金额")."\t";
            echo   iconv("UTF-8", "GBK", "结算金额")."\t";
            echo   iconv("UTF-8", "GBK", "收款户名")."\t";
            echo   iconv("UTF-8", "GBK", "收款账户")."\t";
            echo   iconv("UTF-8", "GBK", "收款银行")."\t";
            echo   iconv("UTF-8", "GBK", "收款银行支行")."\t";
            echo   iconv("UTF-8", "GBK", "时间段")."\t";
            echo   iconv("UTF-8", "GBK", "收款省")."\t";
            echo   iconv("UTF-8", "GBK", "收款市")."\t";
            echo   "\n";
            foreach($data as $v){
                if($v['agent_id'] >0 && !in_array($v['agent_id'],$nojie)){
                    echo   iconv("UTF-8", "GBK", $v['agent_id'])."\t";
                    echo   iconv("UTF-8", "GBK", $v['agentname'])."\t";
                    echo   iconv("UTF-8", "GBK", floor($v['paymoney']))."\t";
                    echo   iconv("UTF-8", "GBK", floor($v['payinner']))."\t";
                    echo   iconv("UTF-8", "GBK", floor($v['payjie']))."\t";
                    echo   iconv("UTF-8", "GBK", $v['account_name'])."\t";
                    echo   iconv("UTF-8", "GBK", "'".$v['account'])."\t";
                    echo   iconv("UTF-8", "GBK", $v['bank'])."\t";
                    echo   iconv("UTF-8", "GBK", $v['bank_son'])."\t";
                    echo   iconv("UTF-8", "GBK", $v['starttime']."-".$v['endtime'])."\t";
                    if(!empty($v['province'])){
                        echo   iconv("UTF-8", "GBK", $v['province'])."\t";
                        echo   iconv("UTF-8", "GBK", $v['city'])."\t";
                    }else{
                        echo   iconv("UTF-8", "GBK", "---")."\t";
                        echo   iconv("UTF-8", "GBK", "---")."\t";
                    }
                    echo   "\n";
                }
            }
            exit();
        }
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('start_date', $postData['start_date']);
        $this ->smarty ->assign('end_date', $postData['end_date']);
        $this ->smarty ->assign('totalMoney', round($res2['totalMoney'],2));
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
//各个游戏充值统计（各个专员）
    public function gamePaycount() {
        $postData = getRequest();
        //获取游戏列表
        $gamelist = parent::getGameList();
        //公会专员
        $sql = "SELECT distinct(addUid) as uid,addUser FROM ".GUILDINFO." group by uid";  //公会专员
        $username = $this ->model ->db ->find($sql);
        $userName=array();
        foreach ($username as $v){
            $userName[$v['uid']]=$v['addUser'];
            $userid[]=$v['uid'];
        }
        if($postData['start_date'] ==''){
            $postData['start_date']=date('Y-m-d');
        }
        if($postData['end_date'] ==''){
            $postData['end_date']=date('Y-m-d');
        }

        $where=$where1=" WHERE pay_date >='".$postData['start_date']." 00:00:00' and pay_date <='".$postData['end_date']." 23:59:59'";
        if($postData['game_id'] >0){
            $where.=$where1.=" and game_id=".$postData['game_id'];
        }
        //公会专员查询
        $user="";
        if($postData['pay_name'] >0){
            $user=$postData['pay_name'];
            $sql="select id  from ".GUILDINFO." where addUid=".intval($postData['pay_name']);
            $gh = $this ->model ->db ->find($sql);
            if(!empty($gh)){
                $agentid='';
                foreach ($gh as $v){
                    $agentid.=$v['id'].",";
                }
                $agent_id="(".substr($agentid,0,-1).")";
                $where.=" and agent_id in ".$agent_id;
            }
        }
        if(empty($postData['type'])){
            $postData['type']=1;
        }
        if($postData['type']==1){  //按游戏
            $sql=" select round(sum(paid_amount),2) as money,game_id from ".PAYDB.".".PAYLIST.$where." and game_id >0 group by game_id order by game_id desc";
            $row=$this ->model->db->find($sql);
            $data=$hj=array();
            foreach ($row as $v){
                $v['gamename']=$gamelist[$v['game_id']]['name'];
                $v['username']=$userName[$user];
                $data[]=$v;
                $hj['money']+=$v['money'];
            }
        }else{  //按专员
            $data=$hj=array();
            foreach ($userid as $v){
                if($v <=0){
                    continue;
                }
                $sql="select id  from ".GUILDINFO." where addUid=".$v;
                $gh = $this ->model ->db ->find($sql);
                if(!empty($gh)){
                    $agentid=$where2='';
                    foreach ($gh as $val){
                        $agentid.=$val['id'].",";
                    }
                    $agent_id="(".substr($agentid,0,-1).")";
                    $where2=" and agent_id in ".$agent_id;
                }else{
                    continue;
                }
                $sql=" select round(sum(paid_amount),2) as money,game_id from ".PAYDB.".".PAYLIST.$where1.$where2." and game_id >0 group by game_id order by game_id desc";
                $row=$this ->model->db->find($sql);
                if(empty($row)){
                    continue;
                }
                $red=array('gamename'=>'合计：','username' =>'--');
                $money=0;
                foreach ($row as $va){
                    $va['gamename']=$gamelist[$va['game_id']]['name'];
                    $va['username']=$userName[$v];
                    $data[]=$va;
                    $hj['money']+=$va['money'];
                    $money+=$va['money'];
                }
                $red['money']=$money;
                $data[]=$red;
            }
        }
        $this ->smarty ->assign('stime', $postData['start_date']);
        $this ->smarty ->assign('etime', $postData['end_date']);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('username', $username);
        $this ->smarty ->assign('gamelist', $gamelist);
    }

}