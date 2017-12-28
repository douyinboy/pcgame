<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 10:38:21
         compiled from ".\templates\recharge\dayData.html" */ ?>
<?php /*%%SmartyHeaderCode:1273658b4e29d2cf085-65535613%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6dc2b9a328e46b02caf084dc4ec02d9dad859aea' => 
    array (
      0 => '.\\templates\\recharge\\dayData.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1273658b4e29d2cf085-65535613',
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
    'heji' => 0,
    'totalcount' => 0,
    'totalmoney' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b4e29d4172d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e29d4172d')) {function content_58b4e29d4172d($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>游戏服区：</label>
            <select class="combox" name="game_id" id="game_id" ref="server_91yxq_212498" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                <select class="combox" name="server_id" id="server_91yxq_212498">
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
            <li>  
                <label>查询起始日期：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a></li>
            <li>
                <label>查询结束日期：</label>
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
    <table class="table" width="100%"  layoutH="107">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>游戏</th>
                    <th>区间新增注册</th>
                    <th>区间注册IP数</th>
                    <th>充值人数</th>
                    <th>充值金额</th>
                </tr>
            </thead>
            <tbody>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']++;
?>
                    <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f8fdfc;<?php }?>">
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['paydate'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['regusers'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['regips'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['payusers'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td><a href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&detail=1&sdate=<?php echo $_smarty_tpl->tpl_vars['vo']->value['paydate'];?>
&game_id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
&server_id=<?php echo $_POST['server_id'];?>
" width="800" height="520" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value['paydate'];?>
<?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
的充值明细" target="dialog"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['paymoney'])===null||$tmp==='' ? "0" : $tmp);?>
</a></td>
                    </tr>
                    <?php } ?> 
                    <tr target="sid" rel="1" style="background-color: #e3effe">
                        <td>合计：</td>
                        <td>--</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['regusers'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['regips'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['payusers'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['paymoney'];?>
</td>
                        </tr>
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
条</span><span style="margin-left: 10px;">共<b style="color: red;"><?php echo $_smarty_tpl->tpl_vars['totalmoney']->value;?>
</b>元</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div><?php }} ?>