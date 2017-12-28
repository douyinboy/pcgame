<?php /* Smarty version Smarty-3.0.6, created on 2016-12-28 16:10:22
         compiled from "/home/91yxq/www.demo.com/template/user_indulge.html" */ ?>
<?php /*%%SmartyHeaderCode:8860441115863736e86dfc5-64356210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0647896379f374939d81d5e0e1537241d682c58' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/user_indulge.html',
      1 => 1482896440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8860441115863736e86dfc5-64356210',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/91yxq/www.demo.com/smarty/plugins/modifier.truncate.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('chinese_title')->value;?>
-用户中心-防沉迷设置</title>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/base.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/public.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/main_pq.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
function.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
user.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
reg_check.js"></script>
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
					<h2>防沉迷设置</h2>
					<div style="font-size:14px; color:#dc5562; line-height:35px;">您可以进入游戏，但是我们建议您填写如下身份资料以免受到防沉迷系统的限制。</div>
				</div>
                
                <?php if ($_smarty_tpl->getVariable('users')->value[26]){?>
				<div class="user_msg">您已通过防沉迷认证，无法更改</div>
				<ul class="fill_list">
					<li><label>真实姓名：</label><input type="text" name="truename" id="truename" class="input_t" style="width:258px" disabled value="<?php echo $_smarty_tpl->getVariable('uname')->value;?>
***"/></li>
					<li><label>身份证号码：</label><input type="text" name="idcard" id="idcard" class="input_t" style="width:258px" disabled value="<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('users')->value[4],"3",'',true);?>
************"/></li>
				</ul>
                <?php }else{ ?>
				<div class="user_msg">注意：一旦认证成功将无法更改，请认真填写</div>
                <form action="" method="post" name="idform" id="idform" onSubmit="return my_indulge_sumbit();">
                    <input type="hidden" name="stage" value="yes">
                    <input type="hidden" id="tn_chk" name="tn_chk" value="0" /><!--真实姓名验证状态值-->
                    <input type="hidden" id="id_chk" name="id_chk" value="0" /><!--身份证验证状态值-->  
                    <ul class="fill_list">
                        <li><label>真实姓名：</label><input onBlur="reg_check(this,'&amp;action=chk_truename&amp;truename='+this.value,'n_info','真实姓名不能为空！');" type="text" name="truename" id="truename" class="input_t" style="width:258px" /><span class="msg_text" id="n_info">请输入真实姓名</span></li>
                            <li><label>身份证号码：</label><input onBlur="reg_check(this,'&amp;action=chk_idcard&amp;idcard='+this.value,'id_info','身份证号码不能为空！');" type="text" name="idcard" id="idcard" class="input_t" style="width:258px" /><span class="msg_text" id="id_info">请输入身份证号码</span></li>
                        <li><label>&nbsp;</label><a href="javascript:void(0)" onclick="$('#idform').submit();" class="game_btn2">确 认</a></li>
                    </ul>
                </form>
                <?php }?>
                <div class="msg mt20">
                    <h3>网络游戏防沉迷系统及用户隐私说明</h3>
                    <p>按照版署《网络游戏未成年人防沉迷系统》要求,为预防青少年过度游戏，未满18岁的用户和身份信息不完整的用户将受到防沉迷系统的限制，平台积极响应国家新闻出版总署防沉迷政策要求，开发出网页游戏防沉迷系统。<br /><br />
                    年龄已满18周岁的玩家，在填写身份证资料后，可以不受防沉迷系统影响，自由进行游戏，否则游戏每日在线3小时后即打怪经验减半,超过5小时则无经验。<br /><br />
                    说明：系统只支持输入18位的中国身份证号码，持有其他证件（如：外国护照，军人证，等）者，请与客服GM联系处理。<br /><br />
                    填写身份信息将使我们可以对您的年龄做出判断，以确定您的游戏时间是否需要按照国家新闻出版总署的要求纳入防沉迷系统的管理。<br /><br />
                    隐私说明：用户填写的身份信息属于用户的隐私。<?php echo $_smarty_tpl->getVariable('chinese_title')->value;?>
游戏绝对尊重用户个人隐私权。所以，我们平台游戏绝不会公开，编辑或透露用户的信息内容，除非有法律许可及公安管理规定。</p>
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
