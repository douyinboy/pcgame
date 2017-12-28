function YDBOBJ() {
	this.YundabaoUA = navigator.userAgent.toLowerCase();
	this.isIos = this.YundabaoUA.match(/(iphone|ipod|ipad);?/i);
	this.isAndroid = this.YundabaoUA.match(/android/i);
	this.isWindows = this.YundabaoUA.match(/windows/i)
};
var ApiFunHandler = function(funName, iArguments, seperator) {
		if (typeof(seperator) == "undefined") seperator = ",";
		var YundabaoUA = navigator.userAgent.toLowerCase(),
			isIos = YundabaoUA.match(/(iphone|ipod|ipad);?/i),
			isAndroid = YundabaoUA.match(/android/i),
			isWindows = YundabaoUA.match(/windows/i);
		var paraLen = iArguments.length;
		if (paraLen > 0) {
			var OtherParameters = "";
			for (var i = 0; i < paraLen; i++) {
				OtherParameters += iArguments[i];
				if (i < paraLen - 1) OtherParameters += seperator
			}
		};
		if (isIos) {
			var ifr = document.createElement('iframe');
			ifr.src = "app9vcom:##//" + funName + "/?" + OtherParameters;
			ifr.style.width = "0";
			ifr.style.height = "0";
			document.body.appendChild(ifr);
			if (null != ifr) ifr.parentNode.removeChild(ifr);
			ifr = null;
			try {
				if (OtherParameters != "") {
					eval("window.webkit.messageHandlers." + funName + ".postMessage('" + (OtherParameters == "" ? "''" : OtherParameters) + "')")
				} else eval("window.webkit.messageHandlers." + funName + ".postMessage('')")
			} catch (ex) {}
		} else if (isAndroid && window.App9vCom) {
			var androidParas = "",
				argLength = iArguments.length;
			for (var i = 0; i < argLength; i++) androidParas += YDBGetArguments(eval("iArguments[" + i.toString() + "]")) + (argLength > 1 && i < (argLength - 1) ? "," : "");
			var outV = eval("window.App9vCom." + funName + "(" + androidParas + ")")
		}
	};
YDBOBJ.prototype.Alert = function() {
	alert(this.isWindows)
};

function YDBGetArguments(arg) {
	var outStr = "";
	if (typeof arg == "string") outStr = "\"" + arg + "\"";
	else if (typeof arg == "int") outStr = arg;
	else outStr = arg;
	return outStr
};
YDBOBJ.prototype.SetGlobal = function(HeadBar, DragRefresh, HeadBarExceptionList, DragRefreshExceptionList, CashTime, CashTimeUnit, BackKeyUseType, ShowCloseButton, CloseText, ClearCookie, BgColor) {
	var OtherParameters = "";
	var paraLen = arguments.length;
	if (paraLen > 8) {
		for (var i = 8; i < paraLen; i++) {
			OtherParameters += arguments[i];
			if (i < paraLen - 1) OtherParameters += ","
		}
	};
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//SetGlobal/?" + HeadBar + "," + DragRefresh + "," + encodeURI(HeadBarExceptionList.replace(/,/g, "|")) + "," + encodeURI(DragRefreshExceptionList.replace(/,/g, "|")) + "," + ShowCloseButton + "," + OtherParameters;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.SetGlobal.postMessage(HeadBar + "," + DragRefresh + "," + encodeURI(HeadBarExceptionList.replace(/,/g, "|")) + "," + encodeURI(DragRefreshExceptionList.replace(/,/g, "|")) + "," + ShowCloseButton + "," + OtherParameters)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.SetGlobal(HeadBar, DragRefresh, HeadBarExceptionList, DragRefreshExceptionList, CashTime, CashTimeUnit, BackKeyUseType, ShowCloseButton, OtherParameters)
	}
};
YDBOBJ.prototype.SetHeadBar = function(IntState) {
	var funName = "SetHeadBar";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetMenuBar = function(IntState) {
	var funName = "SetMenuBar";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetDragRefresh = function(IntState) {
	var funName = "SetDragRefresh";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetMoreButton = function(IntState) {
	var funName = "SetMoreButton";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.MenuBarAutoHide = function(IntState) {
	var funName = "MenuBarAutoHide";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GoBack = function() {
	var funName = "GoBack";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GoTop = function() {
	var funName = "GoTop";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.Scan = function() {
	var funName = "Scan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetScan = function(CallBackFun) {
	var funName = "GetScan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.Share = function(title, content, img, linkUrl, CallBackFun) {
	if (this.isIos) {
		title = title.replace(/,/g, "，");
		content = content.replace(/,/g, "，");
		var ifr = document.createElement('iframe');
		if (undefined == CallBackFun) ifr.src = "app9vcom:##//Share/?" + encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl);
		else ifr.src = "app9vcom:##//Share/?" + encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(CallBackFun);
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			if (undefined == CallBackFun) window.webkit.messageHandlers.Share.postMessage(encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl));
			else window.webkit.messageHandlers.Share.postMessage(encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(CallBackFun))
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		if (undefined == CallBackFun) var outV = window.App9vCom.Share(title, content, img, linkUrl);
		else var outV = window.App9vCom.Share(title, content, img, linkUrl, CallBackFun)
	}
};
YDBOBJ.prototype.SingleShare = function(title, content, img, linkUrl, platform, CallBackFun) {
	if (this.isIos) {
		title = title.replace(/,/g, "，");
		content = content.replace(/,/g, "，");
		var ifr = document.createElement('iframe');
		if (undefined == CallBackFun) ifr.src = "app9vcom:##//SingleShare/?" + encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(platform);
		else ifr.src = "app9vcom:##//SingleShare/?" + encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(platform) + "," + encodeURI(CallBackFun);
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			if (undefined == CallBackFun) window.webkit.messageHandlers.SingleShare.postMessage(encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(platform));
			else window.webkit.messageHandlers.SingleShare.postMessage(encodeURI(title) + "," + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl) + "," + encodeURI(platform) + "," + encodeURI(CallBackFun))
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		if (undefined == CallBackFun) var outV = window.App9vCom.SingleShare(title, content, img, linkUrl, platform);
		else var outV = window.App9vCom.SingleShare(title, content, img, linkUrl, platform, CallBackFun)
	}
};
YDBOBJ.prototype.ClearCache = function() {
	var funName = "ClearCache";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SpeechRecognition = function(CallBackFun) {
	var funName = "SpeechRecognition";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetGPS = function(CallBackFun) {
	var funName = "GetGPS";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenGPS = function(userid) {
	var funName = "OpenGPS";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.CloseGPS = function() {
	var funName = "CloseGPS";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetDeviceInformation = function(CallBackFun) {
	var funName = "GetDeviceInformation";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.PopUp = function(index, count) {
	if (index == "" || undefined == index) index = "0";
	if (count == "" || undefined == count) count = "0";
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//PopUp/?" + index.replace(/,/g, "|") + "," + count.replace(/,/g, "|");
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.PopUp.postMessage(index.replace(/,/g, "|") + "," + count.replace(/,/g, "|"))
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.PopUp(index, count)
	}
};
YDBOBJ.prototype.ImageViewState = function(state) {
	var funName = "ImageViewState";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetAlipayInfo = function(ProductName, Desicript, Price, OuttradeNo) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//SetAlipayInfo/?" + ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.SetAlipayInfo.postMessage(ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.SetAlipayInfo(ProductName, Desicript, Price, OuttradeNo)
	}
};
YDBOBJ.prototype.SetWxpayInfo = function(ProductName, Desicript, Price, OuttradeNo, attach) {
	Price = Price.toString();
	if (attach == "" || undefined == attach) attach = undefined;
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//SetWxpayInfo/?" + ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo + "[,]" + attach;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.SetWxpayInfo.postMessage(ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo + "[,]" + attach)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.SetWxpayInfo(ProductName, Desicript, Price, OuttradeNo, attach)
	}
};
YDBOBJ.prototype.WXLogin = function(returnDataType, accessUrl) {
	var funName = "WXLogin";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ShowTopRightMenu = function() {
	var funName = "ShowTopRightMenu";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.UploadImage = function(receiveUrl, showFun, UserName, Key, IsCut, CutWidth, CutHeight, sourceType, isUpload) {
	var funName = "UploadImage";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetBgColor = function(BgColor) {
	var funName = "SetBgColor";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetReturnButtonMode = function(showmode) {
	var funName = "SetReturnButtonMode";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetWifiSsid = function(CallBackFun) {
	var funName = "GetWifiSsid";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.UseTouchID = function(CallBackFun, LoginUrl, AccessTitle, FallbackTitle) {
	var funName = "UseTouchID";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetHealthStep = function(CallBackFun) {
	var funName = "GetHealthStep";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.QQLogin = function(accessUrl) {
	var funName = "QQLogin";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenBluetooth = function() {
	var funName = "OpenBluetooth";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ExitApp = function() {
	var funName = "ExitApp";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.AnimationWay = function(entranceway, exitway) {
	if (entranceway == "2" || entranceway == "3") entranceway = "0";
	if (exitway == "2" || exitway == "3") exitway = "0";
	if (entranceway == "0" && exitway == "1") exitway = "0";
	if (entranceway == "1" && exitway == "0") exitway = "1";
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//AnimationWay/?" + entranceway + "," + exitway;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.AnimationWay.postMessage(entranceway + "," + exitway)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.AnimationWay(entranceway, exitway)
	}
};
YDBOBJ.prototype.OpenWithSafari = function(openurl) {
	var funName = "OpenWithSafari";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenNewWindow = function() {
	var funName = "OpenNewWindow";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetOpenCurrentWindow = function() {
	var funName = "SetOpenCurrentWindow";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetUserRelationForPush = function(YDB_UserName) {
	var funName = "PushMsgConfig";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetClientIDOfGetui = function(doWithCIDFun) {
	var funName = "GetClientIDOfGetui";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.RongyunLogin = function(userId, name, portraitUri, token) {
	var funName = "RongyunLogin";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.InitiateChat = function(otheruserId, nickName, portraitUri) {
	var funName = "InitiateChat";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SessionList = function() {
	var funName = "SessionList";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.RefreshUserInfo = function(userId, name, portraitUri) {
	var funName = "RefreshUserInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.CreateDiscussGroup = function(defaultUserId, groupName, groupId) {
	var funName = "CreateDiscussGroup";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenDiscussGroup = function(groupId, groupName) {
	var funName = "OpenDiscussGroup";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.AddDiscussGroup = function(groupId, userId, nickName, portraitUri) {
	var funName = "AddDiscussGroup";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.RemoveDiscussGroup = function(groupId, userId) {
	var funName = "RemoveDiscussGroup";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.IntPortraitUri = function(userId, nickName, portraitUri) {
	var funName = "IntPortraitUri";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SetStatusBarStyle = function(colorvalue) {
	var funName = "SetStatusBarStyle";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.isWXAppInstalled = function(installstate) {
	var funName = "isWXAppInstalled";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.IsReloadPreviousPage = function(operation) {
	var funName = "IsReloadPreviousPage";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.IsReloadNextPage = function(operation) {
	var funName = "IsReloadNextPage";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.DismissVC = function() {
	var funName = "DismissVC";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetBaseInfo = function(callback) {
	var funName = "GetBaseInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetCpuInfo = function(callback) {
	var funName = "GetCpuInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetMemoryInfo = function(callback) {
	var funName = "GetMemoryInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetStorageInfo = function(callback) {
	var funName = "GetStorageInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetDisplayInfo = function(callback) {
	var funName = "GetDisplayInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GpsState = function(callback) {
	var funName = "GpsState";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.Opengps = function() {
	if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.Opengps()
	}
};
YDBOBJ.prototype.ContactAll = function(callback) {
	var funName = "ContactAll";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ContactSelect = function(callback) {
	var funName = "ContactSelect";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ContactAdd = function(lastName, firstName, homeNum, mobile, email, callback) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//ContactAdd/?" + encodeURI(lastName) + "," + encodeURI(firstName) + "," + homeNum + "," + mobile + "," + email + "," + callback;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.ContactAdd.postMessage(encodeURI(lastName) + "," + encodeURI(firstName) + "," + homeNum + "," + mobile + "," + email + "," + callback)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var name = lastName + firstName;
		var outV = window.App9vCom.ContactAdd(name, homeNum, mobile, email, callback)
	}
};
YDBOBJ.prototype.ContactDelete = function(contactid, callback) {
	var funName = "ContactDelete";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ContactUpdate = function(contactid, lastName, firstName, homeNum, mobile, email, callback) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//ContactUpdate/?" + contactid + "," + encodeURI(lastName) + "," + encodeURI(firstName) + "," + homeNum + "," + mobile + "," + email + "," + callback;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.ContactUpdate.postMessage(contactid + "," + encodeURI(lastName) + "," + encodeURI(firstName) + "," + homeNum + "," + mobile + "," + email + "," + callback)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.ContactUpdate(contactid, lastName, firstName, homeNum, mobile, email, callback)
	}
};
YDBOBJ.prototype.StartVoice = function(path) {
	var funName = "StartVoice";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.VolumeVideo = function(volume) {
	var funName = "VolumeVideo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.PauseVoice = function() {
	var funName = "PauseVoice";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.PlayVoice = function() {
	var funName = "PauseVoice";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.StopVoice = function() {
	var funName = "StopVoice";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenVideo = function(path) {
	var funName = "OpenVideo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.Wallpaper = function(path) {
	var funName = "Wallpaper";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorInfo = function(callback) {
	var funName = "NavigatorInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorBaidu = function() {
	var funName = "NavigatorBaidu";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorGoogle = function() {
	var funName = "NavigatorGoogle";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorGaode = function() {
	var funName = "NavigatorGaode";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorBaiduPath = function(startlat, startlon, endlat, endlon) {
	var funName = "NavigatorBaiduPath";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.NavigatorGaodePath = function(startlat, startlon, startname, endlat, endlon, endname) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//NavigatorGaodePath/?" + startlat + "," + startlon + "," + encodeURI(startname) + "," + endlat + "," + endlon + "," + encodeURI(endname);
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.NavigatorGaodePath.postMessage(startlat + "," + startlon + "," + encodeURI(startname) + "," + endlat + "," + endlon + "," + encodeURI(endname))
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.NavigatorGaodePath(startlat, startlon, startname, endlat, endlon, endname)
	}
};
YDBOBJ.prototype.appleNavigation = function(startlat, startlon, endlat, endlon) {
	var funName = "appleNavigation";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLinitManager = function(callback) {
	var funName = "BLinitManager";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLscan = function(callback) {
	var funName = "BLscan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLgetPeripheral = function(callback) {
	var funName = "BLgetPeripheral";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLisScanning = function(callback) {
	var funName = "BLisScanning";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLstopScan = function() {
	var funName = "BLstopScan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLconnect = function(peripheralUUID, callback) {
	var funName = "BLconnect";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLdisconnect = function(peripheralUUID, callback) {
	var funName = "BLdisconnect";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLisConnected = function(peripheralUUID, callback) {
	var funName = "BLisConnected";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLretrievePeripheral = function(peripheralUUIDs, callback) {
	var funName = "BLretrievePeripheral";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLretrieveConnectedPeripheral = function(serviceUUIDs, callback) {
	var funName = "BLretrieveConnectedPeripheral";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLdiscoverService = function(peripheralUUID, callback) {
	var funName = "BLdiscoverService";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLdiscoverCharacteristics = function(peripheralUUID, serviceUUID, callback) {
	var funName = "BLdiscoverCharacteristics";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLdiscoverDescriptorsForCharacteristic = function(peripheralUUID, serviceUUID, characteristicUUID, callback) {
	var funName = "BLdiscoverDescriptorsForCharacteristic";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLsetNotify = function(peripheralUUID, serviceUUID, characteristicUUID, callback) {
	var funName = "BLsetNotify";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLreadValueForCharacteristic = function(peripheralUUID, serviceUUID, characteristicUUID, callback) {
	var funName = "BLreadValueForCharacteristic";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLreadValueForDescriptor = function(peripheralUUID, serviceUUID, characteristicUUID, descriptorUUID, callback) {
	var funName = "BLreadValueForDescriptor";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLwriteValueForCharacteristic = function(peripheralUUID, serviceUUID, characteristicUUID, value, callback) {
	var funName = "BLwriteValueForCharacteristic";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.BLwriteValueForDescriptor = function(peripheralUUID, serviceUUID, characteristicUUID, descriptorUUID, value, callback) {
	var funName = "BLwriteValueForDescriptor";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.SwitchApp = function(appid) {
	var funName = "SwitchApp";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.iOSSystemShare = function(content, img, linkUrl) {
	if (this.isIos) {
		content = content.replace(/,/g, "，");
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//iOSSystemShare/?" + encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl);
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.iOSSystemShare.postMessage(encodeURI(content) + "," + encodeURI(img) + "," + encodeURI(linkUrl))
		} catch (ex) {}
	}
};
YDBOBJ.prototype.IsFixedBottomMenu = function(IntState) {
	if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.IsFixedBottomMenu(IntState)
	}
};
YDBOBJ.prototype.SetFontSize = function() {
	var funName = "SetFontSize";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.Ring = function() {
	if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.Ring()
	}
};
YDBOBJ.prototype.SetBrightness = function(percent) {
	var funName = "SetBrightness";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.CiticWxPay = function(appid, partnerid, prepayid, noncestr, sign, timestamp, Outtradeno, attach) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//CiticWxPay/?" + appid + "[,]" + partnerid + "[,]" + prepayid + "[,]" + noncestr + "[,]" + sign + "[,]" + timestamp + "[,]" + Outtradeno + "[,]" + attach;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.CiticWxPay.postMessage(appid + "[,]" + partnerid + "[,]" + prepayid + "[,]" + noncestr + "[,]" + sign + "[,]" + timestamp + "[,]" + Outtradeno + "[,]" + attach)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.CiticWxPay(appid, partnerid, prepayid, noncestr, sign, timestamp, Outtradeno, attach)
	}
};
YDBOBJ.prototype.BeeCloudPay = function(channel, bill_no, title, total_fee, optional, return_url) {
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//BeeCloudPay/?" + channel + "[,]" + bill_no + "[,]" + title + "[,]" + total_fee + "[,]" + optional + "[,]" + return_url;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.BeeCloudPay.postMessage(channel + "[,]" + bill_no + "[,]" + title + "[,]" + total_fee + "[,]" + optional + "[,]" + return_url)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.BeeCloudPay(channel, bill_no, title, total_fee, optional, return_url)
	}
};
YDBOBJ.prototype.GetHalfScan = function(CallBackFun, top, height) {
	var funName = "GetHalfScan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.CloseScan = function() {
	var funName = "CloseScan";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.WftWxpayInfo = function(ProductName, Desicript, Price, OuttradeNo, attach) {
	Price = Price.toString();
	if (attach == "" || undefined == attach) attach = undefined;
	if (this.isIos) {
		var ifr = document.createElement('iframe');
		ifr.src = "app9vcom:##//WftWxpayInfo/?" + ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo + "[,]" + attach;
		ifr.style.width = "0";
		ifr.style.height = "0";
		document.body.appendChild(ifr);
		if (null != ifr) ifr.parentNode.removeChild(ifr);
		ifr = null;
		try {
			window.webkit.messageHandlers.WftWxpayInfo.postMessage(ProductName + "[,]" + Desicript + "[,]" + Price + "[,]" + OuttradeNo + "[,]" + attach)
		} catch (ex) {}
	} else if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.SetWxpayInfo(ProductName, Desicript, Price, OuttradeNo, attach)
	}
};
YDBOBJ.prototype.SetHardware = function(status) {
	if (this.isAndroid && window.App9vCom) {
		var outV = window.App9vCom.SetHardware(status)
	}
};
YDBOBJ.prototype.isScreenOrientation = function(status) {
	var funName = "isScreenOrientation";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.OpenStep = function(userid) {
	var funName = "OpenStep";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetCurrentStep = function(uid, starttime, endtime, callback) {
	var funName = "GetCurrentStep";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.openUCBrower = function(url, downloadurl) {
	var funName = "openUCBrower";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetChannel = function(callback) {
	var funName = "GetChannel";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.CopyPasteboardText = function(txt) {
	var funName = "copyPasteboardText";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.StatusBarHidden = function(isShow) {
	var funName = "statusBarHidden";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.IsShowLandcape = function(isShow) {
	var funName = "IsShowLandcape";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.ScreenOrientation = function(isShow) {
	var funName = "screenOrientation";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.GetAppInfo = function(callBackFun) {
	var funName = "GetAppInfo";
	ApiFunHandler(funName, arguments)
};
YDBOBJ.prototype.test = function(IntState) {
	var funName = "test";
	ApiFunHandler(funName, arguments)
}