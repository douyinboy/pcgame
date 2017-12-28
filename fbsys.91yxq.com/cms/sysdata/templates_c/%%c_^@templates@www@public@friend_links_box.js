;
(function(window){
	
	function loadHtml(){	
		var $friend_links_box = 
			'<div class="m_box" id="friend_links_box">'+
				'<div class="hd_title"><h2>友情链接</h2></div>'+
				'<ul class="in_links clearfix">'+
					<?php
 global $PageInfo,$params; 
 $params = array ( 
	'action' => "LIST",
	'return' => "list",
	'nodeid' => "25",
	'orderby' => "c.SortPriority desc",
 ); 
;
$this->_tpl_vars['list'] = CMS_LIST($params); 
    $this->_tpl_vars['PageInfo'] = &$PageInfo;  
?>
					<?php if(!empty($this->_tpl_vars['list'] )): 
   foreach ($this->_tpl_vars['list'] as  $this->_tpl_vars['key']=>$this->_tpl_vars['var']): ?>
					<?php if($this->_tpl_vars['key']>0): ?>
					'<li class="line">|</li>'+
					<?php endif;?>
					'<li><a href="<?php echo $this->_tpl_vars["var"]["FriendLink"];?>" target="_blank"><?php echo $this->_tpl_vars["var"]["Title"];?></a></li>'+
					<?php endforeach; endif;?>
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
		jQ.setAttribute('src','<?php echo $this->_tpl_vars["91yxq_image_url"];?>/js/jquery-1.10.2.min.js');
		document.getElementsByTagName("HEAD")[0].appendChild(jQ);
		
	}
	
	if(typeof(window.jQuery) == 'undefined'){
		loadJQ();
	}
	else{
		loadHtml();
	}
	
})(window);