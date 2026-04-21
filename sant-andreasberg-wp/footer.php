<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid">

      <div class="footer-col">
        <span class="footer-logo"><?php bloginfo('name'); ?></span>
        <p class="footer-desc">
          <?php esc_html_e('Die Nationalpark-Gemeinde im Oberharz – Urlaub, Natur und Geschichte.', 'sant-andreasberg'); ?>
        </p>
      </div>

      <div class="footer-col">
        <?php if (is_active_sidebar('footer-1')) {
            dynamic_sidebar('footer-1');
        } else { ?>
          <h4><?php esc_html_e('Navigation', 'sant-andreasberg'); ?></h4>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Startseite', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about-sankt-andreasberg/')); ?>"><?php esc_html_e('Über Sankt Andreasberg', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo sa_get_cat_url('winter'); ?>"><?php esc_html_e('Winter', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo sa_get_cat_url('sommer'); ?>"><?php esc_html_e('Sommer', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/sights/')); ?>"><?php esc_html_e('Sehenswürdigkeiten', 'sant-andreasberg'); ?></a></li>
          </ul>
        <?php } ?>
      </div>

      <div class="footer-col">
        <?php if (is_active_sidebar('footer-2')) {
            dynamic_sidebar('footer-2');
        } else { ?>
          <h4><?php esc_html_e('Rechtliches', 'sant-andreasberg'); ?></h4>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url(home_url('/impressum/')); ?>"><?php esc_html_e('Impressum', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Datenschutz', 'sant-andreasberg'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Kontakt', 'sant-andreasberg'); ?></a></li>
          </ul>
        <?php } ?>
      </div>

    </div>

    <div class="footer-bottom">
      <span>
        &copy; <?php echo esc_html(date('Y')); ?>
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
      </span>
      <?php
      wp_nav_menu([
          'theme_location' => 'footer',
          'container'      => false,
          'menu_class'     => 'footer-bottom-links',
          'fallback_cb'    => false,
          'depth'          => 1,
      ]);
      ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
