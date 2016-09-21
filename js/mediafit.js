/* MediaFit by Eric Winterstine v.5.25.2016
   --------------------------------------------------------------------------------
*/
var doMediaFit;
document.addEventListener('DOMContentLoaded', function () {
	var MediaFit = function() {
		var pageMedia = [];							// Array to hold all image objects
		var allMediaLoaded = false;					// Boolean to later use to stop checking for all preloaded media and break early from loops
		var resizeDelay = false;						// Delay to resize imagery (prevents too many calculations if user is playing the accordion
		var listenOnScroll = false;					// Determine if we need to listen to scroll events (for lazy load, etc.)
		var lastScreenSize = 0;
		var scrolledTop = window.pageYOffset;
		var screenHeight = window.innerHeight;
		var allDomObjects = [];
		var observer, observerConfig;
		var docBody = document.getElementsByTagName('body')[0];
		var pollingIndex = 0;
		
		/* init()
		   --------------------------------------------------------------------------------
			Parses each dom element with class "js-mediaFit" into individual objects.
		*/
		var init = function() {
			allDomObjects = document.getElementsByClassName('js-mediaFit');
			var regEx = /\bjs-mediaFitApplied\b/g;
			for ( var i = 0; i < allDomObjects.length; i++ ) {
				if ( regEx.test(allDomObjects[i].className) === false ) {
					pushMedia(allDomObjects[i]);		
				}
			}
			instantiateListeners();
		};
		
		/* pushMedia()
		   --------------------------------------------------------------------------------
			Pushes a new media object to the master pageMedia array with
			position, image source, lazy load, and other properties. 
		*/
		var pushMedia = function(mediaDomObj) {
			mediaDomObj.className += " js-mediaFitApplied";
			var mediaType = mediaDomObj.tagName.toLowerCase();
			var mediaPosition = mediaDomObj.getAttribute('data-position') || false;
			var mediaSource = mediaDomObj.getAttribute('src') || mediaDomObj.getAttribute('data-src') || false;
			var mediaParent = mediaDomObj.parentNode;
			var mediaContain = mediaDomObj.getAttribute('data-containAt') || mediaDomObj.getAttribute('data-containat') || false;
			var flexContainer = mediaDomObj.getAttribute('data-flexContainer') || mediaDomObj.getAttribute('data-containerwrap') || false;
			var mediaLazyLoad;
			
			// Parse the media position into an array or set it's default to [0.5,0.5] (centered)
			if ( mediaPosition !== false && mediaPosition.match(/\d+%?\s\d+%?/) ) {
				mediaPosition = mediaPosition.split(' ');
				mediaPosition[0] = (!isNaN(mediaPosition[0].replace('%',''))) ? parseInt(mediaPosition[0].replace('%',''))/100 : 0.5;
				mediaPosition[1] = (!isNaN(mediaPosition[1].replace('%',''))) ? parseInt(mediaPosition[1].replace('%',''))/100 : 0.5;
			} else {
				mediaPosition = [0.5,0.5];	// default, centered position
			}
			
			// Parse the media contain percentage
			if ( mediaContain !== false && mediaContain.match(/\d+%?/) ) {
				mediaContain = (!isNaN(mediaContain.replace('%',''))) ? parseInt(mediaContain.replace('%',''))/100 : false;
			} else {
				mediaContainer = false;
			}
			
			if ( flexContainer !== false && flexContainer.toLowerCase() == "true" )
				flexContainer = true;
			
			if ( mediaDomObj.getAttribute('data-lazyLoad') && mediaDomObj.getAttribute('data-lazyLoad') != "" || mediaDomObj.getAttribute('data-lazyload') && mediaDomObj.getAttribute('data-lazyload') != "" ) {
				mediaLazyLoad = true;
				mediaSource = mediaDomObj.getAttribute('data-lazyLoad') || mediaDomObj.getAttribute('data-lazyload');
				listenOnScroll = true;
			} else
				mediaLazyLoad = false;
						
			pageMedia.push({
				mediaType	:	mediaType,
				loading		:	false,
				loaded		:	false,
				flexContainer:	flexContainer,
				domObject	:	mediaDomObj,
				domOffset	:	100,//getPageOffset(mediaParent).top,
				mediaObject	:	null,
				mediaSource	:	mediaSource,
				mediaPosition: 	mediaPosition,
				mediaContain :	mediaContain,
				lazyLoad	:	mediaLazyLoad
			});
		};
				
		/* checkPageImagery()
		   --------------------------------------------------------------------------------
			Loops through each media object on the page to determine if it should be loaded.
			If the media should be loaded, it creates an object and listens for an 'onload'
			event. Once this event is fired, we will have the media's dimensions to properly
			resize it to fit it's container properly.
		*/
		var checkPageImagery = function() {
			scrolledTop = window.pageYOffset;
			if ( !allMediaLoaded && pageMedia.length > 0 ) {
				var foundOne = false;
				for ( var i = 0; i < pageMedia.length; i++ ) {
					if ( pageMedia[i] && !pageMedia[i].loaded && !pageMedia[i].loading ) {
						foundOne = true;

						// Check if the media dom object doesn't exist anymore
						if ( !document.body.contains(pageMedia[i].domObject) ) {
							pageMedia[i] = null;
						} else if ( getStyle(pageMedia[i].domObject,'display') !== 'none' && getStyle(pageMedia[i].domObject.parentNode,'display') !== 'none' && (pageMedia[i].lazyLoad !== false && scrolledTop + screenHeight > pageMedia[i].domOffset || pageMedia[i].lazyLoad === false) ) {
							
							// Handle Images
							if ( pageMedia[i].mediaType === 'img' ) {
								var mediaObject = new Image();
								mediaObject.mediaType = pageMedia[i].mediaType;
								mediaObject.domObject = pageMedia[i].domObject;
								mediaObject.position = pageMedia[i].mediaPosition;
								mediaObject.contain = pageMedia[i].mediaContain;
								mediaObject.flexContainer = pageMedia[i].flexContainer;
								mediaObject.indx = i;
								mediaObject.onerror = function() {
									console.warn("mediaFit: Cannot load " + this.src + ".\nCheck the filepath and that it is absolute.");
									pageMedia[this.indx] = null;
								};
								mediaObject.onabort = function() {
									console.warn("mediaFit: Image load aborted for " + this.src + ".");
									pageMedia[this.indx] = null;
								};
								mediaObject.onload = function() {
									// If the DOM object still exists
									if ( document.body.contains(this.domObject) ) {
										pageMedia[this.indx].loaded = true;
										pageMedia[this.indx].loading = false;
										this.domObject.setAttribute('src',this.src);
										fitMedia(this);
										this.domObject.className = this.domObject.className.replace(/\bloading\b/,'');
										this.domObject.className += " loaded";
										this.domObject.parentNode.className = this.domObject.parentNode.className.replace(/\bloading\b/,'');
										this.domObject.parentNode.className = this.domObject.parentNode.className.replace(/\bloaded\b/,'');
										this.domObject.parentNode.className += " loaded";
									} else {
										pageMedia[this.indx] = null;
									}
								};
								mediaObject.src = pageMedia[i].mediaSource;
								pageMedia[i].mediaObject = mediaObject;
								pageMedia[i].domObject.className += " loading";
								pageMedia[i].domObject.parentNode.className = pageMedia[i].domObject.parentNode.className.replace(/\bloading\b/,'');
								pageMedia[i].domObject.parentNode.className = pageMedia[i].domObject.parentNode.className.replace(/\bloaded\b/,'');
								pageMedia[i].domObject.parentNode.className += " loading";
							}
							
							// Handle Videos
							if ( pageMedia[i].mediaType === 'video' ) {
								var mediaObject;
								if ( pageMedia[i].domObject.getAttribute('id') )
									mediaObject = document.getElementById( pageMedia[i].domObject.getAttribute('id') );
								else {
									pageMedia[i].domObject.setAttribute('id', ('js-mediaFitVideo' + i));
									mediaObject = document.getElementById( pageMedia[i].domObject.getAttribute('id') );
								}
								mediaObject.src = pageMedia[i].mediaSource;
								mediaObject.mediaType = pageMedia[i].mediaType;
								mediaObject.domObject = pageMedia[i].domObject;
								mediaObject.position = pageMedia[i].mediaPosition;
								mediaObject.contain = pageMedia[i].mediaContain;
								mediaObject.flexContainer = pageMedia[i].flexContainer;
								mediaObject.indx = i;
								mediaObject.load();
								mediaObject.addEventListener('error', function() {
									console.warn("mediaFit: Cannot load " + this.src + ".\nCheck the filepath and that it is absolute.");
									pageMedia[this.indx] = null;
								});
								mediaObject.addEventListener('abort', function() {
									console.warn("mediaFit: Video load aborted for " + this.src + ".");
									pageMedia[this.indx] = null;
								});
								mediaObject.addEventListener('loadeddata', function() {
									if ( document.body.contains(pageMedia[this.indx].domObject) ) {
										pageMedia[this.indx].loaded = true;
										pageMedia[this.indx].loading = false;
										var source = document.createElement('source');
										source.src = this.src;
										source.type = 'video/mp4';
										this.domObject.appendChild(source);
										fitMedia(this);
										this.domObject.className = this.domObject.className.replace(/\bloading\b/,'');
										this.domObject.className += " loaded";
										this.domObject.parentNode.className = this.domObject.parentNode.className.replace(/\bloading\b/,'');
										this.domObject.parentNode.className = this.domObject.parentNode.className.replace(/\bloaded\b/,'');
										this.domObject.parentNode.className += " loaded";
									} else 
										pageMedia[this.indx] = null;
										
								});
								pageMedia[i].mediaObject = mediaObject;
								pageMedia[i].domObject.className += " loading";
								pageMedia[i].domObject.parentNode.className = pageMedia[i].domObject.parentNode.className.replace(/\bloading\b/,'');
								pageMedia[i].domObject.parentNode.className = pageMedia[i].domObject.parentNode.className.replace(/\bloaded\b/,'');
								pageMedia[i].domObject.parentNode.className += " loading";
							}
							
							// Handle Iframes
							if ( pageMedia[i].mediaType == 'iframe' ) {
								var mediaObject = {};
								mediaObject.src = pageMedia[i].mediaSource;
								mediaObject.mediaType = pageMedia[i].mediaType;
								mediaObject.domObject = pageMedia[i].domObject;
								mediaObject.position = pageMedia[i].mediaPosition;
								mediaObject.contain = pageMedia[i].mediaContain;
								mediaObject.flexContainer = pageMedia[i].flexContainer;
								pageMedia[i].loaded = true;
								fitMedia(mediaObject);
								pageMedia[i].domObject.className = pageMedia[i].domObject.className.replace(/\bloading\b/,'');
								pageMedia[i].domObject.className += " loaded";
								pageMedia[i].domObject.parentNode.className = pageMedia[i].domObject.parentNode.className.replace(/\bloading\b/,'');
								pageMedia[i].domObject.parentNode.className += " loaded";
								pageMedia[i].mediaObject = mediaObject;
							}
							
							pageMedia[i].loading = true;
						}
					}
				}
				if ( !foundOne )
					allMediaLoaded = true;
			}
		}
		
		/* fitMedia(img)
		   --------------------------------------------------------------------------------
			Resizes and positions an image OBJECT into it's container.
		*/
		var fitMedia = function(mediaObject) {
			// Removing styling for the media if it's parent is set to static
			var mediaParent = mediaObject.domObject.parentNode;
			
			if ( getStyle(mediaParent,'position') === 'static' ) {
				mediaObject.domObject.setAttribute('style','');
				return false;
			}
			
			mediaObject.domObject.setAttribute('style','');
			if ( getStyle(mediaObject.domObject,'display') === 'none' ) {
				mediaObject.domObject.style.display = 'none';
				return false;
			}
			else {
				mediaObject.domObject.style.display = "block";
				mediaObject.domObject.style.position = "absolute";
			}
			
			var mediaWidth = mediaObject.width || mediaObject.videoWidth || mediaParent.offsetWidth;
			var mediaHeight = mediaObject.height || mediaObject.videoHeight || mediaParent.offsetHeight;
			var mediaRatio = mediaWidth / mediaHeight;
			var containerWidth = mediaParent.offsetWidth;
			var containerHeight = mediaParent.offsetHeight;
			var containerRatio = containerWidth / containerHeight;
			var newMediaWidth,newMediaHeight,newXPosition,newYPosition;
			
			// Special ratio for contained youtube iframes
			if ( mediaObject.mediaType === 'iframe' && mediaObject.contain !== false || mediaObject.mediaType === 'iframe' && mediaObject.flexContainer ) {
				mediaRatio = 1.77777778;
				mediaHeight = mediaWidth / mediaRatio;
			}
			
			// If the container is set to flex, let's flex it
			if ( mediaObject.flexContainer ) {
				mediaParent.setAttribute('style','');
				// Determine if we need to flex the container by width or by height
				if ( parseFloat( getStyle(mediaParent,'height') ) !== 0 ) {
					containerWidth = containerHeight * mediaRatio;
					containerRatio = containerWidth / containerHeight;
					mediaParent.style.width = containerWidth + "px";
				} else {
					containerHeight = containerWidth / mediaRatio;
					containerRatio = containerWidth / containerHeight;
					mediaParent.style.height = containerHeight + "px";
				}
			}

			if ( mediaRatio > containerRatio ) {
				var imageDifference = 1 - containerRatio / mediaRatio;
				if ( mediaObject.contain !== false && imageDifference >= mediaObject.contain ) {
					// Contain the media
					newMediaWidth = containerWidth;
					newMediaHeight = containerWidth / mediaRatio;
					newXPosition = 0;
					newYPosition = (containerHeight - newMediaHeight) * mediaObject.position[1];
				} else {
					newMediaWidth = containerHeight * mediaRatio;
					newMediaHeight = containerHeight;
					newXPosition = (containerWidth - newMediaWidth) * mediaObject.position[0];
					newYPosition = 0;
				}
			} else {
				var imageDifference = 1 - mediaRatio / containerRatio;
				if ( mediaObject.contain !== false && imageDifference >= mediaObject.contain ) {
					// Contain the media
					newMediaWidth = containerHeight * mediaRatio;
					newMediaHeight = containerHeight;
					newXPosition = (containerWidth - newMediaWidth) * mediaObject.position[0];
					newYPosition = 0;
				} else {
					newMediaWidth = containerWidth;
					newMediaHeight = containerWidth / mediaRatio;
					newXPosition = 0;
					newYPosition = (containerHeight - newMediaHeight) * mediaObject.position[1];
				}
			}
				
			mediaObject.domObject.style.width = Math.ceil(newMediaWidth+1) + "px";
			mediaObject.domObject.style.height = Math.ceil(newMediaHeight+1) + "px";
			mediaObject.domObject.style.left = Math.floor(newXPosition) + "px";
			mediaObject.domObject.style.top = Math.floor(newYPosition) + "px";	
		};
		
		/* instantiateListeners()
		   --------------------------------------------------------------------------------
			Creates page listeners to handle events such as resize and page scroll for
			lazy-loaded media.
		*/
		var instantiateListeners = function() {
			// Listener for dom injection
			var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver || false;
			if ( MutationObserver ) {
				observer = new MutationObserver(function(mutations) {
					mutations.forEach(function(mutation) {
						// See if the new node is a js-mediaFit
						var mediaFitAdded = false;
						for ( var i = 0; i < mutation.addedNodes.length; i++ ) {
							var regEx = /\bjs-mediaFit\b/g;
							if ( typeof mutation.addedNodes[i].className !== 'undefined' && regEx.test(mutation.addedNodes[i].className) ) {
								mediaFitAdded = true;
								pushMedia(mutation.addedNodes[i]);
								allMediaLoaded = false;
							}
						}
						if ( mediaFitAdded ) {
							checkPageImagery();
						}
						
					});
				});
				
				// pass in the target node, as well as the observer options
				observer.observe(docBody, { childList: true, attributes: true, characterData: true, subtree: true, attributeOldValue: true, characterDataOldValue: true });
			} else {
				// Try Polling
				setInterval(function() {
					var mediaDomObjects = document.getElementsByClassName('js-mediaFit');
					var mdolength = mediaDomObjects.length;
					if ( mdolength ) {
						var endTime = Number(new Date()) + 30;
						var regEx = /\bjs-mediaFitApplied\b/g;
						pollingIndex = ( pollingIndex >= mdolength ) ? 0 : pollingIndex;
						var endPollingIndex = (pollingIndex - 1 < 0 ) ? mdolength - 1 : pollingIndex - 1;
						while( Number(new Date()) < endTime ) {
							pollingIndex = ( pollingIndex >= mdolength ) ? 0 : pollingIndex;
							if ( regEx.test(mediaDomObjects[pollingIndex].className) === false ) {
								pushMedia(mediaDomObjects[pollingIndex]);
								allMediaLoaded = false;
								checkPageImagery();
							}
							if ( pollingIndex === endPollingIndex ) break;	// we made a complete loop, break early
							pollingIndex++;
						}
					}
				},250);
			}	
			if ( listenOnScroll ) {
				window.onscroll = function() {
					if (window.requestAnimationFrame) window.requestAnimationFrame(function() { checkPageImagery() });
					else if (window.msRequestAnimationFrame) window.msRequestAnimationFrame(function() { checkPageImagery() });
					else if (window.webkitRequestAnimationFrame) window.webkitRequestAnimationFrame(function() { checkPageImagery() });
					else if (window.mozRequestAnimationFrame) window.mozRequestAnimationFrame(function() { checkPageImagery() });
					else if (window.oRequestAnimationFrame) window.oRequestAnimationFrame(function() { checkPageImagery() });
				};
			}
			window.onresize = function(){
				if ( !resizeDelay ) {
					scrolledTop = window.pageYOffset;
					screenHeight = window.innerHeight;
					resizeDelay = setTimeout(function() {
						if ( window.innerWidth !== lastScreenSize ) {
							for ( var i = 0; i < pageMedia.length; i++ ) {
								// Dom lost? Set to null and skip
								if ( pageMedia[i] && !document.body.contains(pageMedia[i].domObject) ) {
									pageMedia[i] = null;
								} else if ( pageMedia[i] && pageMedia[i].loaded ) {
									if ( listenOnScroll ) {
										pageMedia[i].domOffset = getPageOffset(pageMedia[i].domObject.parentNode).top;
									}
									fitMedia(pageMedia[i].mediaObject);
								}
							}
							checkPageImagery();
						}
						resizeDelay = false;
					},100);
				}
			};
		}
		
		/* getPageOffset()
		   --------------------------------------------------------------------------------
			Returns an element's offset position.
		*/
		var getPageOffset = function(domObj) {
			var box = { top: 0, left: 0 };
			// BlackBerry 5, iOS 3 (original iPhone)
			if ( typeof domObj.getBoundingClientRect !== "undefined" ) {
			  box = domObj.getBoundingClientRect();
			}
			return {
			  top: box.top  + ( window.pageYOffset || domObj.scrollTop )  - ( domObj.clientTop  || 0 ),
			  left: box.left + ( window.pageXOffset || domObj.scrollLeft ) - ( domObj.clientLeft || 0 )
			};	
		};
		
		/* getStyle()
		   --------------------------------------------------------------------------------
			Returns an element's css style property.
		*/
		var getStyle = function(el, styleProp) {
			var value, defaultView = (el.ownerDocument || document).defaultView;
			// W3C standard way:
			if (defaultView && defaultView.getComputedStyle) {
				// sanitize property name to css notation
				// (hypen separated words eg. font-Size)
				styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
				return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
			} else if (el.currentStyle) { // IE
				// sanitize property name to camelCase
				styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
					return letter.toUpperCase();
				});
				value = el.currentStyle[styleProp];
				// convert other units to pixels on IE
				if (/^\d+(em|pt|%|ex)?$/i.test(value)) { 
					return (function(value) {
						var oldLeft = el.style.left, oldRsLeft = el.runtimeStyle.left;
						el.runtimeStyle.left = el.currentStyle.left;
						el.style.left = value || 0;
						value = el.style.pixelLeft + "px";
						el.style.left = oldLeft;
						el.runtimeStyle.left = oldRsLeft;
						return value;
					})(value);
				}
				return value;
			}
		};
		
		return {
			init: init,
			checkPageImagery: checkPageImagery
		};
	};
	 
	var mediafit = MediaFit();
	mediafit.init();
	mediafit.checkPageImagery();
	
	doMediaFit = function() {
		mediafit.init();
		mediafit.checkPageImagery();
	};
});