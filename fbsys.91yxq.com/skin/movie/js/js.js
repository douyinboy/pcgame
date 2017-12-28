function check(obj) 
{
	var obj = document.frames['Editor'].document.all.obj;
	if(obj.length == '')
	{
		alert('内容不能为空！');
	}
	else if(obj.length >1000)
	{
		alert('字数超过系统限制 1000！');	
	}
	else
	{
		return true;
	}
}

function facomm(id)
{

	return document.getElementById(id).focus();

}
function copycode(obj) 
{
	var obj=document.getElementById(obj); 
    var   o=document.body.createTextRange();   
    o.moveToElementText(obj);  
    //o.select();  
    o.execCommand("Copy");
	alert('代码复制成功！')
}
function toggle_collapse(obj) 
{
	var obj=document.getElementById(obj);
	if(obj.style.display == 'none')
	{
		obj.style.display = 'block';
	}
	else
	{
		obj.style.display = 'none';
	}
}