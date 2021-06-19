
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,
minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- <meta name="HandheldFriendly" content="true"> -->

    <!-- Le styles -->
    <style>
    :root {
    <?php
    if ($GLOBALS['theme'] == 'light') {
      ?>
          --dark-background: #f1e8e8;
          --white: #000000;
          --light-text: #0c0c0c;
          --neon-red: #df2327;
          --neon-blue: #40c7ff;
      <?php
    } else {
      ?>
          --dark-background: #070f20;
          --white: #ffffff;
          --light-text: #dbecf0;
          --neon-red: #fe494d;
          --neon-blue: #3ffdfe;
      <?php
    }
    ?>
        --container-width-1600: 1570px;
        --container-width-1200: 1170px;
        --container-width-1000: 1000px;

        --font-title: "Glacial Indifference";
        --font-text: "Ubuntu";
    }
    </style>
    <!-- <link href="<?php echo get_bloginfo('template_url'); ?>/css/theme_<?php echo $GLOBALS['theme']; ?>.css" rel="stylesheet"> -->
    <link href="<?php echo get_bloginfo('template_url'); ?>/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,700,700i" rel="stylesheet">
    <!-- <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon-32x32.png" sizes="32x32" /> -->
    <!-- <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon-16x16.png" sizes="16x16" /> -->

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?php echo get_bloginfo('template_url') ?>/img/favicon/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="Neo Fusion"/>
    <meta name="msapplication-TileColor" content="#070f20" />
    <meta name="msapplication-TileImage" content="<?php echo get_bloginfo('template_url') ?>/img/favicon/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="<?php echo get_bloginfo('template_url') ?>/img/favicon/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="<?php echo get_bloginfo('template_url') ?>/img/favicon/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="<?php echo get_bloginfo('template_url') ?>/img/favicon/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="<?php echo get_bloginfo('template_url') ?>/img/favicon/mstile-310x310.png" />

    <!-- <link rel="shortcut icon" href="<?php echo get_bloginfo('template_url') ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo get_bloginfo('template_url') ?>/img/favicon.ico" type="image/x-icon"> -->

    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet"> -->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48758010-3', 'auto');
      ga('send', 'pageview');
    </script>

    <!-- Google AdSense -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-8943805401802569",
        enable_page_level_ads: true
      });
    </script>

    <!-- <?php wp_enqueue_script("jquery"); ?> -->
    <?php wp_head(); ?>

  </head>
  <body>

  <div class="navbar navbar-inverse navbar-fixed-top">

    <div class="navbar-inner">

      <div class="header-container">

        <div class="brand">
          <a class="brand-link" href="<?php echo site_url(); ?>">
            <img class="logo" src="<?php echo get_bloginfo('template_url') ?>/img/logo-neon-<?php echo $GLOBALS['theme']; ?>.png" />
            <span class="logo-text">NEO FUSION</span>
          </a>
          <!-- <p class="logo-text">Neo FUSION</p> -->
          <form id="search" method="get" action="<?php echo home_url(); ?>" role="search">
            <input type="text" class="input-search input-search-desktop" placeholder="Pesquisar" name="s" value="<?php echo $_GET['s']; ?>"/>
            <button type="submit" role="button" style="display:none;"/>
          </form>
        </div>

        <!-- Hamburger menu  -->
        <div id="menuToggle">
          <input type="checkbox" />

          <span></span>
          <span></span>
          <span></span>

          <ul id="hmenu">
            <a href="<?php echo site_url(); ?>/category/curtas"><li>CURTAS</li></a>
            <a href="<?php echo site_url(); ?>/category/materia"><li>MATÉRIAS</li></a>
            <a href="<?php echo site_url(); ?>/video"><li>VÍDEOS</li></a>
            <a href="<?php echo site_url(); ?>/podcast"><li>PODCASTS</li></a>
            <!-- <a href="<?php echo site_url(); ?>/category/ebook"><li>eBOOKS</li></a> -->
            <li>
              <form id="search" method="get" action="<?php echo home_url(); ?>" role="search">
                <input type="text" class="input-search" placeholder="Pesquisar" name="s" value="<?php echo $_GET['s']; ?>"/>
                <button type="submit" role="button" style="display:none;"/>
              </form>
            </li>
            <li>
              <!-- <a href="https://discordapp.com/invite/cbsTx69" class="social-icon social-discord" target="_blank"></a> -->
              <!-- <a href="https://facebook.com/nintendofusion" class="social-icon social-fb" target="_blank"></a> -->
              <a href="https://instagram.com/neofusionbr" class="social-icon social-ig" target="_blank"></a>
              <a href="https://twitter.com/NeoFusionBR" class="social-icon social-tw" target="_blank"></a>
              <a href="https://www.youtube.com/channel/UCU74wc5ncqwjjoXhdw53DSA" class="social-icon social-yt" target="_blank"></a>
              <a href="https://twitch.tv/ninfusionbr" class="social-icon social-twitch" target="_blank"></a>
            </li>
          </ul>
        </div>

        <!-- <ul class="social nav">
        </ul> -->

        <div class="nav-collapse collapse">
          <ul class="nav">
              <!-- <li><a href="https://discordapp.com/invite/cbsTx69" class="social-icon social-discord" target="_blank"> -->
                <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/discord-red.png"> -->
              <!-- </a></li> -->
              <!-- <li><a href="https://facebook.com/nintendofusion" class="social-icon social-fb" target="_blank"> -->
                <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/facebook-red.png"> -->
              <!-- </a></li> -->
              <li><a href="https://instagram.com/neofusionbr" class="social-icon social-ig" target="_blank">
              </a></li>
              <li><a href="https://twitter.com/NeoFusionBR" class="social-icon social-tw" target="_blank">
                <!-- <img  src="<?php echo get_bloginfo('template_url') ?>/img/icons/twitter-red.png"> -->
              </a></li>
              <li><a href="https://www.youtube.com/channel/UCU74wc5ncqwjjoXhdw53DSA" class="social-icon social-yt" target="_blank">
                <!-- <img class="social-icon" src="<?php echo get_bloginfo('template_url') ?>/img/icons/youtube-red.png"> -->
              </a></li>
              <li><a href="https://twitch.tv/ninfusionbr" class="social-icon social-twitch" target="_blank">
              </a></li>

              <!-- <li class="active"><a href="#">Home</a></li> -->
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/curtas">CURTAS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/materia">MATÉRIAS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/video">VÍDEOS</a></li>
              <li><a class="navbar-link" href="<?php echo site_url(); ?>/podcast">PODCAST</a></li>
              <!-- <li><a class="navbar-link" href="<?php echo site_url(); ?>/category/ebook">eBOOKS</a></li> -->
              <!-- <?php wp_list_pages(array('title_li' => '', 'exclude' => 4)); ?> -->

          </ul>
          <!--  -->
        </div><!--/.nav-collapse -->

        <!-- Fusion Header Ad -->
        <!-- <div class="ad-header">
          <ins class="adsbygoogle"
               style="display:inline-block;width:728px;height:90px"
               data-ad-client="ca-pub-8943805401802569"
               data-ad-slot="5347274925"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div> -->
      </div>
    </div>
  </div>

  <!-- Mobile header ad -->
  <!-- <div class="ad-mobile">
    <ins class="adsbygoogle"
         style="display:inline-block;width:320px;height:100px"
         data-ad-client="ca-pub-8943805401802569"
         data-ad-slot="6638694344"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div> -->



  <div class="container">
