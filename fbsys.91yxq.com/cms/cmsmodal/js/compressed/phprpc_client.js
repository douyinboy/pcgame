function phprpc_error(errno,errstr){this.errno=errno;this.errstr=errstr;}
function phprpc_client(){this.__url='';this.__encrypt=false;this.encrypt=0;this.ready=false;this.ajax=true;this.__get_mode=function(url){var protocol=null;var host=null;if(url.substr(0,7)=="http://"){protocol="http:";host=url.substring(7,url.indexOf('/',7));}
else if(url.substr(0,8)=="https://"){protocol="https:";host=url.substring(8,url.indexOf('/',8));}
if((protocol==null&&host==null)||(protocol==window.location.protocol&&host==window.location.host)){try{var xmlhttp=this.__create_xmlhttp();delete(xmlhttp);this.ajax=true;}
catch(e){this.ajax=false;}}
else{this.ajax=false;}}
this.use_service=function(url,encrypt){if(typeof(encrypt)=="undefined"){encrypt=this.__encrypt;}
if(typeof(this.__name)=="undefined"){return false;}
this.__url=url;this.ready=false;this.__get_mode(url);if(this.ajax){var xmlhttp=this.__create_xmlhttp();var __rpc=this;var __run=false;if(encrypt===true){xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4&&xmlhttp.status==200&&__run==false){__run=true;if(xmlhttp.responseText){eval(xmlhttp.responseText);if(typeof(phprpc_encrypt)=="undefined"){__rpc.__encrypt=false;__rpc.use_service(__rpc.__url);}
else{__rpc.use_service(__rpc.__url,num2dec(__rpc.__get_key(__rpc)).replace(/\+/g,'%2B'));}}
delete(xmlhttp);}}}
else{var __run=false;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4&&xmlhttp.status==200&&__run==false){__run=true;if(xmlhttp.responseText){eval(xmlhttp.responseText);__rpc.__create_functions(__rpc);}}
delete(xmlhttp);}}
xmlhttp.open("GET",this.__url+'?phprpc_encrypt='+encrypt+'&phprpc_encode=false',true);xmlhttp.send(null);}
else{var id=this.__create_id();var callback;if(this.__encrypt){callback=base64encode(utf16to8([this.__name,".__switch_key('",id,"');"].join('')));}
else{callback=base64encode(utf16to8([this.__name,".__get_functions('",id,"');"].join('')));}
var request=['phprpc_encrypt=',this.__encrypt,'&phprpc_callback=',callback,'&phprpc_encode=false'].join('');this.__append_script(id,request);}
return true;}
this.__get_key=function(rpc){rpc.__encrypt=unserialize(phprpc_encrypt);rpc.__encrypt['p']=dec2num(rpc.__encrypt['p']);rpc.__encrypt['g']=dec2num(rpc.__encrypt['g']);rpc.__encrypt['y']=dec2num(rpc.__encrypt['y']);rpc.__encrypt['x']=rand(127,1);var key=pow_mod(rpc.__encrypt['y'],rpc.__encrypt['x'],rpc.__encrypt['p']);key=num2str(key);var n=16-key.length;var k=[];for(var i=0;i<n;i++){k[i]='\0';}
k[n]=key;rpc.__encrypt['k']=k.join('');return pow_mod(rpc.__encrypt['g'],rpc.__encrypt['x'],rpc.__encrypt['p']);}
this.__switch_key=function(id){if(typeof(phprpc_encrypt)=="undefined"){this.__encrypt=false;this.__get_functions(id);}
else{this.__remove_script(id);var callback=base64encode(utf16to8([this.__name,".__get_functions('",id,"');"].join('')));var request=['phprpc_encrypt=',num2dec(this.__get_key(this)),'&phprpc_callback=',callback,'&phprpc_encode=false'].join('');this.__append_script(id,request);}}
this.__create_functions=function(rpc){var functions=unserialize(phprpc_functions);var func=[];var n=functions.length;for(var i=0;i<n;i++){func[i]=[rpc.__name,".",functions[i]," = function () {\r\n    this.__call('",functions[i],"', this.__args_to_array(arguments));\r\n}\r\n",rpc.__name,".",functions[i],".ref = false;\r\n"].join('');}
eval(func.join(''));rpc.ready=true;if(typeof(rpc.onready)=="function"){rpc.onready();}}
this.__get_functions=function(id){this.__create_functions(this);this.__remove_script(id);}
this.__call=function(func,args){var __args=serialize(args);if((this.__encrypt!==false)&&(this.encrypt>0)){__args=xxtea_encrypt(__args,this.__encrypt['k']);}
__args=base64encode(__args);var request=['phprpc_func=',func,'&phprpc_args=',__args,'&phprpc_encode=false','&phprpc_encrypt=',this.encrypt];var ref=eval(this.__name+"."+func+".ref");if(!ref){request[request.length]='&phprpc_ref=false';}
if(this.ajax){var xmlhttp=this.__create_xmlhttp();var session={'args':args,'ref':ref,'encrypt':this.encrypt,'run':false};var __rpc=this;xmlhttp.onreadystatechange=function(){if(xmlhttp.readyState==4&&xmlhttp.status==200&&session.run==false){session.run=true;if(xmlhttp.responseText){eval(xmlhttp.responseText);var callback=eval(__rpc.__name+"."+func+"_callback");__rpc.__get_result(session.encrypt,session.ref,session.args,callback);}
delete(xmlhttp);}}
xmlhttp.open("POST",this.__url,true);xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');xmlhttp.send(request.join('').replace(/\+/g,'%2B'));}
else{var id=this.__create_id();var callback=this.__name+"."+func+"_callback";if(typeof(eval(callback))!="function"){callback="null";}
callback=this.__name+".__callback('"+id+"', "+callback+");"
request[request.length]='&phprpc_callback=';request[request.length]=base64encode(utf16to8(callback));this.__append_script(id,request.join(''),args,ref);}};this.__get_result=function(encrypt,ref,args,callback){if(args[args.length-1].constructor==Function){callback=args[args.length-1];}
if(typeof(callback)=="function"){phprpc_warning=null;if((phprpc_errno!=1)&&(phprpc_errno!=16)&&(phprpc_errno!=64)&&(phprpc_errno!=256)){if((this.__encrypt!==false)&&(encrypt>0)){if(encrypt>1){phprpc_result=xxtea_decrypt(phprpc_result,this.__encrypt['k']);}
if(ref){phprpc_args=xxtea_decrypt(phprpc_args,this.__encrypt['k']);}}
phprpc_result=unserialize(phprpc_result);if(ref){phprpc_args=unserialize(phprpc_args);}
else{phprpc_args=args;}
phprpc_warning=new phprpc_error(phprpc_errno,phprpc_errstr);}
else{phprpc_result=new phprpc_error(phprpc_errno,phprpc_errstr);phprpc_args=args;}
callback(phprpc_result,phprpc_args,phprpc_output,phprpc_warning);}}
this.__callback=function(id,callback){var script=document.getElementById("script_"+id);this.__get_result(script.encrypt,script.ref,script.args,callback);this.__remove_script(id);}
this.__create_xmlhttp=function(){if(window.XMLHttpRequest){var objXMLHttp=new XMLHttpRequest();if(objXMLHttp.readyState==null){objXMLHttp.readyState=0;objXMLHttp.addEventListener("load",function(){objXMLHttp.readyState=4;if(typeof(objXMLHttp.onreadystatechange)=="function"){objXMLHttp.onreadystatechange();}},false);}
return objXMLHttp;}
else{var MSXML=['MSXML2.XMLHTTP.5.0','MSXML2.XMLHTTP.4.0','MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP','Microsoft.XMLHTTP'];var n=MSXML.length;for(var i=0;i<n;i++){try{return new ActiveXObject(MSXML[i]);}
catch(e){}}
throw new Error("Your browser does not support xmlhttp objects");}};this.__create_id=function(){return(new Date()).getTime().toString(36)+Math.floor(Math.random()*100000000).toString(36);}
this.__append_script=function(id,request,args,ref){var script=document.createElement("script");script.id="script_"+id;script.src=this.__url+"?"+request.replace(/\+/g,'%2B');script.defer=true;script.type="text/javascript";script.args=args;script.ref=ref;script.encrypt=this.encrypt;var head=document.getElementsByTagName("head").item(0);head.appendChild(script);}
this.__remove_script=function(id){var script=document.getElementById("script_"+id);var head=document.getElementsByTagName("head").item(0);head.removeChild(script);}
this.__args_to_array=function(args){var n=args.length;var argArray=new Array(n);for(i=0;i<n;i++){argArray[i]=args[i];}
return argArray;}}
phprpc_client.create=function(name,encrypt){eval([name,' = new phprpc_client();',name,'.__name = "',name,'";'].join(''));if(typeof(encrypt)=="boolean"){encrypt=true;eval([name,'.__encrypt = ',encrypt,';'].join(''));}}