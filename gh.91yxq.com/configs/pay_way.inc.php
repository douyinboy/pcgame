<?php
/*快钱网银 0.996
支付宝 0.995
易宝神州行 0.96
声讯 0.44
快钱神州行 0.965 快钱联通和电信0.95
如意付 神州行0.965 联通和电信0.95
手机钱包 约0.46
北京骏网 0.865
易宝网银 0.997
人工充值  1
*/
$pay_way_arr = array(
                      1=>array("payname"=>"银行卡(快钱)充值",
					           "pay_rate"=>"1"),
					   
                      2=>array("payname"=>"支付宝(网上银行)",
					           "pay_rate"=>"1"),
							      
                      3=>array("payname"=>"快钱账号充值",
					           "pay_rate"=>"1"),

                   //   4=>array("payname"=>"易宝骏网一卡通",
					//           "pay_rate"=>"0.85"),  
							   
                    //  5=>array("payname"=>"声讯V币充值",
					 //          "pay_rate"=>"0.45"), 
							   
                      6=>array("payname"=>"神州行充值卡(快钱)",
					           "pay_rate"=>"0.95"), 

                   //   7=>array("payname"=>"如意付充值",
					//           "pay_rate"=>"0.88"), 

                   //   8=>array("payname"=>"手机钱包充值",
					//           "pay_rate"=>"0.46"), 
							     
                      9=>array("payname"=>"骏网一卡通",
					           "pay_rate"=>"0.84"),   	
							  
                      10=>array("payname"=>"银行卡(易宝)充值",
					           "pay_rate"=>"0.997"),
							   
                      11=>array("payname"=>"人工充值",
					           "pay_rate"=>"1"),
							       	  	   							                    
		      		//  12=>array("payname"=>"台灣JCARD",
					//   	        "pay_rate"=>"0.7"),

		      		//  13=>array("payname"=>"银行卡(快钱)充值",
					//           "pay_rate"=>"1"),
							   
					  14=>array("payname"=>"电信卡充值(快钱)",
					           "pay_rate"=>"0.95"),
							   
					  15=>array("payname"=>"联通卡充值(快钱)",
					           "pay_rate"=>"0.95"), 
							   
					  16=>array("payname"=>"官方后台补发",
					           "pay_rate"=>"1"),
							   
				//	  17=>array("payname"=>"GPU充值",  
				//	           "pay_rate"=>"0.6"), 
							   
                      18=>array("payname"=>"支付宝余额充值",
					           "pay_rate"=>"1"),
							   
              //        19=>array("payname"=>"盛峰声讯充值",
				//	           "pay_rate"=>"0.5"),  
    
                      30=>array('payname'=>'微信支付','pay_rate'=>'0.98'),
					  
					  31=>array('payname'=>'手机QQ支付','pay_rate'=>'0.98'),
					  
					  32=>array('payname'=>'骏网一卡通（汇付宝）','pay_rate'=>'0.84'),
					  
					  33=>array('payname'=>'网上银行（汇付宝）','pay_rate'=>'1'),
					  
					  34=>array('payname'=>'快捷支付（汇付宝）','pay_rate'=>'0.99'),
					  
					  35=>array('payname'=>'移动卡充值（汇付宝）','pay_rate'=>'0.95'),
					  
					  36=>array('payname'=>'联通卡充值（汇付宝）','pay_rate'=>'0.95'),
					  
					  37=>array('payname'=>'电信卡充值（汇付宝）','pay_rate'=>'0.95'),
					  
					  38=>array('payname'=>'移动卡充值（19捷迅）','pay_rate'=>'0.95'),
					  
					  39=>array('payname'=>'联通卡充值（19捷迅）','pay_rate'=>'0.95'),
					  
					  40=>array('payname'=>'电信卡充值（19捷迅）','pay_rate'=>'0.95'),
					  
					  41=>array('payname'=>'Q币卡充值（星启天）','pay_rate'=>'0.86'),
					  
					  42=>array('payname'=>'网易一卡通（星启天）','pay_rate'=>'0.88'),
					  
					  43=>array('payname'=>'盛大一卡通（星启天）','pay_rate'=>'0.88'),
					  
					  44=>array('payname'=>'久游一卡通（星启天）','pay_rate'=>'0.82'),
					  
					  45=>array('payname'=>'网银支付（九一付）','pay_rate'=>'1'),
					  
					  46=>array('payname'=>'微信支付（聚财通）','pay_rate'=>'0.98'),
							   
					  100=>array("payname"=>"平台币支付充值",
								"pay_rate"=>"1"),
			);
?>
