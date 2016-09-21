var resized = false;
var unloadedImagery = [];
var unloadedImageryTimeout = false;

$(function() {

	setUpSlides()
	var allImages = {}

	slideCount = 0;
	var caption;

	// var slideRotate = $(document).find('.slide-container');
	//  	slideRotate.each(function() {
	//  		activeSlider = $(this);
	// 	 		setInterval(function(){
	// 		    changeSlides(activeSlider, 1);
	// 	 	}, 5000)
	//  })

	$('.slide-container a').on('click', function(e) {
		
		e.preventDefault();
		e.defaultPrevented;
			activeSlider = $(this).parent();
			var direction = $(this).hasClass('prev') ? -1 : 1;
			changeSlides(activeSlider, direction)
	})

	$(window).resize(function() {
		resized = true;
		hero = false;
		setUpSlides(resized, hero);
	})

});

$(".smallImage img").one('load', function(){
            var me = $(this);
            if ($(me).hasClass("js-getrealsize")) {
                getIMGrealsize(me);
            }
 })

function setUpSlides(resized, hero) {
	$(document).find('.slide-container').each(function() {
		var mainContainer = $(this);
		var slideCount = 0;
		var slideIndex = $(this).find('.current').index();
		$(this).children('ul').addClass('slides-container')
		$(this).find('li').each(function() {
			slideCount++;
		})
		
		if(!resized) {
			$(this).append('<a href="#" class="prev cssAnime"><span>Prev</span</a><a href="#" class="next cssAnime"><span>Next</span></a><div class="slide-count"></div>');

			//if($(this).attr('data-hero') ) {  
				var caption = $(this).find('li.current').attr('data-caption'); 
				$(this).append('<div class="slide-caption"> '+ caption +' </div>')
			//}
		}

		$(this).find('img').each(function() {
			if ( !positionSlideImage($(this),mainContainer) ) {
				clearTimeout(unloadedImageryTimeout);
				unloadedImageryTimeout = setTimeout(function() {
					setUpSlides(true);
				},200);
			}
		});
		
		mainContainer.find('.slide-count').html(slideIndex+1 + ' of ' + slideCount)
	});
}

function positionSlideImage(img,mainContainer) {
	activeImage = img;
	
	if ( activeImage.height() <= 50 ) {
		unloadedImagery.push(activeImage);
		return false;
	}
	
	imgRatio =  activeImage.height() / activeImage.width();
	height = activeImage.height();
	width = activeImage.width();
	height = activeImage.width() * imgRatio;
	imgWidth = mainContainer.height() <= mainContainer.width()*imgRatio ? mainContainer.width() : ((mainContainer.height() - (mainContainer.width()*imgRatio)) / imgRatio) + mainContainer.width();
	positionX =mainContainer.height() >= activeImage.height()*imgRatio ?  0 : (activeImage.height() - mainContainer.height()) / 2;
	positionY = mainContainer.width() * imgRatio >= mainContainer.height() ? ((mainContainer.width() * imgRatio) - mainContainer.height()) / 2 : 0;
	positionX = (activeImage.width() - mainContainer.width()) / 2;
	activeImage.css({'top': -positionY+'px', 'width': imgWidth+'px'});
	return true;
}

function changeSlides(slider, direction) {
		slideCount = 0;
		activeSlide = slider.find('.current');
		activeSlideIndex = activeSlide.index();
		slider.find('li').each(function() {
			slideCount++;
		})

		var navOut = (direction == 1) ? 'navOutNext' : 'navOutPrev';
		var navIn = (direction == 1) ? 'navInNext' : 'navInPrev';
		var nextSlideIndex = activeSlide.index() + direction;
		slideIndex = getSlideIndex(slideCount, nextSlideIndex);
		nextSlide = slider.find('li').eq(slideIndex);
		activeSlide.addClass(navOut);
		nextSlide.addClass(navIn);

		setTimeout(function() {
			nextSlide.attr('class', '').addClass('current');
			activeSlide.attr('class', '')
			slider.find('.slide-count').html(slideIndex+1 + ' of ' + slideCount);
			if(nextSlide.attr('data-caption')) {slider.children('.slide-caption').html(nextSlide.attr('data-caption')).show()} else {slider.children('.slide-caption').hide();}
		}, 800)

}

function getSlideIndex(slideCount, index) {
	if(index == slideCount) return 0;
	if(index < 0) return slideCount-1;
	return index;
}