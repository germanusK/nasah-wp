<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Elemento
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>


<body <?php body_class( elemento_body_site_layout() ); ?> data-container="<?php echo elemento_site_container();?>">
<?php 
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

?>

<div id="skiptocontent"><a href="#content" class=""><?php esc_html_e( 'Skip to content', 'elemento' ); ?></a></div>

<div class="body-wrapp <?php echo elemento_header_type();?>">

<!--Header Component-->
<header id="siteHeader" class="jr-site-header pd-a-15 <?php  elemento_header_class(); ?>">

    <div class="<?php echo elemento_site_container();?>">
        <div class="row align-flex-item-center full-width">
            <div class="col-8 col-md-4 col-lg-3">
                <div class="logo-holder">
                    <?php
                    the_custom_logo();
                    if( display_header_text() ):
                        ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php 
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) : ?>
                            <p class="site-description"><?php echo esc_html($description); ?></p>
                            <?php
                        endif; 
                    endif; 
                    ?>
                </div>
            </div>
            <!--Mobile view ham menu-->
            <div class="mobile-menu">
                <a href="#" class="burger">
                    <span></span>
                    <span></span>
                    <span></span>    
                </a>
            </div>
            <!--Ends-->
            <div class="col-md-8 col-lg-9 text-align-right" id="desktop-show">
                <?php 

                ?>
                <nav class="menu-main">
                    <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'floted-li clearfix d-i-b primary-menu',
                        'walker'        => '',
                        'fallback_cb'    => 'wp_page_menu',
                    ) );
                    ?>
                </nav>
            </div>
            <div class="col-4 col-md-8 col-lg-9 mobileshow">
                <div class="sidebarmenu">
                    <div class="sidebar-menu">
                        <a href='javascript:void(0)' onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></a> 
                    </div>
                    <div id="mySidenav" class="sidenav"> 
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times; </a>
                        <div id='sidebarmenuleft'>
                            <?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>