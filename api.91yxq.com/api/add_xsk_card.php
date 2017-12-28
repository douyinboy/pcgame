<?php
require('../include/config.inc.php');
require('../include/configApi.php');


$file = fopen("xsk.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
//feof() check if file read end EOF
while(!feof($file))
{
    //fgets() Read row by row
    $row = fgets($file);
    $sql = "INSERT INTO 91yxq_plat.card_rxhw (card_id) VALUES('" . $row . "')";
    $mysqli->query($sql);
}
fclose($file);








