(function($){
	$.fn.foShow = function(args) {
		args = $.extend({
			mains:null,
			navs:null,
			prev:null,
			next:null,
			duration:500,
			interval:null,
			curClass:"on",
			hovering:false
		},
		args);
		this.each(function(){
			var index = 0;
			var total = args.mains.length;
			args.mains.removeClass(args.curClass).hide().eq(index).show();
			if(args.navs)
			args.navs.removeClass(args.curClass).eq(index).addClass(args.curClass);
			var animate = function(index){
				args.mains.removeClass(args.curClass).stop(true,true).hide().eq(index).fadeIn(args.duration);
				args.navs.removeClass(args.curClass).eq(index).addClass(args.curClass);
			}
			if(args.interval && args.interval > 0){
				var loopTimer = null;
				var delLoopTimer = function(){
					if( loopTimer )
					clearInterval(loopTimer);
					loopTimer = null;
				}
				var addLoopTimer = function(){
					delLoopTimer();
					loopTimer = setInterval(function(){
						index++;
						if(index == total)
						index = 0;
						animate(index);
					},args.interval);
				}
				if( args.hovering ){
					$(this).hover(
						function(){
							delLoopTimer();
						},
						function(){
							addLoopTimer();
						}
					);
				}
				addLoopTimer();
			}
			if(args.navs){
				args.navs.hover(
					function(){
						index = args.navs.index(this);
						animate(index);
					},
					function(){}
				);
			}
			if(args.prev){
				args.prev.click(function(){
						index--;
						if( index<0 )
						index = total+index;
						animate(index);
				});
			}
			if(args.next){
				args.next.click(function(){
						index++;
						if( index==total )
						index = 0;
						animate(index);
				});
			}
			
		})
	}
	
})(jQuery);
	