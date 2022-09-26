<?php
/**
 * Widget template Grid-01
 *
 * @version     2.0.0
 */
?>

<?php if ($instance['before_posts']) : ?>
  <div class="gspw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>

<div class="gspw-posts grid-01">

  <?php if ($gspw_query->have_posts()) : ?>

    <?php while ($gspw_query->have_posts()) : $gspw_query->the_post(); ?>

        <?php $current_post = ($post->ID == $current_post_id && is_single()) ? 'active' : ''; ?>

        <article <?php post_class($current_post); ?>>

          <header>
            <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>
              <div class="entry-image">
                <a href="<?php the_permalink(); ?>" rel="bookmark">
                  <?php the_post_thumbnail('gs-square-thumb'); ?>
                </a>
              </div>
            <?php endif; ?>

            <?php if (get_the_title() && $instance['show_title']) : ?>
              <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
              </h4>
            <?php endif; ?>

            <?php if ($instance['show_date'] || $instance['show_author'] || $instance['show_comments']) : ?>
              <div class="entry-meta">
                <?php if ($instance['show_date']) : ?>
                  <span class="dashicons dashicons-calendar-alt"></span><time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_time($instance['date_format']); ?></time>
                <?php endif; ?>

                <?php if ($instance['show_date'] && $instance['show_author']) : ?>
                  <span class="sep"><?php _e('|', 'gspw'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_author']) : ?>
                  <span class="author">
                    <span class="dashicons dashicons-admin-users"></span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author"><?php echo get_the_author(); ?></a>
                  </span>
                <?php endif; ?>

                <?php if ($instance['show_author'] && $instance['show_comments']) : ?>
                  <span class="sep"><?php _e('|', 'gspw'); ?></span>
                <?php endif; ?>

                <?php if ($instance['show_comments']) : ?>
                  <span class="dashicons dashicons-admin-comments"></span><a class="comments" href="<?php comments_link(); ?>"><?php comments_number(__('No comments', 'gspw'), __('One comment', 'gspw'), __('% comments', 'gspw')); ?></a>
                <?php endif; ?>
              </div> <!-- end meta -->
            <?php endif; ?>
          </header>

          <section>
            <?php if ($instance['show_excerpt']) : 

            $linkmore = '';
            if ($instance['show_readmore']) {
              $linkmore = ' <a href="'.get_permalink().'" class="more-link">'.$excerpt_readmore.'</a>';
            }
            ?>
              <p class="post-excerpt"><?php echo get_the_excerpt() . $linkmore; ?></p>
            <?php endif; ?>

            <?php if ($instance['show_content']) : ?>
            <p class="post-content"><?php echo get_the_content() ?></p>
            <?php endif; ?>
          </section>

          <footer>
            <?php
            $categories = get_the_term_list($post->ID, 'category', '', ', ');
            if ($instance['show_cats'] && $categories) :
            ?>
              <div class="entry-categories">
                <span class="dashicons dashicons-portfolio"></span><span class="entry-cats-list"><?php echo $categories; ?></span>
              </div>
            <?php endif; ?>

            <?php
            $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');
            if ($instance['show_tags'] && $tags) :
            ?>
              <div class="entry-tags">
                <span class="dashicons dashicons-tag"></span><span class="entry-tags-list"><?php echo $tags; ?></span>
              </div>
            <?php endif; ?>

            <?php if ($custom_fields) : ?>
              <?php $custom_field_name = explode(',', $custom_fields); ?>
              <div class="entry-custom-fields">
                <?php foreach ($custom_field_name as $name) :
                  $name = trim($name);
                  $custom_field_values = get_post_meta($post->ID, $name, true);
                  if ($custom_field_values) : ?>
                    <div class="custom-field custom-field-<?php echo $name; ?>">
                      <?php
                      if (!is_array($custom_field_values)) {
                        echo $custom_field_values;
                      } else {
                        $last_value = end($custom_field_values);
                        foreach ($custom_field_values as $value) {
                          echo $value;
                          if ($value != $last_value) echo ', ';
                        }
                      }
                      ?>
                    </div>
                  <?php endif;
                endforeach; ?>
              </div>
            <?php endif; ?>
          </footer>

        </article>
    <?php endwhile; ?>

  <?php else : ?>
    <p class="gspw-not-found">
      <?php _e('No posts found.', 'gspw'); ?>
    </p>
  <?php endif; ?>
</div>

<?php if ($instance['after_posts']) : ?>
  <div class="gspw-after">
    <?php echo wpautop($instance['after_posts']); ?>
  </div>
<?php endif; ?>