<?php
 /**================================
  *系统管理模块（sysmanage）
  * 该模块的权限开放给所有登录玩家
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class sysmanageAction extends Action{
    //管理首页
    public function index(){
        $postData = getRequest();
        $gamelist=  parent::getGameList();
        switch ($postData['show']){
            case 'online':  //今日注册
                $date=date('Y-m-d');
                $year=date("Y");
                $maxh=date("H");
                $data=array();
                array_unshift($gamelist,array('id'=>0,'name'=>'平台'));
                foreach ($gamelist as $v){
                    $data[]=$v;
                    $sql="SELECT count(id) as reg,FROM_UNIXTIME(reg_time,'%H') AS hour FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$date 00:00:00') and reg_time<=unix_timestamp('$date 23:59:59') and game_id=".$v['id']."  group by hour";
                    $res=$this->model->db->find($sql);
                    $reg=array();
                    foreach ($res as $vv){
                        $reg[$vv['hour']]=$vv['reg'];
                    }
                    for($i=0;$i < $maxh;$i++){
                         $row[$v['id']].=$reg[$i] >0 ? $reg[$i].",":"0,";
                    } 
                }
                for($i=0;$i < $maxh;$i++){
                    $h.="'".$i."时',";
                } 
                $this ->smarty ->assign("H", substr($h, 0,-1));
                $this ->smarty ->assign("data", $data);
                $this ->smarty ->assign("datetime", $date);
                $this ->smarty ->assign('row',$row);
                $this ->smarty ->display($postData['action']."/online.html");
                break;
            case 'pay':  //今天充值
                $date=date('Y-m-d');
                $year=date("Y");
                $maxh=date("H");
                $data=array();
                array_unshift($gamelist,array('id'=>0,'name'=>'平台币'));
                foreach ($gamelist as $v){
                    $data[]=$v;
                    $sql="SELECT sum(money) as topmonay,substring(pay_date,12,2) AS hour FROM ".PAYDB.".".PAYLIST." where pay_date >='$date 00:00:00' and pay_date <='$date 23:59:59' and game_id=".$v['id']."  group by hour";
                    $res=$this->model->db->find($sql);
                    $reg=array();
                    foreach ($res as $vv){
                        $reg[$vv['hour']]=$vv['topmonay'];
                    }
                    for($i=0;$i < $maxh;$i++){
                         $row[$v['id']].=$reg[$i] >0 ? $reg[$i].",":"0,";
                    } 
                }
                for($i=0;$i < $maxh;$i++){
                    $h.="'".$i."时',";
                } 
                $this ->smarty ->assign("H", substr($h, 0,-1));
                $this ->smarty ->assign("data", $data);
                $this ->smarty ->assign("datetime", $date);
                $this ->smarty ->assign('row',$row);
                $this ->smarty ->display($postData['action']."/pay.html");
                break;
            default :
        break;
        }
            //充值前20公会
            if(empty($postData['start_date'])){
                $postData['start_date']=date('Y-m-d');
            }
            $sql=" select round(sum(money),2) as topmoney,agent_id from ".PAYDB.".".PAYLIST." where pay_date >='".$postData['start_date']." 00:00:00' and pay_date <='".$postData['start_date']." 23:59:59' group by agent_id order by topmoney  desc LIMIT 20 ";
            $agentPay=$this ->model ->db ->find($sql);
            $paydata=$data=$hj=$regpay=$row=array();
            foreach ($agentPay as $v){
                $hj['paydata']+=$v['topmoney'];
                $paydata[$v['agent_id']]=$v['topmoney'];
                $agentid.=$v['agent_id'].",";
            }
            //今天注册
            $sql=" select count(id) as regdata,agent_id from ".USERDB.".".REGINDEX.substr($postData['start_date'], 0,-6).
                    " where reg_time >=".strtotime($postData['state_day']." 00:00:00")." and reg_time <=".strtotime($postData['start_date']." 23:59:59")." and agent_id in (".substr($agentid, 0,-1).") group by agent_id";
            $reg=$this ->model ->db ->find($sql);
            foreach ($reg as $v){
                $regpay[$v['agent_id']]=$v['regdata'];
            }
            //昨天充值
            $ydate=date('Y-m-d',time()-24*60*60);
            $sql=" select round(sum(money),2) as topmoney,agent_id from ".PAYDB.".".PAYLIST." where pay_date >='".$ydate." 00:00:00' and pay_date <='".$ydate." 23:59:59'  and agent_id in (".substr($agentid, 0,-1).") group by agent_id order by topmoney  desc LIMIT 20 ";
            $agentPay1=$this ->model ->db ->find($sql);
            $ypay=$yreg=array();
            foreach ($agentPay1 as $v){
                $ypay[$v['agent_id']]=$v['topmoney'];
            }
            //昨天注册
            $sql=" select count(id) as regdata,agent_id from ".USERDB.".".REGINDEX.substr($ydate, 0,-6).
                    " where reg_time >=".strtotime($ydate." 00:00:00")." and reg_time <=".strtotime($ydate." 23:59:59")." and agent_id in (".substr($agentid, 0,-1).") group by agent_id";
            $reg1=$this ->model ->db ->find($sql);
            foreach ($reg1 as $v){
                $yreg[$v['agent_id']]=$v['regdata'];
            }
            foreach ($paydata as $kk =>$vv){
                $row['agent_id']=$kk;
                $row['agentname']=$this ->guildlist[$kk]['agentname'];
                $row['paydata']=$vv;
                $row['regdata']=$regpay[$kk];
                
                $row['paydatay']=$ypay[$kk];
                $row['regdatay']=$yreg[$kk];
                $hj['regdata']+=$regpay[$kk];
                $hj['paydata']+=$vv;
                $hj['regdatay']+=$yreg[$kk];
                $hj['paydatay']+=$ypay[$kk];
                $data[]=$row;
            }
            //今天、昨天 总充值
            $sql=" select round(sum(money),2) as topmoney,substring(pay_date,1,10) as dates from ".PAYDB.".".PAYLIST." where pay_date >='".$ydate." 00:00:00' and pay_date <='".$postData['start_date']." 23:59:59' group by dates ";
            $paytotal=$this ->model ->db ->find($sql);
            $pay_ny=array();
            foreach ($paytotal as $v){
                $pay_ny[$v['dates']]=$v['topmoney'];
            }
            //今天 昨天注册
            $sql=" select count(id) as regdata,FROM_UNIXTIME(reg_time,'%Y-%m-%d') as dates from ".USERDB.".".REGINDEX.substr($postData['start_date'], 0,-6).
                    " where reg_time >=".strtotime($ydate." 00:00:00")." and reg_time <=".strtotime($postData['start_date']." 23:59:59")." group by dates ";
            $regy=$this ->model ->db ->find($sql);
            $reg_ny=array();
            foreach ($regy as $v){
                $reg_ny[$v['dates']]=$v['regdata'];
            }
            array_multisort($paydata[$v['agent_id']], SORT_DESC, $data);
            $this ->smarty ->assign("hj", $hj);
            $this ->smarty ->assign("data", $data);
            $this ->smarty ->assign("date", $postData['start_date']);  
            $this ->smarty ->assign("ydate", $ydate);
            $this ->smarty ->assign("pay", $pay_ny);
            $this ->smarty ->assign("reg", $reg_ny);
    }
    
    // 获取指定省下的城市列表
    public function get_citiess() 
    {
        $res = array();
        $getData = getRequest();
        $provice_id = $getData['provice_id'];
        include (ROOT.'configs/city_codes/city_codes.php');
        $cities = array();
        foreach($city_codes[$provice_id] as $key=>$val)
        {
            if(is_array($val))
            {
                $cities[$key] = $val[0];
            }
        }
        if(!empty($cities)){
            foreach($cities as $key=>$val){
                array_push($res, array($val, $val));
            }
        }
        echo json_encode($res);
        exit();
    }
    
    //json返回平台服务器列表
    public function  getServers(){
        $res = array();
        $res[] = array('0', "请选择");
        $getData = getRequest();
        if($getData['game_id'] > 0){
           $w = array('is_open' =>1);
           $servers = parent::getGameServers($getData['game_id'], $w); 
           if(count($servers) > 0){
               foreach($servers as $v){
                   array_push($res, array($v['server_id'], $v['name']));
               }
           }  
        }
        echo json_encode($res);
        exit();
    }

    //json返回指定公会成员列表
    public function  getMembers(){
        $res = array();
        $res[] = array('0', "请选择");
        $getData = getRequest();
        $agentid = $getData['agentid'];
        if($agentid > 0 && is_array($this ->guildlist[$agentid])){
           $w = array('state' =>1);
           $members = parent::getGuildMembers($this ->guildlist[$agentid], $w); 
           if(count($members) > 0){
               foreach($members as $v){
                   array_push($res, array($v['site_id'], $v['sitename']."(".$v['aAccount'].')'));
               }
           }  
        }
        echo json_encode($res);
        exit();
    }
    
    //修改管理者个人资料及密码
    public function cmdata(){
        $postData = getRequest();
        if($postData['account']){
            $field = array();
            $field['uid'] = $this ->adminfo['uid'];
            if($postData['newpass'] != $postData['newpassagain'])
                ajaxReturn("两次密码不一致，请重新输入！", 300);
            $field['uPass'] = getPass($postData['newpass'], $this ->adminfo['passext']);
            
            $field['uName'] = $postData['name'];
            $field['uPhone'] = $postData['mobel'];
            $field['uMail'] = $postData['email'];
            $this ->model ->setTable(ADMINUSERS);
            $this ->model ->setKey('uid');
            $this ->model ->upRecordByKey($field);
            ajaxReturn(C('Ok:Update'));
        }
        $this ->model ->setTable(ADMINUSERS);
        $this ->model ->setKey('uid');
        $data = $this ->model ->getOneRecordByKey($this ->adminfo['uid']);
        $this ->smarty ->assign('data', $data);
    }
    //加载左边栏
    public function leftMenu(){
        global $getData;
        include(DATA_DIR . 'grantlist.php');
        //过滤权限
        $userGrants = array();
        foreach($allGrants as $key =>$v){
            if($this ->admgrantkeys == 'all' || in_array($v['key'],$this ->admgrantkeys)){
                array_push($userGrants, $v);
            }
        }
        $topMenu = $this ->getUserTopMenu($userGrants);
        $leftMenu = array();
        if(count($topMenu) > 0){
            $topInfo = array();
            if(isset($getData['tid'])){
                 foreach($topMenu as $val){
                     if($val['key'] == $getData['tid'])
                        $topInfo = $val;
                 }              
            }else{
                 $topInfo = $topMenu[0];
            }
            if(isset($topInfo['key'])){
                $leftMenu = $this ->getUserLeftMenu($topInfo, $userGrants);
            }else{
                if(isAjax())
                    ajaxReturn( C('Error:AccountUnnormal'), 300 );
            }
        }
        $this ->smarty ->assign('theModule', $topInfo);
        $this ->smarty ->assign('topMenu', $topMenu);
        $this ->smarty ->assign('leftMenu', $leftMenu);
    }    
    //获取用户左边菜单栏
    private function getUserLeftMenu($topInfo, $userGrants){
        $leftMenu = array();
        foreach($userGrants as $val){
            if(floor(($val['key'] - $topInfo['key'])/1000) == 0 && $val['key'] != $topInfo['key'])
                array_push($leftMenu, $val);
        }
        //划分等级
        $data = $this ->divideGrade($leftMenu);
        return $data;
    }
    //划分权限等级
    private function divideGrade($userLeftMenu, $data = array()){
        $data = array();
         foreach($userLeftMenu as $val){
            if(fmod(($val['key']), 100) == 0){
                foreach($userLeftMenu as $v){
                    $c = $v['key'] - $val['key'];
                    if(($c) >0 && ($c) <20)
                       $val['sonfunc'][$v['key']] = $v;
                    if(($c) >=20 && ($c) <100)
                        if(fmod($c, 20) == 0)
                            $val['sondir'][$v['key']] = $v;
                        else
                            $val['sondir'][floor($v['key']/20)*10]['sonfunc'][] = $v;
                }
                $data[$val['key']] = $val;
            }
        }
        return $data;
    }
    //获取用户顶部导航
    private function getUserTopMenu($userGrants){
        $topMenu = array();
        foreach($userGrants as $val){
            if(fmod($val['key'], 1000)==0)
                array_push($topMenu, $val);
        }
        return $topMenu;
    }
}