<?php /* Smarty version Smarty-3.1.7, created on 2017-02-14 18:15:01
         compiled from "./templates/system/editGroupGrant.html" */ ?>
<?php /*%%SmartyHeaderCode:158075309658a2d8a5365a53-37444409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4462acf1474584051c8837abef53b07007e130ca' => 
    array (
      0 => './templates/system/editGroupGrant.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '158075309658a2d8a5365a53-37444409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'vo' => 0,
    'item' => 0,
    'item2' => 0,
    'item3' => 0,
    'item4' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a2d8a5594de',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a2d8a5594de')) {function content_58a2d8a5594de($_smarty_tpl) {?><form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=<?php echo $_GET['api'];?>
&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
<div class="pageContent" style="overflow-y:auto; overflow-x:auto;height: 430px;width: 1000px"> <!-- layoutH="68" -->
<input name="sub" type="hidden" value="1" />
<input name="id" type="hidden" value="<?php echo $_GET['id'];?>
" />
<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
<div style=" float:left;  margin:10px;  width:200px; height:300px;  border:solid 1px #CCC; background:#FFF;overflow-y:auto; overflow-x:auto;">

<h5 style="text-align: center;"><?php echo $_smarty_tpl->tpl_vars['vo']->value['top']['title'];?>
</h5>
<ul class="tree treeFolder treeCheck expand" oncheck="kkk">
 <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['vo']->value['son']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
        <li>
            <a tname="grantlist[]" tvalue="<?php echo $_smarty_tpl->tpl_vars['item']->value['key'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a>
		<ul>
                    <?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sondir']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value){
$_smarty_tpl->tpl_vars['item2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['item2']->key;
?>
            <li><a tname="grantlist[]" tvalue="<?php echo $_smarty_tpl->tpl_vars['item2']->value['key'];?>
"><?php echo $_smarty_tpl->tpl_vars['item2']->value['title'];?>
</a>
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['item3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item3']->_loop = false;
 $_smarty_tpl->tpl_vars['key3'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item2']->value['sonfunc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item3']->key => $_smarty_tpl->tpl_vars['item3']->value){
$_smarty_tpl->tpl_vars['item3']->_loop = true;
 $_smarty_tpl->tpl_vars['key3']->value = $_smarty_tpl->tpl_vars['item3']->key;
?>
                    <li><a tname="grantlist[]" tvalue="<?php echo $_smarty_tpl->tpl_vars['item3']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['item3']->value['checked']==1){?> checked="true" <?php }?>><?php echo $_smarty_tpl->tpl_vars['item3']->value['title'];?>
</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
       <?php  $_smarty_tpl->tpl_vars['item4'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item4']->_loop = false;
 $_smarty_tpl->tpl_vars['key4'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sonfunc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item4']->key => $_smarty_tpl->tpl_vars['item4']->value){
$_smarty_tpl->tpl_vars['item4']->_loop = true;
 $_smarty_tpl->tpl_vars['key4']->value = $_smarty_tpl->tpl_vars['item4']->key;
?>
            <li ><a tname="grantlist[]" tvalue="<?php echo $_smarty_tpl->tpl_vars['item4']->value['key'];?>
" <?php if ($_smarty_tpl->tpl_vars['item4']->value['checked']==1){?> checked="true" <?php }?>><?php echo $_smarty_tpl->tpl_vars['item4']->value['title'];?>
</a></li>
       <?php } ?>
        
                </ul>
	</li>
        <?php } ?>
	</ul>
</div>
<?php } ?>
</div>
<div class="formBar">
    <ul>
        <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
        <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
    </ul>
</div>
</form>
<script type="text/javascript">
function kkk(){
	var json = arguments[0], result="";
//	alert(json.checked);

	$(json.items).each(function(i){
		result += "<p>name:"+this.name + " value:"+this.value+" text: "+this.text+"</p>";
	});
	//$("#resultBox").html(result);
	
}
</script><?php }} ?>