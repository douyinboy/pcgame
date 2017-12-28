<?php
class Paging {
									
	protected $recordTotal;			//记录总数
	protected $pageSize;				//每页记录条数	
	protected $currentPage; 			//当前页的页码
	protected $requestPage;			//请求页的页码，等同$this->currentPage属性
	protected $overlap;				//相邻的页，下一页重叠上一页末尾部分记录的条数
	
	protected $pageCount;				//总页数
	
	protected $limitOffset = 0;		//数据库查询的limit子句指定的起点
	protected $limitLength;			//数据库查询的limit子句指定的记录条数(等同 $this->pageSize属性)
	protected $limit = '';			//筛选记录的 SQL limit 子句
	
	protected $pageStart = 0;			//当前页实际起始记录（在所有记录中 从1开始数，因此其值一般来说比$this->limitOffset 大1）
	protected $pageEnd = 0;			//当前页实际结束记录
	protected $pageRecordCount = 0;		//当前页实际记录数

	protected $first = 0;			//第一页页码
	protected $last = 0;			//最后一页页码
	protected $prev = 0;			//上一页页码
	protected $next = 0;			//下一页页码

	
	//构造函数(参数如下，或者以一个以下列变量名为下标的数组作为参数)
	//参数$recordTotal		为记录总数
	//参数$pageSize			为每页记录数，默认12
	//参数$requestPage		为当前要请求的页码，默认1
	//参数$overlap 			两相邻的页之间，下一页开头将会重叠上一页末尾部分记录的条数，默认0
	function __construct($recordTotal = 0,$requestPage = 1,$pageSize = 12,$overlap = 0){
		if( func_num_args() == 1 && is_array( $recordTotal )){
			$this->init($recordTotal );
		}else{
			$this->init($recordTotal,$requestPage,$pageSize,$overlap);
		}
	}
	
	function Paging($recordTotal = 0,$requestPage = 1,$pageSize = 12,$overlap = 0){
		if( func_num_args() == 1 && is_array( $recordTotal )){
			$this->init($recordTotal );
		}else{
			$this->init($recordTotal ,$requestPage ,$pageSize ,$overlap );
		}
	}
	
	function init($recordTotal = 0,$requestPage = 1,$pageSize = 12,$overlap = 0){
		if( func_num_args() == 1 && is_array( $recordTotal )){
			if( isset($recordTotal['requestPage']) )
			$requestPage 	= $recordTotal['requestPage'];
			if( isset($recordTotal['pageSize']) )
			$pageSize 	= $recordTotal['pageSize'];
			if( isset($recordTotal['overlap']) )
			$overlap 	= $recordTotal['overlap'];
			if( isset($recordTotal['recordTotal']) )
			$recordTotal 	= $recordTotal['recordTotal'];
		}
		$this->recordTotal 	= !empty($recordTotal) && intval($recordTotal)>0 ? intval($recordTotal):0;
		$this->pageSize 		= !empty($pageSize) && intval($pageSize)>0 ? intval($pageSize):12;
		$this->requestPage 	= !empty($requestPage) && intval($requestPage)>1 ? intval($requestPage):1;
		$this->overlap 		= !empty($overlap) && intval($overlap) > 0 && intval($overlap) < $this->pageSize ? intval($overlap) : 0;

		$this->limitLength 		= &$this->pageSize;
		$this->currentPage 		= &$this->requestPage;
		
		$this->pageCount = intval( ceil( $this->recordTotal/($this->limitLength - $this->overlap) ) ) ;		
		
		//修正请求的页码(超出范围，将就近到正确范围内)
		if($this->currentPage > $this->pageCount)
			$this->currentPage = $this->pageCount;
		if($this->currentPage < 1)
			$this->currentPage = 1;
		if($this->pageCount >= 0){
			$this->limitOffset = ($this->currentPage - 1)*($this->limitLength - $this->overlap);
			$this->limit = ' '.$this->limitOffset.','.$this->limitLength.' ';
			$this->pageStart = $this->limitOffset+1;
			$this->pageEnd = $this->currentPage == $this->pageCount?$this->recordTotal:$this->limitOffset+$this->limitLength;
			$this->pageRecordCount = $this->pageEnd - $this->limitOffset ;
			$this->first = 1;
			$this->last = $this->pageCount;
			$this->prev = $this->currentPage>1?$this->currentPage-1:1;
			$this->next = $this->currentPage < $this->pageCount?$this->currentPage+1:$this->pageCount;
		}
		return $this;
	}
	

	//用魔术方法获取属性
	function __get($proName){
		return $this->$proName;
	}
	
	
	
	//获取离当前页最近的指定个数的页码列表
	//参数$centerPageNoCount 指定列表中页码的个数
	//参数$removeStarts 当当前页靠前时，最多排除当前页之前的前几页不算在中间列表内，默认0不排除
	//参数$removeEnds 当当前页靠后时，最多排除后几页，默认等同$removeStarts
	function centerPageNo($centerPageNoCount = 7,$removeStarts = 0,$removeEnds = -1){
		if( !is_int($centerPageNoCount) || $centerPageNoCount < 1 ){
			throw new Exception('参数不正确：方法'.__METHOD__.'第一个参数为中间页码个数，必须是大于0的整数！');
		}
		$removeStarts = intval($removeStarts)>=0 ? intval($removeStarts) : 0;
		$removeEnds = intval($removeEnds)>=0 ? intval($removeEnds) : $removeStarts;
		$pageNoList = array();
		if($this->pageCount == 0 ){
			return array();
		}else if($this->pageCount == 1 ){
			return array($this->currentPage);
		}else{
			$start = $removeStarts + 1;
			$end = $this->pageCount - $removeEnds ;
			if( $start > $this->currentPage ){
				$start = $this->currentPage;
				
			}
			if( $end < $this->currentPage ){
				$end = $this->currentPage;
			}
			if( $start >= $end ){
				return array($this->currentPage);
			}
			$listStart = intval($this->currentPage - floor(($centerPageNoCount-1)/2));
			$listEnd = intval($this->currentPage + ceil(($centerPageNoCount-1)/2));
			if( $listStart >= $start && $listEnd <= $end ){
				$pageNoList = range($listStart,$listEnd);
			}elseif( $listStart < $start && $listEnd > $end ){
				$pageNoList = range($start,$end);
			}elseif( $listStart < $start && $listEnd <= $end ){
				$steps = $start-$listStart;
				for($i = 0;$i < $steps && $listEnd < $end;$i++){
					$listEnd++;
				}
				$pageNoList = range($start,$listEnd);
			}elseif( $listStart >= $start && $listEnd > $end ){
				$steps = $listEnd-$end;
				for($i = 0;$i < $steps && $listStart > $start;$i++){
					$listStart--;
				}
				$pageNoList = range($listStart,$end);
			}
		}
		return $pageNoList;
	}
	
	//获取包含省略号页码列表的数组（如 array(1,'...',5,6,7,8,9,'...',99) ）
	//参数 $centerPageNoCount 为中间页码的个数
	//参数 $retainStarts 当当前页靠后时，最前(前一个省略号前)至少保留页码个数，默认值1
	//参数 $retainEnds 当当前页靠前时，最后(后一个省略号后)至少保留页码个数，默认等同$retainStars，（注意：默认值非-1，而是等同$retainStars）
	//返回包含这些页码的数组（索引式数组）
	function abbrPageNo($centerPageNoCount = 7, $retainStarts = 1, $retainEnds = -1){
		if($this->pageCount == 0){
			return array();
		}elseif($this->pageCount == 1){
			return array(1);
		}else{
			$retainStarts = intval($retainStarts)>=0 ? intval($retainStarts) : 1;
			$retainEnds = intval($retainEnds)>=0 ? intval($retainEnds) : $retainStarts;
			//获取含中间页码列表的数组（如 1,...,5,6,7,8,9,...,99中的 5,6,7,8,9;即除去第一页和最后一页，中间最靠近当前页应该显示的页码）
			$pageNoList = $this->centerPageNo($centerPageNoCount,$retainStarts , $retainEnds);
			//将页码列表补充完整
			$lastOfCenter = $pageNoList[count($pageNoList)-1];
			if( $retainEnds > 0 )
			if($lastOfCenter < $this->pageCount - $retainEnds -1 ){
				$pageNoList[] = '...';
				for($i = $this->pageCount - $retainEnds +1 ; $i <= $this->pageCount ; $i++){
					$pageNoList[] = $i;
				}
			}else{
				for($i = $lastOfCenter +1 ; $i <= $this->pageCount ; $i++){
					$pageNoList[] = $i;
				}
			}
			if( $retainStarts > 0 )
			if( $pageNoList[0] > $retainStarts +2){
				array_unshift($pageNoList,'...');
				for($i = $retainStarts ; $i >=1 ; $i--){
					array_unshift($pageNoList , $i);
				}
			}else{
				for($i = $pageNoList[0]-1 ; $i >=1 ; $i--){
					array_unshift($pageNoList , $i);
				}
			}
			return $pageNoList;
		}
	}
	
	//所有页码的数组
	//参数$sortType 指定排序方式，默认"asc"(升序)，传入"desc"(不区分大小写)为降序，其他均为升序
	function fullPageNo($sortType = 'asc'){
		if( $this->pageCount == 0 ){
			return array();
		}elseif(strtolower($sortType) == 'desc'){
			$res = range($this->pageCount,1);
			return $res;
		}else{
			return range(1,$this->pageCount);
		}
	}
	
	
	//将含省略号的页码数组转成详尽信息的模板可用的页码列表
	//参数$buildUrlFunc:			创建url的回调函数名
	//参数$buildUrlFuncArgs:		传给回调一般参数(作为回调函数第二个参数传给回调函数,可选)
	//(页码作为回调函数的一个参数传给回调函数)
	//参数$centerPageNoCount:		中间页码个数
	//参数$retainStarts:			最前(前一个省略号前)至少保留的页码个数
	//参数$retainEnds:				最后(后一省略号后)至少保留的页码个数(设为0则则对应)
	//说明:=============================================
	//传入的回调函数可有三种形式
	//1.普通函数,此时$buildUrlFunc 为函数名字符串
	//	例如:function cdsUrl($pageNo,$args){return 'http://www.cds.com/index.php?'.implode('&',$args).'&page='.$pageNo;}
	//2.对象的方法,此时$buildUrlFunc 为一数组，数组第一个元素为对象，第二个元素为其方法名，
	//	回调的方法与1中定义的普通函数类似
	//3.类的静态方法(实际只要不含$this的方法都可以),此时$buildUrlFunc 为一数组,数组第一个元素为类名，第二个元素为其静态方法名，
	//	回调的方法与1中定义的普通函数类似
	//暂不支持类的动态方法调用，如需要调用动态方法可以先实例化类，以上述第2中方式实现调用
	function abbrList($buildUrlFunc =null,$buildUrlFuncArgs=null,$centerPageNoCount = 7, $retainStarts = 1, $retainEnds = -1){
		
		$retainStarts = intval($retainStarts)>=0 ? intval($retainStarts) : 1;
		$retainEnds = intval($retainEnds)>=0 ? intval($retainEnds) : $retainStarts;
		$pageNoList = $this->abbrPageNo($centerPageNoCount,$retainStarts,$retainEnds);
		$result = array();
		foreach($pageNoList as $key=>$val){
			if($val == '...' ){
				$result[$key]['pageNo'] = '...';
				if(isset($buildUrlFunc))
				$result[$key]['pageUrl'] = '';
				$result[$key]['valid'] = 0;
			}else{
				$result[$key]['pageNo'] = $val;
				if(isset($buildUrlFunc))
				$result[$key]['pageUrl'] = call_user_func($buildUrlFunc,$val,$buildUrlFuncArgs);
				$result[$key]['current'] = intval($val == $this->currentPage);
				$result[$key]['valid'] = 1;
			}
		}
		return $result;
	}
	
	//全部的页码列表
	//参数$buildUrlFunc:			创建url的回调函数名
	//参数$buildUrlFuncArgs:		传给回调一般参数(作为回调函数第二个参数传给回调函数,可选)
	//参数$sortType 指定排序方式，默认"asc"(升序)，传入"desc"(不区分大小写)为降序，其他均为升序
	function fullList($buildUrlFunc =null,$buildUrlFuncArgs=null,$sortType = 'asc'){
		
		$pageNoList = $this->fullPageNo($sortType);
		$result = array();
		foreach($pageNoList as $key=>$val){
			$result[$key]['pageNo'] = $val;
			if(isset($buildUrlFunc))
			$result[$key]['pageUrl'] = call_user_func($buildUrlFunc,$val,$buildUrlFuncArgs);
			$result[$key]['current'] = intval($val == $this->currentPage);
		}
		return $result;
	}
	
	//获取上一页信息
	function prevInfo($buildUrlFunc = null,$buildUrlFuncArgs = null){
		$prevInfo['pageNo'] = $this->prev;
		if(isset($buildUrlFunc))
		$prevInfo['pageUrl'] = call_user_func($buildUrlFunc,$this->prev,$buildUrlFuncArgs);
		$prevInfo['current'] = intval($this->prev == $this->currentPage );
		return $prevInfo;
	}
	
	//获取下一页信息
	function nextInfo($buildUrlFunc,$buildUrlFuncArgs = null){
		$nextInfo['pageNo'] = $this->next;
		if(isset($buildUrlFunc))
		$nextInfo['pageUrl'] = call_user_func($buildUrlFunc,$this->next,$buildUrlFuncArgs);
		$nextInfo['current'] = intval($this->next == $this->currentPage );
		return $nextInfo;
	}
	
	//获取第一页信息
	function firstInfo($buildUrlFunc,$buildUrlFuncArgs = null){
		$firstInfo['pageNo'] = $this->first;
		if(isset($buildUrlFunc))
		$firstInfo['pageUrl'] = call_user_func($buildUrlFunc,$this->first,$buildUrlFuncArgs);
		$firstInfo['current'] = intval($this->first == $this->currentPage );
		return $firstInfo;
	}
	
	//获取最后一页信息
	function lastInfo($buildUrlFunc,$buildUrlFuncArgs = null){
		$lastInfo['pageNo'] = $this->last;
		if(isset($buildUrlFunc))
		$lastInfo['pageUrl'] = call_user_func($buildUrlFunc,$this->last,$buildUrlFuncArgs);
		$lastInfo['current'] = intval($this->last == $this->currentPage );
		return $lastInfo;
	}
	
	//一个 __call() 方法实现上面4个方法
	function __call($funcName,$funcArgs = null){
		// if(in_array($funcName,array('prevInfo','nextInfo','firstInfo','lastInfo'))){
			// $str = str_replace('Info','',$funcName);
			// $res['pageNo'] = $this->$str;
			// if(isset($funcArgs[0]))
			// $res['pageUrl'] = call_user_func($funcArgs[0],$this->$str,$funcArgs[1]);
			// $res['current'] = intval($this->$str == $this->currentPage );
			// return $res;
		// }else{
			//调用未定义方法
			throw new Exception('Call to undefined method '.__CLASS__.'::'.$funcName.'()');
		// }
		
	}
	
	//输出最常用的分页信息
	function pagingInfo($buildUrlFunc =null,$buildUrlFuncArgs=null,$centerPageNoCount = 7, $retainStarts = 1, $retainEnds = -1){
		$result = array();
		if( $this->pageCount > 0 ){
			
			$result['abbrList'] = $this->abbrList($buildUrlFunc,$buildUrlFuncArgs,$centerPageNoCount,$retainStarts,$retainEnds);
					
			$result['prev'] = $this->prevInfo($buildUrlFunc,$buildUrlFuncArgs);
			$result['next'] = $this->nextInfo($buildUrlFunc,$buildUrlFuncArgs);
			$result['first'] = $this->firstInfo($buildUrlFunc,$buildUrlFuncArgs);
			$result['last'] = $this->lastInfo($buildUrlFunc,$buildUrlFuncArgs);
			
			$result['recordTotal'] = $this->recordTotal;
			$result['pageSize'] = $this->pageSize;
			$result['currentPage'] = $this->currentPage;
			$result['requestPage'] = $this->requestPage;
			$result['overlap'] = $this->overlap;
			
			$result['limitOffset'] = $this->limitOffset;
			$result['limitLength'] = $this->limitLength;
			$result['limit'] = $this->limit;
			
			$result['pageCount'] = $this->pageCount;
			$result['pageStart'] = $this->pageStart;
			$result['pageEnd'] = $this->pageEnd;
			$result['pageRecordCount'] = $this->pageRecordCount;
			
			if(isset($buildUrlFunc))
			$result['replacePageNoUrl'] = call_user_func($buildUrlFunc,'hereReplacePageNo',$buildUrlFuncArgs);
		}
		return $result;
	}
	
}
function Paging($recordTotal = 0,$pageSize = 12,$requestPage = 1,$overlap = 0){
	if( func_num_args() == 1 && is_array( $recordTotal )){
		return new Paging($recordTotal);
	}else{
		return new Paging($recordTotal,$pageSize,$requestPage,$overlap);
	}
}

?>