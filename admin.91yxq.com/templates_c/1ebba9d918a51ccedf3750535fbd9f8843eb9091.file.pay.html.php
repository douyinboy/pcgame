<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 10:16:59
         compiled from ".\templates\sysmanage\pay.html" */ ?>
<?php /*%%SmartyHeaderCode:1634558a50b9ba1d632-91871256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ebba9d918a51ccedf3750535fbd9f8843eb9091' => 
    array (
      0 => '.\\templates\\sysmanage\\pay.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1634558a50b9ba1d632-91871256',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'datetime' => 0,
    'H' => 0,
    'data' => 0,
    'vo' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a50b9ba63b4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a50b9ba63b4')) {function content_58a50b9ba63b4($_smarty_tpl) {?><script type="text/javascript" >
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