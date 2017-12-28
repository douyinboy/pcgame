<?php
require("../include/config.inc.php");
require("../include/function.php");
require("email.class.php");

//$m=new m;
$rt=true;
$time=time();
while($rt){

	if(time()-$time>=28000){
		$time=time();
	}


   $row=mysql_query("SELECT * FROM 91yxq_sendmail WHERE 1 order by time");
	while($rs=mysql_fetch_array($row))
	{
		$mailInfo['emailAddr'] = $rs['mail'];
        $mailInfo['subject'] = '=?UTF-8?B?'.base64_encode($rs['mail_title']).'?=';//解决标题乱码问题
        $mailInfo['message'] = $rs['mail_info'];
        $smtp->sendmail($mailInfo['emailAddr'], $smtpusermail, $mailInfo['subject'], $mailInfo['message'], $mailtype);
		mysql_query("DELETE FROM `91yxq_sendmail` WHERE `id`=".$rs['id']);
	}


	//ss($mem);
	ob_flush();//释放缓存

	flush(); //将不再缓存里的数据发送到浏览器去

	sleep(15);
}

?>
