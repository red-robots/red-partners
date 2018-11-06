jQuery(document).ready(function($){
    
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
    
    $(document).on('click','#reset_filter',function(e){
        e.preventDefault();
        var url = $(this).attr('data-url');
        $('#spinner').show();
        setTimeout( function(){
            $('#listingFilter').removeClass('disable-form');
            $('#main').load( url + ' #mainContent',function(){
                load_selection_fields();
                window.history.replaceState( null, null, url );
            });
        },800);
    });
    
    $( document ).on('click','.fieldwrap .btn',function(e){
        e.preventDefault();
        var parent = $(this).parents('.fieldwrap');
        var search_input = parent.find('input.form-control').val();
        var hasVal = search_input.replace(/\s+/g, '');        
        if(hasVal) {
            do_ajax_search_list();
        }
        
    });

    var selection_status = '';
    $( document ).on('change','select.the-field', function(){
        var parent = $(this).parents('.selection-field');
        $('.form-group').removeClass('option-changed');
        parent.addClass('option-changed');
        var is_open = parent.find('.fs-wrap').hasClass('fs-open');
        if(is_open) {
            $('#listingFilter').attr('data-formstat','changed');
        } 
    });
    
    
    
    $(document).mouseup(function(e)  {        
        var container = $('.selection-field');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            var status  = $('#listingFilter').attr('data-formstat');
            if(status) {
                do_ajax_search_list();
            }
        } 
    });
    
    function do_ajax_search_list() {
        var the_fields = [];
        $('.form-group').removeClass('option-changed');
        $.each( $('.the-field'), function() {
            var field_val = $(this).val();
            var field_name = $(this).attr('name');
            var data = {
                        'name': field_name,
                        'value': field_val
                    };
            the_fields.push(data);
        });
        
        $.ajax({
            type : 'GET',
            url : listAjax.ajax_url,
            dataType: "json",
            data : {
                action : 'do_list_filter',
                fields : the_fields,
                page : 1,
                limit : $('input.limit').val(),
                links : $('input.links').val(),
                base_url : $('input.current_url').val()
            },
            beforeSend:function(){
                $('#spinner').show();
                $('#listingFilter').addClass('disable-form');
                $('#listingFilter').attr('data-formstat','');
            },
            success : function( obj ) {
                var success = obj.success;
                var output = obj.markup;
                var new_url = obj.base_url;
                var show_all = obj.show_all;
                var main_url = obj.main_url;
                
                if(show_all) {
                    setTimeout( function(){
                        $('#spinner').hide();
                        $('#listingFilter').removeClass('disable-form');
                        $('.listing-outer-wrapper').load(main_url + ' #list_container');
                    },800);
                } else {   
                    if(output) {
                        setTimeout( function(){
                            $('#spinner').hide();
                            $('#listingFilter').removeClass('disable-form');
                            $('#list_container').html(output);
                            $('a.popup').colorbox({
                                height: '95%'
                            });
                        },800);
                    } 
                    
                    if(success==false) {
                        setTimeout( function(){
                            $('#listingFilter').removeClass('disable-form');
                            $('#spinner').hide();
                        },800);
                    }
                }
                

                if(new_url) {
                    window.history.replaceState( null, null, new_url );
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#spinner').hide();
                $('#listingFilter').removeClass('disable-form');
                $('#pageErrors').append('<div class="error-message"><p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div></div>');
            }
        });
    }
});