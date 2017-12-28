<?php
$_sqlMap_select = array(
				"getOasInfo" => "select * from ".$db_config['table_pre']."plugin_oas_setting",
				"getAccessInfoByUserID" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access where OwnerID=#UserID# AND AccessType=0 ",
				"getAccessInfoByAccessID" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access where AccessID=#AccessID#",
				"getRecordNum" => "SELECT count(*) nr FROM ".$db_config['table_pre']."plugin_oas_access where AccessType=0",
				"getRecordLimit" => "SELECT * FROM ".$db_config['table_pre']."plugin_oas_access WHERE AccessType=0 Limit #start#, #offset# ",
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
