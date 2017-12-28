//获取表单对象
function gID(getID){
    return document.getElementById(getID);
}

function url53kf(){
	window.open('http://chat.53kf.com/company.php?arg=zitian&style=1');
}

//写cookie
function setCookie(cookieName, cookieValue, seconds) {
    var expires = new Date();
    expires.setTime(expires.getTime() + parseInt(seconds)*1000);
    document.cookie = escape(cookieName) + '=' + escape(cookieValue) + (seconds ? ('; expires=' + expires.toGMTString()) : "") + '; path=/; domain=demo.com;';
}

//获取cookie
function getCookie(cname) {
    var cookie_start = document.cookie.indexOf(cname);
    var cookie_end = document.cookie.indexOf(";", cookie_start);
    return cookie_start == -1 ? '' : decodeURI(document.cookie.substring(cookie_start + cname.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}


//添加收藏夹
function addBookmark(url,title){
    if (window.sidebar) {
        window.sidebar.addPanel(title, url,"");
    } else if( document.all ) {
        window.external.AddFavorite( url, title);
    } else if( window.opera && window.print ) {
        return true;
    }
}


//设为首页
function setHomepage(url,title){
    if (document.all)
    {
        document.body.style.behavior='url(#default#homepage)';
        document.body.setHomePage(url);
    }
    else if (window.sidebar)
    {
        if(window.netscape)
        {
             try
            {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
             }
             catch (e)
             {
                alert( "该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true" );
             }
        }
    var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components. interfaces.nsIPrefBranch);
    prefs.setCharPref(title,url);
    }
}

//获取渠道id
var agentIDArray = Array(
"1026^vs^1030","1023^baidu.com^1027","1024^google.com.hk^1028","1025^hao123.com^1029","1027^114la.com^1031","1028^dh818.com^1032","1029^2345.com^1033","1030^go2000.cn^1034","1031^365j.com^1035","1032^qq5.com^1036","1033^1616.net^1037","1034^uusee.net^1038","1035^9991.com^1039","1036^v2233.com^1040","1037^kzdh.com^1041","1038^46.com^1042","1039^345ba.com^1043","1040^zhaodao123.com^1044","1041^duote.com^1045","1042^91danji.com^1046","1043^quxiu.com^1047","1044^duotegame.com^1048","1045^360.cn^1049","1046^haouc.com^1050","1047^17173.com^1051","1048^86wan.com^1052","1049^966.com^1053","1050^yzz.cn^1054","1051^07073.com^1055","1052^cwebgame.com^1056","1053^2366.com^1057","1054^766.com^1058","1055^e3ol.com^1059","1056^reyoo.net^1060","1057^ccjoy.com^1061","1058^265g.com^1062","1059^duowan.com^1063","1060^pcgames.com.cn^1064","1061^maituan.com^1065","1062^6dan.com^1066","1063^9u8u.com^1067","1064^92pk.com^1068","1065^kkpk.com^1069","1066^wangye2.com^1070","1067^popwan.com^1071","1068^5068.com^1072","1069^521g.com^1073","1070^juxia.com^1074","1071^52kl.net^1075","1072^131.com^1076","1073^game.163.com^1077","1074^e004.com^1078","1075^173eg.com^1079","1076^uuu9.com^1080","1077^games.sina.com.cn^1081","1078^fm4399.com^1082"
);

function getAgentID(){
    lastUrl = document.referrer;
    var agent_id =0 ;  //渠道id
    var placeid =0 ;  //广告位id
    agent_id = getQueryString("agent_id");
    if (!agent_id){
        var agenttmp = "";
        for(var i = 0 ;i<agentIDArray.length;i++){
            agenttmp = agentIDArray[i].split("^");
            if (lastUrl.indexOf(agenttmp[1])!= -1){
                agent_id = agenttmp[0];
                placeid = agenttmp[2];
            }
        }
    }
    if (agent_id>0){
        setCookie("agent_id",agent_id,3600);
        setCookie("placeid",placeid,3600);
    }
    return agent_id;
}


//组对象显示隐藏
function showDiv(tag,num,tid){
    for(var i=0;i<num;i++){
        gID(tag+i).style.display='none';
    }
    if(tid!=null){
        gID(tag+tid).style.display="block";
    }
}


function setClass(tag,classname){
    gID(tag).className=classname;
}

//版权信息年份
function getCurrYear(aYearID){  //font html
    var myDate = new Date();
    var curYear = myDate.getFullYear(); //获取完整的年份
    try{
        yearObj = document.getElementById(aYearID);
    }catch(e){;}
    if(yearObj){
        yearObj.innerHTML = curYear;
    }
}


//获取传参值
function    getQueryString(queryStringName){
    var    returnValue="";
    var    URLString=new    String(document.location);
    var    serachLocation=-1;
    var    queryStringLength=queryStringName.length;
    do    {
        serachLocation=URLString.indexOf(queryStringName+"\=");
        if    (serachLocation!=-1) {
            if    ((URLString.charAt(serachLocation-1)=='?')    ||    (URLString.charAt(serachLocation-1)=='&')) {
                URLString=URLString.substr(serachLocation);
                break;
            }
            URLString=URLString.substr(serachLocation+queryStringLength+1);
        }
    }
    while    (serachLocation!=-1)
    if    (serachLocation!=-1){
        var    seperatorLocation=URLString.indexOf("&");
        if    (seperatorLocation==-1)    {
            returnValue=URLString.substr(queryStringLength+1);
        }
        else{
            returnValue=URLString.substring(queryStringLength+1,seperatorLocation);
        }
    }
    returnValue   =   returnValue.replace(/#/g,'');
    return    returnValue;
}

//
getAgentID();

try{
    ref = escape(document.referrer);
}catch(e){}

if(ref.indexOf('demo.com')==-1 && ref!=''){
    setCookie("from_url",ref,3600);
}

function showAllGameLst(aFlag){
    if (gID("allGameLstDiv")){
        gameLstDiv = gID("allGameLstDiv");
        if(aFlag==1){
            gameLstDiv.style.display ='block';
        }else{
            gameLstDiv.style.display = 'none';
        }
    }
}