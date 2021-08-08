<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Le styles -->
        <style>
            :root {
            <?php
            if ($GLOBALS['theme'] == 'light') {
              ?> --dark-background: #f1e8e8;
                --white: #000000;
                --light-text: #0c0c0c;
                /* --neon-red: #df2327;
                --neon-blue: #40c7ff; */
                --neon-red: #ffffff;
                --neon-blue: #ffffff;
            <?php
          } else {
            ?>
                /* --dark-background: #070f20; */
                --dark-background: #000000;
                --white: #ffffff;
                --light-text: #dbecf0;
                /* --neon-red: #fe494d;
                --neon-blue: #3ffdfe; */
                --neon-red: #ffffff;
                --neon-blue: #ffffff;
            <?php
          }
          ?> --container-width-1600: 850px;
                --container-width-1200: 850px;
                --container-width-1000: 850px;

                --font-title: "Oswald";
                --font-text: "Roboto";
            }
        </style>
        <!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/theme_<?php echo $GLOBALS['theme']; ?>.css" rel="stylesheet"> -->
        <link href="<?php echo get_bloginfo('template_url'); ?>/style.css" rel="stylesheet">
        <!-- <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,700,700i" rel="stylesheet"> -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&family=Roboto:wght@300;500&display=swap"
              rel="stylesheet">
        <?php wp_site_icon(); ?>

        <!-- <?php wp_enqueue_script("jquery"); ?> -->
        <?php wp_head(); ?>

    </head>


    <body>


        <div class="navbar navbar-inverse navbar-fixed-top">

            <div class="navbar-inner">

                <div class="header-container">

                    <div class="brand">
                        <a class="brand-link" href="<?php echo site_url(); ?>" title="Harmony of Shinesparkers">
                            <img class="logo" src="<?php echo get_bloginfo('template_url') ?>/img/harmony-logo.png"/>
                            <!-- <span class="logo-text">HARMONY</span> -->
                        </a>
                        <!-- <p class="logo-text">Neo FUSION</p> -->
                        <!-- <form id="search" method="get" action="<?php echo home_url(); ?>" role="search">
        <input type="text" class="input-search input-search-desktop" placeholder="Pesquisar" name="s" value="<?php echo $_GET['s']; ?>"/>
        <button type="submit" role="button" style="display:none;"/>
      </form> -->
                    </div>

                    <!-- Hamburger menu  -->
                    <div id="menuToggle">
                        <input type="checkbox"/>

                        <span></span>
                        <span></span>
                        <span></span>

                        <ul id="hmenu">
                            <a href="<?php echo site_url(); ?>/">
                                <li>ALBUMS</li>
                            </a>
                            <a href="<?php echo site_url(); ?>/role/musician">
                                <li>MUSICIANS</li>
                            </a>
                            <a href="<?php echo site_url(); ?>/role/artist">
                                <li>ARTISTS</li>
                            </a>
                            <a href="<?php echo site_url(); ?>/team">
                                <li>TEAM</li>
                            </a>
                            <!-- <a href="<?php echo site_url(); ?>/contact"><li>CONTACT</li></a> -->
                            <!-- <a href="<?php echo site_url(); ?>/category/ebook"><li>eBOOKS</li></a> -->
                            <!-- <li>
          <form id="search" method="get" action="<?php echo home_url(); ?>" role="search">
            <input type="text" class="input-search" placeholder="Pesquisar" name="s" value="<?php echo $_GET['s']; ?>"/>
            <button type="submit" role="button" style="display:none;"/>
          </form>
        </li> -->
                            <!-- <li>
                              <a href="https://facebook.com/shinesparkers" class="social-icon social-fb" target="_blank"></a>
                              <a href="https://instagram.com/shinesparkers" class="social-icon social-ig" target="_blank"></a>
                              <a href="https://twitter.com/Shinesparkers" class="social-icon social-tw" target="_blank"></a>
                            </li> -->
                        </ul>
                    </div>

                    <!-- <ul class="social nav">
                    </ul> -->

                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <!-- <li><a href="https://discordapp.com/invite/cbsTx69" class="social-icon social-discord" target="_blank"> -->
                            <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/discord-red.png"> -->
                            <!-- </a></li> -->
                            <!-- <li><a href="https://facebook.com/shinesparkers" class="social-icon social-fb" target="_blank">

                            </a></li>
                            <li><a href="https://instagram.com/shinesparkers" class="social-icon social-ig" target="_blank">
                            </a></li>
                            <li><a href="https://twitter.com/Shinesparkers" class="social-icon social-tw" target="_blank">
                            </a></li> -->
                            <!-- <li><a href="https://www.youtube.com/channel/UCU74wc5ncqwjjoXhdw53DSA" class="social-icon social-yt" target="_blank"> -->
                            <!-- </a></li> -->
                            <!-- <li><a href="https://twitch.tv/ninfusionbr" class="social-icon social-twitch" target="_blank">
                            </a></li> -->

                            <!-- <li class="active"><a href="#">Home</a></li> -->
                            <li><a class="navbar-link" href="<?php echo site_url(); ?>/">ALBUMS</a></li>
                            <li><a class="navbar-link" href="<?php echo site_url(); ?>/role/musician">MUSICIANS</a></li>
                            <li><a class="navbar-link" href="<?php echo site_url(); ?>/role/artist">ARTISTS</a></li>
                            <li><a class="navbar-link" href="<?php echo site_url(); ?>/team">TEAM</a></li>
                            <!-- <li><a class="navbar-link" href="<?php echo site_url(); ?>/contact">CONTACT</a></li> -->
                            <!-- <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/ebook">eBOOKS</a></li> -->
                            <!-- <?php wp_list_pages(array('title_li' => '', 'exclude' => 4)); ?> -->

                        </ul>
                        <!--  -->
                    </div><!--/.nav-collapse -->


                </div>
            </div>

        </div>


        <!-- <div class="container"> -->
