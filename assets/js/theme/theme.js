/**
*  Theme js functions
*
*/

//Variables
var ajaxurl         = hcc_ajax_params.ajaxurl;
var home_url        = hcc_js_custom_params.home_url;
var is_404_url      = hcc_js_custom_params.is_404;
var error_header    = hcc_ajax_params.error_header;
var error_body      = hcc_ajax_params.error_body;
var success_header  = hcc_ajax_params.success_header;
var success_body    = hcc_ajax_params.success_body;
var cfThankYou      = hcc_ajax_params.cfThankYou;
var more_text       = hcc_ajax_params.more_text;
var error_text      = hcc_ajax_params.error_text;
var load_text       = hcc_ajax_params.load_text;

jQuery( document ).ready(function($) {
    Loader();
    smoothScroll();
    StickyHeader();
    switcherTheme(); //Switch color scheme of theme
    FeedBackButton(); //Enable contact button
    SlickCarousel(); //  Slick jQuery slider
    SectionCount(); // Count sections
    slideDown(); // Slide to next section
    fancyboxInitial(); //Including Fancybox
    waterweellCarousel(); //  Waterweell jQuery slider
    overlayHide();
    mobileMenu();
});
     
// Preloader
function Loader(){
    $(function(){
        $preloader = $('.loaderArea'),
        $loader = $preloader.find('.loader');
        $loader.fadeOut();
        $preloader.delay(450).fadeOut('slow');
        //Modal form. Show & Hide
        modalForms();
    });
}
//  Slick jQuery slider
function SlickCarousel(){
      try{
          let SlickSlider = $('.slick-slider');
          if($("div").is( SlickSlider )){
                
                SlickSlider.each(function(){
                   $(this).slick({
                        infinite: false,
                        arrows: true,
                        dots: false,
                        prevArrow:"<button type='button' class='slick-prev pull-left'><img src='" + hcc_js_custom_params.theme_url + "img/icons/a-left-min.png'></button>",
                        nextArrow:"<button type='button' class='slick-next pull-right'><img src='" + hcc_js_custom_params.theme_url + "img/icons/a-right-min.png'></button>",
                        //appendArrows: $('.slider-navigation'),
                        slidesToShow: 1,
                        autoplay: true,
                        autoplaySpeed: 8000,
                   }); 
                }); 
                
            }
      }
      catch(e){
          console.log('Problem with Slick jQuery plugin');
      }   
}
//  Waterweell jQuery slider
function waterweellCarousel(){
      try{
          let waterwallSlider = $('.waterwall-slider');
          let reviewsWrap     = $('.reviews-wrap');
          
          if($("div").is( waterwallSlider )){
                
                waterwallSlider.each(function(){
                   var nextArrow  = reviewsWrap.find('.review-next');
                   var prevArrow  = reviewsWrap.find('.review-prev');
                   var carousel   = $(this).waterwheelCarousel({
                        startingItem:1,
                        opacityMultiplier:1,
                        flankingItems:2,
                        linkHandling:1,
                        keyboardNav:true,
                        imageNav:false,
                    });
                    if(nextArrow){
                          nextArrow.on('click', function(){
                              carousel.next();
                              return false;
                          });
                    }
                    if(prevArrow){
                          prevArrow.on('click', function(){
                              carousel.prev();
                              return false;
                          });
                    }
          
                }); 
                
          }
          
      }
      catch(e){
          console.log('Problem with Waterweell jQuery plugin');
      }   
}

function smoothScroll(){
	$("a[href^='#']").on('click', function(event) {
		if (this.hash !== "") {
			event.preventDefault();
			if (this.hash == "#masthead") {
				$('html, body').animate({
					scrollTop: 0
				}, 800, function(){
				});
			} else {
				var hash = this.hash;
				$('html, body').animate({
					scrollTop: $(hash).offset().top
				}, 800, function(){
				});
			}
		};
	});
}

function StickyHeader(){
        let nav = $('#masthead');
        let mywindow = $(window);
        let mypos = mywindow.scrollTop();
        let up = false;
        let newscroll;
        if ( $(window).width() > 1200 ) {
            $(window).scroll(function () {
                newscroll = mywindow.scrollTop();
                if ($(this).scrollTop() > 0) {
                    nav.addClass("sticky");
                }else{
                    nav.removeClass("sticky");
                }
                mypos = newscroll;
            });
        }
}

function iasInitial( elem ){
    try{
        let name            = elem.attr('data-ias');
        if( typeof name ==="undefined" || name === null || name === '' ){
            return false;
        }
        let containerClass  = name + '-container';
        let container       = elem.find('.ias-container').addClass( containerClass );
        containerClass      = '.' + containerClass;
        let itemClass       = name + '-item';
        let item            = elem.find('.ias-item').addClass( itemClass );
        itemClass           = '.' + itemClass;
        let paginationClass = 'pagination-' + name;
        let pagination      = elem.find('.pagination').addClass( paginationClass );
        paginationClass     = '.pagination.' + paginationClass;
        let nextClass       = 'next-' + name;
        let next            = pagination.find('.next.page-numbers').addClass( nextClass );
        nextClass           = '.page-numbers.' + nextClass;
          
        var ias = $.ias( {
                      container:  containerClass,
                      item:       itemClass,
                      pagination: paginationClass,
                      next:       nextClass,
                     //loader      : "<img src='/img/loading.gif'>",
        });
        
        console.log( ias );

        ias.extension( new IASTriggerExtension( { offset: 1 } ) );
        ias.extension( new IASSpinnerExtension() );
        ias.extension( new IASNoneLeftExtension() );
            
    }
    catch(e){
          console.log('Problem with Ias jQuery plugin');
    }   
}

function WaipointsInitial( name ){
        try{
            let data            = name.attr('data-ias');
            let paginationClass = data + '-next';
            let itemClass       = data + '-item';
            let item            = name.find('.infinite-item').addClass(itemClass);
            itemClass           = '.' + itemClass;
            let paginationNext  = name.find('.next.page-numbers').addClass(paginationClass);
            paginationClass     = '.' + paginationClass;
            var infinite = new Waypoint.Infinite({
              element: name.find('.infinite-container')[0],
              container: 'auto',
              items: itemClass,
              loadingClass: 'infinite-loading',
              more: paginationClass,
              offset: 'bottom-in-view',
              onBeforePageLoad: $.noop,
              onAfterPageLoad: $.noop
            }); 
        }  
        catch(e){
            console.log('Problem with Waipoints jQuery plugin');
        }
}

function fancyboxInitial(){
    try{
        $('.review-modal').fancybox({protect: true,cyclic:true});
    }
    catch(e){
          console.log('Problem with Fancybox jQuery plugin');
    }   
}

function SectionCount(){
    var section = $(document).find('section');
    section.eq(0).addClass('main-section');
    var counter = 1;
    section.each(function(){
            name = 'section-' + counter;
            $(this).attr('data-id', name );
            counter++;
    });
}

function slideDown(){
    var counter = 1;
    $('section').each(function(){
        counter++;
        let toDown          = $(this).find('.arrow-to-next');
        let sectionNextName = 'section[data-id="section-' + counter + '"]';
        let sectionNextId   = $(sectionNextName).attr('id');
        toDown.attr('href', '#' + sectionNextId);
    });
}

function mobileMenu(){
    let MenuBurger = $('.burger');
    let ButtonWrap = $('.contact-button-wrap');
    let header     = $('#masthead');
    let overlay    = $('.overlay');
    MenuBurger.on('click', function(){
        $(this).toggleClass('active');
        header.toggleClass('opened closed');
        $('body').toggleClass('noscroll modal-open');
        overlay.toggleClass('on');
        ButtonWrap.removeClass('active'); 
        ButtonWrap.find('.button-tel').removeClass('active'); 
        ButtonWrap.find('.buttons-socials').removeClass('active');
    });
        
    $('nav').find('.inside-link').on('click',function(){
            MenuBurger.removeClass('active');
            header.removeClass('opened');
            $('body').removeClass('noscroll modal-open');
            overlay.removeClass('on');
    });
}

function overlayHide(){
    $('.overlay').on('click', function(){
        $(this).removeClass('on');
        $('body').removeClass('noscroll modal-open');
        $('.burger').removeClass('active');
        $('#masthead').removeClass('opened').addClass('closed');
    });
}

function switcherTheme(){
    let switcher = $('.switcher');
    switcher.on('click', function(){
        let ButtonWrap = $('.contact-button-wrap');
        ButtonWrap.removeClass('active');
        ButtonWrap.find('.button-tel').removeClass('active');
        ButtonWrap.find('.buttons-socials').removeClass('active');
    });
    switcher.find('.light-theme').on('click', function(){
            switcher.removeClass('moon').addClass('sun');
            $('section').removeClass('dark-theme').addClass('light-theme');
            switcher.attr('data-theme', 'light-theme');
    });
    switcher.find('.dark-theme').on('click', function(){
            switcher.removeClass('sun').addClass('moon');
            $('section').removeClass('light-theme').addClass('dark-theme');
            switcher.attr('data-theme', 'dark-theme');
    });
}

function FeedBackButton(){
    let container = $('.contact-button-wrap');
    let button = container.find('.button-tel');
    button.on('click', function(){
       container.toggleClass('active'); 
       $(this).toggleClass('active'); 
       $(this).siblings('.buttons-socials').toggleClass('active');
    });
    container.find('.one-social').on('click', function(e){
            if( $(this).hasClass('message') ){
                e.preventDefault();
                showStronglyForm( $('.modal-form') );
            }
            setTimeout( hideFeedBackInner, 200 );
    });
    container.on('click', function(e){
            hideFeedBackInner();
    }).on('click', 'div', function(e) {
            e.stopPropagation();
    });
}

function hideFeedBackInner(){
       let ButtonWrap = $('.contact-button-wrap');
       ButtonWrap.removeClass('active'); 
       ButtonWrap.find('.button-tel').removeClass('active'); 
       ButtonWrap.find('.buttons-socials').removeClass('active');
}