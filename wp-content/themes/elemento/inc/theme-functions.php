<?php





if( ! function_exists( 'elemento_banner_image' ) ):

	function elemento_banner_image(){
		?>
		<section id="staticBanner" class="jr-site-static-banner front-page header_height">
			<?php if( esc_attr( get_theme_mod('header_image') ) ){
				the_header_image_tag();
				?>
				<?php }else{?>
				<img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/slider1.jpg');?>">
				<?php } ?>
				<?php if( ! esc_attr( get_theme_mod('hide_overlay') ) ):?>
					<div class="banner-overlay">
					</div>
				<?php endif; ?>
			</section>
			<?php
	} 

endif;



if( ! function_exists( 'elemento_banner_video' ) ):
	function elemento_banner_video(){
?>
		<section id="staticBanner" class="jr-site-static-banner front-page video-banner">
			<?php if( esc_attr ( get_theme_mod('external_header_video') ) ){?>
			<?php 
			echo wp_oembed_get( esc_attr( get_theme_mod('external_header_video') ) , array( 'banner' => 1 ) );
			?>

			<?php }else{?>

			<?php if(get_header_video_url()){?>
			<video controls='false' autoplay muted loop>
				<source src="<?php echo  esc_url(get_header_video_url());?>" type="video/mp4">
					<?php esc_html_e('Your browser does not support the video tag.' , 'elemento')?>
				</video>

				<?php }else{ ?>

				<p class="alert alert-danger">
					<?php esc_html_e('Please upload banner video. Go to: Customize > Banner Setting > Add Media' , 'elemento' );?>
				</p>
				<?php } ?>

				<?php } ?>

				<?php if( ! esc_attr( get_theme_mod('hide_overlay') ) ):?>
					<div class="banner-overlay"></div>
				<?php endif; ?>
			</section>
		<?php
		}

endif;




if( ! function_exists('elemento_post_single_title') ):

	function elemento_post_single_title(){
		?>
		<div class="flex-box caption">

			<div class="article-wrap onDetails">

				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>

				<?php if( ! esc_attr( get_theme_mod( 'hide_meta_single' ) ) && ( 'post' == get_post_type() ) ):?> 

					<?php elemento_posted_on(); ?>

				<?php endif;?>

				<?php elemento_categories(); ?>

				<?php elemento_comment_count(); ?>



			</div>

		</div>
		<?php
	}

endif;

if( ! function_exists('elemento_dynamic_css') ):
function elemento_dynamic_css(){
	ob_start();
	?>
	<style>
		.header_height{ height:<?php echo elemento_header_height();?>;}
		<?php 
		if( elemento_hide_overlay() ):
		?>
		.slides li:before{ display:none;}
		<?php endif; ?>
		
		body{
			font-family: '<?php echo elemento_body_font_family() ;?>',sans-serif;
			font-size: <?php echo elemento_body_font_size(); ?>;
			color: <?php echo elemento_body_text_color();?>;
		}
		body a{ color:#ED564B;}
		body a:hover{ color:#4257f2;}
		.site-title a{font-size: <?php echo elemento_site_title_font_size();?>;}
		.site-description{font-size: <?php echo elemento_site_desc_font_size(); ?>;}
		nav.menu-main li a{font-size: <?php echo elemento_main_menu_font_size();?>;}
		h1{font-size: <?php echo elemento_h1_font_size();?>; }
		h2{font-size: <?php echo elemento_h2_font_size();?>; }
		h3{font-size: <?php echo elemento_h3_font_size();?>; }
		h4{font-size: <?php echo elemento_h4_font_size();?>; }
		h5{font-size: <?php echo elemento_h5_font_size();?>; }
		h6{font-size: <?php echo elemento_h6_font_size();?>; }
		header.sticky-header.scrolled,
		.no-banner header.jr-site-header
		{background-color:  <?php echo elemento_header_bg_color();?>!important; }

		h1.site-title{font-size: 32px;margin:0 0 5px 0; }
		nav.menu-main ul>li>a{color:<?php echo elemento_menu_color();?>}
		nav.menu-main ul li a:hover{color:<?php echo elemento_menu_hover_color();?>;}    
		nav.menu-main ul li .sub-menu>li>a{color:<?php echo esc_attr( get_theme_mod('submenu_items_color') ); ?> !important;}
		nav.menu-main ul li .sub-menu{background-color:<?php echo esc_attr( get_theme_mod('submenu_background') ); ?> !important;}

		
		.is-sidebar{
			background-color:  <?php echo elemento_sidebar_bg_color();?>;
			color:  <?php echo elemento_sidebar_color();?>;
		}
		.tagcloud .tag-cloud-link{
			border: 2px solid <?php echo esc_attr( get_theme_mod('theme_border_color') ); ?> !important;
            }

		.jr-site-footer a{
			color:<?php echo elemento_footer_color();?>;
		}

		.jr-site-footer .copyright-bottom{
			background-color: <?php echo elemento_copyright_bg_color();?>;
			color:<?php echo elemento_copyright_color();?>;
		}


		nav ul li:hover, nav ul li:focus,
		nav ul li.active-page,
		nav ul > li.current-menu-item {
			background-color: #4257f2;
		}
		nav ul li:focus {
			background-color: #4257f2 !important;
		}
		nav ul li:hover a,
		nav ul li.active-page a,
		nav ul > li.current-menu-item a {
			text-decoration: none;
			color: white;
		}

		.single-post .post-title, h1.page-title{font-size:  <?php echo elemento_single_post_font_size();?>;}

		@media (max-width: 1020px){
			.mobile-menu span {

				background-color: <?php echo elemento_mobile_menu_color();?>;

			}
		}

		

	</style>
	<?php 
	echo ob_get_clean();
}

endif;
add_action( 'wp_head' , 'elemento_dynamic_css' , 55 );


