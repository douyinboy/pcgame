<?php

//自定义增加的调用函数请加到此行以下

function quote($str) { 
	$str=str_replace(array('[quote]','[/quote]','[br]'),array('<div class="quote"><table width=99% cellspacing=1 cellpadding=4 align=center border=0 bgcolor=#999999><tr bgcolor=#ffffee><td><span style="color:blue">','</span></td></tr></table><br></div>','<br />'),$str);

	return $str;
}

function PrevPage($PageNum,$CurrentPage,$sendVar){
	$PageNum--;
	$CurrentPage--;
	if($PageNum == '' || $PageNum == -1)
		return false;
	
	if($CurrentPage>0){
		if(($CurrentPage-1) == 0){
			$link1 = $sendVar;
		}else{
			$link1 = str_replace(".","_".($CurrentPage-1).".",$sendVar);
		}
		$Page=$Page."<a href='".$link1."' title='上一个图集'><span>上一个图集</span></a>";
	}
	return $Page;
}

function NextPage($PageNum,$CurrentPage,$sendVar){
	$PageNum--;
	$CurrentPage--;
	if($PageNum == '' || $PageNum == -1)
		return false;
	
	if($CurrentPage < $PageNum) {
		$link1 = str_replace(".","_".($CurrentPage+1).".",$sendVar);
		$Page = $Page."<a href='".$link1."' title='下一个图集'><span>下一个图集</span></a>";
	}
	
	return $Page;
}

function AClass($a){
	$str = @preg_replace("/class=\"list_p1_1/",' ',$a);
	$strarr = @explode('>', $str);	
	$strarr1 = @explode('</a', $strarr[1]);	
	return '<span class="httitle">'.@substr($strarr[0], 0, -2).'target="_blank">'.$strarr1[0].'</a></span>';
}
//自定义增加调用函数结束
?>