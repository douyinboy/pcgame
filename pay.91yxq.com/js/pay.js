var server_data = {};
var money_list=new Array();
money_list[1]=new Array(10,30,50,100,500,1000,2000,3000,5000);
money_list[3]=new Array(10,20,30,50,100,200,300,500);
money_list[5]=new Array(5,10,15,20,30,50,100);
money_list[6]=new Array(10,20,30,50,100,300,500);
money_list[9]=new Array(5,10,15,30,50,100);
money_list[14]=new Array(50,100);
money_list[15]=new Array(20,30,50,100,200,300,500);
money_list[19]=new Array(10,20,30);
money_list[32]=new Array(5,10,15,20,30,50,100,200,300,500,1000);
money_list[35]=new Array(10,20,30,50,100);
money_list[41]=new Array(5,10,15,30,60,100);
money_list[42]=new Array(5,10,15,20,30,50);
money_list[43]=new Array(5,10,15,25,30,35,45,50,100,300,350,1000);
money_list[44]=new Array(5,10,15,20,25,30,50,100);
money_list[100]=new Array(500,1000,2000,5000,10000,50000,100000,500000);
$(document).ready(function(){
	var login_name=get_cookie('login_name');
	if(login_name!=''){
		$('#sure_user').hide();
		$('#login_account').html(login_name)
		$('#besure_user').show();
	};
});



$('#define_user').click(function(){
	if ( $('#username').val()=='' ) {
		 alert('充值帐号不能为空!');
		 return false;
	}
	$("#confirm_username").html($('#username').val());
	$('#sure_user').hide();
	$('#login_account').html($('#username').val());
	$('#besure_user').show();
	showGame_note();
});

$('#bank_list dl dd').click(function(){
	$('#bank_name').val($(this).children('font').attr('id'));
	$(this).parent().parent().children().children('.option_on').removeClass('option_on');
	$(this).addClass('option_on');
});

$('#change_user').click(function(){
	$('#login_account').html('');
	$('#confirm_username').html('');
	$('#besure_user').hide();
	$('#sure_user').show();
});

$('#input_money').keyup(function(e){
	var input_money_int_way=parseInt($('#input_money').val());
	if(isNaN(input_money_int_way)){
		input_money_int_way = 0;
	}
	$('#input_money').val(input_money_int_way);
	var p_way=$('#pay_way_id').val();
	var i_way=$('#input_money').val();
	$("#pay_amount").val(i_way);
	showGame_note();
});




function trim(str){
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

function closeForm(){
	$('#pay_info').hide();
	$('.popup_bg').hide();
}

function closeGameList(){
	$('#game_list').hide();
}

function closeServerList(){
	$('#server_list').hide();
}

function showBank(){
	if($('#morebank').css('display')=='none'){
		$('#morebank').show();
	}
	$('#bank_more').hide();
}

function showGameList() {
	getAllgame();
	$('#server_list').hide(); //服务器列表隐藏
	$('#game_list').show(); //游戏列表显示
	search_game();
	search_server();
}

function getAllgame(){
	var ghtml='';
	for(i in gl){
			ghtml += '<a href="Javascript:showServerList(\''+i+'\',0);">'+gl[i]['name']+'</a>';
	}

	$('#game_list .txt').html(ghtml);
}



function showServerList(game_byname,server_id){
	if(game_byname==''){ showGameList(); return false; }
	var game_id=gl[game_byname]['gid'];
	var game_name=gl[game_byname]['name'];
	$('#confirm_gamename').html(game_name);
	$('#game_id').val(game_id);
	$('#game_byname').val(game_byname);
	$('#server_id').val('');
	$('#show_game_name').html(game_name);
	$('#show_game_name').show();
	$('#game_list').hide();
	showGame_note();
	$.ajax(
    {
        type:"GET",
		async:true,
        url:"./source/servers_str.php",
		data:"gid="+game_id+"&rand="+Math.random(),
        success: function(result){
					if(result){
						data_server=eval("("+result+")");
						if(server_id>0){
							$.each(data_server, function (key, val) {
								 if(val['server_id']==server_id && server_id>0){
									 selectServer(val['server_id'],val['name']);
									 return false;
								 }
							});
						} else {
							showServer_page(data_server);
							return false;
						}
					}else{
						alert('服务器列表为空');
						showGameList();
						return false;
					}
        },
        error:function(){
			showGameList();
            return false;
        }
    });
}

function showServer_page(server_data){
	if(typeof server_data !== 'object'){
		return false;
	}
	this_server_datas = server_data;
	_this_page_html = '';

	target_page = '';
	for(i in this_server_datas){
			if(this_server_datas[i].name != ''){
					_this_page_html += '<a href="Javascript:selectServer('+this_server_datas[i]['server_id']+',\''+this_server_datas[i]['name']+'\')">'+this_server_datas[i]['name']+'</a>';
			}
	}


	$("#server_list .txt").html(_this_page_html);
	$("#server_list").show();

}

function selectServer(sid,sname){
	$('#server_id').val(sid);
	$('#show_server_name').html(sname);
	$('#confirm_servername').html(sname);
	$('#server_list').hide();
}

function changeServer(){
	showServerList($('#game_byname').val(),0);
}

function search_game(){
	var tips = "输入游戏名字或拼音简写";
	$('#game_keyword').val(tips);
	$('#game_keyword').css('color', '#666');
	$('#game_keyword').focus(function(){
		if($(this).val() != tips) return false;
		$(this).val('');
		$(this).css('color', '#000');
	}).blur(function(){
		if($(this).val() == ''){
			$('#game_keyword').val(tips);
			$('#game_keyword').css('color', '#666');
		}
	});

	//keyup
	$('#game_keyword').keyup(function(e){
		if($('#game_keyword').val() == '' || $('#game_keyword').val() == tips){
			$('#game_keyword').focus();
			getAllgame();
			return false;;
		}
		getSearchGame($('#game_keyword').val());
	});
}
function search_server(){
	var tips = "输入游戏区服ID简写";
	$('#server_keyword').val(tips);
	$('#server_keyword').css('color', '#666');
	$('#server_keyword').focus(function(){
		if($(this).val() != tips) return false;
		$(this).val('');
		$(this).css('color', '#000');
	}).blur(function(){
		if($(this).val() == ''){
			$('#server_keyword').val(tips);
			$('#server_keyword').css('color', '#666');
		}
	});

	//keyup
	$('#server_keyword').keyup(function(){
		if($('#server_keyword').val() == '' || $('#server_keyword').val() == tips){
			$('#server_keyword').focus();
			showServer_page(data_server);
			return false;
		}
		getSearchServer($('#server_keyword').val());
	});
}
function getSearchServer(keyw){
	var _this_server_search_html='';
	var ghtml='';
	for(i in data_server){
		if(data_server[i]['server_id'].indexOf(keyw) != -1 || data_server[i]['name'].indexOf(keyw) != -1){
		   _this_server_search_html += '<a href="javascript:selectServer('+data_server[i]['server_id']+',\''+data_server[i]['name']+'\')">'+data_server[i]['name']+'</a>';
		}
	}
	$("#server_list .txt").html(_this_server_search_html);

	$("#server_list").show();
}


function getSearchGame(keyw){
	var ghtml='';
	for(i in gl){
		if(gl[i]['name'].indexOf(keyw) != -1 || i.indexOf(keyw) != -1){
		   ghtml += '<a href="javascript:showServerList(\''+i+'\',0);">'+gl[i]['name']+'</a>';
		}
	}
	$('#game_list .txt').html(ghtml);
}

function showGame_note(){
	var game_id=$('#game_id').val();
	var username = $('#login_account').text();
	var mark = 0;
	if (username != '') {
        $.ajax({
			type:"GET",
			async:false,
			url:"./source/sale_username.php",
			data:"username="+username,
			success: function(result){
				if(result == 1){
                    mark = 1;
				}
			},
			error:function(){
                alert('system is wrong');
			}
		});
	}
	if (game_id<=0) {
		showGameList(); return false;
	}
	var pay_way_id=$('#pay_way_id').val();
	var pay_rate=1;
	if(pay_way_id==6 || pay_way_id==14 || pay_way_id==15){
		pay_rate = 0.95;
	}
	if(pay_way_id==9){
		pay_rate = 0.84;
	}
	if(pay_way_id==32){
		pay_rate = 0.84;
	}
	if(pay_way_id==30){
		pay_rate = 0.98;
	}
	if(pay_way_id==31){
		pay_rate = 0.98;
	}
	if(pay_way_id==34){
		pay_rate = 0.99;
	}
	if(pay_way_id==35 || pay_way_id==36 || pay_way_id==37 || pay_way_id==38 || pay_way_id==39 || pay_way_id==40){
		pay_rate = 0.95;
	}
	if(pay_way_id==41){
		pay_rate = 0.86;
	}
	if(pay_way_id==42 || pay_way_id==43){
		pay_rate = 0.88;
	}
	if(pay_way_id==44){
		pay_rate = 0.82;
	}
	if(pay_way_id==46){
		pay_rate = 0.98;
	}
	$('#pay_rate').val(pay_rate);

	var game_byname=$('#game_byname').val();
	var pay_amount = Math.floor($('#pay_amount').val());
	var pay_amount_rate = Math.floor($('#pay_amount').val() * agent_rate[game_byname]['rate']);
	if ( pay_amount>=99999) { pay_amount = 99999; }
	if ( (parseInt($('#select_money dl dd.option_on font').html())==0 || isNaN(parseInt($('#select_money dl dd.option_on font').html()))) && (isNaN(pay_amount) || pay_amount == 0)){
		pay_amount = 100;
	}
	$('#pay_amount').val(pay_amount);

	$("#confirm_money").html(pay_amount_rate+'元');
	var gameb=Math.floor(pay_amount*gl[game_byname]['rate']*pay_rate)+gl[game_byname]['b_name'];
    var gameb2=Math.floor(pay_amount*gl[game_byname]['rate']*pay_rate*2)+gl[game_byname]['b_name'];
    $('#gameb').html('您将获得'+gameb);
    $('#confirm_gameb').html(gameb);

    if (mark == 1) {
        $('#gameb').html('该游戏5.0折，您将获得' + gameb + '+' + gameb + '(原价' + pay_amount*2 + '元，优惠价' + pay_amount + '元)');
        $('#confirm_gameb').html(gameb2);
    }
}

function orderForm(){
	var phone =$('#username_phone').val();
	var pay_type=$('#pay_way_id').val();
	var game=$('#game_id').val();
	var server=$('#server_id').val();
	var server_name=$('#server_name').val();
	var user=$('#login_account').html();
	var money=$('#pay_amount').val();
	var game_byname=$('#game_byname').val();
	var dfbank = $('#bank_name').val();
	if(!pay_type){
		alert('充值方式选择失败'); closeForm(); return false;
	}
	if(pay_type==30 || pay_type==31 || pay_type==46){
		if(money<10 || money%10!=0){
			alert('微信支付充值金额必须是10的倍数'); closeForm(); return false;
		}
	}
	if(!game){
		 showGameList(); return false;
	}
	if(!server){
		 showServerList(game_byname,0); return false;
	}
	if(!user){
		alert('请填写用户名');
		$('.main_user_account').hide();
		$('.main_user_input').show();
		$('#username').focus(); return false;
	}
	if(money<1 || money>99999){
		alert('请选择正确的金额');
		$('#input_money').focus();
		return false;
	}
	$.ajax(
    {
        type:"GET",
        url:"make_order.php",
		data:"dfbank="+dfbank+"&pay_type="+pay_type+"&game="+game+"&server="+server+"&user="+user+"&money="+money+"&game_byname="+game_byname+"&server_name="+encodeURIComponent(server_name)+"&rand="+Math.random(),
        success: function(result){
					if(result!='money_too_more' && result!='phone_error'){
						$('#confirm_orderid').html(result);
						$('#orderid').val(result);
						_top = $(document).scrollTop() - 30;
						/*$('#pay_info').css('top', _top);*/
						$('#pay_info').show();
						$('.popup_bg').show();

						$("form").submit(function(){

							/*$('#czover').css('top', _top);*/
							$('#pay_info').hide();
							$('#pay_tips').show();
						});
					}else{
						alert('获取订单号失败，请重新提交');
						closeForm();
						return false;
					}
        },
        error:function(){
			alert('网络故障，请重新提交');
			showGameList();
            return false;
        }
    });

}

function selectMoney(){
	$('#select_money dl dd').click(function(){
		$(this).parent().children('.option_on').removeClass('option_on');
		$(this).addClass('option_on');
		if(parseInt($(this).children('font').html()) != 0 && isNaN(parseInt($(this).children('font').html())) == false){
			//$("#input_money").attr("disabled","disabled");
			$("#input_money").val('');
			$("#pay_amount").val(parseInt($(this).children('font').html()));
			showGame_note();
		}else{
			$("#input_money").removeAttr("disabled");
			$("#pay_amount").val($('#input_money').val());
			showGame_note();
			$('#input_money').keyup(function(e){

				var p_way=$('#pay_way_id').val();
				var i_way=$('#input_money').val();
				$("#pay_amount").val(i_way);
				showGame_note();

			});
		}
	});
}

function object_reverse(obj){
	_keys = [];
	for(i in obj){
		_keys.push(i);
	}
	_keys = _keys.reverse();
	new_obj = {};
	for(i in _keys){
		new_obj[_keys[i]] = obj[_keys[i]];
	}
	return new_obj;
}

function turnToPay(this_pay_way){
		$('#pay_name').html($('#pay_way_'+this_pay_way).html());
		$("#input_money").val('');
		var last_pay_way=$('#pay_way_id').val();
		if(last_pay_way == '') last_pay_way = 1;
		if(this_pay_way==errorWay && errorToWay>0) this_pay_way=errorToWay;
		$('#pay_way_id').val(this_pay_way);
		$('.li_a').addClass('li_o');
		$('.li_a').removeClass('li_a');
		$('#pay_way_'+this_pay_way).addClass('li_a');
		$('#pay_way_'+this_pay_way).removeClass('li_o');
		$('#confirm_payway').html($('#pay_way_'+this_pay_way).html());
		$('#show_game_name').show();
		$('#main_money_list').show();
		$('#confirm_tb1').show();
		$('#confirm_tb2').show();
		switch(this_pay_way){
			case 1: get99bill(); break;
			case 18: getAlipay2(); break;
			case 3: get99bill1(); break;
			case 11: getRengong(); break;
			case 30: get51wx();break;
			case 31: getCft();break;
			case 32: gethfb_jw();break;
			case 33: gethfb_wy();break;
			case 34: gethfb_kj();break;
			case 35: gethfb_yd();break;
			case 36: gethfb_lt();break;
			case 37: gethfb_dx();break;
			case 46: get_jct();break;
			default:; break;
		}
}

function get99bill(){
	changeMoneyList(1);
	$('#main_other_money').show();
	$.ajax(
    {
        type:"GET",
        url:"pay_index.php",
		data:"act=99bill_bank&rand="+Math.random(),
        success: function(result){
			$('#pay_content').show();
			$('#bank_list').html(result);
			$('#bank_list').show();
			$('#bank_more').show();

        },
        error:function(){
            return false;
        }
    });
}
function get99bill1(){
	changeMoneyList(1);
	$('#main_other_money').show();
	$('#pay_content').hide();
	$('#bank_list').hide();
	$('#morebank').hide();
}
function getAlipay2(){
	$('#main_other_money').show();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(1);
}

function get51wx(){
	$('#main_other_money').show();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(1);
}
function getCft(){
	$('#main_other_money').show();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(1);
}
function gethfb_jw(){
	$('#main_other_money').hide();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(32);
}
function gethfb_wy(){
	$('#main_other_money').show();
	$('#bank_list').show();
	$('#pay_content').show();
	changeMoneyList(1);
}
function gethfb_kj(){
	$('#main_other_money').show();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(1);
}
function gethfb_yd(){
	$('#main_other_money').hide();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(35);
}
function gethfb_lt(){
	$('#main_other_money').hide();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(35);
}
function gethfb_dx(){
	$('#main_other_money').hide();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(35);
}
function get_xqt(pt){
	$('#main_other_money').hide();
	$('#bank_list').hide();
	$('#pay_content').hide();
	changeMoneyList(pt);
}

function get_jct(){
	$('#main_other_money').show();
	$('#pay_content').hide();
	$('#bank_list').hide();
	changeMoneyList(1);
}


function changeMoneyList(pt){
	var mlist='';
	var deva=100;
	 $.each(money_list[pt],function(k,value) {
		if(value==deva){
			mlist+='<dd class="option_on"><i class="imgpq"></i><font>'+value+'元</font></dd>';
		} else {
			mlist+='<dd><i class="imgpq"></i><font>'+value+'元</font></dd>';
		}
     });
	 if(pt==1){
		 mlist+='<dd id="main_other_money" class="option_bg"><i class="imgpq"></i><font><input type="text" title="其它" maxlength="5" id="input_money" class="input_txt">&nbsp;&nbsp;元</font></dd>';
	 }
	$('#select_money dl').html(mlist);
	$('#pay_amount').val(deva);

	if($("#pay_amount").val()>0){
		showGame_note();
	}
	selectMoney();
}

function check() {

	if ($("#game_id").val()<=0) {
		alert('请选择游戏！');
		showGameList();
		return false;
	}
	if ($("#server_id").val()<1) {
		showServerList($('#game_byname').val(),server_id);
		return false;
	}
    // if ( $('#login_account').html()=='') {
	 // 	 alert('充值帐号不能为空!');
		//  $('#username').focus();
	 // 	 return false;
    // }
	if($("#pay_amount").val()>99999 || $("#pay_amount").val()<1){
		alert('请选择正确的金额');
		$('#input_money').focus();
		return false;
	}
		$.get('api/check_game_user.php?user_name=' + $('#login_account').html()+'&game_id='+$("#game_id").val()+'&server_id='+$("#server_id").val(), function(data){
            if(data!='ok'){
                $("#confirm_username").html($('#login_account').html());

				orderForm();
			}
		});
}

function get_cookie(cookie_name){if (document.cookie == ''){return '';}var value = '';var cookie_values = document.cookie.split(";");for (i in cookie_values){_t=$.trim(cookie_values[i]).split("=");if (_t[0] == cookie_name){value=_t[1];try{value = decodeURIComponent(value);}catch(e){}break;}}return value;}

function addBookmark(url,title){if(window.sidebar){window.sidebar.addPanel(title,url,"")}else if(document.all){window.external.AddFavorite(url,title)}else if(window.opera&&window.print){return true}}

function setHomepage(url,title){if(document.all){document.body.style.behavior='url(#default#homepage)';document.body.setHomePage(url)}else if(window.sidebar){if(window.netscape){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect")}catch(e){alert("该操作被浏览器拒绝，如果想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true")}}var prefs=Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);prefs.setCharPref(title,url)}}
