<?php /* Smarty version Smarty-3.0.6, created on 2017-10-26 18:14:06
         compiled from "E:\phpStudy\WWW\91yxq\www.91yxq.com\template/help_recharge.html" */ ?>
<?php /*%%SmartyHeaderCode:2786859f1b56e89baf2-77178214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a72437d969191a476b81a8295d31f8d8a5f8690' => 
    array (
      0 => 'E:\\phpStudy\\WWW\\91yxq\\www.91yxq.com\\template/help_recharge.html',
      1 => 1509012844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2786859f1b56e89baf2-77178214',
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
	<script type="text/javascript" src="http://image.91yxq.com/datewidget/laydate.dev.js"></script>
	<script src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
/help.js" type="text/javascript"></script>
	<style>
		tr td {
			text-align: center;
		}
	</style>
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
                    <h2>充值列表</h2>
                </div>
                <div id="myTab1_Content0">
					<form action="" name="help_q" id="help_q" method="get">
						订单号：<input type="text" name="orderid" value="<?php echo $_smarty_tpl->getVariable('orderid')->value;?>
" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						开始时间：<input type="text" id="startTime" name="startTime" value="<?php echo $_smarty_tpl->getVariable('startTime')->value;?>
" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						结束时间：<input type="text" id="endTime" name="endTime" value="<?php echo $_smarty_tpl->getVariable('endTime')->value;?>
" />
						<input type="submit" value="查询">
						<input type="hidden" name="act" value="recharge">
					</form>
					<br>
					<table border="1" cellspacing="0" cellpadding="0">
						<tr style="height: 28px; line-height: 22px;">
							<th width="50xp">序号</th>
							<th width="200xp">充值订单号</th>
							<th width="100px">充值金额</th>
							<th width="100px">游戏币</th>
							<th width="100px">充值游戏</th>
							<th width="100px">充值区服</th>
							<th width="100px">充值方式</th>
							<th width="180px">充值时间</th>
						</tr>
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
?>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['num'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['orderid'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['money'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['pay_gold'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['game'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['server'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['pay_channel'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['val']->value['sync_date'];?>
</td>
						</tr>
						<?php }} ?>
					</table>
                </div>

				<div class="page" style="margin-top: 15px;">
					<?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int)ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? $_smarty_tpl->getVariable('pageTotal')->value+1 - (1) : 1-($_smarty_tpl->getVariable('pageTotal')->value)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0){
for ($_smarty_tpl->tpl_vars['foo']->value = 1, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++){
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration == 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration == $_smarty_tpl->tpl_vars['foo']->total;?>
						<?php if ($_smarty_tpl->tpl_vars['foo']->value==$_smarty_tpl->getVariable('p')->value){?>
						<a style="color: red; cursor: default;" href="javascript:;">[<?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
]</a>
						<?php }else{ ?>
						<a href="<?php echo $_smarty_tpl->getVariable('url')->value;?>
&p=<?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
</a>
						<?php }?>
					<?php }} ?>
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
<script type="text/javascript">
    laydate({
        elem: '#startTime', //dom
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义
        festival: true, //显示节日
        istime: true //显示时间
    });
    laydate({
        elem: '#endTime', //dom
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义
        festival: true, //显示节日
        istime: true //显示时间
    });
</script>