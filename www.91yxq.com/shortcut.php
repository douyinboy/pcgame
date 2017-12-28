<?php
$Shortcut = "[InternetShortcut]
URL=http://www.demo.com/
IDList=
IconFile=http://www.demo.com/favicon.ico
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2
";
Header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=91yxq游戏.url;");
echo $Shortcut;
