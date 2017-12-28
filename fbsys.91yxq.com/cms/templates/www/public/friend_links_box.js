;
(function(window){
	
	function loadHtml(){	
		var $friend_links_box = 
			'<div class="m_box" id="friend_links_box">'+
				'<div class="hd_title"><h2>友情链接</h2></div>'+
				'<ul class="in_links clearfix">'+
					<cms action="LIST" return="list" NodeID="25" OrderBy="c.SortPriority desc" />
					<loop name="list" var="var" key="key" >
					<if test="$key>0">
					'<li class="line">|</li>'+
					</if>
					'<li><a href="[$var.FriendLink]" target="_blank">[$var.Title]</a></li>'+
					</loop>
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
		jQ.setAttribute('src','[$91yxq_image_url]/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else{
		loadHtml();
	}
	
})(window);