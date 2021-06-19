<?php
/**
 * The Template for displaying all single posts.
 *
 * @package unitedthemes
 */

get_header(); ?>

[bandcamp width=100% height=42 album=2814907003 size=small bgcol=ffffff linkcol=0687f5 track=2991542520][bandcamp width=100% height=42 album=2814907003 size=small bgcol=ffffff linkcol=0687f5 track=2023861669]

		<div class="grid-container">		
        	
            <?php if( ot_get_option( 'ut_single_posts_sidebar', 'on' ) == 'on' && is_active_sidebar( 'blog-widget-area' ) ) {
                
                $grid = 'grid-75 tablet-grid-100 mobile-grid-100';
                
            } else {
                
                $grid = 'grid-100 tablet-grid-100 mobile-grid-100';     
                
            } ?>
            
            <div id="primary" class="grid-parent <?php echo $grid; ?>">
    
            <?php while ( have_posts() ) : the_post(); ?>
                
                

                <?php
                $meta_fields = get_post_custom();

                ?><h1><?php the_title(); ?></h1>
                <?php get_template_part( 'partials/blog/content', get_post_format() ); ?>

                <?php

                if ($post->post_type == "album") {

                    // Find tracks that belong to this album
                    $args = array(
                        'numberposts'      => 30,
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

                        $a_groupno = get_post_meta( $a->ID, 'group', true);
                        $b_groupno = get_post_meta( $b->ID, 'group', true);

                        return ($a_groupno > $b_groupno) || (($a_groupno == $b_groupno) && ($a_trackno > $b_trackno));
                    });

                    $current_group = "";
                    ?>
                    <h1>Tracks</h1>
                    <ul>
                    <?php foreach ($tracks as $post):
                        setup_postdata($post);

                        $meta_fields = get_post_custom();

                        if ($meta_fields['group'][0] != $current_group) {
                            $current_group = $meta_fields['group'][0];
                            ?>
                                <h2><?php echo $current_group ?></h2>
                            <?php
                        }
                        ?>
                        
                        <li style="padding-left: 50px; margin: 15px">
                            <h3 style="margin-bottom: 0px;">
                            <a href="<?php the_permalink(); ?>">
                                <?php 
                                echo $meta_fields["track_no"][0] . ". ";
                                the_title(); ?>
                            </a>
                            </h3>
                            <?php 
                            
                            echo "By ";
                            $musicians = explode(';', $meta_fields["musician"][0]);
                            foreach ($musicians as $musician) {

                                $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='musician' AND `post_title`='$musician'" );
                                // echo $meta_fields["musician"][0]; 
                                ?>
                                <a href="<?php echo $results[0]->guid; ?>"> <?php echo $results[0]->post_title; ?> </a>
                                <?php
                            
                            }

                            $musicians = explode(';', $meta_fields["feat"][0]);
                            if (strlen($musicians[0]) > 0) {
                                echo " feat. ";
                            }
                            foreach ($musicians as $musician) {

                                $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='musician' AND `post_title`='$musician'" );
                                // echo $meta_fields["musician"][0]; 
                                ?>
                                <a href="<?php echo $results[0]->guid; ?>"> <?php echo $results[0]->post_title; ?> </a>
                                <?php
                            
                            }
                            echo ", based on ";
                            echo $meta_fields["source"][0] . " (" . $meta_fields["original_game"][0] . ")";
                            ?>
                            <!-- <?php echo ($meta_fields["feat"][0] != "" ? " feat. ".$meta_fields["feat"][0] : "" ) ?> -->
                        </li>
                    <?php 
                        
                        wp_reset_postdata();
                    endforeach; ?>
                    </ul>

        
                    <?php

                }

                if ($post->post_type == "track") {

                    $album = $meta_fields['album'][0];
                    $albums = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$album'" );

                    ?>
                    <b>Album</b>: <a href="<?php echo $albums[0]->guid; ?>"> <?php echo $albums[0]->post_title; ?> </a>
                    <?php
                    wp_reset_postdata();

                }


                if ($post->post_type == "musician") {
                    // Find tracks that belong to this album
                    $musician = $post->post_title;
                    $args = array(
                        'numberposts'      => 30,
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
                    ?>
                    <h1>Tracks</h1>
                    <ul>
                    <?php foreach ($tracks as $post):
                        setup_postdata($post);

                        $meta_fields = get_post_custom();

                        ?>
                        
                        <li style="padding-left: 50px; margin: 15px">
                            <h3 style="margin-bottom: 0px;">
                            <a href="<?php the_permalink(); ?>">
                                <?php 
                                the_title(); ?>
                            </a>
                            </h3>
                            <?php 
                            
                            echo "From ";
                            $album = $meta_fields['album'][0];
                            $results = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_type`='album' AND `post_title`='$album'" );
                            // echo $meta_fields["musician"][0]; 
                            ?>
                            <a href="<?php echo $results[0]->guid; ?>"> <?php echo $results[0]->post_title; ?> </a>
                            <?php
                            
                            echo ", based on ";
                            echo $meta_fields["source"][0] . " (" . $meta_fields["original_game"][0] . ")";
                            ?>
                            <!-- <?php echo ($meta_fields["feat"][0] != "" ? " feat. ".$meta_fields["feat"][0] : "" ) ?> -->
                        </li>
                    <?php 
                        
                        wp_reset_postdata();
                    endforeach; ?>
                    </ul>
                    <?php

                }

                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template();
                ?>
    
            <?php endwhile; // end of the loop. ?>
            
            </div>
        
        	<?php if( ot_get_option( 'ut_single_posts_sidebar', 'on' ) == 'on' && is_active_sidebar( 'blog-widget-area' ) ) {
            
                get_sidebar(); 
            
            } ?>
            
		</div>
		
        <div class="ut-scroll-up-waypoint" data-section="section-<?php echo ut_clean_section_id($post->post_name); ?>"></div>
        
<?php get_footer(); ?>