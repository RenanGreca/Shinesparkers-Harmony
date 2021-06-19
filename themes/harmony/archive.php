<?php get_header();

if ( is_category() ) {

    $title = 'Categoria: '.single_cat_title('', false);

} elseif ( is_tag() ) {

    $title = 'Tag: '.single_tag_title('', false);

} elseif ( is_author() ) {

  $uri = explode('/', $_SERVER['REQUEST_URI']);
  $title = get_user_by('slug', $uri[count($uri)-2])->display_name;

  
} else {

  $uri = explode('/', $_SERVER['REQUEST_URI']);
  $banner_url = "";
  if ($uri[count($uri)-2] == "musician") {
    $title = "Musicians";
    $banner_url = "2021/06/Harmony101_Samus_Nightmare-compressed.jpg";
  } else if ($uri[count($uri)-2] == "artist") {
    $title = "Artists";
    $banner_url = "2021/06/Final-Destination_compressed.jpg";
  }
  
  //post_type_archive_title('', false);
}

?>
<title><?php echo $title; ?> - Harmony of Shinesparkers</title>
<div class="home-spacer"></div>
<div class="home-image">
  <img src="<?php echo site_url(); ?>/wp-content/uploads/<?php echo $banner_url; ?>"/>
</div>
<div class="container">
<div class="archive-list">
  <h1><?php echo $title; ?></h1>

  <?php 
  
  $posts = [];
  if ($uri[count($uri)-2] == "musician") {
    $args = array(
      'numberposts'      => 300,
      'post_type'        => 'staff',
      'post_status'      => 'publish',
      'tax_query' => array(
        array(
            'taxonomy' => 'role',
            'field'    => 'slug',
            'terms'    => 'musician',
        ),
      ),
      
    );
    $posts = get_posts( $args );
    // print_r($posts);
  }

  if ($uri[count($uri)-2] == "artist") {
    $args = array(
      'numberposts'      => 300,
      'post_type'        => 'staff',
      'post_status'      => 'publish',
      'tax_query' => array(
        array(
            'taxonomy' => 'role',
            'field'    => 'slug',
            'terms'    => 'artist',
        ),
      ),
      
    );
    $posts = get_posts( $args );
    // print_r($posts);
  }
  
  if (($uri[count($uri)-2] == "artist") || ($uri[count($uri)-2] == "musician")):
    $list = [];
    $sublist = [];
    $i = 0;

    // echo print_r($posts[18])." ";
    foreach ($posts as $post):

      setup_postdata($post);

      $roles_array = wp_get_post_terms($post->ID, $taxonomy = 'role');
      $roles = [];
      foreach ($roles_array as $role) {
        // echo $role->name;
        if ($role->name != "Musician") {
          $roles[] = $role->name;
        }
      }
      

      $list[] = '<a href="'.get_permalink($post->ID).'">'. $post->post_title .'</a>';
      $i += 1;
      // <!-- <h4><?php echo implode($roles, ", ") </h4> -->

    endforeach; 

    // $list2 = [];
    $sublist = [];
    $chunk_count = 3;
    $chunk_size = ceil(count($list)/3);

    for ($i = 0; $i < $chunk_count; $i++):
      $sublist[] = array_slice($list, $chunk_size*$i, $chunk_size);
    endfor;

    // print_r($sublist);

    ?>
    <div class="staff-list">
    <?php

    foreach ($sublist as $list):

    ?>

      
        <div class="staff-list-row">
        <?php
        foreach ($list as $link):
          echo $link;
        endforeach;
        ?>
        </div>

    <?php

    endforeach;
  endif;



  // for ($i = 0; $i<)

  ?>
  </div>

    <!-- <div class="all">
      <?php posts_nav_link('<span class="spacing"> </span>','Anterior','Próxima'); ?>
    </div> -->
</div>
</div>

<?php get_footer(); ?>
