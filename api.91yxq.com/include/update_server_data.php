<?php

$time=$_POST['time'];
$sign=$_POST['sign'];

if ($sign != md5($time.'asdf')) {
    exit('sign error');
}

$gameData = $_POST['gameData'];

$filename = __DIR__ . '/games_str.php';

if(! empty($gameData)) {

	 $str='<?php

     $game_list_str=\''.$gameData.'\';

    ?>';

    file_put_contents($filename, $str);
}
exit($str);
