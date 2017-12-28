<?php
 /**================================
  *付费记录（payAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class payAction extends Action{
    
    //渠道充值数据统计
    public function theGuildPayData(){
        $postData = getRequest();
        $where =" WHERE game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['agent_id']." AND placeid=".$this->adminfo['uid']." AND game_id = reg_game_id AND server_id = reg_server_id";
        if($postData['start_date'] ==''){
            $postData['start_date'] = date("Y"."-01-01");
        }
        if($postData['end_date'] ==''){
            $postData['end_date'] = date("Y-m-d"); 
        }
        $where .= " AND  pay_date <= '".$postData['end_date']." 23:59:59' AND pay_date >='".$postData['start_date']." 00:00:00'"; 
        $searchYear = date("Y", strtotime($postData['start_date']));
        if($searchYear != date("Y", strtotime($postData['end_date']))){
            ajaxReturn(C('Error:ParamCantBeyondYear'), 300);
        }
        if($postData['game_id'] > 0){
           $where .= " AND game_id=".intval($postData['game_id']);
           $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
           $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] > 0){
           $where .= " AND server_id=".$postData['server_id'];
        }
        //期间充值总金额
        $sql = "SELECT COUNT(distinct user_name) as payusers, game_id, server_id, SUM(paid_amount) as paymoney  FROM ".PAYDB.'.'.PAYLIST.$where." GROUP BY game_id, server_id ORDER BY paymoney DESC";
        $data = $this ->model ->db ->find($sql);
        $gamelist = parent::getGameList();
        $totaldata = array('totalusers' =>0, 'totalpay' =>0, 'totaladd'=>0);
        foreach($data as $k => $v){
        //新增注册数
            $sql ="SELECT COUNT(*) as total_num FROM  ".USERDB.".".REGINDEX.$searchYear." WHERE game_id=".$v['game_id']." AND server_id=".$v['server_id']." AND agent_id=".$this ->adminfo['agent_id']." AND placeid=".$this ->adminfo['uid']." AND reg_time >=".strtotime($postData['start_date'])." AND reg_time <=".strtotime($postData['end_date']." 23:59:59");
            $data[$k]['addusers'] = $this ->model ->db ->count($sql);
            
            $data[$k]['gamename'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['paymoney'] = round($v['paymoney']);
            
            $totaldata['payusers'] +=$v['payusers'];
            $totaldata['paymoney'] +=intval($v['paymoney']);
            $totaldata['addusers'] +=intval($data[$k]['addusers']);
        }
        $this ->smarty ->assign('totaldata', $totaldata);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
    }
   
    //玩家最近充值
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
        $where =" WHERE game_id !=0 AND server_id !=0 AND agent_id=".$this ->adminfo['agent_id']." AND placeid=".$this->adminfo['uid']." AND game_id = reg_game_id AND server_id = reg_server_id";        
        if($postData['placeid']>0){
            $where .= ' AND placeid ='.$postData['placeid'];
        }
        if($postData['start_date'] !=''){
            $where .= " AND  pay_date >= '".$postData['start_date']." 00:00:00'";
         }
        if($postData['end_date'] !=''){
           $where .= " AND pay_date <='".$postData['end_date']." 23:59:59'";
        }
        if($postData['game_id'] >0){
            $where .='  AND game_id='.intval($postData['game_id']);  
            $serverlist = parent::getGameServers($postData['game_id'], array('is_open' =>1));
            $this ->smarty ->assign('serverlist',$serverlist);
        }
        if($postData['server_id'] >0){
            $where .='  AND server_id='.intval($postData['server_id']);
        }
        if($postData['user_name'] !=''){
            $where .=" AND user_name='".trim($postData['user_name'])."'";
        }
        $sql = "SELECT COUNT(*) AS total FROM ".PAYDB.'.'.PAYLIST.$where; 
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYLIST.$where." ORDER BY pay_date DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $gamelist = parent::getGameList();
        foreach($data as $k => $v){
            $data[$k]['game'] = $gamelist[$v['game_id']]['name'];
            $data[$k]['paid_amount'] = round($data[$k]['paid_amount'], 2);
        }
    //期间充值总金额
        $sql = "SELECT round(SUM(paid_amount),2) as money FROM ".PAYDB.'.'.PAYLIST.$where; 
        $totalmoney = $this ->model ->db ->get($sql);
        
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('totalmoney', $totalmoney['money']);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('guildmembers', $this ->guildmembers);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
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
                        if($paytimes >7){
                            $hint['beyond'].=$user_name." "; //特殊游戏账号已发过7次
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
    
    
}