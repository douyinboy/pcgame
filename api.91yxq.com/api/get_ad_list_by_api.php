<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_ad_list_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
//$sign = $_GET['sign'];
//unset($_GET['sign']);
//if ($sign != getSign($_GET, SECRET_KEY)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$adList = getAdList($mysqli);

//echo "<pre>";
//var_dump($data);die;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>广告位</title>
    <link rel="stylesheet" type="text/css" href="css/fire_index.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
</head>
<body>
<div class="fire_wrap" style="width: 1000px; margin: 0 auto;">
    <table width="100%">
        <thead>
            <th>ID</th>
            <th>位置预览</th>
            <th>广告类别/尺寸</th>
            <th>广告代码</th>
        </thead>
        <tbody>
            <?php if (!empty($adList)): ?>
            <?php foreach ($adList as $val): ?>
            <tr align="center">
                <td width="5%"><?php echo $val['id'];?></td>
                <td width="25%"><img style="width: 200px;" src="http://demo.cc/<?php echo $val['position_pic'] ?>" alt=""></td>
                <td width="25%"><?php echo $val['ad_name'] ?></td>
                <td width="40%">
                    <textarea name="" id="" cols="60" rows="5">
                        <script type="text/javascript" src="http://api.demo.com/api/get_ad_content_by_api.php?id=<?php echo $val['id'];?>"></script>
                    </textarea>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>


