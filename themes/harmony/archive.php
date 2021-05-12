<?php get_header();

if ( is_category() ) {

    $title = 'Categoria: '.single_cat_title('', false);

} elseif ( is_tag() ) {

    $title = 'Tag: '.single_tag_title('', false);

} elseif ( is_author() ) {

  $uri = explode('/', $_SERVER['REQUEST_URI']);
  $title = get_user_by('slug', $uri[count($uri)-2])->display_name;

} else {
  $title = post_type_archive_title('', false);
}

?>
<title><?php echo $title; ?> - Harmony of Shinesparkers</title>
<div class="archive-list">
  <h1><?php echo $title; ?></h1>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

  $roles_array = wp_get_post_terms($post->ID, $taxonomy = 'role');
  $roles = [];
  foreach ($roles_array as $role) {
    if ($role->name != "musician") {
      $roles[] = $role->name;
    }
  }
  ?>

  <h3><?php echo the_title(); ?></h3>
  <h4><?php echo implode($roles, ", ") ?></h4>

  <?php endwhile; else: ?>
    <p><?php _e('Nenhum post encontrado.'); ?></p>
  <?php endif; ?>

    <!-- <div class="all">
      <?php posts_nav_link('<span class="spacing"> </span>','Anterior','Próxima'); ?>
    </div> -->
</div>

<?php get_footer(); ?>
