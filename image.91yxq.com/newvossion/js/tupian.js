// JavaScript Document






$(document).ready(function(){

    $(".hotgame-pic").hover(
function () {
/*    $(this).find("img").stop(true).fadeTo(200, 1);*/
    $(this).find(".gamelist-hotzi").stop(false, true).animate({ top: '0' }, 300);
    $(this).find(".gamelist-hotjie").stop(false, true).animate({ top: '30' }, 300);
},
function () {
  /*  $(this).find("img").stop(true).fadeTo(200, 0.7);*/
    $(this).find(".gamelist-hotzi").stop(false, true).animate({ top: '95' }, 150);
    $(this).find(".gamelist-hotjie").stop(false, true).animate({ top: '125' }, 150);
})

$('#tab-con1 ul').imgChange({ thumbObj: '#tab-tit1 span', autoChange: 0, effect: 'scroll', vertical: 0 })


});


function ExChgClsName(Obj, NameA, NameB) {
    var Obj = document.getElementById(Obj) ? document.getElementById(Obj) : Obj;
    Obj.className = Obj.className == NameA ? NameB : NameA;
}
function showMenu(iNo) {
    ExChgClsName("Menu_" + iNo, "MenuBox", "MenuBox2");
}

