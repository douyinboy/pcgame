<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.91yxq.com/api/get_bbs_member_list_by_api.php?url=http://demo.mocuz.com/
 */
//判断参数是否为空
if (trim($_GET['url']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

$where = '';
$pageWhere = '';
if (!empty($_GET['uid'])) {
    $where .= "uid=" . $_GET['uid'] . ' AND';
    $pageWhere .= "&uid=" . $_GET['uid'];
}
if (!empty($_GET['user_name'])) {
    $where .= " user_name='" . $_GET['user_name'] . "' AND";
    $pageWhere .= "&user_name=" . $_GET['user_name'];
}
if (!empty($_GET['state'])) {
    $pageWhere .= "&state=" . $_GET['state'];
}
$url = $_GET['url'];
$p = $_GET['p'];

//每页显示数
$num = 20;

//总记录数
$total = getBBSListTotal($url, $where, $mysqli);

//总页数
$pageCount = ceil($total / $num);

//规定页数显示范围
$p = max($p, 1);
$p = min($p, $pageCount);

$offset = ($p - 1) * $num;
$limit = 'LIMIT ' . $offset . ',' . $num;

list($list, $_url) = getBBSList($url, $where, $limit, $mysqli);

$lastPage = $p - 1;
$lastPage = max($lastPage, 1);
$nextPage = $p + 1;
$nextPage = min($nextPage, $pageCount);

$url = $_SERVER['SCRIPT_NAME'] . "?url={$url}" . $pageWhere;
$page = '';
$page .= '<div class="currentPage">当前第' . $p . '/' . $pageCount . '页</div>';
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
    <title>会员管理</title>
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

</head>
<body>
<div class="fire_wrap" style="width: 1000px; margin: 0 auto;">
    <div class="search">
        <form action="http://api.91yxq.com/api/get_bbs_member_list_by_api.php?" method="get">
            <input type="hidden" name="url" value="<?=$_url ?>">
            UID <input type="text" name="uid" value="<?=$_GET['uid'] ?>">
            用户名 <input type="text" name="user_name" value="<?=$_GET['user_name'] ?>">
            状态 <select name="state" id="">
                <option value="">请选择...</option>
                <option value="1" <?php if (isset($_GET['state']) && $_GET['state'] == 1): ?>selected<?php endif; ?>>正常</option>
                <option value="2" <?php if (isset($_GET['state']) && $_GET['state'] == 2): ?>selected<?php endif; ?>>异常</option>
            </select>
            <input type="submit" value="搜索">
        </form>
    </div>
    <table width="100%" class="gridtable">
        <thead>
        <th>用户ID</th>
        <th>用户名</th>
        <th>游戏用户名</th>
        <th>注册时间</th>
        <th>状态</th>
        </thead>
        <tbody>
        <?php if (!empty($list)): ?>
            <?php foreach ($list as $val): ?>
                <tr align="center">
                    <td width="10%"><?=$val['uid'] ?></td>
                    <td width="20%"><?=$val['user_name'] ?></td>
                    <td width="30%"><?=$val['bbs_username'] ?></td>
                    <td width="30%"><?=date('Y-m-d H:i:s', $val['reg_time']) ?></td>
                    <td width="10%">正常</td>
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


