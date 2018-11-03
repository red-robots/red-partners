jQuery(document).ready(function($){
    //Examples of how to assign the Colorbox event to elements
    $(".group1").colorbox({rel:'group1'});
    $(".group2").colorbox({rel:'group2'});
    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
    $(".group4").colorbox({rel:'group4', slideshow:true});
    $(".ajax").colorbox();
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
    $(".inline").colorbox({inline:true, width:"50%"});
    $(".callbacks").colorbox({
        onOpen:function(){ alert('onOpen: colorbox is about to open'); },
        onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
        onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
        onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
        onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
    });
    $('.non-retina').colorbox({rel:'group5', transition:'none'})
    $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});

    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function(){ 
        $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
        return false;
    });
    
    
    function load_selection_fields() {
       $('#listing_status').fSelect({
            placeholder: 'Status',
            searchText: 'Search status...'
        });

        $('#listing_city').fSelect({
            placeholder: 'City',
            searchText: 'Search city...'
        });

        $('#listing_zipcode').fSelect({
            placeholder: 'Zip',
            searchText: 'Search zip code...'
        });

        $('#listing_broker').fSelect({
            placeholder: 'Broker',
            searchText: 'Search name...'
        });

        $('#listing_property_type').fSelect({
            placeholder: 'Property Type',
            searchText: 'Search property type...'
        }); 
    }
    
    load_selection_fields();
    
    
    $('body').on('click','#reset_filter',function(e){
        e.preventDefault();
        $('#listingFilter').load( full_url + ' .prop-form-inner',function(){
            load_selection_fields();
        });
    });
    
    $('body').on('change','#listing_status',function(){
        var selections = $(this).val();
    });
    
    $('body').on('click','ul.pagination li',function(){
        var link = $(this).find('a');
        if( $(this).hasClass('disabled') ) {
            var url = link.attr('href');
            link.on("click",function(e){
                e.preventDefault();
            });
        }
    });
});