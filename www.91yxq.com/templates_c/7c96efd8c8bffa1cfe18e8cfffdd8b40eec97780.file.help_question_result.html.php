<?php /* Smarty version Smarty-3.0.6, created on 2016-12-28 16:34:38
         compiled from "/home/91yxq/www.demo.com/template/help_question_result.html" */ ?>
<?php /*%%SmartyHeaderCode:9306886335863791e08b065-44325094%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c96efd8c8bffa1cfe18e8cfffdd8b40eec97780' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/help_question_result.html',
      1 => 1482896440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9306886335863791e08b065-44325094',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/91yxq/www.demo.com/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_function_math')) include '/home/91yxq/www.demo.com/smarty/plugins/function.math.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->getVariable('chinese_title')->value;?>
-用户中心-问题反馈及查询</title>
	<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/base.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/public.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/main_pq.css" />
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
/jquery-1.11.1.min.js"></script>
	<script src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
/help.js" type="text/javascript"></script>

	
	<script>
		function getDetail(url){
			
			$.ajax({
				url:url,
				async:false,
				type:'post',
				dataType:'json',
				success:function(data){
					if( data.status == -1 ){
						alert(data.info);
						window.location.href = data.location;
					}
					else if( data.status == 0 ){
						alert(data.info);
					}else{
						var html = 
							'<li>'+
								'<div class="title"><h3>'+data.qre.title+'</h3><span class="mark_'+(data.qre.state==3?'yes':'no')+'">'+data.qre.qstate+'</span><span class="time fr">时间:'+data.qre.qtime+'</span></div>'+
								'<div class="text">'+data.qre.content+'</div>'+
							'</li>';
						var i;
						for( var i in data.are){
							if( data.are[i].rstype ==0 ){
								html +=
									'<li class="reply">'+
										'<div class="title"><h3>客服回复</h3><span class="time fr">时间:'+data.are[i].qtime+'</span></div>'+
										'<div class="text">'+data.are[i].content+'</div>'+
									'</li>';
							}else{
								html +=
									'<li >'+
										'<div class="title"><h3>追加问题</h3><span class="mark_'+(data.are[i].state==3?'yes':'no')+'">'+data.are[i].qstate+'</span><span class="time fr">时间:'+data.are[i].qtime+'</span></div>'+
										'<div class="text">'+data.are[i].content+'</div>'+
									'</li>';
							}
						}
						var box = $('#qre_detail_box').show().children('.issue_list');
						var ul = box.children('ul');
						ul.html(html);
						$('#qre_detail_bg').show();
						$('#qid').val(data.qid);
						$('#qtitle').val(data.qre.title);
						//alert(ul.height() + ' ' + box.height() + ' ' + box.scrollTop() +' '+ box.css('padding-top'))
						box.scrollTop(ul.height() - box.height() - parseInt( box.css('padding-top') ))
						//alert(ul.height() + ' ' + box.height() + ' ' + box.scrollTop() )
						//alert(data.info);
					}
				},
				error:function(){
					alert('请求超时');
				}
			});
			return false;
		}
		
		function closePopup(){
			$('#qre_detail_box').hide();
			$('#qre_detail_bg').hide();
		}
		
		function reAsk(){
			$.ajax({
				url:'help.php?act=question_result',
				async:false,
				type:'post',
				dataType:'json',
				data:{qid:$('#qid').val(),stage:'yes',content:$('#qcontent').val(),title:$('#qtitle').val()},
				success:function(data){
					if( data.status == -1 ){
						alert(data.info);
						window.location.href = data.location;
					}
					else if( data.status == 0 ){
						alert(data.info);
					}else{
						var html = 
							'<li>'+
								'<div class="title"><h3>'+data.qre.title+'</h3><span class="mark_'+(data.qre.state==3?'yes':'no')+'">'+data.qre.qstate+'</span><span class="time fr">时间:'+data.qre.qtime+'</span></div>'+
								'<div class="text">'+data.qre.content+'</div>'+
							'</li>';
						var i;
						for( var i in data.are){
							if( data.are[i].rstype ==0 ){
								html +=
									'<li class="reply">'+
										'<div class="title"><h3>客服回复</h3><span class="time fr">时间:'+data.are[i].qtime+'</span></div>'+
										'<div class="text">'+data.are[i].content+'</div>'+
									'</li>';
							}else{
								html +=
									'<li >'+
										'<div class="title"><h3>追加问题</h3><span class="mark_'+(data.are[i].state==3?'yes':'no')+'">'+data.are[i].qstate+'</span><span class="time fr">时间:'+data.are[i].qtime+'</span></div>'+
										'<div class="text">'+data.are[i].content+'</div>'+
									'</li>';
							}
						}
						var box = $('#qre_detail_box').show().children('.issue_list');
						var ul = box.children('ul');
						ul.html(html);
						$('#qre_detail_bg').show();
						$('#qid').val(data.qid);
						$('#qtitle').val(data.qre.title);
						//alert(ul.height() + ' ' + box.height() + ' ' + box.scrollTop() +' '+ box.css('padding-top'))
						box.scrollTop(ul.height() - box.height() - parseInt( box.css('padding-top') ))
						//alert(ul.height() + ' ' + box.height() + ' ' + box.scrollTop() )
						//alert(data.info);
						$('#qcontent').val('');
					}
				},
				error:function(){
					alert('请求超时');
				}
			});
			return false;
		}
	</script>
</head>

<body>

<!--反馈详情 弹出层-->
<div class="popup_box issue_box" id="qre_detail_box" style="display:none;" >
	<a href="javascript:void(0);" class="popup_close" onclick="closePopup();return false;"></a>
	<div class="hd_title"><h2>反馈详情</h2></div>
    <div class="issue_list">
        <ul>
            <li>
                <div class="title"><h3>反馈标题测试测试测试测试测试</h3><span class="mark_yes">已解答</span><span class="time fr">时间:2015-05-19</span></div>
                <div class="text">详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试</div>
            </li>
            <li class="reply">
                <div class="title"><h3>客服回复</h3><span class="time fr">时间:2015-05-19</span></div>
                <div class="text">详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试</div>
            </li>
            <li>
                <div class="title"><h3>追加问题</h3><span class="mark_no">未解答</span><span class="time fr">时间:2015-05-19</span></div>
                <div class="text">详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试详细内容测试</div>
            </li>
        </ul>
    </div>
    <ul class="issue_fill">
		<input type="hidden" name="qid" id="qid" />
		<input type="hidden" name="qtitle" id="qtitle" />
        <li><span class="f14">追加问题</span></li>
        <li><textarea name="qcontent" id="qcontent" cols="85" rows="4" class="input_t"></textarea></li>
        <li><a href="javascript:void(0)" class="game_btn1" onclick="reAsk();return false;">确 认</a></li>
    </ul>
</div>
<div class="popup_bg"  id="qre_detail_bg" style="display:none;"></div>
<!--弹出遮罩层-->


<!--导入公共头部文件-->
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 mt40 clearfix">
		
		<!--左侧导航-->
        <?php $_template = new Smarty_Internal_Template('user_link.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

		<!--右块-->
		<div class="fr w980">
			<div class="p50">
				<div class="user_hd">
                    <h2>问题反馈及查询</h2>
                    <div id="myTab1" class="fl user_menu">
                        <a class="li_o" href="./help.php?act=question">问题反馈</a>
                        <a class="li_a" >我的反馈</a>
                    </div>
                </div>
				
				
				<?php if (0&&$_smarty_tpl->getVariable('flage')->value==0){?>  
					<?php if ($_smarty_tpl->getVariable('qlist')->value){?>       
						<div class="wclwt">
						<div class="wclwt1"><p class="wclwt1a">编号</p><p class="wclwt1b">我提出的问题</p><p class="wclwt1c">处理状态</p><p class="wclwt1d">提交时间</p><p class="clear"></p></div>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('qlist')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
						<div class="wclwt2"><p class="wclwt1a"><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['xid'];?>
</p><p class="wclwt1b"><a style="text-decoration:underline;" href="/help.php?act=question_result&qid=<?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'],10,"……");?>
</a></p><p class="wclwt1c"><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['result'];?>
</p><p class="wclwt1d"><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['qtime'];?>
</p><p class="clear"></p></div>
						<?php endfor; endif; ?>
						<div class="clear"></div>
						<ul>
						<li class="new_list_3">
						<p class="list_3_iput">
						<select name="" size="1" class="list_3_iput_1">
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('pagecount')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>
						<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['iteration'];?>
" <?php if ($_smarty_tpl->getVariable('page')->value==$_smarty_tpl->getVariable('smarty')->value['section']['loop']['iteration']){?>selected<?php }?>>第<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['iteration'];?>
页</option>
						<?php endfor; endif; ?>
						</select></p>
						<?php if ($_smarty_tpl->getVariable('page')->value<$_smarty_tpl->getVariable('pagecount')->value){?><a href="/help.php?act=question_result&page=<?php echo smarty_function_math(array('equation'=>"x+y",'x'=>$_smarty_tpl->getVariable('page')->value,'y'=>1),$_smarty_tpl);?>
">下一页</a><?php }?>
						<?php if ($_smarty_tpl->getVariable('page')->value>1){?><a href="/help.php?act=question_result&page=<?php echo smarty_function_math(array('equation'=>"x-y",'x'=>$_smarty_tpl->getVariable('page')->value,'y'=>1),$_smarty_tpl);?>
">上一页</a><?php }?>
						<a href="/help.php?act=question_result&page=<?php echo $_smarty_tpl->getVariable('pagecount')->value;?>
">尾页</a>
						<a href="/help.php?act=question_result">首页</a>
						<span><?php echo $_smarty_tpl->getVariable('page')->value;?>
/<?php echo $_smarty_tpl->getVariable('pagecount')->value;?>
</span><span>共<?php echo $_smarty_tpl->getVariable('total')->value;?>
条记录</span>
						<div class="clear"></div>
						</li>
						</ul>
						</div>
					<?php }else{ ?>
						<div class="zlts2">您还没有需要处理的问题，<a href="/help.php?act=question">马上提交问题！</a></div>
					<?php }?>
				<?php }?>
				

				
		<?php if ($_smarty_tpl->getVariable('flage')->value==0){?>  
			<?php if ($_smarty_tpl->getVariable('qlist')->value){?> 
				<div >
					<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab1">
						<tr>
							<th width="80">编号</th>
							<th>标题</th>
							<th>问题类型</th>
							<th>处理状态</th>
							<th>日期</th>
							<th width="110">操作</th>
						</tr>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('qlist')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
						<tr>
							<td><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['xid'];?>
</td>
							<td>
								<a style="text-decoration:underline;" href="javascript:;" onclick="getDetail('./help.php?act=question_result&qid=<?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
');return false;"><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'],10,"……");?>
</a>
							</td>
							<td><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['qtype'];?>
</td>
							<td>
								<span class="<?php if ($_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['state']==1){?>red<?php }elseif($_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['state']==2){?>blue<?php }elseif($_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['state']==3){?>green<?php }?>">
									<?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['qstate'];?>

								</span>
							</td>
							<td><?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['qtime'];?>
</td>
							<td><a href="javascript:;" class="btn1 popup_pq" onclick="getDetail('./help.php?act=question_result&qid=<?php echo $_smarty_tpl->getVariable('qlist')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
');return false;">查看详情</a></td>
						</tr>
						<?php endfor; endif; ?>
						
					</table>
					
					<!--翻页-->
					<div class="page pt20">
						<a href="<?php echo $_smarty_tpl->getVariable('prevPage')->value['pageUrl'];?>
" class="updow">&lt;</a>
						<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pagingList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value){
?>
							<?php if ($_smarty_tpl->tpl_vars['page']->value['pageNo']=='...'){?>
								<span>...</span>
							<?php }elseif($_smarty_tpl->tpl_vars['page']->value['current']==1){?>
								<span class="on"><?php echo $_smarty_tpl->tpl_vars['page']->value['pageNo'];?>
</span>
							<?php }else{ ?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['page']->value['pageUrl'];?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['pageNo'];?>
</a>
							<?php }?>
						<?php }} ?>
						<a href="<?php echo $_smarty_tpl->getVariable('nextPage')->value['pageUrl'];?>
" class="updow">&gt;</a>
					</div>
					
				</div>
				
			<?php }else{ ?>
				<div style="padding:20px;font-size:14px;">您还没有需要处理的问题，<a href="./help.php?act=question">马上提交问题！</a></div>
			<?php }?>
		<?php }?>
		
			</div>
		</div>
	</div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</body>
</html>