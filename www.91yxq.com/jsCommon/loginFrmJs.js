function load_script($file){
    var head = document.getElementsByTagName("head")[0],
        script  = document.createElement("script");
    script.type = "text/javascript";
    script.src = $file;
    head.insertBefore(script,head.firstChild);//head.appendChild(css);//后插可能效率差点
}

load_script('http://www.6qwan.com/jsCommon/jquery.js');
load_script('http://www.6qwan.com/jsCommon/login_tips.js');

function chkFrmInfo(aFrmLog) {

    var login_user=$("#login_user").val();
    var login_pwd=$("#login_pwd").val();
    if( login_user == ''){
        login_tips.show_msg('请输入账号！');
        $("#login_user").focus();
        return false;
    }
    if(login_pwd == ''){
        login_tips.show_msg('请输入密码！');
        $("#login_pwd").focus();
        return false;
    }

    var url="http://www.6qwan.com/api/check_login_user.php?act=login";
    var paras={'login_user':login_user,'login_pwd':login_pwd};
    $.ajax(
    {
    type:"POST",
    url:url,
    data:paras,
    dataType : 'json',
    success: function(data)
    {
        switch(data.code){
            case '01':
                login_tips.show_msg(data.msg);
                break;
            case '02':
                login_tips.show_verify();
                break;
            case '10':
                window.location.href = window.location.href;
                break;
        }
    },
    error:function()
    {
        login_tips.show_msg('网络故障，验证失败！');
        return false;
    }
    });
    return false;
}

function InputKeyPress(theform){
//兼容IE和Firefox获得keypress
    var currKey=0,CapsLock=0;
    var e = arguments[1];
    e=e||window.event;;
    var kCode=e.keyCode||e.which||e.charCode;
    if(kCode == '13'){
        if(document.getElementById(theform)!=null){
            document.getElementById(theform).onsubmit=function(){return false;};
        }else if(document.getElementById('frmLogin')!=null){
            document.getElementById('frmLogin').onsubmit=function(){return false;};
        }
        chkFrmInfo(theform);
    }
}

//添加收藏夹
function addBookmark(){
    url = window.location.href;
    title = window.document.title;
    if (window.sidebar) {
        window.sidebar.addPanel(title, url,"");
    } else if( document.all ) {
        window.external.AddFavorite( url, title);
    } else if( window.opera && window.print ) {
        return true;
    }
}

function getUNameCookie()
{
    var cook= MyCookie.Get('remUserName');
    if (cook){
        document.getElementById('login_user').value = cook;
        document.getElementById('login_pwd').focus();
        document.getElementById('remUName').checked = "checked";
    }else {
        document.getElementById('login_user').focus();
        }
}

function setUNameCookie(aObjID)
{
    if (document.getElementById('remUName').checked){
        var usrName = document.getElementById(aObjID).value;
        MyCookie.Set('remUserName',usrName);
    } else {
        MyCookie.Set('remUserName',"",-86400);
        }
}

var paras=window.location.search;
paras=paras.substr(5,paras.length-1);
if(paras=='do'){
    document.getElementById("xskFloatDiv").style.display="block";
}