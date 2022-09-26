jQuery(document).ready(function($){


//Mobile menu accordian
jQuery('.menu-click,.close-menu a').on('click', function(){
    jQuery('.menu-inner').toggleClass('active');
});
homeHeight();

/* page builder row styles */
var row_container = $('body').data('container');
var fdn_cotainer = row_container;
$('.panel-row-style').each(function(){
    /* container */
    var row_co = $(this).data('container');
    if(row_co == null || row_co=='' || row_co == undefined){
        row_co = row_container;
    }
    $(this).find('.panel-grid-cell').wrapAll('<div class="'+row_co+'"></div>');

    
 });
/* container ends */

/* banner slider */
   var auto_play = true;
    var s_speed = parseInt( $('.top_slider').data('speed') );
    if( s_speed === 0 ){
        auto_play = false;
    }
    var a_speed = parseInt( $('.top_slider').data('animation') ); 
    $('.top_slider').flexslider({
        slideshow: auto_play,
        slideshowSpeed: s_speed,
        animationSpeed: a_speed,
        controlNav: false,
        directionNav: true,
        animationLoop: true,
        prevText: '<i class="fas fa-angle-left">',
        nextText: '<i class="fas fa-angle-right">',
        
    });
    $('.flex-direction-nav').addClass('container-large');


/* pagebuilder widget styles */
$('.panel-widget-style').each(function(){
    var title_color = $(this).data('title-color');
    if( title_color ){
        $(this).find('.compo-header h2').css('color',title_color);
    }
});




    $(".do-scrol").click(function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        var scrolltop = $(target).offset().top;
        $('html, body').animate({scrollTop: scrolltop }, 1500 );
    });


    jQuery('#siteHeader').on('keydown', function (e) {
        if ((e.which === 9 && !e.shiftKey)) {
            jQuery('#primary-menu .sub-menu li').css('opacity','1');
            jQuery('#primary-menu .sub-menu li').css('visibility','visible');
        }     

        if ((e.which === 9 && e.shiftKey)) {
            jQuery('#primary-menu .sub-menu li').css('opacity','1');
            jQuery('#primary-menu .sub-menu li').css('visibility','visible');
        }     
    });

    jQuery("#primary-menu li").hover(
      function() {
      
        jQuery('#primary-menu .sub-menu li').css('opacity','');
        jQuery('#primary-menu .sub-menu li').css('visibility','');
      }, function() {
       jQuery('#primary-menu .sub-menu li').css('opacity','');
       jQuery('#primary-menu .sub-menu li').css('visibility','');
      }
    );

//Filtering Portfolio

$(function() {
    var selectedClass = "";
    $(".fil-cat").click(function(){
        selectedClass = $(this).attr("data-rel");
        $("#portfolioWork").fadeTo(100, 0.1);
        $("#portfolioWork div").not("."+selectedClass).fadeOut().removeClass('scale-anm');
        setTimeout(function() {
            $("."+selectedClass).fadeIn().addClass('scale-anm');
            $("#portfolioWork").fadeTo(300, 1);
        }, 300);

    });
});
//Ends==========

$(".toolbar button").off().on("click", function () {
    $(".toolbar button").removeClass("active-work");
    $(this).addClass("active-work");

});

//Fixed footer
function fixFooter(){
    if($('#footer').hasClass('fixed-footer')){
        var spaceBtm = $('.fixed-footer').outerHeight();
        $('.body-wrapp').addClass('keepSpace');
        $('.keepSpace').css({
            'margin-bottom': spaceBtm - 24 + 'px'
        })
    }
}

fixFooter();

//Input form underline

$('.input-box').not(this).on('click', function(){
    $(this).parent().removeClass('has-border');
});

$('.input-box').off().on('focus', function(){
    $('.input-wrap').removeClass('has-border');
    $(this).parent().addClass('has-border');
});

//Popup setting=====================================
$('.fire-video-popup').off().on('click', function(){
    $('#videoPop').fadeIn(400);
    $('body').css({
        'overflow-y':'hidden'
    });
});

$('.custop-pop-close').off().on('click', function(){
    $('#videoPop').fadeOut(400);
    $('body').css({
        'overflow-y':'auto'
    });
});
//===================================================

//Menu trigger====================
$('.mobile-menu').on('click', function(){
    $(this).toggleClass('collapse-menu')
    $('.menu-main').slideToggle(400);
});


$('.is_mobile--menu li:last a').focusout(function(event){
    $('.collapse-menu a').focus();
});

$('.is_mobile--menu li.menu-item-has-children').click(function(event){
    $(this).find('ul').toggle();
});

//If no banner

if($('.body-wrapp').hasClass('no-banner')){
    var hdrHeight = $('.jr-site-header').outerHeight() + 'px';
    $('.jr-site-header + section, .jr-site-header + div').css({
        'paddingTop': hdrHeight
    });
}

//full width youtube video
$(function(){
    $('.jr-site-static-banner iframe').css({ width: $(window).innerWidth() + 'px', height: $(window).innerHeight() + 'px' });
  
    $(window).resize(function(){
      $('.jr-site-static-banner iframe').css({ width: $(window).innerWidth() + 'px', height: $(window).innerHeight() + 'px' });
    });
  });



//Skill bar js
$('.skillbar').each(function(){
    $(this).find('.skillbar-bar').animate({
        width:$(this).attr('data-percent')
    },2000);
});

//Accordian

$('.acc-title').off().on('click', function () {
    $('.acc-content').slideUp(400);
    $('.acc-title').removeClass('active');
    $(this).addClass('active');
    $(this).siblings('.acc-content').slideDown(400);
});





//Sticky Header =========

$(window).scroll(function () {
    var scrollTop = $(window).scrollTop();
    if(scrollTop > 80){
        $('.jr-site-header').addClass('scrolled')
    }
    else{
        $('.jr-site-header').removeClass('scrolled')
    }
});

$(window).resize(function(){
    homeHeight();
    $(window).trigger('resize.px.parallax');
});


/*-----------------------------------------------------------------------------------*/
/*  MENU
/*-----------------------------------------------------------------------------------*/
function calculateScroll() {
    var contentTop      =   [];
    var contentBottom   =   [];
    var winTop      =   $(window).scrollTop();
    var rangeTop    =   200;
    var rangeBottom =   500;
    $('.navmenu').find('.scroll_btn a').each(function(){
        contentTop.push( $( $(this).attr('href') ).offset().top );
        contentBottom.push( $( $(this).attr('href') ).offset().top + $( $(this).attr('href') ).height() );
    })
    $.each( contentTop, function(i){
        if ( winTop > contentTop[i] - rangeTop && winTop < contentBottom[i] - rangeBottom ){
            $('.navmenu li.scroll_btn')
            .removeClass('active')
            .eq(i).addClass('active');
        }
    })
};

jQuery(document).ready(function() {
    // if single_page
    if (jQuery("#page").hasClass("single_page")) {
    }
    else {
        $(window).scroll(function(event) {
            calculateScroll();
        });
        $('.navmenu ul li a, .mobile_menu ul li a, .btn_down').click(function() {
            $('html, body').animate({scrollTop: $(this.hash).offset().top - 80}, 1000);
            return false;
        });
    };
});



// utility functions 
function homeHeight(){
    var wh = jQuery(window).height() - 0;
    var ww = jQuery(window).width();
    var hh = jQuery('#siteHeader').height();
    hh = hh-25;
    if( ww > 767 ){
         jQuery('.top_slider, .top_slider .slides li').css('height', wh);
     }else{
        jQuery('.top_slider, .top_slider .slides li').css({'height':'350px' , 'margin-top':hh+'px'});
     }
   
}

  // makes sure the whole site is loaded
jQuery(window).load(function() {
        // will first fade out the loading animation
  jQuery("#status").fadeOut();
        // will fade out the whole DIV that covers the website.
  jQuery("#preloader").fadeOut();
});

});


var elemento = elemento || {};

// Set a default value for scrolled.
elemento.scrolled = 0;


elemento.primaryMenu = {

	init: function() {
		this.focusMenuWithChildren();
	},

	// The focusMenuWithChildren() function implements Keyboard Navigation in the Primary Menu
	// by adding the '.focus' class to all 'li.menu-item-has-children' when the focus is on the 'a' element.
	focusMenuWithChildren: function() {
		// Get all the link elements within the primary menu.
		var links, i, len,
			menu = document.querySelector( '.menu-main' );

		if ( ! menu ) {
			return false;
		}

		links = menu.getElementsByTagName( 'a' );

		// Each time a menu link is focused or blurred, toggle focus.
		for ( i = 0, len = links.length; i < len; i++ ) {
			links[i].addEventListener( 'focus', toggleFocus, true );
			links[i].addEventListener( 'blur', toggleFocus, true );
		}

		//Sets or removes the .focus class on an element.
		function toggleFocus() {
			var self = this;

			// Move up through the ancestors of the current link until we hit .primary-menu.
			while ( -1 === self.className.indexOf( 'primary-menu' ) ) {
				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					if ( -1 !== self.className.indexOf( 'focus' ) ) {
						self.className = self.className.replace( ' focus', '' );
					} else {
						self.className += ' focus';
					}
				}
				self = self.parentElement;
			}
		}
	}
}; // twentyt


function elementoDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}

elementoDomReady( function() {
	
	elemento.primaryMenu.init();          // Primary Menu.
	
} );

// Mobile Menu
(function($) {

  $.fn.sidebarmenu = function(options) {
      
      var sidebarmenuleft = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
       
        $(this).find("#menu-button").on('click', function(){
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) { 
            mainmenu.hide().removeClass('open');
          }
          else {
            mainmenu.show().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').show();
            }
          }
        });

        sidebarmenuleft.find('li ul').parent().addClass('has-sub');

        multiTg = function() {
          sidebarmenuleft.find(".has-sub").prepend('<a href="#" class="submenu-button"></a>');
          sidebarmenuleft.find('.submenu-button').on('click', function() {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').hide();
            }
            else {
              $(this).siblings('ul').addClass('open').show();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else sidebarmenuleft.addClass('dropdown');

        if (settings.sticky === true) sidebarmenuleft.css('position', 'fixed');

      });
  };
})(jQuery);

(function($){
$(document).ready(function(){

$("#sidebarmenuleft").sidebarmenu({
   title: "Menu",
   format: "multitoggle"
});

});
// closebtn
$('.mobileshow ul li:last').focusout(function(){
    $('.closebtn').focus();
});

})(jQuery);

document.getElementById("mySidenav").style.display = "none";

function openNav() { 
    document.getElementById("mySidenav").style.width = "300px";
    document.getElementById("mySidenav").style.display = "block"; 
}

function closeNav() { 
    document.getElementById("mySidenav").style.width = "0"; 
    document.getElementById("mySidenav").style.display = "none";
}