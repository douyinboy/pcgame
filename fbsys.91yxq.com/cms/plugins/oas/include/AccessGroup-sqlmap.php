<?php
$_sqlMap_select = array(
				"getOasInfo" => "select * from ".$db_config['table_pre']."plugin_oas_setting ",
				"getAccessInfoByGroupID" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access where OwnerID=#GroupID# AND AccessType=1 ",
				"getAccessInfoByAccessID" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access where AccessID=#AccessID#",
				"getAllPermission" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_permission ORDER BY OrderKey ",
				"getAccessMapByAccessID" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access_map where AccessID=#AccessID#"
);
$_sqlMap_insert = array(
				"addAccess" => array(
								"table" => $db_config['table_pre']."plugin_oas_access"
				),
				"addAccessMap" => array(
								"table" => $db_config['table_pre']."plugin_oas_access_map"
				)
);
$_sqlMap_update = array(
				"updateAccess" => array(
								"table" => $db_config['table_pre']."plugin_oas_access",
								"where" => "AccessID='#AccessID#'"
				)
);
$_sqlMap_delete = array(
				"user" => array(
								"table" => $db_config['table_pre']."_user",
								"where" => "UserID=#UserID# AND UserName=#UserName#",
								"sql" => "delete from ".$db_config['table_pre']."_user where UserID=#UserID# "
				),
				"delAccess" => array(
								"table" => $db_config['table_pre']."plugin_oas_access",
								"where" => "AccessID='#AccessID#'"
				),
				"delAccessMap" => array(
								"table" => $db_config['table_pre']."plugin_oas_access_map",
								"where" => "AccessID='#AccessID#'"
				)
);
?>
