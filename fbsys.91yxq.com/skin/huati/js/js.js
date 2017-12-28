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