<?php
 /**==============================
  * 功能操作列表数据
  * @author Kevin
  * @email 254056198@qq.com
  * @version: 1.0 data
  * @package 游戏公会联盟后台管理系统
 =================================*/
global $allGrants;
$allGrants=array(                    
            //公会数据统计
            array('key' =>1000, 'title' =>'数据', 'order' =>3),
                array('key' =>1100, 'title' =>'业绩管理', 'order' =>1),
                    array('key' =>1103, 'title' =>'提取链接', 'module' =>'grant', 'option' =>'getUrl', 'order' =>1),
                    array('key' =>1105, 'title' =>'玩家最近充值', 'order' =>1, 'module' =>'pay', 'option' =>'theGuildPay', 'order' =>1),
                    array('key' =>1104, 'title' =>'最近注册', 'order' =>1, 'module' =>'reg', 'option' =>'todayReg', 'order' =>1),
                    array('key' =>1106, 'title' =>'游戏区服充值汇总', 'module' =>'pay', 'option' =>'theGuildPayData', 'order' =>1),
                    array('key' =>1107, 'title' =>'发放首冲', 'module' =>'pay', 'option' =>'firstPay', 'order' =>1),
                    array('key' =>1105, 'title' =>'申请工资结算(按周)', 'module' =>'payjie', 'option' =>'weekjie', 'order' =>1),


);