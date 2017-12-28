/**
 * Created with JetBrains WebStorm.
 * User: chenqiaohua
 * Date: 13-11-29
 * Time: 下午1:56
 * To change this template use File | Settings | File Templates.
 */

jQuery(function(){
    var imgList = $(".playImg .imgList").children("li");
    var imgIconList = $(".playImg .imgBtnList").children("a");
    var len = imgList.length;
    var iNow = 0;
    var iSpeed = 6000;
    var iOld = len - 1;
    // init
    var timer = setInterval(playImg, iSpeed);

    imgIconList.each(function(index){
       $(this).click(function(){
           iNow = index -1;
           playImg();
       });
    });

    $(".playImg .prev").click(function(){
       if(iNow <= 0){
           iNow = len;
       }
       iNow = iNow -2;
        playImg();
    });

    $(".playImg .next").click(function(){
        if(iNow >= len -1){
            iNow =-1;
        }
        playImg();
    })

    $(".playImg").hover(function(){
        clearInterval(timer);
    }, function(){
        timer = setInterval(playImg, iSpeed);
    });

    function playImg(){
        iOld = iNow;
        imgList.css({"opacity" : "0", "z-index" : "2"});
        imgList.eq(iOld).css({"opacity" : "0.5", "z-index": "3"});
        iNow++;
        if(iNow == imgList.length ){
            iNow = 0;
        }
        imgList.eq(iNow).css({"z-index" : "4"}).animate({ "opacity" : "1"},800);
        imgIconList.eq(iNow).addClass("now_a").siblings("a").removeClass("now_a");
    }

});

