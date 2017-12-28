<?php

exit('<meta charset="utf-8" />需要重新处理 "city_codes.txt" 时屏蔽本行代码!');

/*
@版本日期: 2013年11月17日
@著作权所有: 1024 intelligence ( http://www.1024i.com )

获得使用本类库的许可, 您必须保留著作权声明信息.
报告漏洞，意见或建议, 请联系 Lou Barnes(iua1024@gmail.com)
*/

$capital_to_province = array(
	'北京'=>'北京市',
	'上海'=>'上海市',
	'天津'=>'天津市',
	'重庆'=>'重庆市',
	'哈尔滨'=>'黑龙江省',
	'长春'=>'吉林省',
	'沈阳'=>'辽宁省',
	'呼和浩特'=>'内蒙古自治区',
	'石家庄'=>'河北省',
	'太原'=>'山西省',
	'西安'=>'陕西省',
	'济南'=>'山东省',
	'乌鲁木齐'=>'新疆维吾尔族自治区',
	'拉萨'=>'西藏自治区',
	'西宁'=>'青海省',
	'兰州'=>'甘肃省',
	'银川'=>'宁夏回族自治区',
	'郑州'=>'河南省',
	'南京'=>'江苏省',
	'武汉'=>'湖北省',
	'杭州'=>'浙江省',
	'合肥'=>'安徽省',
	'福州'=>'福建省',
	'南昌'=>'江西省',
	'长沙'=>'湖南省',
	'贵阳'=>'贵州省',
	'成都'=>'四川省',
	'广州'=>'广东省',
	'昆明'=>'云南省',
	'南宁'=>'广西壮族自治区',
	'海口'=>'海南省',
	'香港'=>'香港特别行政区',
	'澳门'=>'澳门特别行政区',
	'台北县'=>'台湾省'
);


$f_in = fopen('city_codes.txt', 'r');
$f_out = fopen('city_codes.php', 'w');

fwrite($f_out, '<?php'."\r\n");
fwrite($f_out, '$city_codes = array();'."\r\n");

$current_province_id = '';
$current_city_id = '';

while (!feof($f_in)) {
    $line = fgets($f_in, 4096);
	$line = trim($line);

	if($line=='') continue;

	$line_parts = explode('=', $line);

	$province_id = substr($line_parts[0], 0, 5);	// 省
	$city_id = substr($line_parts[0], 5, 2);		// 市
	$district_id = substr($line_parts[0], 7, 2);	// 县

	
	// 4 个直辖市，特殊处理
	if( in_array($province_id, array('10101','10102','10103','10104') ) )
	{

		if($current_province_id!=$province_id)
		{
			$current_province_id = $province_id;

			$province = $line_parts[1];
			if(array_key_exists( $line_parts[1], $capital_to_province) ) $province = $capital_to_province[$line_parts[1]];
			fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][0] = \''.$province.'\';'."\r\n");
		}

		if($current_city_id!=$city_id)
		{
			$current_city_id = $city_id;
			if($current_city_id=='01')
			{
				fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][\''.$current_city_id.'00\'][0] = \'市中心\';'."\r\n");
			}
			else
			{
				fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][\''.$current_city_id.'00\'][0] = \''.$line_parts[1].'\';'."\r\n");
			}
		}
	}
	else
	{
		if($current_province_id!=$province_id)
		{
			$current_province_id = $province_id;

			$province = $line_parts[1];
			if(array_key_exists( $line_parts[1], $capital_to_province) ) $province = $capital_to_province[$line_parts[1]];
			fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][0] = \''.$province.'\';'."\r\n");
		}

		if($current_city_id!=$city_id)
		{
			$current_city_id = $city_id;
			fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][\''.$current_city_id.'\'][0] = \''.$line_parts[1].'\';'."\r\n");
		}

		if($district_id!='00')	// 县
		{
			if( $district_id=='01')
			{
				fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][\''.$current_city_id.'\'][\''.$district_id.'\'] = \'市区\';'."\r\n");
			}
			else
			{
				fwrite($f_out, '$city_codes[\''.$current_province_id.'\'][\''.$current_city_id.'\'][\''.$district_id.'\'] = \''.$line_parts[1].'\';'."\r\n");
			}
			
		}
	}
}
fclose($f_in);

fwrite($f_out, '?>');
fclose($f_out);
?>