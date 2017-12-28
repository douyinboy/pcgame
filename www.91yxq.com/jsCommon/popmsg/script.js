var popmsg = {
    goUrl : '', //如果不为空，弹出消息后跳转至该地址
    ID : function(id) {
        var type =typeof(id);
        if(type == 'object') return id;
        if(type == 'string') return document.getElementById(id);
        return null;
    },
    loadCss : function(file){
        var head = document.getElementsByTagName("head")[0],
            css  = document.createElement("link");
        css.type = "text/css";
        css.rel = "stylesheet";
        css.href = file;
        head.insertBefore(css,head.firstChild);//head.appendChild(css);//后插可能效率差点
    },
    insertHtml : function(html){
        var frag = document.createDocumentFragment();
        var div = document.createElement("div");
        div.innerHTML = html;
        for (var i = 0, ii = div.childNodes.length; i < ii; i++) {
            frag.appendChild(div.childNodes[i]);
        }
        document.body.insertBefore(frag,document.body.firstChild);//document.body.appendChild(frag);//后插可能效率差点
    },
    mark : function(show) {
        var fbg = popmsg.ID("__frame__");
        if(!fbg){
            var html;
            html = '<div id="__frame__" style="display:none;position:absolute;top:0;left:0;background:#000;filter:alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity: 0.4;opacity: 0.4;z-index:9999;border:none;width:100%;">';
            html += '<iframe scrolling="no" frameborder="0" marginheight="0" marginwidth="0" style="width:100%;height:100%;border:none;filter:alpha(opacity=0);-moz-opacity:0;-khtml-opacity: 0;opacity:0;">';
            html += '</iframe>';
            html += '</div>';
            popmsg.insertHtml(html);
        }
        fbg = popmsg.ID("__frame__");
        if(show){
            fbg.style.height = popmsg.getDocHeight() + "px";
            fbg.style.display = "";
            //document.documentElement.style.overflow = "hidden";
        }else{
            fbg.style.display = "none";
            //document.documentElement.style.overflow = "auto";
        }
    },
    ie6 : function(){
        return ((window.XMLHttpRequest == undefined) && (ActiveXObject != undefined));
    },
    getWindow : function(){
        var myHeight = 0;
        var myWidth = 0;
        if(typeof(window.innerWidth) == 'number'){//Non-IE
            myHeight = window.innerHeight;
            myWidth = window.innerWidth;
        }else if(document.documentElement){//标准模式
            myHeight = document.documentElement.clientHeight;
            myWidth = document.documentElement.clientWidth;
        }else if(document.body){//非标准模式
            myHeight = document.body.clientHeight;
            myWidth = document.body.clientWidth;
        }
        return {'height':myHeight,'width':myWidth};
    },
    getScroll : function(){
        var myHeight = 0;
        var myWidth = 0;
        if(typeof(window.pageYOffset) == 'number'){//Non-IE
            myHeight = window.pageYOffset;
            myWidth = window.pageXOffset;
        }else if(document.documentElement){//标准模式
            myHeight = document.documentElement.scrollTop;
            myWidth = document.documentElement.scrollLeft;
        }else if(document.body){//非标准模式
            myHeight = document.body.scrollTop;
            myWidth = document.body.scrollLeft;
        }
        return {'height':myHeight,'width':myWidth};
    },
    getDocHeight : function(D){
        if(!D) var D = document;
        return Math.max(
            Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
            Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
            Math.max(D.body.clientHeight, D.documentElement.clientHeight)
        );
    },
    addEvent : function(element, type, handler) {
        var ele = popmsg.ID(element);
        if (!ele) return;
        if (ele.addEventListener) ele.addEventListener(type, handler, false);//Mozilla
        else if (ele.attachEvent) ele.attachEvent("on" + type, handler);//IE
        else ele["on" + type] = handler
    },
    center : function(id){
         var id = popmsg.ID(id);
         var ie6 = popmsg.ie6();
         var win = popmsg.getWindow();//浏览器窗口宽度和高度
         var ele = {'height':id.clientHeight,'width':id.clientWidth};//元素对象的宽度和高度
         if(ie6){
             var scrollBar = popmsg.getScroll(); //滚动条宽度和高度
         }else{
             var scrollBar = {'height':0,'width':0};//用fixed定位不需要考虑滚动条
             id.style.position = 'fixed';
         }
         ele.top = parseInt((win.height-ele.height)/2+scrollBar.height);
         ele.left = parseInt((win.width-ele.width)/2+scrollBar.width);
         id.style.top = ele.top + 'px';
         id.style.left = ele.left + 'px';
    },
    floatCenter : function(id){
        popmsg.center(id);
        var fun = function(){popmsg.center(id);};
        if(popmsg.ie6()){
            popmsg.addEvent(window,'scroll',fun);
            popmsg.addEvent(window,'resize',fun);
        }else{
            popmsg.addEvent(window,'resize',fun);
        }
    },
    draw : function(){
        var html;
        html = '<div id="popmsg">';
        html += '<div id="popmsg_title_box">';
        html += '<span id="popmsg_title">系统提示</span>';
        html += '<a id="popmsg_close" href="javascript:void(0);" onclick="popmsg.hide();"></a>';
        html += '</div>';
        html += '<div id="popmsg_content"></div>';
        html += '<div id="popmsg_footer"><input type="button" class="b2" value="确 定" id="popmsg_confirm" onclick="popmsg.hide();" /></div>';
        html += '</div>';
        popmsg.insertHtml(html);
    },
    setTitle:function(title){
        if(popmsg.ID("popmsg") == null){
            popmsg.draw();
        }
        popmsg.ID("_dialog_title").innerHTML = title;
    },
    show:function(msg){
        var id = popmsg.ID("popmsg"); 
        if(id == null){
            popmsg.draw();
            id = popmsg.ID("popmsg"); 
        }
        popmsg.mark(1);
        popmsg.ID('popmsg_content').innerHTML = msg;
        id.style.display = 'block';
        popmsg.floatCenter(id);
    },
    hide: function() {
        popmsg.mark(0);
        var id = popmsg.ID("popmsg");
        id.style.display = 'none';
        if(popmsg.goUrl!=''){
            window.location.href = popmsg.goUrl;
        }
    }
}
//////////////
popmsg.loadCss('http://www.6qwan.com/jsCommon/popmsg/style.css');