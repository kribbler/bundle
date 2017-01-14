/**
 * Pexeto Zoom Thumbnail Slider
 * Dependencies: jQuery (http://jquery.com/),
 * 				Mousewheel (http://brandonaaron.net/code/mousewheel/docs),
 *				pexetoOnImgLoaded,
 *				jQuery Easing (http://gsgd.co.uk/sandbox/jquery/easing/)
 *
 * @author Pexeto
 * http://pexetothemes.com
 */
(function ($) {
	$.fn.pexetoThumbnailSlider = function (options) {
		var defaults      = {
			thumbWidth        : 90,
			thumbHeight       : 60,
			thumbSpace        : 10,
			thumbPadding      : 4,
			sliderWidth       : 850,
			parentWidth       : 980,
			sliderHeight      : 400,
			easing            : 'swing',
			pauseOnHover      : true,
			slideSpeed        : 400,
			thumbnailsPerPage : 4,
			autoplay          : true,
			animationInterval : 3000,
			animationSpeed    : 800,
			windowMargin      : 20,
			thumbnailStep     : 2,
			//when paginating the thumbnails, the number of thumbnails to slide trough
			
			//selectors and classes
			thumbContainerSel : '.ts-thumbnail-container',
			thumbWindowSel    : '.ts-thumbnail-window',
			imgComtainerSel   : '.ts-image-container',
			thumbWrapperSel   : '.ts-thumbnail-wrapper',
			thumbHolderSel    : 'li',
			descClass         : 'ts-desc',
			selectedClass     : 'selected'
		},  
		o                    = $.extend(defaults, options),
		$root                = $(this).addClass('loading'),
		$imageContainer      = $root.find(o.imgComtainerSel),
		$images              = $imageContainer.find('img'),
		images               = [],
		$thumbWrapper        = $(o.thumbWrapperSel),
		$thumbContainer      = $thumbWrapper.find(o.thumbContainerSel + ':first'),
		$thumbHolders        = $thumbWrapper.find(o.thumbHolderSel),
		$thumbWindow         = $thumbWrapper.find(o.thumbWindowSel),
		currentImage         = -1,
		inAnimation          = false,
		thumbInAnimation     = false,
		thumbContainerHeight = 0,
		thumbnailsPerPage    = o.thumbnailsPerPage,
		thumbHeight          = o.thumbHeight,
		sliderHeight         = o.sliderHeight,
		currentThumbnail     = 0,
		firstThumbnail       = 0,
		itemNum              = $images.length,
		timer                = -1,
		$prevArrow           = null,
		$nextArrow           = null,
		pageNum              = 0,
		rootHovered          = false,
		$description         = null;


		/**
		 * Inits the main functionality - calls all the functions.
		 */
		function init() {
			//display the slider images
			$root.removeClass('loading');
			$thumbHolders.css({
				visibility: 'visible'
			});

			//add the description element
			$description = $('<div />', {'class':o.descClass}).appendTo($imageContainer);

			setThumbnailsPerPage();

			setThumbnailNavigation();
			bindThumbnailEventHandlers();

			setSliderSize();
			setImages();

			//show the first image
			animateImage(0);

			//start the animation 
			if(o.autoplay) {
				startAutoplay();

				if(o.pauseOnHover) {
					setPauseFunctionality();
				}
			}

			

		}

		/**
		 * Hides all the images except the first one and after that loads all the images 
		 * into an array for later usage.
		 */
		function setImages() {
			$images.each(function (i) {
				var $img = $(this).css({
					visibility: 'visible'
				});
				if(i !== 0) {
					$img.css({
						opacity: 0
					});
				}
				images[i] = $img;
			});
		}



		/**
		 * Animates the new image to be displayed.
		 * @param  {int} index the index of the image to be displayed
		 */
		function animateImage(index) {
			if(!inAnimation) {
				$thumbContainer.trigger('slideChange', [currentImage, index]);
				var $image = images[index],
					curImage = images[currentImage],
					desc = $image.attr('title');

				if(index !== currentImage) {
					inAnimation = true;
					if(curImage) {
						curImage.css({
							zIndex: 0
						});
					}
					currentImage = index;

					//fade the image holder in
					$image.css({
						zIndex: 10
					}).show().animate({
						opacity: 1
					}, o.animationSpeed, function () {
						inAnimation = false;
						if(curImage) {
							curImage.css({
								opacity: 0
							}).hide();
						}
					});

					//show the description
					if(desc){
						$description.hide().html(desc).animate({height:'show'});
						// .show('slide', {direction:'right'});
					}else{
						if($description.is(':visible')){
							$description.fadeOut();
						}
					}
				}
			}
		}

		/**
		 * Calls the functionality for the next image to be displayed.
		 */
		function showNextImage() {
			var index = currentImage === (itemNum - 1) ? 0 : (currentImage + 1);
			animateImage(index);
		}

		/**
		 * Creates navigations arrows and appends them to the thumbnail container.
		 */
		function setThumbnailNavigation() {

			//previous arrow
			$prevArrow = $('<div />', {
				'class': 'prev-arrow hover'
			}).bind({
				'click': function () {
					$thumbContainer.trigger('pageChange', [{step:-o.thumbnailStep}]);
				}
			}).appendTo($thumbWrapper);

			//next arrow
			$nextArrow = $('<div />', {
				'class': 'next-arrow hover'
			}).bind({
				'click': function () {
					$thumbContainer.trigger('pageChange', [{step:o.thumbnailStep}]);
				}
			}).appendTo($thumbWrapper);

			setArrowVisibility();
		}

		function setArrowVisibility(){
			setThumbnailsPerPage();
			if(thumbnailsPerPage<itemNum){
				$prevArrow.show();
				$nextArrow.show();
			}else{
				$prevArrow.hide();
				$nextArrow.hide();
			}
		}

		/**
		 * Calculates thenumber of thumbnails that can be fit into the visible 
		 * thumbnail window section.
		 */
		function setThumbnailsPerPage() {
			thumbnailsPerPage = Math.floor((sliderHeight - o.windowMargin - o.thumbSpace) / (thumbHeight + o.thumbSpace + 2*o.thumbPadding));

			//calculate the number of the pages the thumbnails are separated into
			pageNum = Math.floor(itemNum / thumbnailsPerPage);
			itemNum % thumbnailsPerPage && pageNum++;
		}

		/**
		 * Binds event handlers to the thumbnail section.
		 */
		function bindThumbnailEventHandlers() {

			$thumbContainer.on({'slideChange' : function (event, curIndex, newIndex) {
					//the image displayed has been changed
					showSelectedThumbnail(curIndex, newIndex);
				}, 'pageChange' : function(event, args){
					changeThumbnailPage(args);
				}, 'mousewheel' : function(event, delta){
					event.preventDefault();
					if(thumbnailsPerPage<itemNum){
						var step = delta < 0 ? o.thumbnailStep : -o.thumbnailStep;
						$thumbContainer.trigger('pageChange', [{step:step}]);
					}
				}
			}).on('click', o.thumbHolderSel, function(){
				//show the selected image
				animateImage($(this).index());
				if(o.autoplay) {
					window.clearInterval(timer);
					startAutoplay();
				}
			});

			$thumbContainer.touchwipe({
				wipeUp: function () {
					$thumbContainer.trigger('pageChange', [{step:-o.thumbnailStep}]);
				},
				wipeDown: function () {
					$thumbContainer.trigger('pageChange', [{step:o.thumbnailStep}]);
				}
			});

			$(window).on('resize', function(){
				setSliderSize();
				setArrowVisibility();
			});
		}


		/**
		 * Shows the current image's relevant thumbnail and makes it selected.
		 * @param  {int} curIndex the index of the current image
		 * @param  {int} newIndex the index of the new selected image
		 */
		function showSelectedThumbnail(curIndex, newIndex){
			if(itemNum > thumbnailsPerPage) {
				//trigger the thumbnail page change if the new thumbnail is 
				//located on a different page
				if(newIndex < currentThumbnail) {
					var args = {};
					if(newIndex===0){
						args.margin = 0;
					}else{
						args.step = -(currentThumbnail - newIndex);
					}
					$thumbContainer.trigger('pageChange', [args]);
				} else if(newIndex >= currentThumbnail + thumbnailsPerPage) {
					$thumbContainer.trigger('pageChange', [{step: o.thumbnailStep}]);
				}
			}

			$thumbHolders.eq(curIndex).removeClass(o.selectedClass);
			$thumbHolders.eq(newIndex).addClass(o.selectedClass);
		}

		/**
		 * Changes the current thumbnail page - moves the thumbnail container 
		 * down or up.
		 * @param  {int} step the step of the movement - the number of 
		 * thumbnails to move down or up
		 */
		function changeThumbnailPage(args){
			var margin = args.margin || 0,
				step = args.step || null,
				up = false;

			if(!thumbInAnimation) {
				if(step && step > 0) {
					//move up
					
					if(currentThumbnail+1+thumbnailsPerPage>itemNum){
						return;
					}
					
					if(currentThumbnail + step + thumbnailsPerPage > itemNum) {
						step = itemNum - (currentThumbnail + thumbnailsPerPage);
					}

					//calculate the distance to move the thumbnail container
					margin = step * (thumbHeight + o.thumbSpace + 2*o.thumbPadding) - 1;
					up=true;
					
				} else if(step && step < 0) {
					//move down
					if(currentThumbnail !== 0) {
						if(currentThumbnail + step <= 0) {
							step = -currentThumbnail;
						}

						//calculate the distance to move the thumbnail container
						margin = Math.abs(step * (thumbHeight + o.thumbSpace + 2*o.thumbPadding)) - 1;
					}
				}

				moveThumbContainer(step, margin, up);
			}
		}

		/**
		 * Moves the thumbnail container up or down.
		 * @param  {int}     step   the number of thumbnails that will be moved
		 * @param  {int}     margin the distance to move
		 * @param  {boolean} up     whether to move the container up or down 
		 */
		function moveThumbContainer(step, margin, up){
			var marginTop = 0;
			if(step){
				marginTop = up ? '-='+margin : '+='+margin;
			}

			if(step<0 && currentThumbnail+step<0){
				return;
			}
			

			thumbInAnimation = true;

			$thumbContainer.animate({
				marginTop: [marginTop, o.easing]
			}, o.slideSpeed, function () {
				thumbInAnimation = false;
				if(step){
					currentThumbnail += step;
					firstThumbnail += step;
				}else{
					currentThumbnail = 0;
					firstThumbnail = 0;
				}
				
			});
		}

		/**
		 * Sets the slider size and the size of some elements inside the slider 
		 * according to the parent size.
		 */
		function setSliderSize() {
			var curParentWidth = $root.parent().width(),
				changed = false,
				thumbImgWidth = 0,
				thumbMargin = 0;

			if(o.parentWidth != curParentWidth) {
				//the current parent width is different than the default slider width
				sliderHeight = o.sliderHeight * curParentWidth / o.parentWidth;
				thumbImgWidth = parseInt($thumbHolders.eq(0).find('img').css('width'), 10);
				thumbHeight = thumbImgWidth * o.thumbHeight / o.thumbWidth;
				changed = true;
			} else if(sliderHeight != o.sliderHeight) {
				//reset the default sizes
				sliderHeight = o.sliderHeight;
				thumbHeight = o.thumbHeight;
				changed = true;
			}

			if(changed) {
				//the slider size is changed
				
				$root.css({
					height: sliderHeight
				});
				$imageContainer.css({
					height: sliderHeight
				});
				$thumbWindow.css({
					height: (sliderHeight - 2 * o.windowMargin)
				});
				thumbMargin = -firstThumbnail * (thumbHeight + o.thumbPadding + o.thumbSpace);
				$thumbContainer.css({
					marginTop: thumbMargin
				});
				setThumbnailsPerPage();
			}
		}

		/**
		 * Inits the pause on hover functionality. When the slider is hovered 
		 * and the autoplay is enabled, stops the animation. When the mouse 
		 * leaves the slider, the animation is resumed.
		 */
		function setPauseFunctionality() {
			$root.on({
				'mouseenter': function () {
					rootHovered = true;
					window.clearInterval(timer);
					timer = -1;
				},
				'mouseleave': function () {
					rootHovered = false;
					if(o.autoplay) {
						startAutoplay();
					}
				}
			});
		}

		/**
		 * Starts the autoplay functionality.
		 */
		function startAutoplay() {
			if(!rootHovered) {
				timer = window.setInterval(showNextImage, o.animationInterval);
			}
		}

		//init the slider when all the images are loaded
		$root.find('img').pexetoOnImgLoaded({
			callback: init
		});

	};
}(jQuery));
