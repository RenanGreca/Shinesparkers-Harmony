
    </div> <!-- /container -->

      <footer>

        <?php
        if ($GLOBALS['theme'] == 'light') {
          $theme_url = 'https://'.$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?').'?theme=dark';
          $theme = 'escuro';
        } else {
          $theme_url = 'https://'.$_SERVER['HTTP_HOST'].strtok($_SERVER["REQUEST_URI"],'?').'?theme=light';
          $theme = 'claro';
        }
        ?>

        <div class="footer-line">
        </div>
        <!-- <img class="logo" src="<?php echo get_bloginfo('template_url') ?>/img/logo.png" /> -->
        <div class="links">
          <a href="<?php echo site_url(); ?>/sobre">Sobre</a>
          <a href="<?php echo site_url(); ?>/equipe">Equipe</a>
          <a href="<?php echo site_url(); ?>/politicas">Políticas</a>
          <a href="<?php echo site_url(); ?>/contato">Contato</a>
          <!-- <a href="#Mídia">Mídia</a> -->
          <a href="<?php echo $theme_url; ?>">Ativar tema <?php echo $theme; ?></a>
        </div>

        <div class="copyright">
            <div class="year">© <?php echo date('Y'); ?> Neo Fusion</div>
        </div>

      </footer>



    <?php wp_footer(); ?>

  </body>
</html>
