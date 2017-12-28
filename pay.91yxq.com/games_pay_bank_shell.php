<?php
include(__DIR__ . '/include/config.inc.php');

include(__DIR__ .  'config/pay_bank.inc.php');

$tmp = array();
$sql="SELECT * FROM  `pay_bank` ORDER BY `bank_count` DESC , `bank_name` ASC";
$qu=mysql_query($sql);
while ($re=mysql_fetch_array($qu)) {
	$tmp[$re['id']]=$re['bank_name'];
}

$str = '<?php $pay_bank = array(\'99bill_bank\'=>array(';

foreach ($tmp as $key => $value) {
	$str .= ('\''.$value.'\'=>\''.$pay_bank['99bill_bank'][$value].'\',');
}

$str .= '));';

file_put_contents(__DIR__ . '/config/pay_bank.inc.php',$str);


