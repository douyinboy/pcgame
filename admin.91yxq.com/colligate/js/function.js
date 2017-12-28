
function search_pro(){
	var tips='输入关键字';
	$('#pro_keyword').val(tips);
	$('#pro_keyword').css('color', '#666');
	$('#pro_keyword').focus(function(){
		if($(this).val() != tips) return;
		$(this).val('');
		$(this).css('color', '#000');
	}).blur(function(){
		if($(this).val() == ''){
			$('#pro_keyword').val(tips);
			$('#pro_keyword').css('color', '#666');
		}
	});
	
	//keyup
	$('#pro_keyword').keyup(function(e){
		if($('#pro_keyword').val() == '' || $('#pro_keyword').val() == tips){
			$('#pro_keyword').focus();
			getAllPro();
			return;
		}
		getPro($('#pro_keyword').val());
	});
}
function getPro(keyw){
	var phtml='';
	for(i in pro_str){
		if(pro_str[i].indexOf(keyw) != -1){
			phtml += '<option value="'+i+'">'+pro_str[i]+'</option>';
		}
	}
	for(i in pro_str_byname){
		if(pro_str_byname[i].indexOf(keyw) != -1){
			phtml += '<option value="'+i+'">'+pro_str[i]+'</option>';
		}
	}
	$('#game_id').html(phtml);
}
function getAllPro(){
	var phtml='';
	for(i in pro_str){
		phtml += '<option value="'+i+'">'+pro_str[i]+'</option>';
	}
	$('#game_id').html(phtml);
}