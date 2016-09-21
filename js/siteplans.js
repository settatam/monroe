$(function(){

	$('.js-openSitepladdn').on(pointerEvent, function(e){

        /* PhotoSwipe Object/Array Creation */
	    var pswpElement = document.querySelectorAll('.pswp')[0];
	    var ps_items=[];

        $( ".siteplan_collectiomn .oneplan" ).each(function( index ) {

            if ($(this).data("largeimg")) {
              var imgObj = {
                    html: "<div class='siteplan_slide'><div id='sp_container_"+index+"' class='siteplan_container'><img src='" + normalizeURL($(this).data("largeimg")) + "' class='sp_img'/></div></div>",
                    mapName: $(this).data("map-name"),
                    commID: $(this).data("comm-id"),
                    title: $("figcaption" , this).text(),
                    myID: index
              }
              //ps_items.push(imgObj);
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
        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, ps_items, ps_options);

        gallery.listen('afterChange', function() {
            prepSitePlans(gallery.currItem);
        });

        /*gallery.listen('preventDragEvent', function(e, isDown, preventObj) {
            console.log("preventDragEvent");
            // e - original event
            // isDown - true = drag start, false = drag release

            // Line below will force e.preventDefault() on:
            // touchstart/mousedown/pointerdown events
            // as well as on:
            // touchend/mouseup/pointerup events

            preventObj.prevent = true;
        });*/

        gallery.listen('beforeChange', function() {
            toll.sitePlan.abort();
        });

        gallery.listen('destroy', function() {
            toll.sitePlan.abort();
        });

        gallery.init();

    });


});

var prepSitePlansdddd = function(item) {

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