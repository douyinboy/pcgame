<?php /* Smarty version Smarty-3.0.6, created on 2017-03-22 23:21:00
         compiled from "/home/91yxq/www.demo.com/template/user_passwd.html" */ ?>
<?php /*%%SmartyHeaderCode:1707548943589d7ef35503c6-66961346%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd11a33ad9fa70ba24ebc1e0396b404668544f754' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/user_passwd.html',
      1 => 1490173018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1707548943589d7ef35503c6-66961346',
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
-用户中心-安全中心</title>
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
                	<h2>安全中心</h2>
                	<div id="" class="fl user_menu clearfix">
                        <div class="li_a" href="javascript:void(0);">修改密码</div>
                        <div class="li_o" href="javascript:void(0);" onclick="window.location.href='<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=security_question'">修改密保</div>
                        <!--<div class="li_o" href="javascript:void(0);" onclick="window.location.href='<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=payment_cipher'">支付密码</div>-->
                    </div>
                </div>
                
                <div id="myTab1_Content0">
                    <div class="user_msg">您一天只能修改密码3次, 您还剩下<?php echo $_smarty_tpl->getVariable('num')->value;?>
次修改机会!</div>
                    <ul class="fill_list">
                        <form id="frm1" name=frm onSubmit="return my_passwd_submit();" action="" method="post">
                        <input type="hidden" name="stage" value="yes">  
                        <li><label>原密码：</label><input type="password" name="oldpwd" id="oldpwd" class="input_t" style="width:258px"  onblur="my_passwd_1();"/><span class="msg_text" id="o_info">请输入原密码</span></li>
                        <li><label>新密码：</label><input type="password" name="login_pwd" id="login_pwd" class="input_t" style="width:258px"  onblur="my_passwd_2();"/><span class="msg_text" id="p_info">请输入新密码</span></li>
                        <li><label>确认密码：</label><input type="password" name="relogin_pwd" id="relogin_pwd" class="input_t" style="width:258px"  onblur="my_passwd_3();"/><span class="msg_text" id="p_info2">不能为空</span></li>
                        <li><label>&nbsp;</label><a href="javascript:void(0)" onclick="$('#frm1').submit();" class="game_btn2" style="width:290px">确 认</a></li>
                        </form>
                    </ul>
                </div>
                <div id="myTab1_Content1" style="display:none">
                    <div class="user_msg">密保问题, 保障您的帐号安全, 当您对帐号进行操作时需要验证密保问题!</div>
                    <ul class="fill_list">
                        <li class="clearfix">
                            <label>密保问题：</label>
                            <div class="select_down">
                                <div>
                                <select id="question" name="question">
                                    <option value="" selected="">请选择密保问题</option>
                                    <option value="您母亲的姓名是?">您母亲的姓名是?</option>
                                    <option value="您配偶的生日是?">您配偶的生日是?</option>
                                    <option value="您的学号（或工号）是?">您的学号（或工号）是?</option>
                                    <option value="您母亲的生日是?">您母亲的生日是?</option> 
                                    <option value="您高中班主任的名字是?">您高中班主任的名字是?</option>
                                    <option value="您父亲的姓名是?">您父亲的姓名是?</option>
                                    <option value="您小学班主任的名字是?">您小学班主任的名字是?</option>
                                    <option value="您父亲的生日是?">您父亲的生日是?</option> 
                                    <option value="您配偶的姓名是?">您配偶的姓名是?</option>
                                    <option value="您初中班主任的姓名是?">您初中班主任的姓名是?</option>
                                    <option value="您最熟悉的童年好友名字是?">您最熟悉的童年好友名字是?</option>
                                    <option value="您最熟悉的学校宿舍室友名字是?">您最熟悉的学校宿舍室友名字是?</option>
                                    <option value="对您影响最大的人名字是?">对您影响最大的人名字是?</option>
                                </select>
                                </div>
                            </div>
                        </li>
                        <li><label>密保答案：</label><input type="text" name="textfield" id="textfield" class="input_t" style="width:258px" /></li>
                        <li><label>&nbsp;</label><a href="javascript:void(0)" class="game_btn2" style="width:290px">确 认</a></li>
                    </ul>
                </div>
                <div id="myTab1_Content2" style="display:none">
                    <div class="user_msg"><i class="user_img icon_prompt"></i>请设置支付密码及验证身份，如未填写身份信息也可在此页面填写！</div>
                    <ul class="fill_list">
                        <li><label>真实姓名：</label><input type="text" name="textfield" id="textfield" class="input_t" style="width:258px" /><span class="msg_text">请输入真实姓名</span></li>
                        <li><label>身份证号码：</label><input type="text" name="textfield" id="textfield" class="input_t" style="width:258px" /><span class="msg_text">请输入身份证号码</span></li>
                        <li><label>支付密码：</label><input type="text" name="textfield" id="textfield" class="input_t" style="width:258px" /><span class="msg_text">请输入新密码</span></li>
                        <li><label>确认密码：</label><input type="text" name="textfield" id="textfield" class="input_t input_error" style="width:258px" /><span class="warn">密码不一致</span></li>
                        <li><label>&nbsp;</label><a href="javascript:void(0)" class="game_btn2" style="width:290px">确 认</a></li>
                    </ul>
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
