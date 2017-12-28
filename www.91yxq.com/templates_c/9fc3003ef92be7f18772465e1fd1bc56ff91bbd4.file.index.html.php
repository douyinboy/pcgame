<?php /* Smarty version Smarty-3.0.6, created on 2016-12-28 11:40:55
         compiled from "/home/91yxq/www.demo.com/template/gamelogin/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1774669233586334474838a2-05651062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fc3003ef92be7f18772465e1fd1bc56ff91bbd4' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/gamelogin/index.html',
      1 => 1482896441,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1774669233586334474838a2-05651062',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>91yxq游戏《<?php echo $_smarty_tpl->getVariable('game_name')->value;?>
》双线<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
服[<?php echo $_smarty_tpl->getVariable('game_name')->value;?>
]|精品游戏,尽在91yxq游戏平台!</title>
</head>
<frameset name="bodyFrame" id="bodyFrame" framespacing="0" border="0" cols="*" rows="27,*">
  <frame scrolling="no" title="topFrame" id="topFrame" frameborder="0" src="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
/gameTop/<?php if ($_smarty_tpl->getVariable('top')->value==1){?><?php echo $_smarty_tpl->getVariable('game_id')->value;?>
<?php }else{ ?>index<?php }?>.html?game_name=<?php echo $_smarty_tpl->getVariable('game_name')->value;?>
&game_short_name=<?php echo $_smarty_tpl->getVariable('game_short_name')->value;?>
&game_id=<?php echo $_smarty_tpl->getVariable('game_id')->value;?>
&server_id=<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
&server_name=<?php echo $_smarty_tpl->getVariable('server_name')->value;?>
&wd=<?php echo $_smarty_tpl->getVariable('wd')->value;?>
"></frame>
  <frame frameborder="0" src="<?php echo $_smarty_tpl->getVariable('game_url')->value;?>
"></frame>
</frameset>
<noframes><body>浏览器不支持框架</body></noframes>
</html>