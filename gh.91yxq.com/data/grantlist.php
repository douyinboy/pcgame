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
            array('key' =>1000, 'title' =>'CPS数据', 'order' =>3),
                array('key' =>1100, 'title' =>'公会业绩查询', 'order' =>1),
                    array('key' =>1102, 'title' =>'每日业绩查询', 'order' =>1, 'module' =>'recharge', 'option' =>'dayData', 'order' =>1),
                    array('key' =>1103, 'title' =>'员工业绩查询', 'order' =>1, 'module' =>'recharge', 'option' =>'memberPayData', 'order' =>1),
                    array('key' =>1104, 'title' =>'公会最近注册', 'order' =>1, 'module' =>'reg', 'option' =>'todayReg', 'order' =>1), 
                    array('key' =>1106, 'title' =>'游戏区服充值汇总', 'module' =>'recharge', 'option' =>'theGuildPayData', 'order' =>1),    
                    array('key' =>1105, 'title' =>'玩家最近充值查询', 'order' =>1, 'module' =>'recharge', 'option' =>'theGuildPay', 'order' =>1),
            array('key' =>1400, 'title' =>'推广管理', 'order' =>1),
                    array('key' =>1401, 'title' =>'成员管理', 'module' =>'system', 'option' =>'guildMembers', 'order' =>1),
            array('key' =>1300, 'title' =>'结算和内充记录', 'order' =>1),
                    array('key' =>1301, 'title' =>'工资结算报表', 'module' =>'recharge', 'option' =>'settleAccounts', 'order' =>1),
                    array('key' =>1302, 'title' =>'内充记录报表', 'module' =>'recharge', 'option' =>'innerPay', 'order' =>1),
                    array('key' =>1303, 'title' =>'首充管理', 'module' =>'recharge', 'option' =>'firstPay', 'order' =>1),
                    array('key' =>1304, 'title' =>'申请内充', 'module' =>'recharge', 'option' =>'applyInnerpay', 'order' =>1),
                    array('key' =>1305, 'title' =>'申请工资结算(按周)', 'module' =>'payjie', 'option' =>'weekjie', 'order' =>1),
                    array('key' =>1306, 'title' =>'申请工资结算', 'module' =>'payjie', 'option' =>'jie', 'order' =>1),
            array('key' =>1200, 'title' =>'个人信息中心', 'order' =>1),
                    array('key' =>1201, 'title' =>'公会信息', 'module' =>'sysmanage', 'option' =>'myInfo', 'order' =>1),
                    array('key' =>1202, 'title' =>'密码修改', 'module' =>'sysmanage', 'option' =>'cmdata', 'order' =>1),
                    array('key' =>1203, 'title' =>'安全退出', 'module' =>'public', 'option' =>'loginOut', 'order' =>1),
);