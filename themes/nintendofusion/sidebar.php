<div class="sidebar">
  <!-- <div class="sidebar-line">
  </div> -->

  <!-- Side bar ad -->
  <!--<div class="ad-sidebar">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
    style="display:inline-block;width:300px;height:250px"
    data-ad-client="ca-pub-8943805401802569"
    data-ad-slot="7358377160"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div> -->

  <?php
  $args = array(
    'posts_per_page'   => 6,
    // 'category_name'    => 'audio_video',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => ['podcast', 'video'],
    'post_status'      => 'publish',
    'suppress_filters' => true
  );
  $audio_video = get_posts( $args );
  // print_r($audio_video)
  ?>

  <!-- $args = array(
  'posts_per_page' => 8,
  'orderby' => 'rand',
  'post_type' => 'albums',
  'genre' => 'jazz',
  'post_status' => 'publish'
  );
  $show_albums = get_posts( $args ); -->

  <div class="podcast-video">
    <h2>Vídeo & Podcast</h2>
    <?php
    // print_r($others_array);
    $post = $audio_video[0];
    // echo $post;
    $cat = $post->post_type;
    if ($cat == "podcast") {
      $category = "Podcast";
    } else if ($cat == "video") {
      $category = "Vídeo";
    }

    $permalink = get_post_permalink($post->ID);
    $time = get_the_time('j \d\e F \d\e Y', $post->ID);
    $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

    $title = $post->post_title;
    $subtitle = "";
    $title_class = "sidebar-highlight-title";
    if ($pos = strpos($post->post_title, ':')) {
      $title = substr($post->post_title, 0, $pos+1);
      $title_class = "sidebar-highlight-title";
      $subtitle = substr($post->post_title, $pos+2);
      $subtitle_class = "sidebar-highlight-subtitle";
    }

    ?>

    <div class="mosaic-news-contents">
      <a href="<?php echo $permalink ?>">
        <div class="mosaic-news-image" style="background-image: url('<?php echo $image; ?>')">
          <div class="news-gradient-black">
          </div>
          <div class="news-tag-container">
            <div class="news-tag">
              <?php echo $category; ?>
            </div>
          </div>
        </div>
        <div class="sidebar-highlight-title">
          <div class="<?php echo $title_class; ?>">
            <?php echo $title; ?>
          </div>
          <div class="<?php echo $subtitle_class; ?>">
            <?php echo $subtitle; ?>
          </div>
        </div>
      </a>
      <div class="authors">
        COM <?php echo $coauthors; ?>
      </div>
      <?php echo $time; ?>
    </div>

    <?php
    for($i=1; ($i<6 && $i<count($audio_video)); $i++) {
      $post = $audio_video[$i];
      $categories = get_the_category($post->ID);
      $cat = $post->post_type;
      if ($cat == "podcast") {
        $category = "Podcast";
      } else if ($cat == "video") {
        $category = "Vídeo";
      }
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
      $title = $post->post_title;
      $subtitle = "";
      $title_class = "sidebar-highlight-title";
      if ($pos = strpos($post->post_title, ':')) {
        $title = substr($post->post_title, 0, $pos);
        $title_class = "sidebar-highlight-title";
        $subtitle = substr($post->post_title, $pos+2);
        $subtitle_class = "sidebar-highlight-subtitle";
      }
      ?>
      <div class="sidebar-post">
        <a href="<?php echo $permalink; ?>" class="sidebar-post-link">
          <div class="sidebar-post-image" style="background-image: url('<?php echo $image; ?>')">
          </div>
        </a>
          <div class="sidebar-post-contents">
            <a href="<?php echo $permalink; ?>">
              <div class="sidebar-post-tag">
                <?php echo $category; ?>
              </div>
              <div class="sidebar-post-title">
                <?php echo $title; ?>
              </div>
            </a>

            <!-- <div class="authors">
              COM <?php echo $coauthors; ?>
            </div> -->
            <div class="sidebar-post-excerpt">
              <p><?php echo $excerpt ?></p>
            </div>
            <?php the_time('j \d\e F \d\e Y'); ?>
          </div>
      </div>
      <!-- <a href="<?php the_permalink(); ?>">
        <div class="sidebar-post">
          <div class="sidebar-post-image" style="background-image: url('<?php echo $image; ?>')">
            <div class="sidebar-post-tag">
              <?php echo $category; ?>
            </div>
          </div>
          <div class="sidebar-post-contents">
            <div class="sidebar-post-title"><?php the_title(); ?></div>
            <div class="sidebar-post-excerpt"><?php the_excerpt(); ?></div>
            <p><em><?php the_time('j \d\e F \d\e Y'); ?></em></p>
          </div>
        </div>
      </a> -->

      <?php
    }
    ?>
  </div>

  <?php
  if (!is_home()) {

    $args = array(
    'posts_per_page'   => 3,
    'orderby'          => 'meta_value_num',
    'meta_key'         => 'wpb_post_views_count',
    'order'            => 'DESC',
    'post_type'        => 'post',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'date_query' => array(
      'after' => date('Y-m-d', strtotime('-14 days'))
      )
    );
    $most_seen = get_posts( $args );
    // print_r($most_seen);


  ?>
  <div>
    <h2>Mais vistos</h2>
    <?php
    // print_r($others_array);

    foreach($most_seen as $post) {
      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      // $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
      // 'single-post-thumbnail' )[0];
      $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
      $image = get_post_meta($post->ID, 'icone', true);
      if ($image == '') {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
      }

      $title_array = separate_title_subtitle($post->post_title, "sidebar-post-title-1", "sidebar-post-subtitle-1");
      ?>

      <div class="sidebar-post">
        <a href="<?php the_permalink(); ?>" class="sidebar-post-link">
          <div class="sidebar-post-image" style="background-image: url('<?php echo $image; ?>')">
          </div>
        </a>
          <div class="sidebar-post-contents">
            <a href="<?php echo $permalink; ?>">
              <div class="sidebar-post-tag">
                <?php echo $category; ?>
              </div>
              <div class="sidebar-post-title">
                <div class="<?php echo $title_array['title_class']; ?>">
                  <?php echo $title_array['title']; ?>
                </div>
                <div class="<?php echo $title_array['subtitle_class']; ?>">
                  <?php echo $title_array['subtitle']; ?>
                </div>
              </div>
            </a>

            <!-- <div class="authors">
              POR <?php echo $coauthors; ?>
            </div> -->
            <div class="sidebar-post-excerpt">
              <!-- <p><?php echo $excerpt ?></p> -->
            </div>
            <!-- <?php the_time('j \d\e F \d\e Y'); ?> -->
          </div>
      </div>
      <!-- <a href="<?php the_permalink(); ?>">
        <div class="sidebar-post">
          <div class="sidebar-post-image" style="background-image: url('<?php echo $image; ?>')">
            <div class="sidebar-post-tag">
              <?php echo $category; ?>
            </div>
          </div>
          <div class="sidebar-post-contents">
            <div class="sidebar-post-title"><?php the_title(); ?></div>
            <div class="sidebar-post-excerpt"><?php the_excerpt(); ?></div>
            <p><em><?php the_time('j \d\e F \d\e Y'); ?></em></p>
          </div>
        </div>
      </a> -->

      <?php
    }
  }
    ?>
  </div>
</div>
