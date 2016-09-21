var siteUrl;
var pointerEvent = "click";
var modelClose = '<div class="lightClose"> </div>';
var spByComm = {};
var width = $(document).width();
var ratio;
var unloadedImageryTimeout = false;
var clicked = false;
var interest = [];

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

    //NSE banner fix

    if(pageName == 'home') {
            var data = sessionStorage.getItem('nse_banner');

            if(data) {
                $('#colorbox').css({'height': 0, 'width': 0, 'display': 'none'});
            }
         $('body').on('click', '#cboxClose', function() {
            //sessionStorage.setItem('nse_banner', true);
        })
    }


    //Parallax

    var prxObj = [];

    $('.parallax-item').each(function(){
        var $bgobj = $(this); // assigning the object
    
        $(window).scroll(function() {
            var yPos = -($(window).scrollTop() / 4);     
            // Put together our final background position
            var coords = '50% '+ yPos + 'px';

            var mTop = yPos - 43

            // Move the background
            //$bgobj.css({ backgroundPosition: coords });
            $bgobj.css({ 'margin-top': mTop + 'px' });
        }); 
    });    

    $('.add-parallax').each(function(index) {
         var parObj = {
                    top: $(this).offset().top,
                    height: $(this).height(),
                    id: $(this).attr('id')
              }

              prxObj.push(parObj);
    })

    var fdItems = [];

    $('.add-fade').each(function(index) {
         var parObj = {
                    top: $(this).offset().top,
                    height: $(this).height(),
                    id: $(this).attr('id')
              }

              fdItems.push(parObj);
    })

    

   

    $('.checkbox').on('click', function() {
        if($('#'+$(this).attr('data-check')).prop('checked') === false) {
            if(interest.indexOf($(this).data('value')) == -1) {
                interest.push($(this).data('value'));
            }
        }else{
            var pos = interest.indexOf($(this).data('value'));
            interest.splice(pos, 1)
        }
        console.log(interest);
        $('#'+$(this).attr('data-check')).prop('checked', function(_, checked) {  
            return !checked;
        });
    })

    //hero 
    


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

    $(document).on('click', '.arrow', function(e) {
        e.preventDefault();
        var direction = ( $(this).hasClass('left-arrow') ) ? -1 : 1;
        changeSlide( direction, $(this).parent() );
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
        var new_width = $( window ).width();
        if(new_width < 768) {
            $('.main-nav').hide()
        }else{
            $('.main-nav').show();      
        }

        $('#colorbox, #cboxOverlay').css({'height': 0, 'width': 0, 'display': 'none'});

    });
    

        //Scrolling
        
        $(window).scroll(function() {
            windowWidth = $(window).width()
            windowHeight = $(window).height();
            var position = $(window).scrollTop();
            var documentHeight = $(document).height();


            // if(position >= documentHeight - $(window).height() - 100) {
            //     $('.main-footer').show().animate({'bottom': 0}, 300);
            // }

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

            for(i=0; i<prxObj.length; i++) {
                var divTop = prxObj[i].top - windowHeight;
                if(position > divTop) {
                    $('#'+prxObj[i].id).animate({ 'top': 0}, 1000);
                }
            }

            for(i=0; i<fdItems.length; i++) {
                var divTop = fdItems[i].top - windowHeight;
                if(position > divTop) {
                    $('#'+fdItems[i].id).animate({ opacity: 1}, 500);
                }
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
    

    $('.collection-boxes').hover(function() {
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

    $('a.model-image').on('click', function(e) {
        e.preventDefault();
    })

     $('.model-list').hover(function(){
        width = $(document).width()
        //if(width > 768){
           // $(this).find('.collection-box-image').animate({'background-size': '105%'}, 300);
        //}
        var cta = $(this).find('.cta');
        cta.removeClass(cta.attr('data-value'));
    }, function() {
        if(width > 768){
            $(this).find('.collection-box-image').animate({'background-size': '100%'}, 300);
        }
        var cta = $(this).find('.cta');
        cta.removeClass(cta.attr('data-value'));
    });


    $('#contact').submit(function(e) {
        var errors = [];

        if(interest.length > 1) {
            var interests = "Interested in: " + interest.join();
            var comments = $('#description').val() + " " + interests;
        }else{
            var comments = $('#description').val();
        }

        if(errors.length > 0) {
            return false;
        }

        $('#comments').val(comments);

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

        return false;



    });

    $('#model-inquiry').submit(function(e) {

        var error = [];

        if(interest.length >= 1) {
            var interests = "Interested in: " + interest.join();
            var comments = $('#description').val() + " " + interests;
        }else{
            var comments = $('#description').val();
        }

        $('#comments').val(comments);

        if(error.length > 0) {
            return false;
        }
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
        var filteredItems = [];

       

        if(!clicked) {
        $( ".image_collection .oneimage" ).each(function( index ) {

        var c = $(this);

        if ($(this).data("type") == "image") {

            var dimensions = getHeightWidth($(this).data("largeimg"));
                var imgObj = {
                    type: c.data('filter'),
                    src: $(this).data("largeimg"),
                    w: dimensions[0].width,
                    h: dimensions[0].height,
                    title: $("figcaption" , this).text()
              }

            ps_items.push(imgObj);
        
        }

         


          if ($(this).data("type") == "video") {
                
            var iframeHTML = '<iframe frameborder="0" name="pswp_iframe" scrolling="no" src="' + $(this).data("src") + '"></iframe>';
        
            $( ".videos").each(function( index ) {
              var imgObj = {
                    type: "videos",
                    html: "<div class='pswp_fullscreen'><div class='pswp_iframe_holder'>" + iframeHTML + "</div></div>",
                    mapName: $(this).data("map-name"),
                    commID: $(this).data("comm-id"),
                    title: $(this).data("title"),
                    myID: index
              }
            
                ps_items.push(imgObj);


            });    
        
          }

          if ($(this).data("type") == "sitemap") {

                var pswpElement = document.querySelectorAll('.pswp')[0];
              
              var imgObj = {
                    type: "sitemaps",
                    html: "<div class='siteplan_slide'><div id='sp_container_"+index+"' class='siteplan_container'><img src='" + normalizeURL($(this).data("largeimg")) + "' class='sp_img'/></div></div>",
                    mapName: $(this).data("map-name"),
                    commID: $(this).data("comm-id"),
                    title: $(this).data("title"),
                    myID: index
              }
              ps_items.push(imgObj);

          }
        
        })
    }

    clicked = true;

    var activeFilter = $('.gallery-buttons button.on')
    var gFilter = activeFilter.data('filter');

    if(gFilter == "*") {
        filteredItems = ps_items;
    }else{

        for ( var i = 0; i < ps_items.length; i++ ) {

        if ( "."+ps_items[i].type == gFilter)
            filteredItems.push(ps_items[i]);
        }

    }


    
       var ps_options = {
            index: $(this).index(),
            preload: [0,0],
            allowPanToNext: false,
            preventSwiping: true,
            closeOnScroll: false,
            isClickableElement: function(el) {
                console.log(el.tagName === 'IMG');
                return el.tagName === 'IMG';
            }
        };
    

        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, filteredItems, ps_options);
        //gallery.options.index = $(this).index();


        


        gallery.listen('beforeChange', function() { 
            console.log("beforeChange");
        });

        // After slides change
        // (after content changed)
        gallery.listen('afterChange', function() {
            prepSitePlans(gallery.currItem);

            console.log("afterChange");
            
        });

        gallery.listen('destroy', function() {
            $(".pswp_iframe_holder").html(""); //Clear out matterport or youtube if it's playing.
        });

         gallery.init();
    }); 

    
    var clicked_mobile = false;

    $('.js-openGallery-mobile').on(pointerEvent, function(e){
        var ps_mobile = [];
        var data_value = $(this).data("value");
        e.preventDefault();
       

            $( ".mobile-photo" ).each(function( index ) {
                if($(this).hasClass(data_value)) {
                    var imgObj = {
                        src: $(this).data("largeimg"),
                        w: 1000,
                        h: 600,
                        title: $("figcaption" , this).text()
                  }
                  ps_mobile.push(imgObj);
              }
            

            
        })

       

       var ps_options = {
            index: $(this).index(),
            preload: [0,0],
            allowPanToNext: false,
            preventSwiping: true,
            closeOnScroll: false,
            isClickableElement: function(el) {
                console.log(el.tagName === 'IMG');
                return el.tagName === 'IMG';
            }
        };
    

        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, ps_mobile, ps_options);
        //gallery.options.index = $(this).index();


        


        gallery.listen('beforeChange', function() { 
            console.log("beforeChange");
        });

        // After slides change
        // (after content changed)
        gallery.listen('afterChange', function() {
            prepSitePlans(gallery.currItem);

            console.log("afterChange");
            
        });

        gallery.listen('destroy', function() {
            $(".pswp_iframe_holder").html(""); //Clear out matterport or youtube if it's playing.
        });

         gallery.init();
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


        $( "."+$(this).data('value')).each(function( index ) {
            if ($(this).data("type")) {
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
            index: parseInt($(this).data("type"))-1,
            preload: [0,0],
            allowPanToNext: false,
            preventSwiping: true,
            closeOnScroll: false,
            isClickableElement: function(el) {
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


    if ( $('body').hasClass('residencess') ) {
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
            var comm_id = $('.model-tabs a.on').data('jde');

            
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
            var comm_id = $('.model-tabs a.on').data('comm');

            if(typeof(comm_id) === "undefined") {
                $('.firststeps').hide();
            }else{
                $('.firststeps').show();
            }

            $('#firststep-link').attr('href', 'https://firststep.tollbrothersinc.com/#/home/0'+jde);
            $('#paw-link').attr('href', 'https://paw.tbimortgage.com/PAWForm/home?state=FL&community='+comm_id);
            //scrollToDiv('model-listings-wrapper')
        }

        // Site Plans
        var collName = ($('.model-tabs a.on').attr('data-community-name') != "#qdh") ? $('.model-tabs a.on').attr('data-community-name') : "";
        $('#collection_name').text(collName);
        $('a.view-site-plans').attr('data-site-plans',$('.model-tabs a.on').attr('data-site-plans'));
    }

    $(document).on('click', '.model-tabs a', function(e) {
        e.preventDefault();
        var a = $(this);
        var c = $('#'+a.data('container'));
        var display = c.css('display');
        var r = $('.residence-item');

        if(display == "none") {
            r.slideUp();
            c.slideDown('slow');
        } 

        $(document).find('.model-tabs a.on').removeClass('on');
        a.addClass('on');
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
            htmls += '<div class="model-list cssAnime large-6 columns" data-hash="'+r.hash+'" href="'+r.url+'" data-Price="'+r.Price+'" data-Name="'+r.Name+'" data-type="'+r.type+'" data-Size="'+r.Size+'">' + r.domHtml + '</div>';
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

function resetModelBoxes(width) {

    if(width < 769) {
        $('.model-box-image').css({'background-size': 'cover'})
    }else{
        $('.model-box-image').css({'background-size': '100%'})
    }

}

function animateBoxes(){
    //
}

function getHeightWidth(url) {
    var myimg = [];
    $('.backup img').each(function() {
        if($(this).data('largeimg') == url) {
            var imgObj = {
                height: $(this).height(),
                width: $(this).width()
            }
            myimg.push(imgObj);
            console.log(imgObj);
        }
        
    })
   

    return myimg;
}

function setFormComment() {

}







