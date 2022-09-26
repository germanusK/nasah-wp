<?php
/**
 *
 * @package   GS_Posts_Widget
 * @author    GS Plugins <hello@gsplugins.com>
 * @license   GPL-2.0+
 * @link      https://www.gsplugins.com
 * @copyright 2017 GS Plugins
 *
 * @wordpress-plugin
 * Plugin Name:           GS Posts Widget Lite
 * Plugin URI:            https://www.gsplugins.com/wordpress-plugins
 * Description:           WordPress Posts widget to display recent posts elegantly. GS Posts widget is powerful widget plugin to display latest posts with thumbnails, author, published data, excerpt or full content. GS Posts Widget packed with necessary controlling options & 15+ different themes to present posts elegantly with eye catching effects. Check demo and documentation at <a href="http://posts-widget.gsplugins.com">GS Posts Widget PRO Demos & Docs</a>
 * Version:               1.2.7
 * Author:                GS Plugins
 * Author URI:            https://www.gsplugins.com
 * Text Domain:           gspw
 * License:               GPL-2.0+
 * License URI:           http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Add new image sizes
  add_image_size( 'gs-square-thumb', 420, 420, true );

if ( !class_exists( 'WP_Widget_gspw_Posts' ) ) {

  class WP_Widget_gspw_Posts extends WP_Widget {

    function __construct() {

      $widget_options = array(
        'classname' => 'widget_gspw_posts',
        'description' => __( 'Displays List of posts with an array of options', 'gspw' )
      );

      $control_options = array(
        'width' => 450
      );

      parent::__construct(
        'gs-posts-widget',
        __( 'GS Posts Widget', 'gspw' ),
        $widget_options,
        $control_options
      );

      $this->alt_option_name = 'widget_gspw_posts';

      add_action('save_post', array(&$this, 'flush_widget_cache'));
      add_action('deleted_post', array(&$this, 'flush_widget_cache'));
      add_action('switch_theme', array(&$this, 'flush_widget_cache'));
      add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_scripts'));

      if (apply_filters('gspw_enqueue_styles', true) && !is_admin()) {
        add_action('wp_enqueue_scripts', array(&$this, 'enqueue_theme_scripts'));
      }

      load_plugin_textdomain('gspw', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    function enqueue_admin_scripts() {
      wp_register_style('gspw_admin_styles', plugins_url('gspw-files/admin/css/gspw-admin.min.css', __FILE__));
      wp_enqueue_style('gspw_admin_styles');

      wp_register_script('gspw_admin_scripts', plugins_url('gspw-files/admin/js/gspw-admin.min.js', __FILE__), array('jquery'), null, true);
      wp_enqueue_script('gspw_admin_scripts');
    }

    function enqueue_theme_scripts() {
      
      wp_register_style('gspw_theme_style', plugins_url('gspw-files/assets/css/gspw-style.css', __FILE__));
      wp_enqueue_style('gspw_theme_style');

      wp_enqueue_style('dashicons');
    }

    function widget( $args, $instance ) {

      global $post;

      if ( is_object( $post ) ) {
        $current_post_id = $post->ID;
      } else {
        $current_post_id = 0;
      }

      $cache = wp_cache_get( 'widget_gspw_posts', 'widget' );

      if ( !is_array( $cache ) )
        $cache = array();

      if ( isset( $cache[$args['widget_id']] ) ) {
        echo $cache[$args['widget_id']];
        return;
      }

      ob_start();
      extract( $args );

      global  $excerpt_length;

      $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
      $title_link = $instance['title_link'];
      $class = $instance['class'];
      $number = empty($instance['number']) ? -1 : $instance['number'];
      $cats = empty($instance['cats']) ? '' : explode(',', $instance['cats']);
      $tags = empty($instance['tags']) ? '' : explode(',', $instance['tags']);
      $atcat = $instance['atcat'] ? true : false;
      $thumb_size = $instance['thumb_size'];
      $attag = $instance['attag'] ? true : false;
      $excerpt_length = $instance['excerpt_length'];
      $excerpt_readmore = $instance['excerpt_readmore'];
      $sticky = $instance['sticky'];
      $order = $instance['order'];
      $orderby = $instance['orderby'];
      $meta_key = $instance['meta_key'];
      $custom_fields = $instance['custom_fields'];

      // Sticky posts
      if ($sticky == 'only') {
        $sticky_query = array( 'post__in' => get_option( 'sticky_posts' ) );
      } elseif ($sticky == 'hide') {
        $sticky_query = array( 'post__not_in' => get_option( 'sticky_posts' ) );
      } else {
        $sticky_query = null;
      }

      // If $atcat true and in category
      if ($atcat && is_category()) {
        $cats = get_query_var('cat');
      }

      // If $atcat true and is single post
      if ($atcat && is_single()) {
        $cats = '';
        foreach (get_the_category() as $catt) {
          $cats .= $catt->term_id.' ';
        }
        $cats = str_replace(' ', ',', trim($cats));
      }

      // If $attag true and in tag
      if ($attag && is_tag()) {
        $tags = get_query_var('tag_id');
      }

      // If $attag true and is single post
      if ($attag && is_single()) {
        $tags = '';
        $thetags = get_the_tags();
        if ($thetags) {
          foreach ($thetags as $tagg) {
            $tags .= $tagg->term_id . ' ';
          }
        }
        $tags = str_replace(' ', ',', trim($tags));
      }

      // Excerpt more filter
      //$new_excerpt_more = create_function('$more', 'return "...";');
      $new_excerpt_more = function($more) {
        return "...";
      };
      add_filter('excerpt_more', $new_excerpt_more);

      // Excerpt length filter
     // $new_excerpt_length = create_function('$length', "return " . $excerpt_length . ";");
      $new_excerpt_length = function($length) {
        global $excerpt_length;
        return $excerpt_length;
      };
      if ( $instance['excerpt_length'] > 0 ) add_filter('excerpt_length',$new_excerpt_length );

      if( $class ) {
        $before_widget = str_replace('class="', 'class="'. $class . ' ', $before_widget);
      }

      echo $before_widget;

      if ( $title ) {
        echo $before_title;
        if ( $title_link ) echo "<a href='$title_link'>";
        echo $title;
        if ( $title_link ) echo '</a>';
        echo $after_title;
      }

      $args = array(
        'posts_per_page' => $number,
        'order' => $order,
        'orderby' => $orderby,
        'category__in' => $cats,
        'tag__in' => $tags,
        'post_type' => 'post'
      );

      if ($orderby === 'meta_value') {
        $args['meta_key'] = $meta_key;
      }

      if (!empty($sticky_query)) {
        $args[key($sticky_query)] = reset($sticky_query);
      }

      $args = apply_filters('gspw_wp_query_args', $args, $instance, $this->id_base);

      $gspw_query = new WP_Query($args);
        
        if ($instance['template'] == 'gspwtemp3') {
          include 'gspw-files/templates/gspwtemp3-grid-01.php';
        }
        if ($instance['template'] == 'gspwtemp4') {
          include 'gspw-files/templates/gspwtemp4-grid-02A.php';
        }
        
      // Reset the global $the_post as this query will have stomped on it
      wp_reset_postdata();

      echo $after_widget;

      if ($cache) {
        $cache[$args['widget_id']] = ob_get_flush();
      }
      wp_cache_set( 'widget_gspw_posts', $cache, 'widget' );
    }

    function update( $new_instance, $old_instance ) {
      $instance = $old_instance;

      $instance['title'] = strip_tags( $new_instance['title'] );
      $instance['class'] = strip_tags( $new_instance['class']);
      $instance['title_link'] = strip_tags( $new_instance['title_link'] );
      $instance['number'] = strip_tags( $new_instance['number'] );
      $instance['cats'] = (isset( $new_instance['cats'] )) ? implode(',', (array) $new_instance['cats']) : '';
      $instance['tags'] = (isset( $new_instance['tags'] )) ? implode(',', (array) $new_instance['tags']) : '';
      $instance['atcat'] = isset( $new_instance['atcat'] );
      $instance['attag'] = isset( $new_instance['attag'] );
      $instance['show_excerpt'] = isset( $new_instance['show_excerpt'] );
      $instance['show_content'] = isset( $new_instance['show_content'] );
      $instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] );
      $instance['show_date'] = isset( $new_instance['show_date'] );
      $instance['date_format'] = strip_tags( $new_instance['date_format'] );
      $instance['show_title'] = isset( $new_instance['show_title'] );
      $instance['show_author'] = isset( $new_instance['show_author'] );
      $instance['show_comments'] = isset( $new_instance['show_comments'] );
      $instance['thumb_size'] = strip_tags( $new_instance['thumb_size'] );
      $instance['show_readmore'] = isset( $new_instance['show_readmore']);
      $instance['excerpt_length'] = strip_tags( $new_instance['excerpt_length'] );
      $instance['excerpt_readmore'] = strip_tags( $new_instance['excerpt_readmore'] );
      $instance['sticky'] = $new_instance['sticky'];
      $instance['order'] = $new_instance['order'];
      $instance['orderby'] = $new_instance['orderby'];
      $instance['meta_key'] = $new_instance['meta_key'];
      $instance['show_cats'] = isset( $new_instance['show_cats'] );
      $instance['show_tags'] = isset( $new_instance['show_tags'] );
      $instance['custom_fields'] = strip_tags( $new_instance['custom_fields'] );
      $instance['template'] = strip_tags( $new_instance['template'] );

      if (current_user_can('unfiltered_html')) {
        $instance['before_posts'] =  $new_instance['before_posts'];
        $instance['after_posts'] =  $new_instance['after_posts'];
      } else {
        $instance['before_posts'] = wp_filter_post_kses($new_instance['before_posts']);
        $instance['after_posts'] = wp_filter_post_kses($new_instance['after_posts']);
      }

      $this->flush_widget_cache();

      $alloptions = wp_cache_get( 'alloptions', 'options' );
      if ( isset( $alloptions['widget_gspw_posts'] ) )
        delete_option( 'widget_gspw_posts' );

      return $instance;
    }

    function flush_widget_cache() {
      wp_cache_delete( 'widget_gspw_posts', 'widget' );
    }

    function form( $instance ) {
      // Set default arguments
      $instance = wp_parse_args( (array) $instance, array(
        'title' => __('Latest Posts', 'gspw'),
        'class' => '',
        'title_link' => '' ,
        'number' => '5',
        'types' => 'post',
        'cats' => '',
        'tags' => '',
        'atcat' => false,
        'thumb_size' => 'gs-square-thumb',
        'attag' => false,
        'excerpt_length' => 10,
        'excerpt_readmore' => __('Read more', 'gspw'),
        'order' => 'DESC',
        'orderby' => 'date',
        'meta_key' => '',
        'sticky' => 'show',
        'show_cats' => false,
        'show_tags' => false,
        'show_title' => true,
        'show_date' => true,
        'date_format' => get_option('date_format') . ' ' . get_option('time_format'),
        'show_author' => true,
        'show_comments' => false,
        'show_excerpt' => true,
        'show_content' => false,
        'show_readmore' => true,
        'show_thumbnail' => true,
        'custom_fields' => '',
        'template' => '',
        'before_posts' => '',
        'after_posts' => ''
      ) );

      // Or use the instance
      $title  = strip_tags($instance['title']);
      $class  = strip_tags($instance['class']);
      $title_link  = strip_tags($instance['title_link']);
      $number = strip_tags($instance['number']);
      $cats = $instance['cats'];
      $tags = $instance['tags'];
      $atcat = $instance['atcat'];
      $thumb_size = $instance['thumb_size'];
      $attag = $instance['attag'];
      $excerpt_length = strip_tags($instance['excerpt_length']);
      $excerpt_readmore = strip_tags($instance['excerpt_readmore']);
      $order = $instance['order'];
      $orderby = $instance['orderby'];
      $meta_key = $instance['meta_key'];
      $sticky = $instance['sticky'];
      $show_cats = $instance['show_cats'];
      $show_tags = $instance['show_tags'];
      $show_title = $instance['show_title'];
      $show_date = $instance['show_date'];
      $date_format = $instance['date_format'];
      $show_author = $instance['show_author'];
      $show_comments = $instance['show_comments'];
      $show_excerpt = $instance['show_excerpt'];
      $show_content = $instance['show_content'];
      $show_readmore = $instance['show_readmore'];
      $show_thumbnail = $instance['show_thumbnail'];
      $custom_fields = strip_tags($instance['custom_fields']);
      $template = $instance['template'];
      $before_posts = format_to_edit($instance['before_posts']);
      $after_posts = format_to_edit($instance['after_posts']);

      // Let's turn $cats, and $tags into an array if they are set
      if (!empty($cats)) $cats = explode(',', $cats);
      if (!empty($tags)) $tags = explode(',', $tags);

      // Count number of categories for select box sizing
      $cat_list = get_categories( 'hide_empty=0' );
      if ($cat_list) {
        foreach ($cat_list as $cat) {
          $cat_ar[] = $cat;
        }
        $c = count($cat_ar);
        if($c > 6) { $c = 6; }
      } else {
        $c = 3;
      }

      // Count number of tags for select box sizing
      $tag_list = get_tags( 'hide_empty=0' );
      if ($tag_list) {
        foreach ($tag_list as $tag) {
          $tag_ar[] = $tag;
        }
        $t = count($tag_ar);
        if($t > 6) { $t = 6; }
      } else {
        $t = 3;
      }

      ?>

      <div class="gspw-tabs">
        <a class="gspw-tab-item active" data-toggle="gspw-tab-general"><?php _e('General', 'gspw'); ?></a>
        <a class="gspw-tab-item" data-toggle="gspw-tab-display"><?php _e('Display', 'gspw'); ?></a>
        <a class="gspw-tab-item" data-toggle="gspw-tab-filter"><?php _e('Filter', 'gspw'); ?></a>
        <a class="gspw-tab-item" data-toggle="gspw-tab-order"><?php _e('Order', 'gspw'); ?></a>
      </div>

      <div class="gspw-tab gspw-tab-general">

        <p>
          <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'gspw' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'title_link' ); ?>"><?php _e( 'Title URL', 'gspw' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'title_link' ); ?>" name="<?php echo $this->get_field_name( 'title_link' ); ?>" type="text" value="<?php echo $title_link; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php _e( 'CSS class', 'gspw' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" type="text" value="<?php echo $class; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('before_posts'); ?>"><?php _e('Before posts', 'gspw'); ?>:</label>
          <textarea class="widefat" id="<?php echo $this->get_field_id('before_posts'); ?>" name="<?php echo $this->get_field_name('before_posts'); ?>" rows="5"><?php echo $before_posts; ?></textarea>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('after_posts'); ?>"><?php _e('After posts', 'gspw'); ?>:</label>
          <textarea class="widefat" id="<?php echo $this->get_field_id('after_posts'); ?>" name="<?php echo $this->get_field_name('after_posts'); ?>" rows="5"><?php echo $after_posts; ?></textarea>
        </p>

      </div>

      <div class="gspw-tab gspw-hide gspw-tab-display">

        <p>
          <label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Template', 'gspw'); ?>:</label>
          <select name="<?php echo $this->get_field_name('template'); ?>" id="<?php echo $this->get_field_id('template'); ?>" class="widefat">
            <option value="gspwtemp3"<?php if( $template == 'gspwtemp3') echo ' selected'; ?>><?php _e('Style : 1', 'gspw'); ?></option>
            <option value="gspwtemp4"<?php if( $template == 'gspwtemp4') echo ' selected'; ?>><?php _e('Style : 2', 'gspw'); ?></option>
            <option value="gspwtemp5"<?php if( $template == 'gspwtemp5') echo ' selected'; ?>><?php _e('Style : 3 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp6"<?php if( $template == 'gspwtemp6') echo ' selected'; ?>><?php _e('Style : 4 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp7"<?php if( $template == 'gspwtemp7') echo ' selected'; ?>><?php _e('Style : 5 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp8"<?php if( $template == 'gspwtemp8') echo ' selected'; ?>><?php _e('Style : 6 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp9"<?php if( $template == 'gspwtemp9') echo ' selected'; ?>><?php _e('Style : 7 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp10"<?php if( $template == 'gspwtemp10') echo ' selected'; ?>><?php _e('Like Advertisement (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp11"<?php if( $template == 'gspwtemp11') echo ' selected'; ?>><?php _e('List View : 1 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp12"<?php if( $template == 'gspwtemp12') echo ' selected'; ?>><?php _e('List View : 2 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp13"<?php if( $template == 'gspwtemp13') echo ' selected'; ?>><?php _e('Ticker : Horizontal (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp14"<?php if( $template == 'gspwtemp14') echo ' selected'; ?>><?php _e('Ticker : Vertical (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp1"<?php if( $template == 'gspwtemp1') echo ' selected'; ?>><?php _e('Slider : 1 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp2"<?php if( $template == 'gspwtemp2') echo ' selected'; ?>><?php _e('Slider : 2 (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp15"<?php if( $template == 'gspwtemp15') echo ' selected'; ?>><?php _e('Vertical : Up (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp16"<?php if( $template == 'gspwtemp16') echo ' selected'; ?>><?php _e('Vertical : Down (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp15_1"<?php if( $template == 'gspwtemp15_1') echo ' selected'; ?>><?php _e('Vertical : Up - Footer (Pro)', 'gspw'); ?></option>
            <option value="gspwtemp16_1"<?php if( $template == 'gspwtemp16_1') echo ' selected'; ?>><?php _e('Vertical : Down - Footer (Pro)', 'gspw'); ?></option>
          </select>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts', 'gspw' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>" min="-1" />
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" type="checkbox" <?php checked( (bool) $show_title, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show title', 'gspw' ); ?></label>
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" <?php checked( (bool) $show_date, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Show published date', 'gspw' ); ?></label>
        </p>

        <p<?php if (!$show_date) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('date_format'); ?>"><?php _e( 'Date format', 'gspw' ); ?>:</label>
          <input class="widefat" type="text" id="<?php echo $this->get_field_id('date_format'); ?>" name="<?php echo $this->get_field_name('date_format'); ?>" value="<?php echo $date_format; ?>" />
          Date Format : F j, Y g:i a
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" type="checkbox" <?php checked( (bool) $show_author, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Show post author', 'gspw' ); ?></label>
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_comments' ); ?>" name="<?php echo $this->get_field_name( 'show_comments' ); ?>" type="checkbox" <?php checked( (bool) $show_comments, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_comments' ); ?>"><?php _e( 'Show comments count', 'gspw' ); ?></label>
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" type="checkbox" <?php checked( (bool) $show_excerpt, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Show excerpt', 'gspw' ); ?></label>
        </p>

        <p<?php if (!$show_excerpt) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e( 'Excerpt length (in words)', 'gspw' ); ?>:</label>
          <input class="widefat" type="number" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" value="<?php echo $excerpt_length; ?>" min="-1" />
        </p>

        <p>
          <input class="checkbox" id="<?php echo $this->get_field_id( 'show_content' ); ?>" name="<?php echo $this->get_field_name( 'show_content' ); ?>" type="checkbox" <?php checked( (bool) $show_content, true ); ?> />
          <label for="<?php echo $this->get_field_id( 'show_content' ); ?>"><?php _e( 'Show content', 'gspw' ); ?></label>
        </p>

        <p<?php if (!$show_excerpt && !$show_content) echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id('show_readmore'); ?>">
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_readmore'); ?>" name="<?php echo $this->get_field_name('show_readmore'); ?>"<?php checked( (bool) $show_readmore, true ); ?> />
          <?php _e( 'Show read more link', 'gspw' ); ?>
          </label>
        </p>

        <p<?php if (!$show_readmore  || (!$show_excerpt && !$show_content)) echo ' style="display:none;"'; ?>>
          <input class="widefat" type="text" id="<?php echo $this->get_field_id('excerpt_readmore'); ?>" name="<?php echo $this->get_field_name('excerpt_readmore'); ?>" value="<?php echo $excerpt_readmore; ?>" />
        </p>

        <?php if ( function_exists('the_post_thumbnail') && current_theme_supports( 'post-thumbnails' ) ) : ?>

          <?php $sizes = get_intermediate_image_sizes(); ?>

          <p>
            <input class="checkbox" id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" type="checkbox" <?php checked( (bool) $show_thumbnail, true ); ?> />

            <label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php _e( 'Show thumbnail', 'gspw' ); ?></label>
          </p>

          <p<?php if (!$show_thumbnail) echo ' style="display:none;"'; ?>>
            <select id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" class="widefat">
              <?php foreach ($sizes as $size) : ?>
                <option value="<?php echo $size; ?>"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php echo $size; ?></option>
              <?php endforeach; ?>
              <option value="full"<?php if ($thumb_size == $size) echo ' selected'; ?>><?php _e('full'); ?></option>
            </select>
          </p>

        <?php endif; ?>

        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_cats'); ?>" name="<?php echo $this->get_field_name('show_cats'); ?>" <?php checked( (bool) $show_cats, true ); ?> />
          <label for="<?php echo $this->get_field_id('show_cats'); ?>"> <?php _e('Show post categories', 'gspw'); ?></label>
        </p>

        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_tags'); ?>" name="<?php echo $this->get_field_name('show_tags'); ?>" <?php checked( (bool) $show_tags, true ); ?> />
          <label for="<?php echo $this->get_field_id('show_tags'); ?>"> <?php _e('Show post tags', 'gspw'); ?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'custom_fields' ); ?>"><?php _e( 'Show custom fields (comma separated)', 'gspw' ); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'custom_fields' ); ?>" name="<?php echo $this->get_field_name( 'custom_fields' ); ?>" type="text" value="<?php echo $custom_fields; ?>" />
        </p>

      </div>

      <div class="gspw-tab gspw-hide gspw-tab-filter">

        <p>
          <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('atcat'); ?>" name="<?php echo $this->get_field_name('atcat'); ?>" <?php checked( (bool) $atcat, true ); ?> />
          <label for="<?php echo $this->get_field_id('atcat'); ?>"> <?php _e('Show posts only from current category', 'gspw');?></label>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e( 'Categories', 'gspw' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('cats'); ?>[]" id="<?php echo $this->get_field_id('cats'); ?>" class="widefat" style="height: auto;" size="<?php echo $c ?>" multiple>
            <option value="" <?php if (empty($cats)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;') ?></option>
            <?php
            $categories = get_categories( 'hide_empty=0' );
            foreach ($categories as $category ) { ?>
              <option value="<?php echo $category->term_id; ?>" <?php if(is_array($cats) && in_array($category->term_id, $cats)) echo 'selected="selected"'; ?>><?php echo $category->cat_name;?></option>
            <?php } ?>
          </select>
        </p>

        <?php if ($tag_list) : ?>
          <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('attag'); ?>" name="<?php echo $this->get_field_name('attag'); ?>" <?php checked( (bool) $attag, true ); ?> />
            <label for="<?php echo $this->get_field_id('attag'); ?>"> <?php _e('Show posts only from current tag', 'gspw');?></label>
          </p>

          <p>
            <label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e( 'Tags', 'gspw' ); ?>:</label>
            <select name="<?php echo $this->get_field_name('tags'); ?>[]" id="<?php echo $this->get_field_id('tags'); ?>" class="widefat" style="height: auto;" size="<?php echo $t ?>" multiple>
              <option value="" <?php if (empty($tags)) echo 'selected="selected"'; ?>><?php _e('&ndash; Show All &ndash;') ?></option>
              <?php
              foreach ($tag_list as $tag) { ?>
                <option value="<?php echo $tag->term_id; ?>" <?php if (is_array($tags) && in_array($tag->term_id, $tags)) echo 'selected="selected"'; ?>><?php echo $tag->name;?></option>
              <?php } ?>
            </select>
          </p>
        <?php endif; ?>

        <p>
          <label for="<?php echo $this->get_field_id('sticky'); ?>"><?php _e( 'Sticky posts', 'gspw' ); ?>:</label>
          <select name="<?php echo $this->get_field_name('sticky'); ?>" id="<?php echo $this->get_field_id('sticky'); ?>" class="widefat">
            <option value="show"<?php if( $sticky === 'show') echo ' selected'; ?>><?php _e('Show All Posts', 'gspw'); ?></option>
            <option value="hide"<?php if( $sticky == 'hide') echo ' selected'; ?>><?php _e('Hide Sticky Posts', 'gspw'); ?></option>
            <option value="only"<?php if( $sticky == 'only') echo ' selected'; ?>><?php _e('Show Only Sticky Posts', 'gspw'); ?></option>
          </select>
        </p>

      </div>

      <div class="gspw-tab gspw-hide gspw-tab-order">

        <p>
          <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order by', 'gspw'); ?>:</label>
          <select name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat">
            <option value="date"<?php if( $orderby == 'date') echo ' selected'; ?>><?php _e('Published Date', 'gspw'); ?></option>
            <option value="title"<?php if( $orderby == 'title') echo ' selected'; ?>><?php _e('Title', 'gspw'); ?></option>
            <option value="comment_count"<?php if( $orderby == 'comment_count') echo ' selected'; ?>><?php _e('Comment Count', 'gspw'); ?></option>
            <option value="rand"<?php if( $orderby == 'rand') echo ' selected'; ?>><?php _e('Random'); ?></option>
            <option value="meta_value"<?php if( $orderby == 'meta_value') echo ' selected'; ?>><?php _e('Custom Field', 'gspw'); ?></option>
            <option value="menu_order"<?php if( $orderby == 'menu_order') echo ' selected'; ?>><?php _e('Menu Order', 'gspw'); ?></option>
          </select>
        </p>

        <p<?php if ($orderby !== 'meta_value') echo ' style="display:none;"'; ?>>
          <label for="<?php echo $this->get_field_id( 'meta_key' ); ?>"><?php _e('Custom field', 'gspw'); ?>:</label>
          <input class="widefat" id="<?php echo $this->get_field_id('meta_key'); ?>" name="<?php echo $this->get_field_name('meta_key'); ?>" type="text" value="<?php echo $meta_key; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'gspw'); ?>:</label>
          <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
            <option value="DESC"<?php if( $order == 'DESC') echo ' selected'; ?>><?php _e('Descending', 'gspw'); ?></option>
            <option value="ASC"<?php if( $order == 'ASC') echo ' selected'; ?>><?php _e('Ascending', 'gspw'); ?></option>
          </select>
        </p>

      </div>

      <?php if ( $instance ) { ?>

        <script>

          jQuery(document).ready(function($){

            var show_excerpt = $("#<?php echo $this->get_field_id( 'show_excerpt' ); ?>");
            var show_content = $("#<?php echo $this->get_field_id( 'show_content' ); ?>");
            var show_readmore = $("#<?php echo $this->get_field_id( 'show_readmore' ); ?>");
            var show_readmore_wrap = $("#<?php echo $this->get_field_id( 'show_readmore' ); ?>").parents('p');
            var show_thumbnail = $("#<?php echo $this->get_field_id( 'show_thumbnail' ); ?>");
            var show_date = $("#<?php echo $this->get_field_id( 'show_date' ); ?>");
            var date_format = $("#<?php echo $this->get_field_id( 'date_format' ); ?>").parents('p');
            var excerpt_length = $("#<?php echo $this->get_field_id( 'excerpt_length' ); ?>").parents('p');
            var excerpt_readmore_wrap = $("#<?php echo $this->get_field_id( 'excerpt_readmore' ); ?>").parents('p');
            var thumb_size_wrap = $("#<?php echo $this->get_field_id( 'thumb_size' ); ?>").parents('p');
            var order = $("#<?php echo $this->get_field_id('orderby'); ?>");
            var meta_key_wrap = $("#<?php echo $this->get_field_id( 'meta_key' ); ?>").parents('p');
            var template = $("#<?php echo $this->get_field_id('template'); ?>");

            var toggleReadmore = function() {
              if (show_excerpt.is(':checked') || show_content.is(':checked')) {
                show_readmore_wrap.show('fast');
              } else {
                show_readmore_wrap.hide('fast');
              }
              toggleExcerptReadmore();
            }

            var toggleExcerptReadmore = function() {
              if ((show_excerpt.is(':checked') || show_content.is(':checked')) && show_readmore.is(':checked')) {
                excerpt_readmore_wrap.show('fast');
              } else {
                excerpt_readmore_wrap.hide('fast');
              }
            }

            // Toggle read more option
            show_excerpt.click(function() {
              toggleReadmore();
            });

            // Toggle read more option
            show_content.click(function() {
              toggleReadmore();
            });

            // Toggle excerpt length on click
            show_excerpt.click(function(){
              excerpt_length.toggle('fast');
            });

            // Toggle excerpt length on click
            show_readmore.click(function(){
              toggleExcerptReadmore();
            });

            // Toggle date format on click
            show_date.click(function(){
              date_format.toggle('fast');
            });

            // Toggle excerpt length on click
            show_thumbnail.click(function(){
              thumb_size_wrap.toggle('fast');
            });

            // Show or hide custom field meta_key value on order change
            order.change(function(){
              if ($(this).val() === 'meta_value') {
                meta_key_wrap.show('fast');
              } else {
                meta_key_wrap.hide('fast');
              }
            });

          });

        </script>
      <?php
      }
    }
  }

  function init_wp_widget_gspw_posts() {
    register_widget( 'WP_Widget_gspw_Posts' );
  }

  add_action( 'widgets_init', 'init_wp_widget_gspw_posts' );
}

if ( ! function_exists('gs_posts_widget_pro_link') ) {
  function gs_posts_widget_pro_link( $gsPostsWidget_links ) {
    $gsPostsWidget_links[] = '<a class="gs-pro-link" href="https://www.gsplugins.com/product/wordpress-posts-widget" target="_blank">Go Pro!</a>';
    $gsPostsWidget_links[] = '<a href="https://www.gsplugins.com/wordpress-plugins" target="_blank">GS Plugins</a>';
    return $gsPostsWidget_links;
  }
  add_filter( 'plugin_action_links_' .plugin_basename(__FILE__), 'gs_posts_widget_pro_link' );
}
/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_posts_widget() {

  if ( ! class_exists( 'Appsero\Client' ) ) {
    require_once __DIR__ . '/gspw-files/appsero/src/Client.php';
  }

  $client = new Appsero\Client( '87992730-ddbb-4719-b239-52526acfa132', 'GS Posts Widget', __FILE__ );

  // Active insights
  $client->insights()->init();

}

appsero_init_tracker_posts_widget();

/**
 * @gspw_review_dismiss()
 * @gspw_review_pending()
 * @gspw_review_notice_message()
 * Make all the above functions working.
 */
function gspw_review_notice(){

  gspw_review_dismiss();
  gspw_review_pending();

  $activation_time    = get_site_option( 'gspw_active_time' );
  $review_dismissal   = get_site_option( 'gspw_review_dismiss' );
  $maybe_later        = get_site_option( 'gspw_maybe_later' );

  if ( 'yes' == $review_dismissal ) {
      return;
  }

  if ( ! $activation_time ) {
      add_site_option( 'gspw_active_time', time() );
  }
  
  $daysinseconds = 259200; // 3 Days in seconds.
 
  if( 'yes' == $maybe_later ) {
      $daysinseconds = 604800 ; // 7 Days in seconds.
  }

  if ( time() - $activation_time > $daysinseconds ) {
      add_action( 'admin_notices' , 'gspw_review_notice_message' );
  }
}
add_action( 'admin_init', 'gspw_review_notice' );

/**
* For the notice preview.
*/
function gspw_review_notice_message(){
  $scheme      = (parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY )) ? '&' : '?';
  $url         = $_SERVER['REQUEST_URI'] . $scheme . 'gspw_review_dismiss=yes';
  $dismiss_url = wp_nonce_url( $url, 'gspw-review-nonce' );

  $_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'gspw_review_later=yes';
  $later_url   = wp_nonce_url( $_later_link, 'gspw-review-nonce' );
  ?>
  
  <div class="gslogo-review-notice">
      <div class="gslogo-review-thumbnail">
          <img src="<?php echo plugins_url('gspw-files/admin/css/icon-128x128.png', __FILE__) ?>" alt="">
      </div>
      <div class="gslogo-review-text">
          <h3><?php _e( 'Leave A Review?', 'gspw' ) ?></h3>
          <p><?php _e( 'We hope you\'ve enjoyed using <b>GS Posts Widget Lite</b>! Would you consider leaving us a review on WordPress.org?', 'gspw' ) ?></p>
          <ul class="gslogo-review-ul">
              <li>
                  <a href="https://wordpress.org/support/plugin/posts-widget/reviews/" target="_blank">
                      <span class="dashicons dashicons-external"></span>
                      <?php _e( 'Sure! I\'d love to!', 'gspw' ) ?>
                  </a>
              </li>
              <li>
                  <a href="<?php echo $dismiss_url ?>">
                      <span class="dashicons dashicons-smiley"></span>
                      <?php _e( 'I\'ve already left a review', 'gspw' ) ?>
                  </a>
              </li>
              <li>
                  <a href="<?php echo $later_url ?>">
                      <span class="dashicons dashicons-calendar-alt"></span>
                      <?php _e( 'Maybe Later', 'gspw' ) ?>
                  </a>
              </li>
              <li>
                  <a href="https://www.gsplugins.com/contact/" target="_blank">
                      <span class="dashicons dashicons-sos"></span>
                      <?php _e( 'I need help!', 'gspw' ) ?>
                  </a>
              </li>
              <li>
                  <a href="<?php echo $dismiss_url ?>">
                      <span class="dashicons dashicons-dismiss"></span>
                      <?php _e( 'Never show again', 'gspw' ) ?>
                  </a>
              </li>
          </ul>
      </div>
  </div>
  
  <?php
}

/**
* For Dismiss! 
*/
function gspw_review_dismiss(){

  if ( ! is_admin() ||
      ! current_user_can( 'manage_options' ) ||
      ! isset( $_GET['_wpnonce'] ) ||
      ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'gspw-review-nonce' ) ||
      ! isset( $_GET['gspw_review_dismiss'] ) ) {

      return;
  }

  add_site_option( 'gspw_review_dismiss', 'yes' );   
}

/**
* For Maybe Later Update.
*/
function gspw_review_pending() {

  if ( ! is_admin() ||
      ! current_user_can( 'manage_options' ) ||
      ! isset( $_GET['_wpnonce'] ) ||
      ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'gspw-review-nonce' ) ||
      ! isset( $_GET['gspw_review_later'] ) ) {

      return;
  }
  // Reset Time to current time.
  update_site_option( 'gspw_active_time', time() );
  update_site_option( 'gspw_maybe_later', 'yes' );

}

/**
* Remove Reviews Metadata on plugin Deactivation.
*/
function gspw_deactivate() {
  delete_option('gspw_active_time');
  delete_option('gspw_maybe_later');
  delete_option('gsadmin_maybe_later');
}
register_deactivation_hook(__FILE__, 'gspw_deactivate');

/**
* Reviews Metadata on plugin activation.
*/

if ( ! function_exists('gspw_row_meta') ) {
  function gspw_row_meta( $meta_fields, $file ) {

    if ( $file != 'posts-widget/gspw-posts-widget.php' ) {
        return $meta_fields;
    }
  
    echo "<style>.gspw-rate-stars { display: inline-block; color: #ffb900; position: relative; top: 3px; }.gspw-rate-stars svg{ fill:#ffb900; } .gspw-rate-stars svg:hover{ fill:#ffb900 } .gspw-rate-stars svg:hover ~ svg{ fill:none; } </style>";

    $plugin_rate   = "https://wordpress.org/support/plugin/posts-widget/reviews/?rate=5#new-post";
    $plugin_filter = "https://wordpress.org/support/plugin/posts-widget/reviews/?filter=5";
    $svg_xmlns     = "https://www.w3.org/2000/svg";
    $svg_icon      = '';

    for ( $i = 0; $i < 5; $i++ ) {
      $svg_icon .= "<svg xmlns='" . esc_url( $svg_xmlns ) . "' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>";
    }

    // Set icon for thumbsup.
    $meta_fields[] = '<a href="' . esc_url( $plugin_filter ) . '" target="_blank"><span class="dashicons dashicons-thumbs-up"></span>' . __( 'Vote!', 'gscs' ) . '</a>';

    // Set icon for 5-star reviews. v1.1.22
    $meta_fields[] = "<a href='" . esc_url( $plugin_rate ) . "' target='_blank' title='" . esc_html__( 'Rate', 'gscs' ) . "'><i class='gspw-rate-stars'>" . $svg_icon . "</i></a>";

    return $meta_fields;
  }
  add_filter( 'plugin_row_meta','gspw_row_meta', 10, 2 );
}

if( ! function_exists('gsadmin_signup_notice')){
  function gsadmin_signup_notice(){

      gsadmin_signup_pending() ;
      $activation_time    = get_site_option( 'gsadmin_active_time' );
      $maybe_later        = get_site_option( 'gsadmin_maybe_later' );
  
      if ( ! $activation_time ) {
          add_site_option( 'gsadmin_active_time', time() );
      }
      
      if( 'yes' == $maybe_later ) {
          $daysinseconds = 604800 ; // 7 Days in seconds.
          if ( time() - $activation_time > $daysinseconds ) {
              add_action( 'admin_notices' , 'gsadmin_signup_notice_message' );
          }
      }else{
          add_action( 'admin_notices' , 'gsadmin_signup_notice_message' );
      }
  
  }
  // add_action( 'admin_init', 'gsadmin_signup_notice' );
  /**
   * For the notice signup.
   */
  function gsadmin_signup_notice_message(){
      $scheme      = (parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY )) ? '&' : '?';
      $_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'gsadmin_signup_later=yes';
      $later_url   = wp_nonce_url( $_later_link, 'gsadmin-signup-nonce' );
      ?>
      <div class=" gstesti-admin-notice updated gsteam-review-notice">
          <div class="gsteam-review-text">
              <h3><?php _e( 'GS Plugins Affiliate Program is now LIVE!', 'gst' ) ?></h3>
              <p>Join GS Plugins affiliate program. Share our 80% OFF lifetime bundle deals or any plugin with your friends/followers and earn up to 50% commission. <a href="https://www.gsplugins.com/affiliate-registration/?utm_source=wporg&utm_medium=admin_notice&utm_campaign=aff_regi" target="_blank">Click here to sign up.</a></p>
              <ul class="gsteam-review-ul">
                  <li style="display: inline-block;margin-right: 15px;">
                      <a href="<?php echo $later_url ?>" style="display: inline-block;color: #10738B;text-decoration: none;position: relative;">
                          <span class="dashicons dashicons-dismiss"></span>
                          <?php _e( 'Hide Now', 'gst' ) ?>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
      
      <?php
  }

  /**
   * For Maybe Later signup.
   */
  function gsadmin_signup_pending() {

      if ( ! is_admin() ||
          ! current_user_can( 'manage_options' ) ||
          ! isset( $_GET['_wpnonce'] ) ||
          ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'gsadmin-signup-nonce' ) ||
          ! isset( $_GET['gsadmin_signup_later'] ) ) {

          return;
      }
      // Reset Time to current time.
      update_site_option( 'gsadmin_maybe_later', 'yes' );
  }
}