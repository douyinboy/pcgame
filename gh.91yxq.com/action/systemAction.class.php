<?php
 /**================================
  *后台权限管理相关（systemtAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class systemAction extends Action{
    //公会成员列表
    public function guildMembers(){
        $postData = getRequest();
        //处理api参数增删改操作
        if($postData['api']=='add'){
            if($postData['id'] > 0){
                $this ->model ->setTable(GUILDMEMBER);
                $this ->model ->setKey('site_id');
                $mInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                if($mInfo['agent_id']!=$this ->adminfo['uid']){
                    ajaxReturn(C('Error:HaveNoGrant'), 300);
                }
                $this ->smarty ->assign('mInfo', $mInfo);
            }else{
                $sql ="SELECT * FROM ".GUILDMEMBER." WHERE aAccount ='".$postData['aAccount']."'";
                $tmpone = $this ->model ->db ->get($sql);
                if($tmpone['site_id'] >0){
                    ajaxReturn(C('Error:HaveOtherBodyUsedAccount'), 300);
                }
            }
            if($postData['sub']==1){
                $this ->model ->setTable(GUILDMEMBER);
                $arr=array(
                    'agent_id' =>$this ->adminfo['uid'],
                    'author'   =>$postData['author'],
                    'aAccount' =>$postData['aAccount'],
                    'aPass'    =>$postData['aPass'],
                    'state'    =>$postData['state']
                );
                if($mInfo['site_id'] > 0){
                    $this ->model ->setKey('site_id');
                    $arr['site_id'] = $mInfo['site_id'];
                    $this ->model ->upRecordByKey($arr);
                }else{
                    $arr['addtime'] = date("Y-m-d H;i:s");
                    $this ->model ->addRecord($arr);
                }
                ajaxReturn(C('Ok:Operate'));
            }
            $this ->smarty ->display($postData['action'].'/addGuildMember.html');
            exit();
        }else if($postData['api']=='geturl'){
            if($postData['game_id'] > 0){
                $serverlist = parent::getGameServers($postData['game_id']);
                $this ->smarty ->assign('serverlist',$serverlist);
             }
             if($postData['game_id'] >0 && $postData['server_id'] >0){
                if($this ->adminfo['uid'] <1){
                    ajaxReturn(C('Error:AdminStateException'), 300);
                }
                $reg= ADENTR.$postData['game_id'].'/?aid='.$this ->adminfo['uid'].'&pid='.$postData['id'].'&sid='.intval($postData['server_id']);
                $dwzurl = parent::getShotUrl($reg);
                $this ->smarty ->assign('regurl',$reg); 
                $this ->smarty ->assign('dregurl',$dwzurl); 
             }
            $gamelist = parent::getGameList();
            $this ->smarty ->assign('gamelist', $gamelist);
            $this ->smarty ->display($postData['action'].'/geturl.html');
            exit();
        }else if($postData['api']=='del'){
            if($postData['id'] >0){
                $this ->model ->setTable(GUILDMEMBER);
                $this ->model ->setKey('site_id');
                $mInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                if($mInfo['agent_id'] != $this ->adminfo['uid']){
                    ajaxReturn(C('Error:HaveNoGrant'), 300);
                }
                //修改充值链接
                $sql ="UPDATE ".PAYDB.".".PAYLIST." SET placeid=0 WHERE agent_id=".$mInfo['agent_id']." AND placeid=".$postData['id'];
                $this ->model ->db ->query($sql);
                //修改注册链接
                $sql ="UPDATE ".USERDB.".`users` SET place_id=0 WHERE place_id=".$postData['id'];
                $this ->model ->db ->query($sql);
                $year = date("Y");
                for($i=2014; $i <= $year; $i++){
                    $sql ="UPDATE ".USERDB.".".REGINDEX.$i." SET placeid=0 WHERE agent_id=".$this ->adminfo['uid']." AND placeid=".$postData['id'];
                    $this ->model ->db ->query($sql);
                }
                $this ->model ->delRecordByKey($postData['id']);
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }
        //处理查询
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        $where =' WHERE agent_id='.$this ->adminfo['uid'];
        if($postData['name'] !=''){
            $where .= ' AND sitename like "%'.$postData['name'].'%"';
        }
        $sql = "SELECT COUNT(*) AS total FROM ".GUILDMEMBER.$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT * FROM ".GUILDMEMBER.$where." order by state desc,addtime desc  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('adminInfo', $this ->adminfo);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
}