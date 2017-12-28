<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:16:53
         compiled from "./templates/recharge/payjieToguild.html" */ ?>
<?php /*%%SmartyHeaderCode:107603031056cff2f542dff7-22183498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbf746b5a1ddb64ee1f199e583ce3a90e5357f2a' => 
    array (
      0 => './templates/recharge/payjieToguild.html',
      1 => 1456972706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107603031056cff2f542dff7-22183498',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff2f55ba6d',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'guildlist' => 0,
    'v' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
    'totalMoney' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff2f55ba6d')) {function content_56cff2f55ba6d($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                <select class="combox" name="agentid" id="agentid6" ref="w_cohesid22132213" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
                    <option value="0">请选择</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['agentid']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                    <?php } ?>
                </select>
                <input type="text" id="search_key6" size="10" class="" value="输入关键字"/>
            </li>
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
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" title="新增结算" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="460" width="980" target="dialog" mask="true"><span>新增结算</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
            <tr>
                <th>流水编号</th>
                <th>公会名</th>
                <th>结算起始--结束日期</th>
                <th>期间充值总金额</th>
                <th>公会内充总金额</th>
                <th>结算金额</th>
                <th>结算时间</th>
                <th>操作</th>
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
                <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f6fcfc;<?php }?>">
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['sDate'];?>
 截止至：<?php echo $_smarty_tpl->tpl_vars['vo']->value['eDate'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['payMoney'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['innerMoney'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['jieMoney'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['jieTime'];?>
</td>
                    <td><a style="color: red;" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
结算明细"  href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=detail&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"  height="360" width="780" target="dialog" >查看明细</a></td>
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
条</span> <span>&nbsp;&nbsp;结算总金额：<?php echo $_smarty_tpl->tpl_vars['totalMoney']->value;?>
&nbsp;元</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
        search_pro('search_key6','agentid6');
</script><?php }} ?>