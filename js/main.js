	document.querySelector('.color-button').onclick = function() {
		style = getCookie("style");
		setColor(style);
	}

	function setCookie(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
		var d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	  }
	  
	  if (expires && expires.toUTCString)options.expires = expires.toUTCString();
	  
	  value = encodeURIComponent(value);
	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
		updatedCookie += "; " + propName;
		var propValue = options[propName];
		if (propValue !== true)updatedCookie += "=" + propValue;
	  }

	  document.cookie = updatedCookie;
	}
	
	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}
	
	function rand(min, max) {
		return Math.floor(Math.random() * (max - min)) + min;
	}
	
	function setColor(str){
		switch(str){
			default:
				color = 'style';
				version = document.getElementById("style").getAttribute("data-version");
				document.getElementById("theme-meta").setAttribute("content", "#f4be5b");
				document.getElementById("style").setAttribute("href", "/style/"+color+".css?"+version);
				
				setCookie("style", color, {expires: Date.now()+86400*365});
				setCookie("theme-meta", "#f4be5b", {expires: Date.now()+86400*365});
			break;
			
			case "style":
				color = 'material';
				version = document.getElementById("style").getAttribute("data-version");
				document.getElementById("theme-meta").setAttribute("content", "#2196F3");
				document.getElementById("style").setAttribute("href", "/style/"+color+".css?"+version);
				
				setCookie("style", color, {expires: Date.now()+86400*365});
				setCookie("theme-meta", "#2196F3", {expires: Date.now()+86400*365});
			break;
		}
	}  