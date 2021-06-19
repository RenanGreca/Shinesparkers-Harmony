<?php

add_action( 'init', 'set_theme_cookie' );
// Dark and light theme cookie
function set_theme_cookie() {
  $theme_id = 'dark';
  // If there already is a cookie, set current theme to it.
  if (isset($_COOKIE['theme']) &&
      (($_COOKIE['theme'] == 'dark') || ($_COOKIE['theme'] == 'light'))) {

      $theme_id = $_COOKIE['theme'];
  }
  // If there is a theme on the GET parameters, create or update the cookie.
  if (isset($_GET['theme']) &&
      (($_GET['theme'] == 'dark') || ($_GET['theme'] == 'light'))) {

      $theme_id = $_GET['theme'];
      setcookie('theme', $theme_id, time() + (86400 * 30), "/");
  }

  $GLOBALS['theme'] = $theme_id;
}

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

//Lets add Open Graph Meta Info
function insert_fb_in_head() {
    global $post;

    echo '<meta property="fb:admins" content="1001692808"/>
    ';
    echo '<meta property="fb:admins" content="100000307065898"/>
    ';
    echo '<meta property="fb:app_id" content="976575375818675"/>
    ';
    echo '<meta property="og:site_name" content="Neo Fusion"/>
    ';

    if ( !is_singular()) { //if it is not a post or a page
      echo '<meta property="og:image" content="' . get_bloginfo('template_url')."/img/wallpaper-small.png?v=2" . '"/>
      ';
      echo '<meta property="og:title" content="Neo Fusion"/>
      ';
      echo '<meta property="og:url" content="https://neofusion.com.br"/>
      ';
      return;
    }
    $categories = get_the_category();
    $category = $categories[0]->cat_name;
    $cat = get_post_type();
    if ($cat == "podcast") {
      $category = "Podcast";
    } else if ($cat == "video") {
      $category = "Vídeo";
    }
    $title = remove_formatting_chars(get_the_title());
    if ($category) {
        $title = $category . ': ' . $title;
    }
    echo '<meta property="og:title" content="' . $title . '"/>
    ';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>
    ';
    echo '<meta property="og:description" content="' . get_the_excerpt() . '"/>
    ';
    $coauthors = coauthors(', ', ' e ', null, null, false);
    echo '<meta property="article:author" content="' . $coauthors . '"/>
    ';

    if (!has_post_thumbnail( $post->ID )) {
        //the post does not have featured image, use a default image
        $image = get_bloginfo('template_url')."/img/wallpaper-small.png?v=2";
    } else {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
    }
    $image_size = getimagesize($image);
    echo '<meta property="og:image" content="' . $image . '"/>
    ';
    echo '<meta property="og:image:width" content="' . $image_size[0] . '"/>
    ';
    echo '<meta property="og:image:height" content="' . $image_size[1] . '"/>
    ';
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

// function wpbootstrap_scripts_with_jquery()
// {
//     // Register the script like this for a theme:
//     wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
//     // For either a plugin or a theme, you can then enqueue the script:
//     wp_enqueue_script( 'custom-script' );
// }
// add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

add_theme_support( 'post-thumbnails' );

// Used to track number of views in each post
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function nf_score_to_word($score) {
  if ($score == 10) {
    return "Obra-prima";
  } else if ($score >= 9) {
    return "Excelente";
  } else if ($score >= 8) {
    return "Ótimo";
  } else if ($score >= 7) {
    return "Bom";
  } else if ($score >= 6) {
    return "Aceitável";
  } else if ($score >= 5) {
    return "Medíocre";
  } else if ($score >= 4) {
    return "Ruim";
  } else if ($score >= 3) {
    return "Muito ruim";
  } else if ($score >= 2) {
    return "Desagradável";
  } else if ($score >= 1) {
    return "Desastre";
  } else if ($score == 0) {
    return "Péssimo";
  }
}

function remove_formatting_chars( $title, $id = null ) {
  $title = str_replace('~', '', $title);
  $title = str_replace('^', '', $title);
  return $title;
}
add_filter( 'the_title', 'remove_formatting_chars', 10, 2 );

function new_previous_posts_link_attributes(  ) {
  return 'class="post-link-prev"';
}
add_filter( 'previous_posts_link_attributes', 'new_previous_posts_link_attributes' );

function new_next_posts_link_attributes(  ) {
  return 'class="post-link-next"';
}
add_filter( 'next_posts_link_attributes', 'new_next_posts_link_attributes' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


function separate_title_subtitle($title, $large_class, $small_class) {

    $result['title'] = $title;
    $result['subtitle'] = "";
    $result['title_class'] = $large_class;
    $result['subtitle_class'] = "";


    // Use ~ to make the subtitle bigger than the title
    if ($pos = strpos($title, '~')) {
      $result['title'] = substr($title, 0, $pos);
      $result['title_class'] = $small_class;
      $result['subtitle'] = substr($title, $pos+2);
      $result['subtitle_class'] = $large_class;   
    }

    // Use ^ to make the title bigger than the subtitle
    if ($pos = strpos($title, '^')) {
      $result['title'] = substr($title, 0, $pos);
      $result['title_class'] = $large_class;
      $result['subtitle'] = substr($title, $pos+2);
      $result['subtitle_class'] = $small_class;
    }

    return $result;
}

?>
