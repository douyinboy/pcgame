Wan = {
	indexUrl : "http://www.wan.com",
	errorUrl : "http://www.wan.com/404.shtml",
	loginUrl : "http://www.wan.com/login.shtml",
	regUrl : "http://www.wan.com/reg.shtml",
	PlatList : {
		"玩平台" : "",
		"畅游" : "1001",
		"8641" : "1003",
		"第七大道" : "1004"/*,*/
		/*"37wanwan" : "1005"*/
	},
	Plat : [
	    {"id" : "1003", "name" : "8641"},		
		{"id" : "1001", "name" : "畅游"},
		{"id" : "1004", "name" : "第七大道"},
		{"id" : "1002", "name" : "wan900"},
		{"id" : "", "name" : "玩平台"}/*,
		{"id" : "1005", "name" : "37wanwan"}*/
	],
	login : function() {
    	var ref = arguments[0] || Url.referrer();
    	Url.location(Wan.loginUrl + "?url=" + ref.encode(), "_top");
    	return false;
    },
    reg : function() {
    	var ref = arguments[0] || Url.referrer();
    	Url.location(Wan.regUrl + "?url=" + ref.encode(), "_top");
    	return false;
    },
    getPlatId : function(name) {
    	$.each(Wan.Plat, function(i, json) {
    		if (json.name == name) {
    			return json.id;
    		}
    	});
    	return "";
    }
};
Passport = {
	loginUrl : "http://passport.wan.com/login",
	regUrl : "http://passport.wan.com/reg",
	logoutUrl : "http://passport.wan.com/logout",
	captchaUrl : "http://passport.wan.com/captcha",
	tip : function(result) {
		return _Tips.Passport[result] || _Tips.Passport[99];
	},
	isLogin : function() {
		return !$.isEmptyArray([Cookie.get("userid"), 
		        Cookie.get("username"), 
		        Cookie.get("nickname"), 
		        Cookie.get("address"), 
		        Cookie.get("sign"), 
		        Cookie.get("timeflag")]);
	},
	currentUser : function() {
		var len = arguments[0] || 22;
		var username = Cookie.get("nickname") || Cookie.get("username");
		username = username.decode();
		if (username.length > len) {
			var loc = username.indexOf('@');
			if (loc >= 0) {
				username = username.substring(0, loc);
			}
			if (username.length > len) {
				username = username.substring(0, len - 1);
			}
			username = username + "…";
		}
        return username;
    },
    logout : function() {
    	$.getJSONP(Passport.logoutUrl, {}, function(data) {
    		if (data.result === 0 && data.url) {
    			Url.location(data.url);
    		} else {
    			window.location.reload();
    		}
    	});
    	return false;
    }
};
Play = {
	gameCode : 	"",
	gameUrl : "http://play.wan.com/game",
	serverUrl : "http://play.wan.com/server",
	playUrl : "http://play.wan.com/playing",
	userinfoUrl : "http://play.wan.com/userinfo",
	cardUrl : "http://play.wan.com/card",
	tip : function(result) {
		return _Tips.Play[result] || _Tips.Play[99];
	},
	getGameCode : function() {
    	if (Play.gameCode) {
    		return Play.gameCode;
    	}
    	var host = window.location.host;
    	Play.gameCode = host.substring(0, host.indexOf('.'));
    	return Play.gameCode;
    },
	updatePlayHistory : function(game, server) {
		var userid = Cookie.get("userid");
		if ($.isEmpty(userid)) {
			return;
		}
		var time = new Date().getTime();
		var playhistory = {};
		var userplay = Cookie.get("recentplay").decode();
		if (!$.isEmpty(userplay) && userplay.indexOf(userid+"'") == 0 && userplay.substring(userplay.length-1)!="'") {
			playhistory = eval('(' + userplay.substring(userplay.indexOf("'")+1) + ')');
		}
		if ($.isEmpty(playhistory[game.gameCode]) && playhistory.length >= 5) {
			var min = 0;
			var minGame = "";
			$.each(playhistory, function(code, json) {
				if (min === 0 || json.time < min) {
					min = json.time;
					minGame = code;
				}
			});
			delete playhistory[minGame];
		}
		playhistory[game.gameCode] = {
				name : server.serverIndex + "|" + server.groupName + "|" + game.gameName,
				time : time
		}
		var sortarr = [];
		for (var code in playhistory) {
			sortarr.push({"code":code,"time":playhistory[code].time});
		}
		sortarr.sort(function(a, b) {
			return b.time - a.time;
		});
		userplay = userid+"'{";
		for (var i in sortarr) {
			userplay += '"'+sortarr[i].code+'":{"name":"'+playhistory[sortarr[i].code].name+'","time":"'+playhistory[sortarr[i].code].time+'"},';
		}
		if (userplay != '{') {
			userplay = userplay.substring(0, userplay.length - 1);
		}
		userplay += '}';
		Cookie.set("recentplay", userplay.encode(), 365);
	}
};
Forum = {
	forumUrl : "http://forum.wan.com/sso.php", 
	loginForum : function() {
		if(Passport.isLogin()) {
			window.open(Forum.forumUrl + "?wan=wan&username=" + Cookie.get("username"));
		} else {
			window.open(Wan.loginUrl + "?url=" + Url.referrer());
		}
	}
};
Url = {
	_requestParamMap : {},
	query : function() {
		var search = window.location.search;
		if (search.indexOf("?") >= 0) {
			search = search.substr(1);
		}
		return search || '';
	},
	param : function(name) {
		var p = this._requestParamMap[name];
		if (p != null && p != undefined) {
			return p;
		}
		var search = this.query();
		if (search != '') {
            var paramString = search.split("&");
            var str = '';
            for (var i = 0; i < paramString.length; i++) {
                str = paramString[i].split("=");
                this._requestParamMap[str[0]] = str[1]
            }
        }
		return this._requestParamMap[name] || '';
	},
	referrer : function() {
        var url = '';
        if (self == top) {
            url = window.location.href;
        } else if (!$.browser.webkit) {
            try {
                url = top.location.href;
            } catch(exp) {             
            }
        }
        if (!url) {
            url = document.referrer;
        }
        if (!url) {
            var ld = Cookie.get("ld");
            if (ld) {
               url = ld.indexOf("http://") > 0 ? ld : ("http://" + ld); 
            }
        }
        if (!url) {
            url = location.href;
        }
        return url;
    },
    location : function(url) {
    	var target = arguments[1];
        if (target == "_blank") {
            window.open(url)
        } else if (target == '_top') {
            top.location.href = url
        } else {
            window.location.href = url
        }
    }
};
Cookie = {
	get : function(key) {
        var strcookie = document.cookie;
        if (strcookie != "") {
            var arrcookie = strcookie.split("; ");
            for ( var i = 0; i < arrcookie.length; i++) {
                var arr = arrcookie[i].split("=");
                if (arr[0] == key) {
                    return arr[1] || ""
                }
            }
        }
        return ""
    },
    set : function(key, value, expires) {
        var ep = '';
        if (expires) {
            var date = new Date();
            date.setTime(date.getTime() + (expires < 0 ? -1 : expires * 24 * 3600 * 1000));
            ep = ";expires=" + date.toGMTString();
        }
        var domain = arguments[3] || this.getDomain();
        document.cookie = key + "=" + value + ep + ";domain=" + domain + ";path=/";
    },
    clear : function(key) {
        var domain = arguments[1] || this.getDomain();
        var date = new Date();
        date.setTime(date.getTime() - 1);
        document.cookie = key + "=;expires=" + date.toGMTString() + ";domain=" + domain + ";path=/";
    },
    getDomain : function() {
        var domain = document.domain;
        var index = domain.lastIndexOf('.');
        index = domain.substring(0, index).lastIndexOf('.');
        if (index == -1) {
            return domain;
        }
        return domain.substring(index + 1);
    }
};
_Tips = {
	Passport : {
		0 : "&nbsp;",
		1 : "很遗憾，账号已被注册",
		2 : "用户名不能为空",
		3 : "用户名长度不符，需5-30位",
		4 : "用户名不能包含特殊字符",
		5 : "用户名不能包含特殊字符",
		6 : "请输入密码",
		7 : "密码长度不符，长度需为4-16位",
		8 : "密码不能使用空格、逗号、引号",
		9 : "密码不能与用户名相同",
		10 : "两次输入的密码请保持一致",
		11 : "用户名或密码为空",
		12 : "用户名或密码错误",
		13 : "账号不能为手机号",
		14 : "请输入真实姓名，如“王五”",
		15 : "请输入真实姓名，如“王五”",
		16 : "请输入真实姓名，如“王五”",
		17 : "请输入真实身份证，如“320812198011111110”",
		18 : "请输入真实身份证，如“320812198011111110”",
		19 : "请输入真实身份证，如“320812198011111110”",		
		20 : "邮箱格式不正确",
		21 : "手机号格式不正确",
		22 : "验证码错误",
		23 : "存在相同用户名",
	    24 : "登陆超时，请重新登陆",	    
	    25 : "服务器繁忙，请稍后重试",
	    26 : "邮箱不能为空",
		27 : "邮箱长度不正确",
		28 : "邮箱格式不正确",
		29 : "服务器繁忙，请稍后重试",
		30 : "账号不存在",
		31 : "请选择平台",
		98 : "服务器繁忙，请稍后重试",
		99 : "服务器繁忙，请稍后重试"
	},
	Play : {
		0 : "&nbsp;",
		1 : "很遗憾，账号已被注册",
		2 : "用户名不能为空",
		3 : "用户名长度不符，需5-30位",
		4 : "用户名不能包含中文",
		5 : "用户名不能包含中文",
		6 : "请输入密码",
		7 : "密码长度不符，长度需为4-16位",
		8 : "密码不能使用空格、逗号、引号",
		9 : "密码不能与用户名相同",
		10 : "两次输入的密码请保持一致",
		11 : "用户名或密码为空",
		12 : "用户名或密码错误",
		13 : "账号不能为手机号",
		14 : "请填写真实姓名",
		15 : "姓名的长度不正确",
		16 : "姓名填写不正确，请输入中文字符",
		17 : "请输入身份证号",
		18 : "身份证号码位数不对",
		19 : "请输入真实的身份证号",		
		20 : "邮箱格式不正确",
		21 : "手机号格式不正确",
		22 : "验证码错误",
		23 : "存在多个相同账户",
	    24 : "登陆超时，请重新登陆",	    
	    25 : "服务器繁忙，请稍后重试",
		26 : "邮箱不能为空",
		27 : "邮箱长度不正确",
		28 : "邮箱未认证",
		29 : "链接失效",
		30 : "账号不存在",
		31 : "服务器繁忙，请稍后重试",
	    32 : "订单未支付",
	    33 : "订单不存在",
	    34 : "支付方式不存在",
	    35 : "支付渠道不存在",
	    36 : "服务器繁忙，请稍后重试",
	    37 : "游戏列表为空",
	    38 : "游戏不存在",
	    39 : "服务器列表为空",
	    40 : "服务器不存在",
	    41 : "角色列表为空",
	    42 : "订单重复",
	    43 : "游戏点数错误",
	    44 : "没有此代理",
	    45 : "充值金额错误",
	    46 : "服务器繁忙，请稍后重试",
	    47 : "服务器繁忙，请稍后重试",
	    48 : "订单已支付",
	    49 : "服务器需激活",
	    50 : "用户已被防沉迷",
	    51 : "卡类型不存在",
	    52 : "卡已发完",
	    53 : "平台币余额不足",
	    54 : "平台币消费失败",
	    55 : "平台币充值失败",
		98 : "服务器繁忙，请稍后重试",
		99 : "服务器繁忙，请稍后重试"
	}
};
_Md5 = {
	hexcase : 0,
	hex_md5 : function(a) {
		return this.rstr2hex(this.rstr_md5(this.str2rstr_utf8(a)))
	},
    rstr_md5 : function(a) {
        return this.binl2rstr(this.binl_md5(this.rstr2binl(a), a.length * 8))
    },
    rstr2hex : function(c) {
        try {
            this.hexcase
        } catch(g) {
            this.hexcase = 0
        }
        var f = this.hexcase ? "0123456789ABCDEF": "0123456789abcdef";
        var b = "";
        var a;
        for (var d = 0; d < c.length; d++) {
            a = c.charCodeAt(d);
            b += f.charAt((a >>> 4) & 15) + f.charAt(a & 15)
        }
        return b
    },
    str2rstr_utf8 : function(c) {
        var b = "";
        var d = -1;
        var a,
        e;
        while (++d < c.length) {
            a = c.charCodeAt(d);
            e = d + 1 < c.length ? c.charCodeAt(d + 1) : 0;
            if (55296 <= a && a <= 56319 && 56320 <= e && e <= 57343) {
                a = 65536 + ((a & 1023) << 10) + (e & 1023);
                d++
            }
            if (a <= 127) {
                b += String.fromCharCode(a)
            } else {
                if (a <= 2047) {
                    b += String.fromCharCode(192 | ((a >>> 6) & 31), 128 | (a & 63))
                } else {
                    if (a <= 65535) {
                        b += String.fromCharCode(224 | ((a >>> 12) & 15), 128 | ((a >>> 6) & 63), 128 | (a & 63))
                    } else {
                        if (a <= 2097151) {
                            b += String.fromCharCode(240 | ((a >>> 18) & 7), 128 | ((a >>> 12) & 63), 128 | ((a >>> 6) & 63), 128 | (a & 63))
                        }
                    }
                }
            }
        }
        return b
    },
    rstr2binl : function(b) {
        var a = Array(b.length >> 2);
        for (var c = 0; c < a.length; c++) {
            a[c] = 0
        }
        for (var c = 0; c < b.length * 8; c += 8) {
            a[c >> 5] |= (b.charCodeAt(c / 8) & 255) << (c % 32)
        }
        return a
    },
    binl2rstr : function(b) {
        var a = "";
        for (var c = 0; c < b.length * 32; c += 8) {
            a += String.fromCharCode((b[c >> 5] >>> (c % 32)) & 255)
        }
        return a
    },
    binl_md5 : function(p, k) {
        p[k >> 5] |= 128 << ((k) % 32);
        p[(((k + 64) >>> 9) << 4) + 14] = k;
        var o = 1732584193;
        var n = -271733879;
        var m = -1732584194;
        var l = 271733878;
        for (var g = 0; g < p.length; g += 16) {
            var j = o;
            var h = n;
            var f = m;
            var e = l;
            o = this.md5_ff(o, n, m, l, p[g + 0], 7, -680876936);
            l = this.md5_ff(l, o, n, m, p[g + 1], 12, -389564586);
            m = this.md5_ff(m, l, o, n, p[g + 2], 17, 606105819);
            n = this.md5_ff(n, m, l, o, p[g + 3], 22, -1044525330);
            o = this.md5_ff(o, n, m, l, p[g + 4], 7, -176418897);
            l = this.md5_ff(l, o, n, m, p[g + 5], 12, 1200080426);
            m = this.md5_ff(m, l, o, n, p[g + 6], 17, -1473231341);
            n = this.md5_ff(n, m, l, o, p[g + 7], 22, -45705983);
            o = this.md5_ff(o, n, m, l, p[g + 8], 7, 1770035416);
            l = this.md5_ff(l, o, n, m, p[g + 9], 12, -1958414417);
            m = this.md5_ff(m, l, o, n, p[g + 10], 17, -42063);
            n = this.md5_ff(n, m, l, o, p[g + 11], 22, -1990404162);
            o = this.md5_ff(o, n, m, l, p[g + 12], 7, 1804603682);
            l = this.md5_ff(l, o, n, m, p[g + 13], 12, -40341101);
            m = this.md5_ff(m, l, o, n, p[g + 14], 17, -1502002290);
            n = this.md5_ff(n, m, l, o, p[g + 15], 22, 1236535329);
            o = this.md5_gg(o, n, m, l, p[g + 1], 5, -165796510);
            l = this.md5_gg(l, o, n, m, p[g + 6], 9, -1069501632);
            m = this.md5_gg(m, l, o, n, p[g + 11], 14, 643717713);
            n = this.md5_gg(n, m, l, o, p[g + 0], 20, -373897302);
            o = this.md5_gg(o, n, m, l, p[g + 5], 5, -701558691);
            l = this.md5_gg(l, o, n, m, p[g + 10], 9, 38016083);
            m = this.md5_gg(m, l, o, n, p[g + 15], 14, -660478335);
            n = this.md5_gg(n, m, l, o, p[g + 4], 20, -405537848);
            o = this.md5_gg(o, n, m, l, p[g + 9], 5, 568446438);
            l = this.md5_gg(l, o, n, m, p[g + 14], 9, -1019803690);
            m = this.md5_gg(m, l, o, n, p[g + 3], 14, -187363961);
            n = this.md5_gg(n, m, l, o, p[g + 8], 20, 1163531501);
            o = this.md5_gg(o, n, m, l, p[g + 13], 5, -1444681467);
            l = this.md5_gg(l, o, n, m, p[g + 2], 9, -51403784);
            m = this.md5_gg(m, l, o, n, p[g + 7], 14, 1735328473);
            n = this.md5_gg(n, m, l, o, p[g + 12], 20, -1926607734);
            o = this.md5_hh(o, n, m, l, p[g + 5], 4, -378558);
            l = this.md5_hh(l, o, n, m, p[g + 8], 11, -2022574463);
            m = this.md5_hh(m, l, o, n, p[g + 11], 16, 1839030562);
            n = this.md5_hh(n, m, l, o, p[g + 14], 23, -35309556);
            o = this.md5_hh(o, n, m, l, p[g + 1], 4, -1530992060);
            l = this.md5_hh(l, o, n, m, p[g + 4], 11, 1272893353);
            m = this.md5_hh(m, l, o, n, p[g + 7], 16, -155497632);
            n = this.md5_hh(n, m, l, o, p[g + 10], 23, -1094730640);
            o = this.md5_hh(o, n, m, l, p[g + 13], 4, 681279174);
            l = this.md5_hh(l, o, n, m, p[g + 0], 11, -358537222);
            m = this.md5_hh(m, l, o, n, p[g + 3], 16, -722521979);
            n = this.md5_hh(n, m, l, o, p[g + 6], 23, 76029189);
            o = this.md5_hh(o, n, m, l, p[g + 9], 4, -640364487);
            l = this.md5_hh(l, o, n, m, p[g + 12], 11, -421815835);
            m = this.md5_hh(m, l, o, n, p[g + 15], 16, 530742520);
            n = this.md5_hh(n, m, l, o, p[g + 2], 23, -995338651);
            o = this.md5_ii(o, n, m, l, p[g + 0], 6, -198630844);
            l = this.md5_ii(l, o, n, m, p[g + 7], 10, 1126891415);
            m = this.md5_ii(m, l, o, n, p[g + 14], 15, -1416354905);
            n = this.md5_ii(n, m, l, o, p[g + 5], 21, -57434055);
            o = this.md5_ii(o, n, m, l, p[g + 12], 6, 1700485571);
            l = this.md5_ii(l, o, n, m, p[g + 3], 10, -1894986606);
            m = this.md5_ii(m, l, o, n, p[g + 10], 15, -1051523);
            n = this.md5_ii(n, m, l, o, p[g + 1], 21, -2054922799);
            o = this.md5_ii(o, n, m, l, p[g + 8], 6, 1873313359);
            l = this.md5_ii(l, o, n, m, p[g + 15], 10, -30611744);
            m = this.md5_ii(m, l, o, n, p[g + 6], 15, -1560198380);
            n = this.md5_ii(n, m, l, o, p[g + 13], 21, 1309151649);
            o = this.md5_ii(o, n, m, l, p[g + 4], 6, -145523070);
            l = this.md5_ii(l, o, n, m, p[g + 11], 10, -1120210379);
            m = this.md5_ii(m, l, o, n, p[g + 2], 15, 718787259);
            n = this.md5_ii(n, m, l, o, p[g + 9], 21, -343485551);
            o = this.safe_add(o, j);
            n = this.safe_add(n, h);
            m = this.safe_add(m, f);
            l = this.safe_add(l, e)
        }
        return Array(o, n, m, l)
    },
    md5_cmn : function(h, e, d, c, g, f) {
        return this.safe_add(this.bit_rol(this.safe_add(this.safe_add(e, h), this.safe_add(c, f)), g), d)
    },
    md5_ff : function(g, f, k, j, e, i, h) {
        return this.md5_cmn((f & k) | ((~f) & j), g, f, e, i, h)
    },
    md5_gg : function(g, f, k, j, e, i, h) {
        return this.md5_cmn((f & j) | (k & (~j)), g, f, e, i, h)
    },
    md5_hh : function (g, f, k, j, e, i, h) {
        return this.md5_cmn(f ^ k ^ j, g, f, e, i, h)
    },
    md5_ii : function(g, f, k, j, e, i, h) {
        return this.md5_cmn(k ^ (f | (~j)), g, f, e, i, h)
    },
    safe_add : function(a, d) {
        var c = (a & 65535) + (d & 65535);
        var b = (a >> 16) + (d >> 16) + (c >> 16);
        return (b << 16) | (c & 65535)
    },
    bit_rol : function(a, b) {
        return (a << b) | (a >>> (32 - b))
    }
};
String.prototype.md5 = function() {
	return _Md5.hex_md5(this);
};
String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
};
String.prototype.limit = function(len) {
	if (len && this.length > len - 3) {
		return this.substring(0, len - 3) + "...";
	}
	return this;
};
String.prototype.encode = function() {
	return encodeURIComponent(this);
};
String.prototype.decode = function() {
	return decodeURIComponent(this);
};
$.extend({
	cnReg : /^[a-zA-Z0-9][\._\-@a-zA-Z0-9]{4,29}$/,
	mailReg : /^[a-zA-Z0-9][_a-zA-Z0-9]{4,}@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\.)+[a-zA-Z]{2,}$/,
    phoneReg : /^((13[0-9])|(15[^4,\D])|(18[0,5-9]))\d{8}$/,
    pwdReg : /^[~`!@#$%\^&*()_+=\-{}\]\[:;.<>\/?a-zA-Z0-9]{4,16}$/,
    nameReg : /^[\u4E00-\u9FA5]+$/,
    certReg : /^\d{17}(\d|x|X)|\d{15}$/i,
    _certArea : {11 : '',12 : '',13 : '',14 : '',15 : '',21 : '',22 : '',23 : '',
        31 : '',32 : '',33 : '',34 : '',35 : '',36 : '',37 : '',41 : '',42 : '',
        43 : '',44 : '',45 : '',46 : '',50 : '',51 : '',52 : '',53 : '',54 : '',
        61 : '',62 : '',63 : '',64 : '',65 : '',71 : '',81 : '',82 : '',91 : ''
    },
	isEmpty : function(value) {
		return value == '' || value == null || value == undefined;
	},
	isEmptyArray : function(array) {
		for ( var i = 0; i < array.length; i++) {
            if ($.isEmpty(array[i])) {
                return true
            }
        }
		return false;
	},
	random : function() {
		var len = arguments[0] && isNaN(arguments[0]) ? arguments[0] : 5;	
		return parseInt(Math.random() * Math.pow(10, len));
	},
	date : function(time) {
		var t = parseInt(time);
		var date = isNaN(t) ? new Date() : new Date(t);
		var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
		var day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
		var hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
		var minute = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		var second = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
		return date.getFullYear() + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
	},
	getData : function(json) {
        var string = '';
        for ( var key in json) {
            string += "&" + key + "=" + json[key]
        }
        return string.length > 0 ? string.substring(1) : ''
    },
    getJSONP : function(url, params, func) {
        params.callback = '?';
        $.getJSON(url, $.getData(params), function(data) {
            func && func(data);
        })
    }
});
$.fn.extend({
	isCn : function() {
        var result = 0;
        var cn = this.val().trim();
        if (cn == undefined || cn == '') {
            result = 2;
        } else if (cn.length < 5 || cn.length > 30) {
            result = 3;
        } else if (!$.cnReg.test(cn)) {
            result = 4;
        }
        return result;
    },
	isMail : function() {
        var result = 0;
        var mail = this.val().trim();
        if (mail == undefined || mail == '') {
            result = 20;
        } else if (!$.mailReg.test(mail)) {
            result = 20;
        }
        return result;
    },
    isPhone : function() {
        var result = 0;
        var phone = this.val().trim();
        if (phone == undefined || phone == '') {
            result = 2;
        } else if (!$.phoneReg.test(phone)) {
            result = 21;
        }
        return result;
    },
    isPwd : function(cn) {
        var result = 0;
        var pwd = this.val().trim();
        if (pwd == undefined || pwd == '') {
            result = 6;
        } else if (pwd.length < 4 || pwd.length > 16) {
            result = 7;
        } else if (!$.pwdReg.test(pwd)) {
            result = 8;
        } else if (pwd == cn) {
            result = 9;
        }
        return result;
    },
    isPwd2 : function(pwd) {
        var result = 0;
        var pwd2 = this.val().trim();
        if (pwd2 == undefined || pwd2 == '') {
            result = 6;
        } else if (pwd != pwd2) {
            result = 10;
        }
        return result;
    },
    isName : function() {
        var result = 0;
        var name = this.val().trim();
        if (name == undefined || name == '') {
            result = 14;
        } else if (name.length < 2 || name.length > 8) {
            result = 15;
        } else if(!$.nameReg.test(name)) {
            result = 16;
        }
        return result;
    },
    isCertNum : function() {
        var result = 0;
        var certnum = this.val().trim();
        if (certnum == undefined || certnum == '') {
            result = 17;
        } else if (certnum.length != 15 && certnum.length != 18) {
            result = 18;
        } else if (!$.certReg.test(certnum)) {
            result = 19;
        } else if ($._certArea[parseInt(certnum.substr(0, 2))] == null) {
            result = 19;
        } else {
            if (certnum.length == 15) {
                certnum = certnum.substring(0, 6) + "19" + certnum.substring(6);
            }
            sBirthday = certnum.substr(6, 4) + "-" + Number(certnum.substr(10, 2))
                    + "-" + Number(certnum.substr(12, 2));
            var d = new Date(sBirthday.replace(/-/g, "/"));
            if (sBirthday != (d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate())) {
                result = 19;
            } else if (certnum.length == 18) {
                certnum = certnum.replace(/x$/i, "a");
                var sum = 0;
                for ( var i = 17; i >= 0; i--) {
                    sum += (Math.pow(2, i) % 11) * parseInt(certnum.charAt(17 - i), 11)
                }
                if (sum % 11 != 1) {
                    result = 19;
                }
            } 
        }
        return result;
    }
});