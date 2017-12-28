<?php

include_once('../include/class/Paging.class.php');
$all_games = include('./api_allgames.php');

$type=empty($_GET['type'])?0:intval($_GET['type']);
$theme=empty($_GET['theme'])?0:intval($_GET['theme']);
$initial=empty($_GET['initial'])?0:intval($_GET['initial']);

$page = empty($_GET['page'])?1:intval($_GET['page']);

$callback = $_GET['callback'];

$filtered_games = array();

foreach($all_games as $key=>$val){
	if( ($type<=0 || $val['GameTypeId']==$type) && ($theme<=0 || $val['GameThemeId']==$theme) && ($initial<=0 || $val['GameInitialId']==$initial) ){
		$filtered_games[] = $val;
	}
}

$total = count($filtered_games);
$pageSize = 4;
$paging = new Paging($total,$page,$pageSize);
$page_games = array_slice($filtered_games,$paging->limitOffset,$paging->limitLength);




$gameListHtml = '';

foreach($page_games as $key=>$val){
	$gameListHtml .= '<li class="clearfix">'.
							'<div class="pic"><a href="'.$val['GameWeb'].'" target="_blank"><img src="'.$val['GameImg'].'" /></a></div>'.
							'<div class="txt">'.
								'<a style="display:block;" href="'.$val['GameWeb'].'" class="name" target="_blank">'.$val['GameName'].'</a>'.
								'<div class="text">'.$val['GameFeature'].'</div>'.
								'<div>'.
									'<a href="'.$val['ServerUrl'].'" class="btn1" target="_blank">进入游戏</a>'.
									'<span class="f14 ml15">'.
										'<a href="'.$val['GameWeb'].'" target="_blank">官网</a>'.
										'<span class="line">|</span>'.
										'<a href="'.$val['GiftUrl'].'" target="_blank">礼包</a>'.
									'</span>'.
								'</div>'.
							'</div>'.
						'</li>';
}
if( empty($gameListHtml) ){
	$gameListHtml = '<li class="clearfix">抱歉，没有找到符合条件的结果。</li>';
}
$gameListHtml = '<ul>'.$gameListHtml.'</ul>';


$pageListHtml = '';
if( $paging->pageCount > 1 ){
	$prevPage = $paging->prevInfo('getPageUrl');
	if( !$prevPage['current'] ){
		$pageListHtml .= '<a href="javascript:void(0);" onclick="'.$prevPage['pageUrl'].'" class="updow">&lt;</a>';
	}
	$pageList = $paging->abbrList('getPageUrl');
	foreach( $pageList as $key=>$val ){
		if( $val['pageNo']=='...' ){
			$pageListHtml .= '<span>...</span>';
		}
		elseif( $val['current'] ){
			$pageListHtml .= '<a href="javascript:void(0)" class="on">'.$val['pageNo'].'</a>';
		}
		else{
			$pageListHtml .= '<a href="javascript:void(0);" onclick="'.$val['pageUrl'].'">'.$val['pageNo'].'</a>';
		}
	}
	$nextPage = $paging->nextInfo('getPageUrl');
	if( !$nextPage['current'] ){
		$pageListHtml .= '<a href="javascript:void(0);" onclick="'.$nextPage['pageUrl'].'" class="updow">&gt;</a>';
	}
}
//echo $gameListHtml;
$result_arr = array(
	'gameListHtml'=>$gameListHtml,
	'pageListHtml'=>$pageListHtml
);



echo $callback.'('.json_encode($result_arr).')';

// echo "<pre>";
// print_r($paging);
// print_r($page_games);
// print_r($pageList);
// print_r($gameListHtml);
// print_r($pageListHtml);
// echo "</pre>";


// <a href="javascript:void(0);" class="updow">&lt;</a> 
                // <a href="javascript:void(0);">1</a>
                // <a href="javascript:void(0);">2</a>
                // <a href="javascript:void(0);">3</a>
                // <a href="javascript:void(0)" class="on">4</a>
                // <a href="javascript:void(0);">5</a>
                // <span>...</span>
                // <a href="javascript:ovid(0);">20</a>
                // <a href="javascript:ovid(0);" class="updow">&gt;</a>




function getPageUrl($page,$args=null){
	return 'jsonpGetGamesPage('.$page.')';
}




?>