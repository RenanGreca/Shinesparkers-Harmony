<?php get_header(); ?>
<!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/single.css" rel="stylesheet"> -->

<?php while ( have_posts() ) : the_post(); ?>

<title><?php the_title(); ?> - Harmony of Shinesparkers</title>

<div class="spacer"></div>
<div class="container">
<?php
$meta_fields = get_post_custom();
$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' )[0];
?>

<!-- <?php get_template_part( 'partials/blog/content', get_post_format() ); ?> -->

<?php

// =================================================================
// ALBUM
// =================================================================

if ($post->post_type == "album") {

  $content = $post->post_content;
  $description = substr($content, 0, strpos($content, '<h2 id="download"'));

  $download = substr($content, strpos($content, '<h2 id="download"'), strpos($content, '<h2 id="artwork"')-strpos($content, '<h2 id="download"'));

  $artwork = substr($content, strpos($content, '<h2 id="artwork"'));

  $album_title = $post->post_title;
  ?>

  <style>
    body {
      background-color: #<?php echo $meta_fields['bg_color'][0]; ?>;
    }

    h1, h2, h3, h4 {
      color: <?php echo $meta_fields['Color'][0]; ?>;
    }

    h3 {
      text-align: center;
    }

    hr {
      border-color: <?php echo $meta_fields['Color'][0]; ?>;
    }

    a {
      color: <?php echo $meta_fields['Color'][0]; ?>;
      font-weight: bold;
      transition: color 0.3s ease;
    }

    a:hover {
      color: white;
    }
  </style>

  <h1 id="top" class="post-title" style="text-align: center;">
    <?php echo str_replace(": ", ":<br>", $album_title); ?>
  </h1>
  <h3 style="padding-top: 0;">
    <?php echo $meta_fields['year'][0]; ?>
  </h3>

  <div class="home-album">
    <div class="home-album-cover">
      <img src="<?php echo $image ?>" />
      <div class="album-links">
        <a href="#download">Download</a> •
        <a href="#tracks">Tracks</a> •
        <a href="#artwork">Artwork</a> •
        <a href="#extras">Extras</a>
      </div>
    </div>
    <div class="home-album-info">
      <div class="home-album-contents" style="text-align: left;">
        <?php echo $description; ?>
        <br/><br/>
        <?php
          $director = $meta_fields['Director'][0];
          $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='staff' AND `post_title`='$director'" );
          echo 'Director and Producer — <a href="'.get_permalink($results[0]->ID).'">'.$results[0]->post_title.'</a>';
        ?>
        <br/>
        <?php
          $directors = explode(',', $meta_fields["Assistant Director"][0]);
          $list = [];
          // print_r($directors);
          foreach ($directors as $director) {
            $director = trim($director);
            $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='staff' AND `post_title`='$director'" );
            // print_r($results);

            if (count($results) > 0) {
              $list[] = '<a href="'.get_permalink($results[0]->ID).'">'.$results[0]->post_title.'</a>';
            } else {
              $list[] = $director;
            }
          }
          if (count($list) > 1) {
            echo "Assistant Director(s) — ".implode(", ", $list);
          } else {
            echo "Assistant Director — ".implode(", ", $list);
          }
          if ($album_title == "Harmony of a Champion") {
            echo "<div style='margin-top: 4px;'>Sound Design — Gina Zdanowicz, Spencer Bambrick</div>";
          }

        ?>
      </div>
    </div>
  </div>

  <hr/>
  <?php
  echo $download;

  // Find tracks that belong to this album
  $args = array(
    'numberposts'      => 200,
    'post_type'        => 'track',
    'post_status'      => 'publish',
    'meta_key'         => 'album',
    'meta_value'       => $post->post_title

  );
  $tracks = get_posts( $args );

  // Sort tracks by group and track number
  usort($tracks, function ($a, $b) {
    $a_trackno = get_post_meta( $a->ID, 'track_no', true);
    $b_trackno = get_post_meta( $b->ID, 'track_no', true);

    $a_groupno = get_post_meta( $a->ID, 'group_no', true);
    $b_groupno = get_post_meta( $b->ID, 'group_no', true);

    return ($a_groupno > $b_groupno) || (($a_groupno == $b_groupno) && ($a_trackno > $b_trackno));
  });

  $current_group = "";
  ?>
  <hr/>
  <h2 id="tracks">Tracks</h2>
  <ul class="album-track-list">
  <?php
  foreach ($tracks as $post):
    // $post = $tracks[$i];
    setup_postdata($post);

    $track_fields = get_post_custom();
    $track_no = $track_fields["track_no"][0];

    if ($track_fields['group'][0] != $current_group) {
      $current_group = $track_fields['group'][0];
      ?>
      <h3><?php echo $current_group ?></h3>
      <?php
    }
    ?>

    <li>

    <div class="album-track" style="background: rgb(255 255 255 / <?php echo ( ($track_no % 2 == 0 ) ? "5%" : "0%" ); ?> );">
      <div class="album-track-info">
        <h4>
          <a href="<?php the_permalink(); ?>">
          <?php
          echo $track_no . ". ";
          the_title(); ?>
          </a>
        </h4>

        <?php

        echo "by ";
        $musicians = explode(',', $track_fields["musician"][0]);
        $list = get_staff_links($musicians);

        echo implode(", ", $list);

        $musicians = explode(',', $track_fields["feat"][0]);
        if (strlen($musicians[0]) > 0) {
          echo " feat. ";
        }
        $list = get_staff_links($musicians);
        echo implode(", ", $list);
        echo "<br>";
        $source_track = "";
        if (strlen($track_fields["original_game"][0]) > 0) {
          $source_track = " (" . $track_fields["original_game"][0] . ")";
        }
        echo '<span class="source">'.$track_fields["source"][0] . $source_track .'</span>';
        ?>
      </div>

      <?php
      if ($album_title == "Harmony of a Champion"):
      ?>
      <iframe style="border: 0; height: 42px;"
              src="https://bandcamp.com/EmbeddedPlayer/album=2814907003/size=small/bgcol=333333/linkcol=e99708/track=<?php echo $track_fields["mp3_url"][0]; ?>/transparent=true/" seamless>

              <a href="https://shinesparkers.bandcamp.com/album/harmony-of-a-champion-music-from-pok-mon-red-and-green-versions">
                Harmony of a Champion (Music from Pokémon Red and Green Versions)
              </a>
      </iframe>
      <?php
      else: ?>
      <div class="album-track-player">
        <audio controls preload="none">
          <source src="<?php echo $track_fields["mp3_url"][0]; ?>" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
      </div>
      <?php
      endif;
      ?>
    </div>
    <!-- <?php echo ($track_fields["feat"][0] != "" ? " feat. ".$track_fields["feat"][0] : "" ) ?> -->


    <!-- <hr> -->
    </li>
    <?php

    wp_reset_postdata();
    endforeach; ?>
  </ul>

  <hr/>
  <?php

  echo apply_filters('the_content', $artwork);
  ?>
  <div class="scrolltop"><a href="#top">⬆</a></div>
  <?php
}

// =================================================================
// TRACK
// =================================================================

if ($post->post_type == "track") {

  $album = $meta_fields['album'][0];
  $albums = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$album'" );
  $album = $albums[0];

  // setup_postdata($album);

  $track_fields = get_post_custom();
  $album_fields = get_post_custom($album->ID);
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $album->ID ), 'single-post-thumbnail' )[0];

  ?>
  <style>
    body {
      background-color: #<?php echo $album_fields['bg_color'][0]; ?>;
    }

    h1, h2, h3 {
      color: #<?php echo $album_fields['color'][0]; ?>;
    }

    a {
      color: #<?php echo $album_fields['color'][0]; ?>;
      transition: color 0.3s ease;
    }

    a:hover {
      color: white;
    }

    h3 {
      text-align: center;
    }

    h4 {
      padding: 0;
    }
  </style>


  <h1 class="post-title">
    <?php the_title(); ?>
  </h1>

  <a href="<?php the_permalink($album->ID); ?>">
    <div class="track-album">
      <div class="track-album-cover">
        <img src="<?php echo $image; ?>" />
      </div>
      <div class="track-album-info">
        <div class="track-album-title">
          <h4>
            <?php echo $album->post_title; ?>
          </h4>
          <span style="color: white;">
            Track <?php echo $track_fields["track_no"][0]; ?>
          </span>
        </div>
      </div>
    </div>
  </a>

  <?php

  echo "By ";
  $musicians = explode(',', $track_fields["musician"][0]);
  $list = get_staff_links($musicians);
  echo implode(", ", $list);

  $musicians = explode(',', $track_fields["feat"][0]);
  if (strlen($musicians[0]) > 0) {
    echo " feat. ";
  }
  $list = get_staff_links($musicians);
  echo implode(", ", $list).'<br>';
  $source_track = "";
  if (strlen($track_fields["original_game"][0]) > 0) {
    $source_track = " (" . $track_fields["original_game"][0] . ")";
  }
  echo '<div class="source">'.$track_fields["source"][0] . $source_track .'</div>';


  if ($album->post_title == "Harmony of a Champion"):
    ?>
      <iframe style="border: 0; margin: 10px 0; height: 42px;"
              src="https://bandcamp.com/EmbeddedPlayer/album=2814907003/size=small/bgcol=333333/linkcol=e99708/track=<?php echo $track_fields["mp3_url"][0]; ?>/transparent=true/" seamless>

              <a href="https://shinesparkers.bandcamp.com/album/harmony-of-a-champion-music-from-pok-mon-red-and-green-versions">
                Harmony of a Champion (Music from Pokémon Red and Green Versions)
              </a>
      </iframe>
      <?php
      else: ?>
      <div class="album-track-player" style="float: none; margin-top: 16px;">
        <audio controls preload="none">
          <source src="<?php echo $track_fields["mp3_url"][0]; ?>" type="audio/mpeg">
          Your browser does not support the audio element.
        </audio>
      </div>
      <h2>Download</h2>
      <a href="<?php echo $track_fields["mp3_url"][0] ?>" rel="noopener" target="_blank">⬇ MP3</a> •
      <a href="<?php echo $track_fields["flac_url"][0] ?>" rel="noopener" target="_blank">⬇ FLAC</a>
    <?php
  endif;
  ?>

  <!-- <div class="track-player">
    <audio controls preload="none">
      <source src="<?php echo $track_fields["mp3_url"][0]; ?>" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>
  </div> -->

  <br><br>

  <p><?php the_content(); ?></p>

  <?php
  // wp_reset_postdata();

}

// =================================================================
// STAFF
// =================================================================

if ($post->post_type == "staff") {
  // Find tracks that belong to this album
  $musician = $post->post_title;
  $args = array(
    'numberposts'      => 50,
    'post_type'        => 'track',
    'post_status'      => 'publish',

    'meta_query' => array (
      'relation' => 'OR',
      array (
        'key'         => 'musician',
        'value'       => $post->post_title,
        'compare'     => 'LIKE'
      ),
      array (
        'key'         => 'feat',
        'value'       => $post->post_title,
        'compare'     => 'LIKE'
      )
    )
  );
  $tracks = get_posts( $args );
  usort($tracks, function ($a, $b) use ($wpdb) {
    $a_album = get_post_meta( $a->ID, 'album', true);
    $b_album = get_post_meta( $b->ID, 'album', true);

    $a_album = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$a_album'" );
    $b_album = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$b_album'" );

    $a_albumno = get_post_meta( $a_album[0]->ID, 'number', true);
    $b_albumno = get_post_meta( $b_album[0]->ID, 'number', true);

    $a_trackno = get_post_meta( $a->ID, 'track_no', true);
    $b_trackno = get_post_meta( $b->ID, 'track_no', true);

    $a_groupno = get_post_meta( $a->ID, 'group_no', true);
    $b_groupno = get_post_meta( $b->ID, 'group_no', true);

    $track_order = ($a_groupno > $b_groupno) || (($a_groupno == $b_groupno) && ($a_trackno > $b_trackno));

    $track_order =  ($b_albumno > $a_albumno) ||
                    (($a_albumno == $b_albumno) && ($track_order));// ||
                    //((($a_albumno == $b_albumno) && ($a_groupno == $b_groupno)) && ($a_trackno > $b_trackno));

    return $track_order;
  });

  $musician_fields = get_post_custom();
  ?>

  <h1 class="post-title">
    <?php the_title(); ?>
  </h1>



  <?php
  $content = $post->post_content;

  if (strpos($content, '<h2 id="artwork"') !== false) {
    $description = substr($content, 0, strpos($content, '<h2 id="artwork"'));
    $artwork = substr($content, strpos($content, '<h2 id="artwork"'));
  } else {
    $description = $content;
  }

  ?>
  <p><?php echo apply_filters('the_content', $description); ?></p>
  <?php


  $i=1;
  $list=[];
  for ($i=1; $i<=3; $i+=1) {
    $url = $musician_fields["portfolio_url".$i][0];
    $title = $musician_fields["portfolio_title".$i][0];

    if ($url && title) {
      $list[] = "<a target=\"_blank\" href=".$url.">".$title."</a>";
    }

  }

  if (count($list) > 0) {
    echo "<h2>Portfolio & Contact</h2>";
    echo '<div class="portfolio-links">'.implode(" • ", $list).'</div>';
  }

  $terms = wp_get_post_terms( $post->ID, 'role');
  foreach ( $terms as $term ) {
      $roles[] = $term->slug;
  }

  // print_r($roles);

  if (in_array("musician", $roles)):

    ?>
    <h2>Tracks</h2>
    <ul class="album-track-list">
    <?php
    $i=0;
    foreach ($tracks as $post):
      // setup_postdata($post);

      $track_fields = get_post_custom();

      $album = $track_fields['album'][0];
      $album = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$album'" )[0];
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $album->ID ), 'single-post-thumbnail' )[0];

      ?>

      <li>

      <!-- <a href="<?php the_permalink($post->ID); ?>">
        <div class="track-album">
          <div class="track-album-cover">
            <img src="<?php echo $image; ?>" />
          </div>
          <div class="track-album-info">
            <div class="track-album-title">
              <h4>
                <?php echo $post->post_title; ?>
              </h4>
              <span style="color: white;">
                <?php echo $album->post_title.", track ".$track_fields["track_no"][0]; ?>
              </span>
            </div>
          </div>
        </div>
      </a> -->

      <div class="album-track" style="background: rgb(255 255 255 / <?php echo ( ($i % 2 == 0 ) ? "5%" : "0%" ); ?> );">
        <div class="album-track-cover">
            <img src="<?php echo $image; ?>" />
        </div>
        <div class="album-track-info">
          <h4>
            <a href="<?php the_permalink(); ?>">
            <?php
            the_title(); ?>
            </a>
          </h4>

          <?php
          $i += 1;

          // echo $meta_fields["musician"][0];
          ?>
          <div style="margin-bottom: -5px;">
          from <a href="<?php echo get_permalink($album->ID); ?>"> <?php echo $album->post_title; ?> </a>
          </div>
          <?php


          $musicians = explode(',', $track_fields["musician"][0]);
          $list = get_staff_links($musicians);
          // echo "<div>by ".implode(", ", $list)."";

          $musicians = explode(',', $track_fields["feat"][0]);
          if (strlen($musicians[0]) > 0) {
            // echo " feat. ";
          }
          $list = get_staff_links($musicians);
          // echo implode(", ", $list);
          $source_track = "";
          if (strlen($track_fields["original_game"][0]) > 0) {
            $source_track = " (" . $track_fields["original_game"][0] . ")";
          }
          // echo '</div>';
          // echo '<div class="source">'.$track_fields["source"][0] . $source_track .'</div>';
          ?>
        </div>

        <?php
        if ($track_fields["album"][0] == "Harmony of a Champion"):
        ?>
        <iframe style="border: 0; height: 42px;"
                src="https://bandcamp.com/EmbeddedPlayer/album=2814907003/size=small/bgcol=333333/linkcol=e99708/track=<?php echo $track_fields["mp3_url"][0]; ?>/transparent=true/" seamless>

                <a href="https://shinesparkers.bandcamp.com/album/harmony-of-a-champion-music-from-pok-mon-red-and-green-versions">
                  Harmony of a Champion (Music from Pokémon Red and Green Versions)
                </a>
        </iframe>
        <?php
        else: ?>
        <div class="album-track-player">
          <audio controls preload="none">
            <source src="<?php echo $track_fields["mp3_url"][0]; ?>" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
        </div>
        <?php
        endif;
        ?>
      </div>
      <!-- <?php echo ($track_fields["feat"][0] != "" ? " feat. ".$track_fields["feat"][0] : "" ) ?> -->


      <!-- <hr> -->
      </li>
      <?php

      wp_reset_postdata();
      endforeach; ?>
      </ul>

    <?php
  endif;

  if (strpos($content, '<h2 id="artwork"') !== false):
    echo apply_filters('the_content', $artwork);
  endif;

}

// // If comments are open or we have at least one comment, load up the comment template
// if ( comments_open() || '0' != get_comments_number() )
//   comments_template();
?>

<?php endwhile; // end of the loop. ?>

</div>

<?php get_footer(); ?>
