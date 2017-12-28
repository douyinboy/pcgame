//客服中心 提交问题检测
function help_question(){
	if($.trim(gID('uname').value).length<=0){
		alert('请填写玩家帐号!');
		gID('username').focus();
		return false;
   }
   if($.trim(gID('rolename').value).length<=0){
		alert('请填写角色名称!');
		gID('rolename').focus();
		return false;
   }
   if(gID('game_id').value=="0"){
		alert('请选择游戏!');
		return false;
   }
	if(gID('server_id').value=="0"){
		alert('请选择服务器!');
		return false;
   }
	if($.trim(gID('title').value).length<=0){
		alert('请填写问题标题!');
		gID('title').focus();
		return false;
   }
	if($.trim(gID('content').value).length<=0){
		alert('请填写问题内容!');
		gID('content').focus();
		return false;
   }
   gID('help_q').submit();
}

function getGamSvrLst(gid){
	if(gid<=0){return false;}
	var url='http://www.demo.com/help.php?act=question';
	var paras='&gslt=getSvrLst&gid='+gid;
	$.ajax({
		type:"POST",
		url:url,
		data:paras,   
        success: function(result){  
			if(result){
				$('#server_id').html('<select name="data[server_id]" id="server_id">'+result+'</select>');
			}else{
				return false;
			}
        },
        error:function(){
            alert('网络故障,获取游戏列表失败!');
            return false;
        }
    });
}