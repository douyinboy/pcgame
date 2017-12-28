<?php

/*身份证验证函数群*/
function idcard_verify_number($idcard_base)
{
    if (strlen($idcard_base) != 17){ return false; }

    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    
    // 校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++){
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }

    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];

    return $verify_number;

}

// 将15位身份证升级到18位
function idcard_15to18($idcard){
    if (strlen($idcard) != 15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
    }

    $idcard = $idcard . idcard_verify_number($idcard);

    return $idcard;
}

// 18位身份证校验码有效性检查
function idcard_checksum18($idcard){
    if (strlen($idcard) != 18){ return false; }
    $idcard_base = substr($idcard, 0, 17);

    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
        return false;
    }else{
        return true;
    }
}
/*
身份证验证调用这个扩展函数即可
身份证调用这个 验证
*/
function check_idcard($idcard)
{
	if(strlen($idcard) == 15 || strlen($idcard) == 18)
	{
	   if(strlen($idcard) == 15)
	   {
			$idcard = idcard_15to18($idcard);
	   }
	
	   if(idcard_checksum18($idcard))
	   {
			return true;
	   }else{
			return false;
	   }
	}else{
	   return false;
	}
}

/* 验证是否已满18周岁 */
function check_age($idcard)
{
	if(strlen($idcard) == 15 || strlen($idcard) == 18)
	{
	   if(strlen($idcard) == 15)
	   {
			$idcard = idcard_15to18($idcard);
	   }
	
      $y=substr($idcard,6,4);
      $ny=date("Y");
      $age=$ny-$y;
	   
	   if($age<18)
	   {
			return false;
	   }else{
			return true;
	   }
	}else{
	   return false;
	}
}

/*身份证验证函数群END*/

    $account = trim($_REQUEST['account']);
	$truename = trim($_REQUEST['truename']); 
	$idcard =  trim($_REQUEST['card']);
	$sign =  trim($_REQUEST['sign']);
	
	if (mb_check_encoding($account, 'gb2312')) {
		$account = iconv('gb2312', 'utf-8',$account);
    } 
	if (mb_check_encoding($truename, 'gb2312')) {
        $truename = iconv('gb2312', 'utf-8',$truename);
    } 

   if(empty($account) || empty($truename) || empty($idcard) || empty($sign)){
      echo "-1";
      exit();
   }

	$key=md5(urlencode(trim($truename)).urlencode(trim($account)).'treyuwwe64*&DSwssieq'.$idcard);

	if($sign!=$key){
	   echo '-2';
	   exit();
	}
	
	$show_result = true;

	if (!check_idcard($idcard)) {
		echo '-3';
      $show_result = false;
	} else if (!check_age($idcard)) {
       $show_result = true;
	} else if (!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$truename)) {
		echo '-4';
		$show_result = false;
	} else if (strlen($truename)>10) {
		echo '-4';
		$show_result = false;
	}
	if ($show_result) {
		 $info="username=$account&true_name=$truename&id_card=$idcard";
		 $result=long_login($info,time(),"update&do=indulged");
		if($result=="ok"){
			if (!check_age($idcard)) {
		    	$_SESSION["login"]["fcm"] =0;
		   		echo '2';
			} else {
				$_SESSION["login"]["fcm"] =1;
		   		echo '1';
			}
		} else {
		    echo '-5';
		}
	}

?>