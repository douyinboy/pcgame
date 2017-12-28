<?php

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n\r\n<html>\r\n\r\n<head>\r\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n<title>CMSware TempLates Maker By LanMV.COM</title>\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"slides.css\" />\r\n<script type=\"text/javascript\" src=\"js/compressed/xmlhttprequest.js\"></script>\r\n<script type=\"text/javascript\" src=\"js/compressed/full/phprpc_client.js\"></script>\r\n<script type=\"text/javascript\">\r\nphprpc_client.create('rpc');\r\n\r\nrpc.onready = function () {\r\n    rpc.done.ref = true;\r\n}\r\n\r\nrpc.use_service('ctlm.php');\r\nrpc.encrypt = 0;\r\n\r\nrpc.done_callback = function (result, args) {\r\n    if (result instanceof phprpc_error) {\r\n        alert(result.errstr);\r\n    }\r\n    else {\r\n        document.getElementById('ctlm').value = result;\r\n    }\r\n    return true;\r\n}\r\n\r\nwindow.onload = function () {\r\n    var done = document.getElementById('done');\r\n    done.onclick = function () {\r\n        var a = document.getElementById('a').value;\r\n        var b = document.getElementById('b').value;\r\n        var c = document.getElementById('c').value;\r\n        var d = document.getElementById('d').value;\r\n        var e1 = document.getElementById('e1').value;\r\n        var f = document.getElementById('f').value;\r\n        var g = document.getElementById('g').value;\r\n        var h = document.getElementById('h').value;\r\n        var i = document.getElementById('i').value;\r\n        var j = document.getElementById('j').value;\r\n        var k = document.getElementById('k').value;\r\n        var l = document.getElementById('l').value;\r\n        var m = document.getElementById('m').value;\r\n        if (rpc.ready) {\r\n            rpc.done(a, b, c, d, e1, f, g, h, i, j, k, l, m);\r\n        }\r\n        else {\r\n            alert('本程序不可本地运行,请上传至服务器CMSware根目录!');\r\n        }\r\n    }\r\n}\r\nfunction oCopy(obj){ \r\nobj.select(); \r\njs=obj.createTextRange(); \r\njs.execCommand(\"Copy\")\r\n} \r\n</script>\r\n</head>\r\n\r\n<body>\r\n<div style=\"width: 100%;\" align=\"center\">\r\n<div id=\"presentation-title\">CMSware TempLates Maker</div>\r\n<div id=\"slide-number\">V.1.0.5 <a href=\"mailto:lanmv@126.com\" style=\"color=#d7d7d7;\" title=\"联系我们...\">[ Contact ]</a></div>\r\n";
require_once( "../config.php" );
global $tplURl;
global $sql;
global $requite;
if ( !mysql_connect( "localhost", $db_config['db_user'], $db_config['db_password'] ) )
{
	exit( "Could not connect: ".mysql_error( ) );
}
if ( !mysql_select_db( $db_config['db_name'] ) )
{
	exit( "Could not connect: ".mysql_error( ) );
}
if ( empty( $_POST['TableID'] ) )
{
	$GLOBALS['_POST']['TableID'] = 1;
}
$sql = "SET NAMES utf8;";
mysql_query( $sql );
echo "<div id=\"slide-content\">\r\n<h1>Pleace Select Options ...</h1>\r\n\t\t\t<h2>Making TempLates Now ...</h2>\r\n\t\t\t<br />\r\n\t\t\t<form action=\"index.php\" name=\"Table\" method=\"post\">\t\t\t<p>\r\n\t\t\t准备生成 \r\n\t\t\t<select id=\"a\">\r\n\t\t\t\t<option value=\"1\">内容列表[CMS_LIST]</option>\r\n\t\t\t\t<option value=\"2\">搜索调用[CMS_SEARCH]</option>\r\n\t\t\t\t<option value=\"3\">内容调用[CMS_CONTENT]</option>\r\n\t\t\t\t<option value=\"4\">数据库调用[CMS_SQL]</option>\r\n\t\t\t</select>\r\n\r\n\t\t\t结点ID \r\n\t\t\t<select id=\"b\">\r\n\t\t\t";
$sqlSite = "SELECT NodeID,TableID,NodeType,Name FROM `".$db_config['table_pre']."site` WHERE NodeType = 1 and TableID = ".$_POST['TableID'];
$resultSite = mysql_query( $sqlSite );
while ( $rowTable = mysql_fetch_array( $resultSite, MYSQL_NUM ) )
{
	printf( "<option value=\"%s\" /> %s[%s] \n", $rowTable[0], $rowTable[3], $rowTable[0] );
}
mysql_free_result( $resultSite );
echo "\t\t\t</select>\r\n\t\t\t\r\n\t\t\t内容模型 \r\n\t\t\t<select name=\"TableID\" id=\"c\">\r\n\t\t\t";
$sqlTable = "SELECT TableID,Name FROM `".$db_config['table_pre']."content_table`";
$resultTable = mysql_query( $sqlTable );
while ( $rowTable = mysql_fetch_array( $resultTable, MYSQL_NUM ) )
{
	printf( "<option value=\"%s\" /> %s[%s] \n", $rowTable[0], $rowTable[1], $rowTable[0] );
}
mysql_free_result( $resultTable );
echo "\t\t\t</select>\r\n\t\t\t\r\n\t\t\t列表数 \r\n\t\t\t<input type=\"text\" id=\"d\" value=\"10\" maxlength=\"2\" size=\"3\" onclick=\"this.value=''\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" />\r\n\t\t\t\r\n\t\t\t分页:\r\n\t\t\t<select id=\"e1\"><option value=\"1\">屏蔽分页</option><option value=\"2\">静态分页</option><option value=\"3\">动态分页</option></select>\r\n\t\t\t\r\n\t\t\t<br />\r\n\t\t\t内容ID \r\n\t\t\t<input type=\"text\" id=\"f\" value=\"多个IndexID请用','隔开\" title=\"如果您要生成 内容调用[CMS_CONTENT] 代码,请在此处输入准备调用的内容ID ...\" onclick=\"this.value=''\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" />\r\n\r\n\t\t\tWhere条件 \r\n\t\t\t<input type=\"text\" id=\"h\" value=\"\" title=\"在生成 内容列表[CMS_LIST] 时,如果需要添加条件限制,请在此处输入条件语句 ...\" size=\"55\" onclick=\"this.value=''\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" /> 如:c.Photo!=''\r\n\r\n\t\t\t<br />\r\n\t\t\treturnKey字段设置 \r\n\t\t\t<select name=\"l\">\r\n\t\t\t<option value=\"1\" selected>启用</option>\r\n\t\t\t<option value=\"2\">不启用</option>\r\n\t\t\t</select>\r\n\t\t\t<input type=\"text\" id=\"k\" value=\"Title,Author\" title=\"在这里设置返回字段名称,多字段请用\",\"分割...\" onclick=\"this.value=''\" size=\"50\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" />\r\n\t\t\t通过设置此字段可减少数据库负载。\r\n\t\t\t\r\n\t\t\t<br />\r\n\t\t\tSQL语句 \r\n\t\t\t<input type=\"text\" id=\"g\" value=\"这里可以输入MySQL的SQL语句.\" title=\"当您选择 数据库调用[CMS_SQL] 生成标签时,请在此处输入SQL查询语句 ...\" onclick=\"this.value=''\" size=\"100\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" />\r\n\r\n\r\n\t\t\t<br />\r\n      数组名 \r\n\t\t\t<input type=\"text\" id=\"i\" value=\"Default\" title=\"您在这里可以自定义CMSware标签调用返回数组的名字...\" onclick=\"this.value=''\" size=\"10\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" />\r\n\r\n\r\n\t\t\t内容排序设置\r\n\t\t\t<select id=\"j\">\r\n\t\t\t<option value=\"Dis\" selected>不启用Orderby排序</option>\r\n\t\t\t<option value=\"Hits_Today\">按照今日点击数排序</option>\r\n\t\t\t<option value=\"Hits_Week\">按照本周点击数排序</option>\r\n\t\t\t<option value=\"Hits_Month\">按照本月点击数排序</option>\r\n\t\t\t<option value=\"Hits_Date\">按照最新访问时间排序</option>\r\n\t\t\t<option value=\"CommentNum\">按照评论总数排序</option>\r\n\t\t\t<option value=\"Hits_Total\">按照总点击数排序</option>\r\n\t\t\t<option value=\"rand()\">随机调用排序</option>\r\n\t\t\t</select>\r\n\t\t\t\r\n\t\t\t排序设置(Order)\r\n\t\t\t<select id=\"m\" title=\"Order排序设置...\">\r\n\t\t\t<option value=\"Dis\">不启用Order</option>\r\n\t\t\t<option value=\"ASC\">正序(ASC)</option>\r\n\t\t\t<option value=\"DESC\">倒序(DESC)</option>\r\n\t\t\t</select>\r\n\r\n\t\t\t字段设置\r\n\t\t\t<select name=\"NotVar\">\r\n\t\t\t<option value=\"1\">添加\"\$var\"前缀</option>\r\n\t\t\t<option value=\"2\" selected>不加\"\$var\"前缀</option>\r\n\t\t\t</select>\r\n\t\t\t</p>\r\n\r\n\t\t\t<p>\r\n\t\t\t<input type=\"button\" id=\"done\" value=\"[ 生 成 模 版 标 签 ]\" style=\"background-color:#F1F1F1;width:460;height:40px;cursor:hand;\" />\r\n\t\t\t\r\n\t\t\t<input type=\"submit\" id=\"GetTable\" value=\"[ 获 取 模 型 字 段 ]\" style=\"background-color:#F1F1F1;width:460;height:40px;cursor:hand;\" /></form>\t\t\t\r\n\t\t\t<div id=\"ShowTable\" style=\"width: 788px; text-align: left;\">\r\n\t\t\t";
$sqlField = "SELECT FieldOrder,TableID,FieldName,FieldTitle FROM `".$db_config['table_pre']."content_fields` WHERE TableID = ".$_POST['TableID']." Order By FieldOrder ASC";
$resultField = mysql_query( $sqlField );
while ( $rowField = mysql_fetch_array( $resultField, MYSQL_NUM ) )
{
	$rowField[0] = $rowField[0] + 1;
	if ( $_POST['NotVar'] != 1 )
	{
		$Notvar = "\$";
	}
	else
	{
		$Notvar = "\$var.";
	}
	printf( "%s. %s <input name=\"f%s\" value=\"[".$Notvar."%s]\" title=\"点击复制本字段...\" onclick=\"oCopy(this)\" onMouseOver=\"this.focus()\" onFocus=\"this.select()\" readonly=\"readonly\" /> \n", $rowField[0], $rowField[3], $rowField[0], $rowField[2] );
}
mysql_free_result( $resultField );
echo "\t\t\t</div>\r\n\t\t\t<br />\r\n\t\t\t<p>\r\n\t\t\t<h2>CMSware TempLates Codes ...</h2>\r\n\t\t\t<textarea id=\"ctlm\" title=\"此处是CMSware模版代码的生成窗口, Ctrl+A 可复制内容代码 ...\" rows=\"12\" cols=\"108\" onMouseOver=\"this.focus()\" onBlur=\"if (value ==''){value='Not Code ...'}\" onFocus=\"this.select()\"></textarea>\r\n\t\t\t<br />\r\n\t\t\t</p>\r\n\t\t\t\r\n</div>\r\n\r\n<div id=\"footer\">\r\n<a href=\"http://www.lanmv.com\" title=\"蓝慕威科技\">LanMV.COM</a>\r\n</div>\r\n</div>\r\n</body>\r\n\r\n</html>";
?>
