
/*

-- For this to work, you need to have these two divs with these exact IDs:

<div id="map_holder"></div>
<div id="map_directions_holder"></div>


-- And you need to define this object:

<script type="text/javascript">
    mapData = {
        "long" : <?=$communityList[0]["salesOfficeLongitude"]; ?>,
        "lat" : <?=$communityList[0]["salesOfficeLatitude"]; ?>,
        "markerTitle" : "<?=$comm_data['name']; ?>",
        "markerImage" : {
            "src" : "//www.tollbrothers.com/tb/images/maps/red_dotlrg.png",
            "width" : 28, 
            "height" : 37,
            "anchorx" : 14,
            "anchory" : 37
        }
    };
</script>


-- And then below that, call this JS: 

<script src="//maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>

*/

var map, directionsDisplay, directionsService, commLatLang;
var get_direction  = false;

function initMap() {

    commLatLang = {lat: mapData.lat, lng: mapData.long};


    var image = {
        url: mapData.markerImage.src,
        size: new google.maps.Size(mapData.markerImage.width, mapData.markerImage.height),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is at the bottom middle(14, 37).
        anchor: new google.maps.Point(mapData.markerImage.anchorx, mapData.markerImage.anchory)
    };

    //This hides all the other POI info that can be displayed on the map (Like john's barber shop, etc...)
    var myStyles =[{
        featureType: "poi",
        elementType: "labels",
        stylers: [{ 
            visibility: "off" 
        }]
    }];

    map = new google.maps.Map(document.getElementById('map_holder'), {
      center: commLatLang,
      zoom: 14,
      styles: myStyles,
      scrollwheel: false
    });

    var marker = new google.maps.Marker({
        position: commLatLang,
        map: map,
        icon: image,
        title: mapData.markerTitle
    });

    google.maps.event.addDomListener(window, 'resize', function() {
        map.setCenter(commLatLang);
    });

     google.maps.event.addDomListener(document.getElementById('getDirs'), 'click', function() {
       setTimeout(function() {
            if($(document).width() > 768) {
                
                $('#map_holder').css({'height': $('.directions_style').height()+"px" })
            }else{
                $('#map_holder').css({'height': "312px" })
            }
            var center = map.getCenter();
            google.maps.event.trigger(map, 'resize');
            map.setCenter(commLatLang);
       }, 1000)


    });

}

function calculateAndDisplayRoute(startingPoint, successCallBack, errorCallBack) {
    
    directionsDisplay = new google.maps.DirectionsRenderer;
    directionsService = new google.maps.DirectionsService;

    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('map_directions_holder'));

    var start = startingPoint;
    var end = commLatLang;
    directionsService.route({
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            successCallBack();

        } else {
            errorCallBack(status);
        }
    });
}


