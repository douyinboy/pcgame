<?php
$sign=trim($_GET['sign']);
$gl=trim($_GET['gl']);
if(!$gl || !$sign){ echo 'value error'; exit; }
if($sign!=md5('asdf')){ echo 'sign error'; exit; }
$str="<?php \$game_list_str='".$gl."'; ?>";
file_put_contents(__DIR__ . '/games_str.php',$str);
