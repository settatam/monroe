var mapSuccess = function() {
    hideMapAlert();
    $("#map_directions").show();
    $('.directions_style').show();
    $("#clearDirs").removeClass("hidden");
    $("#getDirs").hide();
    get_direction = true;

    $(".map_error").hide('fast');
     var width = $(document).width();

            if(width > 768) {
                   $('#map_holder').css({ width: '50%'});
                
            }

    scrollToDivs('map_holder');
       var setHeight = function(callback) {
         if(width > 768) {
            setTimeout(function() { 
                    $('#map_holder').css({'height': $('#map_directions_holder').height() })   
                }, 100);
                //map.fitBounds(bounds)

                callback();
        }
    }

         setHeight(function() {

           
                setTimeout(function() {
                    bounds = map.getBounds();
                    
                    // map.setZoom(map.getZoom()+0)
                    //google.maps.event.trigger(map, 'resize');
                    //var center = map.getCenter();
                    map.fitBounds(bounds);
                     google.maps.event.trigger(map, 'resize');
                     
                    //map.setCenter(center);
                    
                }, 3000);
            
            
        })
}

var mapError = function(errorStatus) {
     $(".map_error").show('fast');
    //updateMapAlert('Directions request failed due to ' + errorStatus, true);
}



//This is only to display a little dialog alert...
function updateMapAlert(msg, isError) {
    var isError = typeof isError !== 'undefined' ?  isError : false;
   
    // if (isError) {
    //     $("#map_alert").addClass("map_error");
    // } else {
    //     $("#map_alert").removeClass("map_error");
    // }
}

function hideMapAlert() {
    $(".map_error").addClass("hidden");
}





$(function(){

    if ($("body").hasClass("directions")) {

        $(".js_getdirections").on(pointerEvent, function(e){
            
            var startLocation = $("#start_location").val();
             if(startLocation == "" || startLocation == " ") {
                $("#start_location").addClass('error');
                return false;
            }
           
            updateMapAlert("getting directions...", false);
           

            $('.directions_style').css({'padding-left': '17px', 'padding-right': '17px'});
            //width > 768 ? $('#map_holder').css({ width: '50%'});
            //$('#map_holder').css({ width: '50%'});
            var mapper = calculateAndDisplayRoute(startLocation, mapSuccess, mapError);
                //if(width > 768) {
        //}

       
            //bounds = new google.maps.LatLngBounds();
            //map.fitBounds( bounds );
            
        });

        $(".js_cleardirections").on(pointerEvent, function(e){
            $(".directions_style").hide();
            $("#map_directions_holder").html("");

            $('#map_holder').css({'height':  '600px', 'width': '100%'});
            $("#getDirs").show(); 
            $("#start_location").val("");
             setTimeout(function() { 
                var center = map.getCenter();
                 google.maps.event.trigger(map, 'resize');
                map.setCenter(center);
            }, 1000);
            initMap();
           scrollToDivs('intro-header');
        });

        $(".js_printdirections").on(pointerEvent, function(e){
            window.print();
        })


        $.getScript( "//maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyC6BgkfHSn04LjLI3ZXV7ukuRp1vMcYPLs" )
          .done(function( script, textStatus ) {
            //initMap() gets called by the api when it's ready... might be a better way to do it.
          })
          .fail(function( jqxhr, settings, exception ) {
            console.log("google maps api script failed to load");
        });

    }

});

function scrollToDivs(div) {
    $('html, body').animate({
        scrollTop: $("#"+div).offset().top - 200
    }, 1000);
}

function doHeight(height) {
            alert(height);
        }


