var siteUrl;
var pointerEvent = "click";
var modelClose = '<div class="lightClose"> </div>';
var spByComm = {};
var width = $(document).width();

$(function(){
	siteUrl = $('body').attr('data-site-url');
    var heroTab = $('.hero').offset().top + $('.hero').height(); 

    


    // ----------------------------------------------------------------------
    var pageName = $('body').attr('data-pagename');
    var navIndex = 0

    if (pageName == 'home') navIndex = 1;
    if (pageName == 'lifestyle') navIndex = 2;
    if (pageName == 'amenities') navIndex = 4;
    if (pageName == 'residences' || pageName == 'model' || pageName == 'qdh') navIndex = 3;
    if (pageName == 'directions') navIndex = 5;
    if (pageName == 'contact') navIndex = 6;

    if (navIndex != 0) var navItem = $('nav a').eq(navIndex).addClass('on').removeClass('off');

    /* PhotoSwipe Object/Array Creation */
    var pswpElement = document.querySelectorAll('.pswp')[0];
    var ps_items=[];

    //loop through the image_collection and add it's object to the ps_items array
    $( ".image_collection .oneimage" ).each(function( index ) {

        if ($(this).data("largeimg")) {
              var imgObj = {
                    src: $(this).data("largeimg"),
                    w: $(this).data("img-w"),
                    h: $(this).data("img-h"),
                    title: $("figcaption" , this).text()
              }
              ps_items.push(imgObj);
          } else {

                var iframeHTML = '<iframe frameborder="0" name="pswp_iframe" scrolling="no" src="' + $(this).data("iframe") + '"></iframe>';

                var iframeObj = {
                    html: "<div class='pswp_fullscreen'><div class='pswp_iframe_holder'>" + iframeHTML + "</div></div>",
                    w: 920,
                    h: 614,
                    title: $("figcaption" , this).text()
                }
                ps_items.push(iframeObj);
          }

        
    });

    $('.checkbox').on('click', function() {
        $('#'+$(this).attr('data-check')).prop('checked', function(_, checked) {
            return !checked;
        });
    })


    $( ".text-row .photos" ).each(function( index ) {

        if ($(this).data("largeimg")) {
              var imgObj = {
                    src: $(this).data("largeimg"),
                    w: $(this).data("img-w"),
                    h: $(this).data("img-h"),
                    title: $("figcaption" , this).text()
              }
              ps_items.push(imgObj);
          } else {

                var iframeHTML = '<iframe frameborder="0" name="pswp_iframe" scrolling="no" src="' + $(this).data("iframe") + '"></iframe>';

                var iframeObj = {
                    html: "<div class='pswp_fullscreen'><div class='pswp_iframe_holder'>" + iframeHTML + "</div></div>",
                    w: 920,
                    h: 614,
                    title: $("figcaption" , this).text()
                }
                ps_items.push(iframeObj);
          }

        
    });



    //Slider area

    setupPageSlides();

    $(document).on('click', '.arrow', function(e) {
        e.preventDefault();
        var direction = ( $(this).hasClass('left-arrow') ) ? -1 : 1;
        changeSlide( direction, $(this).parent() );
        console.log($(this).parent().width());
    });

    $('.arrow').hover(function() {
        $(this).children('a').addClass('gallery-up');
    },
        function() {
            $(this).children('a').removeClass('gallery-up');
        }
    )

    //Slider area stop

    var ps_options = {
        index: 0, // start at first slide
        closeOnScroll: false
    };

    $( window ).resize(function() {
        setupPageSlides();
        var new_width = $( window ).width();
        if(new_width < 768) {
            $('.main-nav').hide()
        }else{
            $('.main-nav').show();
        }

        resetCollectionBoxes(new_width)
    });

        //Scrolling
        
        $(window).scroll(function() {
            windowWidth = $(window).width()
            var position = $(window).scrollTop();
            var documentHeight = $(document).height();


            if(position >= documentHeight - $(window).height() - 172) {
                $('.main-footer').show('slow');
            }

            var offset = $('.main-header').offset();
            if (position > $('.main-header').height() && position < heroTab) { 
                $('.main-header').hide(); 
            }

            if(position <= $('.main-header').height()) {
                $('.main-header').removeClass('sticky').show();
            }

             if(position >= heroTab) {
                $('.main-header').addClass('sticky').slideDown('slow');
            }


            

            //console.log(position);
            //position >= heroTab ? $('.main-header').addClass('sticky'):$('.main-header').removeClass('sticky');

        });

    //Mobile Menu dropdown
        $('ul li.menu-icon a').on('click', function(e){
            e.preventDefault();
            $('.main-nav').slideToggle();
        })

    // Submit Contact Form

    $('.required').keyup(function(){
        $(this).removeClass('error');
    })

    //Zoom background image 
    

    $('.collection-boxes').hover(function(){
        width = $(document).width()
        if(width > 768){
            $(this).find('.collection-box-image').animate({'background-size': '105%'}, 300);
        }
    }, function() {
        if(width > 768){
            $(this).find('.collection-box-image').animate({'background-size': '100%'}, 300)
        }
    });

      $('.model-list').hover(function(){
        alert('yes')
        width = $(document).width()
        if(width > 768){
            $(this).find('.collection-box-image').animate({'background-size': '105%'}, 300);
            
        }
        var cta = $(this).find('.cta');
            cta.addClass(cta.attr('data-value'));
    }, function() {
        if(width > 768){
            $(this).find('.collection-box-image').animate({'background-size': '100%'}, 300);
            
        }
        var cta = $(this).find('.cta');
            cta.removeClass(cta.attr('data-value'));
    });


    $('#contact').submit(function(e) {
        var errors = []
        $('.required').each(function() {
            if($(this).val() == "") {
                $(this).addClass('error');
                errors.push('firstname');
            }

            if($(this).attr('id') == "email") {
                var email = $(this).val().trim().toLowerCase();
                if(!validateEmail(email))
                    {$(this).addClass('error');
                    errors.push('email');}
                }
        })

        if(errors.length > 0) {
            return false;
        }


    });

    $('#model-inquiry').submit(function(e) {

        var error = [];
        $('.required').each(function() {
            if($(this).val() == "") {
                $(this).addClass('error');
                error.push('firstname');
            }

            if($(this).attr('id') == "email") {
                if(!validateEmail($(this).val())) {
                    $(this).addClass('error');
                    error.push('email');
                }
            }

        })

        if(error.length > 0) {
            return false;
        }


    });



    $('.js-openGallery').on(pointerEvent, function(e){
        e.preventDefault();
        console.log(ps_items)
        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, ps_items, ps_options);
        gallery.options.index = $(this).index();
        gallery.init();


        gallery.listen('beforeChange', function() { 
            console.log("beforeChange");
        });

        // After slides change
        // (after content changed)
        gallery.listen('afterChange', function() {
            console.log("afterChange");
            
        });

        gallery.listen('destroy', function() {
            $(".pswp_iframe_holder").html(""); //Clear out matterport or youtube if it's playing.
        });
    }); 


});


var normalizeURL = function(url, domainToo){
    url = url.replace(/^http[s]*:/i,'');
    if (!/anvil2.tollwebservices.com/i.test(url) && !/tollbrothers.com/i.test(url) && !/www\.youtube\.com/i.test(url)){
        url = '//www.tollbrothers.com' + url;
    }
    return url;
};

$(function(){

    
    if ($('body').hasClass('model')) {

        var $grid = $('.image_collection').isotope({});
        $(".image_collection img").load(function() {
            $('.image_collection').isotope();
            $('.image_collection').isotope('layout');
            // $('.image_collection').isotope('reloadItems').isotope('reLayout');
        })

        $('.gallery-buttons').on('click', 'button', function() {
            
                $(this).parent().find('.on').removeClass('on');
                $(this).addClass('on');
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({ filter: filterValue });
        });

    }
})


$(function(){

    $('.js-openSiteplan').on(pointerEvent, function(e){

        e.preventDefault();

        /* PhotoSwipe Object/Array Creation */
        var pswpElement = document.querySelectorAll('.pswp')[0];
        var ps_items=[];


        $( ".oneplan" ).each(function( index ) {
            if ($(this).data("largeimg")) {
                console.log($(this).data("largeimg"))
              var imgObj = {
                    html: "<div class='siteplan_slide'><div id='sp_container_"+index+"' class='siteplan_container'><img src='" + normalizeURL($(this).data("largeimg")) + "' class='sp_img'/></div></div>",
                    mapName: $(this).data("map-name"),
                    commID: $(this).data("comm-id"),
                    title: $(this).data("title"),
                    myID: index
              }
              ps_items.push(imgObj);

          }

        });
        var ps_options = {
            index: $(this).index(),
            preload: [0,0],
            allowPanToNext: false,
            preventSwiping: true,
            closeOnScroll: false,
            isClickableElement: function(el) {
                console.log(el.tagName);
                console.log(el.tagName === 'IMG');
                return el.tagName === 'IMG';
            }
        };

        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, ps_items, ps_options);


        gallery.listen('afterChange', function() {
            // console.log(gallery.currItem);
            // return;
            prepSitePlans(gallery.currItem);
            console.log(gallery.currItem)
        });


        gallery.listen('beforeChange', function() {
            toll.sitePlan.abort();
        });

        gallery.listen('destroy', function() {
            toll.sitePlan.abort();
        });

        gallery.init();

    });


});

var prepSitePlans = function(item) {

    toll.sitePlan.abort();

    if (item.mapName !== "") {
        spData = spByComm['comm_' + item.commID];
        sitePlanSelector = "#sp_container_" + item.myID;
        spImg = $(sitePlanSelector + " .sp_img");
        $("<img/>") 
        .attr("src", $(spImg).attr("src"))
        .load(function() {
            pic_real_width = this.width;   
            pic_real_height = this.height;

            if (pic_real_width + 40 > $(window).width()) {
                $(spImg).addClass('tooWide');
            }
            toll.sitePlan.loadWithPrefetchedData(item.commID, spData, false);
            toll.sitePlan.init(item.mapName, sitePlanSelector, item.commID);
            toll.sitePlan.show();
        });
    }

}

//Home page parallax 

var collectionBoxes = new Array();

$(function() {
    $(document).find('.collection-boxes').each(function() {
        collectionBoxes.push({
            top: $(this).offset().top
        })
    })

    animateBoxes();

})


/*
    New Residences/QDH page functionality
*/
var residenceModels = new Array();
var scrollDownResidences = false;
$(function(){
    var listingParent;
    $(document).find('.model-list').each(function(){
        if ( !$(this).hasClass('off') ) {
            residenceModels.push({
                domElement  :   $(this),
                domHtml     :   $(this).html(),
                price       :   parseInt($(this).attr('data-price')),
                size        :   parseInt($(this).attr('data-size')),
                name        :   $(this).attr('data-name'),
                url         :   $(this).attr('data-url'),
                hash        :   $(this).attr('data-hash'),
                type        :   $(this).attr('data-type')
            });
        }
    });


    if ( $('body').hasClass('residences') ) {
        var hash = window.location.hash == "" ? "#heritage" : window.location.hash;
        var index = 0;
        var linksCount = 0
        $(document).find('.model-tabs a').each(function() {
            linksCount++;
            if ( $(this).attr('data-hash') == hash )
                index = $(this).index();
                $(this).addClass('on');
            //else
                //index = 1;
        });

        if ( index != 0 ) {

        
            var jde = $('.model-tabs a.on').attr('data-jde');
            $('#firststep-link').attr('href', 'https://firststep.tollbrothersinc.com/#/home/0'+jde);
            if(window.location.hash) {

                scrollToDiv('model-tabs');
            }
            //scrollToDiv('model-list')
        }


        $(document).find('.model-tabs a.on').removeClass('on');
        $(document).find('.model-tabs a').eq(index).addClass('on');

        filterResidenceModels('Price',1);
    
        if ( index != 0 ) {

            var jde = $('.model-tabs a.on').attr('data-jde');
            $('#firststep-link').attr('href', 'https://firststep.tollbrothersinc.com/#/home/0'+jde);
            //scrollToDiv('model-listings-wrapper')
        }

        // Site Plans
        var collName = ($('.model-tabs a.on').attr('data-community-name') != "#qdh") ? $('.model-tabs a.on').attr('data-community-name') : "";
        $('#collection_name').text(collName);
        $('a.view-site-plans').attr('data-site-plans',$('.model-tabs a.on').attr('data-site-plans'));
    }

    $(document).on('click', '.model-tabs a', function(e) {
    e.preventDefault();
    $('#firststep-link').attr('href', 'https://firststep.tollbrothersinc.com/#/home/0'+$(this).attr('data-jde'));
    window.location.hash = $(this).attr('data-hash');
    $(document).find('.model-tabs a.on').removeClass('on');
    $(this).addClass('on');
    var sortBy = $(document).find('.model-sorter li.on').attr('data-value');
    var ddorder = ($(document).find('.model-sorter li').hasClass('asc')) ? 1 : -1;
    filterResidenceModels(sortBy,ddorder);
    scrollToDiv('model-tabs');

    // Site Plans
    var collName = ($(this).attr('data-community-name') != "#qdh") ? $(this).attr('data-community-name') : "";
    $('#collection_name').text(collName);
    //var sitePlans = $(this).attr('data-site-plans').split(',');
    $('a.view-site-plans').attr('data-site-plans',$(this).attr('data-site-plans'));
});
});
$(document).on('click', '.fghjfghj', function(e) {
    e.preventDefault();
    var ddoptions = $(this).parent().find('li');
    if ( ddoptions.hasClass('on') ) {
        ddoptions.removeClass('on');
        return false;
    }
    $(this).addClass('on');
});
$(document).on('click', '.gallery-buttons button', function(e) {
    e.preventDefault();
    if(!$(this).hasClass('sortby')) {
        var ddoptions = $(this).parent();
        var ddbutton = ddoptions.parent().children('li');

        // default descending order
        var ddorder = 1;
        // Remove any active option from an on state
        $(document).find('.gallery-buttons button').removeClass('on');
        // Make this option the new on state
        $(this).addClass('on');

        // If the option is already selected, toggle the sort (ascending/descending)
        // if ( $(this).attr('data-value') == ddbutton.html() ) {
        //     if ( ddbutton.hasClass('asc') )
        //         ddbutton.removeClass('asc');
        //     else {
        //         ddbutton.addClass('asc');
        //         ddorder = 1;
        //     }
        // }
        // If this is a new option, set the button text and default to descending
        // else {
        //     ddbutton.html( $(this).attr('data-value') );
        //     ddbutton.removeClass('asc');
        // }
        filterResidenceModels( $(this).attr('data-value'), 1);
    }
});



// Autohide any open dropdowns
$(document).mouseup(function(e) {
    $(document).find('.dropdown').each(function(){
        var dropdown = $(this);
        if ( !dropdown.is(e.target) && !dropdown.children('a').is(e.target) && !dropdown.find('.dropdown-options a').is(e.target) )
            dropdown.find('.dropdown-options').removeClass('on').hide();
    });
});
function filterResidenceModels( sortBy, ddorder ) {
    var filterBy = $(document).find('.model-tabs a.on').attr('data-hash');
    //var filterBy = $(document).find('.model-tabs a.on').attr('data-community-name');
    var filteredModels = new Array();
    var filterCommunityName = 'Hasentree';


        if(filterBy == "#qdh") {
            $('.firststep').hide();
        }else {
            $('.firststep').show();
        }
        filterCommunityName = $(document).find('.model-tabs a.on').attr('data-community-name');
        for ( var i = 0; i < residenceModels.length; i++ ) {

            if ( residenceModels[i].hash == filterBy )
                filteredModels.push(residenceModels[i]);
        }

        console.log(sortBy);
    
    filteredModels.sort(function(a,b) {
        if ( a[sortBy] > b[sortBy] ) return ddorder;
        else if ( a[sortBy] < b[sortBy] ) return ddorder * -1;
        else return 0;
    });
    $('#model-listings-wrapper').html('');
    var htmls = '';
    var r;
    var totalFilter = 0;
    for ( var i = 0; i < filteredModels.length; i++ ) {
        r = filteredModels[i];
        if ( !r.domElement.hasClass('off') ) {
            htmls += '<a class="model-list cssAnime large-6 columns" data-hash="'+r.hash+'" href="'+r.url+'" data-Price="'+r.Price+'" data-Name="'+r.Name+'" data-type="'+r.type+'" data-Size="'+r.Size+'">' + r.domHtml + '</div>';
            totalFilter ++;
        }
    }


    $('#model-listings-wrapper').html(htmls);
    if ( totalFilter == residenceModels.length ) {
        var filterText = 'Showing all <strong>' + totalFilter + '</strong> home designs in the <strong>Hasentree</strong> community.';
        $('p.filter-text').html(filterText);
    } else {
        var filterText = 'Showing <strong>' + totalFilter + '</strong> home designs in the <strong>'+filterCommunityName+'</strong> collection.';
        $('p.filter-text').html(filterText);
    }
}

function scrollToDiv(div) {
    $('html, body').animate({
        scrollTop: $("#"+div).offset().top - 200
    }, 1000);
}

function setupPageSlides() {

    var height = 0;
    var slideCount = 0;
    var leftPos = 0;
    var firstSlideIndex = 1;
    $(document).find('.slider').each(function(){
        slideCount = 0;
        leftPos = 0;
        var height;
        // Set the slideshow to be the same height as it's neighbor copy
        height = $(this).find('.slide-content').height();
        //$(this).find('.slide-content').height(height);
        $(this).find('.slide-content .slide').each(function() {
            if ( $(this).hasClass('on') ) {
                width=$(this).width();
                firstSlideIndex = slideCount + 1;
                $(this).css({'display':'block','height':height+'px', 'left':'0px', 'background-size': 'cover', 'background-image':'url('+$(this).attr('data-image')+')'});
            }
            else
                $(this).css({'display':'block','z-index': 1, 'height':height+'px', 'width':'100%', 'background-size': 'cover', 'left':$(this).width()+'px','background-image':'url('+$(this).attr('data-image')+')'});
            slideCount++;
        });
        // Add arrows
        if ( slideCount > 1 ) {
            // add arrows
            var nextSlide = $(this).find('.slide.on');
            var totalSlides = $(this).find('.slide').length;
            var nextCaption = ( typeof nextSlide.attr('data-caption') != 'undefined' ) ? nextSlide.attr('data-caption') + '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
            var htmls = nextCaption + '<span><em>'+firstSlideIndex+'</em> / '+totalSlides+'</span>';
            $(this).find('.left-arrow .caption').html(htmls);
            $(this).find('.right-arrow .caption').html(htmls);

            // Make arrows same height as slideshow
            $(this).find('.arrow').each(function() { $(this).height(height); });
        }
    });
}

function changeSlide( direction, slider ) {
    var slideSpeed = 700;
    var totalSlides = slider.children('.slide').length;
    var currentSlide = slider.children('.slide.on');
    var nextSlideIndex = currentSlide.index() + direction;
    if ( nextSlideIndex < 0 ) nextSlideIndex = totalSlides - 1;
    if ( nextSlideIndex >= totalSlides ) nextSlideIndex = 0;
    var nextSlide = slider.find('.slide').eq(nextSlideIndex);
    if ( direction == 1 ) {
        nextSlide.stop(true,false).addClass('on').css({'left':slider.width()+'px'});
        //nextSlide.animate({'left':'0px'},slideSpeed);
        currentSlide.stop(true,false).removeClass('on');
        TweenMax.to( currentSlide, 0.85, {left:-slider.width()});
        TweenMax.to( nextSlide, 0.85, {left:0});

    } else {
        nextSlide.stop(true,false).addClass('on').css({'left':-slider.width()+'px'});
        //nextSlide.animate({'left':'0px'},slideSpeed);
        currentSlide.stop(true,false).removeClass('on');//.animate({'left':slider.width()+'px'},slideSpeed);
        TweenMax.to( currentSlide, 0.85, {left:slider.width()});
        TweenMax.to( nextSlide, 0.85, {left:0});
    }
    // Both slide captions display current photo's data
    var nextCaption = ( typeof nextSlide.attr('data-caption') != 'undefined' ) ? nextSlide.attr('data-caption') + '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
    var htmls = nextCaption + '<span><em>'+(nextSlideIndex+1)+'</em> / '+totalSlides+'</span>';
    slider.find('.left-arrow .caption').html(htmls);
    slider.find('.right-arrow .caption').html(htmls);
}

function validateEmail(email) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(email)) {
        return true;
    }
    else {
        return false;
    }
}


function resetCollectionBoxes(width) {
    if(width < 769) {
        $('.collection-box-image').css({'background-size': 'cover'})
    }else{
        $('.collection-box-image').css({'background-size': '100%'})
    }
}

function animateBoxes() {
    console.log(collectionBoxes)
}

