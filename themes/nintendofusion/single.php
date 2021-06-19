<?php get_header(); ?>
<link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet">

<!-- Facebook API -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=976575375818675";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Twitter API -->
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>

<!-- Facebook comments -->
<!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.10&appId=976575375818675";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->

<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();
// Track pageviews
wpb_set_post_views(get_the_ID());
$views = wpb_get_post_views(get_the_ID());

$post = get_post();
// print_r($post);


$main_post_id = $post->ID;
$categories = get_the_category();
$permalink = get_the_permalink();
$category = $categories[0]->cat_name;
$cat = $post->post_type;
if ($cat == "podcast") {
  $category = "Podcast";
} else if ($cat == "video") {
  $category = "Vídeo";
}

$image_full = wp_get_attachment_image_src( get_post_thumbnail_id(),
'single-post-thumbnail' )[0];
$image_mobile = wp_get_attachment_image_src( get_post_thumbnail_id(),
'large' )[0];

$coauthors = coauthors_posts_links(', ', ' e ', null, null, false);

$title_array = separate_title_subtitle($post->post_title, "review-maintitle", "review-subtitle");

$post_title = remove_formatting_chars($post->post_title);

$meta_fields = get_post_custom();

$disclaimer = $meta_fields['disclaimer'][0];

?>
<title><?php echo $category; ?>: <?php echo $post_title; ?> - Neo Fusion</title>
<?php

  // print_r($post);
  $args = array(
    'posts_per_page'   => 3,
    'exclude'          => $post->ID,
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
  $ids = array();
  array_push($ids, $most_seen[0]->ID);

  if (count($most_seen) < 3) {
    $ids = array();
    for ($i=0; $i<count($most_seen); $i++) {
      array_push($ids, $most_seen[$i]->ID);
    }
    array_push($ids, $post->ID);

    $args = array(
      'posts_per_page'   => 3-count($most_seen),
      'exclude'          => $ids,
      'category_name'    => 'materia',
      'exclude'          => $ids,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'post',
      'post_status'      => 'publish',
      'suppress_filters' => true
    );
    $most_seen_extras = get_posts( $args );

    for ($i=0; $i<count($most_seen_extras); $i++) {
      array_push($most_seen, $most_seen_extras[$i]->ID);
    }
  }

  ?>

  <style>
  .review-image {
    background-image: url('<?php echo $image_full; ?>');
  }

  @media (max-width: 900px) {
    .review-image {
      background-image: url('<?php echo $image_mobile; ?>');
    }
  }
  </style>

  <?php
  $parent = get_the_category_by_ID($categories[0]->parent);
  if ($parent == "Matéria" || $categories[0]->name == "Matéria") {
    ?>
    <div class="review-image" style="">
      <!-- <div class="review-bg"> -->
      <div class="gradient-map">
      </div>
      <div class="gradient">
      </div>
      <div class="gradient-black">
      </div>

      <div class="review-header">


        <div class="review-tag">
          <?php echo $category; ?>
        </div>

        <div class="review-title">
          <div class="<?php echo $title_array['title_class']; ?>">
            <?php echo $title_array['title']; ?>
          </div>
          <div class="<?php echo $title_array['subtitle_class']; ?>">
            <?php echo $title_array['subtitle']; ?>
          </div>
        </div>

      </div>
    </div>

    <!-- <div class="review-space">
  </div> -->
  <div class="content review-content">
    <div class="review-date">
      <?php the_time('j \d\e F \d\e Y'); ?>
    </div>

    <div class="review-author">
      POR
      <?php
      echo $coauthors;
      ?>
    </div>

    <div class="review-disclaimer">
      <?php
      echo $meta_fields['disclaimer'][0];
      ?>
    </div>
  </div>

  <div class="content review-content">
    <?php the_content();
    $icone = $meta_fields['icone'][0];
    ?>

    <?php
    if ($category == 'Análise') {
      ?>
      <div class="review-summary">
        <?php // print_r($meta_fields);
        echo $meta_fields['resumo'][0];
        ?>
      </div>
      <?php
    }
    ?>
  </div>

  <?php
  if ($category == 'Análise') {
    ?>
    <div class="review-footer">
      <div class="review-footer-left">
        <div class="review-boxart" style="background-image: url('<?php echo $icone; ?>')">
          <div class="review-score">
            <!-- <?php 
            if ($meta_fields['nota'][0]) {
                echo $meta_fields['nota'][0]; 
            }
            ?> -->
          </div>
        </div>
      </div>
      <div class="review-footer-right">
        <div class="review-footer-details">
          <div class="review-footer-word"><?php echo nf_score_to_word($meta_fields['nota'][0]); ?></div>
          <div class="review-footer-title"><?php the_title(); ?></div>
          <?php if ($meta_fields['publisher'][0]) { ?>
            <span class="review-footer-detail">Publicadora</span> <?php echo $meta_fields['publisher'][0]; ?><br />
          <?php } ?>
          <span class="review-footer-detail">Desenvolvedora</span> <?php echo $meta_fields['developer'][0]; ?><br />
          <?php if ($meta_fields['equipe'][0]) { ?>
          <span class="review-footer-detail">Equipe</span> <?php echo $meta_fields['equipe'][0]; ?><br />
          <?php } ?>
          <span class="review-footer-detail">Plataformas</span> <?php echo $meta_fields['plataformas'][0]; ?> <br />
          <span class="review-footer-detail">Lançamento</span> <?php echo $meta_fields['data'][0]; ?><br />
        </div>
      </div>

    </div>
    <div class="ad-footer">
      <!-- footer AdSense ad -->
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- Footer ad -->
      <ins class="adsbygoogle"
      style="display:inline-block;width:728px;height:90px"
      data-ad-client="ca-pub-8943805401802569"
      data-ad-slot="9703492990"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
    <?php
  }
  ?>

  <div class="more-content">

    <div class="social-share-buttons">
      <!-- Facebook share button -->
      <div class="fb-share-button"
        data-href="<?php echo $permalink ?>"
        data-layout="button"
        data-size="large">
      </div>

      <!-- Twitter tweet button -->
      <a class="twitter-share-button"
        href="https://twitter.com/intent/tweet?via=neofusionbr"
        data-size="large">
      Tweet</a>
    </div>

    <h1>Leia também</h1>
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
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }

        $title_array = separate_title_subtitle(get_the_title($post->ID), "mosaic-news-title-1", "mosaic-news-subtitle-1");
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
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }

        $title_array = separate_title_subtitle(get_the_title($post->ID), "mosaic-news-title-1", "mosaic-news-subtitle-1");
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
        $image = get_post_meta($post->ID, 'icone', true);
        if ($image == '') {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
        }

        $title_array = separate_title_subtitle(get_the_title($post->ID), "mosaic-news-title-1", "mosaic-news-subtitle-1");
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
  </div>

  <?php if (!$_GET["preview"]) {?>
    <div class="comments-wrapper">
      <h3>Comentários</h3>
      <?php
      $post = get_post($main_post_id);
      comments_template(); ?>
    </div>
  <?php } ?>


<?php } else {
  ?>


  <div class="post-wrapper">
    <div class="span8">

      <h1><?php echo str_replace('~', '', $post->post_title); ?></h1>
      <?php
      // print_r($others_array);

      $categories = get_the_category($post->ID);
      $category = $categories[0]->cat_name;
      $permalink = get_post_permalink($post->ID);
      $excerpt = get_the_excerpt($post->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),
      'single-post-thumbnail' )[0];
      $meta_fields = get_post_custom();
      ?>

      <!-- <a href="<?php echo $permalink; ?>"> -->

      <div class="cover-wrapper">
      <?php
      if ($meta_fields['video'][0]) {
        ?>

          <iframe src="https://www.youtube.com/embed/<?php echo $meta_fields['video'][0]; ?>" frameborder="0" allowfullscreen>
          </iframe>

        <?php
      } else {
        ?>
        <div class="news-image" style="background-image: url('<?php echo $image; ?>')">
        </div>
        <?php
      }
      ?>
      </div>
      <!-- <div class="news-title">

    </div> -->
    <div class="news-date">
      <?php the_time('j \d\e F \d\e Y'); ?>
    </div>
    <div class="news-author">
      Por
      <?php
      echo $coauthors;
      ?>
    </div>
    <div class="content news-content">
        <div class="review-disclaimer">
        <?php
        echo $meta_fields['disclaimer'][0];
        ?>
        </div>
      <p><?php the_content(); ?></p>
    </div>

    <!-- </a> -->

    <div class="social-share-buttons">
      <!-- Facebook share button -->
      <div class="fb-share-button"
        data-href="<?php echo $permalink ?>"
        data-layout="button"
        data-size="large">
      </div>

      <!-- Twitter tweet button -->
      <a class="twitter-share-button"
        href="https://twitter.com/intent/tweet?via=neofusionbr"
        data-size="large">
      Tweet</a>
    </div>

    <?php if (!$_GET["preview"]) {?>
      <div class="comments-wrapper">
        <h3>Comentários</h3>
        <?php comments_template(); ?>
      </div>
    <?php } ?>
  </div>

  <div class="span4">

    <?php get_sidebar(); ?>

  </div>

</div>

<?php } ?>


<!-- <div class="comments-mobile">
<h3>Comentários</h3>
<div class="fb-comments"
data-href="http://192.168.1.110"
data-numposts="5"
colorscheme="dark"
data-mobile="true"></div>
</div> -->

<?php endwhile; else: ?>
  <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
