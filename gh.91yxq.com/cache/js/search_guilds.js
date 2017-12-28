
function search_pro(searchkey, setkey){
	var tips='输入关键字';
	$('#'+searchkey).val(tips);
	$('#'+searchkey).css('color', '#666');
	$('#'+searchkey).focus(function(){
		if($(this).val() != tips) return;
		$(this).val('');
		$(this).css('color', '#000');
	}).blur(function(){
		if($(this).val() == ''){
			$('#'+searchkey).val(tips);
			$('#'+searchkey).css('color', '#666');
		}
	});
	
	//keyup
	$('#'+searchkey).keyup(function(e){
		if($('#'+searchkey).val() == '' || $('#'+searchkey).val() == tips){
			$('#'+searchkey).focus();
			getAllPro(setkey);
			return;
		}
		getPro($('#'+searchkey).val(), setkey);
	});
}
function getPro(keyw, setkey){
	var phtml='<option value="0">请选择</option>';
	for(i in pro_str){
		if(pro_str[i].indexOf(keyw) != -1){
			phtml += '<option value="'+i+'">'+pro_str[i]+'</option>';
		}
	}
	$('#'+setkey).html(phtml);
        var $ref=$("#"+setkey);
        var $refCombox=$ref.parents("div.combox:first");
        $ref.html(phtml).insertAfter($refCombox);
        $refCombox.remove();
        $ref.trigger("change").combox();
}
function getAllPro(setkey){
	var phtml='';
	for(i in pro_str){
		phtml += '<option value="'+i+'">'+pro_str[i]+'</option>';
	}
	$('#'+setkey).html(phtml);
}