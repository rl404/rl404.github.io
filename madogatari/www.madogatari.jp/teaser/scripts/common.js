var ua,
		isSP = false,
		isIE = false,
		ie_ver = '',
		is_ie_ver = false,
		osStr = '',
		blowserStr = '',
		event_type = 'click';

;(function($,window,undefind) {
	var $window = $(window),
			$document = $(document);

	/* -----------------------------------------------
	 * Init Handler
	 * ----------------------------------------------- */
	initialize();

	/* -----------------------------------------------
	 * Start Handler
	 * ----------------------------------------------- */
	window.onLoad = startAnimation();

	/* -----------------------------------------------
	 * Init
	 * ----------------------------------------------- */
	function initialize(){
		getUA();
		// isSP = true;
		if(isSP){
			// event_type = "touchend";
			$('body').addClass('sp');
		}
		else{
			event_type = "click";
			$('body').addClass('pc');
		}

		$('.fadeover a').hover(
			function(){
				$(this).stop(true, false).animate({ opacity: 0.5 },{ duration: 200 });
			},
			function(){
				$(this).stop(true, false).animate({ opacity: 1 },{ duration: 200 });
			}
		);

	};

	/* -----------------------------------------------
	 * Start Contents
	 * ----------------------------------------------- */
	function startAnimation(){
		initContent(isSP, event_type, isIE, osStr, blowserStr);
	}
})(jQuery,window,window.Modernizr);



/* -----------------------------------------------
 * Check User Agent
 * ----------------------------------------------- */
function getUA(){
	var ua = {};
	ua.name = window.navigator.userAgent.toLowerCase();
	 
	ua.isIE = (ua.name.indexOf('msie') >= 0 || ua.name.indexOf('trident') >= 0);
	ua.isiPhone = ua.name.indexOf('iphone') >= 0;
	ua.isiPod = ua.name.indexOf('ipod') >= 0;
	ua.isiPad = ua.name.indexOf('ipad') >= 0;
	ua.isiOS = (ua.isiPhone || ua.isiPod || ua.isiPad);
	ua.isAndroid = ua.name.indexOf('android') >= 0;
	ua.isTablet = (ua.isiPad || (ua.isAndroid && ua.name.indexOf('mobile') < 0));
	ua.chrome = ua.name.indexOf('chrome') >= 0;
	ua.windows = ua.name.indexOf('win') >= 0;
	ua.mac = ua.name.indexOf('mac') >= 0;
	 
	if (ua.isIE) {
	    ua.verArray = /(msie|rv:?)\s?([0-9]{1,})([\.0-9]{1,})/.exec(ua.name);
	    if (ua.verArray) {
	        ua.ver = parseInt(ua.verArray[2], 10);
	    }
	}
	if (ua.isiOS) {
	    ua.verArray = /(os)\s([0-9]{1,})([\_0-9]{1,})/.exec(ua.name);
	    if (ua.verArray) {
	        ua.ver = parseInt(ua.verArray[2], 10);
	    }
	}
	if (ua.isAndroid) {
	    ua.verArray = /(android)\s([0-9]{1,})([\.0-9]{1,})/.exec(ua.name);
	    if (ua.verArray) {
	        ua.ver = parseInt(ua.verArray[2], 10);
	    }
	}

	// alert(ua.name);
	if(ua.chrome){
		blowserStr = 'chrome';
		// alert('chorme');
	}
	if(ua.windows){
		osStr = 'win';
		// alert('win');
	}
	if(ua.mac){
		osStr = 'mac';
		// alert('mac');
	}


	if (ua.isiOS || ua.isAndroid || ua.isTablet) {
		isSP = true;
	}

	if (ua.isIE && ua.ver <= 11) {
		isIE = true;
	}
};

/* -----------------------------------------------
 * Tracer
 * ----------------------------------------------- */
function trace(p, s){
	// if (jQuery.browser.msie) {return};
	// console.log(p + " -> ", s);
};