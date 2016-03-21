"use strict";
function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{1,4})?$/;
    if (!emailReg.test(email)) {
        return false;
    } else {
        return true;
    }
}
function validateContactNumber(number) {
    var numberReg = /^((\+)?[1-9]{1,3})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
    if (!numberReg.test(number)) {
        return false;
    } else {
        return true;
    }
}
function validateTextOnly(text) {
    var textReg = /^[A-z]+$/;
    if (!textReg.test(text)) {
        return false;
    } else {
        return true;
    }
}
function validateNumberOnly(number) {
    var numberReg = /^[0-9]+$/;
    if (!numberReg.test(number)) {
        return false;
    } else {
        return true;
    }
}
function checkElementValidation(child, type, check, error) {
    child.parent().find('.alert').remove();
    if ( child.val() == "" && child.attr("data-required") == "required" ) {
      child.removeClass("success");
      child.addClass("error");
      child.parent().append('<div class="alert alert-warning"><i class="fa fa-exclamation"></i>' + child.parents("form").attr("data-required") + '</div>');
      child.parent().find('.error-message').css("margin-left", -child.parent().find('.error-message').innerWidth()/2);
      return false;
    } else if( child.attr("data-validation") == type && 
      child.val() != "" ) {
      if( !check ) {
        child.removeClass("success");
        child.addClass("error");
        child.parent().append('<div class="alert alert-warning"><i class="fa fa-exclamation"></i>' + error + '</div>');
        child.parent().find('.error-message').css("margin-left", -child.parent().find('.error-message').innerWidth()/2);
        return false;
      }
    }
    child.removeClass("error");
    child.addClass("success");
    return true;
}
function checkFormValidation(el) {
    var valid = true,
    children = el.find('input[type="text"], textarea');
    children.each(function(index) {
        var child = children.eq(index);
        var parent = child.parents("form");
        if( !checkElementValidation(child, "email", validateEmail(child.val()), parent.attr("data-email")) ||
            !checkElementValidation(child, "phone", validateContactNumber(child.val()), parent.attr("data-phone")) ||
            !checkElementValidation(child, "text_only", validateTextOnly(child.val()), parent.attr("data-text")) ||
            !checkElementValidation(child, "number", validateNumberOnly(child.val()), parent.attr("data-number")) 
        ) {
            valid = false;
        }
    });
    return valid;
}
jQuery.fn.isOnScreen = function(){
     
    var win = jQuery(window);
     
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
     
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
     
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
     
};
jQuery.fn.serializeObject = function()
{
var o = {};
var a = this.serializeArray();
jQuery.each(a, function() {
    if (o[this.name]) {
        if (!o[this.name].push) {
            o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || '');
    } else {
        o[this.name] = this.value || '';
    }
});
return o;
};

jQuery(function($) { 
  /* Top bar */
  function topBarSize() {
    var el = $('.top-bar .container');
    el.css( {
      'display' : 'none',
      'height'  : 'auto' 
    }).attr('data-height', el.height()).attr('style', 'height: 0;').parent().removeClass('open');
  }
  $('.top-bar .close').on('click', function() {
    var el = $('.top-bar');
    var child = $('.top-bar .container');
    el.toggleClass('open');  
    if( el.hasClass('open') ) {
      child.height(child .attr('data-height'));
    } else {
      child.attr('style', 'height: 0;');
    }
  });
  topBarSize();
  $(window).resize(function() {
    topBarSize();
    siteNavigationSizing();
    //fixboxes();
  });
  /* Megamenu */
  $('.megamenu > .sub-menu').addClass('container').removeClass('sub-menu').wrap('<div class="sub-menu">');
  $('.megamenu .container *').removeClass('sub-menu menu-item-has-children-parent menu-item-has-children');
  $('.megamenu .container > li:first-of-type').addClass('col-md-offset-1');
  $('.megamenu .container > li > a').each(function() {
    $(this).replaceWith($('<h4>' + $(this).html() + '</h4>'))
  });


 
  /* Site navigation dropdown */
  function siteNavigationSizing() {
    var el = $('.site-navigation > ul > li.menu-item-has-children, .site-navigation > ul > li.menu-item-has-children-parent');
    el.each(function(index) {
      var child = el.eq(index).children(".sub-menu");
      child.css({
        'display' : 'none',
        'height'  : 'auto'
      });
      child.attr('data-height', child.height());
      child.attr('style', '');
      el.addClass('menu-item-has-children-parent');
      el.removeClass('menu-item-has-children');
    });
  }
  siteNavigationSizing()
  var navInterval = ""
  $('.site-navigation > ul > li').hover(function() {
    if( $('body').width() > 993 ) {
      var el = $(this).children(".sub-menu");
      el.css('height', el.attr('data-height'));
      navInterval = setInterval(function() {
        el.css("overflow", "visible");
        clearInterval(navInterval);
      }, 300 );
    }
  }, function() {
    $(this).children(".sub-menu").attr('style', '');
    clearInterval(navInterval);
  });

  $('.site-search .close').on('click', function() {
    $('.site-search .container').removeClass('open');    

    if ($('.site-wrapper').hasClass('search-is-open')){
        $('.site-wrapper').removeClass('search-is-open');
    } 

  })
  /* Mobile navigation */
  $('.navbar-toggle').on('click', function() {
    $('.site-navigation').toggleClass('open');

    if( $('.nav-wrap.sticky').length && $('.site-navigation').hasClass('open') && $(window).width() <= 992 ) {
      $(window).scrollTop(0);
      $('.nav-wrap.sticky').removeClass('sticky');
      $('.nav-wrap').addClass('unstick');
    }
    if ( !$('.site-navigation').hasClass('open') && $('.nav-wrap').hasClass('unstick')) {
              $('.sticky-holder').height( 0 );
        }
  })

  /*sticky*/

    if ($('header.site-header').hasClass('sticky')) {

      var vp_height = $(window).height();   // returns height of browser viewport
      var w_height = $(document).height(); // returns height of HTML document
      var navtop_offset = $('.nav-wrap').offset().top;
      var navtop_height = $('.nav-wrap').outerHeight();
      
      jQuery(window).scroll(function() {
        
            if( jQuery(window).scrollTop() > navtop_offset && !$('header.site-header').hasClass('notsticky') && w_height > (vp_height + navtop_height + navtop_offset ) ) {  //notsticky is just for colorpicker
              if (!$('.nav-wrap').hasClass('sticky')&& !$('nav.site-navigation').hasClass('open')) {
                $('.nav-wrap').addClass('sticky');
                $('.sticky-holder').height( navtop_height );
                if ($('.nav-wrap').hasClass('unstick')) {
                        $('.nav-wrap').removeClass('unstick');
                    }
              }

            }
            else {
                if( $('.nav-wrap').hasClass('sticky')) {
                      $('.nav-wrap').removeClass('sticky');
                      $('.sticky-holder').height( 0 );
                      if (!$('.nav-wrap').hasClass('unstick')) {
                        $('.nav-wrap').addClass('unstick');
                      }
                }
            }

      });
    }


  /* Tabs */
  $('.nav-tabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  });
  /* Contact Form on SUBMIT */
  $('input[type="text"], textarea').on("blur", function(){
      var parent = $(this).parents("form");
      if( !checkElementValidation($(this), "email", validateEmail($(this).val()), parent.attr("data-email")) ||
          !checkElementValidation($(this), "phone", validateContactNumber($(this).val()), parent.attr("data-phone")) ||
          !checkElementValidation($(this), "text_only", validateTextOnly($(this).val()), parent.attr("data-text")) ||
          !checkElementValidation($(this), "number", validateNumberOnly($(this).val()), parent.attr("data-number"))) {
      }
  });
  $('[data-form="submit"]').on('click', function(e) {
      $(this).parents('form.contact-form').submit();
      e.preventDefault();
  });
  $("form.contact-form").on("submit", function(e) {
      $(".contact-success").remove();
      var el = $(this);
      var formData = el.serializeObject();
      if(checkFormValidation(el)) {
          try {
              $.ajax({
                  type: "POST",
                  url: $('#theme-path').val() + '/includes/' + 'mail.php',
                  data: {
                      form_data : formData,
                  }
              }).success(function(msg) {
                $("form.contact-form").append('<div class="row"><div class="col-md-12"><div class="alert alert-success contact-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check"></i>' + $("form.contact-form").attr("data-success") + '</div></div></div>');
                $('.alert .close').on('click', function() {
                  $(this).parent().remove();
                });
              });
          } catch(e) { console.log(e); }
      }
      e.preventDefault();
      return false;
  });

 
  /* Contact Form on Clear */
  $('[data-form="clear"]').on('click', function() {
      var el = $(this).parents('form.contact-form').find('input[type="text"], textarea');
      el.each(function(index) {
          el.eq(index).val("");
          el.eq(index).removeClass("error success");
          el.eq(index).parent().find(".alert").remove();
      });
      if( $(this).parents('form.contact-form').next().hasClass("success") ) {
          $(this).parents('form.contact-form').next().remove();
      }
      return false;
  });  
  /* Portfolio */
    var $container = $('.isotope'); 
        // bind filter button click
    var $filters = $('.filter button').on( 'click', function() { 
        $('.filter button').removeClass('selected');
        $(this).addClass("selected");
      var filterAttr = $(".filter li button.selected").attr('data-filter'); 
      // set filter in hash
      location.hash = 'filter=' + encodeURIComponent( filterAttr );
    });

    var isIsotopeInit = false;

    function onHashchange() {
      var hashFilter = getHashFilter(); 
      if(hashFilter==null) {
          hashFilter = "*";
      }
      if ( !hashFilter && isIsotopeInit ) { 
        return;
      }
      var item = "";
      if( hashFilter != '*' ) {
          item = ".";
      }
      item += hashFilter; 
      isIsotopeInit = true; 
      $('.filter li button[data-filter="'+hashFilter+'"]').addClass('selected');
      // filter isotope
      if($(".portfolio.isotope").length) { 
        $container.isotope({
          itemSelector : '.isotope-item',
          layoutMode: 'fitRows',
          filter: item
        }); 
      }
    }

    $(window).on( 'hashchange', onHashchange );
    // trigger event handler to init Isotope
    onHashchange();
 
  /* Portfolio Random */
  try {
    var $containerRandom = $('.isotope.random');
    if($containerRandom.length) {
      var first_scroll = true;
      $(window).scroll(function() {
          if(first_scroll) {
              $containerRandom.isotope();
              first_scroll = false;
          }
      });
      $(window).focus(function(){
          $containerRandom.isotope();
      });
      $containerRandom.isotope({
          itemSelector : '.isotope li',
          layoutMode: 'masonry',
          masonry: {
            columnWidth: 292
          }
      });
      $('.filter button').on('click', function() {
          $('.filter button').removeClass('selected');
          $(this).addClass("selected");
          var item = "";
          if( $(this).attr('data-filter') != '*' ) {
              item = ".";
          }
          item += $(this).attr('data-filter');
          $containerRandom.isotope({ filter: item });
      });
      $(window).resize(function(){
       if ($(".isotope").length && $('.filter button.selected').length) {
          var item = "";
          if( $('.filter button.selected').attr('data-filter') != '*' ) {
              item = ".";
          }
          item += $('.filter button.selected').attr('data-filter');
          $containerRandom.isotope({ filter: item });
          $(".isotope").isotope('layout');

          if( $('.col-md-12').width() == 940 ) {
            console.log(111);
            $containerRandom.isotope({
                masonry: {
                  columnWidth: 242
                },
                layoutMode: 'masonry',
            });            
          } else if( $('.col-md-12').width() == 1140 ) {
            $containerRandom.isotope({
                masonry: {
                  columnWidth: 292
                },
                layoutMode: 'masonry',
            });          
          } else {
            $containerRandom.isotope({
                layoutMode: 'fitRows',
            });               
          }
        } else {
          var $containerRandom = $('.isotope.random');
            $containerRandom.isotope({
                layoutMode: 'fitRows'
            });  
            
            //$containerRandom.isotope( 'reloadItems' )

              //$containerRandom.isotope('reloadItems');
              //$containerRandom.isotope('destroy');
        }
      });
      if( $('.col-md-12').width() == 940 ) {
        console.log(111);
        $containerRandom.isotope({
            masonry: {
              columnWidth: 242
            },
            layoutMode: 'masonry',
        });            
      } else if( $('.col-md-12').width() == 1140 ) {
        $containerRandom.isotope({
            masonry: {
              columnWidth: 292
            },
            layoutMode: 'masonry',
        });          
      } else {
        $containerRandom.isotope({
            layoutMode: 'fitRows',
        });               
      }
      $(document).ready(function(){
        $(window).load(function() {
          $(".isotope").isotope('layout');
        });
      });
    }
  } catch (e) { }
  /* Blog masonry */

   
  try {
    var $containerMasonry = $('.blog-masonry');
    $containerMasonry.imagesLoaded( function() {
      if($containerMasonry.length) {
        $containerMasonry.isotope({
            itemSelector : '.blog-masonry .post',
            animationOptions: {
                duration: 750,
                queue: false,
            }
        });
        $(window).resize(function() {
            $containerMasonry.isotope('layout');
        });
        $(window).focus(function(){
            $containerMasonry.isotope('layout');
        });
        $(document).ready(function() {
          $(window).load(function() {
            $containerMasonry.isotope('layout');
          });
        });
      }
    });
  } catch (e) { }
  /* Twitter */
  try {
    $("[data-twitter]").each(function(index) {
        var el = $("[data-twitter]").eq(index);
        $.ajax({
            type: "POST",
            url: 'http://localhost:8004/assets/php/twitter.php',
            data: {
              account : el.attr("data-twitter")
            },
            success: function(msg) {
              el.find(".carousel-inner").html(msg);
            }
        });
        
    });
  } catch(e) {}
  function checkForOnScreen() {
    $('.counter-number').each(function(index) {
      if(!$(this).hasClass('animated') && $('.counter-number').eq(index).isOnScreen()) {
        $('.counter-number').eq(index).countTo({
          speed: 5000
        });
        $('.counter-number').eq(index).addClass('animated');
      }
    });
  }
  checkForOnScreen();
  $(window).scroll(function() {
    checkForOnScreen();
  });
  /* Fullscreen */
  if ($(window).height > 700)
  {
  $('.fullscreen').css('height', $(window).height() + 'px'); //menu position on home page
   }


  /* Navigation links (smooth scroll) */ 
  $('.site-navigation a[href*=#]:not([href=#])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
          || location.hostname == this.hostname) {
        var target = $(this.hash);
        var href = $.attr(this, 'href');
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          var $targetoffset = target.offset().top - $('.nav-wrap').outerHeight(true) + 20;  
          

          $('html,body').animate({
           // scrollTop: target.offset().top 
           scrollTop: $targetoffset
          }, 1000 //, function () {
            //  window.location.hash = href;
          //}

          );
          return false;
        }
      }
  });
  /* Waypoints */

if ($('body').hasClass('home'))
{
  var navLinkIDs = "";
  $('.site-navigation a[href*=#]:not([href=#])').each(function(index) {
      if(navLinkIDs != "") {
          navLinkIDs += ", ";
      }
      var temp = $('.site-navigation a[href*=#]:not([href=#])').eq(index).attr("href").split('#');
      navLinkIDs += '#' + temp[1];

  });
  if( navLinkIDs ) {
    $(navLinkIDs).waypoint(function(direction) {
        if(direction=='down') {
            $('.site-navigation a').parent().removeClass("current_page_item");
            $('.site-navigation a[href="#'+$(this).attr('id')+'"]').parent().addClass("current_page_item");
        }
    }, { offset: 125 });
    $(navLinkIDs).waypoint(function(direction) {
        if(direction=='up') {
            $('.site-navigation a').parent().removeClass("current_page_item");
            $('.site-navigation a[href="#'+$(this).attr('id')+'"]').parent().addClass("current_page_item");
        }
    }, {  offset: function() {
        return -$(this).height() + 20;
    } });
  }

}

 $('.nav-wrap .fa-search').on('click', function() {

  if ($('body').hasClass("home")) { 
    
    if ($('.site-wrapper').hasClass('search-is-open')){
        $('.site-wrapper').removeClass('search-is-open');
    } else {
      $('.site-wrapper').addClass('search-is-open');
    }

    var home_height = $('.forcefullwidth_wrapper_tp_banner').height();
    var home_outerheight = $('.forcefullwidth_wrapper_tp_banner').outerHeight();
    if ($('.site-header').hasClass('style-3') && !$('.site-search > .container').hasClass('open')) {
          $('.site-search .container').toggleClass('open');
          $("html, body").animate({ scrollTop: 72}, "slow");
          //alert('0');
    }
    else {

        if (home_height > "100" && $('.nav-wrap').hasClass('style-3')){
            $('.site-search .container').toggleClass('open');
            $("html, body").animate({ scrollTop: 0}, "slow");
            //alert('1');
        }
        //transparent top
        else if (home_height > "100" && !$('.nav-wrap').hasClass('style-3') && $('header.site-header').hasClass('style-1')){
            $('.site-search .container').toggleClass('open');
            $("html, body").animate({ scrollTop: $(".site-search").offset().top}, "slow");
        }
        else if (home_height > "100" && !$('.nav-wrap').hasClass('style-3')){
            $('.site-search .container').toggleClass('open');
            $("html, body").animate({ scrollTop: $(".site-search").offset().top}, "slow");
            //alert('test');
        }
        else {
            $('.site-search .container').toggleClass('open');
            $("html, body").animate({ scrollTop: $(".site-search").offset().top}, "slow");

        }
    } 
  }

  else
  {
       $('.site-search .container').toggleClass('open');
      $("html, body").animate({ scrollTop: $(".site-search").offset().top }, "slow");
      //alert('5');
  } 
   
  });


  /* WordPress specific */
  // Comment buttons
  $('button[data-form="clear"]').on('click', function() {
     $('textarea, input[type="text"]').val(''); 
  });
  $('button[data-form="submit"]').on('click', function() {
     $('.form-submit #submit').click(); 
  });
  // Search widget
  $('.widget_product_search form').addClass('searchform');
  $('.searchform input[type="submit"]').remove();
  $('.searchform div').append('<button type="submit" class="fa fa-search" id="searchsubmit" value=""></button>');
  $('.searchform input[type="text"]').attr('placeholder', 'Search...');

  $('.blog-masonry').parent().removeClass('col-md-12');
  $('.post.style-3').parent().parent().removeClass('col-md-12').parent().removeClass('col-md-12');

  //$("a[rel^='prettyPhoto']").prettyPhoto();

  $('.site-navigation > div > ul').unwrap();

  $('.show-register').on('click', function() {
    $('#customer_login h3, #customer_login .show-register').addClass('hidden');
    $('#customer_login .register').removeClass('hidden');
  });


/*Force VC to use the lightbox we like*/
/*disable prettyphoto in VC*/
if (typeof rlArgs !== 'undefined') {
window.vc_prettyPhoto = function () {}
}


/*lightbox for VC*/
$('.wpb_single_image .wpb_wrapper a[href$=".jpg"], .wpb_single_image .wpb_wrapper a[href$=".png"], .wpb_single_image .wpb_wrapper a[href$=".gif"]').attr('rel', 'lightbox');

//$( document ).ajaxComplete(function() {
  $(window).load(function() {
  //alert(rlArgs.script);
  if (typeof rlArgs.script !== 'undefined') {

      if ( rlArgs.script === 'swipebox' ) {
        $('.prettyphoto').swipebox();
      } else if ( rlArgs.script === 'prettyphoto' ) {
        $('.prettyphoto').prettyPhoto();
      } else if ( rlArgs.script === 'fancybox' ) {
        $('.prettyphoto').fancybox();
      } else if ( rlArgs.script === 'nivo' ) {
        $('.prettyphoto').nivoLightbox();
      } else if ( rlArgs.script === 'imagelightbox' ) {
        $('.prettyphoto').imageLightbox();
      }
  } 
});

$(document).ready(function(){
    $('.parallax-window[data-type="background"]').each(function(){
        var $bgobj = $(this); // assigning the object
    
        $(window).scroll(function() {
            var yPos = -($(window).scrollTop() / $bgobj.data('speed')); 
            
            // Put together our final background position
            var coords = '50% '+ yPos + 'px';

            // Move the background
            $bgobj.css({ backgroundPosition: coords });
        }); 
    });    
});


});


/* fix horizontal height of boxes */

/*outdated function, left here for reference*/
var fixboxes = function() {
  
  jQuery('ul.portfolio li.isotope-item article.inner') .each(function() {
    var box_height=jQuery(this).height();
    jQuery(this).find('a.item-hover').css({"height": box_height +'px'});
  });

//  jQuery('ul.recentportfolio li.item') .each(function() {
//    var $this = this;
//    var box_height=jQuery(this).height();
//    jQuery($this).find('a.item-hover').css({"height": box_height +'px', "padding-top":"0"});
//    jQuery($this).find('.item-info').css({"height": box_height +'px', "top":"0"});
//  });

  jQuery('.recentblog header') .each(function() {
    var $this = this;
    var box_height=jQuery(this).find('.item-img').height();
    jQuery($this).find('a.post-hover').css({"height": box_height +'px'});
  });


};


jQuery(window).load(function() {
//fixboxes();
});

jQuery(window).resize(function(){
//fixboxes();

});


// menu behaviour removed in Constructo version 2.0
//jQuery(document).ready(function()
//{
//jQuery('nav.site-navigation ul li:has(ul)').doubleTapToGo();
//});

jQuery(document).ready(function() {
jQuery('.ls-wp-fullwidth-helper:after').animate({ width: "90px" }, "slow" );
});



jQuery(document).ready(function(){

  // hide #back-top first
  jQuery("#back-top").hide();
  
  // fade in #back-top
  jQuery(function () {
    jQuery(window).scroll(function () {

      if (jQuery(this).scrollTop() > 300) {
       


        jQuery('#scrolltop').fadeIn();
      } else {
        jQuery('#scrolltop').fadeOut();
      }
    });

    // scroll body to 0px on click
    jQuery('#scrolltop a').click(function () {
      jQuery('body,html').animate({
        scrollTop: 0
      }, 800);
      return false;
    });
  });
jQuery(document).ready(function(){
if (jQuery('.owl-carousel').length) {

var owl = jQuery('.owl-carousel');
    var number_items = jQuery('.owl-carousel').attr("data-col");
    jQuery(owl).owlCarousel({ 
        loop:true,
        margin:30,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:false,
                slideBy: 1
            },
            600:{
                items:2,
                nav:false,
                slideBy: 2
            },
            992:{
                items: number_items,
                nav:false,
                slideBy: number_items
            }
        }
    });

    // Custom Navigation Events
    jQuery(".owlnext").click(function(){
      owl.trigger('next.owl.carousel');
    })
    jQuery(".owlprev").click(function(){
      owl.trigger('prev.owl.carousel');
    })
  }
})

/*vertical menu*/
if (jQuery('body').hasClass('vertical-menu')) {
  //jQuery('body > .site-wrapper .nav-wrap').prepend('<div class="hide-menu"></div>')
  jQuery('.nav-wrap > .hide-menu').click(function($){
  jQuery('header.vertical-menu, body.vertical-menu').toggleClass('hide-side-menu'); 
  });
}



}); //end of (document).ready function

function getHashFilter() {
  var hash = location.hash; 
  // get filter=filterName
  var matches = location.hash.match( /filter=([^&]+)/i );
  var hashFilter = matches && matches[1];
  return hashFilter && decodeURIComponent( hashFilter );
}

/*overwriting the vc row behaviour function for the vertical menu*/

if ( typeof window[ 'vc_rowBehaviour' ] !== 'function' ) {

  window.vc_rowBehaviour = function () {
    var $ = window.jQuery;
    var local_function = function () {
      var $elements = $( '[data-vc-full-width="true"]' );
      $.each( $elements, function ( key, item ) {
        var $el = $( this );
        var $el_full = $el.next( '.vc_row-full-width' );
        var el_margin_left = parseInt( $el.css( 'margin-left' ), 10 );
        var el_margin_right = parseInt( $el.css( 'margin-right' ), 10 );
        var offset = 0 - $el_full.offset().left - el_margin_left;
        var width = $( window ).width();
        if ($('body').hasClass('vertical-menu') && ($el.find('.rev_slider_wrapper').length !=0) && ($( window ).width() > '992') ) {              // ANPS
             $el.css( {                                                                                         // ANPS
              'position': 'relative',                                                                           // ANPS
              'left': offset + 330,                                                                             // ANPS
              'box-sizing': 'border-box',                                                                       // ANPS
              'width': ($( window ).width() - 330)                                                              // ANPS
            } );                                                                                                // ANPS
        } else {                                                                                                // ANPS
            $el.css( {
              'position': 'relative',
              'left': offset,
              'box-sizing': 'border-box',
              'width': $( window ).width()
            } );
        }
        if ( ! $el.data( 'vcStretchContent' ) ) {
          var padding = (- 1 * offset);
          if ( padding < 0 ) {
            padding = 0;
          }
          var paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right;
          if ( paddingRight < 0 ) {
            paddingRight = 0;
          }
          $el.css( { 'padding-left': padding + 'px', 'padding-right': paddingRight + 'px' } );
        }
        $el.attr( "data-vc-full-width-init", "true" );
      } );
    };
    /**
     * @todo refactor as plugin.
     * @returns {*}
     */
    var parallaxRow = function () {
      var vcSkrollrOptions,
        callSkrollInit = false;
      if ( vcParallaxSkroll ) {
        vcParallaxSkroll.destroy();
      }
      $( '.vc_parallax-inner' ).remove();
      $( '[data-5p-top-bottom]' ).removeAttr( 'data-5p-top-bottom data-30p-top-bottom' );
      $( '[data-vc-parallax]' ).each( function () {
        var skrollrSpeed,
          skrollrSize,
          skrollrStart,
          skrollrEnd,
          $parallaxElement,
          parallaxImage,
          youtubeId;
        callSkrollInit = true; // Enable skrollinit;
        if ( $( this ).data( 'vcParallaxOFade' ) == 'on' ) {
          $( this ).children().attr( 'data-5p-top-bottom', 'opacity:0;' ).attr( 'data-30p-top-bottom',
            'opacity:1;' );
        }

        skrollrSize = $( this ).data( 'vcParallax' ) * 100;
        $parallaxElement = $( '<div />' ).addClass( 'vc_parallax-inner' ).appendTo( $( this ) );
        $parallaxElement.height( skrollrSize + '%' );

        parallaxImage = $( this ).data( 'vcParallaxImage' );

        youtubeId = vcExtractYoutubeId( parallaxImage );

        if ( youtubeId ) {
          insertYoutubeVideoAsBackground( $parallaxElement, youtubeId );
        } else if ( parallaxImage !== undefined ) {
          $parallaxElement.css( 'background-image', 'url(' + parallaxImage + ')' );
        }

        skrollrSpeed = skrollrSize - 100;
        skrollrStart = - skrollrSpeed;
        skrollrEnd = 0;

        $parallaxElement.attr( 'data-bottom-top', 'top: ' + skrollrStart + '%;' ).attr( 'data-top-bottom',
          'top: ' + skrollrEnd + '%;' );
      } );

      if ( callSkrollInit && window.skrollr ) {
        vcSkrollrOptions = {
          forceHeight: false,
          smoothScrolling: false,
          mobileCheck: function () {
            return false;
          }
        };
        vcParallaxSkroll = skrollr.init( vcSkrollrOptions );
        return vcParallaxSkroll;
      }
      return false;
    };
    /**
     * @todo refactor as plugin.
     * @returns {*}
     */
    var fullHeightRow = function () {
      $( '.vc_row-o-full-height:first' ).each( function () {
        var $window,
          windowHeight,
          offsetTop,
          fullHeight;
        $window = $( window );
        windowHeight = $window.height();
        offsetTop = $( this ).offset().top;
        if ( offsetTop < windowHeight ) {
          fullHeight = 100 - offsetTop / (windowHeight / 100);
          $( this ).css( 'min-height', fullHeight + 'vh' );
        }
      } );
    };
    $( window ).unbind( 'resize.vcRowBehaviour' ).bind( 'resize.vcRowBehaviour', local_function );
    $( window ).bind( 'resize.vcRowBehaviour', fullHeightRow );
    local_function();
    fullHeightRow();
    if (typeof initVideoBackgrounds == 'function') {                        //Anps
      initVideoBackgrounds(); // must be called before parallax
    }                                                                       //Anps
    parallaxRow();
  }
}

/* Google Maps (using gmaps.js) */

function isFloat(n){
    return parseFloat(n.match(/^-?\d*(\.\d+)?$/))>0;
}

function checkCoordinates(str) {
  if( !str ) { return false; }

  str = str.split(',');

  var isCoordinate = true;

  if( str.length !== 2 && ( !isFloat(str[0]) || !isFloat(str[1]) ) ) {
    isCoordinate = false;
  }

  return isCoordinate;
}

jQuery(function($){
  $('.map').each(function() {
    /* Options */
    var gmap = {
      zoom   : ($(this).attr('data-zoom')) ? parseInt($(this).attr('data-zoom')) : 15,
      address: $(this).attr('data-address'),
      markers: $(this).attr('data-markers'),
      icon   : $(this).attr('data-icon'),
      typeID : $(this).attr('data-type'),
      ID     : $(this).attr('id'),
    };

    var gmapScroll = ($(this).attr('data-scroll')) ? $(this).attr('data-scroll') : 'false';
    var markersArray = [];
    var bound = new google.maps.LatLngBounds();

    if( gmapScroll == 'false' ) {
      gmap.draggable = false;
      gmap.scrollwheel = false;
    }

    /* Google Maps with markers */

    if( gmap.markers ) {
      gmap.markers = gmap.markers.split('|');
      gmap.markers.forEach(function(marker) {
        marker = $.parseJSON(marker);

        if( marker ) {
          if( checkCoordinates(marker.address) ) {
            marker.latLng = marker.address.split(',');
            delete marker.address;
          }
          markersArray.push(marker);
        }
      });

      $('#' + gmap.ID).gmap3({
        map:{
          options:{
            zoom       : gmap.zoom,
            draggable  : gmap.draggable,
            scrollwheel: gmap.scrollwheel,
            mapTypeId  : google.maps.MapTypeId[gmap.typeID],
          }
        },
        marker:{
          values: markersArray,
          options:{
            draggable: false
          },
          callback: function(results) {
            var center = null;

            results.forEach(function(m, i) {
              if( markersArray[i].center ) {
                center = {H:m.position.H, L:m.position.L};
              } else {
                bound.extend( new google.maps.LatLng(m.position.H, m.position.L) );
              }
            });

            if( !center ) {
              center = bound.getCenter();
            }

            $(this).gmap3('get').setCenter(new google.maps.LatLng(center.H, center.L));
          }, 
          events: {
            click: function(marker, event, context){
              if( !context.data ) { return false; }

              var map = $(this).gmap3('get'),
              infowindow = $(this).gmap3({
                get: { name:'infowindow' }
              });

              if (infowindow){
                if( context.data ) {
                  infowindow.open(map, marker);
                  infowindow.setContent(decodeURIComponent(context.data));
                }
              } else {
                $(this).gmap3({
                  infowindow:{
                    anchor : marker,
                    options: { content: decodeURIComponent(context.data) }
                  }
                });
              }
            },
          }
        }, 
      }); 
    }

    /* Google Maps Basic */

    if( gmap.address ) {
      if( checkCoordinates(gmap.address) ) {
        $('#' + gmap.ID).gmap3({
          map:{
            options:{
              zoom       : gmap.zoom,
              draggable  : gmap.draggable,
              scrollwheel: gmap.scrollwheel,
              mapTypeId  : google.maps.MapTypeId[gmap.typeID],
              center     : gmap.address.split(','),
            }
          },
          marker:{
            latLng: gmap.address.split(','),
            options: {
              icon: gmap.icon
            }
          },
        });
      } else {
        $('#' + gmap.ID).gmap3({
          map:{
            options:{
              zoom       : gmap.zoom,
              draggable  : gmap.draggable,
              scrollwheel: gmap.scrollwheel,
              mapTypeId  : google.maps.MapTypeId[gmap.typeID],
            }
          },
          getlatlng:{
            address:  gmap.address,
            callback: function(results) {
              if ( !results ) return;
              $(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
              $(this).gmap3({
                marker:{
                  latLng:results[0].geometry.location,
                  options: {
                    icon: gmap.icon
                  }
                }
              })
            }
          }
        });  
      }
    }
  });
});