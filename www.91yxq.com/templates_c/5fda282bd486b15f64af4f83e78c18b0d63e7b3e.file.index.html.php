<?php /* Smarty version Smarty-3.0.6, created on 2017-12-22 14:19:39
         compiled from "E:\phpStudy\WWW\91yxq\www.91yxq.com\template\gamelogin/index.html" */ ?>
<?php /*%%SmartyHeaderCode:34855a3ca3fb50f4a3-45249903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fda282bd486b15f64af4f83e78c18b0d63e7b3e' => 
    array (
      0 => 'E:\\phpStudy\\WWW\\91yxq\\www.91yxq.com\\template\\gamelogin/index.html',
      1 => 1513923509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34855a3ca3fb50f4a3-45249903',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>demo游戏《<?php echo $_smarty_tpl->getVariable('game_name')->value;?>
》双线<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
服[<?php echo $_smarty_tpl->getVariable('game_name')->value;?>
]|精品游戏,尽在demo游戏平台!</title>
<link rel="stylesheet" type="text/css" href="http://www.demo.com/template/gamelogin/css/left.css">
<link rel="stylesheet" href="http://www.demo.com/template/gamelogin/css/top.css">
</head>
<body>
  <!--头部开始-->
  <div id="i_top">
    <a href="http://www.91yxq.com" target="_blank" class="logo"><img src="http://www.demo.com/template/gamelogin/images/slideup-logo.png"></a>
    <!-- end logo -->
    <div class="i_qufu"><p><b id="game_name"><?php echo $_smarty_tpl->getVariable('game_name')->value;?>
</b>-当前服务器：<b id="server_id"><?php echo $_smarty_tpl->getVariable('server_id')->value;?>
</b>服: <b id="server_name"><?php echo $_smarty_tpl->getVariable('server_name')->value;?>
</b></p></div>
    <!-- end 区服名 -->
    <div class="i_top_notice">
      <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2355520282&amp;site=qq&amp;menu=yes" target="_blank">充值超高返利 戳这里！</a>
    </div>
    <dl id="i_top_right">
      <dd><a href="http://h5.91yxq.com" target="_blank">H5游戏</a></dd>
      <dd><a target="_blank" href="http://www.91yxq.com/<?php echo $_smarty_tpl->getVariable('game_short_name')->value;?>
/xsk/index.html">新手礼包</a></dd>
      <dd><a target="_blank" href="http://www.91yxq.com/<?php echo $_smarty_tpl->getVariable('game_short_name')->value;?>
/xsk/index.html">官网</a></dd>
      <dd><a target="_blank" href="http://pay.91yxq.com/?game_id=<?php echo $_smarty_tpl->getVariable('game_id')->value;?>
&server_id=<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
">充值</a></dd>
      <dd><a target="_blank" href="###" onclick="return addFavorite(this)">收藏</a></dd>
      <dd>用户：<em id="my_username"><?php echo $_smarty_tpl->getVariable('user')->value;?>
</em></dd>
      <dd><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2355520282&amp;site=qq&amp;menu=yes" target="_blank">客服QQ：2355520282</a></dd>
      <dd>
        <a class="btn_all_game" href="http://www.91yxq.com/games/index.html" target="_blank">热门游戏</a>
        <!-- end 所有游戏 -->
      </dd><dd><a id="i_slideup_top"></a></dd>
    </dl>
    <!-- end 顶部右边 -->
  </div>
  <div id="i_slidedown_top"></div>
  <!--头部结束-->

  <!--左侧开始-->
  <div id="i_left">
    <input class="gameId" type="hidden" value="<?php echo $_smarty_tpl->getVariable('game_id')->value;?>
">
    <a href="" target="_blank" class="i_btn_download" title="下载微端"></a>
    <div class="i_left_item">
      <a href="http://pay.demo.com/?game_id=<?php echo $_smarty_tpl->getVariable('game_id')->value;?>
&server_id=<?php echo $_smarty_tpl->getVariable('server_id')->value;?>
" target="_blank" class="i_btn_link">在线充值</a>
    </div>
    <!-- end item -->
    <div class="i_left_item">
      <img src="http://www.demo.com/template/gamelogin/images/qrcode_gzh.png">
      <p>扫描官方二维码<br>更多惊喜等你拿</p>
    </div>
    <!-- end 二维码 -->
    <div class="i_left_item">
      <h3>客服QQ：</h3>
      <p><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2355520282&amp;site=qq&amp;menu=yes" target="_blank" style="font-size: 18px;">2355520282</a></p>
    </div>
    <!-- end item -->
    <div class="i_left_item">
      <h3>官网地址：</h3>
      <p><a href="http://www.demo.com" target="_blank" style="font-size: 18px;">www.demo.com</a></p>
      <p><a href="http://h5.91yxq.com" target="_blank" style="font-size: 18px;">h5.91yxq.com</a></p>
    </div>
    <!-- end item -->

    <div id="i_left_drawbank_btn"><span></span></div>
    <!-- end 左栏收缩 -->
    <div id="i_left_open_btn"><span></span></div>
    <!-- end 左栏展开 -->
  </div>
  <!--左侧结束-->

  <!--右侧开始-->
  <div id="i_right">
    <iframe id="url_mainframe" frameborder="0" src="<?php echo $_smarty_tpl->getVariable('game_url')->value;?>
"></iframe>
  </div>
  <!--右侧结束-->

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="http://www.demo.com/template/gamelogin/js/left.js"></script>
<script>
    var gameId = $('.gameId').val();
    var weiduan_arr = new Array();
    var bg_arr = new Array();
    weiduan_arr[1] = 'http://www.91yxq.com/hys/hys.exe';
    weiduan_arr[2] = 'http://www.91yxq.com/dpsc/dpsc.exe';
    weiduan_arr[3] = 'http://www.91yxq.com/rxhw/rxhw.exe';
    weiduan_arr[8] = 'http://www.91yxq.com/rxsg3/rxsg3.exe';

    bg_arr[1] = 'http://www.demo.com/template/gamelogin/images/hys.png';
    bg_arr[2] = 'http://www.demo.com/template/gamelogin/images/dpsc.png';
    bg_arr[3] = 'http://www.demo.com/template/gamelogin/images/rxhw.png';
    bg_arr[5] = 'http://www.demo.com/template/gamelogin/images/zgzn.png';
    bg_arr[6] = 'http://www.demo.com/template/gamelogin/images/czdtx.png';
    bg_arr[7] = 'http://www.demo.com/template/gamelogin/images/nslm.png';
    bg_arr[8] = 'http://www.demo.com/template/gamelogin/images/rxsg3.png';
    bg_arr[9] = 'http://www.demo.com/template/gamelogin/images/sd.png';
    bg_arr[11] = 'http://www.demo.com/template/gamelogin/images/xxd2.png';
    bg_arr[12] = 'http://www.demo.com/template/gamelogin/images/qyz.png';
    bg_arr[13] = 'http://www.demo.com/template/gamelogin/images/fyws.png';
    bg_arr[14] = 'http://www.demo.com/template/gamelogin/images/xsqst.png';
    bg_arr[15] = 'http://www.demo.com/template/gamelogin/images/dyjd.png';
    bg_arr[16] = 'http://www.demo.com/template/gamelogin/images/blr.png';
    bg_arr[17] = 'http://www.demo.com/template/gamelogin/images/rxjh.png';
    bg_arr[18] = 'http://www.demo.com/template/gamelogin/images/wszzl.png';
    bg_arr[19] = 'http://www.demo.com/template/gamelogin/images/cgtx.png';
    bg_arr[20] = 'http://www.demo.com/template/gamelogin/images/sywz.png';

    $('.i_btn_download').attr('href', "javascript:alert('该游戏暂无微端')");
    $('.i_btn_download').attr('href', weiduan_arr[gameId]);
    $('#i_left').css('background-image', "url(" + bg_arr[gameId] + ")");

</script>

  <script>
      $(function(){
          $('#i_slideup_top').on('click',function(){
              $('#i_top').hide();
                $('#i_left').css('top', '8px');
                $('#i_right').css('top', '8px');
                $('#i_slidedown_top').show();

          });
          $('#i_slidedown_top').on('click',function(){
              $('#i_top').show();
              $('#i_left').css('top', '38px');
              $('#i_right').css('top', '38px');
              $('#i_slidedown_top').hide();

          });
      });

      function addFavorite(thisElm) {
          var url = window.top.location.href;
          var title = window.top.document.title;
          if (window.external && ("addFavorite" in window.external)){
              window.external.addFavorite(url,title);
              return false;
          }
          else if(window.sidebar ){
              if("addPanel" in window.sidebar){
                  window.sidebar.addPanel(title, url, "customizeURL");
                  return false;
              }
              else{
                  thisElm.href = url;
                  thisElm.title = title;
                  return true;
              }
          }
          else{
              alert("抱歉，您所使用的浏览器无法完成此操作，请使用Ctrl+D进行添加");
              return false;
          }

      }
  </script>
</body>
</html>