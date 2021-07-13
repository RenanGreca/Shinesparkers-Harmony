<?php get_header(); ?>

<title>Harmony of Shinesparkers</title>
<meta property="og:title" content="Harmony of Shinesparkers">
<meta property="og:type" content="website">
<meta property="og:url" content="https://harmony.shinesparkers.net/">
<meta property="og:image" content="<?php echo site_url(); ?>/wp-content/uploads/2021/06/Metroid25_Poster-compressed.jpg">

<div class="home-spacer"></div>

<div class="home-image">
  <img src="<?php echo site_url(); ?>/wp-content/uploads/2021/06/Metroid25_Poster-compressed.jpg"/>
</div>
<?php

// Find albums
$args = array(
  'numberposts'      => 30,
  'post_type'        => 'album',
  'post_status'      => 'publish'

);
$albums = get_posts( $args );

// usort($albums, function ( $a, $b ) {
//   $a_year = get_post_meta( $a->ID, 'year', true);
//   $b_year = get_post_meta( $b->ID, 'year', true);

//   return ($a_year < $b_year);
// });

foreach ($albums as $post):
  setup_postdata($post);

  // print_r($post);
  $meta_fields = get_post_custom();

  $permalink = get_post_permalink($post->ID);
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
  $excerpt = get_the_excerpt($post->ID);

  ?>
    <style type="text/css">
      #album-<?php echo $post->ID ?> a:hover {
        filter: drop-shadow(0 0 0.4rem #<?php echo $meta_fields["Color"][0]; ?>);
      }
    </style>

    <div id="album-<?php echo $post->ID ?>"
        style="color: #<?php echo $meta_fields["Color"][0]; ?>;
              background-color: #<?php echo $meta_fields["bg_color"][0]; ?>">
      <div class="container home-album">
        <div class="home-album-cover">
          <a href="<?php the_permalink(); ?>">
            <img src="<?php echo $image; ?>" />
          </a>
        </div>
        <div class="home-album-info">
          <div class="home-album-contents">
            <a href="<?php the_permalink(); ?>">
              <h2><?php echo $meta_fields['year'][0]; ?></h2>
              <h1><?php echo str_replace(": ", ":<br>", $post->post_title); ?></h1>
            </a>
            <?php echo $excerpt; ?>
          </div>
        </div>
      </div>
    </div>
  <?

endforeach;

get_footer();

?>
