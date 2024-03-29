/**
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * Copyright (c) 2011 Matteo Spinelli, http://cubiq.org/
 * Released under MIT license
 * http://cubiq.org/dropbox/mit-license.txt
 *
 * Version 1.0 - Last updated: 2011.01.29
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 */
;(function(){
var nav = navigator,
	isIDevice = (/iphone|ipod|ipad/gi).test(nav.platform),
	isIPad = (/ipad/gi).test(nav.platform),
	isRetina = 'devicePixelRatio' in window && window.devicePixelRatio > 1,
	isSafari = nav.appVersion.match(/Safari/gi),
	hasHomescreen = 'standalone' in nav && isIDevice,
	isStandalone = hasHomescreen && nav.standalone,
	OSVersion = nav.appVersion.match(/OS \d+_\d+/g),
	platform = nav.platform.split(' ')[0],
	language = nav.language.replace('-', '_'),
	startY = startX = 0,
	expired = localStorage.getItem('_addToHome'),
	theInterval, closeTimeout, el, i, l,
	options = {
		animationIn: 'drop',		// drop || bubble || fade
		animationOut: 'fade',		// drop || bubble || fade
		startDelay: 2000,			// 2 seconds from page load before the balloon appears
		lifespan: 20000,			// 20 seconds before it is automatically destroyed
		bottomOffset: 14,			// Distance of the balloon from bottom
		expire: 0,					// Minutes to wait before showing the popup again (0 = always displayed)
		message: '',				// Customize your message or force a language ('' = automatic)
		touchIcon: false,			// Display the touch icon
		arrow: true,				// Display the balloon arrow
		iterations:100				// Internal/debug use
	},
	/* Message in various languages, en_us is the default if a language does not exist */
	intl = {
		da_dk: 'TilfÃ¸j denne side til din %device: tryk pÃ¥ `%icon` og derefter `<strong>TilfÃ¸j til hjemmeskÃ¦rm</strong>`.',
		de_de: 'Installieren Sie diese App auf Ihrem %device: `%icon` antippen und dann `<strong>Zum Home-Bildschirm</strong>`.',
		el_gr: 'Î•Î³ÎºÎ±Ï„Î±ÏƒÏ„Î®ÏƒÎµÏ„Îµ Î±Ï…Ï„Î®Î½ Ï„Î·Î½ Î•Ï†Î±ÏÎ¼Î¿Î³Î® ÏƒÏ„Î®Î½ ÏƒÏ…ÏƒÎºÎµÏ…Î® ÏƒÎ±Ï‚ %device: `%icon` Î¼ÎµÏ„Î¬ Ï€Î±Ï„Î¬Ï„Îµ `<strong>Î ÏÎ¿ÏƒÎ¸Î®ÎºÎ· ÏƒÎµ Î‘Ï†ÎµÏ„Î·ÏÎ¯Î±</strong>`.',
		en_us: 'Install this web app on your %device: tap `%icon` and then `<strong>Add to Home Screen</strong>`.',
		es_es: 'Para instalar esta app en su %device, pulse `%icon` y seleccione `<strong>AÃ±adir a pantalla de inicio</strong>`.',
		fr_fr: 'Ajoutez cette application sur votre %device en cliquant sur `%icon`, puis `<strong>Ajouter Ã  l\'Ã©cran d\'accueil</strong>`.',
		he_il: '<span dir="rtl">×”×ª×§×Ÿ ××¤×œ×™×§×¦×™×” ×–×• ×¢×œ ×”-%device ×©×œ×š: ×”×§×© `%icon` ×•××– `<strong>×”×•×¡×£ ×œ×ž×¡×š ×”×‘×™×ª</strong>`.</span>',
		it_it: 'Installa questa applicazione sul tuo %device: premi su `%icon` e poi `<strong>Aggiungi a Home</strong>`.',
		ja_jp: 'ã“ã®ã‚¦ã‚§ãƒ–ã‚¢ãƒ—ãƒªã‚’ã‚ãªãŸã®%deviceã«ã‚¤ãƒ³ã‚¹ãƒˆãƒ¼ãƒ«ã™ã‚‹ã«ã¯`%icon`ã‚’ã‚¿ãƒƒãƒ—ã—ã¦`<strong>ãƒ›ãƒ¼ãƒ ç”»é¢ã«è¿½åŠ </strong>`ã‚’é¸ã‚“ã§ãã ã•ã„ã€‚',
		ko_kr: '%deviceì— ì›¹ì•±ì„ ì„¤ì¹˜í•˜ë ¤ë©´ %iconì„ í„°ì¹˜ í›„ "í™ˆí™”ë©´ì— ì¶”ê°€"ë¥¼ ì„ íƒí•˜ì„¸ìš”',
		nl_nl: 'Installeer deze webapp op uw %device: tik `%icon` en dan `<strong>Zet in beginscherm</strong>`.',
		pt_br: 'Instale este web app em seu %device: aperte `%icon` e selecione `<strong>Adicionar Ã  Tela Inicio</strong>`.',
		pt_pt: 'Para instalar esta aplicaÃ§Ã£o no seu %device, prima o `%icon` e depois o `<strong>Adicionar ao ecrÃ£ principal</strong>`.',
		sv_se: 'LÃ¤gg till denna webbapplikation pÃ¥ din %device: tryck pÃ¥ `%icon` och dÃ¤refter `<strong>LÃ¤gg till pÃ¥ hemskÃ¤rmen</strong>`.',
	};

OSVersion = OSVersion ? OSVersion[0].replace(/[^\d_]/g,'').replace('_','.')*1 : 0;
expired = expired == 'null' ? 0 : expired*1;

// Merge options
if (window.addToHomeConfig) {
	for (i in window.addToHomeConfig) {
		options[i] = window.addToHomeConfig[i];
	}
}

// Is it expired?
if (!options.expire || expired < new Date().getTime()) {
	expired = 0;
}

/* Bootstrap */
if (hasHomescreen && !expired && !isStandalone && isSafari) {
	document.addEventListener('DOMContentLoaded', ready, false);
	window.addEventListener('load', loaded, false);
}


/* on DOM ready */
function ready () {
	document.removeEventListener('DOMContentLoaded', ready, false);

	var div = document.createElement('div'),
		close,
		link = options.touchIcon ? document.querySelectorAll('head link[rel=apple-touch-icon],head link[rel=apple-touch-icon-precomposed]') : [],
		sizes, touchIcon = '';

	div.id = 'addToHomeScreen';
	div.style.cssText += 'position:absolute;-webkit-transition-property:-webkit-transform,opacity;-webkit-transition-duration:0;-webkit-transform:translate3d(0,0,0);';
	div.style.left = '-9999px';		// Hide from view at startup

	// Localize message
	if (options.message in intl) {		// You may force a language despite the user's locale
		language = options.message;
		options.message = '';
	}
	if (options.message == '') {		// We look for a suitable language (defaulted to en_us)
		options.message = language in intl ? intl[language] : intl['en_us'];
	}

	// Search for the apple-touch-icon
	if (link.length) {
		for (i=0, l=link.length; i<l; i++) {
			sizes = link[i].getAttribute('sizes');

			if (sizes) {
				if (isRetina && sizes == '114x114') {
					touchIcon = link[i].href;
					break;
				}
			} else {
				touchIcon = link[i].href;
			}
		}

		touchIcon = '<span style="background-image:url(' + touchIcon + ')" class="touchIcon"></span>';
	}

	div.className = (isIPad ? 'ipad' : 'iphone') + (touchIcon ? ' wide' : '');
	div.innerHTML = touchIcon + options.message.replace('%device', platform).replace('%icon', OSVersion >= 4.2 ? '<span class="share"></span>' : '<span class="plus">+</span>') + (options.arrow ? '<span class="arrow"></span>' : '') + '<span class="close">Ã—</span>';

	document.body.appendChild(div);
	el = div;

	// Add the close action
	close = el.querySelector('.close');
	if (close) close.addEventListener('click', addToHomeClose, false);

	// Add expire date to the popup
	if (options.expire) localStorage.setItem('_addToHome', new Date().getTime() + options.expire*60*1000);
}


/* on window load */
function loaded () {
	window.removeEventListener('load', loaded, false);

	setTimeout(function () {
		var duration;

		startY = isIPad ? window.scrollY : window.innerHeight + window.scrollY;
		startX = isIPad ? window.scrollX : Math.round((window.innerWidth - el.offsetWidth)/2) + window.scrollX;

		el.style.top = isIPad ? startY + options.bottomOffset + 'px' : startY - el.offsetHeight - options.bottomOffset + 'px';
		el.style.left = isIPad ? startX + 208 - Math.round(el.offsetWidth/2) + 'px' : startX + 'px';

		switch (options.animationIn) {
			case 'drop':
				if (isIPad) {
					duration = '0.6s';
					el.style.webkitTransform = 'translate3d(0,' + -(window.scrollY + options.bottomOffset + el.offsetHeight) + 'px,0)';
				} else {
					duration = '0.9s';
					el.style.webkitTransform = 'translate3d(0,' + -(startY + options.bottomOffset) + 'px,0)';
				}
				break;
			case 'bubble':
				if (isIPad) {
					duration = '0.6s';
					el.style.opacity = '0'
					el.style.webkitTransform = 'translate3d(0,' + (startY + 50) + 'px,0)';
				} else {
					duration = '0.6s';
					el.style.webkitTransform = 'translate3d(0,' + (el.offsetHeight + options.bottomOffset + 50) + 'px,0)';
				}
				break;
			default:
				duration = '1s';
				el.style.opacity = '0';
		}

		setTimeout(function () {
			el.style.webkitTransitionDuration = duration;
			el.style.opacity = '1';
			el.style.webkitTransform = 'translate3d(0,0,0)';
			el.addEventListener('webkitTransitionEnd', transitionEnd, false);
		}, 0);

		closeTimeout = setTimeout(addToHomeClose, options.lifespan);
	}, options.startDelay);
}

function transitionEnd () {
	el.removeEventListener('webkitTransitionEnd', transitionEnd, false);
	el.style.webkitTransitionProperty = '-webkit-transform';
	el.style.webkitTransitionDuration = '0.2s';

	if (closeTimeout) {		// Standard loop
		clearInterval(theInterval);
		theInterval = setInterval(setPosition, options.iterations);
	} else {				// We are closing
		el.parentNode.removeChild(el);
	}
}

function setPosition () {
	var matrix = new WebKitCSSMatrix(window.getComputedStyle(el, null).webkitTransform),
		posY = isIPad ? window.scrollY - startY : window.scrollY + window.innerHeight - startY,
		posX = isIPad ? window.scrollX - startX : window.scrollX + Math.round((window.innerWidth - el.offsetWidth)/2) - startX;

	if (posY == matrix.m42 && posX == matrix.m41) return;

	clearInterval(theInterval);
	el.removeEventListener('webkitTransitionEnd', transitionEnd, false);
//	el.style.webkitTransitionDuration = '0';

	setTimeout(function () {
		el.addEventListener('webkitTransitionEnd', transitionEnd, false);
//		el.style.webkitTransitionDuration = '0.2s';
		el.style.webkitTransform = 'translate3d(' + posX + 'px,' + posY + 'px,0)';
	}, 0);
}

function addToHomeClose () {
	clearInterval(theInterval);
	clearTimeout(closeTimeout);
	closeTimeout = null;
	el.removeEventListener('webkitTransitionEnd', transitionEnd, false);

	var posY = isIPad ? window.scrollY - startY : window.scrollY + window.innerHeight - startY,
		posX = isIPad ? window.scrollX - startX : window.scrollX + Math.round((window.innerWidth - el.offsetWidth)/2) - startX,
		opacity = '1',
		duration = '0',
		close = el.querySelector('.close');

	if (close) close.removeEventListener('click', addToHomeClose, false);

	el.style.webkitTransitionProperty = '-webkit-transform,opacity';

	switch (options.animationOut) {
		case 'drop':
			if (isIPad) {
				duration = '0.4s';
				opacity = '0';
				posY = posY + 50;
			} else {
				duration = '0.6s';
				posY = posY + el.offsetHeight + options.bottomOffset + 50;
			}
			break;
		case 'bubble':
			if (isIPad) {
				duration = '0.8s';
				posY = posY - el.offsetHeight - options.bottomOffset - 50;
			} else {
				duration = '0.4s';
				opacity = '0';
				posY = posY - 50;
			}
			break;
		default:
			duration = '0.8s';
			opacity = '0';
	}

	el.addEventListener('webkitTransitionEnd', transitionEnd, false);
	el.style.opacity = opacity;
	el.style.webkitTransitionDuration = duration;
	el.style.webkitTransform = 'translate3d(' + posX + 'px,' + posY + 'px,0)';
}

/* Public function */
window.addToHomeClose = addToHomeClose;
})();