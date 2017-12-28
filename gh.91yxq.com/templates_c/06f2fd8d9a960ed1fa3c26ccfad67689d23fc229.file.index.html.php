<?php /* Smarty version Smarty-3.1.7, created on 2017-02-24 18:19:21
         compiled from ".\templates\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2924358b008a90ddf37-84622258%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06f2fd8d9a960ed1fa3c26ccfad67689d23fc229' => 
    array (
      0 => '.\\templates\\index.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2924358b008a90ddf37-84622258',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'topMenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b008a9260b1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b008a9260b1')) {function content_58b008a9260b1($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\phpStudy\\WWW\\91yxq\\gh.91yxq.com\\Smarty-3.1.7/plugins\\modifier.date_format.php';
?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo $_smarty_tpl->getConfigVariable('admin_title');?>
【<?php echo $_smarty_tpl->getConfigVariable('admin_version');?>
】</title>

<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes/css/pqcms.css">

<link href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<!--<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/date_plus/skin/WdatePicker.css"> 
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
uploadify/css/uploadify.css">  -->
<!--[if IE]>
<link href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->
<style type="text/css">
	#header{height:80px}
	#leftside, #container, #splitBar, #splitBarProxy{top:85px}
</style>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/jquery-1.7.1.js"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
uploadify/scripts/jquery.uploadify.min.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/dwz.min.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/dwz.regional.zh.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/search_guilds.js"></script>
<!--
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/date_plus/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
js/highcharts.js"></script>
-->
<script type="text/javascript">
$(function(){
    DWZ.init("<?php echo $_smarty_tpl->getConfigVariable('root_url_cache');?>
config/cframe.xml", {
        loginUrl:"index.php?action=public&opt=ajaxLogin", loginTitle:"超时重新登录",	// 弹出对话框登录
        statusCode:{ok:200, error:300, timeout:301},
        debug:false,
        callback:function(){
            initEnv();
            $("#themeList").theme({themeBase:"<?php echo $_smarty_tpl->getConfigVariable('root_url_cframe');?>
themes"});
        }
    });
});
function fleshVerify(){//重载验证码
	var timenow = new Date().getTime();
    $('#verifyImg').attr("src", '<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=public&opt=loadVerify&verify_time='+timenow);
}

function sortBy(field,thisElm){
		var orderField_input = $(thisElm).parents('.unitBox').eq(0).find('.orderField_input');
		var orderDesc_input = $(thisElm).parents('.unitBox').eq(0).find('.orderDesc_input');
		if( orderField_input.val()==field ){
			orderDesc_input.val( 1-orderDesc_input.val() )
		}
		else{
			orderDesc_input.val(1)
		}
		navTabPageBreak({orderField:field});
}
</script>
</head>
<body scroll="no">
    <div id="layout">
        
    <div id="header" class="head">
        <a href="javascript:void(0);" class="logo"></a>
        <!--导航-->
        <div id="navMenu">
                <ul>
                <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['sec'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['name'] = 'sec';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['topMenu']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sec']['total']);
?>
                    <li <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['sec']['index']==0){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=sysmanage&opt=leftMenu&tid=<?php echo $_smarty_tpl->tpl_vars['topMenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sec']['index']]['key'];?>
" class="on"><span class="l"></span><span class="r"><?php echo $_smarty_tpl->tpl_vars['topMenu']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sec']['index']]['title'];?>
</span></a></li>
                <?php endfor; endif; ?>
                </ul>
        </div> 
        <!--信息-->
        <div class="head_info_box">
            <div class="head_info">
                <a href="javascript:void(0);">公会名: <?php echo $_SESSION['user']['name'];?>
</a>
                <span class="line">|</span>
                <a href="javascript:void(0);">管理者: <?php echo $_SESSION['user']['account'];?>
</a>
                <span class="line">|</span>
				<a href="?action=sysmanage&opt=cmdata" target="dialog" height="230" width="600">修改密码</a>
                <span class="line">|</span>
                <a href="?action=public&opt=loginOut">退出登录</a>
            </div>
        </div>
    </div>
    <!--头部 END-->
<!--左侧管理菜单-->
    <div id="leftside">
        <div id="sidebar_s">
            <div class="collapse">
                <div class="toggleCollapse"><div></div></div>
            </div>
        </div>
        <div id="sidebar">
            <div class="toggleCollapse"><h2><=隐藏左边栏</h2><div>收缩</div></div>
            <?php echo $_smarty_tpl->getSubTemplate ("sysmanage/leftMenu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        </div>
    </div>
<!--左侧管理菜单END-->
<!--主界面-->
    <div id="container">
        <div id="navTab" class="tabsPage">
            <div class="tabsPageHeader">
                <div class="tabsPageHeaderContent ">
                    <ul class="navTab-tab">
                        <li tabid="grant1101" class="main"><a href="javascript:;"><span><span class="home_icon">管理首页</span></span></a></li>
                    </ul>
                </div>
                <div class="tabsLeft">left</div>
                <div class="tabsRight">right</div>
                <div class="tabsMore">more</div>
            </div>
            <ul class="tabsMoreList">
                <li><a href="javascript:;">管理首页</a></li>
            </ul>
            <div class="navTab-panel tabsPageContent layoutBox" >
                <?php echo $_smarty_tpl->getSubTemplate ("sysmanage/index.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            </div>
        </div>
    </div>
<!--主界面END-->
    </div>
<!--footer-->
    <div id="footer">Copyright &copy; <?php echo smarty_modifier_date_format(time(),"%Y");?>
<a href="<?php echo $_smarty_tpl->getConfigVariable('officel_url');?>
" target="_blank"><?php echo $_smarty_tpl->getConfigVariable('officel_title');?>
</a></div>
<!--footer END-->
</body>
</html><?php }} ?>