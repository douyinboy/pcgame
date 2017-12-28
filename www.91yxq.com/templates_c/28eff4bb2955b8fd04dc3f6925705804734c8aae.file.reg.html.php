<?php /* Smarty version Smarty-3.0.6, created on 2017-03-22 21:36:24
         compiled from "/home/91yxq/www.demo.com/template/reg.html" */ ?>
<?php /*%%SmartyHeaderCode:1607005823589d3aec763019-35559092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28eff4bb2955b8fd04dc3f6925705804734c8aae' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/reg.html',
      1 => 1490173018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1607005823589d3aec763019-35559092',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>
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
reg_check.js"></script>
</head>

<body style="background:#b0d1f4">
<!---头部-->
<div class="head">
	<div class="m1200">
        <a href="index.html" class="logo"></a>
        <div class="fl title">账号注册</div>
    </div>
</div>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 p40 mt40 clearfix">
        <div class="inner_title">账号注册</div>
        <div class="fr regbox"><p>已有账号，请直接登录</p><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
main.php?act=login" class="game_btn1">立即登录</a></div>
        <div class="fl fill_list">
            <form action="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
main.php?act=reg" method="post" id="regform" name="regform">
            <input type="hidden" id="u_chk" name="u_chk" value="0" /><!--用户名验证状态值-->
            <input type="hidden" id="m_chk" name="m_chk" value="0" /><!--电子邮件验证状态值-->
            <input type="hidden" id="c_chk" name="c_chk" value="0" /><!--验证码验证状态值-->
            <input type="hidden" id="tn_chk" name="tn_chk" value="0" /><!--真实姓名验证状态值-->
            <input type="hidden" id="id_chk" name="id_chk" value="0" /><!--身份证验证状态值-->
            <input type="hidden" id="act" name="action" value="1" />
            <input type="hidden" name="game_id" value="<?php echo $_smarty_tpl->getVariable('game_id')->value;?>
" />
            <input type="hidden" name="href" value="<?php echo $_smarty_tpl->getVariable('href')->value;?>
" />
            <ul>
                <li>
					<label>用户名：</label>
					<input name="login_name" type="text" id="login_name" value="" class="input_t" style="width:258px" onBlur="reg_check(this,'&action=chkname&user_name='+this.value,'u_info','用户名不能为空!');" onKeyup="reg_check(this,'&action=chkname&user_name='+this.value,'u_info','用户名不能为空!');"/>
					<span class="msg_text" id="u_info">请输入用户名</span>
				</li>
                <li>
					<label>密码：</label>
					<input name="login_pwd" type="password" id="login_pwd" value="" class="input_t" style="width:258px" onBlur="pwStrength(this,true)" onKeyUp="pwStrength(this,false)" />
					<span class="msg_text" id="p_info">密码长度6~12个字符</span>
				</li>
                <li>
					<label>确认密码：</label>
					<input name="relogin_pwd" type="password" id="relogin_pwd" value="" class="input_t" style="width:258px" onBlur="pw_check(this);" onKeyUp="pw_check(this);"/>
					<span class="msg_text" id="p_info2">请再次输入密码</span>
				</li>
                <li>
					<label>电子邮箱：</label>
					<input name="email" type="text" id="email" value="" class="input_t" style="width:258px" onBlur="reg_check(this,'&action=chkmail&email='+this.value,'e_info','电子邮件不能为空！');" onKeyUp="reg_check(this,'&action=chkmail&email='+this.value,'e_info','电子邮件不能为空！');"/>
					<span class="msg_text" id="e_info">邮箱是找回密码的凭证,请填写真实有效邮箱</span>
				</li>
                <li>
					<label>真实姓名：</label>
					<input name="truename" type="text" id="truename" value="" class="input_t" style="width:258px" onBlur="reg_check(this,'&action=chk_truename&truename='+this.value,'n_info','真实姓名不能为空,例如: 张三');" onKeyUp="reg_check(this,'&action=chk_truename&truename='+this.value,'n_info','真实姓名不能为空,例如: 张三');" />
					<span class="msg_text" id="n_info">请填写与身份证上一致的真实姓名</span>
				</li>
                <li>
					<label>身份证号：</label>
					<input name="idcard" type="text" id="idcard" value="" class="input_t" style="width:258px" onBlur="reg_check(this,'&action=chk_idcard&idcard='+this.value,'id_info','身份证号不能为空,例如: 440106198202020555');" onKeyUp="reg_check(this,'&action=chk_idcard&idcard='+this.value,'id_info','身份证号不能为空,例如: 440106198202020555');" />
					<span class="msg_text" id="id_info">请填写真实身份证号如：440106198202020555</span>
				</li>
                <li>
					<label>验证码：</label>
					<input name="chk_code" type="text" id="chk_code" value="" class="input_t" style="width:154px" onBlur="reg_check(this,'&action=chkcode&chk_code='+this.value,'code_info','验证码不能为空!');" onKeyUp="reg_check(this,'&action=chkcode&chk_code='+this.value,'code_info','验证码不能为空!');"/>
					<img id="img_sec" border="0" align="absmiddle" alt="验证码,看不清楚?请点击刷新验证码" onClick="this.src='<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
chkcode.inc.php?t='+Math.random();" src="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
chkcode.inc.php" />
					<span class="msg_text" id="code_info">请填写图片中的验证码</span>
				</li>
                <li>
					<label>&nbsp;</label>
					<span class="pr10"><input name="acceptant" type="checkbox" id="acceptant" checked /></span>
					<a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
/doc/agreement.html" target="_blank">我已阅读并同意<span class="red">《通行证服务协议》</span></a>
				</li>
                <li>
					<label>&nbsp;</label>
					<input name="" onclick="reg_submit();" type="button" value="立即注册" class="game_btn2" style="width:290px" />
				</li>
            </ul>
            </form>
        </div>
    </div>
</div>

<!--页脚-->
<div class="foot clearfix" id="footer_box">
	<script src="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
/public/footer.js"></script>
</div>

</body>
</html>
