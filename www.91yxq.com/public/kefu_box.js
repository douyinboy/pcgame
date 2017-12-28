;
(function(window){
	
	function loadHtml(){
		
		var $kefu_box = 
			'<div class="m_box" id="kefu_box">'+
				'<div class="hd_title"><h2>客服中心</h2></div>'+
				'<div class="in_service">'+
					'<ul>'+
						'<li><a href="http://www.demo.com/help.php?act=getpwd_email" target="_blank"><i class="imgpq s2"></i>找回密码</a></li>'+
					'</ul>'+
					'<div class="text">Q Q: 2355520282<br>邮箱: 2355520282@qq.com</div>'+
				'</div>'+
			'</div>';
		$kefu_box = $($kefu_box);
		
		$('#kefu_box').replaceWith($kefu_box);
		
	}
	
	function loadJQ(){
		
		var jQ = document.createElement('script');
		if( typeof(jQ.onload) != 'undefined' ){
			jQ.onload = loadHtml;
		}
		else if( typeof(jQ.onreadystatechange) != 'undefined' ){
			jQ.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					loadHtml()
				}
			}
		}
		jQ.setAttribute('src','http://image.demo.com/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else{
		loadHtml();
	}
		
})(window);