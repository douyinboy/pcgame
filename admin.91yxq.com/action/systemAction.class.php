<?php
<?php
 /**================================
  *后台权限管理（systemAction）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会总后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class systemAction extends Action{
    //默认打开页，可自定义显示公共内容，暂不开放
    public function index(){   
    }
    //权限组管理
    public function group(){
        $postData = getRequest();
        //处理api参数增删改操作
        if($postData['api']=='add'){
            if($postData['id'] > 0){
                $this ->model ->setTable(ADMINGROUP);
                $this ->model ->setKey('gId');
                $gInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                $this ->smarty ->assign('gInfo', $gInfo);
            }
            if($postData['sub']==1){
                $this ->model ->setTable(ADMINGROUP);
                $arr=array(
                    'gName' =>$postData['gName'],
                    'gState' =>$postData['gState'],
                    'px' =>$postData['px'],
                );
                if($gInfo['gId'] > 0){
                    $arr['updUser'] = $this ->adminfo['uid'];
                    $arr['updTime'] = time();
                    $this ->model ->setKey('gId');
                    $arr['gId'] = $gInfo['gId'];
                    $this ->model ->upRecordByKey($arr);
                }else{
                    $arr['cUser'] = $this ->adminfo['uid'];
                    $arr['cTime'] = time();
                    $this ->model ->addRecord($arr);
                }
                ajaxReturn(C('Ok:Operate'));
            }
            $this ->smarty ->display($postData['action'].'/addGroup.html');
            exit();
        }else if($postData['api']=='del'){
            if($postData['id']==1){
                ajaxReturn(C('Error:CantDelTheGroup'), 300);
            }
            if($postData['id'] >1){
                $this ->model ->setTable(ADMINGROUP);
                $this ->model ->setKey('gId');
                $this ->model ->delRecordByKey($postData['id']);
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }else if($postData['api']=='mult_del'){
            if(strlen($postData['ids']) >0){
                $arr = explode(',', $postData['ids']);
                $this ->model ->setTable(ADMINGROUP);
                $this ->model ->setKey('gId');
                foreach($arr as $v){
                    if($v > 1){
                        $this ->model ->delRecordByKey($v);
                    }
                }
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }else if($postData['api']=='editGroupGrant'){
            include(DATA_DIR . 'grantlist.php');
            if($postData['id'] <1){
               ajaxReturn(C('Error:ParamError'), 300); 
            }
            $this ->model ->setTable(ADMINGROUP);
            $this ->model ->setKey('gId');
            if($postData['sub']==1){
                if($postData['id'] != 1){
                   $arr = array();
                   foreach($postData['grantlist'] as $v){
                       array_push($arr, $v, floor($v/10)*10, floor($v/100)*100, floor($v/1000)*1000);
                   }
                   $arr = array_unique($arr);
                   $t = array();
                   $t['gId'] = intval($postData['id']);
                   $t['gGrants'] = serialize($arr);
                   $t['updUser'] = $this ->adminfo['uid'];
                   $t['updTime'] = time();
                   $this ->model ->upRecordByKey($t);
                   ajaxReturn(C('Ok:Update'));
                }else{
                   ajaxReturn(C('Error:CantEDITTheGroup'), 300);
                }
            }
            $gInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
            $grant = $gInfo['gGrants'] =='all'? 'all':unserialize($gInfo['gGrants']);
            $grant == false && $grant = array();
            foreach ($allGrants as $key =>$v){
                if($grant =='all' || in_array($v['key'], $grant))
                    $allGrants[$key]['checked'] =1;
            }
            $data =array();
            $topMenu = $this ->getTopMenu();
            foreach($topMenu as $v){
                $row = array();
                $row['top'] = $v;
                $row['son'] = $this ->getLeftMenu($v);
                array_push($data, $row);
            }
            $this ->smarty ->assign("data", $data);
            $this ->smarty ->display($postData['action'].'/editGroupGrant.html');
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
        $where ='';
        if($postData['name'] !=''){
            $where = ' WHERE gName like "%'.$postData['name'].'%"';
        }
         //处理排序
        if( empty($postData['orderField']) ){
            $postData['orderField'] = 'gId';
            $postData['orderDesc'] = 1;
        }
        $orderStr=$postData['orderField'];
        $orderStr.=$postData['orderDesc']==1? " DESC ":" ASC ";
        
        $sql = "SELECT COUNT(*) AS total FROM ".ADMINGROUP.$where;         
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT * FROM ".ADMINGROUP.$where." ORDER BY ".$orderStr." LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $userlist=  parent::getUserList();
        
        $this ->smarty ->assign('orderField', $postData['orderField']);
        $this ->smarty ->assign('orderDesc',  $postData['orderDesc']);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('username', $userlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //用户管理
    public function users(){
        $postData = getRequest();
        //处理api参数增删改操作
        $this ->model ->setSql("SELECT * FROM ".ADMINGROUP." ORDER BY px");
        $grouplist = $this ->model ->find();
        if($postData['api']=='add'){
            if($postData['id'] > 0){
                $this ->model ->setTable(ADMINUSERS);
                $this ->model ->setKey('uid');
                $uInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                $this ->smarty ->assign('uInfo', $uInfo);
            }
            if($postData['sub']==1){
                $this ->model ->setTable(ADMINUSERS);
                $arr=array(
                    'uName' =>$postData['uName'],
                    'uAccount' =>$postData['uAccount'],
                    'uGroupId' =>$postData['uGroupId'],
                    'uPhone' =>$postData['uPhone'],
                    'uMail' =>$postData['uMail'],
                    'uLoginState' =>$postData['uLoginState'],
                );
                if($postData['uPass'] != ''){
                    $arr['uAttend'] = strlen($uInfo['uAttend'])==6 ? $uInfo['uAttend'] : createExt();
                    $arr['uPass'] = getPass($postData['uPass'], $arr['uAttend']);
                }
                if($uInfo['uid'] > 0){
                    $this ->model ->setKey('uid');
                    $arr['uid'] = $uInfo['uid'];
                    $this ->model ->upRecordByKey($arr);
                }else{
                    $this ->model ->addRecord($arr);
                }
                ajaxReturn(C('Ok:Operate'));
            }
            $this ->smarty ->assign('grouplist', $grouplist);
            $this ->smarty ->display($postData['action'].'/addUser.html');
            exit();
        }else if($postData['api']=='del'){
            if($postData['id']==1){ //终极用户不可删除
                ajaxReturn(C('Error:CantDelTheUser'), 300);
            }
            if($postData['id'] >1){
                $this ->model ->setTable(ADMINUSERS);
                $this ->model ->setKey('UId');
                $this ->model ->delRecordByKey($postData['id']);
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }else if($postData['api']=='mult_del'){
            if(strlen($postData['ids']) >0){
                $arr = explode(',', $postData['ids']);
                $this ->model ->setTable(ADMINUSERS);
                $this ->model ->setKey('uid');
                foreach($arr as $v){
                    $this ->model ->delRecordByKey($v);
                }
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
        $where =' where 1 ';
        if($postData['name'] !=''){
            $where.= ' and  a.uName like "%'.$postData['name'].'%" OR uAccount like "%'.$postData['name'].'%"';
        }
        if($postData['groupid'] >0){
            $where.= " and  a.uGroupId =".$postData['groupid'];
        }
    //处理排序
        if( empty($postData['orderField']) ){
            $postData['orderField'] = 'uid';
            $postData['orderDesc'] = 1;
        }
        $orderStr=" a. ".$postData['orderField'];
        $orderStr.=$postData['orderDesc']==1? " DESC ":" ASC ";
        
        $sql = "SELECT COUNT(*) AS total FROM ".ADMINUSERS." as a ".$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT a.*,b.gName FROM ".ADMINUSERS." as a ".
                " left join ".ADMINGROUP." as b on b.gId=a.uGroupId ".
                $where." ORDER BY ".$orderStr." LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
       
        $data = $this ->model ->db ->find($sql);
        $this ->smarty ->assign('group', $grouplist);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('orderField',  $postData['orderField']);
        $this ->smarty ->assign('orderDesc',   $postData['orderDesc']);
        $this ->smarty ->assign('numperpage',  $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount',  $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //公会列表
    public function guilds(){
        $postData = getRequest();
        //处理api参数增删改操作
        if($postData['api']=='add'){
            include(ROOT . 'configs/weather.php');//
            $lib_weather = new weather();
            $provices = $lib_weather->get_provices(); //省份
            if($postData['id'] > 0){
                $this ->model ->setTable('91yxq_publish.91yxq_sys');
                $this ->model ->setKey('id');
                $gInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                $this ->smarty ->assign('gInfo', $gInfo);
            //省市
                $provices_key=array_flip($provices);
                $provice_id = $provices_key[$postData['province']];
                include (ROOT.'configs/city_codes/city_codes.php');
                $cities = array();
                foreach($city_codes[$provice_id] as $key=>$val)
                {
                    if(is_array($val))
                    {
                        $cities[$key] = $val[0];
                    }
                }
                $this ->smarty ->assign('cities', $cities);
            }else{
                $sql ="SELECT * FROM " . GUILDINFO." WHERE user_name='".trim($postData['user_name'])."' or agentname='".trim($postData['agentname'])."'";
                $tmpone = $this ->model ->db ->get($sql);
                if($tmpone['id']>0){
                    ajaxReturn(C('Error:HaveOtherBodyUsedAccount'), 300); 
                }
            }
            if($postData['sub']==1){
                $prov=$provices[$postData['provice']];//省份
                $city=$postData['city'];
                $this ->model ->setTable(GUILDINFO);
                $arr=array(
                    'user_name' =>trim($postData['user_name']),
                    'user_pwd'  => trim($postData['user_pwd']),
                    'agentname' =>trim($postData['agentname']),
                    'state'     =>$postData['state']
                );
                $postData['mobel'] !='' && $arr['mobel'] = trim($postData['mobel']);
                $postData['yy'] !='' && $arr['yy'] = trim($postData['yy']);
                $postData['qq'] !='' && $arr['qq'] = trim($postData['qq']);
                $postData['bank'] !='' && $arr['bank'] = trim($postData['bank']);
                $postData['bank_son'] !='' && $arr['bank_son'] = trim($postData['bank_son']);
                $postData['account_name'] !='' && $arr['account_name'] = trim($postData['account_name']);
                $postData['account'] !='' && $arr['account'] = str_replace(' ','',trim($postData['account']));
                $prov !='' && $arr['province'] = $prov;
                $city !='' && $arr['city'] = $city;
                if($gInfo['id'] > 0){
                    $this ->model ->setKey('id');
                    $arr['revise_uid']=$this->adminfo['uid'];
                    $arr['revise_date'] = date("Y-m-d H:i:s");
                    $arr['id'] = $gInfo['id'];
                    $this ->model ->upRecordByKey($arr);
                }else{
                    $arr['adduid']=$this->adminfo['uid'];
                    $arr['add_date'] = date("Y-m-d H:i:s");
                    $this ->model ->addRecord($arr);
                }
                ajaxReturn(C('Ok:Operate'));
            }
            $this ->smarty ->assign('provices', $provices);
            $this ->smarty ->display($postData['action'].'/addGuild.html');
            exit();
        }else if($postData['api']=='del'){ 
            $this ->model ->setTable(GUILDINFO);
            if($postData['id'] >0){
                $this ->model ->setKey('id');
                $agentinfo=$this ->model ->getOneRecordByKey($postData['id']);
                $sql=" INSERT INTO ".GUILDDEL." set agent_id=".$agentinfo['id'].", agent_name='".$agentinfo['agentname']."',del_userid=".$this->adminfo['uid'].",del_time='".date('Y-m-d H:i:s')."'";
                $this ->model ->db ->query($sql);
                $this ->model ->delRecordByKey($postData['id']);
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }else if($postData['api']=='mult_del'){
            if(strlen($postData['ids']) >0){
                $arr = explode(',', $postData['ids']);
                $this ->model ->setTable(GUILDINFO);
                $this ->model ->setKey('id');
                foreach($arr as $v){
                    if($v > 0){
                        $agentinfo=$this ->model ->getOneRecordByKey($v);
                        $sql=" INSERT INTO ".GUILDDEL." set agent_id=".$agentinfo['id'].", agent_name='".$agentinfo['agentname']."',del_userid=".$this->adminfo['uid'].",del_time='".date('Y-m-d H:i:s')."'";
                        $this ->model ->db ->query($sql);
                        $this ->model ->delRecordByKey($v);
                    }
                }
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
        $where =' WHERE 1 ';
        if($postData['name'] !=''){
            $where .= " AND (agentname like '%".trim($postData['name'])."%' OR user_name like '%".trim($postData['name'])."%')" ;
        }
        if($postData['aid'] >0){
            $where .= ' AND id= '.  intval($postData['aid']);
        }
    //处理排序
        if( empty($postData['orderField']) ){
            $postData['orderField'] = 'id';
            $postData['orderDesc'] = 1;
        }
        $orderStr=$postData['orderField'];
        $orderStr.=$postData['orderDesc']==1? " DESC ":" ASC ";
        
        $sql = "SELECT COUNT(*) AS total FROM ".GUILDINFO.$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        if($postData['api'] =='export'){
            $sql = "SELECT * FROM ".GUILDINFO.$where." ORDER BY  ".$orderStr;
        }else{
            $sql = "SELECT * FROM ".GUILDINFO.$where." ORDER BY  ".$orderStr." LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        }
        $data = $this ->model ->db ->find($sql);
        $userlist=  parent::getUserList();
        $this ->smarty ->assign('userlist',$userlist);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('orderField', $postData['orderField']);
        $this ->smarty ->assign('orderDesc', $postData['orderDesc']);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //公会成员列表
    public function guildMembers(){
        $postData = getRequest();
        //处理api参数增删改操作
        if($postData['api']=='add'){
            $this ->model ->setTable(GUILDMEMBER);
            if($postData['id'] > 0){
                $this ->model ->setKey('site_id');
                $mInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                $this ->smarty ->assign('mInfo', $mInfo);
            }else{
                $this ->model ->setKey('aAccount');
                if($this ->model ->getOneRecordByKey($postData['aAccount'])){
                    ajaxReturn(C('Error:HaveOtherBodyUsedAccount'), 300);
                }
            }
            if($postData['sub']==1){
                if(!is_array($this ->guildlist[$postData['agent_id']])){
                    ajaxReturn(C('Error:ParamNotIsNull'), 300);
                }
                $arr=array(
                    'agent_id' =>$postData['agent_id'],
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
            $this ->smarty ->assign('guildlist', $this ->guildlist);
            $this ->smarty ->display($postData['action'].'/addGuildMember.html');
            exit();
        }else if($postData['api']=='del'){
            if($postData['id'] >0){
                $this ->model ->setTable(GUILDMEMBER);
                $this ->model ->setKey('site_id');
                $this ->model ->delRecordByKey($postData['id']);
                ajaxReturn(C('Ok:DeleteSub'));
            }
            ajaxReturn(C('Error:AccessError'), 300);
        }else if($postData['api']=='mult_del'){
            if(strlen($postData['ids']) >0){
                $arr = explode(',', $postData['ids']);
                $this ->model ->setTable(GUILDMEMBER);
                $this ->model ->setKey('site_id');
                foreach($arr as $v){
                    if($v > 0){
                        $this ->model ->delRecordByKey($v);
                    }
                }
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
        $where =' WHERE 1';
        if($postData['id'] >0){
            $where .=' AND agent_id ='.intval($postData['id']);
        }
        if($postData['name'] !=''){
            $where .= ' AND author like "%'.$postData['name'].'%"';
        }
        //处理排序
        if( empty($postData['orderField']) ){
            $postData['orderField'] = 'site_id';
            $postData['orderDesc'] = 1;
        }
        $orderStr=$postData['orderField'];
        $orderStr.=$postData['orderDesc']==1? " DESC ":" ASC ";
        
        $sql = "SELECT COUNT(*) AS total FROM ".GUILDMEMBER.$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql = "SELECT * FROM ".GUILDMEMBER.$where." order by ".$orderStr."  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];
        $data = $this ->model ->db ->find($sql);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('orderField', $postData['orderField']);
        $this ->smarty ->assign('orderDesc', $postData['orderDesc']);
        $this ->smarty ->assign('guildlist', $this ->guildlist);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
     //封闭链接与解封
    public function closeAdurl() {
        $postData = getRequest();
        $gamelist = parent::getGameList();
        if($postData['api']=='add'){
            $this ->model ->setTable(BANAGENTGAME);
            if($postData['id'] >0){
                if($postData['id'] > 0){
                    $this ->model ->setKey('id');
                    $mInfo = $this ->model ->getOneRecordByKey(intval($postData['id']));
                    $this ->smarty ->assign('close', $mInfo);
                }
            }
            if($postData['sub']==1){
                $arr=array(
                    'agent_id' =>intval($postData['agent_id']),
                    'game_id' =>intval($postData['game_id']),
                    'pid' =>intval($postData['pid']),
                    'server_id' =>intval($postData['server_id']),
                    'auid' =>$this->adminfo['uid'],
                    'atime' =>date('Y-m-d H:i:s')
                );
                if($postData['id'] >0){
                    $this ->model ->setKey('id');
                    $arr['id'] =$postData['id'];
                    $this ->model ->upRecordByKey($arr);
                }else{
                    $sql=" select id from ".BANAGENTGAME." where agent_id=".$postData['agent_id']." AND  game_id=".
                        $postData['game_id']." AND pid=".$postData['pid']." AND server_id=".$postData['server_id'];
                    $beid=$this ->model ->db ->get($sql);
                    if(!empty($beid)){
                        ajaxReturn("该链接已封，无需重复操作！",300);
                    }
                    $this ->model ->addRecord($arr);
                }  
                ajaxReturn(C("Ok:Operate"));   
            }
            $this ->smarty ->assign('gamelist', $gamelist);  
            $this ->smarty ->display($postData['action']."/addcloseAdurl.html");
            exit();
        }
        if($postData['api']=='jie'){
            if($postData['id'] >0){
                $sql="DELETE FROM ".BANAGENTGAME." WHERE id=".$postData['id'];
                $this ->model ->db ->query($sql);
                ajaxReturn(C("Ok:Operate"));  
            }
            ajaxReturn(C('Error:OprateFail'), 300);
        }
        $pageInfo = array('numperpage'=>20, 'totalcount' =>0, 'currentpage' =>1);
        if($postData['numPerPage'] > 0){
            $pageInfo['numperpage'] = $postData['numPerPage'];
        }
        if($postData['pageNum'] > 1){
            $pageInfo['currentpage'] = intval($postData['pageNum']);
        }
        
        $where=" where 1";
        if($postData['game_id'] >0){
             $where.=" AND a.game_id=".$postData['game_id'];
        }
        if($postData['agent_id'] >0){
            $where.=" AND a.agent_id=".$postData['agent_id'];
        }
        if($postData['server_id'] >0){
            $where.=" AND a.server_id=".$postData['server_id'];
        }
        $sql = "SELECT COUNT(*) AS total FROM ".BANAGENTGAME.$where;  
        $res = $this ->model ->db ->get($sql);
        $pageInfo['totalcount'] = $res['total'];
        $sql=" SELECT a.*,b.name,c.uName ".
                " FROM ".BANAGENTGAME." as a ".
                " left join  ".PAYDB.".".GAMELIST." as b on b.id=a.game_id ".
                " left join ".ADMINUSERS." as c on c.uid=a.auid ".
                $where." ORDER BY a.id  LIMIT ".(($pageInfo['currentpage']-1) * $pageInfo['numperpage']).", ".$pageInfo['numperpage'];   
        $data= $this-> model ->db ->find($sql);
        $this ->smarty ->assign('gamelist', $gamelist);
        $this ->smarty ->assign('data', $data);
        $this ->smarty ->assign('numperpage', $pageInfo['numperpage']);
        $this ->smarty ->assign('totalcount', $pageInfo['totalcount']);
        $this ->smarty ->assign('currentpage', $pageInfo['currentpage']);
    }
    //==============================私有函數=========================    
    //获取指定顶部模块对应左边菜单
    private function getLeftMenu($topInfo){
        global $allGrants;
        $leftMenu = array();
        foreach($allGrants as $val){
            if(floor(($val['key'] - $topInfo['key'])/1000) == 0 && $val['key'] != $topInfo['key'])
                array_push($leftMenu, $val);
        }
        $data = $this ->divideGrade($leftMenu);
        return $data;
    }
    //分级
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
    //获取顶部导航列表
    private function getTopMenu(){
        global $allGrants;
        $topMenu = array();
        foreach($allGrants as $val){
            if(fmod($val['key'], 1000)==0)
                array_push($topMenu, $val);
        }
        return $topMenu;
    }
}


