<?php get_header(); ?>
<title>Neo Fusion</title>
<?php
$ids = array();

// $args = array(
//   'posts_per_page'   => 1,
//   'orderby'          => 'date',
//   'order'            => 'DESC',
//   // 'post_type'        => 'post',
//   'post_status'      => 'publish',
//   'suppress_filters' => true,
//   'tax_query' => array(
// 		array(
// 			'taxonomy' => 'post_tag',
// 			'field' => 'slug',
// 			'terms' => 'destaque'
// 		)
// 	)
// );
// $fixed_array = get_posts( $args );

$no_posts = 3;
// if (count($fixed_array)) {
//   array_push($ids, $fixed_array[0]->ID);
//   $no_posts = 2;
// }

$args = array(
  'posts_per_page'   => $no_posts,
  'category_name'    => 'materia',
  'exclude'          => $ids,
  'orderby'          => 'date',
  'order'            => 'DESC',
  'post_type'        => 'post',
  'post_status'      => 'publish',
  'suppress_filters' => true
);
$highlights_array = get_posts( $args );

for ($i=0; $i<$no_posts; $i++) {
  array_push($ids, $highlights_array[$i]->ID);
}
// $highlights_array = array_merge($fixed_array, $highlights_array);

$args = array(
  'posts_per_page'   => 3,
  'category_name'    => 'curtas',
  'orderby'          => 'date',
  'order'            => 'DESC',
  'post_type'        => 'post',
  'post_status'      => 'publish',
  'suppress_filters' => true
);
$news_array = get_posts( $args );



for ($i=0; $i<6; $i++) {
  array_push($ids, $news_array[$i]->ID);
}

// print_r($ids);

// $args = array(
// 'posts_per_page'   => 3,
// 'exclude'          => $ids,
// 'orderby'          => 'meta_value_num',
// 'meta_key'         => 'wpb_post_views_count',
// 'order'            => 'DESC',
// 'post_type'        => 'post',
// 'post_status'      => 'publish',
// 'suppress_filters' => true,
// 'date_query' => array(
//   'after' => date('Y-m-d', strtotime('-14 days'))
//   )
// );
// $most_seen = get_posts( $args );

for ($i=0; $i<3; $i++) {
  array_push($ids, $most_seen[$i]->ID);
}

$args = array(
  'posts_per_page'   => 9,
  'offset'           => 0,
  'exclude'          => $ids,
  'orderby'          => 'date',
  'order'            => 'DESC',
  'post_type'        => 'post',
  'post_status'      => 'publish',
  'suppress_filters' => true
);
$others_array = get_posts( $args );

// print_r($others_array);
?>

  <!-- <?php if (has_post_thumbnail( $post->ID ) ): ?>
    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
    <div id="custom-bg" style="background-image: url('<?php echo $image[0]; ?>')">

    </div>
  <?php endif; ?> -->

  <div class="mosaic">
    <div class="mosaic-row-1">
      <?php
      $post = $highlights_array[0];
      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      foreach($categories as $cat) {
        $parent = get_the_category_by_ID($cat->parent);
        if ($parent == "Matéria") {
          $category = $cat->cat_name;
        }
      }
      $permalink = get_post_permalink($post->ID);

      $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
      $excerpt = get_the_excerpt($post->ID);
      // $coauthors = get_coauthors($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];

      $title_array = separate_title_subtitle($post->post_title, "highlight-title-1", "highlight-subtitle-1");

      ?>

      <div class="highlight-contents highlight-contents-1">
        <a href="<?php echo $permalink ?>">
          <div class="mosaic-highlight mosaic-highlight-1" style="background-image: url('<?php echo $image; ?>')">
            <div class="highlight-tag">
              <?php echo $category; ?>
            </div>
          </div>
          <div class="highlight-title">
            <div class="<?php echo $title_array['title_class']; ?>">
              <?php echo $title_array['title']; ?>
            </div>
            <div class="<?php echo $title_array['subtitle_class']; ?>">
              <?php echo $title_array['subtitle']; ?>
            </div>
          </div>

        </a>
        <div class="authors">
          POR <?php echo $coauthors; ?>
        </div>
        <?php echo $excerpt; ?>
      </div>
      <!-- <br/> -->
      <!-- <?php echo $post->post_title; ?> -->
    </div>

    <div class="mosaic-row-2">
      <div class="mosaic-column-1">
        <?php
        $post = $news_array[0];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

        $title = $post->post_title;
        ?>

        <div class="mosaic-news mosaic-news-1">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image mosaic-news-image-1" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title mosaic-news-title-1">
                <?php echo $title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>



        <?php
        $post = $news_array[1];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium')[0];

        $title = $post->post_title;
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image mosaic-news-image-1" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title mosaic-news-title-1">
                <?php echo $title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

      <?php
      $post = $highlights_array[1];
      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      foreach($categories as $cat) {
        $parent = get_the_category_by_ID($cat->parent);
        if ($parent == "Matéria") {
          $category = $cat->cat_name;
        }
      }
      $permalink = get_post_permalink($post->ID);

      $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
      $excerpt = get_the_excerpt($post->ID);
      // $coauthors = get_coauthors($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];

      $title_array = separate_title_subtitle($post->post_title, "highlight-title-2", "highlight-subtitle-2");

      ?>

      <div class="highlight-contents highlight-contents-2">
        <a href="<?php echo $permalink ?>">
          <div class="mosaic-highlight mosaic-highlight-2" style="background-image: url('<?php echo $image; ?>')">
            <div class="highlight-tag">
              <?php echo $category; ?>
            </div>
          </div>
          <div class="highlight-title">
            <div class="<?php echo $title_array['title_class']; ?>">
              <?php echo $title_array['title']; ?>
            </div>
            <div class="<?php echo $title_array['subtitle_class']; ?>">
              <?php echo $title_array['subtitle']; ?>
            </div>
          </div>

        </a>
        <div class="authors">
          POR <?php echo $coauthors; ?>
        </div>
        <?php echo $excerpt; ?>
      </div>
    </div>


    <div class="mosaic-row-3">
      <?php
      $post = $highlights_array[2];
      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      foreach($categories as $cat) {
        $parent = get_the_category_by_ID($cat->parent);
        if ($parent == "Matéria") {
          $category = $cat->cat_name;
        }
      }
      $permalink = get_post_permalink($post->ID);

      $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
      $excerpt = get_the_excerpt($post->ID);
      // $coauthors = get_coauthors($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];

      $title_array = separate_title_subtitle($post->post_title, "highlight-title-2", "highlight-subtitle-2");

      ?>

      <div class="highlight-contents highlight-contents-3">
        <a href="<?php echo $permalink ?>">
          <div class="mosaic-highlight mosaic-highlight-3" style="background-image: url('<?php echo $image; ?>')">
            <div class="highlight-tag">
              <?php echo $category; ?>
            </div>
          </div>
          <div class="highlight-title">
            <div class="<?php echo $title_array['title_class']; ?>">
              <?php echo $title_array['title']; ?>
            </div>
            <div class="<?php echo $title_array['subtitle_class']; ?>">
              <?php echo $title_array['subtitle']; ?>
            </div>
          </div>
        </a>
        <div class="authors">
          POR <?php echo $coauthors; ?>
        </div>
        <?php echo $excerpt; ?>
      </div>

      <div class="mosaic-column-2">
        <?php
        $post = $news_array[2];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

        $title = $post->post_title;
        ?>

        <div class="mosaic-news">
          <div class="mosaic-news-contents">
            <a href="<?php echo $permalink ?>">
              <div class="mosaic-news-image mosaic-news-image-2" style="background-image: url('<?php echo $image; ?>')">
                <div class="news-gradient-black">
                </div>
                <div class="news-tag-container">
                  <div class="news-tag">
                    <?php echo $category; ?>
                  </div>
                </div>
              </div>
              <div class="mosaic-news-title mosaic-news-title-1">
                <?php echo $title; ?>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>
    </div>

    
    <!-- <h1>MAIS LIDAS</h1>
    <div class="mosaic-row-4">


      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[0];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

        $title_array = separate_title_subtitle($post->post_title, "mosaic-news-title-1", "mosaic-news-subtitle-1");
        ?>

        <div class="mosaic-news">
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
              <div class="mosaic-news-title">
                <div class="<?php echo $title_array['title_class']; ?>">
                  <?php echo $title_array['title']; ?>
                </div>
                <div class="<?php echo $title_array['subtitle_class']; ?>">
                  <?php echo $title_array['subtitle']; ?>
                </div>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[1];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

        $title_array = separate_title_subtitle($post->post_title, "mosaic-news-title-1", "mosaic-news-subtitle-1");
        ?>

        <div class="mosaic-news">
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
              <div class="mosaic-news-title">
                <div class="<?php echo $title_array['title_class']; ?>">
                  <?php echo $title_array['title']; ?>
                </div>
                <div class="<?php echo $title_array['subtitle_class']; ?>">
                  <?php echo $title_array['subtitle']; ?>
                </div>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

      <div class="mosaic-column-3">
        <?php
        $post = $most_seen[2];
        $categories = get_the_category($post->ID);
        $category = $categories[0]->cat_name;
        foreach($categories as $cat) {
          $parent = get_the_category_by_ID($cat->parent);
          if ($parent == "Matéria") {
            $category = $cat->cat_name;
          }
        }
        $permalink = get_post_permalink($post->ID);
        $time = get_the_time('j \d\e F \d\e Y', $post->ID);
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];

        $title_array = separate_title_subtitle($post->post_title, "mosaic-news-title-1", "mosaic-news-subtitle-1");
        ?>

        <div class="mosaic-news">
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
              <div class="mosaic-news-title">
                <div class="<?php echo $title_array['title_class']; ?>">
                  <?php echo $title_array['title']; ?>
                </div>
                <div class="<?php echo $title_array['subtitle_class']; ?>">
                  <?php echo $title_array['subtitle']; ?>
                </div>
              </div>
            </a>
            <div class="authors">
              POR <?php echo $coauthors; ?>
            </div>
            <?php echo $time; ?>
          </div>
        </div>
      </div>

    </div>

  </div> -->

  <div class="space"></div>
  <div class="list">
    <div class="span8">

      <h1>RECENTES</h1>

      <?php
      // print_r($others_array);

      foreach($others_array as $post) {
        $categories = get_the_category($post->ID);
        $categories = get_the_category();
        if (count($categories) != 0) {
          $category = $categories[0]->cat_name;
        }
        if ($post->post_type == 'podcast') {
          $category = "Podcast";
        }
        if ($post->post_type == 'video') {
          $category = "Vídeo";
        }
        $permalink = get_post_permalink($post->ID);
        $excerpt = get_the_excerpt($post->ID);
        // $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
        // 'single-post-thumbnail' )[0];
        $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }

        $title_array = separate_title_subtitle($post->post_title, "list-news-title-1", "list-news-subtitle-1");
        ?>
        <div class="list-news">
          <a href="<?php echo $permalink; ?>">
            <div class="list-news-image" style="background-image: url('<?php echo $image; ?>')">
            </div>
          </a>
            <div class="list-news-contents">
              <div class="list-news-mobile-contents">
                <a href="<?php echo $permalink; ?>">
                  <h4>
                    <?php echo $category; ?>
                  </h4>
                  <div class="mosaic-news-title">
                    <div class="<?php echo $title_array['title_class']; ?>">
                      <?php echo $title_array['title']; ?>
                    </div>
                    <div class="<?php echo $title_array['subtitle_class']; ?>">
                      <?php echo $title_array['subtitle']; ?>
                    </div>
                  </div>

                </a>

                <div class="authors">
                  POR <?php echo $coauthors; ?>
                </div>
                <div class="list-news-date">
                  em <?php the_time('j \d\e F \d\e Y'); ?>
                </div>
                <div class="list-news-excerpt">
                  <p><?php echo $excerpt ?></p>
                </div>
              </div>
            </div>
        </div>


        <?php
      }
      ?>

      <div class="all">
        <a class="all-link" href="<?php echo site_url(); ?>?s=">
          Acervo
        </a>
      </div>

    </div>
    <div class="span4">

      <?php get_sidebar(); ?>

    </div>
  </div>

  <!-- Mobile layout -->
  <div class="compact-list">
    <?php

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if ($paged == 1) {

    $post = $highlights_array[0];
    $categories = get_the_category($post->ID);
    $category = $categories[0]->cat_name;
    foreach($categories as $cat) {
      $parent = get_the_category_by_ID($cat->parent);
      if ($parent == "Matéria") {
        $category = $cat->cat_name;
      }
    }
    $permalink = get_post_permalink($post->ID);

    $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
    $excerpt = get_the_excerpt($post->ID);
    // $coauthors = get_coauthors($post->ID);
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];

    $title_array = separate_title_subtitle($post->post_title, "highlight-title-1", "highlight-subtitle-1");
    ?>

    <div class="highlight-contents highlight-contents-1">
      <a href="<?php echo $permalink ?>">
        <div class="mosaic-highlight mosaic-highlight-1" style="background-image: url('<?php echo $image; ?>')">
          <div class="highlight-tag hightlight-tag-1" style="text-align: right;">
            <?php echo $category; ?>
          </div>
        </div>
        <div class="mosaic-news-title">
          <div class="<?php echo $title_array['title_class']; ?>">
            <?php echo $title_array['title']; ?>
          </div>
          <div class="<?php echo $title_array['subtitle_class']; ?>">
            <?php echo $title_array['subtitle']; ?>
          </div>
        </div>

      </a>
      <div class="authors authors-1">
        POR <?php echo $coauthors; ?>
      </div>
      <!-- <?php echo $excerpt; ?> -->
    </div>

    <?php
    $post = $highlights_array[1];
    $categories = get_the_category($post->ID);
    $category = $categories[0]->cat_name;
    foreach($categories as $cat) {
      $parent = get_the_category_by_ID($cat->parent);
      if ($parent == "Matéria") {
        $category = $cat->cat_name;
      }
    }
    $permalink = get_post_permalink($post->ID);

    $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
    $excerpt = get_the_excerpt($post->ID);
    // $coauthors = get_coauthors($post->ID);
    $image = get_post_meta($post->ID, 'icone', true);
    if ($image == '') {
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
    }

    $title_array = separate_title_subtitle($post->post_title, "highlight-title-2", "highlight-subtitle-2");

    ?>

    <div class="mobile-mosaic-row-2">
      <a class="mobile-mosaic-row-link" href="<?php echo $permalink ?>">
        <div class="mosaic-highlight mosaic-highlight-2" style="background-image: url('<?php echo $image; ?>')">
          <div class="highlight-tag">
            <?php echo $category; ?>
          </div>
        </div>
      </a>
      <div class="highlight-contents highlight-contents-2">
        <div class="highlight-mobile-contents">
          <a href="<?php echo $permalink ?>">
            <div class="mosaic-news-title">
              <div class="<?php echo $title_array['title_class']; ?>">
                <?php echo $title_array['title']; ?>
              </div>
              <div class="<?php echo $title_array['subtitle_class']; ?>">
                <?php echo $title_array['subtitle']; ?>
              </div>
            </div>
          </a>
          <div class="authors">
            POR <?php echo $coauthors; ?>
          </div>
        </div>
        <!-- <?php echo $excerpt; ?> -->
      </div>
    </div>

    <?php
    $post = $highlights_array[2];
    $categories = get_the_category($post->ID);
    $category = $categories[0]->cat_name;
    foreach($categories as $cat) {
      $parent = get_the_category_by_ID($cat->parent);
      if ($parent == "Matéria") {
        $category = $cat->cat_name;
      }
    }
    $permalink = get_post_permalink($post->ID);

    $coauthors = coauthors_posts_links(', ', ' E ', '', null, false);
    $excerpt = get_the_excerpt($post->ID);
    // $coauthors = get_coauthors($post->ID);
    $image = get_post_meta($post->ID, 'icone', true);
    if ($image == '') {
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
    }

    $title_array = separate_title_subtitle($post->post_title, "highlight-title-2", "highlight-subtitle-2");

    ?>

    <div class="mobile-mosaic-row-3">
      <div class="highlight-contents highlight-contents-3">
        <div class="highlight-mobile-contents">
          <a href="<?php echo $permalink ?>">
            <div class="mosaic-news-title">
              <div class="<?php echo $title_array['title_class']; ?>">
                <?php echo $title_array['title']; ?>
              </div>
              <div class="<?php echo $title_array['subtitle_class']; ?>">
                <?php echo $title_array['subtitle']; ?>
              </div>
            </div>
          </a>
          <div class="authors">
            POR <?php echo $coauthors; ?>
          </div>
        </div>
        <!-- <?php echo $excerpt; ?> -->
      </div>

      <a href="<?php echo $permalink ?>">
        <div class="mosaic-highlight mosaic-highlight-3" style="background-image: url('<?php echo $image; ?>')">
          <div class="highlight-tag">
            <?php echo $category; ?>
          </div>
        </div>
      </a>
    </div>

    <?php } ?>

    <!-- <h1>Matérias</h1>
    <h2>Notícias</h2>
    <h2>Vídeo & Podcast</h2> -->



    <?php 
    
    $args = array(
        'posts_per_page'   => 10,
        // 'category_name'    => 'audio_video',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => ['post', 'podcast', 'video'],
        'post_status'      => 'publish',
        'suppress_filters' => true
    );
    $others_array_mobile = get_posts( $args );
    
    foreach($others_array_mobile as $post) {
    // if ( have_posts() ) : while ( have_posts() ) : the_post();
    // $post = the_post();
    
    if (!in_array ($post, $highlights_array)) {

      $categories = get_the_category();
      if (count($categories) != 0) {
        $category = $categories[0]->cat_name;
      }
      if ($post->post_type == 'podcast') {
        $category = "Podcast";
      }
      if ($post->post_type == 'video') {
        $category = "Vídeo";
      }

      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $coauthors = coauthors_posts_links(', ', ' e ', '', null, false);
      $image = get_post_meta($post->ID, 'icone', true);
      if ($image == '') {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        $image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
      } else {
        $image_mobile = pathinfo($image, PATHINFO_DIRNAME) . '/' . pathinfo($image, PATHINFO_FILENAME).'-150x150.jpg';
      }

      $title = remove_formatting_chars( $post->post_title);

      ?>

      <style>
      #list-news-image-<?php echo $post->ID; ?> {
        background-image: url('<?php echo $image; ?>');
      }

      @media (max-width: 600px) {
        #list-news-image-<?php echo $post->ID; ?> {
          background-image: url('<?php echo $image_mobile; ?>');
        }
      }
      </style>

      <div class="list-news">
        <a href="<?php echo $permalink; ?>">
          <div class="list-news-image" id="list-news-image-<?php echo $post->ID; ?>">
          </div>
        </a>
          <div class="list-news-contents">
            <div class="list-news-mobile-contents">
              <a href="<?php echo $permalink; ?>">
                <h4>
                  <?php echo $category; ?>
                </h4>
                <div class="list-news-title list-news-title-1">
                  <?php echo $title; ?>
                </div>
              </a>

              <div class="authors">
                POR <?php echo $coauthors; ?>
              </div>
              <div class="list-news-excerpt">
                <!-- <?php echo $excerpt ?> -->
              </div>
              <!-- <?php the_time('j \d\e F \d\e Y'); ?> -->
            </div>
          </div>
      </div>



      <!-- <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <p><?php the_excerpt(); ?></p>
      <p><em><?php the_time('l, F jS, Y'); ?></em></p>
      <hr> -->

  <?php
    }
    // endwhile;
    // endif;
}
  ?>
  <div class="all">
    <a class="all-link" href="<?php echo site_url(); ?>?s=">
      Acervo
    </a>
  </div>
  <!-- <div class="all">
    <?php posts_nav_link('<span class="spacing"> </span>','Anterior','Próxima'); ?>
  </div> -->
  <!-- <div class="all">
    <a class="all-link" href="<?php echo site_url(); ?>/page/2">
      Próxima página
    </a>
  </div> -->
</div>

<?php get_footer(); ?>
