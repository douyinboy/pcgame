<?php
 /**===============================
  * 提示内容简体中文语言包
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会联盟后台管理系统
 ==================================*/
global $_GLOBALLANG;
$_GLOBALLANG = array(
//错误提示
    'Error:AdminStateException' => '登录状态异常，请刷新重新登录后再尝试！',
    'Error:HaveOtherBodyUsedAccount' => '成员登录账号已被占用',
    'Error:GuidForbidden' => '公会已封停或尚未开启！',
    'Error:ParamCantBeyondYear' => '该查询暂未开通跨年份查询功能！',
    'Error:ParamError' => '参数出错啦！',
    'Error:HaveNoGrant' => '非法操作-权限受限！请误重复操作',
    'Error:LoginError_2' => '验证码错误',
    'Error:DateOutOfLimit' => '所选日期超出统计范围',
    'Error:EndDateCantlitleStartDate' => '截止日期小于起始时间啦！',
    'Error:LoginError_3' => '账号或密码有误',
    'Error:LoginTimeOut' => '登录超时,请重新登录后操作',
    'Error:AccessError' => '执行出错，请刷新重试',
    'Error:LoginRequestModeError' => '登录请求模式有误',
    'Error:404' => '访问的内容不存在！',
    'Error:OpRecord404' => '不存在该条记录，请您刷新后重试',
    'Error:CantDelTheUser' => '终极权限用户不能删除',
    'Error:AccountUnnormal' => '此账号数据异常，请联系系统维护人员，谢谢',
    'Error:RequrestServerForbidden' => '您请求的服区当前尚未配置使用或处于关服维护中',
    'Error:ParamNotIsNull' => '参数有误，请确认各项必填选项都已选填',
    'Error:CantDelTheGroup' => '终极权限组不能删除噢',
    'Error:CantEDITTheGroup' => '超管组权限禁止编辑噢',
    'Error:CantFindTheGroup' => '用户所在组权限获取失败，请联系管理员',
	'Error:GuildNameError' => '账号有误，请重新输入！',
   
//操作成功提示
    'Ok:Login' => '登录成功',
    'Ok:Operate' => '操作成功',
    'Ok:SubChangePwd' =>'密码修改成功',
    'Ok:DeleteSub' => '删除成功',
    'Ok:Update' => '修改成功',
    'Ok:Add' => '添加成功',
    'Ok:EndOp' => '完成操作',
	'Ok:InnerPay' =>'申请内充成功',
);