<?php
 /**================================
  *后台权限管理相关（grantAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class supportAction extends Action{
    //申请记录
    public function supportaccount() {
        $postData=  getRequest();
        $gamelist=  parent::getGameList();
        //申请
        if($postData['api'] =='support'){
            if($postData['sub']==1){
                if($postData['game_id']==0 || $postData['server_id']==0){
                    ajaxReturn('请选择游戏区服！',300);
                }
                $this ->model ->setTable(GAMEACCOUNT);
                $this ->model ->setKey('user_name');
                $row=$this ->model ->getOneRecordByKey(trim($postData['account']));
                if(empty($row)){
                    ajaxReturn('该扶持账号没记录！',300);
                }
                $usertab = usertab(trim($postData['user_name']));
                $sql =" select uid  FROM ".USERDB.".".$usertab." WHERE `user_name`='".$postData['user_name']."' and `state`>0"; //
                $inf=$this ->model ->db ->get($sql);
                $this ->model->setTable(GAMESUPPORT);
                $arr=array(
                    'user_name' =>trim($postData['user_name']),
                    'game_id'   =>$postData['game_id'],
                    'server_id' =>$postData['server_id'],
                    'game_role' =>  trim($postData['user_role']),
                    'account'   =>trim($postData['account']),
                    'uid'       =>$inf['uid'],
                    'gamerole'  =>trim($postData['gamerole']),
                    'gold'      =>  intval($postData['gold']),
                    'applytime' =>time(),
                    'agent_id'  =>$this ->adminfo['uid'],
                    'remarks' =>trim($postData['remarks']),
                    'stime' =>  strtotime($postData['stime']),
                    'etime' =>  strtotime($postData['etime'])
                );
                $this ->model ->addRecord($arr);
                ajaxReturn(C("Ok:EndOp"));
            }
            $this ->smarty ->assign('gamelist',$gamelist);
            $this ->smarty ->display($postData['action']."/addsupport.html");
            exit();
        }
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1,'totalMoney' =>0);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        
        $where=" where 1 and a.agent_id=".$this ->adminfo['uid'];

        if(!empty($postData['user_name'])){
            $where.=" AND (a.user_name ='".trim($postData['user_name'])."' or account='".trim($postData['user_name'])."')";
        }

        $sql = "SELECT count(*) as total FROM game_support_account_apply as a ".$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        
        $sql=" select a.* from game_support_account_apply as a  ".
                $where." order by `state`  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $dat=$this ->model ->db ->find($sql);
        $data=array();
        foreach ($dat as $v){
            $v['gamename']=$gamelist[$v['game_id']]['name'];
            $v['game']=$gamelist[$v['game']]['name'];
            $v['check_time'] = $v['check_time'] >0 ? date('Y-m-d H:i:s',$v['check_time']) :"--";
            $data[]=$v;
        }    
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //申请记录
    public function supportaccount11() {
        $postData=  getRequest();
        $gamelist=  parent::getGameList();
        //申请
        if($postData['api'] =='support'){
            if($this ->adminfo['uid'] !=100){
                ajaxReturn('测试',300);
            }
            if($postData['sub']==1){
                if($postData['game_id']==0 || $postData['server_id']==0){
                    ajaxReturn('请选择游戏区服！',300);
                }
                $this ->model ->setTable(GAMEACCOUNT);
                $this ->model ->setKey('user_name');
                $row=$this ->model ->getOneRecordByKey(trim($postData['account']));
                if(empty($row)){
                    ajaxReturn('该扶持账号没记录！',300);
                }
                $usertab = usertab($v['account']);
                $sql =" select uid  FROM ".USERDB.".".$usertab." WHERE `user_name`='".$v['user_name']."' and `state`>0"; //玩家登录时间
                $inf=$this ->model ->db ->get($sql);

                
                $this ->model->setTable(GAMESUPPORT);
                $arr=array(
                    'user_name' =>trim($postData['user_name']),
                    'game_id'   =>$postData['game_id'],
                    'server_id' =>$postData['server_id'],
                    'game_role' =>  trim($postData['user_role']),
                    'account'   =>trim($postData['account']),
                    'uid'       =>$inf['uid'],
                    'gamerole'  =>trim($postData['gamerole']),
                    'gold'      =>  intval($postData['gold']),
                    'applytime' =>time(),
                    'agent_id'  =>$this ->adminfo['uid'],
                    'remarks' =>trim($postData['remarks'])
                );
                $this ->model ->addRecord($arr);
                ajaxReturn(C("Ok:EndOp"));
            }
            $this ->smarty ->assign('gamelist',$gamelist);
            $this ->smarty ->display($postData['action']."/addsupport11.html");
            exit();
        }
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1,'totalMoney' =>0);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        
        $where=" where 1 and a.agent_id=".$this ->adminfo['uid'];

        if(!empty($postData['user_name'])){
            $where.=" AND (a.user_name ='".trim($postData['user_name'])."' or account='".trim($postData['user_name'])."')";
        }

        $sql = "SELECT count(*) as total FROM game_support_account_apply as a ".$where;
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        
        $sql=" select a.* from game_support_account_apply as a  ".
                $where." order by `state`  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $dat=$this ->model ->db ->find($sql);
        $data=array();
        foreach ($dat as $v){
            $v['gamename']=$gamelist[$v['game_id']]['name'];
            $v['game']=$gamelist[$v['game']]['name'];
            $v['check_time'] = $v['check_time'] >0 ? date('Y-m-d H:i:s',$v['check_time']) :"--";
            $data[]=$v;
        }    
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    
}