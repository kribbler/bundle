/**
 * jQuery iLightBox - Revolutionary Lightbox Plugin
 * 
 * @version: 1.4.1 - March 01, 2013
 * 
 * @author: Hemn Chawroka
 *          hemn@iprodev.com
 *          http://iprodev.com/
 * 
 */
(function ($, window, undefined) {

	var iLightBox = function (el, options, items, instant) {
		var iL = this;
		
		iL.options = options,
		iL.selector = el.selector || el,
		iL.context = el.context,
		iL.instant = instant;
		
		if(items.length < 1) iL.attachItems();
		else iL.items = items;
		
		iL.vars = {
			total: iL.items.length,
			start: 0,
			current: null,
			next: null,
			prev: null,
			WIN: $(window),
			DOC: $(document),
			BODY: $('body'),
			loadRequests: 0,
			overlay: $('<div class="ilightbox-overlay"></div>'),
			loader: $('<div class="ilightbox-loader"><div></div></div>'),
			toolbar: $('<div class="ilightbox-toolbar"></div>'),
			innerToolbar: $('<div class="ilightbox-inner-toolbar"></div>'),
			title: $('<div class="ilightbox-title"></div>'),
			closeButton: $('<a class="ilightbox-close" title="'+iL.options.text.close+'"></a>'),
			fullScreenButton: $('<a class="ilightbox-fullscreen" title="'+iL.options.text.enterFullscreen+'"></a>'),
			holder: $('<div class="ilightbox-holder" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
			nextPhoto: $('<div class="ilightbox-holder ilightbox-next" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
			prevPhoto: $('<div class="ilightbox-holder ilightbox-prev" ondragstart="return false;"><div class="ilightbox-container"></div></div>'),
			thumbnails: $('<div class="ilightbox-thumbnails" ondragstart="return false;"><div class="ilightbox-thumbnails-container"><a class="ilightbox-thumbnails-dragger"></a><div class="ilightbox-thumbnails-grid"></div></div></div>'),
			thumbs: false,
			nextLock: false,
			prevLock: false,
			isInFullScreen: false,
			isSwipe: false,
			supportTouch: !! ('ontouchstart' in window)
		};
		
		iL.normalizeItems();
		
		//Check necessary plugins
		iL.availPlugins();

		//Set startFrom
		iL.options.startFrom = (iL.options.startFrom > 0 && iL.options.startFrom >= iL.vars.total) ? iL.vars.total - 1 : iL.options.startFrom;

		//If randomStart
		iL.options.startFrom = (iL.options.randomStart) ? Math.floor(Math.random() * iL.vars.total) : iL.options.startFrom;
		iL.vars.start = iL.options.startFrom;
		
		if(instant) iL.instantCall();
		else iL.patchItemsEvents();
	};

	//iLightBox helpers
	iLightBox.prototype = {
		showLoader: function(){
			var iL = this;
			iL.vars.loadRequests += 1;
			if(iL.options.path.toLowerCase() == "horizontal") iL.vars.loader.stop().animate({ top: '-30px' }, iL.options.show.speed, 'easeOutCirc');
			else iL.vars.loader.stop().animate({ left: '-30px' }, iL.options.show.speed, 'easeOutCirc');
		},
		
		hideLoader: function(){
			var iL = this;
			iL.vars.loadRequests -= 1;
			iL.vars.loadRequests = (iL.vars.loadRequests < 0) ? 0 : iL.vars.loadRequests;
			if(iL.options.path.toLowerCase() == "horizontal") {
				if(iL.vars.loadRequests <= 0) iL.vars.loader.stop().animate({ top: '-192px' }, iL.options.show.speed, 'easeInCirc');
			} else {
				if(iL.vars.loadRequests <= 0) iL.vars.loader.stop().animate({ left: '-192px' }, iL.options.show.speed, 'easeInCirc');
			}
		},
		
		createUI: function(){
			var iL = this;
			
			iL.ui = {
				currentElement: iL.vars.holder,
				nextElement: iL.vars.nextPhoto,
				prevElement: iL.vars.prevPhoto,
				currentItem: iL.vars.current,
				nextItem: iL.vars.next,
				prevItem: iL.vars.prev,
				hide: function(){
					iL.closeAction();
				},
				refresh: function(){
					(arguments.length > 0) ? iL.repositionPhoto(true) : iL.repositionPhoto();
				},
				fullscreen: function(){
					iL.fullScreenAction();
				}
			};
		},
		
		attachItems: function(){
			var iL = this,
			itemsObject = new Array(),
			items = new Array();
			
			$(iL.selector, iL.context).each(function(){
				var t = $(this),
				URL = t.attr(iL.options.attr) || null,
				options = t.data("options") && eval("({" + t.data("options") + "})") || {},
				caption = t.data('caption'),
				title = t.data('title'),
				type = t.data('type') || iL.getTypeByExtension(URL);
				
				items.push({
					URL: URL,
					caption: caption,
					title: title,
					type: type,
					options: options
				});
				
				if(!iL.instant) itemsObject.push(t);
			});
			
			iL.items = items,
			iL.itemsObject = itemsObject;
		},
		
		normalizeItems: function(){
			var iL = this,
			newItems = new Array();
			
			$.each(iL.items, function(key, val){
			
				if(typeof val == "string") val = { url:val };
				
				var URL = val.url || val.URL || null,
				options = val.options || {},
				caption = val.caption || null,
				title = val.title || null,
				type = (val.type) ? val.type.toLowerCase() : iL.getTypeByExtension(URL),
				ext = (typeof URL != 'object') ? iL.pathInfo(URL, 'PATHINFO_EXTENSION') : '';
				
				options.thumbnail = options.thumbnail || ((type=="image") ? URL : null),
				options.skin = options.skin || iL.options.skin,
				options.width = options.width || null,
				options.height = options.height || null,
				options.mousewheel = (typeof options.mousewheel != 'undefined') ? options.mousewheel : true,
				options.swipe = (typeof options.swipe != 'undefined') ? options.swipe : true;
				if(type == "video") {
					options.html5video = (typeof options.html5video != 'undefined') ? options.html5video : {};
					
					options.html5video.webm = options.html5video.webm || options.html5video.WEBM || null;
					options.html5video.controls = (typeof options.html5video.controls != 'undefined') ? options.html5video.controls : "controls";
					options.html5video.preload = options.html5video.preload || "metadata";
					options.html5video.autoplay = (typeof options.html5video.autoplay != 'undefined') ? options.html5video.autoplay : false;
				}
				
				if(!options.width || !options.height){
					if(type == "video") options.width = 1280, options.height = 720;
					else if(type == "iframe") options.width = '100%', options.height = '90%';
					else if(type == "flash") options.width = 1280, options.height = 720;
				}
				
				delete val.url;
				val.URL = URL;
				val.caption = caption;
				val.title = title;
				val.type = type;
				val.options = options;
				val.ext = ext;
				
				newItems.push(val);
			});
			
			iL.items = newItems;
		},
		
		instantCall: function(){
			var iL = this,
			key = iL.vars.start;
			
			iL.vars.current = key;
			if(iL.items[key + 1]) iL.vars.next = key + 1;
			else iL.vars.next = null;
			if(iL.items[key - 1]) iL.vars.prev = key - 1;
			else iL.vars.prev = null;
			
			iL.addContents();
			iL.patchEvents();
		},
		
		addContents: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase();
			
			vars.overlay.addClass(opts.skin).hide().css({ opacity: opts.overlay.opacity });
			
			//Add Toolbar Buttons
			if(opts.controls.toolbar){
				vars.toolbar.addClass(opts.skin).append(vars.closeButton);
				if(opts.controls.fullscreen) vars.toolbar.append(vars.fullScreenButton);
			}
			
			//Append elements to body
			vars.BODY.addClass('ilightbox-noscroll').append(vars.overlay).append(vars.loader).append(vars.holder).append(vars.nextPhoto).append(vars.prevPhoto);
			
			if(!opts.innerToolbar) vars.BODY.append(vars.toolbar);
			
			if(opts.controls.thumbnail && vars.total > 1) {
				vars.BODY.append(vars.thumbnails);
				vars.thumbnails.addClass(opts.skin).addClass('ilightbox-'+path);
				$('div.ilightbox-thumbnails-grid', vars.thumbnails).empty();
				vars.thumbs = true;
			}
			
			//Configure loader
			var loaderCss = (opts.path.toLowerCase() == "horizontal") ? { left:parseInt((vars.WIN.width() / 2) - (vars.loader.outerWidth() / 2)) } : { top:parseInt((vars.WIN.height() / 2) - (vars.loader.outerHeight() / 2)) };
			vars.loader.addClass(opts.skin).css(loaderCss);
			if(path == "horizontal") vars.loader.addClass('horizontal');
			
			if(opts.show.effect) setTimeout(function(){ 
				iL.generateBoxes();
			}, opts.show.speed);
			else iL.generateBoxes();

			if(opts.show.effect) {
				vars.overlay.stop().fadeIn(opts.show.speed);
				vars.toolbar.stop().fadeIn(opts.show.speed);
			}
			else {
				vars.overlay.show();
				vars.toolbar.show();
			}
			
			var length = vars.total;
			if(opts.smartRecognition && vars.total > 1) $.each(iL.items, function(key, val){
				var obj = iL.items[key];
				iL.ogpRecognition(obj, function(result){
					if(result) {
						$.extend(true, obj,
						{
							type: result.type,
							options: {
								width: result.width || obj.width,
								height: result.height || obj.height,
								thumbnail: obj.options.thumbnail || result.thumbnail
							}
						});
					}
					length--;
					if(length == 0) {
						vars.dontGenerateThumbs = false;
						iL.generateThumbnails();
					}
				});
			});
			
			iL.createUI();
					
			//Trigger the onOpen callback
			if(typeof iL.options.callback.onOpen == 'function') iL.options.callback.onOpen.call(iL);
		},
		
		loadContent: function(obj, opt, speed){
			var iL = this,
			holder, item;
			
			iL.createUI();
			
			obj.speed = speed || iL.options.effects.loadedFadeSpeed;
			
			if(opt == 'current'){
				if(!obj.options.mousewheel) iL.vars.lockWheel = true;
				else iL.vars.lockWheel = false;
				
				if(!obj.options.swipe) iL.vars.lockSwipe = true;
				else iL.vars.lockSwipe = false;
			}
			
			switch(opt) {
				case 'current': holder = iL.vars.holder, item = iL.vars.current; break;
				case 'next': holder = iL.vars.nextPhoto, item = iL.vars.next; break;
				case 'prev': holder = iL.vars.prevPhoto, item = iL.vars.prev; break;
			}
			
			holder.removeAttr('style class').addClass('ilightbox-holder').addClass(obj.options.skin);
			$('div.ilightbox-inner-toolbar', holder).remove();
			
			if(obj.title || iL.options.innerToolbar){
				var innerToolbar = iL.vars.innerToolbar.clone();
				if(obj.title && iL.options.show.title) {
					var title = iL.vars.title.clone();
					title.empty().html(obj.title);
					innerToolbar.append(title);
				}
				if(iL.options.innerToolbar){
					innerToolbar.append((iL.vars.total > 1) ? iL.vars.toolbar.clone() : iL.vars.toolbar);
				}
				holder.prepend(innerToolbar);
			}
			
			if(iL.options.smartRecognition || obj.options.smartRecognition) iL.ogpRecognition(obj, function(result){
				var newObj = obj,
				oldObj = $.extend({}, obj, {});
				if(result) {
					obj = $.extend(true, obj,
					{
						type: result.type,
						options: {
							width: result.width || obj.width,
							height: result.height || obj.height,
							thumbnail: obj.options.thumbnail || result.thumbnail
						}
					});
					newObj = $.extend({}, obj,
					{
						URL: result.source
					});
					
					if(obj.options.smartRecognition && !oldObj.options.thumbnail) {
						iL.vars.dontGenerateThumbs = false;
						iL.generateThumbnails();
					}
				}
				iL.loadSwitcher(newObj, holder, item, opt);
			});
			else iL.loadSwitcher(obj, holder, item, opt);
		},
		
		loadSwitcher: function(obj, holder, item, opt){
			var iL = this,
			opts = iL.options,
			api = {
				element: holder,
				position: item
			};
			
			switch(obj.type) {
				case 'image':
					//Trigger the onBeforeLoad callback
					if(typeof opts.callback.onBeforeLoad == 'function') opts.callback.onBeforeLoad.call(iL, iL.ui, item);
					if(typeof obj.options.onBeforeLoad == 'function') obj.options.onBeforeLoad.call(iL, api);
					
					iL.loadImage(obj.URL, function(img){
						//Trigger the onAfterLoad callback
						if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
						if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
						
						var width = (img) ? img.width : 400,
						height = (img) ? img.height : 200;
						
						holder.data({ naturalWidth:width, naturalHeight:height });
						$('div.ilightbox-container', holder).empty().append((img) ? '<img src="'+obj.URL+'" class="ilightbox-image" />' : '<span class="ilightbox-alert">'+opts.errors.loadImage+'</span>');

						//Trigger the onRender callback
						if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
						if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);
						
						iL.configureHolder(obj, opt, holder);
					});
					
					break;
				
				case 'video':
					holder.data({ naturalWidth:obj.options.width, naturalHeight:obj.options.height });
					
					iL.addContent(holder, obj);

					//Trigger the onRender callback
					if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
					if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);
					
					iL.configureHolder(obj, opt, holder);
						
					break;
				
				case 'iframe':
					iL.showLoader();
					holder.data({ naturalWidth:obj.options.width, naturalHeight:obj.options.height });
					var el = iL.addContent(holder, obj);

					//Trigger the onRender callback
					if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
					if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);

					//Trigger the onBeforeLoad callback
					if(typeof opts.callback.onBeforeLoad == 'function') opts.callback.onBeforeLoad.call(iL, iL.ui, item);
					if(typeof obj.options.onBeforeLoad == 'function') obj.options.onBeforeLoad.call(iL, api);
					
					el.bind('load', function(){
						//Trigger the onAfterLoad callback
						if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
						if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
					
						iL.hideLoader();
						iL.configureHolder(obj, opt, holder);
						el.unbind('load');
					});
					
					break;
				
				case 'inline':
					var el = $(obj.URL),
					content = iL.addContent(holder, obj),
					images = iL.findImageInElement(holder);
					
					holder.data({ naturalWidth:(iL.items[item].options.width || el.outerWidth()), naturalHeight:(iL.items[item].options.height || el.outerHeight()) });

					//Trigger the onRender callback
					if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
					if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);

					//Trigger the onBeforeLoad callback
					if(typeof opts.callback.onBeforeLoad == 'function') opts.callback.onBeforeLoad.call(iL, iL.ui, item);
					if(typeof obj.options.onBeforeLoad == 'function') obj.options.onBeforeLoad.call(iL, api);
					
					iL.loadImage(images, function(){
						//Trigger the onAfterLoad callback
						if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
						if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
					
						iL.configureHolder(obj, opt, holder);
					});
						
					break;
				
				case 'flash':
					var el = iL.addContent(holder, obj);
					
					holder.data({ naturalWidth:(iL.items[item].options.width || el.outerWidth()), naturalHeight:(iL.items[item].options.height || el.outerHeight()) });

					//Trigger the onRender callback
					if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
					if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);
					
					iL.configureHolder(obj, opt, holder);
						
					break;
				
				case 'ajax':
					var ajax = obj.options.ajax || {};
					//Trigger the onBeforeLoad callback
					if(typeof opts.callback.onBeforeLoad == 'function') opts.callback.onBeforeLoad.call(iL, iL.ui, item);
					if(typeof obj.options.onBeforeLoad == 'function') obj.options.onBeforeLoad.call(iL, api);
					
					iL.showLoader();
					$.ajax({
						url:obj.URL || opts.ajaxSetup.url,
						data: ajax.data || null,
						dataType:ajax.dataType || "html",
						type:ajax.type || opts.ajaxSetup.type,
						cache:ajax.cache || opts.ajaxSetup.cache,
						crossDomain:ajax.crossDomain || opts.ajaxSetup.crossDomain,
						global:ajax.global || opts.ajaxSetup.global,
						ifModified:ajax.ifModified || opts.ajaxSetup.ifModified,
						username:ajax.username || opts.ajaxSetup.username,
						password:ajax.password || opts.ajaxSetup.password,
						beforeSend:ajax.beforeSend || opts.ajaxSetup.beforeSend,
						complete:ajax.complete || opts.ajaxSetup.complete,
						success:function(data, textStatus, jqXHR){
							iL.hideLoader();
							
							var el = $(data),
							container = $('div.ilightbox-container', holder),
							elWidth = iL.items[item].options.width || parseInt(el.attr('width')),
							elHeight = iL.items[item].options.height || parseInt(el.attr('height')),
							css = (el.attr('width') && el.attr('height')) ? { 'overflow':'hidden' } : {};
							
							container.empty().append($('<div class="ilightbox-wrapper"></div>').css(css).html(el));
							holder.show().data({ naturalWidth:(elWidth || container.outerWidth()), naturalHeight:(elHeight || container.outerHeight()) }).hide();

							//Trigger the onRender callback
							if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
							if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);
				
							var images = iL.findImageInElement(holder);
							iL.loadImage(images, function(){
								//Trigger the onAfterLoad callback
								if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
								if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
								
								iL.configureHolder(obj, opt, holder);
							});
							
							opts.ajaxSetup.success(data, textStatus, jqXHR);
							if(typeof ajax.success == 'function') ajax.success(data, textStatus, jqXHR);
						},
						error:function(jqXHR, textStatus, errorThrown){
							//Trigger the onAfterLoad callback
							if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
							if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
							
							iL.hideLoader();
							$('div.ilightbox-container', holder).empty().append('<span class="ilightbox-alert">'+opts.errors.loadContents+'</span>');
							iL.configureHolder(obj, opt, holder);
							
							opts.ajaxSetup.error(jqXHR, textStatus, errorThrown);
							if(typeof ajax.error == 'function') ajax.error(jqXHR, textStatus, errorThrown);
						}
					});
						
					break;
				
				case 'html':
					var object = obj.URL, el
					container = $('div.ilightbox-container', holder);
					
					if(object[0].nodeName) el = object.clone();
					else {
						var dom = $(object);
						if(dom.selector) el = $('<div>'+dom+'</div>');
						else el = dom;
					}
					
					var elWidth = iL.items[item].options.width || parseInt(el.attr('width')),
					elHeight = iL.items[item].options.height || parseInt(el.attr('height'));
					
					iL.addContent(holder, obj);
					
					el.appendTo(document.documentElement).hide();

					//Trigger the onRender callback
					if(typeof opts.callback.onRender == 'function') opts.callback.onRender.call(iL, iL.ui, item);
					if(typeof obj.options.onRender == 'function') obj.options.onRender.call(iL, api);
					
					var images = iL.findImageInElement(holder);
					
					//Trigger the onBeforeLoad callback
					if(typeof opts.callback.onBeforeLoad == 'function') opts.callback.onBeforeLoad.call(iL, iL.ui, item);
					if(typeof obj.options.onBeforeLoad == 'function') obj.options.onBeforeLoad.call(iL, api);
					
					iL.loadImage(images, function(){
						//Trigger the onAfterLoad callback
						if(typeof opts.callback.onAfterLoad == 'function') opts.callback.onAfterLoad.call(iL, iL.ui, item);
						if(typeof obj.options.onAfterLoad == 'function') obj.options.onAfterLoad.call(iL, api);
						
						holder.show().data({ naturalWidth:(elWidth || container.outerWidth()), naturalHeight:(elHeight || container.outerHeight()) }).hide();
						el.remove();
					
						iL.configureHolder(obj, opt, holder);
					});
						
					break;
			}
		},
		
		configureHolder: function(obj, opt, holder){
			var iL = this,
			vars = iL.vars,
			opts = iL.options;
			
			if(opt != "current") (opt == "next") ? holder.addClass('ilightbox-next') : holder.addClass('ilightbox-prev');
			
			if(opt == "current")
				var item = vars.current;
			else if(opt == "next")
				var opacity = opts.styles.nextOpacity,
				item = vars.next;
			else
				var opacity = opts.styles.prevOpacity,
				item = vars.prev;
				
			var api = {
				element: holder,
				position: item
			};
			
			iL.items[item].options.width = iL.items[item].options.width || 0,
			iL.items[item].options.height = iL.items[item].options.height || 0;
			
			if(opt == "current"){
				if(opts.show.effect) holder.fadeIn(obj.speed, function(){
					if(obj.caption && opts.show.caption){
						iL.setCaption(obj, holder);
						$('div.ilightbox-caption', holder).fadeIn(opts.effects.fadeSpeed);
					}
				
					//Generate thumbnails
					iL.generateThumbnails();
					
					//Trigger the onShow callback
					if(typeof opts.callback.onShow == 'function') opts.callback.onShow.call(iL, iL.ui, item);
					if(typeof obj.options.onShow == 'function') obj.options.onShow.call(iL, api);
				});
				else {
					holder.show();
				
					//Generate thumbnails
					iL.generateThumbnails();
					
					//Trigger the onShow callback
					if(typeof opts.callback.onShow == 'function') opts.callback.onShow.call(iL, iL.ui, item);
					if(typeof obj.options.onShow == 'function') obj.options.onShow.call(iL, api);
				}
			} else {
				if(opts.show.effect) holder.fadeTo(obj.speed, opacity, function(){
					if(opt == "next") vars.nextLock = false;
					else vars.prevLock = false;
				
					//Generate thumbnails
					iL.generateThumbnails();
					
					//Trigger the onShow callback
					if(typeof opts.callback.onShow == 'function') opts.callback.onShow.call(iL, iL.ui, item);
					if(typeof obj.options.onShow == 'function') obj.options.onShow.call(iL, api);
				});
				else {
					holder.css({ opacity:opacity }).show();
					if(opt == "next") vars.nextLock = false;
					else vars.prevLock = false;
				
					//Generate thumbnails
					iL.generateThumbnails();
					
					//Trigger the onShow callback
					if(typeof opts.callback.onShow == 'function') opts.callback.onShow.call(iL, iL.ui, item);
					if(typeof obj.options.onShow == 'function') obj.options.onShow.call(iL, api);
				}
			}
			
			setTimeout(function(){ iL.repositionPhoto(); }, 0);
		},
		
		generateBoxes: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options;
			
			iL.loadContent(iL.items[vars.current], 'current', opts.show.speed);
			
			if(iL.items[vars.next]) iL.loadContent(iL.items[vars.next], 'next', opts.show.speed);
			if(iL.items[vars.prev]) iL.loadContent(iL.items[vars.prev], 'prev', opts.show.speed);
		},
		
		generateThumbnails: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			timeOut = null;
			
			if(vars.thumbs && !iL.vars.dontGenerateThumbs) {
				var thumbnails = vars.thumbnails,
				container = $('div.ilightbox-thumbnails-container', thumbnails),
				grid = $('div.ilightbox-thumbnails-grid', container),
				i = 0;
				
				grid.removeAttr('style').empty();
				
				$.each(iL.items, function(key, val){
					var isActive = (vars.current == key) ? 'ilightbox-active' : '',
					opacity = (vars.current == key) ? opts.thumbnails.activeOpacity : opts.thumbnails.normalOpacity,
					thumb = val.options.thumbnail,
					thumbnail = $('<div class="ilightbox-thumbnail"></div>'),
					icon = $('<div class="ilightbox-thumbnail-icon"></div>');
					
					thumbnail.css({ opacity:0 }).addClass(isActive);
					
					if((val.type == "video" || val.type == "flash") && typeof val.options.icon == 'undefined') {
						icon.addClass('ilightbox-thumbnail-video');
						thumbnail.append(icon);
					}
					else if(val.options.icon) {
						icon.addClass('ilightbox-thumbnail-'+val.options.icon);
						thumbnail.append(icon);
					}
					
					if(thumb) iL.loadImage(thumb, function(img){
						i++;
						if(img) thumbnail.data({ naturalWidth:img.width, naturalHeight:img.height }).append('<img src="'+thumb+'" border="0" />');
						else thumbnail.data({ naturalWidth:opts.thumbnails.maxWidth, naturalHeight:opts.thumbnails.maxHeight });
						
						clearTimeout(timeOut);
						timeOut = setTimeout(function(){
							iL.positionThumbnails(thumbnails, container, grid);
						}, 20);
						setTimeout(function(){ thumbnail.fadeTo(opts.effects.loadedFadeSpeed, opacity); }, i*20);
					});
					
					grid.append(thumbnail);
				});
				iL.vars.dontGenerateThumbs = true;
			}
		},
		
		positionThumbnails: function(thumbnails, container, grid){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase();
			
			if(!thumbnails) thumbnails = vars.thumbnails;
			if(!container) container = $('div.ilightbox-thumbnails-container', thumbnails);
			if(!grid) grid = $('div.ilightbox-thumbnails-grid', container);
			
			var thumbs = $('.ilightbox-thumbnail', grid),
			widthAvail = (path == 'horizontal') ? vars.WIN.width() - opts.styles.pageOffsetX : thumbs.eq(0).outerWidth() - opts.styles.pageOffsetX,
			heightAvail = (path == 'horizontal') ? thumbs.eq(0).outerHeight() - opts.styles.pageOffsetY : vars.WIN.height() - opts.styles.pageOffsetY,
			gridWidth = (path == 'horizontal') ? 0 : widthAvail,
			gridHeight = (path == 'horizontal') ? heightAvail : 0,
			active = $('.ilightbox-active', grid),
			gridCss = {},
			css = {};

			if(arguments.length < 3) {
				thumbs.css({ opacity:opts.thumbnails.normalOpacity });
				active.css({ opacity:opts.thumbnails.activeOpacity });
			}
			
			thumbs.each(function(i){
				var t = $(this),
				data = t.data(),
				width = (path == 'horizontal') ? 0 : opts.thumbnails.maxWidth;
				height = (path == 'horizontal') ? opts.thumbnails.maxHeight : 0;
				dims = iL.getNewDimenstions(width, height, data.naturalWidth, data.naturalHeight, true);
				
				t.css({ width:dims.width, height:dims.height });
				if(path == 'horizontal') t.css({ 'float':'left' });
				
				(path == 'horizontal') ? (
					gridWidth += t.outerWidth()
				) : (
					gridHeight += t.outerHeight()
				);
			});
			
			gridCss = { width:gridWidth, height:gridHeight };
			
			grid.css(gridCss);
			
			gridCss = {};
			
			var gridOffset = grid.offset(),
			activeOffset = (active.length) ? active.offset() : { top:parseInt(heightAvail/2), left:parseInt(widthAvail/2) };
			
			gridOffset.top = (gridOffset.top - vars.DOC.scrollTop()),
			gridOffset.left = (gridOffset.left - vars.DOC.scrollLeft()),
			activeOffset.top = (activeOffset.top - gridOffset.top - vars.DOC.scrollTop()),
			activeOffset.left = (activeOffset.left - gridOffset.left - vars.DOC.scrollLeft());
				
			(path == 'horizontal') ? (
				gridCss.top = 0,
				gridCss.left = parseInt( (widthAvail / 2) - activeOffset.left - (active.outerWidth() / 2) )
			) : (
				gridCss.top = parseInt( ((heightAvail / 2) - activeOffset.top - (active.outerHeight() / 2)) ),
				gridCss.left = 0
			);
			
			if(arguments.length < 3) grid.stop().animate(gridCss, opts.effects.repositionSpeed, 'easeOutCirc');
			else grid.css(gridCss);
		},
		
		loadImage: function(image, callback){
			if(!$.isArray(image)) image = [image];
			
			var iL = this,
			length = image.length;
			
			if(length > 0) {
				iL.showLoader();
				$.each(image, function(index, value){
					var img = new Image();
					img.onload = function(){
						length -= 1;
						if(length == 0) {
							iL.hideLoader();
							callback(img);
						}
					};
					img.onerror = img.onabort = function(){
						length -= 1;
						if(length == 0) {
							iL.hideLoader();
							callback(false);
						}
					};
					img.src = image[index];
				});
			} else callback(false);
		},
		
		patchItemsEvents: function(){
			var iL = this,
			clickEvent = iL.vars.supportTouch ? "itap.iLightBox" : "click.iLightBox",
			vEvent = iL.vars.supportTouch ? "click.iLightBox" : "itap.iLightBox";
		
			$.each(iL.itemsObject, function(key, val){
				val.on(clickEvent, function(){
					iL.vars.current = key;
					if(iL.items[key + 1]) iL.vars.next = key + 1;
					else iL.vars.next = null;
					if(iL.items[key - 1]) iL.vars.prev = key - 1;
					else iL.vars.prev = null;
					
					iL.addContents();
					iL.patchEvents();
					
					return false;
				}).on(vEvent, function(){
					return false;
				});
			});
		},
		
		dispatchItemsEvents: function(){
			var iL = this;
		
			$.each(iL.itemsObject, function(key, val){
				val.off('.iLightBox');
			});
		},
		
		refresh: function(){
			var iL = this;
		
			iL.dispatchItemsEvents();
			iL.attachItems();
			iL.normalizeItems();
			iL.patchItemsEvents();
		},
		
		patchEvents: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase(),
			fullscreenEvent = fullScreenApi.fullScreenEventName+'.iLightBox',
			clickEvent = vars.supportTouch ? "itap.iLightBox" : "click.iLightBox";
			
			vars.WIN.bind('resize.iLightBox', function(){
				iL.repositionPhoto(null);
				if(vars.supportTouch) {
					clearTimeout(vars.setTime);
					vars.setTime = setTimeout(function(){
						var scrollTop = getScrollXY().y;
						window.scrollTo( 0, scrollTop-30 );
						window.scrollTo( 0, scrollTop+30 );
						window.scrollTo(0, scrollTop);
					}, 2000);
				}
				if(vars.thumbs) iL.positionThumbnails();
			}).bind('keydown.iLightBox', function(event){
				if(opts.controls.keyboard) {
					switch(event.keyCode){
						case 13:
							if(event.shiftKey && opts.keyboard.shift_enter) iL.fullScreenAction();
							break;
						case 27:
							if(opts.keyboard.esc) iL.closeAction();
							break;
						case 37:
							if(opts.keyboard.left && !vars.isInFullScreen) iL.moveTo('prev');
							break;
						case 38:
							if(opts.keyboard.up && !vars.isInFullScreen) iL.moveTo('prev');
							break;
						case 39:
							if(opts.keyboard.right && !vars.isInFullScreen) iL.moveTo('next');
							break;
						case 40:
							if(opts.keyboard.down && !vars.isInFullScreen) iL.moveTo('next');
							break;
					}
				}
			});
			
			if(fullScreenApi.supportsFullScreen) vars.WIN.bind(fullscreenEvent, function(){
				iL.doFullscreen();
			});
			
			vars.DOC.on(clickEvent, '.ilightbox-overlay', function(){
				if(opts.overlay.blur) iL.closeAction();
			}).on(clickEvent, '.ilightbox-next', function(){
				iL.moveTo('next');
			}).on(clickEvent, '.ilightbox-prev', function(){
				iL.moveTo('prev');
			}).on(clickEvent, '.ilightbox-thumbnail', function(){
				var t = $(this),
				thumbs = $('.ilightbox-thumbnail', vars.thumbnails),
				index = thumbs.index(t);
				
				if(index != vars.current) iL.goTo(index);
			}).on('mouseenter.iLightBox mouseleave.iLightBox', '.ilightbox-holder:not(.ilightbox-next, .ilightbox-prev)', function(e){
				var caption = $('div.ilightbox-caption', vars.holder);
				if(!caption.length) return;
				
				if(vars.nextLock || vars.prevLock) {
					if(e.type == 'mouseenter') caption.fadeIn('fast');
					else caption.fadeOut(opts.effects.fadeSpeed);
				}
				else {
					if(e.type == 'mouseenter') caption.stop().fadeIn('fast');
					else caption.stop().fadeOut(opts.effects.fadeSpeed);
				}
			}).on('mouseenter.iLightBox mouseleave.iLightBox', '.ilightbox-wrapper', function(e){
				if(e.type == 'mouseenter') vars.lockWheel = true;
				else vars.lockWheel = false;
			}).on(clickEvent, '.ilightbox-toolbar a', function(e){
				var t = $(this);
				
				if(t.hasClass('ilightbox-fullscreen')) iL.fullScreenAction();
				else iL.closeAction();
			});
			
			var switchers = $('.ilightbox-overlay, .ilightbox-holder, .ilightbox-thumbnails');
			
			if(opts.controls.mousewheel) switchers.on('mousewheel.iLightBox' , function(event, delta) {
				if(!vars.lockWheel){
					event.preventDefault();
					if(delta < 0) iL.moveTo('next');
					else if(delta > 0) iL.moveTo('prev');
				}
			});
			
			var holders = $('.ilightbox-holder'),
				touchStartEvent = vars.supportTouch ? "touchstart.iLightBox" : "mousedown.iLightBox",
				touchStopEvent = vars.supportTouch ? "touchend.iLightBox" : "mouseup.iLightBox",
				touchMoveEvent = vars.supportTouch ? "touchmove.iLightBox" : "mousemove.iLightBox",
				durationThreshold = 1000,
				horizontalDistanceThreshold = 50,
				verticalDistanceThreshold = 75;

			if(opts.controls.swipe) holders.on(touchStartEvent, function (event) {
				if (vars.nextLock || vars.prevLock) return;
				if (vars.total == 1) return;
				if (vars.lockSwipe) return;
				
				vars.BODY.addClass('ilightbox-closedhand');
				
				var data = event.originalEvent.touches ? event.originalEvent.touches[0] : event,
					scrollTop = vars.DOC.scrollTop(),
					scrollLeft = vars.DOC.scrollLeft(),
					start = {
						time: (new Date()).getTime(),
						coords: [data.pageX - scrollLeft, data.pageY - scrollTop]
					},
					stop;

				function moveHandler(event) {

					if (!start) return;

					var data = event.originalEvent.touches ? event.originalEvent.touches[0] : event;

					stop = {
						time: (new Date()).getTime(),
						coords: [data.pageX - scrollLeft, data.pageY - scrollTop]
					};
					
					holders.each(function(){
						var t = $(this),
							offset = t.data('offset') || { top: t.offset().top - scrollTop, left: t.offset().left - scrollLeft },
							top = offset.top,
							left = offset.left,
							scroll = [(start.coords[0] - stop.coords[0]), (start.coords[1] - stop.coords[1])];
						
						(path == "horizontal") ? t.stop().css({ left: (left-scroll[0]) }) : t.stop().css({ top: (top-scroll[1]) });
					});

					// prevent scrolling
					event.preventDefault();
				}
				
				function repositionHolders(){
					holders.each(function(){
						var t = $(this),
							offset = t.data('offset') || { top: t.offset().top - scrollTop, left: t.offset().left - scrollLeft },
							top = offset.top,
							left = offset.left;
						
						t.stop().animate({ top: top, left: left }, 500, 'easeOutCirc');
					});
				}

				holders.bind(touchMoveEvent, moveHandler);
				vars.DOC.one(touchStopEvent, function (event) {
					holders.unbind(touchMoveEvent, moveHandler);
				
					vars.BODY.removeClass('ilightbox-closedhand');

					if (start && stop) {
						if (path == "horizontal" && stop.time - start.time < durationThreshold && Math.abs(start.coords[0] - stop.coords[0]) > horizontalDistanceThreshold && Math.abs(start.coords[1] - stop.coords[1]) < verticalDistanceThreshold) {
							if(start.coords[0] > stop.coords[0]) {
								if(vars.current == vars.total-1) repositionHolders();
								else {
									vars.isSwipe = true;
									iL.moveTo('next');
								}
							} else {
								if(vars.current == 0) repositionHolders();
								else {
									vars.isSwipe = true;
									iL.moveTo('prev');
								}
							}
						} else if (path == "vertical" && stop.time - start.time < durationThreshold && Math.abs(start.coords[1] - stop.coords[1]) > horizontalDistanceThreshold && Math.abs(start.coords[0] - stop.coords[0]) < verticalDistanceThreshold) {
							if(start.coords[1] > stop.coords[1]) {
								if(vars.current == vars.total-1) repositionHolders();
								else {
									vars.isSwipe = true;
									iL.moveTo('next');
								}
							} else {
								if(vars.current == 0) repositionHolders();
								else {
									vars.isSwipe = true;
									iL.moveTo('prev');
								}
							}
						} else repositionHolders();
					}
					start = stop = undefined;
				});
			});
		
		},
		
		goTo: function(index){
			var iL = this,
			vars = iL.vars,
			diff = (index - iL.vars.current);
			
			if(diff == 1) iL.moveTo('next');
			else if(diff == -1) iL.moveTo('prev');
			else {
				//Trigger the onBeforeChange callback
				if(typeof iL.options.callback.onBeforeChange == 'function') iL.options.callback.onBeforeChange.call(iL, iL.ui);
			
				if(vars.nextLock || vars.prevLock) return false;
			
				if(iL.items[index]){
					if(!iL.items[index].options.mousewheel) iL.vars.lockWheel = true;
					else iL.vars.lockWheel = false;
					
					if(!iL.items[index].options.swipe) iL.vars.lockSwipe = true;
					else iL.vars.lockSwipe = false;
				}
				
				$.each([vars.holder, vars.nextPhoto, vars.prevPhoto], function(key, val){
					val.fadeOut(iL.options.effects.loadedFadeSpeed);
				});
			
				iL.vars.current = index;
				iL.vars.next = index + 1;
				iL.vars.prev = index - 1;
			
				iL.createUI();
				
				setTimeout(function(){ iL.generateBoxes(); }, iL.options.effects.loadedFadeSpeed+50);
				
				$('.ilightbox-thumbnail', vars.thumbnails).removeClass('ilightbox-active').eq(index).addClass('ilightbox-active');
				iL.positionThumbnails();
					
				//Trigger the onAfterChange callback
				if(typeof iL.options.callback.onAfterChange == 'function') iL.options.callback.onAfterChange.call(iL, iL.ui);
			}
		},
		
		moveTo: function(side){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase(),
			switchSpeed = opts.effects.switchSpeed;
			
			if(vars.nextLock || vars.prevLock) return false;
			else {
				var item = (side == "next") ? vars.next : vars.prev;
				if(side == "next") {
					if(!iL.items[item]) return false;
					var firstHolder = vars.nextPhoto,
					secondHolder = vars.holder,
					lastHolder = vars.prevPhoto,
					firstClass = 'ilightbox-prev',
					secondClass = 'ilightbox-next';
				}
				else if(side == "prev") {
					if(!iL.items[item]) return false;
					var firstHolder = vars.prevPhoto,
					secondHolder = vars.holder,
					lastHolder = vars.nextPhoto,
					firstClass = 'ilightbox-next',
					secondClass = 'ilightbox-prev';
				}
				
				//Trigger the onBeforeChange callback
				if(typeof opts.callback.onBeforeChange == 'function') opts.callback.onBeforeChange.call(iL, iL.ui);
				
				(side == "next") ? vars.nextLock = true : vars.prevLock = true;
				
				var captionFirst = $('div.ilightbox-caption', secondHolder);
				
				if(captionFirst.length) captionFirst.stop().fadeOut(switchSpeed, function(){
					$(this).remove();
				});
				
				if(iL.items[item].caption && opts.show.caption) {
					iL.setCaption(iL.items[item], firstHolder);
					$('div.ilightbox-caption', firstHolder).fadeIn(switchSpeed);
				}
				
				$.each([firstHolder, secondHolder, lastHolder], function(key, val){
					val.removeClass('ilightbox-next ilightbox-prev');
				});
				
				var firstOffset = firstHolder.data('offset'),
				winW = (vars.WIN.width() - (opts.styles.pageOffsetX)),
				winH = (vars.WIN.height() - (opts.styles.pageOffsetY)),
				width = firstOffset.newDims.width,
				height = firstOffset.newDims.height,
				thumbsOffset = firstOffset.thumbsOffset,
				diff = firstOffset.diff,
				top = parseInt((winH/2) - (height/2) - diff.H - (thumbsOffset.H/2)),
				left = parseInt((winW/2) - (width/2) - diff.W - (thumbsOffset.W/2));
				firstHolder.animate({ top:top, left:left, opacity:1 }, switchSpeed, (vars.isSwipe) ? 'easeOutCirc' : 'easeInOutCirc');
				$('div.ilightbox-container', firstHolder).animate({ width:width, height:height }, switchSpeed, (vars.isSwipe) ? 'easeOutCirc' : 'easeInOutCirc');

				var secondOffset = secondHolder.data('offset'),
				object = secondOffset.object;
				
				diff = secondOffset.diff;
				
				width = secondOffset.newDims.width,
				height = secondOffset.newDims.height;
				
				width = parseInt(width * ((side == 'next') ? opts.styles.prevScale : opts.styles.nextScale)),
				height = parseInt(height * ((side == 'next') ? opts.styles.prevScale : opts.styles.nextScale)),
				top = (path == 'horizontal') ? parseInt((winH/2) - object.offsetY - (height/2) - diff.H - (thumbsOffset.H/2)) : parseInt(winH - object.offsetX - diff.H - (thumbsOffset.H/2));
				
				if(side == 'prev') left = (path == 'horizontal') ? parseInt(winW - object.offsetX - diff.W - (thumbsOffset.W/2)) : parseInt((winW / 2) - (width / 2) - diff.W - object.offsetY - (thumbsOffset.W/2));
				else {
					top = (path == 'horizontal') ? top : parseInt(object.offsetX - diff.H - height - (thumbsOffset.H/2)),
					left = (path == 'horizontal') ? parseInt(object.offsetX - diff.W - width - (thumbsOffset.W/2)) : parseInt((winW/2) - object.offsetY - (width/2) - diff.W - (thumbsOffset.W/2));
				}
				
				$('div.ilightbox-container', secondHolder).animate({ width:width, height:height }, switchSpeed, (vars.isSwipe) ? 'easeOutCirc' : 'easeInOutCirc');
				secondHolder.addClass(firstClass).animate({ top:top, left:left, opacity:opts.styles.prevOpacity }, switchSpeed, (vars.isSwipe) ? 'easeOutCirc' : 'easeInOutCirc', function(){
				
					$('.ilightbox-thumbnail', vars.thumbnails).removeClass('ilightbox-active').eq(item).addClass('ilightbox-active');
					iL.positionThumbnails();
			
					if(iL.items[item]){
						if(!iL.items[item].options.mousewheel) vars.lockWheel = true;
						else vars.lockWheel = false;
						
						if(!iL.items[item].options.swipe) vars.lockSwipe = true;
						else vars.lockSwipe = false;
					}
					
					vars.isSwipe = false;
				
					if(side == "next"){
						vars.nextPhoto = lastHolder,
						vars.prevPhoto = secondHolder,
						vars.holder = firstHolder;
					
						vars.nextPhoto.hide();
						
						vars.next = vars.next + 1,
						vars.prev = vars.current,
						vars.current = vars.current + 1;
			
						iL.createUI();

						if(!iL.items[vars.next]) vars.nextLock = false;
						else iL.loadContent(iL.items[vars.next], 'next');
					} else {
						vars.prevPhoto = lastHolder;
						vars.nextPhoto = secondHolder;
						vars.holder = firstHolder;
					
						vars.prevPhoto.hide();
						
						vars.next = vars.current;
						vars.current = vars.prev;
						vars.prev = vars.current - 1;
			
						iL.createUI();

						if(!iL.items[vars.prev]) vars.prevLock = false;
						else iL.loadContent(iL.items[vars.prev], 'prev');
					}
					
					iL.repositionPhoto();
					
					//Trigger the onAfterChange callback
					if(typeof opts.callback.onAfterChange == 'function') opts.callback.onAfterChange.call(iL, iL.ui);
				});
				
				top = (path == 'horizontal') ? lastHolder.css('top') : ((side == "next") ? parseInt(-(winH/2) - lastHolder.outerHeight()) : parseInt(top * 2)),
				left = (path == 'horizontal') ? ((side == "next") ? parseInt(-(winW/2) - lastHolder.outerWidth()) : parseInt(left * 2)) : lastHolder.css('left');
				lastHolder.animate({ top:top, left:left, opacity:opts.styles.nextOpacity }, switchSpeed, (vars.isSwipe) ? 'easeOutCirc' : 'easeInOutCirc').addClass(secondClass);
			}
		},
		
		setCaption: function(obj, target){
			var iL = this,
			caption = $('<div class="ilightbox-caption"></div>');
			
			if(obj.caption) {
				caption.html(obj.caption);
				$('div.ilightbox-container', target).append(caption);
			}
		},
		
		fullScreenAction: function(){
			var iL = this;
			
			if(fullScreenApi.supportsFullScreen){
				if(fullScreenApi.isFullScreen()) fullScreenApi.cancelFullScreen(document.documentElement);
				else fullScreenApi.requestFullScreen(document.documentElement);
			} else {
				iL.doFullscreen();
			}
		},
		
		doFullscreen: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			currentHolder = vars.holder,
			current = iL.items[vars.current],
			windowWidth = vars.WIN.width(),
			windowHeight = vars.WIN.height(),
			elements = [currentHolder, vars.nextPhoto, vars.prevPhoto, vars.overlay, vars.toolbar, vars.thumbnails, vars.loader],
			hideElements = [vars.nextPhoto, vars.prevPhoto, vars.loader, vars.thumbnails];
			
			if(!vars.isInFullScreen) {
				vars.isInFullScreen = vars.lockWheel = vars.lockSwipe = true;
				vars.overlay.css({ opacity: 1 });
				
				$.each(hideElements, function(i, element){
					element.hide();
				});
				
				vars.fullScreenButton.attr('title', opts.text.exitFullscreen);
				
				if(opts.fullStretchTypes.indexOf(current.type) != -1) currentHolder.data({ naturalWidthOld:currentHolder.data('naturalWidth'), naturalHeightOld:currentHolder.data('naturalHeight'), naturalWidth:windowWidth, naturalHeight:windowHeight });
				else {
					var viewport = current.options.fullViewPort || opts.fullViewPort || '',
					newWidth = windowWidth,
					newHeight = windowHeight,
					width = currentHolder.data('naturalWidth'),
					height = currentHolder.data('naturalHeight');
					
					if(viewport.toLowerCase() == 'fill') {
						newHeight = (newWidth / width) * height;

						if (newHeight < windowHeight) {
							newWidth = (windowHeight / height) * width,
							newHeight = windowHeight;
						}
					} else if(viewport.toLowerCase() == 'fit') {
						var dims = iL.getNewDimenstions(newWidth, newHeight, width, height, true);
						
						newWidth = dims.width,
						newHeight = dims.height;
					} else if(viewport.toLowerCase() == 'stretch') {
						newWidth = newWidth,
						newHeight = newHeight;
					} else {
						var scale = (width > newWidth || height > newHeight) ? true : false,
						dims = iL.getNewDimenstions(newWidth, newHeight, width, height, scale);
						newWidth = dims.width,
						newHeight = dims.height;
					}
					
					currentHolder.data({
						naturalWidthOld:currentHolder.data('naturalWidth'),
						naturalHeightOld:currentHolder.data('naturalHeight'),
						naturalWidth:newWidth,
						naturalHeight:newHeight
					});
				}
				
				$.each(elements, function(key, val){
					val.addClass('ilightbox-fullscreen');
				});
				
				//Trigger the onEnterFullScreen callback
				if(typeof opts.callback.onEnterFullScreen == 'function') opts.callback.onEnterFullScreen.call(iL, iL.ui);
			} else {
				vars.isInFullScreen = vars.lockWheel = vars.lockSwipe = false;
				vars.overlay.css({ opacity: iL.options.overlay.opacity });
				
				$.each(hideElements, function(i, element){
					element.show();
				});
				
				vars.fullScreenButton.attr('title', opts.text.enterFullscreen);
			
				currentHolder.data({ naturalWidth:currentHolder.data('naturalWidthOld'), naturalHeight:currentHolder.data('naturalHeightOld'), naturalWidthOld:null, naturalHeightOld:null });
				
				$.each(elements, function(key, val){
					val.removeClass('ilightbox-fullscreen');
				});
				
				//Trigger the onExitFullScreen callback
				if(typeof opts.callback.onExitFullScreen == 'function') opts.callback.onExitFullScreen.call(iL, iL.ui);
			}
			iL.repositionPhoto(true);
		},
		
		closeAction: function(){
			var iL = this,
			vars = iL.vars;
			
			vars.WIN.unbind('.iLightBox');
			
			if(vars.isInFullScreen) fullScreenApi.cancelFullScreen(document.documentElement);
			
			vars.DOC.off('.iLightBox');
			$('.ilightbox-overlay, .ilightbox-holder, .ilightbox-thumbnails').off('.iLightBox');
			
			if(iL.options.hide.effect) vars.overlay.stop().fadeOut(iL.options.hide.speed, function(){
				vars.overlay.remove();
				vars.BODY.removeClass('ilightbox-noscroll').off('.iLightBox');
			});
			else {
				vars.overlay.remove();
				vars.BODY.removeClass('ilightbox-noscroll').off('.iLightBox');
			}
			
			var fadeOuts = [vars.toolbar, vars.holder, vars.nextPhoto, vars.prevPhoto, vars.loader, vars.thumbnails];
			
			$.each(fadeOuts, function(i, element){
				element.removeAttr('style').remove();
			});
			
			iL.vars.dontGenerateThumbs = iL.vars.isInFullScreen = false;
					
			//Trigger the onHide callback
			if(typeof iL.options.callback.onHide == 'function') iL.options.callback.onHide.call(iL, iL.ui);
		},

		repositionPhoto: function(){
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase(),
			thumbsOffsetW = (vars.isInFullScreen) ? 0 : ((path == 'horizontal') ? 0 : vars.thumbnails.outerWidth()),
			thumbsOffsetH = (vars.isInFullScreen) ? 0 : ((path == 'horizontal') ? vars.thumbnails.outerHeight() : 0),
			width = (vars.isInFullScreen) ? vars.WIN.width() : (vars.WIN.width() - (opts.styles.pageOffsetX)),
			height = (vars.isInFullScreen) ? vars.WIN.height() : (vars.WIN.height() - (opts.styles.pageOffsetY)),
			offsetW = (path == 'horizontal') ? parseInt((iL.items[vars.next] || iL.items[vars.prev]) ? ((opts.styles.nextOffsetX + opts.styles.prevOffsetX))*2 : (((width/10) <= 30) ? 30 : (width/10))) : parseInt(((width/10) <= 30) ? 30 : (width/10))+thumbsOffsetW,
			offsetH = (path == 'horizontal') ? parseInt(((height/10) <= 30) ? 30 : (height/10))+thumbsOffsetH : parseInt((iL.items[vars.next] || iL.items[vars.prev]) ? ((opts.styles.nextOffsetX + opts.styles.prevOffsetX))*2 : (((height/10) <= 30) ? 30 : (height/10)));
			
			var elObject = {
				type: 'current',
				width: width,
				height: height,
				item: iL.items[vars.current],
				offsetW: offsetW,
				offsetH: offsetH,
				thumbsOffsetW: thumbsOffsetW,
				thumbsOffsetH: thumbsOffsetH,
				animate: arguments.length,
				holder: vars.holder
			};
			
			iL.repositionEl(elObject);
			
			if(iL.items[vars.next]) {
				elObject = $.extend(elObject, {
					type: 'next',
					item: iL.items[vars.next],
					offsetX: opts.styles.nextOffsetX,
					offsetY: opts.styles.nextOffsetY,
					holder: vars.nextPhoto
				});
				
				iL.repositionEl(elObject);
			}
			
			if(iL.items[vars.prev]) {
				elObject = $.extend(elObject, {
					type: 'prev',
					item: iL.items[vars.prev],
					offsetX: opts.styles.prevOffsetX,
					offsetY: opts.styles.prevOffsetY,
					holder: vars.prevPhoto
				});
				
				iL.repositionEl(elObject);
			}
			
			var loaderCss = (path == "horizontal") ? { left:parseInt((width / 2) - (vars.loader.outerWidth() / 2)) } : { top:parseInt((height / 2) - (vars.loader.outerHeight() / 2)) };
			vars.loader.css(loaderCss);
		},
		
		repositionEl: function(obj) {
			var iL = this,
			vars = iL.vars,
			opts = iL.options,
			path = opts.path.toLowerCase(),
			widthAvail = (obj.type == 'current') ? ((vars.isInFullScreen) ? obj.width : (obj.width - obj.offsetW)) : (obj.width - obj.offsetW),
			heightAvail = (obj.type == 'current') ? ((vars.isInFullScreen) ? obj.height : (obj.height - obj.offsetH)) : (obj.height - obj.offsetH),
			itemParent = obj.item,
			item = obj.item.options,
			holder = obj.holder,
			offsetX = obj.offsetX || 0,
			offsetY = obj.offsetY || 0,
			thumbsOffsetW = obj.thumbsOffsetW,
			thumbsOffsetH = obj.thumbsOffsetH;
		
			if(obj.type == 'current') {
				if(typeof item.width == 'number' && item.width) widthAvail = (vars.isInFullScreen && (opts.fullStretchTypes.indexOf(itemParent.type) != -1 || item.fullViewPort || opts.fullViewPort)) ? widthAvail : ((item.width > widthAvail) ? widthAvail : item.width);
				if(typeof item.height == 'number' && item.height) heightAvail = (vars.isInFullScreen && (opts.fullStretchTypes.indexOf(itemParent.type) != -1 || item.fullViewPort || opts.fullViewPort)) ? heightAvail : ((item.height > heightAvail) ? heightAvail : item.height);
			} else {
				if(typeof item.width == 'number' && item.width) widthAvail = (item.width > widthAvail) ? widthAvail : item.width;
				if(typeof item.height == 'number' && item.height) heightAvail = (item.height > heightAvail) ? heightAvail : item.height;
			}
			
			heightAvail = parseInt(heightAvail - $('.ilightbox-inner-toolbar', holder).outerHeight());
			
			var width = (typeof item.width == 'string' && item.width.indexOf('%') != -1) ? iL.percentToValue(parseInt(item.width.replace('%', '')), obj.width) : holder.data('naturalWidth'),
			height = (typeof item.height == 'string' && item.height.indexOf('%') != -1) ? iL.percentToValue(parseInt(item.height.replace('%', '')), obj.height) : holder.data('naturalHeight');
			
			var dims = ((typeof item.width == 'string' && item.width.indexOf('%') != -1 || typeof item.height == 'string' && item.height.indexOf('%') != -1) ? { width:width, height:height } : iL.getNewDimenstions(widthAvail, heightAvail, width, height)),
				newDims = $.extend({}, dims, {});
			
			if(obj.type == 'prev' || obj.type == 'next')
				width = parseInt(dims.width * ((obj.type == 'next') ? opts.styles.nextScale : opts.styles.prevScale)),
				height = parseInt(dims.height * ((obj.type == 'next') ? opts.styles.nextScale : opts.styles.prevScale));
			else
				width = dims.width,
				height = dims.height;
			
			var widthDiff = parseInt((parseInt(holder.css('padding-left').replace('px', '')) + parseInt(holder.css('padding-right').replace('px', '')) + parseInt(holder.css('border-left-width').replace('px', '')) + parseInt(holder.css('border-right-width').replace('px', ''))) / 2),
			heightDiff = parseInt((parseInt(holder.css('padding-top').replace('px', '')) + parseInt(holder.css('padding-bottom').replace('px', '')) + parseInt(holder.css('border-top-width').replace('px', '')) + parseInt(holder.css('border-bottom-width').replace('px', '')) + $('.ilightbox-inner-toolbar', holder).outerHeight()) / 2);
			
			switch(obj.type){
				case 'current':
					var top = parseInt((obj.height/2) - (height/2) - heightDiff - (thumbsOffsetH/2)),
					left = parseInt((obj.width/2) - (width/2) - widthDiff - (thumbsOffsetW/2));
					break;
					
				case 'next':
					var top = (path == 'horizontal') ? parseInt((obj.height/2) - offsetY - (height/2) - heightDiff - (thumbsOffsetH/2)) : parseInt(obj.height - offsetX - heightDiff - (thumbsOffsetH/2)),
					left = (path == 'horizontal') ? parseInt(obj.width - offsetX - widthDiff - (thumbsOffsetW/2)) : parseInt((obj.width / 2) - (width / 2) - widthDiff - offsetY - (thumbsOffsetW/2));
					break;
				
				case 'prev':
					var top = (path == 'horizontal') ? parseInt((obj.height/2) - offsetY - (height/2) - heightDiff - (thumbsOffsetH/2)) : parseInt(offsetX - heightDiff - height - (thumbsOffsetH/2)),
					left = (path == 'horizontal') ? parseInt(offsetX - widthDiff - width - (thumbsOffsetW/2)) : parseInt((obj.width/2) - offsetY - (width/2) - widthDiff - (thumbsOffsetW/2));
					break;
			}
			
			holder.data('offset', {
				top: top,
				left: left,
				newDims: newDims,
				diff: {
					W: widthDiff,
					H: heightDiff
				},
				thumbsOffset: {
					W: thumbsOffsetW,
					H: thumbsOffsetH
				},
				object: obj
			});
			
			if(obj.animate > 0 && opts.effects.reposition) {
				holder.stop().animate({ top:top, left:left }, opts.effects.repositionSpeed, 'easeOutCirc');
				$('div.ilightbox-container', holder).stop().animate({ width:width, height:height }, opts.effects.repositionSpeed, 'easeOutCirc');
				$('div.ilightbox-inner-toolbar', holder).stop().animate({ width:width }, opts.effects.repositionSpeed, 'easeOutCirc', function(){
					$(this).css('overflow', 'visible');
				});
			}
			else {
				holder.css({ top:top, left:left });
				$('div.ilightbox-container', holder).css({ width:width, height:height });
				$('div.ilightbox-inner-toolbar', holder).css({ width:width });
			}
		},
		
		getNewDimenstions: function(width, height, width_old, height_old, thumb){
			var iL = this;
			
			if (!width) factor = height/height_old;
			else if (!height) factor = width/width_old;
			else factor = Math.min( width / width_old, height / height_old );
			
			if(!thumb) {
				if(factor > iL.options.maxScale) factor = iL.options.maxScale;
				else if(factor < iL.options.minScale) factor = iL.options.minScale;
			}

			var final_width = (iL.options.keepAspectRatio) ? Math.round( width_old * factor ) : width,
			final_height = (iL.options.keepAspectRatio) ? Math.round( height_old * factor ) : height;
			
			return { width:final_width, height:final_height, ratio:factor };
		},
		
		setOption: function(options){
			var iL = this;
			
			iL.options = $.extend(true, iL.options, options || {});
			iL.refresh();
		},
		
		availPlugins: function(){
			var iL = this,
			PD = PluginDetect;
			
            iL.plugins = {
                flash: (parseInt(PD.getVersion("Shockwave")) >= 0 || parseInt(PD.getVersion("Flash")) >= 0) ? true : false,
                quicktime: (parseInt(PD.getVersion("QuickTime")) >= 0) ? true : false
            };
			
			var testEl = document.createElement( "video" );
			iL.plugins.html5H264 = !!(testEl.canPlayType && testEl.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"').replace(/no/, ''));
			iL.plugins.html5WebM = !!(testEl.canPlayType && testEl.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/no/, ''));
			iL.plugins.html5Vorbis = !!(testEl.canPlayType && testEl.canPlayType('video/ogg; codecs="theora, vorbis"').replace(/no/, ''));
			iL.plugins.html5QuickTime = !!(testEl.canPlayType && testEl.canPlayType('video/quicktime').replace(/no/, ''));
		},
		
		addContent: function(element, obj){
			var iL= this,
			el;
			
			switch(obj.type){
				case 'video':
					var HTML5 = false,
					videoType,
					html5video = obj.options.html5video;
					
					if(html5video.webm && iL.plugins.html5WebM) obj.ext = 'webm',
					obj.URL = html5video.webm || obj.URL;
					else if(html5video.ogg && iL.plugins.html5Vorbis) obj.ext = 'ogv',
					obj.URL = html5video.ogg || obj.URL;
					else if(html5video.h264 && iL.plugins.html5H264) obj.ext = 'mp4',
					obj.URL = html5video.h264 || obj.URL;
					
					if(iL.plugins.html5H264 && (obj.ext=='mp4' || obj.ext=='m4v')) HTML5 = true, videoType = "video/mp4";
					else if(iL.plugins.html5WebM && obj.ext=='webm') HTML5 = true, videoType = "video/webm";
					else if(iL.plugins.html5Vorbis && obj.ext=='ogv') HTML5 = true, videoType = "video/ogg";
					else if(iL.plugins.html5QuickTime && (obj.ext=='mov' || obj.ext=='qt')) HTML5 = true, videoType = "video/quicktime";
					
					if(HTML5){
						el = $('<video />', {
							"width":"100%",
							"height":"100%",
							"preload":html5video.preload,
							"autoplay":html5video.autoplay,
							"poster":html5video.poster,
							"controls":html5video.controls
						}).append($('<source />', {
							"src":obj.URL,
							"type":videoType
						}));
					} else {
						if(!iL.plugins.quicktime) el = $('<span />', {
							"class":"ilightbox-alert",
							html:iL.options.errors.missingPlugin.replace('{pluginspage}', iL.pluginspages.quicktime).replace('{type}', 'QuickTime')
						});
						else {
							
							el = $('<object />', {
								"type":"video/quicktime",
								"pluginspage":iL.pluginspages.quicktime
							}).attr({
								"data":obj.URL,
								"width":"100%",
								"height":"100%"
							}).append($('<param />', {
								"name":"src",
								"value":obj.URL
							})).append($('<param />', {
								"name":"autoplay",
								"value":"false"
							})).append($('<param />', {
								"name":"loop",
								"value":"false"
							})).append($('<param />', {
								"name":"scale",
								"value":"tofit"
							}));
							
							if(BrowserDetect.browser == 'Explorer') el = QT_GenerateOBJECTText(obj.URL,'100%','100%','','SCALE','tofit','AUTOPLAY','false','LOOP','false');
						}
					}
					
					break;
					
				case 'flash':
					if(!iL.plugins.flash) el = $('<span />', {
						"class":"ilightbox-alert",
						html:iL.options.errors.missingPlugin.replace('{pluginspage}', iL.pluginspages.flash).replace('{type}', 'Adobe Flash player')
					});
					else {
						var flashvars = "",
						i = 0;
						
						if(obj.options.flashvars) $.each(obj.options.flashvars, function(k,v){
							if(i!=0) flashvars += "&";
							flashvars += k+"="+encodeURIComponent(v);
							i++;
						});
						else flashvars = null;
					
						el = $('<embed />').attr({
							"type":"application/x-shockwave-flash",
							"src":obj.URL,
							"width":(typeof obj.options.width == 'number' && obj.options.width && iL.options.minScale == '1' && iL.options.maxScale == '1') ? obj.options.width : "100%",
							"height":(typeof obj.options.height == 'number' && obj.options.height && iL.options.minScale == '1' && iL.options.maxScale == '1') ? obj.options.height : "100%",
							"quality":"high",
							"bgcolor":"#000000",
							"play":"true",
							"loop":"true",
							"menu":"true",
							"wmode":"transparent",
							"scale":"showall",
							"allowScriptAccess":"always",
							"allowFullScreen":"true",
							"flashvars":flashvars,
							"fullscreen":"yes"
						});
					}
					
					break;
					
				case 'iframe':
					el = $('<iframe />').attr({
						"width":(typeof obj.options.width == 'number' && obj.options.width && iL.options.minScale == '1' && iL.options.maxScale == '1') ? obj.options.width : "100%",
						"height":(typeof obj.options.height == 'number' && obj.options.height && iL.options.minScale == '1' && iL.options.maxScale == '1') ? obj.options.height : "100%",
						src:obj.URL,
						frameborder:0,
						'webkitAllowFullScreen':'',
						'mozallowfullscreen':'',
						'allowFullScreen':''
					});
					
					break;
					
				case 'inline':
					el = $('<div class="ilightbox-wrapper"></div>').html($(obj.URL).clone(true));
					
					break;
					
				case 'html':
					var object = obj.URL, el;
					
					if(object[0].nodeName) {
						el = $('<div class="ilightbox-wrapper"></div>').html(object);
					}
					else {
						var dom = $(obj.URL),
						html = (dom.selector) ? $('<div>'+dom+'</div>') : dom;
						el = $('<div class="ilightbox-wrapper"></div>').html(html);
					}
					
					break;
			}
			
			$('div.ilightbox-container', element).empty().html(el);
			return el;
		},
		
		ogpRecognition: function(obj, callback){
			var iL = this,
			url = obj.URL,
			domain = url.match(/:\/\/(.[^/]+)/)[1].replace('www.',''),
			object = new Object();
			
			object.length = false;
			
			iL.showLoader();
			iL.doAjax(url, function(data){
				iL.hideLoader();
				if(data){
					data = "<div>"+data+"</div>";
					var DOM = $(data),
					type = $('meta[name="medium"]', DOM).attr('content'),
					iLMeta = $('meta[property="ilightbox:options"]', DOM).attr('content'),
					prefix;
					
					if(typeof iLMeta != 'undefined') {
						var metaObj = eval("({" + iLMeta + "})") || {};
						
						var source = metaObj.url || metaObj.URL,
						image = metaObj.thumbnail || null,
						width = metaObj.width || 0,
						height = metaObj.height || 0,
						prefix = metaObj.type || false;
						
					} else {
						if(!type) type = $('meta[property="og:type"]', DOM).attr('content');
						
						if(typeof type != 'undefined') type = type.toLowerCase();
						
						if(type.indexOf("video") != -1) prefix = "video";
						else if(type.indexOf("image") != -1) prefix = "image";
						else if(type.indexOf("photo") != -1) prefix = "image";
						
						if(typeof prefix == 'undefined' && $('meta[property="og:video:type"]', DOM).attr('content') != 'undefined') prefix = "video";
						else if(typeof prefix == 'undefined' && $('meta[property="og:video"]', DOM).attr('content') != 'undefined') prefix = "video";
						else if(typeof prefix == 'undefined' && $('link[rel="video_src"]', DOM).attr('href') != 'undefined') prefix = "video";
						else if(typeof prefix == 'undefined' && $('link[rel="image_src"]', DOM).attr('href') != 'undefined') prefix = "image";
						else if(typeof prefix == 'undefined' && $('meta[property="og:image"]', DOM).attr('content') != 'undefined') prefix = "image";
						
						var source = $('link[rel="'+prefix+'_src"]', DOM).attr('href'),
						image = $('link[rel="image_src"]', DOM).attr('href'),
						width = $('meta[name="'+prefix+'_width"]', DOM).attr('content'),
						height = $('meta[name="'+prefix+'_height"]', DOM).attr('content'),
						prefType = $('meta[name="'+prefix+'_type"]', DOM).attr('content');
						
						if(typeof source == 'undefined') source = $('meta[property="og:'+prefix+'"]', DOM).attr('content');
						if(typeof image == 'undefined') image = $('meta[property="og:image"]', DOM).attr('content');
						if(typeof width == 'undefined') width = $('meta[property="og:'+prefix+':width"]', DOM).attr('content');
						if(typeof height == 'undefined') height = $('meta[property="og:'+prefix+':height"]', DOM).attr('content');
						if(typeof prefType == 'undefined') prefType = $('meta[property="og:'+prefix+':type"]', DOM).attr('content');
						
						if(typeof prefType != 'undefined') prefType = prefType.toLowerCase();
					}
					
					object.source = source,
					object.width = width && parseInt(width) || 0,
					object.height = height && parseInt(height) || 0,
					object.type = prefix,
					object.thumbnail = image,
					object.length = true;
					
					if(prefType == 'application/x-shockwave-flash') object.type = "flash";
					else if(prefType.indexOf("video/") != -1) object.type = "video";
					else if(prefType.indexOf("/html") != -1) object.type = "iframe";
				}
				
				callback(object.length ? object : false);
			});
		},
		
		
		doAjax: function(url, callback){
			var iL = this,
			url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D%22"+encodeURIComponent(url)+"%22%20and%0A%20%20%20%20%20%20xpath%3D'%2F%2Fhtml%2Fhead'%0A%20and%20compat%3D%22html5%22&format=xml'&callback=?",
			xhr = $.ajax({
				url: url,
				dataType: 'json',
				cache: true
			});
			
			xhr.success(function(msg){
				var data = iL.filterData(msg.results[0]);
				callback(data);
			}).error(function(){
				callback(false);
			});
		},
		
		filterData: function(data){
			data = data.replace(/[\r|\n|\t]+/gi,'');
			data = data.replace(/<--[\S\s]*?-->/gi,'');
			data = data.replace(/<\!--[\S\s]*?-->/gi,'');
			data = data.replace(/<noscript[^>]*>[\S\s]*?<\/noscript>/gi,'');
			data = data.replace(/<script[^>]*>[\S\s]*?<\/script>/gi,'');
			data = data.replace(/<script.*\/>/i,'');
			data = data.replace(/<style[^>]*>[\S\s]*?<\/style>/gi,'');
			data = data.replace(/<style.*\/>/i,'');
			data = data.replace(/<head[\S\s]*?>/gi,'<head>');
			data = data.replace(/>[\S\s]*?</g,'><');
			return data;
		},
		
		findImageInElement: function(element) {
			var elements = $('*', element),
			imagesArr = new Array();
			
			elements.each(function(){
				var url = "",
				element = this;
				
				if ($(element).css("background-image") != "none") {
					url = $(element).css("background-image");
				} else if (typeof($(element).attr("src")) != "undefined" && element.nodeName.toLowerCase() == "img") {
					url = $(element).attr("src");
				}

				if (url.indexOf("gradient") == -1) {
					url = url.replace(/url\(\"/g, "");
					url = url.replace(/url\(/g, "");
					url = url.replace(/\"\)/g, "");
					url = url.replace(/\)/g, "");

					var urls = url.split(",");

					for (var i = 0; i < urls.length; i++) {
						if (urls[i].length > 0 && $.inArray(urls[i], imagesArr) == -1) {
							var extra = "";
							if (BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 9) {
								extra = "?" + Math.floor(Math.random() * 3000);
							}
							imagesArr.push(urls[i] + extra);
						}
					}
				}
			});
			
			return imagesArr;
		},
		
		basename: function(path, suffix) {
			var b = path.replace(/^.*[\/\\]/g, '');

			if (typeof(suffix) == 'string' && b.substr(b.length - suffix.length) == suffix) {
			b = b.substr(0, b.length - suffix.length);
			}

			return b;
		},
		
		pathInfo: function(path, options) {
			var opt = '',
			optName = '',
			optTemp = 0,
			tmp_arr = {},
			cnt = 0,
			i = 0;
			var have_basename = false,
			have_extension = false,
			have_filename = false;

			// Input defaulting & sanitation
			if (!path) return false;
			if (!options) options = 'PATHINFO_ALL';

			// Initialize binary arguments. Both the string & integer (constant) input is
			// allowed
			var OPTS = {
				'PATHINFO_DIRNAME': 1,
				'PATHINFO_BASENAME': 2,
				'PATHINFO_EXTENSION': 4,
				'PATHINFO_FILENAME': 8,
				'PATHINFO_ALL': 0
			};
			// PATHINFO_ALL sums up all previously defined PATHINFOs (could just pre-calculate)
			for (optName in OPTS) {
				OPTS.PATHINFO_ALL = OPTS.PATHINFO_ALL | OPTS[optName];
			}
			if (typeof options !== 'number') { // Allow for a single string or an array of string flags
				options = [].concat(options);
				for (i = 0; i < options.length; i++) {
					// Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
					if (OPTS[options[i]]) {
						optTemp = optTemp | OPTS[options[i]];
					}
				}
				options = optTemp;
			}

			// Internal Functions
			var __getExt = function (path) {
				var str = path + '';
				var dotP = str.lastIndexOf('.') + 1;
				return !dotP ? false : dotP !== str.length ? str.substr(dotP) : '';
			};


			// Gather path infos
			if (options & OPTS.PATHINFO_DIRNAME) {
				var dirname = path.replace(/\\/g, '/').replace(/\/[^\/]*\/?$/, '');
				tmp_arr.dirname = dirname === path ? '.' : dirname;
			}

			if (options & OPTS.PATHINFO_BASENAME) {
				if (false === have_basename) {
					have_basename = this.basename(path);
				}
				tmp_arr.basename = have_basename;
			}

			if (options & OPTS.PATHINFO_EXTENSION) {
				if (false === have_basename) {
					have_basename = this.basename(path);
				}
				if (false === have_extension) {
					have_extension = __getExt(have_basename);
				}
				if (false !== have_extension) {
					tmp_arr.extension = have_extension;
				}
			}

			if (options & OPTS.PATHINFO_FILENAME) {
				if (false === have_basename) {
					have_basename = this.basename(path);
				}
				if (false === have_extension) {
					have_extension = __getExt(have_basename);
				}
				if (false === have_filename) {
					have_filename = have_basename.slice(0, have_basename.length - (have_extension ? have_extension.length + 1 : have_extension === false ? 0 : 1));
				}

				tmp_arr.filename = have_filename;
			}


			// If array contains only 1 element: return string
			cnt = 0;
			for (opt in tmp_arr) {
				cnt++;
			}
			if (cnt == 1) {
				return tmp_arr[opt];
			}

			// Return full-blown array
			return tmp_arr;
		},
		
		extensions: {
			flash: 'swf',
			image: 'bmp gif jpeg jpg png tiff tif jfif jpe',
			iframe: 'asp aspx cgi cfm htm html jsp php pl php3 php4 php5 phtml rb rhtml shtml txt',
			video: 'avi mov mpg mpeg movie mp4 webm ogv ogg 3gp m4v'
		},
		
		pluginspages: {
			quicktime: 'http://www.apple.com/quicktime/download',
			flash: 'http://www.adobe.com/go/getflash'
		},
		
		getTypeByExtension: function(URL){
			var iL = this,
			ext = iL.pathInfo(URL, 'PATHINFO_EXTENSION');
			
			ext = ($.isPlainObject(ext)) ? null : ext.toLowerCase();
			
			if(iL.extensions.image.indexOf(ext) >= 0) type = 'image';
			else if(iL.extensions.flash.indexOf(ext) >= 0) type = 'flash';
			else if(iL.extensions.video.indexOf(ext) >= 0) type = 'video';
			else type = 'iframe';
			
			return type;
		},
		
		percentToValue: function(percent, total){
			return parseInt((total / 100) * percent);
		}
	};


	// Begin the iLightBox plugin
	$.fn.iLightBox = function () {

		var args = arguments,
		opt = ($.isPlainObject(args[0])) ? args[0] : args[1],
		items = ($.isArray(args[0]) || typeof args[0] == 'string') ? args[0] : args[1];
		
		if(!opt) opt = {};
		
		// Default options. Play carefully.
		var options = $.extend(true, {
			attr: 'href',
			path: 'vertical',
			skin: 'dark',
			startFrom: 0,
			randomStart: false,
			keepAspectRatio: true,
			maxScale: 1,
			minScale: .2,
			innerToolbar: false,
			smartRecognition: false,
			fullViewPort: null,
			fullStretchTypes: 'flash, video',
			overlay: {
				blur: true,
				opacity: .85
			},
			controls: {
				toolbar: true,
				fullscreen: true,
				thumbnail: true,
				keyboard: true,
				mousewheel: true,
				swipe: true
			},
			keyboard: {
				left: true, // previous
				right: true, // next
				up: true, // previous
				down: true, // next
				esc: true, // close
				shift_enter: true // fullscreen
			},
			show: {
				effect: true,
				speed: 300,
				title: true,
				caption: true
			},
			hide: {
				effect: true,
				speed: 300
			},
			styles: {
				pageOffsetX: 0,
				pageOffsetY: 0,
				nextOffsetX: 45,
				nextOffsetY: 0,
				nextOpacity: 1,
				nextScale: 1,
				prevOffsetX: 45,
				prevOffsetY: 0,
				prevOpacity: 1,
				prevScale: 1
			},
			thumbnails: {
				maxWidth: 120,
				maxHeight: 80,
				normalOpacity: 1,
				activeOpacity: .6
			},
			effects: {
				reposition: true,
				repositionSpeed: 200,
				switchSpeed: 500,
				loadedFadeSpeed: 180,
				fadeSpeed: 200
			},
			text: {
				close: "Press Esc to close",
				enterFullscreen: "Enter Fullscreen (Shift+Enter)",
				exitFullscreen: "Exit Fullscreen (Shift+Enter)"
			},
			errors: {
				loadImage: "An error occurred when trying to load photo.",
				loadContents: "An error occurred when trying to load contents.",
				missingPlugin: "The content your are attempting to view requires the <a href='{pluginspage}' target='_blank'>{type} plugin<\/a>."
			},
			ajaxSetup: {
				url: '',
				beforeSend: function(jqXHR, settings){},
				cache: false,
				complete: function(jqXHR, textStatus){},
				crossDomain: false,
				error: function(jqXHR, textStatus, errorThrown){},
				success: function(data, textStatus, jqXHR){},
				global: true,
				ifModified: false,
				username: null,
				password: null,
				type: 'GET'
			},
			callback: {}
		}, opt);
		
		var instant = ($.isArray(items) || typeof items == 'string') ? true : false;
		
		items = $.isArray(items) ? items : new Array();
		
		if(typeof args[0] == 'string') items[0] = args[0];

		if (parseFloat($.fn.jquery) >= 1.7) {
			var iLB = new iLightBox($(this), options, items, instant);
			return {
				close: function(){
					iLB.closeAction();
				},
				fullscreen: function(){
					iLB.fullScreenAction();
				},
				moveNext: function(){
					iLB.moveTo('next');
				},
				movePrev: function(){
					iLB.moveTo('prev');
				},
				goTo: function(index){
					iLB.goTo(index);
				},
				refresh: function(){
					iLB.refresh();
				},
				reposition: function(){
					(arguments.length > 0) ? iLB.repositionPhoto(true) : iLB.repositionPhoto();
				},
				setOption: function(options){
					iLB.setOption(options);
				}
			};
		} else {
			throw "The jQuery version that was loaded is too old. iLightBox requires jQuery 1.7+";
		}

	};
	
	$.iLightBox = function(){
		return $.fn.iLightBox(arguments[0], arguments[1]);
	};
	
	
	$.extend( $.easing,
	{
		easeInCirc: function (x, t, b, c, d) {
			return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
		},
		easeOutCirc: function (x, t, b, c, d) {
			return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
		},
		easeInOutCirc: function (x, t, b, c, d) {
			if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
			return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
		}
	});
	
	
	
	var $document = $( document );

	// add new event shortcuts
	$.each( ( "touchstart touchmove touchend " +
		"tap taphold " +
		"swipe swipeleft swiperight " +
		"scrollstart scrollstop" ).split( " " ), function( i, name ) {

		$.fn[ name ] = function( fn ) {
			return fn ? this.bind( name, fn ) : this.trigger( name );
		};

		// jQuery < 1.8
		if ( $.attrFn ) {
			$.attrFn[ name ] = true;
		}
	});
	
	
	function getScrollXY() {
		var scrOfX = 0, scrOfY = 0;
		if( typeof( window.pageYOffset ) == 'number' ) {
			//Netscape compliant
			scrOfY = window.pageYOffset;
			scrOfX = window.pageXOffset;
		} else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
			//DOM compliant
			scrOfY = document.body.scrollTop;
			scrOfX = document.body.scrollLeft;
		} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
			//IE6 standards compliant mode
			scrOfY = document.documentElement.scrollTop;
			scrOfX = document.documentElement.scrollLeft;
		}
		return { x: scrOfX, y: scrOfY };
	}


	var tapSettings = {
		startEvent	: 'touchstart.iTap',
		endEvent	: 'touchend.iTap'
	};
	
	// tap Event:
	$.event.special.itap = {
		setup: function() {

			var self = this,
				$self = $(this),
				start, stop;
				
			$self.bind(tapSettings.startEvent, function( event ){
				start = getScrollXY();

				$self.one( tapSettings.endEvent, function( event ) {
					stop = getScrollXY();
					
					var orgEvent = event || window.event;
					event = $.event.fix(orgEvent);
					event.type = "itap";
					
					if((start && stop) && (start.x == stop.x && start.y == stop.y)) ($.event.dispatch || $.event.handle).call( self, event );
					
					start = stop = undefined;
				});
			});
		},
    
		teardown: function() {
			$(this).unbind(tapSettings.startEvent);
		}
	};
	
	
	//Fullscreen API
	var fullScreenApi = {
		supportsFullScreen: false,
		isFullScreen: function() { return false; }, 
		requestFullScreen: function() {}, 
		cancelFullScreen: function() {},
		fullScreenEventName: '',
		prefix: ''
	},
	browserPrefixes = 'webkit moz o ms khtml'.split(' ');
	
	// check for native support
	if (typeof document.cancelFullScreen != 'undefined') {
		fullScreenApi.supportsFullScreen = true;
	} else {	 
		// check for fullscreen support by vendor prefix
		for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
			fullScreenApi.prefix = browserPrefixes[i];
			
			if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
				fullScreenApi.supportsFullScreen = true;
				
				break;
			}
		}
	}
	
	// update methods to do something useful
	if (fullScreenApi.supportsFullScreen) {
		fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
		
		fullScreenApi.isFullScreen = function() {
			switch (this.prefix) {	
				case '':
					return document.fullScreen;
				case 'webkit':
					return document.webkitIsFullScreen;
				default:
					return document[this.prefix + 'FullScreen'];
			}
		}
		fullScreenApi.requestFullScreen = function(el) {
			return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
		}
		fullScreenApi.cancelFullScreen = function(el) {
			return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
		}		
	}
	
	//Browser Detection
	var BrowserDetect={init:function(){this.browser=this.searchString(this.dataBrowser)||"An unknown browser";this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"an unknown version";this.OS=this.searchString(this.dataOS)||"an unknown OS"},searchString:function(b){for(var a=0;a<b.length;a++){var c=b[a].string,d=b[a].prop;this.versionSearchString=b[a].versionSearch||b[a].identity;if(c){if(-1!=c.indexOf(b[a].subString))return b[a].identity}else if(d)return b[a].identity}},
	searchVersion:function(b){var a=b.indexOf(this.versionSearchString);if(-1!=a)return parseFloat(b.substring(a+this.versionSearchString.length+1))},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{string:navigator.userAgent,subString:"OmniWeb",versionSearch:"OmniWeb/",identity:"OmniWeb"},{string:navigator.vendor,subString:"Apple",identity:"Safari",versionSearch:"Version"},{prop:window.opera,identity:"Opera",versionSearch:"Version"},{string:navigator.vendor,subString:"iCab",
	identity:"iCab"},{string:navigator.vendor,subString:"KDE",identity:"Konqueror"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.vendor,subString:"Camino",identity:"Camino"},{string:navigator.userAgent,subString:"Netscape",identity:"Netscape"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"},{string:navigator.userAgent,subString:"Gecko",identity:"Mozilla",versionSearch:"rv"},{string:navigator.userAgent,subString:"Mozilla",
	identity:"Netscape",versionSearch:"Mozilla"}],dataOS:[{string:navigator.platform,subString:"Win",identity:"Windows"},{string:navigator.platform,subString:"Mac",identity:"Mac"},{string:navigator.userAgent,subString:"iPhone",identity:"iPhone/iPod"},{string:navigator.platform,subString:"Linux",identity:"Linux"}]};
	BrowserDetect.init();
	
	/*
	PluginDetect v0.7.9
	www.pinlady.net/PluginDetect/license/
	[ getVersion onWindowLoaded BetterIE ]
	[ Flash QuickTime Shockwave ]
	*/
	var PluginDetect={version:"0.7.9",name:"PluginDetect",handler:function(c,b,a){return function(){c(b,a)}},openTag:"<",isDefined:function(b){return typeof b!="undefined"},isArray:function(b){return(/array/i).test(Object.prototype.toString.call(b))},isFunc:function(b){return typeof b=="function"},isString:function(b){return typeof b=="string"},isNum:function(b){return typeof b=="number"},isStrNum:function(b){return(typeof b=="string"&&(/\d/).test(b))},getNumRegx:/[\d][\d\.\_,-]*/,splitNumRegx:/[\.\_,-]/g,getNum:function(b,c){var d=this,a=d.isStrNum(b)?(d.isDefined(c)?new RegExp(c):d.getNumRegx).exec(b):null;return a?a[0]:null},compareNums:function(h,f,d){var e=this,c,b,a,g=parseInt;if(e.isStrNum(h)&&e.isStrNum(f)){if(e.isDefined(d)&&d.compareNums){return d.compareNums(h,f)}c=h.split(e.splitNumRegx);b=f.split(e.splitNumRegx);for(a=0;a<Math.min(c.length,b.length);a++){if(g(c[a],10)>g(b[a],10)){return 1}if(g(c[a],10)<g(b[a],10)){return -1}}}return 0},formatNum:function(b,c){var d=this,a,e;if(!d.isStrNum(b)){return null}if(!d.isNum(c)){c=4}c--;e=b.replace(/\s/g,"").split(d.splitNumRegx).concat(["0","0","0","0"]);for(a=0;a<4;a++){if(/^(0+)(.+)$/.test(e[a])){e[a]=RegExp.$2}if(a>c||!(/\d/).test(e[a])){e[a]="0"}}return e.slice(0,4).join(",")},$$hasMimeType:function(a){return function(c){if(!a.isIE&&c){var f,e,b,d=a.isArray(c)?c:(a.isString(c)?[c]:[]);for(b=0;b<d.length;b++){if(a.isString(d[b])&&/[^\s]/.test(d[b])){f=navigator.mimeTypes[d[b]];e=f?f.enabledPlugin:0;if(e&&(e.name||e.description)){return f}}}}return null}},findNavPlugin:function(l,e,c){var j=this,h=new RegExp(l,"i"),d=(!j.isDefined(e)||e)?/\d/:0,k=c?new RegExp(c,"i"):0,a=navigator.plugins,g="",f,b,m;for(f=0;f<a.length;f++){m=a[f].description||g;b=a[f].name||g;if((h.test(m)&&(!d||d.test(RegExp.leftContext+RegExp.rightContext)))||(h.test(b)&&(!d||d.test(RegExp.leftContext+RegExp.rightContext)))){if(!k||!(k.test(m)||k.test(b))){return a[f]}}}return null},getMimeEnabledPlugin:function(k,m,c){var e=this,f,b=new RegExp(m,"i"),h="",g=c?new RegExp(c,"i"):0,a,l,d,j=e.isString(k)?[k]:k;for(d=0;d<j.length;d++){if((f=e.hasMimeType(j[d]))&&(f=f.enabledPlugin)){l=f.description||h;a=f.name||h;if(b.test(l)||b.test(a)){if(!g||!(g.test(l)||g.test(a))){return f}}}}return 0},getPluginFileVersion:function(f,b){var h=this,e,d,g,a,c=-1;if(h.OS>2||!f||!f.version||!(e=h.getNum(f.version))){return b}if(!b){return e}e=h.formatNum(e);b=h.formatNum(b);d=b.split(h.splitNumRegx);g=e.split(h.splitNumRegx);for(a=0;a<d.length;a++){if(c>-1&&a>c&&d[a]!="0"){return b}if(g[a]!=d[a]){if(c==-1){c=a}if(d[a]!="0"){return b}}}return e},AXO:window.ActiveXObject,getAXO:function(a){var f=null,d,b=this,c={};try{f=new b.AXO(a)}catch(d){}return f},convertFuncs:function(f){var a,g,d,b=/^[\$][\$]/,c=this;for(a in f){if(b.test(a)){try{g=a.slice(2);if(g.length>0&&!f[g]){f[g]=f[a](f);delete f[a]}}catch(d){}}}},initObj:function(e,b,d){var a,c;if(e){if(e[b[0]]==1||d){for(a=0;a<b.length;a=a+2){e[b[a]]=b[a+1]}}for(a in e){c=e[a];if(c&&c[b[0]]==1){this.initObj(c,b)}}}},initScript:function(){var d=this,a=navigator,h,i=document,l=a.userAgent||"",j=a.vendor||"",b=a.platform||"",k=a.product||"";d.initObj(d,["$",d]);for(h in d.Plugins){if(d.Plugins[h]){d.initObj(d.Plugins[h],["$",d,"$$",d.Plugins[h]],1)}}d.convertFuncs(d);d.OS=100;if(b){var g=["Win",1,"Mac",2,"Linux",3,"FreeBSD",4,"iPhone",21.1,"iPod",21.2,"iPad",21.3,"Win.*CE",22.1,"Win.*Mobile",22.2,"Pocket\\s*PC",22.3,"",100];for(h=g.length-2;h>=0;h=h-2){if(g[h]&&new RegExp(g[h],"i").test(b)){d.OS=g[h+1];break}}};d.head=i.getElementsByTagName("head")[0]||i.getElementsByTagName("body")[0]||i.body||null;d.isIE=new Function("return/*@cc_on!@*/!1")();d.verIE=d.isIE&&(/MSIE\s*(\d+\.?\d*)/i).test(l)?parseFloat(RegExp.$1,10):null;d.verIEfull=null;d.docModeIE=null;if(d.isIE){var f,n,c=document.createElement("div");try{c.style.behavior="url(#default#clientcaps)";d.verIEfull=(c.getComponentVersion("{89820200-ECBD-11CF-8B85-00AA005B4383}","componentid")).replace(/,/g,".")}catch(f){}n=parseFloat(d.verIEfull||"0",10);d.docModeIE=i.documentMode||((/back/i).test(i.compatMode||"")?5:n)||d.verIE;d.verIE=n||d.docModeIE};d.ActiveXEnabled=false;if(d.isIE){var h,m=["Msxml2.XMLHTTP","Msxml2.DOMDocument","Microsoft.XMLDOM","ShockwaveFlash.ShockwaveFlash","TDCCtl.TDCCtl","Shell.UIHelper","Scripting.Dictionary","wmplayer.ocx"];for(h=0;h<m.length;h++){if(d.getAXO(m[h])){d.ActiveXEnabled=true;break}}};d.isGecko=(/Gecko/i).test(k)&&(/Gecko\s*\/\s*\d/i).test(l);d.verGecko=d.isGecko?d.formatNum((/rv\s*\:\s*([\.\,\d]+)/i).test(l)?RegExp.$1:"0.9"):null;d.isChrome=(/Chrome\s*\/\s*(\d[\d\.]*)/i).test(l);d.verChrome=d.isChrome?d.formatNum(RegExp.$1):null;d.isSafari=((/Apple/i).test(j)||(!j&&!d.isChrome))&&(/Safari\s*\/\s*(\d[\d\.]*)/i).test(l);d.verSafari=d.isSafari&&(/Version\s*\/\s*(\d[\d\.]*)/i).test(l)?d.formatNum(RegExp.$1):null;d.isOpera=(/Opera\s*[\/]?\s*(\d+\.?\d*)/i).test(l);d.verOpera=d.isOpera&&((/Version\s*\/\s*(\d+\.?\d*)/i).test(l)||1)?parseFloat(RegExp.$1,10):null;d.addWinEvent("load",d.handler(d.runWLfuncs,d))},init:function(d){var c=this,b,d,a={status:-3,plugin:0};if(!c.isString(d)){return a}if(d.length==1){c.getVersionDelimiter=d;return a}d=d.toLowerCase().replace(/\s/g,"");b=c.Plugins[d];if(!b||!b.getVersion){return a}a.plugin=b;if(!c.isDefined(b.installed)){b.installed=null;b.version=null;b.version0=null;b.getVersionDone=null;b.pluginName=d}c.garbage=false;if(c.isIE&&!c.ActiveXEnabled&&d!=="java"){a.status=-2;return a}a.status=1;return a},fPush:function(b,a){var c=this;if(c.isArray(a)&&(c.isFunc(b)||(c.isArray(b)&&b.length>0&&c.isFunc(b[0])))){a.push(b)}},callArray:function(b){var c=this,a;if(c.isArray(b)){for(a=0;a<b.length;a++){if(b[a]===null){return}c.call(b[a]);b[a]=null}}},call:function(c){var b=this,a=b.isArray(c)?c.length:-1;if(a>0&&b.isFunc(c[0])){c[0](b,a>1?c[1]:0,a>2?c[2]:0,a>3?c[3]:0)}else{if(b.isFunc(c)){c(b)}}},getVersionDelimiter:",",$$getVersion:function(a){return function(g,d,c){var e=a.init(g),f,b,h={};if(e.status<0){return null};f=e.plugin;if(f.getVersionDone!=1){f.getVersion(null,d,c);if(f.getVersionDone===null){f.getVersionDone=1}}a.cleanup();b=(f.version||f.version0);b=b?b.replace(a.splitNumRegx,a.getVersionDelimiter):b;return b}},cleanup:function(){var a=this;if(a.garbage&&a.isDefined(window.CollectGarbage)){window.CollectGarbage()}},isActiveXObject:function(d,b){var f=this,a=false,g,c='<object width="1" height="1" style="display:none" '+d.getCodeBaseVersion(b)+">"+d.HTML+f.openTag+"/object>";if(!f.head){return a}f.head.insertBefore(document.createElement("object"),f.head.firstChild);f.head.firstChild.outerHTML=c;try{f.head.firstChild.classid=d.classID}catch(g){}try{if(f.head.firstChild.object){a=true}}catch(g){}try{if(a&&f.head.firstChild.readyState<4){f.garbage=true}}catch(g){}f.head.removeChild(f.head.firstChild);return a},codebaseSearch:function(f,b){var c=this;if(!c.ActiveXEnabled||!f){return null}if(f.BIfuncs&&f.BIfuncs.length&&f.BIfuncs[f.BIfuncs.length-1]!==null){c.callArray(f.BIfuncs)}var d,o=f.SEARCH,k={};if(c.isStrNum(b)){if(o.match&&o.min&&c.compareNums(b,o.min)<=0){return true}if(o.match&&o.max&&c.compareNums(b,o.max)>=0){return false}d=c.isActiveXObject(f,b);if(d&&(!o.min||c.compareNums(b,o.min)>0)){o.min=b}if(!d&&(!o.max||c.compareNums(b,o.max)<0)){o.max=b}return d};var e=[0,0,0,0],l=[].concat(o.digits),a=o.min?1:0,j,i,h,g,m,n=function(p,r){var q=[].concat(e);q[p]=r;return c.isActiveXObject(f,q.join(","))};if(o.max){g=o.max.split(c.splitNumRegx);for(j=0;j<g.length;j++){g[j]=parseInt(g[j],10)}if(g[0]<l[0]){l[0]=g[0]}}if(o.min){m=o.min.split(c.splitNumRegx);for(j=0;j<m.length;j++){m[j]=parseInt(m[j],10)}if(m[0]>e[0]){e[0]=m[0]}}if(m&&g){for(j=1;j<m.length;j++){if(m[j-1]!=g[j-1]){break}if(g[j]<l[j]){l[j]=g[j]}if(m[j]>e[j]){e[j]=m[j]}}}if(o.max){for(j=1;j<l.length;j++){if(g[j]>0&&l[j]==0&&l[j-1]<o.digits[j-1]){l[j-1]+=1;break}}};for(j=0;j<l.length;j++){h={};for(i=0;i<20;i++){if(l[j]-e[j]<1){break}d=Math.round((l[j]+e[j])/2);if(h["a"+d]){break}h["a"+d]=1;if(n(j,d)){e[j]=d;a=1}else{l[j]=d}}l[j]=e[j];if(!a&&n(j,e[j])){a=1};if(!a){break}};return a?e.join(","):null},addWinEvent:function(d,c){var e=this,a=window,b;if(e.isFunc(c)){if(a.addEventListener){a.addEventListener(d,c,false)}else{if(a.attachEvent){a.attachEvent("on"+d,c)}else{b=a["on"+d];a["on"+d]=e.winHandler(c,b)}}}},winHandler:function(d,c){return function(){d();if(typeof c=="function"){c()}}},WLfuncs0:[],WLfuncs:[],runWLfuncs:function(a){var b={};a.winLoaded=true;a.callArray(a.WLfuncs0);a.callArray(a.WLfuncs);if(a.onDoneEmptyDiv){a.onDoneEmptyDiv()}},winLoaded:false,$$onWindowLoaded:function(a){return function(b){if(a.winLoaded){a.call(b)}else{a.fPush(b,a.WLfuncs)}}},div:null,divID:"plugindetect",divWidth:50,pluginSize:1,emptyDiv:function(){var d=this,b,h,c,a,f,g;if(d.div&&d.div.childNodes){for(b=d.div.childNodes.length-1;b>=0;b--){c=d.div.childNodes[b];if(c&&c.childNodes){for(h=c.childNodes.length-1;h>=0;h--){g=c.childNodes[h];try{c.removeChild(g)}catch(f){}}}if(c){try{d.div.removeChild(c)}catch(f){}}}}if(!d.div){a=document.getElementById(d.divID);if(a){d.div=a}}if(d.div&&d.div.parentNode){try{d.div.parentNode.removeChild(d.div)}catch(f){}d.div=null}},DONEfuncs:[],onDoneEmptyDiv:function(){var c=this,a,b;if(!c.winLoaded){return}if(c.WLfuncs&&c.WLfuncs.length&&c.WLfuncs[c.WLfuncs.length-1]!==null){return}for(a in c){b=c[a];if(b&&b.funcs){if(b.OTF==3){return}if(b.funcs.length&&b.funcs[b.funcs.length-1]!==null){return}}}for(a=0;a<c.DONEfuncs.length;a++){c.callArray(c.DONEfuncs)}c.emptyDiv()},getWidth:function(c){if(c){var a=c.scrollWidth||c.offsetWidth,b=this;if(b.isNum(a)){return a}}return -1},getTagStatus:function(m,g,a,b){var c=this,f,k=m.span,l=c.getWidth(k),h=a.span,j=c.getWidth(h),d=g.span,i=c.getWidth(d);if(!k||!h||!d||!c.getDOMobj(m)){return -2}if(j<i||l<0||j<0||i<0||i<=c.pluginSize||c.pluginSize<1){return 0}if(l>=i){return -1}try{if(l==c.pluginSize&&(!c.isIE||c.getDOMobj(m).readyState==4)){if(!m.winLoaded&&c.winLoaded){return 1}if(m.winLoaded&&c.isNum(b)){if(!c.isNum(m.count)){m.count=b}if(b-m.count>=10){return 1}}}}catch(f){}return 0},getDOMobj:function(g,a){var f,d=this,c=g?g.span:0,b=c&&c.firstChild?1:0;try{if(b&&a){d.div.focus()}}catch(f){}return b?c.firstChild:null},setStyle:function(b,g){var f=b.style,a,d,c=this;if(f&&g){for(a=0;a<g.length;a=a+2){try{f[g[a]]=g[a+1]}catch(d){}}}},insertDivInBody:function(i,g){var f,c=this,h="pd33993399",b=null,d=g?window.top.document:window.document,a=d.getElementsByTagName("body")[0]||d.body;if(!a){try{d.write('<div id="'+h+'">.'+c.openTag+"/div>");b=d.getElementById(h)}catch(f){}}a=d.getElementsByTagName("body")[0]||d.body;if(a){a.insertBefore(i,a.firstChild);if(b){a.removeChild(b)}}},insertHTML:function(f,b,g,a,k){var l,m=document,j=this,p,o=m.createElement("span"),n,i;var c=["outlineStyle","none","borderStyle","none","padding","0px","margin","0px","visibility","visible"];var h="outline-style:none;border-style:none;padding:0px;margin:0px;visibility:visible;";if(!j.isDefined(a)){a=""}if(j.isString(f)&&(/[^\s]/).test(f)){f=f.toLowerCase().replace(/\s/g,"");p=j.openTag+f+' width="'+j.pluginSize+'" height="'+j.pluginSize+'" ';p+='style="'+h+'display:inline;" ';for(n=0;n<b.length;n=n+2){if(/[^\s]/.test(b[n+1])){p+=b[n]+'="'+b[n+1]+'" '}}p+=">";for(n=0;n<g.length;n=n+2){if(/[^\s]/.test(g[n+1])){p+=j.openTag+'param name="'+g[n]+'" value="'+g[n+1]+'" />'}}p+=a+j.openTag+"/"+f+">"}else{p=a}if(!j.div){i=m.getElementById(j.divID);if(i){j.div=i}else{j.div=m.createElement("div");j.div.id=j.divID}j.setStyle(j.div,c.concat(["width",j.divWidth+"px","height",(j.pluginSize+3)+"px","fontSize",(j.pluginSize+3)+"px","lineHeight",(j.pluginSize+3)+"px","verticalAlign","baseline","display","block"]));if(!i){j.setStyle(j.div,["position","absolute","right","0px","top","0px"]);j.insertDivInBody(j.div)}}if(j.div&&j.div.parentNode){j.setStyle(o,c.concat(["fontSize",(j.pluginSize+3)+"px","lineHeight",(j.pluginSize+3)+"px","verticalAlign","baseline","display","inline"]));try{o.innerHTML=p}catch(l){};try{j.div.appendChild(o)}catch(l){};return{span:o,winLoaded:j.winLoaded,tagName:f,outerHTML:p}}return{span:null,winLoaded:j.winLoaded,tagName:"",outerHTML:p}},Plugins:{quicktime:{mimeType:["video/quicktime","application/x-quicktimeplayer","image/x-macpaint","image/x-quicktime"],progID:"QuickTimeCheckObject.QuickTimeCheck.1",progID0:"QuickTime.QuickTime",classID:"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B",minIEver:7,HTML:'<param name="src" value="" /><param name="controller" value="false" />',getCodeBaseVersion:function(a){return'codebase="#version='+a+'"'},SEARCH:{min:0,max:0,match:0,digits:[16,128,128,0]},getVersion:function(c){var f=this,d=f.$,a=null,e=null,b;if(!d.isIE){if(d.hasMimeType(f.mimeType)){e=d.OS!=3?d.findNavPlugin("QuickTime.*Plug-?in",0):null;if(e&&e.name){a=d.getNum(e.name)}}}else{if(d.isStrNum(c)){b=c.split(d.splitNumRegx);if(b.length>3&&parseInt(b[3],10)>0){b[3]="9999"}c=b.join(",")}if(d.isStrNum(c)&&d.verIE>=f.minIEver&&f.canUseIsMin()>0){f.installed=f.isMin(c);f.getVersionDone=0;return}f.getVersionDone=1;if(!a&&d.verIE>=f.minIEver){a=f.CDBASE2VER(d.codebaseSearch(f))}if(!a){e=d.getAXO(f.progID);if(e&&e.QuickTimeVersion){a=e.QuickTimeVersion.toString(16);a=parseInt(a.charAt(0),16)+"."+parseInt(a.charAt(1),16)+"."+parseInt(a.charAt(2),16)}}}f.installed=a?1:(e?0:-1);f.version=d.formatNum(a,3)},cdbaseUpper:["7,60,0,0","0,0,0,0"],cdbaseLower:["7,50,0,0",null],cdbase2ver:[function(c,b){var a=b.split(c.$.splitNumRegx);return[a[0],a[1].charAt(0),a[1].charAt(1),a[2]].join(",")},null],CDBASE2VER:function(f){var e=this,c=e.$,b,a=e.cdbaseUpper,d=e.cdbaseLower;if(f){f=c.formatNum(f);for(b=0;b<a.length;b++){if(a[b]&&c.compareNums(f,a[b])<0&&d[b]&&c.compareNums(f,d[b])>=0&&e.cdbase2ver[b]){return e.cdbase2ver[b](e,f)}}}return f},canUseIsMin:function(){var f=this,d=f.$,b,c=f.canUseIsMin,a=f.cdbaseUpper,e=f.cdbaseLower;if(!c.value){c.value=-1;for(b=0;b<a.length;b++){if(a[b]&&d.codebaseSearch(f,a[b])){c.value=1;break}if(e[b]&&d.codebaseSearch(f,e[b])){c.value=-1;break}}}f.SEARCH.match=c.value==1?1:0;return c.value},isMin:function(c){var b=this,a=b.$;return a.codebaseSearch(b,c)?0.7:-1}},flash:{mimeType:"application/x-shockwave-flash",progID:"ShockwaveFlash.ShockwaveFlash",classID:"clsid:D27CDB6E-AE6D-11CF-96B8-444553540000",getVersion:function(){var b=function(i){if(!i){return null}var e=/[\d][\d\,\.\s]*[rRdD]{0,1}[\d\,]*/.exec(i);return e?e[0].replace(/[rRdD\.]/g,",").replace(/\s/g,""):null};var j=this,g=j.$,k,h,l=null,c=null,a=null,f,m,d;if(!g.isIE){m=g.hasMimeType(j.mimeType);if(m){f=g.getDOMobj(g.insertHTML("object",["type",j.mimeType],[],"",j));try{l=g.getNum(f.GetVariable("$version"))}catch(k){}}if(!l){d=m?m.enabledPlugin:null;if(d&&d.description){l=b(d.description)}if(l){l=g.getPluginFileVersion(d,l)}}}else{for(h=15;h>2;h--){c=g.getAXO(j.progID+"."+h);if(c){a=h.toString();break}}if(!c){c=g.getAXO(j.progID)}if(a=="6"){try{c.AllowScriptAccess="always"}catch(k){return"6,0,21,0"}}try{l=b(c.GetVariable("$version"))}catch(k){}if(!l&&a){l=a}}j.installed=l?1:-1;j.version=g.formatNum(l);return true}},shockwave:{mimeType:"application/x-director",progID:"SWCtl.SWCtl",classID:"clsid:166B1BCA-3F9C-11CF-8075-444553540000",getVersion:function(){var a=null,b=null,g,f,d=this,c=d.$;if(!c.isIE){f=c.findNavPlugin("Shockwave\\s*for\\s*Director");if(f&&f.description&&c.hasMimeType(d.mimeType)){a=c.getNum(f.description)}if(a){a=c.getPluginFileVersion(f,a)}}else{try{b=c.getAXO(d.progID).ShockwaveVersion("")}catch(g){}if(c.isString(b)&&b.length>0){a=c.getNum(b)}else{if(c.getAXO(d.progID+".8")){a="8"}else{if(c.getAXO(d.progID+".7")){a="7"}else{if(c.getAXO(d.progID+".1")){a="6"}}}}}d.installed=a?1:-1;d.version=c.formatNum(a)}},zz:0}};PluginDetect.initScript();

	var gArgCountErr='The "%%" function requires an even number of arguments.\nArguments should be in the form "atttributeName", "attributeValue", ...',gTagAttrs=null,gQTGeneratorVersion=1;function AC_QuickTimeVersion(){return gQTGeneratorVersion}function _QTComplain(a,b){b=b.replace("%%",a);alert(b)}function _QTAddAttribute(a,b,c){var d;d=gTagAttrs[a+b];null==d&&(d=gTagAttrs[b]);return null!=d?(0==b.indexOf(a)&&null==c&&(c=b.substring(a.length)),null==c&&(c=b),c+'="'+d+'" '):""}function _QTAddObjectAttr(a,b){if(0==a.indexOf("emb#"))return"";0==a.indexOf("obj#")&&null==b&&(b=a.substring(4));return _QTAddAttribute("obj#",a,b)}function _QTAddEmbedAttr(a,b){if(0==a.indexOf("obj#"))return"";0==a.indexOf("emb#")&&null==b&&(b=a.substring(4));return _QTAddAttribute("emb#",a,b)}function _QTAddObjectParam(a,b){var c,d="",e=b?" />":">";-1==a.indexOf("emb#")&&(c=gTagAttrs["obj#"+a],null==c&&(c=gTagAttrs[a]),0==a.indexOf("obj#")&&(a=a.substring(4)),null!=c&&(d='  <param name="'+a+'" value="'+c+'"'+e+"\n"));return d}function _QTDeleteTagAttrs(){for(var a=0;a<arguments.length;a++){var b=arguments[a];delete gTagAttrs[b];delete gTagAttrs["emb#"+b];delete gTagAttrs["obj#"+b]}}function _QTGenerate(a,b,c){if(4>c.length||0!=c.length%2)return _QTComplain(a,gArgCountErr),"";gTagAttrs=[];gTagAttrs.src=c[0];gTagAttrs.width=c[1];gTagAttrs.height=c[2];gTagAttrs.classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B";gTagAttrs.pluginspage="http://www.apple.com/quicktime/download/";a=c[3];if(null==a||""==a)a="6,0,2,0";gTagAttrs.codebase="http://www.apple.com/qtactivex/qtplugin.cab#version="+a;for(var d,e=4;e<c.length;e+=2)d=c[e].toLowerCase(),a=c[e+1],"name"==d||"id"==d?gTagAttrs.name=a:gTagAttrs[d]=a;c="<object "+_QTAddObjectAttr("classid")+_QTAddObjectAttr("width")+_QTAddObjectAttr("height")+_QTAddObjectAttr("codebase")+_QTAddObjectAttr("name","id")+_QTAddObjectAttr("tabindex")+_QTAddObjectAttr("hspace")+_QTAddObjectAttr("vspace")+_QTAddObjectAttr("border")+_QTAddObjectAttr("align")+_QTAddObjectAttr("class")+_QTAddObjectAttr("title")+_QTAddObjectAttr("accesskey")+_QTAddObjectAttr("noexternaldata")+">\n"+_QTAddObjectParam("src",b);e="  <embed "+_QTAddEmbedAttr("src")+_QTAddEmbedAttr("width")+_QTAddEmbedAttr("height")+_QTAddEmbedAttr("pluginspage")+_QTAddEmbedAttr("name")+_QTAddEmbedAttr("align")+_QTAddEmbedAttr("tabindex");_QTDeleteTagAttrs("src","width","height","pluginspage","classid","codebase","name","tabindex","hspace","vspace","border","align","noexternaldata","class","title","accesskey");for(d in gTagAttrs)a=gTagAttrs[d],null!=a&&(e+=_QTAddEmbedAttr(d),c+=_QTAddObjectParam(d,b));return c+e+"> </embed>\n</object>"}function QT_GenerateOBJECTText(){return _QTGenerate("QT_GenerateOBJECTText",!1,arguments)};
})(jQuery, this);