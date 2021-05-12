
    <!-- </div> <!-- /container -->

      <footer>
        <div class="copyright">
          <div class="year">
            © <?php echo date('Y'); ?>
            <a href="https://shinesparkers.net/">
              Shinesparkers
            </a>
          </div>
        </div>
      </footer>

      <!-- <footer>

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
        <div class="links">
          <a href="<?php echo site_url(); ?>/sobre">Sobre</a>
          <a href="<?php echo site_url(); ?>/equipe">Equipe</a>
          <a href="<?php echo site_url(); ?>/politicas">Políticas</a>
          <a href="<?php echo site_url(); ?>/contato">Contato</a>
          <a href="<?php echo $theme_url; ?>">Ativar tema <?php echo $theme; ?></a>
        </div>

        <div class="copyright">
            <div class="year">© <?php echo date('Y'); ?> Neo Fusion</div>
        </div>

      </footer> -->



    <?php wp_footer(); ?>

  </body>
</html>
