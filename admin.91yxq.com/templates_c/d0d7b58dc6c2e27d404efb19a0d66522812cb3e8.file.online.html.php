<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:28
         compiled from "./templates/sysmanage/online.html" */ ?>
<?php /*%%SmartyHeaderCode:74015356256a32befe26845-63572882%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0d7b58dc6c2e27d404efb19a0d66522812cb3e8' => 
    array (
      0 => './templates/sysmanage/online.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74015356256a32befe26845-63572882',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56a32befe6c8c',
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
<?php if ($_valid && !is_callable('content_56a32befe6c8c')) {function content_56a32befe6c8c($_smarty_tpl) {?><script type="text/javascript" >
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
各游戏注册统计',
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
                    text: '注册（人）'
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
                    this.x +': '+ this.y +'人';
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