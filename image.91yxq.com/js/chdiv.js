// JavaScript Document
function nTabs(thisObj,Num){
if(thisObj.className == "li_a")return;
//li_a是默认显示样式 li_o 是触发事件后样式
var tabObj = thisObj.parentNode.id;
var tabList = document.getElementById(tabObj).getElementsByTagName("div");
//“div”是目标类型，更改表格就用"table"
for(i=0; i <tabList.length; i++)
{
  if (i == Num)
  {
   thisObj.className = "li_a"; 
      document.getElementById(tabObj+"_Content"+i).style.display = "block";
  }else{
   tabList[i].className = "li_o"; 
   document.getElementById(tabObj+"_Content"+i).style.display = "none";
  }
} 
}