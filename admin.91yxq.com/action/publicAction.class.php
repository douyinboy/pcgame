<?php
 /**================================
  * 公共操作处理类（不进行权限验证的操作模块:public）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
ACCESS_GRANT != true && exit("forbiden!");
class publicAction extends Action{
//加载登录页面内容
    public function login(){
        if(isAjax())
            ajaxReturn(C('Error:LoginRequestModeError'), 300);
        if($this ->adminfo['uid'] > 0)
            header("Location: ".URL_INDEX);
    }
//加载异步登录界面
    public function ajaxLogin(){
        if(isAjax()){
        if($this ->adminfo['uid'] > 0)
                ajaxReturn(C('Ok:Login'));
        }else{
            toUrl('ERROR:404');
        }
    }
//加载验证码
    public function loadVerify(){
        $len = isset($_GET['plen'])?$_GET['plen']:4;
        $mode = isset($_GET['mode'])?$_GET['mode']:1;
        $type = isset($_GET['type'])?$_GET['type']:'gif';
        require_once(CLASS_DIR . 'Image.class.php');
        Image::buildImageVerify($len, $mode, $type);
		exit();
    }
//验证登录
    public function loginIn(){
        $pData = $_POST;
        $flag = 1; //登陆状态标记
        md5($pData['verify']) != $_SESSION['verify'] && $flag = 2;
        $this ->model ->setTable(ADMINUSERS);
        $this ->model ->setKey('uAccount');
        $uInfo = $this ->model ->getOneRecordByKey($pData['account']);
        $flag == 1 && !($uInfo && $uInfo['uPass'] == getPass($pData['password'], $uInfo['uAttend'])) && $flag = 3;
        if($flag == 1){ //登录成功
            //设置管理权限列表
            $this ->model ->setTable(ADMINGROUP);
            $this ->model ->setKey('gId');
            $gInfo = $this ->model ->getOneRecordByKey($uInfo['uGroupId']);
            if(!$gInfo && $gInfo['gState']!=1){
                //组权限受限处理
                if(isAjax()){
                    ajaxReturn(C('Error:CantFindTheGroup'), 300);
                }else{
                    toUrl('LOGIN',C('Error:CantFindTheGroup'));
                }
            }
            $ip=  getIP();
            $address=  parent::getplace($ip);
        /*记录登录信息*/
            $this ->model ->setTable(ADMINUSERS);
            $this ->model ->setKey('uid');
            $arr=array(
                'uid' =>$uInfo['uid'],
                'uLastLoginTime' =>time(),
                'uLastLoginIp' =>$ip,
                'uLoginCount' =>$uInfo['uLoginCount'] +1,
                'uLoginAddress' =>$address
            );
            $this ->model ->upRecordByKey($arr);
            //设置管理人员信息
            $managerinfo = array(
                'uid' =>$uInfo['uid'], 
                'account' =>$uInfo['uAccount'], 
                'name' =>$uInfo['uName'],
                'passext' =>$uInfo['uAttend'], 
                'gId' =>$uInfo['uGroupId'],
                'gName' =>$gInfo['gName'],
                'guilds' =>unserialize($uInfo['uGuildList'])
                );
            $managerinfo['guilds'] = $uInfo['uGroupId']==0 ? 0 : unserialize($uInfo['uGroupId']);
            $_SESSION['admin'] = $managerinfo;
            if($gInfo['gGrants'] == 'all'){
                $_SESSION['grant_key'] = $_SESSION['grant_list'] = 'all';
            }else{
                include(DATA_DIR . 'grantlist.php');               
                $_SESSION['grant_key'] = unserialize($gInfo['gGrants']);
                $grantlist = array();
                foreach($_SESSION['grant_key'] as $v){
                    if($allGrants[$v]['module']!=''){
                       $grantlist[$allGrants[$v]['module']][] = $allGrants[$v]['option'] != '' ? 'index':$allGrants[$v]['option'];
                    }
                }
                $_SESSION['grant_list'] = $grantlist;
            }
            if(isAjax()){
                ajaxReturn(C('Ok:Login'));
            }else{
                toUrl('INDEX');
            }
        }
        //登录失败处理
        if(isAjax()){
            ajaxReturn(C('Error:LoginError_'.$flag), 300);
        }else{
            toUrl('LOGIN', C('Error:LoginError_'.$flag));
        }
    }
//退出登录
    public function loginOut(){
        $_SESSION = array();
        session_destroy();
        toUrl('LOGIN');
    }    
//不存在的页面跳转处理
    public function error404(){
    }
//private函数
    private function writeLog($str, $file){
        if(WRITELOG)
            file_put_contents($file, $str, FILE_APPEND);
    }
}