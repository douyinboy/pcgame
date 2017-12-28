<?php /* Smarty version Smarty-3.1.7, created on 2017-02-15 18:19:50
         compiled from ".\templates\sysmanage\index.html" */ ?>
<?php /*%%SmartyHeaderCode:1798158a42b46048850-42094952%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e956d66351ab1f46b4efecf6e4a475f33dd598e3' => 
    array (
      0 => '.\\templates\\sysmanage\\index.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1798158a42b46048850-42094952',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'date' => 0,
    'pay' => 0,
    'reg' => 0,
    'ydate' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a42b4607f36',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a42b4607f36')) {function content_58a42b4607f36($_smarty_tpl) {?><style type="text/css">
	ul.rightTools {float:right; display:block;}
	ul.rightTools li{float:left; display:block; margin-left:5px}
</style>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('root_url');?>
colligate/js/highcharts.js"></script>
<div class="pageContent">
	<div class="panel" defH="25" style="display: none;">
		<h1>快捷方式：</h1>
		<div>
                    <ul class="rightTools">
                        <li><a class="button" target="" href="javascript:void(0);" mask="true"><span>功能待开发</span></a></li>
                        <li><div class="buttonDisabled"><div class="buttonContent"><button>公会信息查询</button></div></div></li>
                    </ul>
		</div>
	</div>
	<div class="tabs" >
		<div class="tabsHeader">
			<div class="tabsHeaderContent">
				<ul>
					<li><a href="javascript:;"><span>数据示意图</span></a></li>
					<li><a href="javascript:;"><span>公会今日充值排行【20】</span></a></li>
				</ul>
			</div>
		</div>
		<div class="tabsContent" >
                    <!--数据示意图-->
			<div>
				<div layoutH="34" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
				    <ul class="tree treeFolder">
						<li><a href="javascript">实时数据</a>
							<ul>
								<li ><a  href="?action=sysmanage&opt=index&show=online" target="ajax" rel="jbsxBox">今日注册</a></li>
								<li><a href="?action=sysmanage&opt=index&show=pay" target="ajax" rel="jbsxBox">今日充值</a></li>
							</ul>
						</li>
	
				     </ul>
				</div>
				<div id="jbsxBox" class="unitBox" layoutH="34">
				</div>
			</div>
                   <!--今日在线-->
                    <div>
                        <div layoutH="34" class="table">
            <fieldset>
                <legend style="margin-left:45%">注册&充值</legend>
                    <dl class="nowrap">
                        <dd>
                            <div class="" style="width:24%;border:1px solid #e1f3fc;margin:5px;float:left;min-height:60px;margin-left: 30%">
                                <div style="border:1px solid #B8D0D6;padding:5px;margin:5px">今日充值总额：<?php echo (($tmp = @$_smarty_tpl->tpl_vars['pay']->value[$_smarty_tpl->tpl_vars['date']->value])===null||$tmp==='' ? "0" : $tmp);?>
元</div>
                                <div style="border:1px solid #B8D0D6;padding:5px;margin:5px">今日总注册：<?php echo (($tmp = @$_smarty_tpl->tpl_vars['reg']->value[$_smarty_tpl->tpl_vars['date']->value])===null||$tmp==='' ? "0" : $tmp);?>
人</div>           
                            </div>
                            <div class="" style="width:24%;border:1px solid #e1f3fc;margin:5px;float:left;min-height:60px">
                                <div style="border:1px solid #B8D0D6;padding:5px;margin:5px">昨天充值总额：<?php echo (($tmp = @$_smarty_tpl->tpl_vars['pay']->value[$_smarty_tpl->tpl_vars['ydate']->value])===null||$tmp==='' ? "0" : $tmp);?>
元</div>
                                <div style="border:1px solid #B8D0D6;padding:5px;margin:5px">昨天总注册：<?php echo (($tmp = @$_smarty_tpl->tpl_vars['reg']->value[$_smarty_tpl->tpl_vars['ydate']->value])===null||$tmp==='' ? "0" : $tmp);?>
人</div>
           
                            </div>
                            <div class="" style="width:98%;border:1px solid #e1f3fc;margin:5px;float:left;min-height:10px;">
                                <?php echo $_smarty_tpl->getSubTemplate ("sysmanage/bestSeller.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                            </div>
                        </dd>
                    </dl>
                </fieldset> 
                    </div>
            </div>
		</div>
	</div>
	
</div><?php }} ?>