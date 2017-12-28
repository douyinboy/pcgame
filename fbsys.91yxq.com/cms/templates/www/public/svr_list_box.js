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
				<CMS action="SQL" return="List" query="select c1.GameId,c1.ServerId,c1.ServerName,c1.OpenDate,c1.OpenTime,c2.GameName,c2.ShortName,c1.ServerStatus from 91yxq_content_6 c1,91yxq_content_5 c2,91yxq_content_index c3  where c2.GameId=c1.GameId and c3.ContentID = c1.ContentID and c1.ServerShow in(2,3) and c1.PlatformId=1 and c1.ServerStatus in(3,4) and c2.PlatformId=1 and c3.TableID=6 and c3.State>0 order by c1.OpenDate DESC,c1.OpenTime DESC limit 20" />
				'<div class="svr_list_ctn" id="svr_list_ykxf">'+
					'<div class="in_zone_list">'+
						'<dl>'+
							'<dt>'+
							   ' <span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
							<LOOP name="List" var="var" key="key">
							<if test="$key<10">
							'<dd>'+
								'<a href="[$91yxq_url]/turn.php?act=gamelogin&game_id=[$var.GameId]&server_id=[$var.ServerId]" target="_blank">'+
									'<span class="date">[@utf8_CsubStr($var.OpenDate,5,10, "")]</span>'+
									'<span class="time">[$var.OpenTime]</span>'+
									'<span class="name">[$var.GameName]</span>'+
									'<span class="zone">[$var.ServerId]服</span>'+
								'</a>'+
							'</dd>'+
							</if>
							</loop>
							
						'</dl>'+
					'</div>'+
					
					<if test="count($List)>=10">
					'<div class="in_zone_list" style="display:none;">'+
						'<dl>'+
							'<dt>'+
								'<span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
							<LOOP name="List" var="var" key="key">
							<if test="$key>=10">
							'<dd>'+
								'<a href="[$91yxq_url]/turn.php?act=gamelogin&game_id=[$var.GameId]&server_id=[$var.ServerId]" target="_blank">'+
									'<span class="date">[@utf8_CsubStr($var.OpenDate,5,10, "")]</span>'+
									'<span class="time">[$var.OpenTime]</span>'+
									'<span class="name">[$var.GameName]</span>'+
									'<span class="zone">[$var.ServerId]服</span>'+
								'</a>'+
							'</dd>'+
							</if>
							</loop>
							
						'</dl>'+
					'</div>'+
		
					'<!--翻页-->'+
					'<div class="zone_page">'+
						'<a href="javascript:void(0);" class="imgpq up"></a> '+
						'<a href="javascript:void(0);" class="num on"></a> '+
						'<a href="javascript:void(0);" class="num"></a> '+
						'<a href="javascript:void(0);" class="imgpq dow"></a> '+
					'</div>'+
					</if>
					
				'</div>'+
				<CMS action="SQL" return="List" query="select c1.GameId,c1.ServerId,c1.ServerName,c1.OpenDate,c1.OpenTime,c2.GameName,c2.ShortName,c1.ServerStatus from 91yxq_content_6 c1,91yxq_content_5 c2,91yxq_content_index c3  where c2.GameId=c1.GameId and c3.ContentID = c1.ContentID and c1.ServerShow in(2,3) and c1.PlatformId=1 and c1.ServerStatus=2 and c2.PlatformId=1 and c3.TableID=6 and c3.State>0 order by c1.OpenDate DESC,c1.OpenTime DESC limit 20" />
				'<div class="svr_list_ctn" id="svr_list_xfyg" style="display:none">'+
					'<div class="in_zone_list">'+
						'<dl>'+
							'<dt>'+
								'<span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
							<LOOP name="List" var="var" key="key">
							<if test="$key<10">
							'<dd>'+
								'<a href="[$91yxq_url]/turn.php?act=gamelogin&game_id=[$var.GameId]&server_id=[$var.ServerId]" target="_blank">'+
									'<span class="date">[@utf8_CsubStr($var.OpenDate,5,10, "")]</span>'+
									'<span class="time">[$var.OpenTime]</span>'+
									'<span class="name">[$var.GameName]</span>'+
									'<span class="zone">[$var.ServerId]服</span>'+
								'</a>'+
							'</dd>'+
							</if>
							</loop>
							
						'</dl>'+
					'</div>'+
					
					<if test="count($List)>=10">
					'<div class="in_zone_list" style="display:none;">'+
						'<dl>'+
							'<dt>'+
								'<span class="date">日期</span>'+
								'<span class="time">时间</span>'+
								'<span class="name">游戏名称</span>'+
								'<span class="zone">服数</span>'+
							'</dt>'+
							<LOOP name="List" var="var" key="key">
							<if test="$key>=10">
							'<dd>'+
								'<a href="[$91yxq_url]/turn.php?act=gamelogin&game_id=[$var.GameId]&server_id=[$var.ServerId]" target="_blank">'+
									'<span class="date">[@utf8_CsubStr($var.OpenDate,5,10, "")]</span>'+
									'<span class="time">[$var.OpenTime]</span>'+
									'<span class="name">[$var.GameName]</span>'+
									'<span class="zone">[$var.ServerId]服</span>'+
								'</a>'+
							'</dd>'+
							</if>
							</loop>
							
						'</dl>'+
					'</div>'+
					'<!--翻页-->'+
					'<div class="zone_page">'+
						'<a href="javascript:void(0);" class="imgpq up"></a> '+
						'<a href="javascript:void(0);" class="num on"></a> '+
						'<a href="javascript:void(0);" class="num"></a> '+
						'<a href="javascript:void(0);" class="imgpq dow"></a> '+
					'</div>'+
					</if>
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
		fo.setAttribute('src','[$91yxq_image_url]/js/jq.foshow.js');
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
		jQ.setAttribute('src','[$91yxq_image_url]/js/jquery-1.10.2.min.js');
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