<?php
$table_header =& $db_config['table_pre'];
$install_sql = "CREATE TABLE {$table_header}plugin_oas_access (\r\n  `AccessID` int(10) NOT NULL auto_increment,\r\n  `AccessType` tinyint(1) default '1',\r\n  `OwnerID` int(10) default NULL,\r\n  `AccessInherit` text,\r\n  `Info` text,\r\n  PRIMARY KEY  (`AccessID`),\r\n  UNIQUE KEY `AccessID` (`AccessID`)\r\n) TYPE=MyISAM;\r\n\r\nCREATE TABLE {$table_header}plugin_oas_setting (\r\n  `key` varchar(32) NOT NULL default '',\r\n  `value` text NOT NULL,\r\n  PRIMARY KEY  (`key`)\r\n) TYPE=MyISAM;\r\n\r\nCREATE TABLE {$table_header}plugin_oas_sessions (\r\n  `sId` varchar(32) NOT NULL default '',\r\n  `UserName` varchar(32) NOT NULL default '',\r\n  `UserID` int(8) NOT NULL default '0',\r\n  `GroupID` int(8) default NULL,\r\n  `LogInTime` int(10) NOT NULL default '0',\r\n  `RunningTime` int(10) NOT NULL default '0',\r\n  `Ip` varchar(16) NOT NULL default '',\r\n  `SessionData` blob,\r\n  PRIMARY KEY  (`sId`)\r\n) TYPE=MyISAM;\r\n\r\nCREATE TABLE {$table_header}plugin_oas_permission (\r\n  `PermissionKey` varchar(32) NOT NULL default '',\r\n  `PermissionInfo` varchar(250) NOT NULL default '',\r\n  `Reserved` tinyint(1) default '0',\r\n  `OrderKey` int(5) NOT NULL default '0',\r\n  PRIMARY KEY  (`PermissionKey`),\r\n  UNIQUE KEY `PermissionKey` (`PermissionKey`)\r\n) TYPE=MyISAM;\r\n\r\nCREATE TABLE {$table_header}plugin_oas_access_map (\r\n  `AccessID` int(10) NOT NULL default '0',\r\n  `PermissionKey` varchar(32) NOT NULL default '',\r\n  `AccessNodeIDs` text,\r\n  PRIMARY KEY  (`AccessID`,`PermissionKey`)\r\n) TYPE=MyISAM;\r\n\r\nCREATE TABLE {$table_header}plugins_oas_user (\r\n  `UserID` int(11) NOT NULL auto_increment,\r\n  `UserName` varchar(32) NOT NULL,\r\n  PRIMARY KEY (`UserID`)\r\n) TYPE=MyISAM;\r\n\r\nINSERT INTO {$table_header}plugin_oas_permission VALUES ('ReadIndex', '��ҳ���', 1, 0);\r\nINSERT INTO {$table_header}plugin_oas_permission VALUES ('ReadContent', '����ҳ���', 1, 0);\r\nINSERT INTO {$table_header}plugin_oas_permission VALUES ('PostComment', '��������', 1, 0);\r\nINSERT INTO {$table_header}plugin_oas_permission VALUES ('ReadComment', '�鿴����', 1, 0);\r\n\r\n\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_Address', 'http://passport/soap.php');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_TransactionAccessKey', '1234');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_RootURL', 'http://passport');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('OAS_RootURL', 'http://cmsware/oas');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_SessionActiveTime', '1800');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_AdminUserName', 'hawking');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_AdminPassword', 'a');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_SelfAdminURL', '');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('CWPS_SelfIndexURL', '');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('AccessDenyTpl', '/oas/access_deny.html');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('IndexPageCacheTime', '1800');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('ContentPageCacheTime', '86400');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_enableComment', '1');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_enableCommentApprove', '0');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_Tpl', '/oas/comment/comment.html');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_contentMinLength', '3');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_contentMaxLength', '1000');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_filterMode', '0');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_replaceWord', '*');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_filterWords', 'fuck,shit,��,���');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_PageNum', '15');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_EnableDisplayCache', '1');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('Comment_HiddenCommentIP', '1');\r\nINSERT INTO {$table_header}plugin_oas_setting VALUES ('EnableCacheUseSubDirs', '1');\r\n";
$result = plugin_runquery( $install_sql );
?>