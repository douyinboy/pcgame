<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:29
         compiled from "./templates/sysmanage/pay.html" */ ?>
<?php /*%%SmartyHeaderCode:164110299056cfef0521b913-29114020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6afcb8a001cf8fd5348b8e25cd8e17ae25c3947a' => 
    array (
      0 => './templates/sysmanage/pay.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '164110299056cfef0521b913-29114020',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cfef0525cff',
  'variables' => 
  array (
    'datetime' => 0,
    'H' => 0,
    'data' => 0,
    'vo' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cfef0525cff')) {function content_56cfef0525cff($_smarty_tpl) {?><script type="text/javascript" >
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'jbsxBox',
                defaultSeriesType: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '<?php echo $_smarty_tpl->tpl_vars['datetime']->value;?>
各游戏充值统计',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: 10
            },
            xAxis: {
                categories: [<?php echo $_smarty_tpl->tpl_vars['H']->value;?>
]
            },
            yAxis: {
                title: {
                    text: '充值（元）'
                },
                plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y +'元';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [
        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            {
                name: '<?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
',
                data: [<?php echo $_smarty_tpl->tpl_vars['row']->value[$_smarty_tpl->tpl_vars['vo']->value['id']];?>
]
            }, 
        <?php } ?>
            ]
        });
    });
</script><?php }} ?>