<?php

/*
@版本日期: 2013年11月17日
@著作权所有: 1024 intelligence ( http://www.1024i.com )

获得使用本类库的许可, 您必须保留著作权声明信息.
报告漏洞，意见或建议, 请联系 Lou Barnes(iua1024@gmail.com)
*/
class weather
{

	private $cache_dir = 'cache';
	private $error = null;

	public function __construct()
	{
		$cache_dir = $this->cache_dir.DIRECTORY_SEPARATOR;
		if(!file_exists($cache_dir))
		{
			mkdir($cache_dir, 0700);
		}
	}

		// 析构函数
	public function __destruct(){}


	// 获取省份列表
	public function get_provices()
	{
		include 'city_codes'.DIRECTORY_SEPARATOR.'city_codes.php';
		
		$provices = array();
		foreach($city_codes as $key=>$arr)
		{
			$provices[$key] = $arr[0];
		}		
		return $provices;
	}

	// 获取指定省下的城市列表
	public function get_cities( $provice_id )
	{
		include 'city_codes'.DIRECTORY_SEPARATOR.'city_codes.php';

		$cities = array();
		foreach($city_codes[$provice_id] as $key=>$val)
		{
			if(is_array($val))
			{
				$cities[$key] = $val[0];
			}
		}
		return $cities;
	}

	// 获取指定省市下的县或区列表
	public function get_districts( $provice_id, $city_id )
	{
		include 'city_codes'.DIRECTORY_SEPARATOR.'city_codes.php';

		$districts = array();
		foreach($city_codes[$provice_id][$city_id] as $key=>$val)
		{
			if($key!='0')
			{
				$districts[$key] = $val;
			}
		}
		return $districts;
	}
	
    private function set_error($error)
    {
        $this->error = $error;
    }

    public function get_error()
    {
        return $this->error;
    }

}
?>