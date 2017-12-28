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
            ajaxReturn(C('Error:LoginTimeOut'), 301);
        
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
        $this ->model ->setTable(GUILDINFO);
        $this ->model ->setKey('user_name');
        $uInfo = $this ->model ->getOneRecordByKey($pData['account']);
        $flag == 1 && !($uInfo && $uInfo['user_pwd'] == $pData['password']) && $flag = 3;
        if($flag == 1){ //登录成功
            if($uInfo['state']!=1 || $uInfo['agenttype']!=1){
                //公会账号被禁或者不存在
                if(isAjax()){
                    ajaxReturn(C('Error:GuidForbidden'), 301);
                }else{
                    toUrl('LOGIN',C('Error:GuidForbidden'));
                }
                exit();
            }
            //设置管理人员信息
            $managerinfo = array(
                'uid' =>$uInfo['id'], 
                'account' =>$uInfo['user_name'], 
                'name' =>$uInfo['agentname'],
                'regdate' =>$uInfo['add_date'],
                'logincount' =>$uInfo['logincount'],
                'loginaddress' =>$uInfo['loginaddress']
                );
            $_SESSION['user'] = $managerinfo;
            $_SESSION['grant_key'] = $_SESSION['grant_list'] = 'all';
            //更新最后登录时间和IP
            $this ->model ->setKey('id');
            $ip=  getIP();
            $place=  parent::getplace($ip);
            $fieldsVal = array('id' =>$uInfo['id'], 'lastip' =>  $ip, 'lastdate' => date("Y-m-d H:i:s"),'loginaddress'=>trim($place),'logincount' =>$uInfo['logincount']+1);
            $res = $this ->model ->upRecordByKey($fieldsVal);
            $this ->model ->db->query("insert into ".GUILDLOGINLOG." (agent_id,longin_time,longin_ip) values (".$uInfo['id'].",'".date('Y-m-d H:i:s')."','".$ip."')");
            
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