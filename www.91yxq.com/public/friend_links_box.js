;
(function(window){
	
	function loadHtml(){	
		var $friend_links_box = 
			'<div class="m_box" id="friend_links_box">'+
				'<div class="hd_title"><h2>友情链接</h2></div>'+
				'<ul class="in_links clearfix">'+
																				'<li><a href="http://www.37.com" target="_blank">37wan</a></li>'+
															'<li class="line">|</li>'+
										'<li><a href="http://www.91wan.com" target="_blank">91wan</a></li>'+
															'<li class="line">|</li>'+
										'<li><a href="http://www.51wan.com" target="_blank">51wan</a></li>'+
															'<li class="line">|</li>'+
										'<li><a href="http://www.9377.com" target="_blank">9377</a></li>'+
															'<li class="line">|</li>'+
										'<li><a href="http://www.tanwan.com" target="_blank">贪玩</a></li>'+
									'</ul>'+
			'</div>';
		$friend_links_box = $($friend_links_box);
		
		$('#friend_links_box').replaceWith($friend_links_box);
		
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