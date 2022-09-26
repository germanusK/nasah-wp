<?php 
 $front_banner = elemento_front_banner_type();
 $site_banner = elemento_site_banner_type(); 

 if( is_front_page() || is_home()){ 
    if( $front_banner == 'video-banner' ){
      elemento_banner_video();
    }else if(  $front_banner == 'image-banner' ){
      elemento_banner_image();
    }else if( $front_banner == 'shortcode-banner' ){ 

         echo '<section id="scBanner" class="front-page sc-banner">';
         echo do_shortcode( get_theme_mod( 'front_shortcode_banner' ) );
         echo '</section>';
      }
  
 }else{
    if( $site_banner == 'video-banner' ){
      elemento_banner_video();
    }
    else if(  $site_banner == 'image-banner' ){
      elemento_banner_image();
    }else if( $front_banner == 'shortcode-banner' ){ 

         echo '<section id="scBanner" class="inner-page sc-banner">';
         echo do_shortcode( get_theme_mod( 'inner_shortcode_banner' ) );
         echo '</section>';
      }
    
 
 }