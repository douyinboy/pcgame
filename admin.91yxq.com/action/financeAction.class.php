<?php
 /**================================
  *财务对账统计（financeAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
  class financeAction extends Action{
    //平台月数据汇总
    public function gametMonthData(){
        $postData = getRequest();
        //处理查询
        $where =' WHERE 1 ';
        if($postData['game_id'] >0){
            $where .=' AND game_id ='.intval($postData['game_id']);
        }
        if($postData['start_date'] ==''){
            $month_start = strtotime(date('Ymd'));
            $chaju = 3600 * 24 * intval(date('d'));
            $last_month = $month_start-$chaju;
            $postData['start_date'] = date('Y-m',$last_month); 
        }
        $where .= " AND ym=".str_replace('-', '', $postData['start_date']);
        $sql = "SELECT * FROM ".PAYDB.'.'.MONTHGAMEDATA.$where." ORDER BY pay_money DESC ";
        $res = $this ->model ->db ->find($sql);
        $data = array();
        //获取游戏列表
        $gamelist = parent::getGameList();
        $hj= array('pay_account' =>0,'first_money' =>0,'inner_money' =>0,'inner_money2'=>0,'vip_money' =>0,'game_api_money' =>0,'game_pay' =>0,'maoli' =>0,);
        foreach ($res as $v){
            $v['gamename'] = $gamelist[$v['game_id']]['name'];
            $v['maoli'] = $v['pay_account'] - $v['game_pay'];
            $data[] = $v;
            $hj['pay_account'] += $v['pay_account'];
            $hj['first_money'] += $v['first_money'];
            $hj['inner_money'] += $v['inner_money'];
            $hj['inner_money2'] += $v['inner_pay_money'];
            $hj['vip_money'] += $v['vip_money'];
            $hj['game_api_money'] += $v['game_api_money'];
            $hj['api_success_money'] += $v['api_success_money'];
            $hj['game_pay'] += $v['game_pay'];
            $hj['maoli'] += $v['maoli'];
            $hj['api_order_count'] += $v['api_order_count'];
            $hj['plat_order_count'] += $v['plat_order_count'];
        }
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('tmonth', $postData['start_date']);
    }
    //研发分成月数据（按公司分）
    public function companyMonthData() {
        $postData = getRequest();
        $gamelist=  parent::getGameList();
        $sql=" select * from ".YYDB.".".COMPANY;
        $company11=$this ->model ->db ->find($sql);
        foreach ($company11 as $vc){
            $companyname[]=$vc;
        }
        //处理查询
        $where =$wherec=' WHERE 1 ';
        if($postData['id'] >0){
            $wherec.=" and id=".$postData['id'];
        }
        if($postData['start_date'] ==''){
            $month_start = strtotime(date('Ymd'));
            $chaju = 3600 * 24 * intval(date('d'));
            $last_month = $month_start-$chaju;
            $postData['start_date'] = date('Y-m',$last_month);
        }
        $where .= " AND ym=".str_replace('-', '', $postData['start_date']);
        //研发公司
        $sql=" select * from ".YYDB.".".COMPANY.$wherec;
        $company=$this ->model ->db ->find($sql);
        $data=$hj=$zhj=$arr=array();
        foreach($company as $v){
            //各研发公司的游戏
            $sql ="SELECT id FROM ".PAYDB.".".GAMELIST." WHERE is_open=1 and owner=".$v['id'];
            $game = $this ->model ->db ->find($sql);
            $rr=array();
            foreach ($game as $vl){
            //各游戏数据
                $sql = "SELECT * FROM ".PAYDB.'.'.MONTHGAMEDATA.$where." and game_id=".$vl['id']." ORDER BY pay_money DESC ";
                $res = $this ->model ->db ->get($sql);
                if($res['api_success_money'] >0){
                    $rr['id']=$vl['id'];
                    $rr['company']=$v['name'];
                    $rr['gamename'] = $gamelist[$vl['id']]['name'];
                    $rr['api_success_money'] = $res['api_success_money'];
                    $rr['game_api_money'] = $res['game_api_money'];
                    $rr['game_pay'] = $res['game_pay'];
                    $data[]= $rr;
                    
                    $hj['api_success_money'] += $rr['api_success_money'];
                    $hj['game_api_money'] += $rr['game_api_money'];
                    $hj['game_pay'] += $rr['game_pay']; 
                    
                    $zhj['api_success_money'] += $rr['api_success_money'];
                    $zhj['game_api_money'] += $rr['game_api_money'];
                    $zhj['game_pay'] += $rr['game_pay']; 
                } 
            }
            if($rr['id'] >0){
                $arr['company']='合计：';
                $arr['gamename']='--';
                $arr['api_success_money']=$zhj['api_success_money'];
                $arr['game_api_money']=$zhj['game_api_money'];
                $arr['game_pay']=$zhj['game_pay'];
            //各研发合计;
               array_push($data,$arr);
               $zhj=$arr=array();
            }
        }
        $this ->smarty ->assign('companyname', $companyname);
        $this ->smarty ->assign('hj', $hj);
        $this ->smarty ->assign('tmonth', $postData['start_date']);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('gamelist', $gamelist);
    }
    
}
?>
