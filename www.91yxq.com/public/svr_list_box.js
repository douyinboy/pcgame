;
(function(window){
	
	function loadHtml(){
		var $svr_list_box = 	
			'<div class="m_box" id="svr_list_box">'+
				'<div class="hd_title"><h2>开服列表</h2></div>'+
				'<!--切换-->'+
				'<div class="zone_tab">'+
					'<div class="svr_list_tit li_o li_a" >已开新服</div>'+
					'<div class="svr_list_tit li_o" >新服预告</div>'+
					'<!--<div class="svr_list_tit li_o" >新服推荐</div>-->'+
				'</div>'+
								'<div class="svr_list_ctn" id="svr_list_ykxf">'+
					'<div class="in_zone_list">'+
						'<dl>'+
							'<dt>'+
							   ' <span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
																					'<dd>'+
								'<a href="http://www.demo.com/turn.php?act=gamelogin&game_id=1&server_id=2" target="_blank">'+
									'<span class="date">03-24</span>'+
									'<span class="time">14:00</span>'+
									'<span class="name">火焰神</span>'+
									'<span class="zone">2服</span>'+
								'</a>'+
							'</dd>'+
																												'<dd>'+
								'<a href="http://www.demo.com/turn.php?act=gamelogin&game_id=1&server_id=1" target="_blank">'+
									'<span class="date">03-23</span>'+
									'<span class="time">14:00</span>'+
									'<span class="name">火焰神</span>'+
									'<span class="zone">1服</span>'+
								'</a>'+
							'</dd>'+
																					
						'</dl>'+
					'</div>'+
					
										
				'</div>'+
								'<div class="svr_list_ctn" id="svr_list_xfyg" style="display:none">'+
					'<div class="in_zone_list">'+
						'<dl>'+
							'<dt>'+
								'<span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
														
						'</dl>'+
					'</div>'+
					
									'</div>'+
				
			'</div>'+
			'';
		
		$svr_list_box = $($svr_list_box);
		
		$('#svr_list_box').replaceWith($svr_list_box);
		
		$svr_list_box.foShow({
			mains:$svr_list_box.find('.svr_list_ctn'),
			navs:$svr_list_box.find('.svr_list_tit'),
			duration:300,
			interval:0,
			curClass:"li_a",
			hovering:true
		});
		
		$svr_list_box.find('#svr_list_ykxf').foShow({
			mains:$svr_list_box.find('#svr_list_ykxf .in_zone_list'),
			navs:$svr_list_box.find('#svr_list_ykxf .zone_page a.num'),
			prev:$svr_list_box.find('#svr_list_ykxf .zone_page a.up'),
			next:$svr_list_box.find('#svr_list_ykxf .zone_page a.dow'),
			duration:300,
			interval:0,
			curClass:"on",
			hovering:true
		});
		
		$svr_list_box.find('#svr_list_xfyg').foShow({
			mains:$svr_list_box.find('#svr_list_xfyg .in_zone_list'),
			navs:$svr_list_box.find('#svr_list_xfyg .zone_page a.num'),
			prev:$svr_list_box.find('#svr_list_xfyg .zone_page a.up'),
			next:$svr_list_box.find('#svr_list_xfyg .zone_page a.dow'),
			duration:300,
			interval:0,
			curClass:"on",
			hovering:true
		});
		
	}
	
	function loadFO(){
		
		var fo = document.createElement('script');
		if( typeof(fo.onload) != 'undefined' ){
			fo.onload = loadHtml;
		}
		else if( typeof(fo.onreadystatechange) != 'undefined' ){
			fo.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					loadHtml()
				}
			}
		}
		fo.setAttribute('src','http://image.demo.com/js/jq.foshow.js');
		document.getElementsByTagName("HEAD")[0].appendChild(fo);
		
	}
	
	function loadJQ(){
		
		var jQ = document.createElement('script');
		if( typeof(jQ.onload) != 'undefined' ){
			jQ.onload = loadFO;
		}
		else if( typeof(jQ.onreadystatechange) != 'undefined' ){
			jQ.onreadystatechange = function(){
				if( !this.readyState || this.readyState == 'loaded' || this.readyState == 'complete' ){
					loadFO()
				}
			}
		}
		jQ.setAttribute('src','http://image.demo.com/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else if(typeof(window.jQuery.fn.foShow) == 'undefined'){
		loadFO();
	}
	else{
		loadHtml();
	}
	
})(window);		