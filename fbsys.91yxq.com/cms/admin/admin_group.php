<?php
require_once 'common.php';
require_once INCLUDE_PATH."admin/groupAdmin.class.php";
require_once INCLUDE_PATH."admin/userAdmin.class.php";
//require_once INCLUDE_PATH."admin/publishAuthAdmin.class.php";

/*
if(!$sys->isAdmin()) {
	goback('access_deny_module_group');

}
*/

$group = new groupAdmin();
$group->PermissionDetector($IN);
	 
switch($IN[o]) {

	case 'view':


		$TPL->assign('gInfo', $group->getAllByPermissionAdmin());
		$TPL->display("group_view.html");
		break;

	case 'add':


		$TPL->assign('groupsInfo', $group->getAllByPermissionRead());

		//$TPL->assign('pAuthInfo',publishAuthAdmin::getAll());
		$TPL->display("group_add.html");
		break;

	case 'add_submit':


		$group->flushData();
		$group->addData("gName", $IN[gName]);
		$group->addData("gInfo", $IN[gInfo]);
		$group->addData("gIsAdmin", $IN[isAdmin]);
		$group->addData("canChangePW", $IN[canChangePW]);
		$group->addData("canLogin", $IN[canLogin]);
		$group->addData("canLoginAdmin", $IN[canLoginAdmin]);
		$group->addData("canNode", $IN[canNode]);
		$group->addData("canTpl", $IN[canTpl]);
		$group->addData("canCollection", $IN[canCollection]);

		$group->addData("ParentGID", $IN[ParentGID]);
		$group->addData("canMakeG", $IN[canMakeG]);
		$group->addData("canMakeU", $IN[canMakeU]);
/*
		if(is_array($IN[gPublishAuth])) {
			foreach($IN[gPublishAuth] as $key=>$var) {
				if($key == 0) {
					$gPublishAuth = '[,'.$var;
				} else {
					$gPublishAuth .= ','.$var;
				}
			}
			$gPublishAuth .=',]';
		} else
			$gPublishAuth = '[,'.$IN[gPublishAuth].',]';


		$group->addData("gPublishAuth", $gPublishAuth);
*/	

		if($group->add()) { 
			fgoto("view", 'add_group_ok');

		} else {
			fgoto("view", 'add_group_fail');
		
		}

		break;

	case 'edit':
		if(empty($IN[gId])) fgoto('view');
 
	 
		$TPL->assign('groupsInfo', $group->getAllByPermissionRead());
		$TPL->assign('gInfo', $group->getInfo($IN[gId]));
		//$TPL->assign('pAuthInfo',publishAuthAdmin::getAll());
		$TPL->display("group_edit.html");
		break;

	case 'edit_submit':
		if(empty($IN[gId])) fgoto('view');

		$group->flushData();
		$group->addData("gName", $IN[gName]);
		$group->addData("gInfo", $IN[gInfo]);
		$group->addData("gIsAdmin", $IN[isAdmin]);
		$group->addData("canChangePW", $IN[canChangePW]);
		$group->addData("canLogin", $IN[canLogin]);
		$group->addData("canLoginAdmin", $IN[canLoginAdmin]);
		$group->addData("canNode", $IN[canNode]);
		$group->addData("canTpl", $IN[canTpl]);
		$group->addData("canCollection", $IN[canCollection]);

		$group->addData("ParentGID", $IN[ParentGID]);
		$group->addData("canMakeG", $IN[canMakeG]);
		$group->addData("canMakeU", $IN[canMakeU]);
 
		/*
		if(is_array($IN[gPublishAuth])) {
			foreach($IN[gPublishAuth] as $key=>$var) {
				if($key == 0) {
					$gPublishAuth =  '[,'.$var;
				} else {
					$gPublishAuth .= ','.$var;
				}
			}
			$gPublishAuth .= ',]';
		} else
			$gPublishAuth = '[,'.$IN[gPublishAuth].',]';


		$group->addData("gPublishAuth", $gPublishAuth);
		*/
		if($group->update($IN[gId])) { 
			fgoto("view", 'edit_group_ok');

		} else {
			fgoto("view", 'edit_group_fail');
		
		}
		break;

	case 'del':
		if(empty($IN[gId])) fgoto('view');
		if($group->del($IN[gId])) {
			fgoto("view", 'del_group_ok');
			
		} else
			fgoto("view", 'del_group_fail');
		
		break;


}

	
include('./modules/footer.php');



?>
