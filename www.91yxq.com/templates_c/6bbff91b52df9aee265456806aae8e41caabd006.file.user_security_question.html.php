<?php /* Smarty version Smarty-3.0.6, created on 2016-12-28 16:10:25
         compiled from "/home/91yxq/www.demo.com/template/user_security_question.html" */ ?>
<?php /*%%SmartyHeaderCode:2180774335863737111fb19-52762180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bbff91b52df9aee265456806aae8e41caabd006' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/user_security_question.html',
      1 => 1482896441,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2180774335863737111fb19-52762180',
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
                        <div class="li_o" href="javascript:void(0);"  onclick="window.location.href='<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=passwd'">修改密码</div>
                        <div class="li_a" href="javascript:void(0);">修改密保</div>
                        <!--<div class="li_o" href="javascript:void(0);" onclick="window.location.href='<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=payment_cipher'">支付密码</div>-->
                    </div>
                </div>
                
                <div id="myTab1_Content1">
                    <div class="user_msg">密保问题, 保障您的帐号安全, 当您对帐号进行操作时需要验证密保问题!</div>
                    <FORM id="frm" name="frm" onSubmit="return my_question_submit();" action="" method="post">
                    <input type="hidden" name="stage" value="yes" />
                    <ul class="fill_list">
                        <?php if ($_smarty_tpl->getVariable('users')->value[23]){?>
                            <li>
                                    <label>原密保问题：</label>
                                    <span class="input_t" style="display:inline-block;border:0 none;box-shadow:0 0 0;border-radius:0;"><?php echo $_smarty_tpl->getVariable('users')->value[11];?>
</span>
                            </li>
                            <li>
                                    <label>原密保答案：</label>
                                    <input type="text"  id="old_answer" name="old_answer"  class="input_t" style="width:258px" />
                            </li>
                        <?php }?>
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
                        <li><label>密保答案：</label><input type="text" name="answer" id="answer" class="input_t" style="width:258px" /></li>
                        <li><label>&nbsp;</label><a href="javascript:void(0)" onclick="$('#frm').submit();" class="game_btn2" style="width:290px">确 认</a></li>
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
