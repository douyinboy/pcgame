  $(function(){
    $('#input_label').click(function () {
          //登录时，点击保存用户名按钮事件
      if($(this).is(":checked")){
        $(this).val(1);
      }else{
              $(this).val(0);
      }
    });

  });

    function docheck(){
     var log_number = $(".log_number").val();
         var log_pass   = $(".log_pass").val();
         var reg = /^[0-9A-Za-z_]{4,20}$/;
      
  
       if(log_number == ""){
    alert('账号不能为空');
    return false;
       }
       if(!reg.test(log_number)){
           alert('账号必须由4-20位数字加字母组成 ');
    return false;
       }
       if(log_pass == ""){
    alert('密码不能为空');
    return false;
       }
       if(log_pass.length < 6 || log_pass.length > 18){
        alert('密码必须由6-18位数字加字母组成 ');
    return false;
       }

    return true;
      }

   function checkreg(){
     var reg_number = $(".reg_number").val();
         var reg_pass   = $(".reg_pass").val();
         var reg_affpass   = $(".reg_affpass").val();
         var reg = /^[\w]{4,20}$/;

       if(reg_number == ""){
    alert('账号不能为空');
    return false;
       }
       if(!reg.test(reg_number)){
        alert('账号必须由4-20位数字加字母组成 ');
    return false;
       }
       if(reg_pass == ""){
    alert('密码不能为空');
    return false;
       }
       if(reg_pass.length < 6 || reg_pass.length > 18){
        alert('密码必须由6-18位数字加字母组成 ');
    return false;
       }
       if(reg_affpass != reg_pass){
        alert('确认密码与密码不一致');
    return false;
       }

    return true;
  }