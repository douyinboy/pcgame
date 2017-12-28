<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 02:35:04
         compiled from ".\templates\pay\theGuildPay.html" */ ?>
<?php /*%%SmartyHeaderCode:315458b4e1d8a92622-30424974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef09ffc9843e67b3f991302684bbefbfaa8d9ea6' => 
    array (
      0 => '.\\templates\\pay\\theGuildPay.html',
      1 => 1487134626,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '315458b4e1d8a92622-30424974',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'gamelist' => 0,
    'v' => 0,
    'serverlist' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
    'totalmoney' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b4e1d8c5788',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e1d8c5788')) {function content_58b4e1d8c5788($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
    <input type="hidden" name="user_name" value="<?php echo $_POST['user_name'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>游戏服区：</label>
            <select class="combox" name="game_id" id="game_id" ref="server_949465wa2n_24" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['game_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select>
                <select class="combox" name="server_id" id="server_949465wa2n_24">
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['serverlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['server_id'];?>
" <?php if ($_POST['server_id']==$_smarty_tpl->tpl_vars['v']->value['server_id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select>
            </li>
            <li><label>玩家账号：</label>
            <input type="text" name="user_name" value="<?php echo $_POST['user_name'];?>
" class="textInput">
            </li>
            </ul>
            <ul class="searchContent">
                <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a>
                </li>
            </ul>
        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
            </ul>
        </div>
    </div>
    </form>
</div>
<div class="pageContent">
    <table class="table" width="100%"  layoutH="137">
                    <thead>
                        <tr>
                            <th>充值账号</th>
                            <th>玩家角色</th>
                            <th>游戏</th>
                            <th>充值金额(元)</th>
                            <th>充值时间</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                            <tr target="sid" rel="1">
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['user_role'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game'];?>
<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
区</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['paid_amount'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_date'];?>
</td>
                            </tr>
                            <?php } ?>
                    </tbody>
    </table>
    <div class="panelBar">
        <div class="pages"><span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option <?php if ($_POST['numPerPage']==20){?>selected<?php }?>  value="20">20</option>
                <option <?php if ($_POST['numPerPage']==50){?>selected<?php }?> value="50">50</option>
                <option <?php if ($_POST['numPerPage']==100){?>selected<?php }?> value="100">100</option>
                <option <?php if ($_POST['numPerPage']==200){?>selected<?php }?> value="200">200</option>
            </select><span>条，共<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
条</span> <span style="margin-left: 10px;">共<b style="color: red;"><?php echo $_smarty_tpl->tpl_vars['totalmoney']->value;?>
</b>元</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div><?php }} ?>