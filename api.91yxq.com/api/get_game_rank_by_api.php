<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_rank_by_api.php
 */


$params = [
    'merid' => 23470,
];

header('Location: http://api.91yxq.com/api/bengbeng/get_reward_by_api.php?idCode='.$params['merid'].'&gid=3');