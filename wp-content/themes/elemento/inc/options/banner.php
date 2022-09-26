<?php 
/**
 * Customizer options
 * @package     Elemento
 * @link        http://www.greenturtlelab.com/
 * since        1.0.0
 * Author:      Greenturtlelab
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
  
  /**
   * Banner type settings 
   */   

    // banner area
        $wp_customize->add_panel( 'elemento_banner_panel', array(
            'priority'       => 10,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __('Banner Setting', 'elemento'),
        ) );

    // banner type
    $wp_customize->add_section(
        'elemento_banner_panel',
        array(
            'title'         => __('Banner type', 'elemento'),
            'priority'      => 10,
            'panel'         => 'elemento_banner_panel', 
        )
    );

    // front page banner type
    $wp_customize->add_setting(
        'front_banner_type',
        array(
            'default'           => 'image-banner',
            'sanitize_callback' => 'elemento_sanitize_banner_type',
        )
    );

    $wp_customize->add_control(
        'front_banner_type',
        array(
            'type'        => 'radio',
            'label'       => __('Front page banner type', 'elemento'),
            'section'     => 'elemento_banner_panel',
            'description' => __('Select the banner type for your front page', 'elemento'),
            'choices' => array(
                'shortcode-banner'    => __('Full screen slider', 'elemento'),
                'image-banner'     => __('Image banner', 'elemento'),
                'video-banner'=> __('Video banner', 'elemento'),
                
                'no-banner'   => __('No banner (only menu)', 'elemento')
            ),
        )
    );
    
        // front page banner shortcode

    $wp_customize->add_setting('front_shortcode_banner', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'front_shortcode_banner_control', array(
            'label' => __('Short code','elemento'),
            'section' => 'elemento_banner_panel',
            'settings' => 'front_shortcode_banner',
            'description' => __('Works if Full screen banner is checked above', 'elemento'),
            'priority'       => 10,
        )));


    // inner page banner type
    $wp_customize->add_setting(
        'site_banner_type',
        array(
            'default'           => 'image-banner',
            'sanitize_callback' => 'elemento_sanitize_banner_type',
        )
    );

    $wp_customize->add_control(
        'site_banner_type',
        array(
            'type'        => 'radio',
            'label'       => __('Inner page banner type', 'elemento'),
            'section'     => 'elemento_banner_panel',
            'description' => __('Select the banner type for all inner pages except the front page', 'elemento'),
            'choices' => array(
                'shortcode-banner'        => __('Full screen slider', 'elemento'),
                'image-banner'     => __('Image banner', 'elemento'),
                'video-banner'=> __('Video banner', 'elemento'),
                
                'no-banner'   => __('No banner (only menu)', 'elemento')
            ),
        )
    );    
    
    $wp_customize->add_setting('inner_shortcode_banner', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'inner_shortcode_banner_control', array(
            'label' => __('Short code','elemento'),
            'section' => 'elemento_banner_panel',
            'settings' => 'inner_shortcode_banner',
            'description' => __('Works if Full screen banner is checked above', 'elemento'),
            'priority'       => 11,
        )));
   

/**
 * Header Setting 
 */

    // inner page image banner height
    $wp_customize->add_setting(
        'header_height',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '300',
        )       
    );

    $wp_customize->add_control( 'header_height', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'header_image',
        'label'       => __('Banner image height [default: 300px]', 'elemento'),
        'input_attrs' => array(
            'min'   => 250,
            'max'   => 600,
            'step'  => 5,
        ),
    ) );

    // banner overlay
    $wp_customize->add_setting(
        'hide_overlay',
        array(
            'sanitize_callback' => 'elemento_sanitize_checkbox',
        )       
    );

    $wp_customize->add_control(
        'hide_overlay',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable the overlay?', 'elemento'),
            'section'   => 'header_image',
            'priority'  => 12,
        )
    );   




/**
 *sanitization 
 */
    // banner type
    function elemento_sanitize_banner_type( $input ) {

        $valid = array(
                    
                    'image-banner'     => __('Image banner', 'elemento'),
                    'video-banner'=> __('Video banner', 'elemento'),
                    'shortcode-banner'        => __('Full screen slider', 'elemento'),
                    'no-banner'   => __('No banner (only menu)', 'elemento')
        );
     
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }



    // checkboxes
    function elemento_sanitize_checkbox( $input ) {
        if ( $input == 1 ) {

            return 1;

        } else {

            return '';
        }
    }



    // menu type
    function elemento_sanitize_menu_type( $input ) {

        $valid = array(
                    'sticky-header'    => __('Sticky', 'elemento'),
                    'image-banner'     => __('Image banner', 'elemento'),
                    'absolute-header'  => __('Absolute', 'elemento'),
                    'fixed-header'     => __('Fixed', 'elemento'),
        );
        if ( array_key_exists( $input, $valid ) ) {

            return $input;

        } else {

            return '';
        }
    }