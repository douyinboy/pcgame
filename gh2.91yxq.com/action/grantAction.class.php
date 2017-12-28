<?php
 /**================================
  *后台权限管理相关（grantAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class grantAction extends Action{
    //获取链接
    public function getUrl(){
        $postData = getRequest();
        if($postData['game_id'] > 0){
            $serverlist = parent::getGameServers($postData['game_id']);
            $this ->smarty ->assign('serverlist',$serverlist);
         }
         if($postData['game_id'] >0 && $postData['server_id'] >0){
            if($this ->adminfo['uid'] <1){
                ajaxReturn(C('Error:AdminStateException'), 300);
            }
            $reg= ADENTR.$postData['game_id'].'/?aid='.$this ->adminfo['agent_id'].'&pid='.$this ->adminfo['uid'].'&sid='.intval($postData['server_id']);
            $dwzurl = parent::getShotUrl($reg);
            $this ->smarty ->assign('regurl',$reg); 
            $this ->smarty ->assign('dregurl',$dwzurl);
         }
        $gamelist = parent::getGameList();
        $this ->smarty ->assign('gamelist', $gamelist);
    }
}