<?php
/**================================
 *付费记录（payAction）
 * @author Kevin
 * @email 254056198@qq.com
 * @version 1.0 data
 * @package 游戏公会联盟后台管理系统
==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class payjieAction extends Action{
    //申请结算
    public function jie(){
        $postData = getRequest();
        if($postData['api']=='add'){
            if($_SESSION['user']['uid'] !=100)
                ajaxReturn('此功能尚未开放！',300);
            $totalpay = $totalinnerpay =$jie = $totalMoneyAll=0;
            if($postData['start_date']!=''&& $postData['end_date']!=''){
                if(strtotime($postData['end_date']) > strtotime(date('Y-m-d'.'00:00:00'))){
                    ajaxReturn('结算日期不能大于当前日期！',300);
                }
                $where =" WHERE  game_id !=0 AND server_id !=0 AND agent_id=".$_SESSION['user']['uid']." AND is_account=0 AND game_id=reg_game_id AND pay_date >='".$postData['start_date']." 00:00:00' AND pay_date <= '".$postData['end_date']." 23:59:59'";
                $sql ="SELECT SUM(money) as tot, game_id FROM ".PAYDB.'.'.PAYINNER." WHERE state =1 AND is_account=0 AND agent_id=".$postData['agentid']." AND pay_type=2  AND pay_time>=".
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
                $gamelist=array();
                $game=array();
                foreach ($gameid as $v){
                    $game['id']=$v['id'];
                    $game['name']=$v['name'];
                    $game['fuildfc']=$v['fuildfc'];
                    $gamelist[]=$game;
                }
                $data=array();
                $pay=array();
                foreach ($gameid as $v){
                    $pay['game_id']=$v['id'];
                    $pay['fanliv'] = $v['fuildfc'];
                    $pay['gamename'] =$v['name'];
                    $pay['totalMoney'] = round($pay_list[$v['id']], 2);
                    $pay['fanli'] = round($pay['totalMoney']*$v['fuildfc']/100, 2);
                    $pay['innerpay'] = $inner_pay[$v['id']];
                    $pay['innerpayfl'] = round($pay['innerpay']*0.35, 2);
                    $pay['jie'] = round($pay['fanli']-$pay['innerpayfl'],2);
                    $totalpay += $pay['totalMoney'];
                    $totalinnerpay += $pay['innerpay'];
                    $jie += $pay['jie'];
                    $totalMoneyAll +=$pay['totalMoney'];
                    $data[]=$pay;
                }
                if($postData['sub']==1){
                    if($totalMoneyAll <=0){
                        ajaxReturn('没有收入，不能提交！',300);
                    }
                    $totalpayjie = 0;
                    if(is_array($postData['payjie'])){
                        foreach ($postData['payjie'] as $v2){
                            $totalpayjie += $v2;
                        }
                    }
                    //结算
                    $sql ="INSERT INTO ".PAYDB.'.'.PAYJIE." SET agent_id=".$_SESSION['user']['uid'].", sDate='".$postData['start_date']."', 
                        eDate='".$postData['end_date']."', payMoney=".$totalpay.", 
                       innerMoney=".$totalinnerpay.", jieMoney=".$totalpayjie.", jieTu=0, subre='".serialize($postData)."',  
                        jieTime=0,apply_time=".time().", admin_id=0,apply=-1";
                    $this ->model ->db ->query($sql);
                    //结算内充标记
                    $sql =" update ".PAYDB.".".PAYINNER." SET is_account=1,account_time='".date('Y-m-d')."' where  pay_time>=".strtotime($postData['start_date'].'00:00:00')."  AND pay_time<= ".strtotime($postData['end_date'].' 23:59:59')." AND  agent_id=".$_SESSION['user']['uid'];
                    $this ->model ->db ->query($sql);
                    //结算收入标记
                    $sql =" update ".PAYDB.".".PAYLIST."  SET is_account=1,account_time='".date('Y-m-d')."' where pay_date >='".$postData['start_date']." 00:00:00' AND pay_date <= '".$postData['end_date']." 23:59:59' AND agent_id=".$_SESSION['user']['uid'];
                    // ajaxReturn($sql,300);
                    $this ->model ->db ->query($sql);
                    ajaxReturn(C("Ok:EndOp"));
                }
                $this ->smarty ->assign('data', $data);
            }
            $this ->smarty ->assign('jie', $jie);
            $this ->smarty ->assign('totalMoneyAll', $totalMoneyAll);
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action']."/addjie.html");
            exit();
        }else if($postData['api']=='detail'){
            if($postData['id'] >0){
                $sql ="SELECT subre FROM ".PAYDB.'.'.PAYJIE." WHERE id=".intval($postData['id']);
                $row = $this ->model ->db ->get($sql);
            }
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
            $this ->smarty ->display($postData['action']."/detailjie.html");
            exit;
        }

        //后台管理人员
        $sql=" select * from db_5399_unions.777wan_admin_users ";
        $user=$this ->model ->db ->find($sql);
        foreach($user as $v){
            $username[$v['uid']]=$v['uName'];
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1,'totalMoney' =>0);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }

        $agent_id=array(940,1216);//显示查看数据的公会ID
        $where=" where 1 and ";
        if(in_array($this ->adminfo['uid'],$agent_id)){
            if($postData['pwd']=='777wan_detailjie'){
                $where.="  agent_id=".$this ->adminfo['uid'];
            }
        }else{
            $where.="  agent_id=".$this ->adminfo['uid'];
        }
        if($postData['start_date'] !=''){
            $where .= " AND apply_time >=".strtotime($postData['start_date'].' 00:00:00');
        }
        if($postData['end_date'] !=''){
            $where .= " AND apply_time <= ".strtotime($postData['end_date'].' 23:59:59');
        }
        $sql = "SELECT count(*) FROM ".PAYDB.'.'.PAYJIE.$where;
        $pageInfo['totalcount'] = $this ->model ->db ->count($sql);
        $sql = "SELECT * FROM ".PAYDB.'.'.PAYJIE.$where." ORDER BY id DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $res = $this ->model ->db ->find($sql);
        $data = array();
        foreach ($res as $v){
            if($v['jieTime'] >0){
                $v['jieTime'] =date("Y-m-d H:i:s", $v['jieTime']);
            }else{
                $v['jieTime']="--";
            }

            $v['name']=$username[$v['admin_id']];
            $v['agentname'] = $_SESSION['user']['name'];
            $data[] = $v;
        }
        // 充值总金额统计
        $sql = "SELECT sum(jieMoney) as jieMoney FROM ".PAYDB.'.'.PAYJIE.$where;
        $tmp2 = $this ->model ->db ->get($sql);
        $totalMoney = $tmp2['jieMoney'];
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('totalMoney', $totalMoney);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //公会工资申请结算（按周）
    public function weekjie() {

        $postData = getRequest();
        $gamelist = parent::getGameList();
        $guildlist=$this ->guildlist;
        $start_date=date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))); //上周一
        $end_date=date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))); //上周日

        $sql = "SELECT agent_id  FROM 91yxq_admin.agent_site WHERE site_id=".$_SESSION['member']['uid'];
        $res = $this->model->db->get($sql);

        //申请结算信息
        if($postData['api'] =='add'){
            if(!empty($_SESSION['member']['agent_id'])){
                $sql = "SELECT weekth,wsdate,wedate,cuid,ctime,puid,ptime,sum(pay_money) as pay_money,sum(pay_amount) as pay_amount,sum(pay_first) as pay_first,sum(pay_inner) as pay_inner,sum(pay_vip) as pay_vip,sum(pay_jie) as pay_jie FROM ".PAYDB.'.'.GUILDWEEK.
                    " where pstate=0 and agent_id=".$res['agent_id']." group by wsdate,wedate ORDER BY atime DESC ";
                $guildpay = $this ->model ->db ->find($sql);
                $data=$heji=array();
                foreach($guildpay as  $v){
                    $v['starttime']=substr($v['wsdate'],0,4)."-".substr($v['wsdate'],4,2)."-".substr($v['wsdate'],6,2);
                    $v['endtime']=substr($v['wedate'],0,4)."-".substr($v['wedate'],4,2)."-".substr($v['wedate'],6,2);
                    $v['agentname']=$_SESSION['user']['name'];
                    $v['puid'] >0 ? $v['uidname']=$adduser[$v['puid']]:$v['uidname']='---';
                    $v['cuid'] >0 ? $v['cname']=$adduser[$v['cuid']]:$v['cname']='---';
                    $data[]=$v;
                    $heji['allmoney']+=$v['pay_money'];
                    $heji['payaccount']+=$v['pay_amount'];
                    $heji['payfirst']+=$v['pay_first'];
                    $heji['payinner']+=$v['pay_inner'];
                    $heji['vmoney']+=$v['pay_vip'];
                    $heji['jiemoney']+=$v['pay_jie'];
                }
                $this ->smarty ->assign('heji', $heji);
                $this ->smarty ->assign('info', $data);
            }
            if($postData['sub'] ==1){
                if($postData['pass'] !='777wan_week&jie'){
                    ajaxReturn('提交密码不正确，请重新输入！',300);
                }
                if(empty($data)){
                    ajaxReturn('没有数据！',300);
                }
                $ip=  getIP();
                foreach ($data as $v){
                    $sql=" update ".PAYDB.'.'.GUILDWEEK." set pstate=1,aip='".$ip."',atime=".time()." where wsdate >=".$v['wsdate']." and wedate <=".$v['wedate']." and agent_id=".$_SESSION['user']['uid'];
                    $this ->model ->db ->query($sql);
                }
                ajaxReturn(C("Ok:EndOp"));
            }

            $this ->smarty ->display($postData['action']."/addweekjie.html");
            exit();
        }

        //明细
        if($postData['api'] =='detail'){
            $sql=" select wsdate,wedate,game_id,fc,round(sum(pay_amount),2) as paymoney,round(sum(pay_inner),2) as innerpay,round(sum(pay_jie),2) as pay_jie from ".PAYDB.".".GUILDWEEK." where agent_id =".$res['agent_id']." and wsdate >=".$postData['wsdate']." and wedate <=".$postData['wedate']." and pstate=1 group by game_id";
            $paydata=$this ->model ->db ->find($sql);
            $data=$hj=array();
            foreach ($paydata as $v){
                $v['stime']=strtotime(substr($v['wsdate'],0,4)."-".substr($v['wsdate'],4,2)."-".substr($v['wsdate'],6,2));
                $v['etime']=strtotime(substr($v['wedate'],0,4)."-".substr($v['wedate'],4,2)."-".substr($v['wedate'],6,2));
                $v['gamename']=$gamelist[$v['game_id']]['name'];
                $v['pay'] =$v['paymoney']* $v['fc']/100;
                $v['inner'] =$v['innerpay']* 0.35;
                $hj['heji'] +=$v['pay'];
                $hj['payinner'] +=$v['inner'];
                $hj['pay_jie'] +=$v['pay_jie'];
                $data[]=$v;
            }

            $this ->smarty ->assign('data', $data);
            $this ->smarty ->assign('hj', $hj);
            $this ->smarty ->assign('is_show', 1); //隐藏
            $this ->smarty ->display($postData['action']."/detail.html");
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
        $where =" WHERE agent_id =".$res['agent_id'];
        if(!empty($postData['start_date'])){
            $where.=" and wsdate >=".str_replace('-','',$postData['start_date']);
        }
        if(!empty($postData['end_date'])){
            $where.=" and wedate >=".str_replace('-','',$postData['start_date']);
        }
        if($postData['state'] !=0){
            $postData['state'] ==-1 ? $where.=" and pstate =0 ":$where.=" and pstate =1 ";
        }

        //获取公会添加人信息
        $sql="SELECT * FROM ".ADMINUSERS;
        $user=$this ->model ->db ->find($sql);
        $adduser=array();
        foreach ($user as $v){
            $adduser[$v['uid']]=$v['uName'];
        }
        $sql = "SELECT COUNT(distinct(wsdate)) AS total FROM ".PAYDB.'.'.GUILDWEEK.$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT *,sum(pay_money) as pay_money,sum(pay_amount) as pay_amount,sum(pay_first) as pay_first,sum(pay_inner) as pay_inner,sum(pay_vip) as pay_vip,sum(pay_jie) as pay_jie FROM ".PAYDB.'.'.GUILDWEEK.$where.
            " group by wsdate,wedate ORDER BY atime DESC LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $guildpay = $this ->model ->db ->find($sql);
        $data=$heji=array();
        foreach($guildpay as  $v){
            $v['starttime']=substr($v['wsdate'],0,4)."-".substr($v['wsdate'],4,2)."-".substr($v['wsdate'],6,2);
            $v['endtime']=substr($v['wedate'],0,4)."-".substr($v['wedate'],4,2)."-".substr($v['wedate'],6,2);
            $v['agentname']=$_SESSION['user']['name'];
            $v['puid'] >0 ? $v['uidname']=$adduser[$v['puid']]:$v['uidname']='---';
            $v['cuid'] >0 ? $v['cname']=$adduser[$v['cuid']]:$v['cname']='---';
            $data[]=$v;
            $heji['allmoney']+=$v['pay_money'];
            $heji['payaccount']+=$v['pay_amount'];
            $heji['payfirst']+=$v['pay_first'];
            $heji['payinner']+=$v['pay_inner'];
            $heji['vmoney']+=$v['pay_vip'];
            $heji['jiemoney']+=$v['pay_jie'];
        }
        $sql = "SELECT SUM(pay_jie) AS totalMoney FROM ".PAYDB.'.'.GUILDWEEK.$where;
        $res2 = $this ->model ->db ->get($sql);
        $this ->smarty ->assign('totalMoney', round($res2['totalMoney'],2));
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('dat', $dat);
        $this ->smarty ->assign('heji', $heji);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);

    }
    //明细
    function detail(){
        $postData = getRequest();
        $gamelist = parent::getGameList();
        $guildlist=$this ->guildlist;
        $sql=" select wsdate,wedate,game_id,fc,round(sum(pay_amount),2) as paymoney,round(sum(pay_inner),2) as innerpay,round(sum(pay_jie),2) as pay_jie from ".PAYDB.".".GUILDWEEK." where agent_id =".$_SESSION['user']['uid']." and wsdate >=".$postData['wsdate']." and wedate <=".$postData['wedate']."  group by game_id";
        $paydata=$this ->model ->db ->find($sql);
        $data=$hj=array();
        foreach ($paydata as $v){
            $v['stime']=strtotime(substr($v['wsdate'],0,4)."-".substr($v['wsdate'],4,2)."-".substr($v['wsdate'],6,2));
            $v['etime']=strtotime(substr($v['wedate'],0,4)."-".substr($v['wedate'],4,2)."-".substr($v['wedate'],6,2));
            $v['gamename']=$gamelist[$v['game_id']]['name'];
            $v['pay'] =$v['paymoney']* $v['fc']/100;
            $v['inner'] =$v['innerpay']* 0.35;
            $hj['heji'] +=$v['pay'];
            $hj['payinner'] +=$v['inner'];
            $hj['pay_jie'] +=$v['pay_jie'];
            $data[]=$v;
        }

        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('hj', $hj);
    }

}
?>
