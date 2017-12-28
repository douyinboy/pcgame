;
document.domain = 'demo.com';
(function(window){
	
	function definePopupLogin(){
		
		if(typeof(window.popup_login) == 'undefined')
		window.popup_login = 
		(function(){
			var popup_login = {};

			//登录框背景html
			var loginBg = '<div class="popup_bg" style="display:block;height:100%;width:100%;position:fixed;top:0;left:0;z-index:9998;"></div>';
			popup_login.loginBg = $(loginBg);
			
			//登录框html
			var loginBox = 
				//'<!--用户登录-->'+
				'<div id="popup_box" class="popup_box login_box" style="display:block;top:50%;left:50;z-index:9999;height:308px;margin:-154px 0 0 -225px;width:450px;">'+
					'<a href="javascript:void(0);" class="popup_close" ></a>'+
					'<iframe frameborder="0" scrolling="no" src="[$91yxq_url]/public/popup_login.html" allowtransparency="true" style="height:308px; width:450px;"></iframe>'+
				'</div>';
			popup_login.loginBox = $(loginBox);
			
			popup_login.close = function(){
				popup_login.loginBg.remove();
				popup_login.loginBox.remove();
				return false;
			}
			popup_login.open = function(){
				popup_login.close();
				$('body').append(popup_login.loginBg).append(popup_login.loginBox);
				popup_login.loginBox.find(".popup_close").click(popup_login.close);
				return false;
			}
			
			return popup_login;
		})();
	
	}
	
	function loadJQ(){
		
		var jQ = document.createElement('script');
		if( typeof(jQ.onload) != 'undefined' ){
			jQ.onload = definePopupLogin;
		}
		else if( typeof(jQ.onreadystatechange) != 'undefined' ){
			jQ.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					definePopupLogin()
				}
			}
		}
		jQ.setAttribute('src','[$91yxq_image_url]/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else{
		definePopupLogin();
	}
	
})(window);