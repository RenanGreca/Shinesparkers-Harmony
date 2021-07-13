<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

$post = get_post();

$title = $post->post_title;

?>

<title><?php echo $title; ?> - Harmony of Shinesparkers</title>
<meta property="og:title" content="<?php echo $title; ?> - Harmony of Shinesparkers">
<meta property="og:type" content="website">
<meta property="og:url" content="https://harmony.shinesparkers.net/team/">
<meta property="og:image" content="<?php echo site_url(); ?>/wp-content/uploads/2021/06/Pallet_Town-compressed.jpg">

<div class="home-spacer"></div>
<div class="home-image">
  <img src="<?php echo site_url(); ?>/wp-content/uploads/2021/06/Pallet_Town-compressed.jpg"/>
</div>

  <!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet"> -->

  <div class="container">
    <div class="content review-content">
      <h1><?php echo $title; ?></h1>

      <!-- <div class="review-date">
        <?php the_time('j \d\e F \d\e Y'); ?>
      </div>

      <div class="review-author">
        POR
        <?php
        echo $coauthors;
        ?>
      </div> -->

      <?php the_content();  ?>
    </div>
  </div>


<?php endwhile; else: ?>
  <p><?php _e('Sorry, this page does not exist.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
