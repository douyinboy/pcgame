;
(function(window){
	
	function loadHtml(){
		
		var $footer_box = 
			'<div class="foot clearfix" id="footer_box">'+
				'<div class="m1200">'+
					'<div class="fl foot_copy">'+
						'<p><?php echo $this->_tpl_vars["91yxq_corporation"];?>版权所有 ©2014-<?php echo date("Y");?>&nbsp;&nbsp;<?php echo $this->_tpl_vars["91yxq_beian"];?></p>'+
						'<p class="copy">'+
							'<a href="<?php echo $this->_tpl_vars["91yxq_url"];?>/doc/aboutus.html" target="_blank">关于我们</a>'+
							'<span class="line">|</span><a href="<?php echo $this->_tpl_vars["91yxq_url"];?>/doc/contactus.html" target="_blank">联系我们</a>'+
							'<span class="line">|</span><a href="<?php echo $this->_tpl_vars["91yxq_url"];?>/doc/cooperation.html" target="_blank">商务合作</a>'+
							'<span class="line">|</span><a href="<?php echo $this->_tpl_vars["91yxq_url"];?>/fcm/" target="_blank">家长监护</a>'+
						'</p>'+
						'<p>抵制不良游戏，拒绝盗版游戏。注意自我保护，谨防受骗上当。适度游戏益脑，沉迷游戏伤身。合理安排时间，享受健康生活。</p>'+
					'</div>'+
					'<div class="fr foot_prove">'+
						'<a href="http://7xpfbb.com1.z0.glb.clouddn.com/wangwen.pdf" target="_blank" class="prove_ic1"></a>'+
					'</div>'+
				'</div>'+
			'</div>';
		$footer_box = $($footer_box);
		
		$('#footer_box').replaceWith($footer_box);
		
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