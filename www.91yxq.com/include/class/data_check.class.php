<?php
/*
 *文件名称：cls.data_check.php
 *作用：数据合法性检测类
 *
 */
class DataCheck	{

	public function chkMoney($money) { 
		$flag = true;
		!ereg("^[0-9][.][0-9]$",$money) and $flag = false; 
		return $flag; 
	} 

	public function chkEmail($email) { 
		$flag = true;
		//!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$",$email) and $flag = false;
		!preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/",$email) and $flag = false;
		return $flag;
	} 

	public function chkUrl($url) {
		$flag = true;
		!ereg("^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $url) and $flag = false;
		return $flag; 
	} 

	public function chkEmpty($string) {
		
		if (!is_string($string)) return false;
		if (empty($string)) return false;
		if ($string == '') return false;
		return true; 
	} 

	public function chkLength($string,$len_1,$len_2 = 100) { 
		$string  = trim($string);
		$str_len = strlen($string);
		if ($str_len < $len_1) return false; 
		if ($str_len > $len_2) return false; 
		return true; 
	} 

	public function chkUserName($string,$len_1,$len_2) { 
		if (!$this -> chkLength($string,$len_1,$len_2)) return false;
		
		return true; 
	} 
	public function chkUserName1($string){
		//if (!preg_match("/^[\x{4e00}-\x{9fa5}|A-Z|a-z|0-9|\_]+$/u",$string)) return false;
		if (preg_match("/^[A-Za-z0-9\_@.com]+$/u",$string)){return true;}
	}

	public function chkUserPwd($string,$len_1,$len_2) { 
		if (!$this -> chkLength($string,$len_1,$len_2)) return false;
		//if (!ereg("^[_a-zA-Z0-9]*$",$string)) return false;
		return true; 
	} 

	public function chkTelephone($string) { 
		$flag = true;
		!ereg("^[+]?[0-9]+([xX-][0-9]+)*$",$string) and $flag = false; 
		return $flag; 
	}

	public function chkMobile($mobile) { 
		if(!preg_match('/^(130|131|132|152|155|156|185|186|134|135|136|137|138|139|150|151|157|158|159|187|188|133|153|180|189|182)(\d{8})$/',$mobile)){ return false; }
		return true; 
	}

	public function chkZipCode($num) { 
		$flag = true;
		$num  = trim($num); 
		if (strlen($num) == 6) {
			!is_numeric($num) and $flag = false;
		} else {
			$flag = false;
		}
	} 

	//检测扩展名: 0 - 没有文件,-1 - 扩展名符合要求,1 - 扩展名正确
	function chkExtendName($file_name,$extend = array()) { 
		if(strlen(trim($file_name)) < 5) {
			return 0;
		}
		$last_dot = strrpos($file_name,".");
		$extend_name = substr($file_name,$last_dot+1);

		for($i=0;$i<count($extend);$i++) { 
			if (trim(strtolower($extend_name)) == trim(strtolower($extend[$i]))) { 
				$flag = 1;
				break;
			}
		}
		$flag != 1 and $flag = -1;
		return $flag;
	} 


	function chkFileSize($file_name,$limit_size) { 
		$size = GetImageSize($file_name); 
		if ($size[0] > $file_name[0] || $size[1] > $limit_size[1]) { 
			return false; 
		} 
		return true; 
	}
	
	// 检查数据是否为日期格式
	public function isDate($data) {
		$re = "#^\d{4}([/-])([0][0-9]|[1][0-2])\\1([0-2][0-9]|[3][0-1])$#";
		return $this -> match($data,$re);
	}

	public function match($data,$re) {
		return preg_match($re,$data);
	}
}
?>
