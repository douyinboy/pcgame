/*====================================
复制图片URL
obj 对象名
=====================================*/ 
function CopyToBbs(obj)
{
	var obj=document.getElementById(obj);
	var obj=obj.createTextRange();
	obj.execCommand("Copy");
	alert('图片复制成功，您现在可以复制到论坛上去了！');
}
/*====================================
复制网页URL
obj 对象名
=====================================*/ 
function CopyUrl(obj)
{
	var obj=document.getElementById(obj);
	var obj=obj.createTextRange();
	obj.execCommand("Copy");
	alert('网页链接复制成功，您现在可以复制任何地方发送给好友了！');
}
/*=======================================
加入收藏函数
=========================================*/
function AddFavorite(url,tit)
{
	window.external.addFavorite(url,tit);
}
/*===========================================
控制图片大小，以免撑坏页面
obj 图片对象的父对象

function ControlImg(obj)
{
	var obj = document.getElementById(obj);
	if(obj.width > 700)
	{
		obj.width = 700;
	}
}
=============================================*/