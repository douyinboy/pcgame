<?php
require('../include/config.inc.php');
require('../include/configApi.php');
/**
 * api.91yxq.com\api\auto_add_server.php
 */
//$content_count = 0;
//$update_count = 0;
//$index_count = 0;
//for ($i = 1; $i <= 31; $i++) {
////    $time = time();
//    $time = strtotime('2017-08-15');
//    $serverName = '双线' . $i .'服';
////    $date = date('Y-m-d');
//    $date = '2017-08-15';
//    $sql = "INSERT INTO " . PUBLISH . "." . CONTENT_6 . " (`CreationDate`, `ModifiedDate`, `CreationUserID`, `LastModifiedUserID`, `PlatformId`, `GameId`, `ServerId`, `ServerName`, `MergeId`, `OpenDate`, `OpenTime`, `ServerStatus`, `ServerShow`) VALUES (" . $time . ", " . $time . ", 1, 1, 1, 20, " . $i . ", '" . $serverName . "', 0, " . "'" . $date ."', '14:00', 3, 3)";
//
//    if ($mysqli->query($sql)) {
//        $content_count++;
//        $contentId = $mysqli->insert_id;
//        $time = time();
//        $sql = "INSERT INTO " . PUBLISH . "." . CONTENT_INDEX . " (`ContentID`, `NodeID`, `TableID`, `PublishDate`) VALUES (" . $contentId . ", 407, 6, " . $time . ")";
//        if ($mysqli->query($sql)) {
//            $index_count++;
//            $id = $mysqli->insert_id;
//            $sql = "UPDATE " . PUBLISH . "." . CONTENT_INDEX . " SET ParentIndexID=" . $id . " WHERE IndexID=" . $id;
//            if ($mysqli->query($sql)) {
//                $update_count++;
//            } else {
//                doLog($serverName . '写入失败!', 'update_content_index');
//            }
//        } else {
//            doLog($serverName . '写入失败!', 'content_index');
//        }
//    } else {
//        //doLog($log,$filename)
//        doLog($serverName . '写入失败!', 'content_6');
//    }
//}
//
//exit('程序执行结束!content表:' . $content_count . '----index表:' . $index_count . '----index修改:' . $update_count);


$content_count = 0;
for ($i = 2; $i < 31; $i++) {
    $serverName = '双线' . $i .'服';
    $date = date('Y-m-d');
    $sql = "INSERT INTO " . PAYDB . "." . SERVERLIST . " (`server_id`, `name`, `game_id`, `pay_url`, `is_open`, `create_date`) VALUES (" . $i . ", '" . $serverName . "', 20, 'http://pay.91yxq.com', 1, '2017-08-15 14:00:00')";

    if ($mysqli->query($sql)) {
        $content_count++;
    } else {
        //doLog($log,$filename)
        doLog($serverName . '写入失败!', 'content_6');
    }
}

exit('程序执行结束!content表:' . $content_count);

