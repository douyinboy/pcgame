function $id(ids)
{
	return document.getElementById(ids);
}
function showTab_nav(O)
{
	var mli=$id("dhlist").getElementsByTagName("li");
	for(i=0;i<mli.length;i++)
	{
		mli[i].className=(O==mli[i]?"sel":"");
	}
}


//-2013-01-14-
function showNewsTabs(m,l,n)
{
	var mli=$id(m).getElementsByTagName("li");
	for(i=0;i<mli.length;i++)
	{
		var ldiv=$id(l+"_"+i);
		mli[i].className=i==n?"current":"";
		ldiv.style.display=(i==n?"block":"none");
	}
}


//获取表单对象
function gID(getID){
	return document.getElementById(getID);
}

//写cookie
function setCookie(cookieName, cookieValue, seconds) {
	var expires = new Date();
	expires.setTime(expires.getTime() + parseInt(seconds)*1000);
	document.cookie = escape(cookieName) + '=' + escape(cookieValue) + (seconds ? ('; expires=' + expires.toGMTString()) : "") + '; path=/; domain=6qwan.com;';
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

/*
鼠标滑动改变样式
setMouse("newsList", ["li", "ul", ".newsList_other"], ["zh", "gg", "hd", "mt"], "replace", ["http://www.91wan.com/", "http://www.91wan.com/", "http://www.91wan.com/", "http://www.91wan.com/"]);
*/
function setMouse(a, b, c, d, e) {
	if (!document.getElementById(a + "_Clicks")) return;
	$("#" + a + "_Clicks " + b[0]).each(function(g) {
		var h = $(this);
		$(this).bind("mouseover",
		function() {
			if (typeof e == "object" && e.length > 0) $("#" + a + "_Link").attr("href", e[g]);	//改变链接地址
			
			//改变背景样式
			var f = $("#" + a + "_Clicks " + b[0] + "[re-class]")[0];
			if (f) {
				f.className = $(f).attr("re-class");
				$(f).removeAttr("re-class")
			}
			if (h[0].className && h[0].className != "") h.attr("re-class", h[0].className);
			if (d == "replace") {
				h[0].className = c[g]
			} else if (d == "add") {
				h.addClass(c[g])
			} else if (d == "replaceImg"){
				var ii = $("#" + a + "_Clicks " + 'img' + "[re-img]")[0];
				if(ii){
				ii.src = $(ii).attr("re-img");
				$(ii).removeAttr("re-img");
				}
				$(h[0].childNodes[0]).attr("re-img",h[0].childNodes[0].src);
				h[0].childNodes[0].src = c[g];
			} 
			
			//显示隐藏属性的更改
			if (document.getElementById(a + "_ShowOrHides")) {
				$("#" + a + "_ShowOrHides " + b[1]).hide();
				$($("#" + a + "_ShowOrHides " + b[1]).get(g)).show()
			}
			if (b.length > 2) {
				for (var j = 2; j < b.length; j++) {
					$(b[j]).hide();
					$(b[j]).eq(g).show()
				}
			}
		});
	})
}

//页面插入swf
function htmlSWF(id,swf_url,swf_width,swf_height) {
    if(document.getElementById(id)==null) return;
    var html=
        '<object classid="clsid:D27CDB6E-AE6D-11CF-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" border="0" width="'+swf_width+'" height="'+swf_height+'">'+
        '<param name="movie" value="'+swf_url+'">'+
        '<param name="quality" value="high"> '+
        '<param name="wmode" value="transparent"> '+
        '<param name="menu" value="false"> '+
        '<embed src="'+swf_url+'" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" name="obj1" width="'+swf_width+'" height="'+swf_height+'" quality="High" wmode="transparent"></embed>'+
        '</object>';
    document.getElementById(id).innerHTML = html;
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
"1129^baidu.com^1284","1130^google.com.hk^1285","1131^hao123.com^1286","1132^vs^1287","1133^114la.com^1288","1134^dh818.com^1289","1135^2345.com^1290","1136^go2000.cn^1291","1137^365j.com^1292","1138^qq5.com^1293","1139^1616.net^1294","1140^uusee.net^1295","1141^9991.com^1296","1142^v2233.com^1297","1143^kzdh.com^1298","1144^46.com^1299","1145^345ba.com^1300","1146^zhaodao123.com^1301","1147^duote.com^1302","1148^91danji.com^1303","1149^quxiu.com^1304","1150^duotegame.com^1305","1151^360.cn^1306","1152^haouc.com^1307","1153^17173.com^1308","1154^86wan.com^1309","1155^966.com^1310","1156^yzz.cn^1311","1157^07073.com^1312","1158^cwebgame.com^1313","1159^2366.com^1314","1160^766.com^1315","1161^e3ol.com^1316","1162^reyoo.net^1317","1163^ccjoy.com^1318","1164^265g.com^1319","1165^duowan.com^1320","1166^pcgames.com.cn^1321","1167^maituan.com^1322","1168^6dan.com^1323","1169^9u8u.com^1324","1170^92pk.com^1325","1171^kkpk.com^1326","1172^wangye2.com^1327","1173^popwan.com^1328","1174^5068.com^1329","1175^521g.com^1330","1176^juxia.com^1331","1177^52kl.net^1332","1178^131.com^1333","1179^game.163.com^1334","1180^e004.com^1335","1181^173eg.com^1336","1182^uuu9.com^1337","1183^games.sina.com.cn^1338","1184^fm4399.com^1339"
);	

function getAgentID(){
	lastUrl = document.referrer;
	var agent_id =0 ;  //渠道id
	var placeid =0 ;  //广告位id
	agent_id = getQueryString("agent_id");
	placeid = getQueryString("site_id");
	var cplaceid = getQueryString("cplaceid");
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
		setCookie("cplaceid",cplaceid,3600);
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
function	getQueryString(queryStringName){
	var	returnValue="";
	var	URLString=new	String(document.location);
	var	serachLocation=-1;
	var	queryStringLength=queryStringName.length;
	do	{
		serachLocation=URLString.indexOf(queryStringName+"\=");
		if	(serachLocation!=-1) {
			if	((URLString.charAt(serachLocation-1)=='?')	||	(URLString.charAt(serachLocation-1)=='&')) {
				URLString=URLString.substr(serachLocation);
				break;
			}
			URLString=URLString.substr(serachLocation+queryStringLength+1);
		}
	}
	while	(serachLocation!=-1)
	if	(serachLocation!=-1){
		var	seperatorLocation=URLString.indexOf("&");
		if	(seperatorLocation==-1)	{
			returnValue=URLString.substr(queryStringLength+1);
		}
		else{
			returnValue=URLString.substring(queryStringLength+1,seperatorLocation);
		}	
	}
	returnValue   =   returnValue.replace(/#/g,''); 
	return	returnValue;
}

//
getAgentID();

try{
    ref = escape(document.referrer);
}catch(e){}

if(ref.indexOf('336.com')==-1 && ref!=''){
	setCookie("from_url",ref,3600);
}

function HotGame(d){
	if(d==1){
		$('#hotgame').show();
	} else {
		$('#hotgame').hide();
	}
}
