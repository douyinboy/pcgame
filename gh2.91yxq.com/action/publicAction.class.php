<?php
 /**================================
  * 公共操作处理类（不进行权限验证的操作模块:public）
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会后台管理系统
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
        $this ->model ->setTable(GUILDMEMBER);
        $this ->model ->setKey('aAccount');
        $uInfo = $this ->model ->getOneRecordByKey($pData['account']);
        $flag == 1 && !($uInfo && $uInfo['aPass'] == $pData['password']) && $flag = 3;
        if($flag == 1){ //登录成功
            //公会信息
            $this ->model ->setTable(GUILDINFO);
            $this ->model ->setKey('id');
            $ggInfo = $this ->model ->getOneRecordByKey($uInfo['agent_id']);
            if($uInfo['state']!=1 || $ggInfo['state'] !=1){
                //账号被禁或者不存在
                if(isAjax()){
                    ajaxReturn(C('Error:GuidForbidden'), 301);
                }else{
                    toUrl('LOGIN',C('Error:GuidForbidden'));
                }
                exit();
            }
            //设置管理人员信息
            $managerinfo = array(
                'uid' =>$uInfo['site_id'], 
                'account' =>$uInfo['aAccount'], 
                'name' =>$uInfo['author'],
                'agent_id' =>$uInfo['agent_id'],
                'agentname' => $ggInfo['agentname']
                );
            $_SESSION['member'] = $managerinfo;
            $_SESSION['grant_key'] = $_SESSION['grant_list'] = 'all';
    //更新最后登录时间和IP
            $this ->model ->setTable(GUILDMEMBER);
            $this ->model ->setKey('site_id');
            $ip=  getIP();
            $place=  parent::getplace($ip);
            $fieldsVal = array('site_id' =>$uInfo['site_id'], 'loginIp' =>  getIP(), 'loginTime' => date("Y-m-d H:i:s"),'loginAddress'=>$place,'logincount'=>$uInfo['logincount']+1);
            $res = $this ->model ->upRecordByKey($fieldsVal);
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