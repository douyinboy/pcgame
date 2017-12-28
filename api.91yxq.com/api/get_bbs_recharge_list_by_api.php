<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.91yxq.com/api/get_bbs_recharge_list_by_api.php?url=http://demo.mocuz.com/
 */
//判断参数是否为空
if (trim($_GET['url']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

$where = '';
$pageWhere = '';
if (!empty($_GET['sync_date_start'])) {
    $where .= "o.sync_date>" . strtotime($_GET['sync_date_start']) . ' AND';
    $pageWhere .= "&sync_date_start=" . $_GET['sync_date_start'];
}
if (!empty($_GET['sync_date_end'])) {
    $where .= " o.sync_date<'" . strtotime($_GET['sync_date_end']) . "' AND";
    $pageWhere .= "&sync_date_end=" . $_GET['sync_date_end'];
}
$url = $_GET['url'];
$p = $_GET['p'];

//每页显示数
$num = 20;

//总记录数
$total = getBBSRechargeListTotal($url, $where, $mysqli);

//总页数
$pageCount = ceil($total / $num);

//规定页数显示范围
$p = max($p, 1);
$p = min($p, $pageCount);

$offset = ($p - 1) * $num;
$limit = 'LIMIT ' . $offset . ',' . $num;

$game_arr = getGameArr($mysqli);
list($order_arr, $_url) = getBBSRechargeList($url, $where, $limit, $mysqli);

$lastPage = $p - 1;
$lastPage = max($lastPage, 1);
$nextPage = $p + 1;
$nextPage = min($nextPage, $pageCount);

$url = $_SERVER['SCRIPT_NAME'] . "?url={$url}" . $pageWhere;
$page = '';
$page .= '<div class="currentPage">总计' . $total . '条&nbsp;&nbsp;当前第' . $p . '/' . $pageCount . '页</div>';
if ($p != 1) {
    $page .= "<a href='{$url}&p=1'>首页</a>";
    $page .= "<a href='{$url}&p={$lastPage}'>上一页</a>";
}

$from = $p - 5 > 1 ? $p - 5 : 1;
$to = $p + 5 < $pageCount ? $p + 5 : $pageCount;

for ($i = $from; $i <= $to; $i++) {
    if ($i == $p) {
        $page .= "<a class='default' href='javascript:;'>[{$i}]</a>";
    } else {
        $page .= "<a href='{$url}&p={$i}'>{$i}</a>";
    }
}
if ($p != $pageCount) {
    $page .= "<a href='{$url}&p={$nextPage}'>下一页</a>";
    $page .= "<a href='{$url}&p={$pageCount}'>末页</a>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>充值列表</title>
    <style type="text/css">
        table.gridtable {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }
        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
        .search {
            height: 20px;
            padding: 20px 0;
        }
        .page {
            width: 660px;
            margin: 0 auto;
            padding: 20px 0;
        }
        .page a {
            display: block;
            float: left;
            height: 15px;
            text-decoration: none;
            margin: 0 7px;
            text-align: center;
        }
        .page .default {
            cursor: default;
            color: #666;;
        }
        .page .currentPage {
            float: left;
        }
    </style>
    <script type="text/javascript" src="http://image.91yxq.com/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://image.91yxq.com/datewidget/laydate.dev.js"></script>
</head>
<body>
<div class="fire_wrap" style="width: 1000px; margin: 0 auto;">
    <div class="search">
        <form action="http://api.91yxq.com/api/get_bbs_recharge_list_by_api.php?" method="get">
            <input type="hidden" name="url" value="<?=$_url ?>">
            开始时间 <input type="text" name="sync_date_start" id="sync_date_start" value="<?=$_GET['sync_date_start'] ?>">
            开始时间 <input type="text" name="sync_date_end" id="sync_date_end" value="<?=$_GET['sync_date_end'] ?>">
            <input type="submit" value="搜索">
        </form>
    </div>
    <table width="100%" class="gridtable">
        <thead>
        <th>用户ID</th>
        <th>订单号</th>
        <th>用户名</th>
        <th>游戏用户名</th>
        <th>游戏/服务器</th>
        <th>充值金额</th>
        <th>充值时间</th>
        <th>订单状态</th>
        <th>游戏状态</th>
        </thead>
        <tbody>
        <?php if (!empty($order_arr)): ?>
            <?php foreach($order_arr as $val):
                $tableName = "pay_".$game_arr[$val['game']]['game_byname']."_log";
                $stat = getGameCoinState($tableName, $val['orderid'], $mysqli);
                ?>
                <tr align="center">
                    <td width="7%"><?=$val['uid'] ?></td>
                    <td width="15%"><?=$val['orderid'] ?></td>
                    <td width="10%"><?=$val['bbs_username'] ?></td>
                    <td width="10%"><?=$val['user'] ?></td>
                    <td width="15%"><?=$game_arr[$val['game']]['name'] ?>【双线<?=$val['server'] ?>服】</td>
                    <td width="8%"><?=$val['money'] ?></td>
                    <td width="15%"><?=date('Y-m-d H:i:s', $val['sync_date']) ?></td>
                    <td width="10%">充值成功</td>
                    <td width="10%"><?php if ($stat): ?>充值成功<?php else: ?>充值失败<?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="page">
        <?=$page?>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    laydate({
        elem: '#sync_date_start', //dom
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义
        festival: true, //显示节日
        istime: true //显示时间
    });
    laydate({
        elem: '#sync_date_end', //dom
        format: 'YYYY-MM-DD hh:mm:ss', // 分隔符可以任意定义
        festival: true, //显示节日
        istime: true //显示时间
    });
</script>

