////加载登录消息框js
var head = document.getElementsByTagName("head")[0],
    script  = document.createElement("script");
script.type = "text/javascript";
script.src = 'http://www.demo.com/jsCommon/login_tips.js';
head.insertBefore(script,head.firstChild);//head.appendChild(css);//后插可能效率差点
////

function ucGID(fid){
    try{
        return document.getElementById(fid);
    }catch(e){ return false;}

}

//读取cookie值
function getUsrInfoCookie(sName){
  var aCookie = document.cookie.split("; ");
    for (var i=0; i < aCookie.length; i++){
        var aCrumb = aCookie[i].split("=");
        if (encodeURIComponent(sName) == aCrumb[0]){
            return decodeURIComponent(aCrumb[1]);
        }
    }
  return null;
}

function InputKeyPress(aFrm,aFlag){
    var e = arguments[2];
    e=e||window.event;
    var kCode=e.keyCode||e.which||e.charCode;

    if(kCode == '13'){
        switch(aFlag){
            case 'login':
               if(document.getElementById(aFrm)!=null){
                  document.getElementById(aFrm).onsubmit=function(){return false};
               }
               sentLoginData();
               break;
            default :
               alert('参数错误');
               break;
        }
    }
}

//注册

//检查登录状态
function chkAccStatus(){//regLogObj0：登录前  regLogObj1：登录后  regLogObj2：注册
    var logFlag=getUsrInfoCookie('login_name');
    if(logFlag){
        var logUsrName=unescape(getUsrInfoCookie('login_name'));
        if(ucGID("usrAccount")){
            var qq_nick=unescape(getCookie('qq_nick'));
            if(qq_nick&&logUsrName.indexOf('@qq')>0){
                ucGID("usrAccount").innerHTML='<img src="http://image.demo.com/imgCommon/qqico.gif" width="16" height="16" />'+qq_nick+' - '+logUsrName;
            }else{
                ucGID("usrAccount").innerHTML=logUsrName ? '尊敬的：'+logUsrName :"游客";
            }
        }
        ucGID("regLogObj0").style.display="none";
        ucGID("regLogObj1").style.display="block";
        setCookie('last_name',escape(logUsrName),86400000*365);
    } else { // 没有登陆成功
        if(getCookie('last_name')){
            ucGID('login_user').value=unescape(getUsrInfoCookie('last_name'));
        }
        ucGID("regLogObj0").style.display="block";
        ucGID("regLogObj1").style.display="none";
    }
}

//检查登录状态
function chkAccStatus_0(){//单个用户名+ 最近玩过的游戏；   regLogObj0：登录前  regLogObj1：登录后  regLogObj2：注册
    var logFlag=getUsrInfoCookie('loginreg');
    if(logFlag){
        var logUsrName=unescape(getUsrInfoCookie('login_name'));
        if(ucGID("usrName")){
            ucGID("usrName").innerHTML=logUsrName ? logUsrName :"游客";
        }
        var lstGameList = getUsrInfoCookie('login_game_info');
        lstGameList=unescape(lstGameList);
        tt = lstGameList.split("<a href=");
        if(!tt[1]){
            lstGameList     = "您还没有玩过游戏！";
        }

        ucGID("lstGameList").innerHTML = lstGameList;
        ucGID("regLogObj0").style.display="none";
        ucGID("regLogObj1").style.display="block";
    } else { // 没有登陆成功
        ucGID("regLogObj0").style.display="block";
        ucGID("regLogObj1").style.display="none";
    }
}

//退出
function LogoutWithGoto(aBackFlag){
    if (aBackFlag=="1"){
        gotoUrl = location.href;
    }else{
        gotoUrl = "http://www.demo.com/";
    }
    LogoutUrl = "http://www.demo.com/api/check_login_user.php?act=logout" + "&backurl=" + escape(gotoUrl) ; // 这里要完善为encodeUrl
    location.href= LogoutUrl;
}

function sentLoginData(){    //登录
    var backCurPage = arguments[0] ? arguments[0] : '1';//默认为登录成功后回到当前页面；
    var login_user=ucGID('login_user');
    var login_pwd=ucGID('passwd');

    if(!login_user.value){
        login_tips.show_msg('帐号不能为空！');
        login_user.focus();
        return false;
    }

    if(!login_pwd.value){
        login_tips.show_msg('密码不能为空！');
        login_pwd.focus();
        return false;
    }
    var url="http://www.demo.com/api/check_login_user.php?act=login";
    var paras="&login_user="+login_user.value+"&login_pwd="+login_pwd.value;

    //跨域问题解决；
    $.getJSON(url + paras + '&callback=?',
        function(data){
            switch(data.code){
                case '01':
                    login_tips.show_msg(data.msg);
                    break;
                case '02':
                    login_tips.show_verify();
                    break;
                case '10':
                    if (backCurPage=="1"){  //默认为登录成功后返回到当前页面
                        gotoUrl = location.href;
                    }else{
                        if (ucGID("logGotoUrl") && ucGID("logGotoUrl").value.length > 7){//指定需要跳转的页面地址；
                            gotoUrl = ucGID("logGotoUrl").value;
                        }else{
                            gotoUrl = "http://www.demo.com/";
                        }
                    }
                    location.href= gotoUrl;
                    break;
            }
        }
    );
    return false;
}

function sentAdLoginData(par){    //POP.AD广告登录
    var backCurPage = arguments[0] ? arguments[0] : '1';//默认为登录成功后回到当前页面；
    var login_user=ucGID('login_user');
    var login_pwd=ucGID('passwd');

    if(!login_user.value){
        login_tips.show_msg('帐号不能为空！');
        login_user.focus();
        return false;
    }

    if(!login_pwd.value){
        login_tips.show_msg('密码不能为空！');
        login_pwd.focus();
        return false;
    }
    var url="http://www.demo.com/api/check_login_user.php?act=login";
    var paras="&login_user="+login_user.value+"&login_pwd="+login_pwd.value;

    //跨域问题解决；
    $.getJSON(url + paras + '&callback=?',
        function(data){
            switch(data.code){
                case '01':
                    login_tips.show_msg(data.msg);
                    break;
                case '02':
                    login_tips.show_verify();
                    break;
                case '10':
                    location.href="http://www.demo.com/"+par+"/list/";
                    break;
            }
        }
    );
    return false;
}



function sendLogDataBysid(aFrmLog) {
    var canSubmit = true;
    var username = ucGID('logUsrName');
    if (username.value=='') {
        alert('账号不能为空！请您输入');
        canSubmit = false;
        username.focus();
        return false;
    }

    var login_pwd = ucGID('logUsrPwd');
    if (login_pwd.value=='') {
        alert('密码不能为空！请您输入');
        canSubmit = false;
        login_pwd.focus();
        return false;
    }

    var frmActionUrl = aFrmLog.action;
    var game_id = '1',server_id='1';
    if(ucGID('game_id')){
        game_id = aFrmLog.game_id.value;
    }
    if(ucGID('server_id')){
        server_id = aFrmLog.server_id.options[aFrmLog.server_id.options.selectedIndex].value;
    }
    frmActionUrl = 'http://www.demo.com/index.php?act=gamelogin&game_id='+game_id+'&server_id='+server_id;
    aFrmLog.action = frmActionUrl;
    if (canSubmit) {
        aFrmLog.submit();
    }
}

function chgMeiTiWithCls_2(tabID,tabCls_0,tabCls_1,aFlag){  //内嵌的切换——样式
    if (aFlag==0){
        ucGID(tabID + "Tab_0").className=tabCls_0;
        ucGID(tabID + "Tab_1").className=tabCls_1;
        ucGID(tabID + "Lst_0").style.display="block";
        ucGID(tabID + "Lst_1").style.display="none";
    }else {
        ucGID(tabID + "Tab_0").className= tabCls_1;
        ucGID(tabID + "Tab_1").className=tabCls_0;
        ucGID(tabID + "Lst_0").style.display="none";
        ucGID(tabID + "Lst_1").style.display="block";
    }
}