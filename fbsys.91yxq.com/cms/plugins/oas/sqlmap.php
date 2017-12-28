<?php
$_sqlMap_select = array(
				"getOasInfo" => "select * from ".$db_config['table_pre']."plugin_oas_setting ",
				"getAllPermission" => "select * from ".$db_config['table_pre']."plugin_oas_permission ",
				"getPermissionInfo" => "select * from ".$db_config['table_pre']."plugin_oas_permission where PermissionKey='#PermissionKey#'"
);
$_sqlMap_insert = array(
				"user" => array(
								"table" => $db_config['table_pre']."_user",
								"sql" => "insert into ".$db_config['table_pre']."plugin_oas_setting values(#UserName#)"
				),
				"addPermission" => array(
								"table" => $db_config['table_pre']."plugin_oas_permission"
				)
);
$_sqlMap_update = array(
				"updateOasInfo" => array(
								"table" => $db_config['table_pre']."plugin_oas_setting",
								"sql" => "update ".$db_config['table_pre']."_user set UserName=#UserName# where UserID=#UserID#"
				)
);
$_sqlMap_delete = array(
				"user" => array(
								"table" => $db_config['table_pre']."_user",
								"where" => "UserID=#UserID# AND UserName=#UserName#",
								"sql" => "delete from ".$db_config['table_pre']."_user where UserID=#UserID# "
				),
				"delPermission" => array(
								"table" =>$db_config['table_pre']."plugin_oas_permission",
								"where" => "PermissionKey='#PermissionKey#'"
				),
				"delAccessMap" => array(
								"table" => $db_config['table_pre']."plugin_oas_access_map",
								"where" => "PermissionKey='#PermissionKey#'"
				)
);
?>
