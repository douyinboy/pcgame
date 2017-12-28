var login_tips = {
    form_name : '',
    formOffset : '',
    formWidth : '',
    formHeight : '',
    init : function(){
        login_tips.check_form_name();
        login_tips.formOffset = $(login_tips.form_name).offset();
        //login_tips.formWidth = $(login_tips.form_name).width();
        login_tips.formWidth = login_tips.eleWidth(login_tips.form_name);
        //login_tips.formHeight = $(login_tips.form_name).height();
        login_tips.formHeight = login_tips.eleHeight(login_tips.form_name);
        if(login_tips.formWidth<200) login_tips.formWidth = 200;
        if(login_tips.formHeight<108) login_tips.formHeight = 108;
    },
    check_form_name : function(){
        var form_name_arr = ['regLogObj0','login','loginform','frmLogin'];
        var len = form_name_arr.length;
        for(i=0;i<len;i++){
            if(document.getElementById(form_name_arr[i])!=null){
                login_tips.form_name = '#'+form_name_arr[i];
                return;
            }
        }
    },
    eleWidth : function(id){
        return Math.max( $(id)[0].clientWidth , $(id)[0].offsetWidth );
    },
    eleHeight : function(id){
        return Math.max( $(id)[0].clientHeight , $(id)[0].offsetHeight );
    },
    mark : function(){
        if(document.getElementById('login_mark')==null){
            var login_mark_html;
            login_mark_html = '<div id="login_mark" style="position:absolute;background:#FFF;filter:alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity: 0.4;opacity: 0.4;z-index:9999;border:none;z-index:100001">';
            login_mark_html += '<iframe scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="width:100%;height:100%;border:none;filter:alpha(opacity=0);-moz-opacity:0;-khtml-opacity: 0;opacity:0;">';
            login_mark_html += '</iframe>';
            login_mark_html += '</div>';
            $('body').prepend(login_mark_html);
        }else{
            $('#login_mark').show();
        }
        $('#login_mark').css({'top':login_tips.formOffset.top,'left':login_tips.formOffset.left}).width(login_tips.formWidth).height(login_tips.formHeight);
    },
    verify : function(){
        if(document.getElementById('login_verify')==null){
            var login_verify_html;
            login_verify_html = '<div id="login_verify" style="position:absolute;height:120px;width:190px;border:2px #bfd1eb solid;background:#f3faff;padding:3px;overflow:hidden;color:#000000;font-size:12px;z-index:100002">';
            login_verify_html += '<p style="margin:0;padding:0;text-align:center;line-height:28px;color:red;">请输入验证码：</p>';
            login_verify_html += '<p style="margin:0;padding:0;text-align:center;"><input type="text" name="verify_code" id="verify_code" onkeyup="login_tips.go_check_verify(event)" style="width:68px;height:20px;" /></p>';
            login_verify_html += '<p style="margin:0;padding:0;text-align:center;"><img id="login_verify_img" src="http://www.demo.com/chkcode.inc.php" onclick="this.src=\'http://www.demo.com/chkcode.inc.php?\'+Math.random();" alt="验证码,看不清楚?请点击刷新验证码" style="cursor:pointer;margin:5px;" /></p>';
            login_verify_html += '<p style="margin:0;padding:0;text-align:center;"><input type="button" value="继 续" onclick="login_tips.check_verify();" /></p>';
            login_verify_html += '</div>';
            $('body').prepend(login_verify_html);
        }else{
            $('#login_verify').show();
            $('#login_verify_img').click();
        }
        var obj = $('#login_verify');
        obj.css('top',login_tips.formOffset.top+((login_tips.formHeight-login_tips.eleHeight(obj))/2));
        obj.css('left',login_tips.formOffset.left+((login_tips.formWidth-login_tips.eleWidth(obj))/2));
        $('#verify_code').focus();
    },
    msg : function(msg){
        if(document.getElementById('login_msg')==null){
            var login_msg_html;
            login_msg_html = '<div id="login_msg" style="position:absolute;height:28px;line-height:28px;color:red;font-weight:bold;text-align:center;width:192px;border:2px #bfd1eb solid;background:#f3faff;padding:3px;overflow:hidden;font-size:12px;z-index:100002">';
            login_msg_html += '</div>';
            $('body').prepend(login_msg_html);
        }
        var obj = $('#login_msg');
        obj.css('display','block');//加上这句才能获得clientHeight/clientWidth
        obj.css('top',login_tips.formOffset.top+((login_tips.formHeight-login_tips.eleHeight(obj))/2));
        obj.css('left',login_tips.formOffset.left+((login_tips.formWidth-login_tips.eleWidth(obj))/2));
        obj.css('display','none');//为了下面的fadeIn
        obj.html(msg);
        obj.fadeIn(300);
    },
    show_verify : function(){
        login_tips.init();
        login_tips.mark();
        login_tips.verify();
    },
    hide_verify : function(){
        $('#login_mark').hide();
        $('#login_verify').hide();
    },
    hide_msg : function(){
        setTimeout(function(){$('#login_msg').fadeOut(300);$('#login_mark').fadeOut(300);},2000);
    },
    go_check_verify : function(e){
        var key = window.event ? e.keyCode : e.which;
        if(key.toString() == "13"){
            login_tips.check_verify();
        }
    },
    go_login : function(){
        if(typeof(sentLoginData)=='function'){
            sentLoginData();
        }else if(typeof(Login)=='function'){
            Login();
        }else if(typeof(chkFrmInfo)=='function'){
            chkFrmInfo();
        }
    },
    check_verify : function(){
        var verify_code = $('#verify_code').val();
        if(!verify_code) return false;
        $.getJSON('http://www.demo.com/api/check_login_verify.php?verify_code='+verify_code+'&callback=?',function (data){
            if(data){
                if(data.code=='10'){
                    login_tips.hide_verify();
                    login_tips.go_login();
                }else{
                    $('#login_verify_img').click();
                }
                $('#verify_code').val('');
            }
        });
    },
    show_msg : function(msg){
        login_tips.init();
        login_tips.mark();
        login_tips.msg(msg);
        login_tips.hide_msg();
    }
}