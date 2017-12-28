;
(function(window){
	
	function loadHtml(){
		
		var $activity_box = 
			'<div class="m_box" id="activity_box">'+
				'<div class="hd_title"><h2>推荐活动</h2></div>'+
				'<div class="side_news">'+
					'<ul>'+
																	'</ul>'+
				'</div>'+
			'</div>';
		$activity_box = $($activity_box);
		
		$('#activity_box').replaceWith($activity_box);
		
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