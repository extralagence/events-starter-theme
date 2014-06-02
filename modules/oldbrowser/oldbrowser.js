/*
 * Browser Detection
 * � 2010 DevSlide Labs 
 * 
 * Visit us at: www.devslide.com/labs
 */

var notSupportedBrowsers = [];
var supportedBrowsers = [];
var BD;

var BrowserDetection = {
	init: function(){
		
		BD = this;
		
		if(notSupportedBrowsers == null || notSupportedBrowsers.length < 1){
			notSupportedBrowsers = BD.defaultNotSupportedBrowsers;
		}
		
		BD.detectBrowser();
		
		if(BD.browser == '' || BD.browser == 'Unknown' || BD.os == '' || 
		   BD.os == 'Unknown' || BD.browserVersion == '' || BD.browserVersion == 0)
		{
			return;
		}
		
		// Check if this is old browser
		var oldBrowser = false;
		for(var i = 0; i < notSupportedBrowsers.length; i++){
			if(notSupportedBrowsers[i].os == 'Any' || notSupportedBrowsers[i].os == BD.os){
				if(notSupportedBrowsers[i].browser == 'Any' || notSupportedBrowsers[i].browser == BD.browser){
					if(notSupportedBrowsers[i].version == "Any" || BD.browserVersion <= parseFloat(notSupportedBrowsers[i].version)){
						oldBrowser = true;
						break;
					}
				} 
			}
		}
		
		if(oldBrowser){
			BD.show();
		}
	},
	
	show: function(){
		if(this.readCookie('bdnotice') == 1){
			return;
		}
		$.fancybox($("#oldBrowser"), {
			padding: 0,
			beforeClose: BD.remindMe
		});
	},
	
	remindMe: function(never){
		BD.writeCookie('bdnotice', 1, never == true ? 365 : 1);
	},
	
	writeCookie: function(name, value, days){
		var expiration = ""; 
		if(parseInt(days) > 0){
			var date = new Date();
			date.setTime(date.getTime() + parseInt(days) * 24 * 60 * 60 * 1000);
			expiration = '; expires=' + date.toGMTString();
		}
		
		document.cookie = name + '=' + value + expiration + '; path=/';
	},
	
	readCookie: function(name){
		if(!document.cookie){ return ''; }
		
		var searchName = name + '='; 
		var data = document.cookie.split(';');
		
		for(var i = 0; i < data.length; i++){
			while(data[i].charAt(0) == ' '){
				data[i] = data[i].substring(1, data[i].length);
			}
			
			if(data[i].indexOf(searchName) == 0){ 
				return data[i].substring(searchName.length, data[i].length);
			}
		}
		
		return '';
	},

	detectBrowser: function(){
		BD.browser = '';
		BD.browserVersion = 0;
		
		if(/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
			BD.browser = 'Opera';
		} else if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
			BD.browser = 'MSIE';
		} else if(/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
			BD.browser = 'Netscape';
		} else if(/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
			BD.browser = 'Chrome';
		} else if(/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
			BD.browser = 'Safari';
			/Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
			BD.browserVersion = new Number(RegExp.$1);
		} else if(/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
			BD.browser = 'Firefox';
		}
		
		if(BD.browser == ''){
			BD.browser = 'Unknown';
		} else if(BD.browserVersion == 0) {
			BD.browserVersion = parseFloat(new Number(RegExp.$1));
		}		
	},
	
	//	Variables
	browser: '',
	browserVersion: '',
	defaultNotSupportedBrowsers: [
		{'os': 'Any', 'browser': 'MSIE', 'version': 7},
		{'os': 'Any', 'browser': 'Firefox', 'version': 4},
		{'os': 'Any', 'browser': 'Safari', 'version': 4},
		{'os': 'Any', 'browser': 'Chrome', 'version': 15},
		{'os': 'Any', 'browser': 'Opera', 'version': 12},
		{'os': 'Any', 'browser': 'Netscape', 'version': 'Any'}
	]
};

jQuery(document).ready(function(){
	BrowserDetection.init();
});