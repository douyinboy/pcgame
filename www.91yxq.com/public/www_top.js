;
document.domain = 'demo.com';
(function(window){
	
	function loadHtml(){
		var $TopHtml = $(
			//'<!--游戏中心下拉列表-->'+
			'<div class="min_game_down">'+
				'<a href="javascript:void(0);" class="menu_hd">游戏中心<i class="arrow"></i></a>'+
				'<div class="min_game_list" style="display:none">'+
					'<ul>'+
																		'<li>'+
							'<a href="http://www.demo.com/hys/index.html" target="_blank">'+
								'<span class="name">魔神变</span>'+
								'<i class="imgpq min_ic_new"></i>'+
							'</a>'+
						'</li>'+
												'<li>'+
							'<a href="http://www.demo.com/hys/index.html" target="_blank">'+
								'<span class="name">火焰神</span>'+
								'<i class="imgpq min_ic_new"></i>'+
							'</a>'+
						'</li>'+
											'</ul>'+
				'</div>'+
			'</div>'+
			
			//'<!--未登录-登录注册-->'+
			'<div id="top_login_div" class="fr login">'+
				'<a href="javascript:void(0);" id="open_popup_login">登录</a>'+
				'<a href="http://www.demo.com/turn.php?act=reg" class="reg_btn" target="_blank">注册</a>'+
			'</div>'+
			//'<!--登录后用户信息-->'+
			'<div id="top_username_div" class="fr min_user_info" style="display:none;">'+
				'<a >欢迎您，</a>'+
				'<a id="top_username" href="http://www.demo.com/user.php"><<用户名>></a>'+
				'<a href="http://www.demo.com/turn.php?act=logout" class="back">【注销】</a>'+
			'</div>'
		);
		$('#platform_top_div').append($TopHtml);
		
		//点击弹出登录框(http://www.demo.com/public/popup_login.js文件中已经绑定事件)
		$TopHtml.find('#open_popup_login').bind('click', window.popup_login.open );
		

		//顶部全部游戏hover下拉列表效果
		var up_timer = null;
		var down_timer = null;
		$TopHtml.filter('.min_game_down').hover(
			function(){
				if( down_timer != null ){
					clearTimeout( down_timer );
					down_timer = null;
				}
				if( up_timer != null ){
					clearTimeout( up_timer );
					up_timer = null;
				}
				$this = $(this);
				$this.children(".menu_hd").removeClass("menu_hd_on");
				$this.children(".min_game_list").stop(true,true);
				down_timer = setTimeout(function(){
					$this.children(".menu_hd").addClass("menu_hd_on");
					$this.children(".min_game_list").fadeIn(200);
				},100);
			},
			function(){
				if( down_timer != null ){
					clearTimeout( down_timer );
					down_timer = null;
				}
				if( up_timer != null ){
					clearTimeout( up_timer );
					up_timer = null;
				}
				$this = $(this);
				//$this.children(".menu_hd").addClass("menu_hd_on");
				$this.children(".min_game_list").stop(true,true);
				up_timer = setTimeout(function(){
					$this.children(".menu_hd").removeClass("menu_hd_on");
					$this.children(".min_game_list").fadeOut(200);
				},100);
			}
		);
		
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
		
		//顶部检测登录状态
		window.popup_login.top_check_login = function(){
		
			
			//公共头部 显示登录按钮时 检测登录状态
			var url="http://www.demo.com/api/login_user_status2.php";
			$.ajax({
				type:"get",
				url:url,
				data:{state:1},
				//dataType : 'json',
				dataType:'jsonp',
				jsonp:'callback',				//默认值'callback',服务端用于接收回调函数名的get下标值
				jsonpCallback:'jsonp_get_login_status',	//提交到服务端的回调函数名,不设置默认由jquery随机生成
				success: function(data)
				{
					switch(data.code){
					case 1:
						$TopHtml.find('#top_username').html(data.msg);
						$TopHtml.filter("#top_username_div").show();
						$TopHtml.filter("#top_login_div").hide();
						break;
					default:
						$TopHtml.find('#top_username').html('');
						$TopHtml.filter("#top_username_div").hide();
						$TopHtml.filter("#top_login_div").show();
						break;
					}
				},
				error:function()
				{
					return false;
				}
			});
		}
		
		//顶部检测登录状态
		jQuery(function (){
		
			window.popup_login.top_check_login();
			
		});
		
		
		
	}
	
	function loadLO(){
		
		var lo = document.createElement('script');
		if( typeof(lo.onload) != 'undefined' ){
			lo.onload = loadHtml;
		}
		else if( typeof(lo.onreadystatechange) != 'undefined' ){
			lo.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					loadHtml()
				}
			}
		}
		lo.setAttribute('src','http://www.demo.com/public/popup_login.js');
		document.getElementsByTagName("HEAD")[0].appendChild(lo);
		
	}
	
	function loadJQ(){
		
		var jQ = document.createElement('script');
		if( typeof(jQ.onload) != 'undefined' ){
			jQ.onload = loadLO;
		}
		else if( typeof(jQ.onreadystatechange) != 'undefined' ){
			jQ.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					loadLO()
				}
			}
		}
		jQ.setAttribute('src','http://image.demo.com/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else if(typeof(window.popup_login) == 'undefined'){
		loadLO();
	}
	else{
		loadHtml();
	}
		

})(window);
;