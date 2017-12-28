<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:47:11
         compiled from "./templates/payjie/jie.html" */ ?>
<?php /*%%SmartyHeaderCode:67251993356d52e6b5c5c33-28023764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c85b14c77c33d28c65cc19137c9bbb51fd648f0' => 
    array (
      0 => './templates/payjie/jie.html',
      1 => 1456973056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67251993356d52e6b5c5c33-28023764',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56d52e6b768cc',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
    'totalMoney' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d52e6b768cc')) {function content_56d52e6b768cc($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/gh.demo.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="pwd" value="<?php echo $_POST['pwd'];?>
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
            <li style="width:500px;"><label>密码：</label>
                <input type="text" name="pwd" size="24" class="" value="<?php echo $_POST['pwd'];?>
"/>
                 <span class="info" style="color:#999;">如没显示数据，请输入密码</span>
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
                            <th>申请时间</th>
                            <th>审核时间</th>
                            <th>审核人</th>
                            <th>状态</th>
                            <th>理由</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                            <tr target="sid" rel="1">
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
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['apply_time']>0){?> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['apply_time'],"%Y-%m-%d");?>
 <?php }else{ ?> --- <?php }?></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['jieTime'];?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['name'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['apply']==-1){?>待审核<?php }elseif($_smarty_tpl->tpl_vars['vo']->value['apply']==1){?>已打款<?php }elseif($_smarty_tpl->tpl_vars['vo']->value['apply']==2){?>不通过<?php }else{ ?>--<?php }?></td>
                                <td title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['Reason'])===null||$tmp==='' ? "--" : $tmp);?>
">
                                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['Reason'])===null||$tmp==='' ? "--" : $tmp);?>

                                </td>
                                <td><a style="color: red;"  href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=detail&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"  height="300" width="600" target="dialog" >查看明细</a></td>
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
<?php }} ?>