if(typeof(BASEDNAME)!="string") var BASEDNAME = '511wan.com';
if(typeof(GAME_ID)!="string") var GAME_ID = '0';
if(typeof(NOTLOADUSERJS)!="boolean") var NOTLOADUSERJS = false;
var input = document.createElement('input');
var isPlaceholder = 'placeholder' in input;
jQuery.cookie = function(name, value, options) {
	if (typeof value != 'undefined') {
		options = options || {};
		if (value === null) {
			value = '';
			options = $.extend({}, options);
			options.expires = -1;
		}
		var expires = '';
		if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
				date = new Date();
				date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
			} else {
				date = options.expires;
			}
			expires = '; expires=' + date.toUTCString();
		}
		var path = options.path ? '; path=' + (options.path) : '';
		var domain = options.domain ? '; domain=' + (options.domain) : '';
		var secure = options.secure ? '; secure' : '';
		document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	} else {
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}
};
function getUnixTime()
{
	var times = new Date();
	return parseInt(times.getTime()/1000);
}
function __form_done(url , msg)
{
	if(typeof(msg)!="undefined") alert(msg);
	top.location = url;
}
function __form_error(msg) {
	$("#errorinfo_form").html(msg);
	$(".submit_disable").removeAttr("disabled");
}
/**
 * 获取指定URL的参数值
 * @param url	指定的URL地址
 * @param name	参数名称
 * @return	参数值
 */
function getUrlParam(url,name){
	var pattern = new RegExp("[?&]"+name+"\=([^&]+)", "g");
	var matcher = pattern.exec(url);
	var items = null;
	if(null != matcher){
		try{
			items = decodeURIComponent(decodeURIComponent(matcher[1]));
		}catch(e){
			try{
				items = decodeURIComponent(matcher[1]);
			}catch(e){
				items = matcher[1];
			}
		}
	}
	return items;
}
$(document).ready(function(){
	if (!isPlaceholder) {//不支持placeholder 用jquery来完成
		if(!isPlaceholder){
			$("input[type='text']").not("input[type='password']").each(//把input绑定事件 排除password框
				function(){
					if($(this).val()=="" && $(this).attr("placeholder")!=""){
						$(this).val($(this).attr("placeholder"));
						$(this).focus(function(){
							if($(this).val()==$(this).attr("placeholder")) $(this).val("");
						});
						$(this).blur(function(){
							if($(this).val()=="") $(this).val($(this).attr("placeholder"));
						});
					}
				});
			//对password框的特殊处理1.创建一个text框 2获取焦点和失去焦点的时候切换
			$("input[type=password]").each(function(i,e){

				var pwdField = $(this);
				if(typeof(pwdField.attr('placeholder'))!="undefined" ) {
					var pwdVal		= pwdField.attr('placeholder');
					var pwdClass	= pwdField.attr('class');
					pwdField.after('<input id="pwdPlaceholder_'+i+'" type="text" value='+pwdVal+' autocomplete="off" class="'+pwdClass+'" />');
					var pwdPlaceholder = $('#pwdPlaceholder_'+i);
					pwdPlaceholder.show();
					pwdField.hide();

					pwdPlaceholder.focus(function(){
						pwdPlaceholder.hide();
						pwdField.show();
						pwdField.focus();
					});

					pwdField.blur(function(){
						if(pwdField.val() == '') {
							pwdPlaceholder.show();
							pwdField.hide();
						}
					});
				}
			});

		}
	}
	if(NOTLOADUSERJS==false) {
		var cookie_lgkey = $.cookie('lgkey');
		if (typeof(cookie_lgkey)=="string" && cookie_lgkey.length==32) {
			$.getJSON("http://my."+BASEDNAME+"/islogin.jsp?game_id="+GAME_ID+"&jsoncallback=?", function(data){
				if(data.islogin) {
					$.each(data.user, function(i, v){
						if(i=='avatar'){
							$(".userinfo_"+i).attr('src',v);
						}else if(i=='vip'){
							$(".userinfo_"+i).addClass('vip'+v);
						}
						else if(i == "active_combine"){
							if(v == 0){
								$("#active_combine_iframe_index").show();
							}
							else{
								$("#active_combine_iframe_index").hide();
							}
						}else if(i == "sysadd"){
							if(v == 1){
								$('.systemvit_bt').removeClass('end');
								$('.systemvit_bt').addClass('sysvit');
							}else{
								$('.systemvit_bt').removeClass('sysvit');
								$('.systemvit_bt').addClass('end');
							}
						}else if(i == "uname"){
							if(v == "微信用户"){
								$(".userinfo_"+i).html(data.user.showname+'<font color="red">(补全)</font>');
								$(".userinfo_"+i).attr('href','javascript:(0);');
								$(".userinfo_"+i).addClass('JsClass_completeiframe');
								$('.JsClass_completeiframe').live('click',function(){
									completeiframe(BASEDNAME);
								});
							}else{
								$(".userinfo_"+i).html(v);
								if(data.user.bindwx == 0){
									$(".userinfo_uname").parent().append('<div class="js-bqzl"><em onclick="$(this).parent().hide();" class="close_right"></em><a href="http://www.' + BASEDNAME + '/task/guidenewtask.jsp" target="_blank">补全资料获取100积分</a></div>');
									$(".userinfo_uname").attr('href','http://www.' + BASEDNAME + '/task/guidenewtask.jsp');
									$(".userinfo_uname").addClass('JsClass_completeiframe');
									/*if(data.user.is_novice_limit == 2){
										$(".userinfo_uname").parent().append('<div class="js-bqzl"><em onclick="$(this).parent().hide();" class="close_right"></em><a href="http://www.' + BASEDNAME + '/task/guidenewtask.jsp" target="_blank">补全资料获取100积分</a></div>');
										$(".userinfo_uname").attr('href','http://www.' + BASEDNAME + '/task/guidenewtask.jsp');
										$(".userinfo_uname").addClass('JsClass_completeiframe');
									}else{
										$(".userinfo_uname").parent().append('<div class="js-bqzl"><em onclick="$(this).parent().hide();" class="close_right"></em><a href="http://www.' + BASEDNAME + '/task/guidenewtask.jsp" target="_blank">补全资料获取100积分</a></div>');
										$(".userinfo_uname").attr('href','javascript:;');
										$(".userinfo_uname").addClass('JsClass_completeiframe');
										$('.JsClass_completeiframe').live('click',function(){
											completeiframe(BASEDNAME);
										});
									}*/
								}
							}
						}else{
							$(".userinfo_"+i).html(v);
						}
					});
					$.each(data.novice, function(i, v){
						$(".signin").attr(i,v);
					});
					if(typeof(data.played_game)=="object") {
						$.each(data.played_game, function(i, v){
							$(".played_game").append("<a class=\"line\" href=\"http://"+v.caption+"."+BASEDNAME+"/play.jsp?server_id="+v.server_id+"\" target=\"_blank\"><span class=\"grey-btn index_user_fright\">进入</span>"+v.game_name+'-'+v.server_name+"</a>");
							//$(".played_game").append("<a href=\"http://"+v.caption+"."+BASEDNAME+"/play.jsp?server_id="+v.server_id+"\">"+v.game_name+v.server_name+"</a>");
						});
					}
					if(typeof(data.played_server)=="object") {
						$.each(data.played_server, function(i, v){
							$(".played_server").append("<a class=\"line\" href=\"http://"+v.caption+"."+BASEDNAME+"/play.jsp?server_id="+v.server_id+"\" target=\"_blank\"><span class=\"grey-btn index_user_fright\">进入</span>"+v.game_name+'-'+v.server_name+"</a>");
							//$(".played_server").append("<a href=\"http://"+v.caption+"."+BASEDNAME+"/play.jsp?server_id="+v.server_id+"\">"+v.game_name+v.server_name+"</a>");
						});
					}
					$(".when_login").show();
					$(".when_notlogin").hide();
					//level经验条计算
					var level = $('.userinfo_level').html();
					var ex = parseInt($('.userinfo_ex').html());
					level_ex = (level*level+4*level)*400;
					if(level > 0){
						level_pre = level - 1;
						level_ex_pre = (level_pre*level_pre+4*level_pre)*400;
						level_ex = level_ex - level_ex_pre;
						ex = ex - level_ex_pre;
					}
					level_width = 90/level_ex * ex;
					if(level == 0){
						$('.userinfo_level').html(1);
						$('.ex').attr("title",0+"/"+(1*1+4*1)*400);
						$('.ex_line_c2').animate({"width":"0px"});

					}else{
						$('.ex').attr("title",ex+"/"+level_ex);
						$('.ex_line_c2').animate({"width":Math.ceil(level_width)+"px"});
					}
					//level经验条计算 end
					//体力计算
					var vit = $('.userinfo_vit').html();
					var vit_up = $('.userinfo_upvit').html();
					var box_width = $('.vit_out').width();
					var vit_box_width = (box_width/vit_up)*vit;
					$('.vit_in').animate({"width":vit_box_width+"px"});
					//体力计算 END
					$.getScript(STATICURL+"/js/vit.js");
					$.getScript(STATICURL+"/js/bottom.js");
				} else {
					$(".when_notlogin").show();
					$(".when_login").hide();
				}
			});
		} else {
			$(".when_notlogin").show();
			$(".when_login").hide();
		}
	}
	$.getJSON("http://my."+BASEDNAME+"/isgeneralize.jsp?u="+getUrlParam(top.location,'u')+"&jsoncallback=?", function(data){});
	$(".jsonp_login").submit(function(){
		if(!isPlaceholder) {
			$(this).find("input[type='text']").not("input[type='password']").each(function(){
				if(typeof($(this).attr('placeholder'))=="string" && $(this).attr('placeholder')==$(this).val()) {
					$(this).val("");
				}
			});
		}
		var data = $(this).serialize();
		var url = $(this).attr("action");
		var form = $(this);
		$("#errorinfo_login").html("请稍等");
		$(".submit_disable").attr("disabled" , "disabled");
		$.getJSON(url+"?callback=?",data,function(json){
			var msg = '';
			if(json) {
				msg = json.message;
				if(json.result) {
					if(msg!="") alert(msg);
					top.location = json.url;
					return;
				}
			}else{
				msg = "服务器忙，请稍候再试！";
			}
			$("#errorinfo_login").html(msg);
			$("#errorinfo_login").addClass('icon_login');
			$("#errorinfo_login").addClass('icon_loginp3');
			$(".submit_disable").removeAttr("disabled");
		});

		if(!isPlaceholder) {
			$(this).find("input[type='text']").not("input[type='password']").each(function(){
				if(typeof($(this).attr('placeholder'))=="string" && ""==$(this).val()) {
					$(this).val($(this).attr('placeholder'));
				}
			});
		}

		return false;
	});

	$(".tmp_disable").removeAttr("disabled");

	$(".common_form").submit(function(){
	});
	if(!+[1,]){
		window.attachEvent('message', function(e){
			if(e.origin !== 'http://my.511wan.com' && e.origin !== 'http://h5.511wan.com') return;
			if(e.data.act == 'close') $(".JsClass_signBox").hide();
		}, false);
	}else{
		window.addEventListener('message', function(e){
			if(e.origin !== 'http://my.511wan.com' && e.origin !== 'http://h5.511wan.com') return;
			if(e.data.act == 'close') $(".JsClass_signBox").hide();
		}, false);
	}

});

function completeiframe_h5(basedname){
	$("body").append('<div class="gray-box JsClass_signBox"></div><div class="JsClass_signBox" style="width: 100%; height: 100%; position: fixed; top: 0;left: 0; z-index: 9999999;"><iframe  id="mid_calendar" src="http://h5.'+basedname+'/my/completeiframe.jsp" width="100%" height="100%" frameborder="0"></iframe></div>');
}
function completeiframe(basedname){
	$("body").append('<div class="gray-box JsClass_signBox"></div><div class="JsClass_signBox" style="width: 100%; height: 100%; position: fixed; top: 0;left: 0; z-index: 9999999;"><span class="JsClass_closeParentBox gray-box-close">x</span><iframe  id="mid_calendar" src="http://my.'+basedname+'/completeiframe.jsp" width="100%" height="100%" frameborder="0"></iframe></div>');
}