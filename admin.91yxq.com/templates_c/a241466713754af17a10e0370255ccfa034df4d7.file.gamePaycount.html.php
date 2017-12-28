<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:00
         compiled from "./templates/recharge/gamePaycount.html" */ ?>
<?php /*%%SmartyHeaderCode:115019423756cff2f1455aa4-05748394%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a241466713754af17a10e0370255ccfa034df4d7' => 
    array (
      0 => './templates/recharge/gamePaycount.html',
      1 => 1456972706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115019423756cff2f1455aa4-05748394',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff2f157d20',
  'variables' => 
  array (
    'stime' => 0,
    'etime' => 0,
    'username' => 0,
    'v' => 0,
    'gamelist' => 0,
    'data' => 0,
    'vo' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff2f157d20')) {function content_56cff2f157d20($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
    <input type="hidden" name="pay_name" value="<?php echo $_POST['pay_name'];?>
"/>
    <input type="hidden" name="type" value="<?php echo $_POST['type'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
                <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['stime']->value;?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['etime']->value;?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>
                    <label>公会专员：</label>
                    <select class="combox" name="pay_name">
                    <option value="">所有</option>
                     <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['username']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['uid']>0){?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" <?php if ($_POST['pay_name']==$_smarty_tpl->tpl_vars['v']->value['uid']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['addUser'];?>
</option>
                    <?php }?>
                    <?php } ?>
                    </select>
                </li>
                </ul>
               <ul class="searchContent">
                <li>
                    <div class="unit">
                            <label>游戏：</label>
                        <select class="combox" name="game_id">
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

                    </div> 
                </li>
                <li>
                    <label>查询方式：</label>
                    <select class="combox" name="type">
                        <option value="1" <?php if ($_POST['type']==1){?> selected <?php }?>>游戏</option>
                        <option value="2" <?php if ($_POST['type']==2){?> selected <?php }?>>专员</option>
                    </select>
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
    <div class="panelBar">
        <ul class="toolBar">
           
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
            <tr>
                <th>游戏名称</th>
                <th>专员</th>
                <th>充值总金额</th>
                <th>时间段</th>
            </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="id" rel="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['username'])===null||$tmp==='' ? "所有" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['money'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['stime']->value;?>
 --<?php echo $_smarty_tpl->tpl_vars['etime']->value;?>
</td>
            </tr>
            <?php } ?>
            <tr>
                <td>合计:</td>
                <td>--</td>
                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['money'];?>
</td>
                <td>--</td>
            </tr>
        </tbody>
    </table>
</div><?php }} ?>