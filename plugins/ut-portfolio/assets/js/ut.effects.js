/* <![CDATA[ */
(function($){
	
	"use strict";
    
    $(document).ready(function(){
		
        /* Lazy Load
		================================================== */
        var $imgs = $("img.portfolio-lazy");
        
        $imgs.addClass('ut-animate-element animated').css('visibility', 'hidden').lazyload({
            event  : 'scroll',
            threshold : 400,
			load   : function() {
			    
                $(this).css('visibility', 'visible').show().addClass('fadeIn');			        
                
				
			},
            failure_limit: Math.max($imgs.length,0)
        });
        
        $(window).bind("load", function() {
            
            setTimeout(function() {
                //$imgs.trigger("sporty");
            }, 200 );
            
        });
        
        /* Lightbox LightGallery Effect
		================================================== */	        
        if ( $().lightGallery ) {
            
            $('.ut-portfolio-wrap').not('.ut-portfolio-packery-wrap').lightGallery({
                selector: 'a[data-rel^="ut-lightgallery"]',
                exThumbImage: 'data-exThumbImage',
                loadVimeoThumbnail : false,
                loadYoutubeThumbnail : false,
                hash: false
            });
            
            $('.ut-portfolio-packery-wrap').lightGallery({
                selector: 'a[data-rel^="ut-lightgallery"]',
                exThumbImage: 'data-exThumbImage',
                loadVimeoThumbnail : false,
                loadYoutubeThumbnail : false,
                hash: false
            });
            
        }
                
        /* Set Default Text Color for all elements */
		$(".ut-hover").each(function() {
            
			var text_color = $(this).closest('.ut-portfolio-wrap').data('textcolor');
			
			$(this).find(".ut-hover-layer").css({ "color" : text_color });
			$(this).find(".ut-hover-layer").find('.portfolio-title').attr('style', 'color: '+text_color+' !important');
			
        });		
		
		$('.ut-hover').on('mouseenter touchstart', function() { 	
			var hover_color   = $(this).closest('.ut-portfolio-wrap').data('hovercolor'),
				hover_opacity = $(this).closest('.ut-portfolio-wrap').data('opacity');

			$(this).find(".ut-hover-layer").css( "background" , "rgba(" + hover_color + "," + hover_opacity+ ")"  );
			$(this).find(".ut-hover-layer").css( "opacity" , 1 );			
			
		});
        
        $('.ut-hover').on('mouseleave touchend', function() { 
        	
			$(this).find(".ut-hover-layer").css( "opacity" , 0 );
			
		});
		
		/* Portfolio Animation
		================================================== */
		var ut_is_animating = false;
		
		function update_portfolio_height( wrap , direction ) {
			
			if( !wrap ) {
				return;
			} 			
			
			var height = null;
			
			if( direction === 'prev' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').prev().height();
			}
			
			if( direction === 'current' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').height();
			}
			
			if( direction === 'next' ) {
				height = $('#ut-portfolio-details-'+wrap).find('.active').next().height();
			}
			
			$('#ut-portfolio-details-wrap-'+wrap).height( height + 30 );
			
		}
				
		/* Update the Portfolio Detail Navigation */
		function update_portfolio_navigation( wrap ) {
						
			if( !wrap ) {
				return;
			} 
			
			/* lets get the next and previous element */
			var prev = $('#ut-portfolio-details-'+wrap).find('.active').prev('.ut-portfolio-detail'),
				next = $('#ut-portfolio-details-'+wrap).find('.active').next('.ut-portfolio-detail');
			
			/* show or hide previous button */
			if( !prev.length ) {
				$('#ut-portfolio-details-navigation-'+wrap).find('.prev-portfolio-details').animate({ opacity: 0}, 200 , 'linear' , function() {
                    $(this).css("visibility" , "hidden");
                });
			} else {
				$('#ut-portfolio-details-navigation-'+wrap).find('.prev-portfolio-details').animate({ opacity: 1}, 200 , 'linear' , function() {
                    $(this).css("visibility" , "visible");
                });
			}
			
			/* show or hide next button */ 
			if( !next.length ) {
				$('#ut-portfolio-details-navigation-'+wrap).find('.next-portfolio-details').animate({ opacity: 0}, 200 , 'linear' , function() {
                    $(this).css("visibility" , "hidden");
                });
			} else {
				$('#ut-portfolio-details-navigation-'+wrap).find('.next-portfolio-details').animate({ opacity: 1}, 200 , 'linear' , function() {
                    $(this).css("visibility" , "visible");     
                });
			}
			
			update_portfolio_navigation_position();
								
		}	
		
		
		function update_portfolio_navigation_position() {
			
			$('.ut-portfolio-details-navigation').each(function() {
                
				var $this 			= $(this),
					$parent 		= $this.parent(),
					$current 		= $parent.find(".active"),					
					media_height 	= $current.find(".ut-portfolio-media").height();
					
					
					if( media_height > 0 ) {
						
						/* align arrows to media container */
						$this.find('.next-portfolio-details').animate({top: media_height / 2 + 45 });
						$this.find('.prev-portfolio-details').animate({top: media_height / 2 + 45 });
					
					} else {
					
						/* align arrows to content container */
						$this.find('.next-portfolio-details').animate({top: $parent.height() / 2 + 45 });
						$this.find('.prev-portfolio-details').animate({top: $parent.height() / 2 + 45 });
					
					}
					
					
            });
						
		}		
		
		$(window).utresize(function(){
			update_portfolio_navigation_position();
		});
		        
		function update_portfolio_height_dynamic( wrap ) {
			            
			if( !wrap ) {
				return;
			} 	
			
            setTimeout(function() {
                            
                /* content is larger */
                if( wrap.parent().get(0).offsetHeight < wrap.parent().get(0).scrollHeight ){
                    
                    wrap.parent().height( wrap.parent().get(0).scrollHeight );
                    return;
                
                /* content is smaller */	
                } else {
                    
                    wrap.parent().height( wrap.height() );
                    return;
                
                }
            
            }, 200 );
					
		}
		
        
        
        /* trigger click on portfolio image since we cannot use direct links (lightbox double images) */
        $(document).on("click", ".ut-portfolio-trigger-link", function( event ) { 
        
            $( $(this).data("trigger") ).trigger('click');
            
            event.preventDefault();            
        
        });
        
        
		/* show portfolio detail */
		$(document).on("click", ".ut-portfolio-link", function(event) { 
						
			if( ut_is_animating ) {
				return false;
			}
			
			ut_is_animating = true;
									
			var portfolio_single_id = $(this).data('post'),
			    portfolio_wrap = $(this).data('wrap'),
			    $portfolio_loader = $('#ut-loader-' + portfolio_wrap),
			    $portfolio_wrap = $('#ut-portfolio-details-wrap-' + portfolio_wrap),
                $portfolio_details = $('#ut-portfolio-details-' + portfolio_wrap),
                $portfolio_details_nav = $('#ut-portfolio-details-navigation-' + portfolio_wrap),
			    $portfolio_detail = $portfolio_wrap.find('#ut-portfolio-detail-' + portfolio_single_id),
			    current_portfolio_single_id = $portfolio_details.find('.active').data('post'),
			    current_portfolio_pformat = $portfolio_details.find('.active').data('format'),
			    section_width = $(".ut-portfolio-wrap.ut-portfolio-"+ portfolio_wrap).data("slideup-width"),
                pformat = $portfolio_detail.data("format"),
                grid = '',
			    scroll_offset = $('#ut-header').outerHeight();
            
            var $anchor = $portfolio_wrap.is(":visible") ? $portfolio_wrap : $(".ut-portfolio-"+ portfolio_wrap);
            
            
			$portfolio_loader.stop(true).fadeIn( 200 , function() {				
				
				$.scrollTo( $anchor , 400 , {  easing: 'linear' , offset: -scroll_offset-$portfolio_details_nav.outerHeight()-60 , 'axis':'y' , onAfter : function(){ 
					
                    /* reset video on current portfolio */
                    if( current_portfolio_pformat === 'video' ) {
                        utResetVideo( $portfolio_details, current_portfolio_single_id );			
                    }	
                    
                    /* destroy slider */
                    if( current_portfolio_pformat === 'gallery' ) {
                        utResetGallery( $portfolio_details , current_portfolio_single_id );
                    }
                    
                    /* we need some extra padding for fullwidth layouts / sections */
					if( section_width === "centered" ) {
                        
                        $portfolio_details.addClass('grid-container');
                        $('#ut-portfolio-details-navigation-' + portfolio_wrap).addClass('grid-container');
                        grid = "grid-100";
                        
					}
                    
                    /* reset content as well */
                    if( portfolio_single_id !== current_portfolio_single_id ) {
                        utResetContent( current_portfolio_single_id );
                    }
                    
					/* hide all portfolio items first */
					$portfolio_details.find('.ut-portfolio-detail.active').attr("class", "animated ut-portfolio-detail clearfix").addClass(grid).fadeOut(200);
					
					/* create single portfolio detail */
					$portfolio_detail.attr("class", "animated ut-portfolio-detail clearfix").addClass(grid).addClass('active').css("visibility" , "hidden").show().slideDown( 400 , 'linear' , function() {

						/* box holds a slider , so we need to "recall" it */
						if( pformat === 'gallery' ) {
							
							utInitFlexSlider( portfolio_single_id , $portfolio_details , function() {   
								
                                utInitPortfolioContent( portfolio_single_id, portfolio_wrap, function() {
                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                        
                                        /* activate wrap */
                                        $portfolio_wrap.addClass('show');
                                                                            
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* now show the portfolio navigation*/
                                            $portfolio_details_nav.slideDown().addClass('show').data( "single" , portfolio_single_id );
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $(window).trigger("resize"); 
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 ).addClass('overflow-visible');
                                                $portfolio_detail.css("visibility" , "visible").addClass("animated zoomIn");
                                                
                                                /* trigger scroll for lazy image load */
                                                $.force_appear();
                                                $(window).trigger("scroll");
                                                
                                                
                                            }, 200);
                                            
                                            /* reset animating global */
                                            ut_is_animating = false;
                                                                                    
                                        });
                                                                            
                                    });
							    
                                });
                                	
							});  
							
						} else if( pformat === 'video' ) {
							
							utInitVideoPlayer( portfolio_single_id , function() { 
								
                                utInitPortfolioContent( portfolio_single_id, portfolio_wrap , function() { 
                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                        
                                        /* activate wrap */
                                        $portfolio_wrap.addClass('show');
                                                                            
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* now show the portfolio navigation*/
                                            $portfolio_details_nav.slideDown().addClass('show').data( "single" , portfolio_single_id );
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $(window).trigger("resize"); 
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 ).addClass('overflow-visible');                                                
                                                $portfolio_detail.css("visibility" , "visible").addClass("animated zoomIn");
                                                
                                            }, 200);
                                            
                                            /* trigger scroll for lazy image load */
                                            $(window).trigger("scroll");
                                            
                                            /* reset animating global */
                                            ut_is_animating = false;
                                        
                                        });
                                        
                                    });
							    
                                });
                                	
							}); 
							
						} else {
							
							utInitPortfolioImage( portfolio_single_id , $portfolio_details , function() { 
								                                
                                utInitPortfolioContent( portfolio_single_id, portfolio_wrap , function() {                                 	
                                    			
                                    $portfolio_loader.fadeOut( 200 , function() {
                                        
                                        /* activate wrap */
                                        $portfolio_wrap.addClass('show');
                                        
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* now show the portfolio navigation*/
                                            $portfolio_details_nav.slideDown().addClass('show').data( "single" , portfolio_single_id );
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $(window).trigger("resize"); 
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 ).addClass('overflow-visible');                                                
                                                $portfolio_detail.css("visibility" , "visible").addClass("animated zoomIn");
                                                
                                            }, 200);
                                            
                                            /* trigger scroll for lazy image load */
                                            $(window).trigger("scroll");
                                            
                                            /* reset animating global */
                                            ut_is_animating = false;
                                        
                                        });
                                                                            
                                    });
							
                                });
                            
							}); 
							
						}
							
					});
									
					
				}});
			
			});
			
			event.preventDefault();
			
		});

        
		
		/* next portfolio item */
		$(document).on("click", ".next-portfolio-details", function(event) { 
			
            event.preventDefault();
            
			if( ut_is_animating ) {
				return false;
			}
			
			ut_is_animating = true;
						
			var portfolio_wrap = $(this).data('wrap'),
			    $portfolio_wrap = $('#ut-portfolio-details-wrap-' + portfolio_wrap),
			    section_width = $(".ut-portfolio-wrap.ut-portfolio-"+ portfolio_wrap).data("slideup-width"),
                grid = '',    
			    $portfolio_details = $('#ut-portfolio-details-' + portfolio_wrap),
			    $portfolio_loader = $('#ut-loader-' + portfolio_wrap),

			    next_portfolio_single_id = $portfolio_details.find('.active').next().data('post'),
			    next_portfolio_pformat = $portfolio_details.find('.active').next().data('format'),
			    current_portfolio_single_id = $portfolio_details.find('.active').data('post'),
			    current_portfolio_pformat = $portfolio_details.find('.active').data('format'),
			    $portfolio_detail = $portfolio_details.find('#ut-portfolio-detail-' + next_portfolio_single_id);
            
			/* reset video on current portfolio */
			if( current_portfolio_pformat === 'video' ) {
				utResetVideo( $portfolio_details, current_portfolio_single_id );			
			}	
			
			/* destroy slider */
			if( current_portfolio_pformat === 'gallery' ) {
				utResetGallery( $portfolio_details , current_portfolio_single_id );
			}
            
            /* we need some extra padding for fullwidth layouts / sections */
            if( section_width === "centered" ) {

                $portfolio_details.addClass('grid-container');
                $('#ut-portfolio-details-navigation-' + portfolio_wrap).addClass('grid-container');
                grid = "grid-100";

            }
            
            /* reset content as well */
            utResetContent( current_portfolio_single_id );
            
			/* hide all current portfolio first */
			$portfolio_details.find('#ut-portfolio-detail-'+current_portfolio_single_id).attr("class", "animated ut-portfolio-detail clearfix").addClass("slideOutRight").fadeOut( 400, function(){	
				
                $(this).removeClass("slideOutRight");
                
				$portfolio_loader.stop(true).fadeIn( 200 , function() {
            							
                    /* create single portfolio detail */
                    $portfolio_detail.addClass('active').addClass(grid).css("visibility" , "hidden").show().slideDown( 400 , 'linear' , function() {
						  
                        /* box holds a slider , so we need to "recall" it */
                        if( next_portfolio_pformat === 'gallery' ) {
                            
                            utInitFlexSlider( next_portfolio_single_id , $portfolio_details , function() {   
                                
                                utInitPortfolioContent( next_portfolio_single_id, portfolio_wrap , function() {
                                    
                                    $portfolio_loader.fadeOut( 200 , function() {
                                        
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , next_portfolio_single_id );
                                        
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                            
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 );
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInLeft");
                                            
                                            }, 200);
                                            
                                            ut_is_animating = false;
                                        
                                        });
                                        
                                    });
                                    
                                });
                                    
                            });  
                            
                        } else if( next_portfolio_pformat === 'video' ) {
                            
                            utInitVideoPlayer( next_portfolio_single_id , function() { 
                                
                                utInitPortfolioContent( next_portfolio_single_id, portfolio_wrap , function() {
                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                                                                                            
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , next_portfolio_single_id );
                                        
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 );
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInLeft");
                                            
                                            }, 200);
                                             
                                            ut_is_animating = false;
                                        
                                        });
                                        
                                    });
                                
                                });
                                   
                            }); 
                            
                        } else {
                             
                            utInitPortfolioImage( next_portfolio_single_id , $portfolio_details , function() { 
                                
                                utInitPortfolioContent( next_portfolio_single_id, portfolio_wrap , function() {
                                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                                                            
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , next_portfolio_single_id );
                                                                        
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 );
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInLeft");
                                            
                                            }, 200);
                                            
                                            ut_is_animating = false;
                                        
                                        });
                                        
                                    });
                                
                                });
                                 
                            });
                        
                        } /* end if */
                									
					});	
            
            	});
				
			});
			
		});
		
		
		/* prev portfolio item */
		$(document).on("click", ".prev-portfolio-details", function(event) { 
			
            event.preventDefault();
            
			if( ut_is_animating ) {
				return;
			}
			
			ut_is_animating = true;
			
			var portfolio_wrap = $(this).data('wrap'),
			    $portfolio_wrap = $('#ut-portfolio-details-wrap-' + portfolio_wrap),
			    section_width = $(".ut-portfolio-wrap.ut-portfolio-"+ portfolio_wrap).data("slideup-width"),
                grid = '',   		    
                $portfolio_details = $('#ut-portfolio-details-' + portfolio_wrap),
			    $portfolio_loader = $('#ut-loader-' + portfolio_wrap),
			    prev_portfolio_single_id = $portfolio_details.find('.active').prev().data('post'),
			    prev_portfolio_pformat = $portfolio_details.find('.active').prev().data('format'),
			    current_portfolio_single_id = $portfolio_details.find('.active').data('post'),
			    current_portfolio_pformat = $portfolio_details.find('.active').data('format'),
			    $portfolio_detail = $portfolio_details.find('#ut-portfolio-detail-' + prev_portfolio_single_id);
            
			/* reset video on current portfolio */
			if( current_portfolio_pformat === 'video' ) {
				utResetVideo( $portfolio_details , current_portfolio_single_id );			
			}
			
			/* destroy slider */
			if( current_portfolio_pformat === 'gallery' ) {
				utResetGallery( $portfolio_details , current_portfolio_single_id );
			}
            
            /* we need some extra padding for fullwidth layouts / sections */
            if( section_width === "centered" ) {

                $portfolio_details.addClass('grid-container');
                $('#ut-portfolio-details-navigation-' + portfolio_wrap).addClass('grid-container');
                grid = "grid-100";

            }
            
            /* reset content as well */
            utResetContent( current_portfolio_single_id );
            						
			/* hide all current portfolio first */
			$portfolio_details.find('#ut-portfolio-detail-'+ current_portfolio_single_id ).attr("class", "animated ut-portfolio-detail clearfix").addClass("slideOutLeft").fadeOut( 400, function(){
			    
                $(this).removeClass("slideOutLeft");
                
				$portfolio_loader.stop(true).fadeIn( 200 , function() {
									
					/* create single portfolio detail */
					$portfolio_detail.addClass('active').addClass(grid).css("visibility" , "hidden").show().slideDown( 400 , 'linear' , function() {
					   
						/* box holds a slider , so we need to "recall" it */
						if( prev_portfolio_pformat === 'gallery' ) {
							
							utInitFlexSlider( prev_portfolio_single_id , $portfolio_details , function() {   
								
                                utInitPortfolioContent( prev_portfolio_single_id, portfolio_wrap , function() {
                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                        
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , prev_portfolio_single_id );
                                                                                                            
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 ); 
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInRight");
                                            
                                            }, 200);
                                            
                                            ut_is_animating = false;
                                        
                                        });
                                                                                                            
                                    });
							    
                                });
                                	
							});  
							
						} else if( prev_portfolio_pformat === 'video' ) {
							
							utInitVideoPlayer( prev_portfolio_single_id , function() { 
								
                                utInitPortfolioContent( prev_portfolio_single_id, portfolio_wrap , function() {
                                
                                    $portfolio_loader.fadeOut( 200 , function() {
                                                                                                            
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , prev_portfolio_single_id );
                                                                            
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                                 
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 );
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInRight");
                                            
                                            }, 200);
                                            
                                            ut_is_animating = false;
                                        
                                        });
                                                                        
                                    });
							    
                                });
                                	
							}); 
							
						} else {
							 
							utInitPortfolioImage( prev_portfolio_single_id , $portfolio_details , function() { 
								
                                utInitPortfolioContent( prev_portfolio_single_id, portfolio_wrap , function() {
                                				
                                    $portfolio_loader.fadeOut( 200 , function() {
                                                                                                            
                                        /* update portfolio navigation*/
                                        $portfolio_details.find('.ut-portfolio-details-navigation').data( "single" , prev_portfolio_single_id );
                                                                        
                                        /* now make portfolio detaials visible and adjust the portfolio navigation */
                                        $portfolio_detail.animate({ opacity: 1 } , 100 , 'linear' , function() {
                                            
                                            /* update portfolio detail navigation */
                                            update_portfolio_navigation( portfolio_wrap );
                                            
                                            /* set details height */
                                            setTimeout(function() {
                                            
                                                $portfolio_wrap.height( $portfolio_details.outerHeight() + 50 );
                                                $portfolio_detail.css("visibility" , "visible").addClass("slideInRight");
                                            
                                            }, 200);
                                            
                                            ut_is_animating = false;
                                        
                                        });
                                                                        
                                    });
							    
                                });
                                 
							});
						
						} /* end if */
															
					});	
				
				});
				
			});		
				
			
		
		});
		
		
		/* close portfolio detail */
		$(document).on("click", ".close-portfolio-details", function(event) { 
			
            event.preventDefault();
            
			if( ut_is_animating ) {
				return false;
			}
			
			ut_is_animating = true;
			
			var portfolio_wrap = $(this).data('wrap'),
				portfolio_single_id = $(this).parent().data("single"),
				$portfolio_wrap = $('#ut-portfolio-details-wrap-'+ portfolio_wrap ),
                $portfolio_details_nav = $('#ut-portfolio-details-navigation-'+ portfolio_wrap ),
				pformat	= $('#ut-portfolio-detail-'+portfolio_single_id).data("format");
							
			/* hide navigation */
			$portfolio_details_nav.removeClass('show').fadeOut( 400, function(){
                
                $(this).slideUp();
                
            });
			
			/* fade portfolio out */
			$portfolio_wrap.find('#ut-portfolio-detail-'+ portfolio_single_id ).attr("css", "animated ut-portfolio-detail clearfix").addClass("zoomOut").animate({ opacity: 0 } , 200 , 'linear' , function(){
				
                $(this).removeClass("zoomOut").css("visibility" , "hidden");
                
				/* collapse portfolio */				
                $('#ut-portfolio-details-wrap-'+portfolio_wrap).height(0).delay(800).queue(function(){
                    
                    $(this).removeClass('show').removeClass('overflow-visible').dequeue();
                    
                });
                
                /* reset video if needed */
				if( pformat === 'video' ) {
					utResetVideo( $portfolio_wrap , portfolio_single_id );
				}
				
				if( pformat === 'gallery' ) {
					utResetGallery( $portfolio_wrap , portfolio_single_id );
				}
				
                /* reset content as well */
                utResetContent( portfolio_single_id );
                
				ut_is_animating = false;
				
			});						
			
		
		});
		
		function utResetContent( portfolio_single_id ) {
            
            if( !portfolio_single_id ) {
				return;
			}
            
            $("#ut-portfolio-detail-"+portfolio_single_id).find(".entry-content").fadeOut( 600 , function() {                
                
				/* remove video */
				$(this).html("");
                $(this).show();
				
			});
            
        
        }        
        
		function utResetVideo( $portfolio_wrap , portfolio_single_id ) {
		
			if( !portfolio_single_id ) {
				return;
			}
			
			$portfolio_wrap.find("#ut-video-call-"+portfolio_single_id).fadeOut( -600 , function() {

				/* remove video */
				$(this).html("");
				
			});
		
		}
		
		function utResetGallery( $portfolio_wrap , portfolio_single_id ) {
		
			if( !portfolio_single_id ) {
				return;
			}
			
			if( $portfolio_wrap.find('#portfolio-gallery-slider-'+portfolio_single_id).hasClass("ut-sliderimages-loaded") ) {
				//$portfolio_wrap.find('#portfolio-gallery-slider-'+portfolio_single_id).flexslider('destroy');
			}
			
		}	
		
        /* load portfolio single content */
        function utInitPortfolioContent( postID, portfolioID , callback ) {
            
            if( !postID ) {
				return;
			}            
            
            var $portfolio = $('#ut-portfolio-detail-' + postID),			
				ajaxURL = utPortfolio.ajaxurl;
			
			 $.ajax({
					type: 'POST',
					url: ajaxURL,
					data: {
                        "action": "ut_get_portfolio_post_content", 
                        "portfolio_id": postID,
                        "show_title" : $('.ut-portfolio-'+portfolioID).data("slideup-title"),
                    },
					success: function(response) {
                        
						$portfolio.find(".entry-content").html(response).fitVids(); 
                        //$portfolio.find('.wp-audio-shortcode').mediaelementplayer();
                        
                        if ( $().lightGallery ) {
                        
                            $portfolio.lightGallery({
                                selector: '.ut-vc-images-lightbox',
                                hash: false
                            });
                        
                        }
                        
						return false;
						
					},
					complete : function() {
						
						if (callback && typeof(callback) === "function") {   
							callback();  
						}
						
					}
					
			});            
        
        }
        
		/* activate portfolio single player */
		function utInitVideoPlayer( postID , callback ) {
		
			if( !postID ) {
				return;
			}
			
			var $portfolio   = $('#ut-portfolio-detail-' + postID ),			
				ajaxURL = utPortfolio.ajaxurl;
			
			 $.ajax({
					type: 'POST',
					url: ajaxURL,
					data: {"action": "ut_get_portfolio_post", portfolio_id: postID },
					success: function(response) {
						
						$portfolio.find(".ut-video-call").show().html(response).fitVids();
						return false;
						
					},
					complete : function() {
						
						if (callback && typeof(callback) === "function") {   
							callback();  
						}
						
					}
					
			});
						
		}
		
		
        /* load portfolio single image */
        function utInitPortfolioImage( postID , $wrapOBJ , callback ) {
         
			if(!postID) {
				return;
			}
            
            var $img = $wrapOBJ.find("#ut-portfolio-detail-"+postID).find(".ut-load-me"),
                url  = $img.data("original");
            
            /* image has not been set yet */
            if( !$img.attr('src') ) {
            
                $img.attr('src', url ).one('load', function() {                    
                    
                    if (callback && typeof(callback) === "function") {   
                        
                        callback();
                          
                    }
                
                });
            
            /* image has been set, no need to load it again */
            } else {
                								
                if (callback && typeof(callback) === "function") {   
                    
                    callback(); 
                     
                }
            
            }
           
        }
        
		/* activate portfolio single slider */
		function utInitFlexSlider( postID , $wrapOBJ , callback ) {
			
			if(!postID) {
				return;
			}
			
			var $slider = $wrapOBJ.find('#portfolio-gallery-slider-'+postID);
			
			/* check if slider images were loaded previously */
			if( $slider.hasClass("ut-sliderimages-loaded") ) {
			 
				$slider.flexslider({							
										
						animation: 'fade',
						controlNav: false,
						animationLoop: true,
						slideshow: false,
						smoothHeight: true,
						startAt: 0,
						after: function(){
							
							update_portfolio_height_dynamic( $wrapOBJ );
							update_portfolio_navigation_position();
							
						}
											
				});
				
				if (callback && typeof(callback) === "function") {   
					callback();  
				}
				
			}			
			
			var $elems = $slider.find('.ut-load-me'), count = $elems.length;
						
			if( count ) {
                
				/* load images first */
				$elems.each(function() {
					
					var $this = $(this),

						url = $this.data("original");
									
					$this.attr('src', url ).removeClass('ut-load-me').one('load', function() {						
                        
                        if ( !--count ) {
                            
                            $slider.flexslider({							
                                    
                                animation: 'fade',
                                controlNav: false,
                                animationLoop: true,
                                slideshow: false,
                                smoothHeight: true,
                                startAt: 0,
                                after: function(){
                                    
                                    update_portfolio_height_dynamic( $wrapOBJ );
                                    update_portfolio_navigation_position();

                                }
                                                        
                            }).addClass("ut-sliderimages-loaded");
                            
                            if (callback && typeof(callback) === "function") {   
                                callback();  
                            }
                        
                        }						
						
					});				
				
				});
			
			} else {
				
				if (callback && typeof(callback) === "function") {   
					callback();  
				}
				
			}
		
		}
        
	});
    
})(jQuery);
 /* ]]> */