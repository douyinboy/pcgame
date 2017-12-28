var width = 396;//宽
var height = 447;//高
var time = 3000;//5秒
var now = 0;//默认显示第一个
var blockCount = 13;//分10块移动
var defer = 50;//块延迟基数
var order = 3;// 0(从上到下) 1(从下到上) 2(随机顺序) 3(随机出现012)
var blockHeight = Math.floor(height/blockCount);
var remain = new Array(pictureCount);
var direct;
var list = [];
document.write("<div class=\"scroller\" id=\"scroller\" style=\"width:"+width+"px\">");
document.write("<div class=\"flat\"><a style=\"width:"+width+"px;height:"+height+"px;\" id=\"flat\" href=\""+href[now]+"\"></a></div>");
document.write("<div class=\"guide\" id=\"guide\" style=\"margin-top:"+(height-23)+"px;margin-left:"+(width-125)+"px\">");
for(var i=0;i<pictureCount;i++)document.write("<p onclick=\"changeItem("+i+")\">"+parseInt(i+1)+"</p>");
document.write("</div>");
for(var i=0;i<blockCount;i++){
	document.write("<div class=\"block\" id=\"item"+i+"\" style=\"height:"+blockHeight+"px\">");
	for(var j=0;j<pictureCount;j++){
		document.write("<a href=\""+href[i]+"\" target=\"_blank\" title=\""+picturetitle[j]+"\">");
		document.write("<img src=\""+picture[j]+"\" width='"+width+"' height='"+height+"'>");
		document.write("</a>");
	}
	document.write("</div>");
	if(i>0)$("item"+i).scrollTop = i*blockHeight;
}
document.write("</div>");
for(var i=0;i<blockCount;i++)list[i] = i;
Array.prototype.chaos = function(){
	var randomNumber,temp;
	for(var i=0;i<this.length;i++){
		randomNumber = getRandom(0,this.length-1);
		temp = this[i];
		this[i] = this[randomNumber];
		this[randomNumber] = temp;
	}
}
Array.prototype.total = function(){
	var count=0;
	for(var i=0;i<this.length;i++){
		count += this[i];
	}
	return count;
}
function getRandom(start,end){
	var number = parseInt(Math.random()*(end-start+1));
	if(start>0)number++;
	return number;
}
function sortList(o){
	if(o==undefined)o=order;
	switch(o){
		case 0:
			list.sort();
			break;
		case 1:
			list.sort();
			list.reverse();
			break;
		case 2:
			list.chaos();
			break;
		case 3:
			sortList(getRandom(0,2));
			break;
	}
}
function $(element){return document.getElementById(element)}
function $$(parent,element){return parent.getElementsByTagName(element)}
function offset(i){
	var step = Math.ceil(remain[i]/10);
	if(step > 0){
		if(direct){
			$("item"+i).scrollTop += step;
		}else{
			$("item"+i).scrollTop -= step;
		}
		remain[i] -= step;
		setTimeout("offset("+i+")",10);
	}
}
function changeStyle(index,type){
	$$($("guide"),"p")[index].className = type?"now":"";
}
function changeItem(index){
	if(remain.total()>0)return;
	changeStyle(now,false);
	if(index==undefined){
		if(++now>=pictureCount)now=0;
	}else{
		if(index==now){
			changeStyle(now,true);
			return false;
		}else{
			now = index;
		}
	}
	changeStyle(now,true);
	$("flat").href = href[now];
	var offsetSize = now*height-$("item0").scrollTop;
	direct = offsetSize>0?1:0;
	if(order>1)sortList();
	for(var i=0;i<blockCount;i++){
		remain[list[i]] = Math.abs(offsetSize);
		setTimeout("offset("+list[i]+")",i*defer);
	}
}
changeStyle(now,true);
if(order>0)sortList();
$("flat").onmouseover = function(){clearInterval(auto)}
$("flat").onmouseout = function(){auto = setInterval("changeItem()",time);}
$("guide").onmouseover = function(){clearInterval(auto)}
var auto = setInterval("changeItem()",time);