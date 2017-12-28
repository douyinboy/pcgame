$(function () {

    var screenWidth = $(window).width();    //屏幕宽度
    var screenHeight = $(window).height();  //屏幕高度
    var body = $('body');                   //body
    var top = $('#i_top');                  //顶部
    var left = $('#i_left');                //左边
    var right = $('#i_right');              //右边
    var iframes = $('#url_mainframe');      //游戏嵌套iframe
    var topCss;

    if(screenWidth <= 1366){
        $('.i_top_gonggao a').css('width','200px');
    }else{
        $('.i_top_gonggao a').css('width', 'auto');
    }

    //自适应屏幕变化
    $(window).resize(function () {
        screenWidth = $(window).width();        //屏幕宽度
        screenHeight = $(window).height();      //屏幕高度
        var leftTop = $('#i_left').css('top');  //左栏top值
        _initialization(screenWidth, screenHeight, leftTop);

        if(screenWidth <= 1366){
            $('.i_top_gonggao a').css('width','200px');
        }else{
            $('.i_top_gonggao a').css('width', 'auto');
        }
    });

    _initialization(screenWidth, screenHeight);

    //左栏收缩触发
    $('#i_left_drawbank_btn').click(function(){
        left.toggleClass('i_left_drawbank');
        _initialization(screenWidth, screenHeight);
    });

    //左栏展开触发
    $('#i_left_open_btn').click(function(){
        left.toggleClass('i_left_drawbank');
        _initialization(screenWidth, screenHeight);
    });

    //初始化函数
    function _initialization(screenWidth, screenHeight, leftTop){

        if(leftTop && leftTop == '332px'){
            topCss = '332px';
        }else{
            topCss = '33px';
        }

        //---------------------- 各元素高度判断 ---------------------------
        if(body.hasClass('i_hideTop')){ //判断顶部是否收起 有class表示收起
            screenHeight -= 33; //匹配顶部高度
            left.css('top', '33px');
            right.css('top', '33px');
        }else{
            screenHeight -= 32; //匹配顶部高度
            left.css('top', topCss);
            right.css('top', topCss);
        }

        //---------------------- 各元素宽度判断 ---------------------------
        if(left.hasClass('i_left_drawbank')){ //判断左栏是否收起，有class表示收起
            right.css('left', '13px');
            right.css('width', screenWidth - 13 + 'px');
        }else{
            right.css('left', '176px');
            right.css('width', screenWidth - 176 + 'px');
        }

        //赋予左栏和右栏同样高度
        left.css('height', screenHeight + 'px');
        right.css('height', screenHeight + 'px');

        iframes.css('height', screenHeight + 'px');
    }



});