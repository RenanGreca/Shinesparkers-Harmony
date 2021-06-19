/* <![CDATA[ */
(function($){
	
	"use strict";
	
    $(document).ready(function(){
        
		$( "#ut-sortable-tax" ).sortable({ 
			handle: '.ut-handle',
			placeholder: "ut-handle-highlight"
		});
		
        /* ------------------------------------------------
        display chosen portfolio settings type after load
        ------------------------------------------------ */
        $("#ut_portfolio_type").each(function(){
            
            var type = $(this).find(":selected").val();
            $('.ut-option-section').hide();
            
            if( type ) {
                $( '#' +  type + '_options' ).show();          
            }
            
        }); 
        
        /* ------------------------------------------------
        display chosen portfolio settings type on change
        ------------------------------------------------ */
        $("#ut_portfolio_type").change(function() {
        
            var type = $(this).find(":selected").val();
            $('.ut-option-section').hide();
            
            if( type ) {
                $( '#' +  type + '_options' ).show();          
            }   
        
        });
			
		/* ------------------------------------------------
		Color Picker 
        ------------------------------------------------ */
		$('.ut_color_picker').wpColorPicker();
		
		
		/* ------------------------------------------------
		Opacity Range Slider
        ------------------------------------------------ */
		$( ".ut-opacity-slider" ).css("visibility","hidden").each(function() {
            
            var sliderdefault = $(this).data('state');
            
            var $slider = $(this).slider({
			
                min: 0,
                max: 1,
                step: 0.1,
                value: sliderdefault ,
                slide: function( event, ui ) {
                    
                    $(this).parent().find('.ut-hidden-slider-input').val( ui.value );
                    $(this).parent().find('.ut-opacity-value').text( ui.value );
                    
                }
            
            });
            
            setTimeout(function(){ $slider.css("visibility","visible").fadeIn().slider( "option", "value", sliderdefault ); }, 500 );
            
        });
        
        
        /* ------------------------------------------------
		Border Radius Range Slider
        ------------------------------------------------ */
		$( ".ut-border-radius-slider" ).css("visibility","hidden").each(function() {
            
            var sliderdefault = $(this).data('state');
            
            var $slider = $(this).slider({
			
                min: 0,
                max: 100,
                step: 1,
                value: sliderdefault ,
                slide: function( event, ui ) {
                                        
                    $(this).parent().find('.ut-hidden-slider-input').val( ui.value );
                    $(this).parent().find('.ut-border-radius-value').text( ui.value );
                    
                }
                
            
            });
            
            setTimeout(function(){ $slider.css("visibility","visible").fadeIn().slider( "option", "value", sliderdefault ); }, 500 );
            
        });
        
        /* ------------------------------------------------
		Gallery Styles
        ------------------------------------------------ */
        $("#ut_gallery_options_style").change(function(){
            
            if( $(this).find(":selected").val() === 'style_one' ) {
                
                $("#ut_gallery_options_style_1_caption_content").show();
                $("#ut_gallery_options_style_2_caption_content").hide();
                
            } else {
                
                $("#ut_gallery_options_style_1_caption_content").hide();
                $("#ut_gallery_options_style_2_caption_content").show();
                
            }
            
            $("#ut_gallery_options_style_1_caption_content").trigger("change");
            $("#ut_gallery_options_style_2_caption_content").trigger("change");
            
        });
        
        $("#ut_gallery_options_style").trigger("change");
        
        
        $("#ut_gallery_options_style_1_caption_content").change(function(){
            
            if( $(this).find(":selected").val() === 'custom_text' && $(this).is(":visible") === true ) {
                
                $("#ut_gallery_options_style_1_caption_custom_text").show();
                
            } else {
                
                $("#ut_gallery_options_style_1_caption_custom_text").hide();
                
            }
            
        });
        
        $("#ut_gallery_options_style_1_caption_content").trigger("change");
        
        $("#ut_gallery_options_style_2_caption_content").change(function(){
            
            if( $(this).find(":selected").val() === 'custom_text' && $(this).is(":visible") === true ) {
                
                $("#ut_gallery_options_style_2_caption_custom_text").show();
                
            } else {
                
                $("#ut_gallery_options_style_2_caption_custom_text").hide();
                
            }
            
        });
        
        $("#ut_gallery_options_style_2_caption_content").trigger("change");
        
        
        
        
    });
    
})(jQuery);
 /* ]]> */	