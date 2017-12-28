<?php

	$userid = $_POST["UserId"];//用户ID（www.yzch.net获取）
	$orderid =  $_POST["OrderId"];//用户订单号（必须唯一）
	$money =  $_POST["Money"];//订单金额
	$bankid =  $_POST["BankId"];//银行ID（见文档）
	$keyvalue =  $_POST["Key"];//用户key（www.yzch.net获取）
	$reutrn_url =  $_POST["Url"];//用户接收返回URL连接
	$ext =  $_POST["Ext"];
	$submiturl = $_POST["JumpUrl"];
	$sign = "userid=".$userid."&orderid=".$orderid."&bankid=".$bankid."&keyvalue=".$keyvalue;
	$sign2 = "money=".$money."&userid=".$userid."&orderid=".$orderid."&bankid=".$bankid."&keyvalue=".$keyvalue;
	$sign = md5($sign);//签名数据 32位小写的组合加密验证串
	$sign2 = md5($sign2);//签名数据2 32位小写的组合加密验证串
	$url=$submiturl."?userid=".$userid."&orderid=".$orderid."&money=".$money."&url=".$reutrn_url."&bankid=".$bankid."&sign=".$sign."&ext=".$ext."&sign2=".$sign2;

	header('Location:'.$url);

?>