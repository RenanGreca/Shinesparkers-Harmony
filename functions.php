<?php 

/**
* Following this guide: 
* https://www.sitepoint.com/programmatically-creating-wordpress-posts-from-csv-data/
*/


function read_csv($custom_post_type) {

    $data = array();
    $errors = array();
    
    $file = site_url() . '/wp-content/uploads/2021/01/' . $custom_post_type . '.csv';
        
    // Check if file is writable, then open it in 'read only' mode
    if ( $_file = fopen( $file, "r" ) ) {
        
        // To sum this part up, all it really does is go row by
        //  row, column by column, saving all the data
        $post = array();
        
        // Get first row in CSV, which is of course the headers
        $header = fgetcsv( $_file );
        
        while ( $row = fgetcsv( $_file ) ) {
            
            foreach ( $header as $i => $key ) {
                $post[$key] = $row[$i];
            }
            
            $data[] = $post;
        }
        
        fclose( $_file );
        
    } else {
        $errors[] = "File '$file' could not be opened. Check the file's permissions to make sure it's readable by your server.";
    }
    
    if ( ! empty( $errors ) ) {
        // ... do stuff with the errors
    }
    
    return $data;
};

function is_post_duplicate ( $title, $custom_post_type ) {
    global $wpdb;

    // Simple check to see if the current post exists within the
    //  database. This isn't very efficient, but it works.

    // Get an array of all posts within our custom post type
    $posts = $wpdb->get_col( "SELECT post_title FROM {$wpdb->posts} WHERE post_type = '{$custom_post_type}'" );
        
    // Check if the passed title exists in array
    return in_array( $title, $posts );
}

function insert_posts( $custom_post_type, $slugs ) {
    // Get the data from all those CSVs!
    $posts = read_csv($custom_post_type);
    
    foreach ( $posts as $post ) {

        if ( !isset($post["title"]) ) {
            $post["title"] = $post["name"];
        }

        if ( !isset($post["description"]) ) {
            $post["description"] = $post["bio"];
        }
        
        // If the post exists, skip this post and go to the next one
        if ( is_post_duplicate( $post["title"], $custom_post_type ) ) {
            continue;
        }
        
        // Insert the post into the database
        $post["id"] = wp_insert_post( array(
            "post_title" => $post["title"],
            "post_content" => $post["description"],
            "post_type" => $custom_post_type,
            "post_status" => "publish"
        ));
  
        // Update post's custom field with attachment
        foreach ( $slugs as $custom_field ) {
            update_field( $custom_field, $post[$custom_field], $post["id"]);
        }
           
    }
}

/**
* Show 'insert posts' button on backend
*/
add_action( "admin_notices", function() {
    echo "<div class='updated'>";
    echo "<p>";
    echo "To insert Album posts, click the button to the right.";
    echo "<a class='button button-primary' style='margin:0.25em 1em' href='{$_SERVER["REQUEST_URI"]}&insert_harmony_album_posts=1'>Insert Album Posts</a>";
    echo "</p>";
    echo "</div>";
    
    echo "<div class='updated'>";
    echo "<p>";
    echo "To insert Musician posts, click the button to the right.";
    echo "<a class='button button-primary' style='margin:0.25em 1em' href='{$_SERVER["REQUEST_URI"]}&insert_harmony_musician_posts=1'>Insert Musician Posts</a>";
    echo "</p>";
    echo "</div>";
    
    echo "<div class='updated'>";
    echo "<p>";
    echo "To insert Track posts, click the button to the right.";
    echo "<a class='button button-primary' style='margin:0.25em 1em' href='{$_SERVER["REQUEST_URI"]}&insert_harmony_track_posts=1'>Insert Track Posts</a>";
    echo "</p>";
    echo "</div>";
});

/**
* Create and insert posts from CSV files
*/
function insert_posts_from_csv() {
    
    if ( isset( $_GET["insert_harmony_album_posts"] ) ) {
        $custom_post_type = "album";
    
        // Change these to whatever you set
        $slugs = array(
            "year",
            "zip_url",
            "torrent_url",
            "director",
            "assistant_directors"
        );


        insert_posts( $custom_post_type, $slugs );   

        add_action( "admin_notices", function() {
            echo "<div class='updated'>";
            echo "<p>";
            echo "Posts Inserted.";
            echo "</p>";
            echo "</div>";
        });

        return;
    }

    if ( isset( $_GET["insert_harmony_musician_posts"] ) ) {
        $custom_post_type = "musician";
    
        // Change these to whatever you set
        $slugs = array(
            "name",
            "country",
            "bio",
            "photo_url",
            "portfolio_url1",
            "portfolio_url2"
        );

        insert_posts( $custom_post_type, $slugs );   

        add_action( "admin_notices", function() {
            echo "<div class='updated'>";
            echo "<p>";
            echo "Posts Inserted.";
            echo "</p>";
            echo "</div>";
        });

        return;
    }

    if ( isset( $_GET["insert_harmony_track_posts"] ) ) {
        $custom_post_type = "track";
    
        // Change these to whatever you set
        $slugs = array(
            "album",
            "group",
            "track_no",
            "source",
            "original_game",
            "musician",
            "feat",
            "description",
            "mp3_url",
            "runtime"
        );

        insert_posts( $custom_post_type, $slugs );   

        add_action( "admin_notices", function() {
            echo "<div class='updated'>";
            echo "<p>";
            echo "Posts Inserted.";
            echo "</p>";
            echo "</div>";
        });

        return;
    }
    
    
}

add_action( 'admin_init', 'insert_posts_from_csv' );
?>