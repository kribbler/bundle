/**
 * This is the script for the content slider - it slides between different slides with
 * different animation. Each slide is composed of two sections and each of this section
 * is animated in a random effect.
 *
 * Dependencies:
 * - jQuery
 * - jQuery Easing : http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * @author Pexeto
 * http://pexetothemes.com
 */
(function($) {
	$.fn.pexetoContentSlider = function(options) {
		var defaults = {
			//set the default options (can be overwritten from the calling function)
			autoplay          : true,
			animationInterval : 3000,
			//the interval between each animation when autoplay is true
			pauseOnHover      : true,
			//if true the animation will be paused when the mouse is
			// over the slider
			pauseInterval     : 5000,
			//the time that the animation will be paused after a click
			animationSpeed    : 400,
			easing            : 'easeOutSine',
			buttons           : true,
			//show the navigation buttons
			arrows            : true,
			//show the navigation arrows
			//selectors, classes and IDs
			ulSel             : '#cs-slider-ul',
			navigationId      : 'cs-navigation',
			selectedClass     : 'selected',
			firstBoxSel       : '.cs-content-left',
			secondBoxSel      : '.cs-content-right',
			prevArrowClass    : 'cs-arrows cs-prev-arrow',
			nextArrowClass    : 'cs-arrows cs-next-arrow',
			loadingClass      : 'cs-loading'
		};


		var o            = $.extend(defaults, options),
			$root        = null,
			$ul          = null,
			$nav         = null,
			$navLi       = null,
			$prevArrow   = null,
			$nextArrow   = null,
			itemNum      = 0,
			currentIndex = 0,
			timer        = 0,
			stopped      = true,
			inAnimation  = false,

			//available effects: slideLeft, slideRight, slideDown, slideUp, 
			//fadeIn (for showing only), fadeOut (for hiding only)
			//in showEffects and hideEffects arrays you can add pairs of animations - 
			//each animation should be an array in which the first element sets 
			//the first box animation and the second element sets the second box animation
			showEffects = [
				['slideLeft', 'slideLeft'],
				['slideRight', 'slideRight'],
				['slideDown', 'slideDown'],
				['slideUp', 'slideUp']
			],
			hideEffects = [
				['fadeOut', 'fadeOut']
			],
			showEffectNum = showEffects.length,
			hideEffectNum = hideEffects.length,
			slides = [];

		$root = $(this);
		$ul = $(o.ulSel);

		/**
		 * Inits the slider - calls the main functionality.
		 */

		function init() {

			$root.addClass(o.loadingClass);

			//get the items number
			itemNum = $ul.find('li').each(function(i) {

				slides[i] = {
					firstBox: $(this).find(o.firstBoxSel),
					secondBox: $(this).find(o.secondBoxSel)
				};
				if(i === 0) {
					$(this).find('img').pexetoOnImgLoaded({
						callback: function() {
							$root.removeClass(o.loadingClass);
							showSlide(0);
						}
					});
				}
			}).length;

			if(itemNum<=1){
				o.buttons=false;
				o.arrows=false;
				o.autoplay=false;
			}

			$ul.find('li img').pexetoOnImgLoaded({
				callback: function() {
					//set the navigation buttons
					setNavigation();
					bindEventHandlers();

					//the images are loaded, start the animation
					if(o.autoplay) {
						startAnimation();
					}

				}
			});

		}

		/**
		 * Binds event handlers for the main slider functionality.
		 */

		function bindEventHandlers() {

			if(o.buttons) {
				//add event handlers
				$nav.on({
					'click': doOnBtnClick,
					'slideChanged': doOnSlideChanged
				}, 'li');

			}

			if(o.arrows) {
				$prevArrow.on('click', function() {
					doOnArrowClick(false);
				});
				$nextArrow.on('click', function() {
					doOnArrowClick(true);
				});
			}



			//display/hide the navigation on $root hover
			$root.on({
				'mouseenter': doOnSliderMouseEnter,
				'mouseleave': doOnSliderMouseLeave
			});

			$(window).on('resize', function(){
				serSliderHeight(currentIndex);
			});
		}

		/**
		 * Calls the functionality to change the current slide with another one.
		 * @param  {int} index the index of the new slide
		 */

		function changeSlide(index) {
			if(!inAnimation) {
				inAnimation = true;
				hideSlide(currentIndex);
				showSlide(index);

				currentIndex = index;

				if(o.buttons) {
					$navLi.trigger('slideChanged');
				}
			}
		}


		/**
		 * Adds navigation buttons to the slider and sets event handler functions to them.
		 */

		function setNavigation() {
			var i, html = '';

			//generate the buttons
			if(o.buttons) {
				$nav = $('<ul />', {
					id: o.navigationId
				});
				for(i = 0; i < itemNum; i++) {
					html += '<li><span></span></li>';
				}
				$nav.html(html).appendTo($root).fadeIn(700);

				$navLi = $nav.find('li');
				$navLi.eq(0).addClass(o.selectedClass);
			}

			//generate the arrows
			if(o.arrows) {
				$prevArrow = $('<div />', {
					'class': o.prevArrowClass
				}).appendTo($root);
				$nextArrow = $('<div />', {
					'class': o.nextArrowClass
				}).appendTo($root);
			}

		}

		/***********************************************************************
		 * EVENT HANDLER FUNCTIONS
		 **********************************************************************/

		/**
		 * On arrow click event handler. Calls a function to change the slide
		 * depending on which arrow (previous/next) was clicked.
		 * @param  {boolean} next whether the next arrow is clicked (set it to true)
		 * or the previous one was cicked (set it to false)
		 */

		function doOnArrowClick(next) {
			var index;
			if(next) {
				//next index will be the next item if there is one or the first item
				index = currentIndex + 1 < itemNum ? currentIndex + 1 : 0;
			} else {
				//previous index will be the previous item if there is one or the last item
				index = currentIndex - 1 >= 0 ? currentIndex - 1 : itemNum - 1;
			}
			if(!inAnimation) {
				pause();
			}
			changeSlide(index);
		}

		/**
		 * On slider mouse enter event handler.
		 */

		function doOnSliderMouseEnter() {
			if(o.buttons) {
				//show the buttons
				$nav.stop().fadeIn(function() {
					$nav.animate({
						opacity: 1
					}, 0);
				});
			}

			if(o.autoplay && o.pauseOnHover) {
				//pause the animation
				stopAnimation();
			}
		}

		/**
		 * On slider mouse leave event handler.
		 */

		function doOnSliderMouseLeave() {
			if(o.buttons) {
				//hide the buttons
				$nav.stop().animate({
					opacity: 0
				});
			}

			if(o.autoplay && o.pauseOnHover) {
				//resume the animation
				startAnimation();
			}
		}

		/**
		 * On navigation button click event handler. Calls the functionality
		 * to show the slide that corresponds to the button index.
		 * @param  {object} e the event object
		 */

		function doOnBtnClick(e) {
			e.stopPropagation();
			var index = $navLi.index($(this));
			if(!inAnimation) {
				pause();
			}
			if(currentIndex !== index) {
				changeSlide(index);
			}
		}

		/**
		 * On slider change event handler. Sets the current button in the navigation
		 * to be selected according to the current slide index.
		 */

		function doOnSlideChanged() {
			var index = $navLi.index($(this));
			if(currentIndex === index) {
				$(this).addClass(o.selectedClass);
			} else {
				$(this).removeClass(o.selectedClass);
			}
		}

		/***************************************************************************
		 * ANIMATION FUNCTIONS
		 **************************************************************************/

		/**
		 * Hides a slide with a random animation.
		 * @param {int} index the index of the slide to be displayed
		 */

		function hideSlide(index) {

			var animation = hideEffects[Math.floor(Math.random() * hideEffectNum)],
				firstBoxPos = positioner.getHidePositionParameters(animation[0]),
				secondBoxPos = positioner.getHidePositionParameters(animation[1]),
				$firstBox = slides[index].firstBox,
				$secondBox = slides[index].secondBox;


			//animate the first box
			$firstBox.animate(firstBoxPos, o.animationSpeed, function() {
				$firstBox.hide();
			});
			//animate the second box
			$secondBox.animate(secondBoxPos, o.animationSpeed, function() {
				$secondBox.hide();
			});

		}

		/**
		 * Displays a slide with a random animation.
		 * @param {int} index the index of the slide to be displayed
		 */

		function showSlide(index) {
			var animation = showEffects[Math.floor(Math.random() * showEffectNum)],
				//get a random effect
				firstBoxPos = positioner.getDisplayPositionParameters(animation[0], true),
				secondBoxPos = positioner.getDisplayPositionParameters(animation[1], false),
				$firstBox = slides[index].firstBox,
				$secondBox = slides[index].secondBox;

			$firstBox.show();
			$secondBox.show();

			serSliderHeight(index);
			

			//animate the first box (with a small delay)
			setTimeout(function() {
				$firstBox.css(firstBoxPos.initialPosition).animate(firstBoxPos.endPosition, o.animationSpeed + 100, setEndAnimation);
			}, o.animationSpeed / 2 + 100);

			//animate the second box
			$secondBox.css(secondBoxPos.initialPosition).animate(secondBoxPos.endPosition, o.animationSpeed, o.easing);

		}

		function serSliderHeight(index){

			var $firstBox = slides[index].firstBox,
				$secondBox = slides[index].secondBox,
				oneColumn = $firstBox.width() === $firstBox.parent().width();
				sliderHeight = 0;

				if(oneColumn){
					sliderHeight = $firstBox.height() + $secondBox.height();
				}else{
					sliderHeight = Math.max($firstBox.height(), $secondBox.height());
				}

			$ul.stop().animate({
				height: sliderHeight
			});
		}


		/**
		 * Starts the animation.
		 */

		function startAnimation() {
			if(o.autoplay && stopped) {
				stopped = false;
				timer = window.setInterval(callNextSlide, o.animationInterval);
			}
		}

		/**
		 * Sets the inAnimation variable to false.
		 */

		function setEndAnimation() {
			inAnimation = false;
		}

		/**
		 * Triggers a changeSlide event to display the next slide.
		 */

		function callNextSlide() {
			var nextIndex = (currentIndex < itemNum - 1) ? (currentIndex + 1) : 0;
			changeSlide(nextIndex);
		}

		/**
		 * Stops the animation.
		 */

		function stopAnimation() {
			if(o.autoplay) {
				window.clearInterval(timer);
				timer = -1;
				stopped = true;
			}
		}

		/**
		 * Pauses the animation.
		 */

		function pause() {
			if(o.autoplay) {
				window.clearInterval(timer);
				timer = -1;
				if(!stopped) {
					window.setTimeout(startAnimation, o.pauseInterval);
				}
				stopped = true;
			}
		}


		/***************************************************************************
		 * HELPER OBJECTS AND FUNCTIONS
		 **************************************************************************/


		var positioner = {
			/**
			 * Gets the positioning(styling) parameters for a 'display' animation.
			 * @param {string} animation the name of the animation. If there is no
			 * animation with the name specified will return fade-in animation parameters.
			 * @param {boolean} firstBox sets if it is the first box (when set to true) or not.
			 * When it is the first box, the animation parameters are a bit different.
			 * @return an object literal containing the inital
			 * (how the object should be positioned initially) and end (how the object should be
			 * positioned in the end of the animation) positioning parameters.
			 */
			getDisplayPositionParameters: function(animation, firstBox) {
				var pos = {
					initialPosition: {
						top: 0,
						left: 0,
						opacity: 0
					},
					endPosition: {
						opacity: 1,
						zIndex : 10
					}
				},
					initialLeft = firstBox ? 50 : 400,
					initialTop = firstBox ? 50 : 400;

				switch(animation) {
				case 'slideUp':
					pos.initialPosition.top = initialTop;
					pos.endPosition.top = 0;
					break;
				case 'slideDown':
					pos.initialPosition.top = -initialTop;
					pos.endPosition.top = 0;
					break;
				case 'slideRight':
					pos.initialPosition.left = -initialLeft;
					pos.endPosition.left = 0;
					break;
				case 'slideLeft':
					pos.initialPosition.left = initialLeft;
					pos.endPosition.left = 0;
					break;
				}

				return pos;
			},

			/**
			 * Gets the positioning(styling) parameters for a 'hide' animation.
			 * @param animation the name of the animation. If there is no animation
			 * with the name specified will return fade-out animation parameters.
			 * @return an object literal containing the end parameters for the
			 * hiding animation
			 */
			getHidePositionParameters: function(animation) {
				var pos = {
					opacity: 0,
					zIndex:0
				};

				switch(animation) {
				case 'slideUp':
					pos.top = -400;
					break;
				case 'slideDown':
					pos.top = 400;
					break;
				case 'slideRight':
					pos.left = 400;
					break;
				case 'slideLeft':
					pos.left = -400;
					break;
				}

				return pos;
			}
		};


		init();

	};

}(jQuery));