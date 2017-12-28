<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:47:10
         compiled from "./templates/payjie/weekjie.html" */ ?>
<?php /*%%SmartyHeaderCode:122536003456d52e6ac431a4-92232696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '411ecab91ae6fde34c44dfff767e71b523f82a54' => 
    array (
      0 => './templates/payjie/weekjie.html',
      1 => 1456973056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122536003456d52e6ac431a4-92232696',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56d52e6ae69de',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'data' => 0,
    'vo' => 0,
    'heji' => 0,
    'totalcount' => 0,
    'totalMoney' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d52e6ae69de')) {function content_56d52e6ae69de($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/gh.demo.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="state" value="<?php echo $_POST['state'];?>
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
            <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
            <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
            <li>
                    <label>状态：</label>
                    <select   name="state">
                        <option value="0">请选择</option>
                        <option value="-1" <?php if ($_POST['state']==-1){?>selected<?php }?> >未结算</option>
                        <option value="1" <?php if ($_POST['state']==1){?> selected<?php }?> >已结算</option>
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
            <li><a class="add" title="结算" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" target="navTab" rel="editMoviePage"><span>结算</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="138">
                    <thead>
                        <tr>
                            <th width="40">周期</th>
                            <th width="120">起始--截止(日期)</th>
                            <th width="80">公会名称</th>
                            <th width="80">平台充值</th>
                            <th width="80">平台充值流水</th>
                            <th width="50">首充</th>
                            <th width="50">内充</th>
                            <th width="50">V充</th>
                            <th width="80">结算金额</th>
                            <th width="50">审核人</th>
                            <th width="100">审核时间</th>
                            <th width="50">打款人</th>
                            <th width="100">打款时间</th>
                             <th width="50">状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <volist id="vo" name="list">
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                            <tr target="sid" rel="1">
                                <td>第<?php echo $_smarty_tpl->tpl_vars['vo']->value['weekth'];?>
周</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['starttime'];?>
 --<?php echo $_smarty_tpl->tpl_vars['vo']->value['endtime'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_money'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_amount'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_first'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_inner'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_vip'];?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['vo']->value['pstate']==1){?>
                                        <a  title="明细" style="color:red;" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=detail&wsdate=<?php echo $_smarty_tpl->tpl_vars['vo']->value['wsdate'];?>
&wedate=<?php echo $_smarty_tpl->tpl_vars['vo']->value['wedate'];?>
"  height="300" width="700" target="dialog" ><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_jie'];?>
</a>
                                    <?php }else{ ?>
                                    <?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_jie'];?>

                                    <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['ctime']>0){?><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['ctime'],"%Y-%m-%d %H:%I:%S");?>
<?php }else{ ?>---<?php }?></td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['uidname'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['ptime']>0){?><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['ptime'],"%Y-%m-%d %H:%I:%S");?>
<?php }else{ ?>---<?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['pstate']==0){?>未结算
                                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value['cuid']==0){?>未审核
                                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value['puid']==0){?>未打款
                                    <?php }elseif($_smarty_tpl->tpl_vars['vo']->value['pstate']==1&&$_smarty_tpl->tpl_vars['vo']->value['cuid']>0&&$_smarty_tpl->tpl_vars['vo']->value['puid']>0){?>已打款
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                             <tr target="sid" rel="1">
                                <td>合计：</td>
                                <td>---</td>
                                <td>---</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['allmoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payaccount'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payfirst'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payinner'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['vmoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['jiemoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                            </tr>
                        </volist>
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
<?php }} ?>