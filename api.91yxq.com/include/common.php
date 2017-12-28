<?php

/**
 * @description 首页轮播图片
 * @param $condition1 string
 * @param $condition2 string
 * @param $limit string
 * @return array
 */
function getGameImg($condition1, $condition2, $limit, $mysqli)
{
    $sql = "SELECT GameId, GameName, GameType FROM " . PUBLISH . "." . PUBLISH_5 . " WHERE " . $condition1;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        $_arr = [];
        while ($row = $res->fetch_assoc()) {
            $_arr[] = $row;
        }

        $sql = "SELECT GameId, GameImg, URL FROM  " . PUBLISH . "." . PUBLISH_7 . " WHERE " . $condition2 . " ORDER BY SortPriority DESC LIMIT " . $limit;
        $res = $mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            foreach ($_arr as $key => $val) {
                if ($row['GameId'] == $val['GameId']) {
                    $arr[] = array_merge($row, $val);
                }
            }
        }
    }

    return $arr;
}

/**
 * @description 获取服务器列表
 * @param $condition string
 * @param $limit string
 * @return array
 */
function getServerList($condition, $limit, $mysqli)
{
    $sql = "SELECT p5.GameId, p5.GameName, p7.GameImg FROM  " . PUBLISH . "." . PUBLISH_5 . " AS p5 LEFT JOIN  " . PUBLISH . "." . PUBLISH_7 . " AS p7 ON p5.GameId = p7.GameId  WHERE p7.NodeID = 35";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        $_arr = [];
        while ($row = $res->fetch_assoc()) {
            $_arr[] = $row;
        }

        $sql = "SELECT GameId, ServerId, ServerName, OpenDate, OpenTime, ServerStatus  FROM  " . PUBLISH . "." . PUBLISH_6 . " WHERE ServerShow = 3 " . $condition . " ORDER BY OpenDate DESC, OpenTime DESC" . $limit;
        $res = $mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            if ($row['ServerStatus'] > 2) {
                $row['ServerStatus'] = 1;
            } else {
                $row['ServerStatus'] = 0;
            }
            foreach ($_arr as $key => $val) {
                if ($row['GameId'] == $val['GameId']) {
                    $arr[] = array_merge($row, $val);
                }
            }
        }
    }


    return $arr;
}

//function getGameRank($mysqli)
//{
//    $sql = "SELECT p5.GameId, p5.GameName, p5.GameType, p7.GameImg, p7.GameFeature FROM  " . PUBLISH . "." . PUBLISH_5 . " AS p5 LEFT JOIN  " . PUBLISH . "." . PUBLISH_7 . " AS p7 ON p7.GameId = p5.GameId  WHERE p7.NodeID = 35 ORDER BY p5.GamePopularity DESC " . $limit;
//    $res = $mysqli->query($sql);
//    $arr = [];
//    if ($res) {
//        while ($row = $res->fetch_assoc()) {
//            $arr[] = $row;
//        }
//    }
//
//    return $arr;
//}

/**
 * @description 获取游戏类型
 * @return array
 */
function getGameType($mysqli)
{
    $sql = "SELECT DataId, DataValue FROM  " . PUBLISH . "." . PUBLISH_4 . " WHERE NodeId = 24";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取游戏列表
 * @param $condition string
 * @param $limit string
 * @return array
 */
function getGameList($condition, $limit, $mysqli)
{
    $sql = "SELECT p5.GameId, p5.GameName, p5.GameType, p7.GameImg, p7.GameFeature FROM  " . PUBLISH . "." . PUBLISH_5 . " AS p5 LEFT JOIN  " . PUBLISH . "." . PUBLISH_7 . " AS p7 ON p7.GameId = p5.GameId  WHERE p7.NodeID = 35 " . $condition . " ORDER BY p7.SortPriority DESC " . $limit;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $bestNewsServer = getBestNewsServer($row['GameId'], $mysqli);
            $row['bestNewsServerId'] = $bestNewsServer['ServerId'];
            $row['bestNewsServerName'] = $bestNewsServer['ServerName'];
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取最新的游戏服
 * @param $game_id integer
 * @return array
 */
function getBestNewsServer($game_id, $mysqli)
{
    $sql = "SELECT ServerId, ServerName FROM " . PUBLISH . "." . PUBLISH_6 . " WHERE ServerStatus > 2 AND GameId = " . $game_id . " ORDER BY OpenDate DESC, OpenTime DESC";

    return $mysqli->query($sql)->fetch_assoc();
}

/**
 * @description 获取游戏总数
 * @param $condition string
 * @return array
 */
function getGameTotal($condition, $mysqli)
{
    $sql = "SELECT p5.GameId FROM  " . PUBLISH . "." . PUBLISH_5 . " AS p5 LEFT JOIN  " . PUBLISH . "." . PUBLISH_7 . " AS p7 ON p7.GameId = p5.GameId  WHERE p7.NodeID = 35 " . $condition;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return count($arr);
}

/**
 * @description 获取游戏新闻总数
 * @param $game_id integer
 * @param $condition string
 * @return array
 */
function getGameNewsTotal($game_id, $condition, $mysqli)
{
    $sql = "SELECT IndexID FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE GameId = " . $game_id . $condition;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return count($arr);
}

/**
 * @description 获取所有的服务器列表
 * @return array
 */
function getAllServerList($mysqli)
{
    $statusList = [
        0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'
    ];
    $sql = "SELECT GameId, GameName, GameType FROM " . PUBLISH . "." . PUBLISH_5 . " WHERE 1";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        $_arr = [];
        while ($row = $res->fetch_assoc()) {
            $_arr[] = $row;
        }

        $sql = "SELECT GameId, OpenDate, OpenTime, ServerId, ServerName, ServerStatus FROM  " . PUBLISH . "." . PUBLISH_6 . " WHERE ServerShow = 3 AND OpenDate = '" . date('Y-m-d', strtotime('-1 day')) . "' OR OpenDate = '" . date('Y-m-d') . "' ORDER BY OpenDate DESC, OpenTime DESC";
        $res = $mysqli->query($sql);
        while ($row = $res->fetch_assoc()) {
            if ($row['ServerStatus'] > 2) {
                $row['ServerStatus'] = 1;
            } else {
                $row['ServerStatus'] = 0;
            }
//            $row['ServerStatus'] = $statusList[$row['ServerStatus']];
            foreach ($_arr as $key => $val) {
                if ($row['GameId'] == $val['GameId']) {
                    $arr[] = array_merge($row, $val);
                }
            }
        }
    }

    return $arr;
}

/**
 * @description 获取游戏新闻列表
 * @param $game_id integer
 * @param $condition string
 * @param $limit string
 * @return array
 */
function getGameTextInfo($game_id, $condition, $limit, $mysqli)
{
    $newsTypeList = [
        1 => '新手指南', 2 => '高手进阶', 3 => '游戏系统', 4 => '特色玩法', 5 => '新闻', 6 => '公告', 7 => '活动', '8' => '游戏截图', 9 => '游戏攻略', 10 => '滚屏公告'
    ];
    $sql = "SELECT IndexID, GameId, NewsType, Title, PublishDate, NewsType FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE GameId = " . $game_id . $condition . " ORDER BY IndexID DESC" . $limit;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $row['NewsType'] = $newsTypeList[$row['NewsType']];
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取上一个游戏新闻标题
 * @param $game_id integer
 * @param $node_id integer
 * @return array
 */
function getLastGameInfo($game_id, $node_id, $mysqli)
{
    $sql = "SELECT IndexID, Title FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE  GameId = " . $game_id . " AND IndexID > " . $node_id . " ORDER BY IndexID ASC LIMIT 1";
    $res = $mysqli->query($sql);
    $arr = $res->fetch_assoc();

    return $arr;
}

/**
 * @description 获取下一个游戏新闻标题
 * @param $game_id integer
 * @param $node_id integer
 * @return array
 */
function getNextGameInfo($game_id, $node_id, $mysqli)
{
    $sql = "SELECT IndexID, Title FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE  GameId = " . $game_id . " AND IndexID < " . $node_id . " ORDER BY IndexID DESC LIMIT 1";
    $res = $mysqli->query($sql);
    $arr = $res->fetch_assoc();

    return $arr;
}

/**
 * @description 获取游戏的服列表
 * @param $game_id integer
 * @return array
 */
function getServerOfGame($game_id, $mysqli)
{
    $statusList = [
        0 => '停服', 1 => '维护', 2 => '待开', 3 => '顺畅', 4 => '火爆', 5 => '爆满'
    ];
    $sql = "SELECT IndexID, ServerId, ServerName, ServerStatus FROM  " . PUBLISH . "." . PUBLISH_6 . " WHERE GameId = " . $game_id . " AND ServerShow = 3 ORDER BY OpenDate DESC, OpenTime DESC";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $row['ServerStatus'] = $statusList[$row['ServerStatus']];
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取新闻详情
 * @param $node_id integer
 * @return array
 */
function getNewsContent($node_id, $mysqli)
{
    $newsTypeList = [
        1 => '新手指南', 2 => '高手进阶', 3 => '游戏系统', 4 => '特色玩法', 5 => '新闻', 6 => '公告', 7 => '活动', '8' => '游戏截图'
    ];
    $sql = "SELECT Title, PublishDate, Content, NewsType FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE IndexID = " . $node_id;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $row['NewsType'] = $newsTypeList[$row['NewsType']];
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取最新的活动列表
 * @return array
 */
function getNewActivity($mysqli)
{
    $sql = "SELECT IndexID, GameId, Photo FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE NodeID = 12 AND Photo != '' ORDER BY PublishDate DESC LIMIT 8";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取游戏截图
 * @param $game_id integer
 * @return array
 */
function getGameScreenshot($game_id, $mysqli)
{
    $sql = "SELECT Photo FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE GameId = " . $game_id . " AND NewsType = 8 AND Photo != '' ORDER BY PublishDate DESC LIMIT 3";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取滚屏公告
 * @param $game_id integer
 * @return array
 */
function getRollingAd($game_id, $mysqli)
{
    $sql = "SELECT Photo FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE GameId = " . $game_id . " AND NewsType = 10";
    $res = $mysqli->query($sql)->fetch_assoc();

    return $res;
}

/**
 * @description 获取游戏资讯总数
 * @return array
 */
function getGameInformationTotal($mysqli)
{
    $sql = "SELECT ContentID FROM  " . PUBLISH . "." . CONTENT_INDEX . " WHERE URL like '%xwzx%' AND TableID = 1";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return count($arr);
}

/**
 * @description 获取游戏资讯列表
 * @param $limit string
 * @return array
 */
function getGameInformation($limit, $mysqli)
{
    $sql = "SELECT p.ContentID, p.PublishDate, p.URL, g.Title FROM  " . PUBLISH . "." . CONTENT_INDEX . " p LEFT JOIN " . PUBLISH . "." . CONTENT_1 . " g ON g.ContentID=p.ContentID WHERE p.URL like '%xwzx%' AND p.TableID = 1 ORDER BY p.PublishDate DESC" . $limit;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取上一个游戏资讯标题
 * @param $index_id integer
 * @return array
 */
function getLastInformation($publishDate, $mysqli)
{
    $sql = "SELECT p.ContentID, p.PublishDate, g.Title FROM  " . PUBLISH . "." . CONTENT_INDEX . " p LEFT JOIN " . PUBLISH . "." . CONTENT_1 . " g ON g.ContentID=p.ContentID WHERE p.PublishDate >" . $publishDate . " AND p.TableID = 1 ORDER BY p.PublishDate ASC LIMIT 1";

    $res = $mysqli->query($sql);
    $arr = $res->fetch_assoc();

    return $arr;
}

/**
 * @description 获取下一个游戏资讯标题
 * @param $index_id integer
 * @return array
 */
function getNextInformation($publishDate, $mysqli)
{
    $sql = "SELECT p.ContentID, p.PublishDate, g.Title FROM  " . PUBLISH . "." . CONTENT_INDEX . " p LEFT JOIN " . PUBLISH . "." . CONTENT_1 . " g ON g.ContentID=p.ContentID WHERE p.PublishDate <" . $publishDate . " AND p.TableID = 1 ORDER BY p.PublishDate DESC LIMIT 1";

    $res = $mysqli->query($sql);
    $arr = $res->fetch_assoc();

    return $arr;
}

/**
 * @description 获取游戏资讯详情
 * @param $indexId integer
 * @return array
 */
function getGameInformationContent($indexId, $mysqli)
{
    $sql = "SELECT g.Title, p.PublishDate, g.Content FROM  " . PUBLISH . "." . CONTENT_INDEX . " p LEFT JOIN " . PUBLISH . "." . CONTENT_1 . " g ON g.ContentID=p.ContentID WHERE g.ContentID = " . $indexId;
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取游戏和游戏服列表
 * @return array
 */
function getGameAndServerList($mysqli)
{
    $sql = "SELECT g.id g_id, g.name g_name, g.exchange_rate, g.b_name, s.server_id, s.name s_name from  " . PAYDB . "." . GAMELIST . " AS g LEFT JOIN " . PAYDB . "." . SERVERLIST ." AS s ON s.game_id = g.id WHERE g.is_open = 1 AND s.is_open = 1 order by g.id desc";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[$row['g_id']]['g_id']                                   = $row['g_id'];
            $arr[$row['g_id']]['g_name']                                 = $row['g_name'];
            $arr[$row['g_id']]['exchange_rate']                          = $row['exchange_rate'];
            $arr[$row['g_id']]['b_name']                                 = $row['b_name'];
            $arr[$row['g_id']]['server'][$row['server_id']]['server_id'] = $row['server_id'];
            $arr[$row['g_id']]['server'][$row['server_id']]['s_name']    = $row['s_name'];
        }
    }

    return $arr;
}

/**
 * @description 获取广告位列表
 * @return array
 */
function getAdList($mysqli)
{
    $sql = "SELECT id, ad_name, position_pic, ad_pic, click_count FROM  " . MANAGE . "." . AD . " WHERE state = 1 ORDER BY id ASC";
    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return $arr;
}

/**
 * @description 获取广告位对应的图片
 * @param $id integer
 * @return array
 */
function getAdImgById($id, $mysqli)
{
    $sql = "SELECT game_id, ad_pic, click_count from  " . MANAGE . "." . AD . " WHERE id = " . $id;

    $res = $mysqli->query($sql)->fetch_assoc();

    if ($res) {
        $sql2 = "UPDATE " . MANAGE . "." . AD . " SET click_count = " . ++$res['click_count'] . "  WHERE id = " . $id;
        $mysqli->query($sql2);
    }

    return $mysqli->query($sql)->fetch_assoc();
}

/**
 * @description 游戏名称
 * @param $id integer
 * @return array
 */
function getGameName($id, $mysqli)
{
    $sql = "SELECT GameName FROM  " . PUBLISH . "." . PUBLISH_5 . " WHERE GameId = " . $id;

    return $mysqli->query($sql)->fetch_assoc();
}

/**
 * @description 获取bbs用户总数
 * @param $url string
 * @return array
 */
function getBBSListTotal($url, $where, $mysqli)
{
    $sql = "SELECT site_id FROM  " . ADMINTABLE . "." . GUILDMEMBER . " WHERE url = '" . $url . "'";

    $result = [];
    if ($res = $mysqli->query($sql)->fetch_assoc()) {
        $sql = "SELECT count(uid) total FROM 91yxq_users.users WHERE " . $where . " place_id = " . $res['site_id'];
        $result = $mysqli->query($sql)->fetch_assoc();
    }

    return $result['total'];
}

/**
 * @description 获取bbs用户
 * @param $url string
 * @return array
 */
function getBBSList($url, $where, $limit, $mysqli)
{
    $sql = "SELECT site_id, url FROM  " . ADMINTABLE . "." . GUILDMEMBER . " WHERE url = '" . $url . "'";

    $arr = [];
    if ($res = $mysqli->query($sql)->fetch_assoc()) {
        $sql = "SELECT uid, user_name, bbs_username, reg_time FROM 91yxq_users.users WHERE " . $where . " place_id = " . $res['site_id'] . " ORDER BY reg_time DESC " . $limit;
        $result = $mysqli->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }
    }

    return [$arr, $res['url']];
}

/**
 * @description 获取充值数据
 * @param $url string
 * @return array
 */
function getBBSRechargeListTotal($url, $where, $mysqli)
{
    $sql = "SELECT site_id FROM  " . ADMINTABLE . "." . GUILDMEMBER . " WHERE url = '" . $url . "'";
    $site_id = $mysqli->query($sql)->fetch_assoc();

    $sql = "SELECT count(u.uid) total  FROM " . PAYDB . "." . PAYORDER . " o LEFT JOIN 91yxq_users.users u ON u.user_name = o.user WHERE " . $where . " o.succ = 1 AND u.place_id = " . $site_id['site_id'];

    $result = $mysqli->query($sql)->fetch_assoc();

    return $result['total'];
}

/**
 * @description 获取充值数据
 * @param $url string
 * @return array
 */
function getBBSRechargeList($url, $where, $limit, $mysqli)
{
    $sql = "SELECT site_id, url FROM  " . ADMINTABLE . "." . GUILDMEMBER . " WHERE url = '" . $url . "'";
    $site_id = $mysqli->query($sql)->fetch_assoc();

    $sql = "SELECT u.uid, o.orderid, o.user, u.bbs_username, o.succ, o.game, o.server, o.money, o.sync_date FROM " . PAYDB . "." . PAYORDER . " o LEFT JOIN 91yxq_users.users u ON u.user_name = o.user WHERE " . $where . " o.succ = 1 AND u.place_id = " . $site_id['site_id'] . " ORDER BY o.sync_date DESC " . $limit;

    $res = $mysqli->query($sql);
    $arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $arr[] = $row;
        }
    }

    return [$arr, $site_id['url']];
}

/**
 * @description 获取游戏列表
 * @param $url string
 * @return array
 */
function getGameArr($mysqli)
{
    $sql = "SELECT id, name, game_byname FROM " . PAYDB . "." . GAMELIST;

    $res = $mysqli->query($sql);
    $game_list_arr = [];
    $game_arr = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $game_list_arr[] = $row;
        }
    }
    foreach ($game_list_arr as $val) {
        $game_arr[$val['id']]['name'] = $val['name'];
        $game_arr[$val['id']]['game_byname'] = $val['game_byname'];
    }

    return $game_arr;
}


/**
 * @description 获取游戏充值成功后，游戏币发货状态
 * @param $url string
 * @return array
 */
function getGameCoinState($tableName, $orderid, $mysqli)
{
    $sql = "SELECT stat FROM " . PAYDB . ".". $tableName . " WHERE orderid = '" . $orderid . "'";

    $res = $mysqli->query($sql)->fetch_assoc();

    return $res['stat'];
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function pceggs($res, $_nickname, $max, $server_id, $mysqli)
{
    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
    $xml .= '<Result>';
    $xml .= '<GameName>' . $_nickname . '</GameName>';
    $xml .= '<PlayLevel>' . $max . '</PlayLevel>';
    $xml .= '<TodayLevel>1</TodayLevel>';
    $xml .= '<Status>1</Status>';
    $xml .= '</Result>';

    return $xml;
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function bengbeng($res, $_nickname, $max, $server_id, $mysqli)
{
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();

    $xml = '<?xml version="1.0" encoding="utf-8"?>';
    $xml .= '<Result>';
    $xml .= '<Status>1</Status>';                                 //是蹦蹦推广用户为1，否则为0
    $xml .= '<UserID>' . $res['uid'] . '</UserID>';               //用户ID
    $xml .= '<UserName>' . $res['user_name'] . '</UserName>';     //用户通行证
    $xml .= '<UserServer>' . $server_id . '</UserServer>';        //区服号
    $xml .= '<ServerName>双线' . $server_id . '服</ServerName>';   //区服名称
    $xml .= '<UserRole>' . $_nickname . '</UserRole>';            //用户角色
    $xml .= '<UserLevel>' . $max . '</UserLevel>';                //用户等级
    $xml .= '<ChongZhi>' . $_result['total'] . '</ChongZhi>';     //用户充值累计
    $xml .= '</Result>';

    return $xml;
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function juxiangyou($res, $_nickname, $max, $server_id, $mysqli)
{
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();

    $arr['UserID'] = $res['uid'];
    $arr['UserName'] = $res['user_name'];
    $arr['UserServer'] = $server_id;
    $arr['ServerName'] = '双线' . $server_id . '服';
    $arr['UserRole'] = $_nickname;
    $arr['UserLevel'] = $max;
    $arr['reCharge'] = $_result['total'] ?: 0;
    $arr['Status'] = 1;                   //查询信息是否正常（1：正常；0异常）

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function youyiwang($res, $_nickname, $max, $server_id, $mysqli)
{
    $arr               = [];
    //$arr['UserID']     = $res['uid'];          //用户ID
    //$arr['UserName']   = $res['user_name'];    //用户通行证
    $arr['ServerName'] = $server_id;           //区服名称
    $arr['UserRole']   = $_nickname;           //用户角色
    $arr['UserLevel']  = $max;                 //用户等级

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function kuailezhuan($res, $_nickname, $max, $server_id, $mysqli)
{
    $xml = '<?xml version="1.0" encoding="utf-8"?>';
    $xml .= '<Result>';
    $xml .= '<UserID>' . $res['uid'] . '</UserID>';               //用户ID
    $xml .= '<UserName>' . $res['user_name'] . '</UserName>';     //用户通行证
    $xml .= '<UserServer>' . $server_id . '</UserServer>';        //区服号
    $xml .= '<ServerName>双线' . $server_id . '服</ServerName>';   //区服名称
    $xml .= '<UserRole>' . $_nickname . '</UserRole>';            //用户角色
    $xml .= '<UserLevel>' . $max . '</UserLevel>';                //用户等级
    $xml .= '<Status>1</Status>';                                 //是快乐赚推广用户为1，否则为0
    $xml .= '</Result>';

    return $xml;
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function tiantianzuan($res, $_nickname, $max, $server_id, $mysqli)
{
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();
    if (!$_result['total']) {
        $_result['total'] = 0;
    }

    $arr               = [];
    $arr['Status']     = 1;                       //查询信息是否正常（1：正常；0异常）
    $arr['UserID']     = $res['uid'];             //用户ID
    $arr['UserName']   = $res['user_name'];       //用户名
    $arr['UserServer'] = $server_id;              //区服
    $arr['ServerName'] = '双线' . $server_id . '服';    //区服名称
    $arr['UserRole']   = $_nickname;              //用户角色
    $arr['UserLevel']  = $max;                    //用户等级
    $arr['Payment']    = $_result['total'];       //充值总额

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function quba($res, $_nickname, $max, $server_id, $mysqli)
{
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();
    if (!$_result['total']) {
        $_result['total'] = 0;
    }

    $arr               = [];
    $arr['UserID']     = $res['uid'];          //用户ID
    $arr['UserName']   = $res['user_name'];    //用户通行证
    $arr['ServerName'] = '双线' . $server_id . '服';    //区服名称
    $arr['UserRole']   = $_nickname;           //用户角色
    $arr['UserLevel']  = $max;                 //用户等级
    $arr['Payment']    = $_result['total'];    //充值总额
    $arr['Status']     = 1;                    //查询信息是否正常（1：正常；0异常）

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function shitoucun($res, $_nickname, $max, $server_id, $mysqli)
{
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();
    if (!$_result['total']) {
        $_result['total'] = 0;
    }

    $arr               = [];
    $arr['GameUid']     = $res['uid'];             //用户ID
    $arr['GameRole']   = $_nickname;               //用户角色
    $arr['GameServer'] = '双线' . $server_id . '服';    //区服名称
    $arr['GameLevel']  = $max;                     //用户等级
    $arr['GamePayment']    = $_result['total'];    //充值总额
    $arr['GameStatus']     = 1;                    //查询信息是否正常（1：正常；0异常）

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function ledouwan($res, $_nickname, $max, $server_id, $mysqli)
{
    $arr['state']     = 0;                              //没有创建角色信息/获取到用户数据
    $arr['results']['role_name']   = $_nickname;        //用户角色
    $arr['results']['role_level'] = $max;               //用户等级
    $arr['results']['u_name']   = $res['user_name'];    //用户角色
    $arr['results']['g_server']   = $server_id;  //注册区服

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function jiquwang($res, $_nickname, $max, $server_id, $mysqli)
{
    $arr['status']    = 0;                               //没有创建角色信息/获取到用户数据
    $arr['msg']       = 'success';                       //没有创建角色信息/获取到用户数据
    $arr['data']['u_name']   = $res['user_name'];        //用户角色
    $arr['data']['role_name']   = $_nickname;            //用户角色
    $arr['data']['role_server']   = $server_id;          //区服ID
    $arr['data']['role_sname']   = '双线' . $server_id . '服';                   //区服名
    $arr['data']['role_level']  = $max;                  //用户等级

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $xml  xml
 */
function jujuwan($res, $_nickname, $max, $server_id, $mysqli)
{
//    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
//    $_result = $mysqli->query($sql)->fetch_assoc();
//    if (!$_result['total']) {
//        $_result['total'] = 0;
//    }

    $arr['status']     = 1;                           //没有创建角色信息/获取到用户数据
    $arr['UserID']     = $res['uid'];                 //用户角色
    $arr['UserName']   = $res['user_name'];           //用户角色
    $arr['UserLevel']  = $max;                        //用户等级
    $arr['UserRole']   = $_nickname;                  //用户角色
    $arr['UserServer'] = $server_id;                  //区服ID
    $arr['ServerName'] = '双线' . $server_id . '服';   //区服名
//    $arr['ChongZhi']   = $_result['total'];           //充值总额

    return json_encode($arr);
}

/**
 * @description 返回获取的游戏角色数据
 * @param $from
 * @return $json
 */
function yiruite($res, $_nickname, $max, $server_id, $mysqli)
{
    $arr['UserID']     = $res['uid'];                 //用户角色
    $arr['UserName']   = $res['user_name'];           //用户角色
    $arr['UserLevel']  = $max;                        //用户等级
    $arr['UserRole']   = $_nickname;                  //用户角色
    $arr['UserServer'] = $server_id;                  //区服ID

    return json_encode($arr);
}







