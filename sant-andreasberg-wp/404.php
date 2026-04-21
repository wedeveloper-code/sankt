<?php get_header(); ?>

<main id="main" role="main">
  <div class="container">
    <div class="error-page">
      <div class="error-code" aria-hidden="true">404</div>
      <h1><?php esc_html_e('Seite nicht gefunden', 'sant-andreasberg'); ?></h1>
      <p class="lead" style="max-width:520px;margin:0 auto 2rem">
        <?php esc_html_e('Diese Seite existiert nicht oder wurde verschoben. Benutzen Sie bitte die Suche oder kehren Sie zur Startseite zurück.', 'sant-andreasberg'); ?>
      </p>
      <?php get_search_form(); ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary" style="margin-top:2rem">
        <?php esc_html_e('Zur Startseite', 'sant-andreasberg'); ?>
      </a>
    </div>
  </div>
</main>

<?php get_footer(); ?>
