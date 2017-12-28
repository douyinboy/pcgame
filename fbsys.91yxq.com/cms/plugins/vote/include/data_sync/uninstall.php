<?php

$table_header =& $db_config['table_pre'];
$uninstall_sql = "DROP TABLE {$table_header}plugin_vote_ipaddress;\r\nDROP TABLE {$table_header}plugin_vote_option;\r\nDROP TABLE {$table_header}plugin_vote_title;";
$result = plugin_runquery( $uninstall_sql );
?>
