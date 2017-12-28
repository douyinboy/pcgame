<?php
$act= $_GET['act'];
if($act == '99bill_bank'){ 

	include __DIR__ . '/config/pay_bank.inc.php';
	
	$dfbank = $_COOKIE['dfbank'];
	$html = "<dl>";
	$size = 0;
	$maxsize=12;
	! $dfbank && $dfbank = 'icbc';
	$flage = '';
	if($pay_bank['99bill_bank'][$dfbank]){
		$html .= "<dd class=\"option_on\"><i class=\"imgpq\"></i><font id=\"$dfbank\"></font><span class=\"bankimg bank_$dfbank\"></span></dd>";
	}else{
		$flage = " checked='checked'";
	}
	
	foreach ($pay_bank['99bill_bank'] as $key => $value) {
		if($dfbank!=$key){
			$html .= "<dd class=\"\"><i class=\"imgpq\"></i><font id=\"$key\"></font><span class=\"bankimg bank_$key\"></span></dd>";
		}
		$size ++;
		if($size==$maxsize){
			$html .= "</dl><dl style='display:none' id='morebank'>";
		}
		if($flage){
			$flage='';
		}
	}
	$html .= '</dl>';
	echo $html;
 } ?>