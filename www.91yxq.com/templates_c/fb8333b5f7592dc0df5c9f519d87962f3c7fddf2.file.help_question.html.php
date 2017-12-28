<?php /* Smarty version Smarty-3.0.6, created on 2017-09-12 15:19:51
         compiled from "E:\phpStudy\WWW\91yxq\www.91yxq.com\template/help_question.html" */ ?>
<?php /*%%SmartyHeaderCode:63559b78a9759ce35-92081110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb8333b5f7592dc0df5c9f519d87962f3c7fddf2' => 
    array (
      0 => 'E:\\phpStudy\\WWW\\91yxq\\www.91yxq.com\\template/help_question.html',
      1 => 1505200763,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63559b78a9759ce35-92081110',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

</head>

<body>

<!--导入公共头部文件-->
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 mt40 clearfix">
		
        <!--左侧导航-->
        <?php $_template = new Smarty_Internal_Template('user_link.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

        <!--右侧-->
        <div class="fr w980">
        	<div class="p50">
                <div class="user_hd">
                    <h2>问题反馈及查询</h2>
                    <div id="myTab1" class="fl user_menu">
                        <a class="li_a" >问题反馈</a>
                        <a class="li_o" href="./help.php?act=question_result">我的反馈</a>
                    </div>
                </div>
                <div id="myTab1_Content0">
					<form action="" name="help_q" id="help_q" method="post" enctype="multipart/form-data">
						<input type="hidden" name="stage" value="yes" />
						<ul class="fill_list">
							<li>
								<label>帐号：</label>
								<input type="text" name="data[username]" id="uname" class="input_t" style="width:258px" />
								<span class="msg_text">请输入发生异常情况的帐号</span>
							</li>
							<li>
								<label>角色名：</label>
								<input type="text" name="data[rolename]" id="rolename" class="input_t" style="width:258px" />
								<span class="msg_text">请输入发生异常情况的帐号</span>
							</li>

							<li class="clearfix">
								<label>服务器：</label>

								<div class="select_down mr10">
									<div>

										<select name="data[game_id]" id="game_id" onchange="getGamSvrLst(this.value);">
											<option value="0" selected="selected">请选择游戏</option>
											<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('gameData')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
?>
											<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gameID'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['nameCn'];?>
</option>
											<?php }} ?>
										</select>

									</div>
								</div>
								<div class="select_down" id="server_div" style="display:none;">
								</div>
							</li>

							<li class="clearfix">
								<label>问题类型：</label>
								<div class="select_down">
									<div>
										<select name="data[type]" id="type">
											<option value='1'>帐号问题</option>
											<option value='2'>充值问题</option>
											<option value='3'>游戏问题</option>
										</select>
									</div>
								</div>
							</li>

							<li>
								<label>标题：</label>
								<input type="text" name="data[title]" id="title" class="input_t" style="width:258px" />
								<span class="msg_text">简单总结您遇到的问题，以便我们及时处理</span>
							</li>

							<li>
								<label>内容：</label>
								<textarea name="data[content]" id="content" cols="55" rows="5" class="input_t"></textarea>
							</li>

							<li style="line-height:40px">
								<label>上传截图：</label>
								<input type="file" name="img" id="img" />
								<span class="msg_text">附上游戏遇到的问题截图</span>
							</li>
							<li>
								<label>&nbsp;</label>
								<a href="javascript:void(0)" class="game_btn2" style="width:290px" onClick="help_question();">确 认</a>
							</li>
						</ul>

					</form>
                </div>
            
                
            </div>
        </div>
    </div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</body>
</html>
