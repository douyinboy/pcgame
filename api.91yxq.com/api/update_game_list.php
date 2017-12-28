<?php
$sign=trim($_GET['sign']);
$gl=trim($_GET['gl']);
if(!$gl || !$sign){ echo 'value error'; exit; }
if($sign!=md5('h@#a$%o^&D*(o!)n*#g')){ echo 'sign error'; exit; }
$str="<?php \$game_list_str='".$gl."'; ?>";
file_put_contents(substr(__DIR__, 0, -3) . 'include/games_str.php',$str);
?>
