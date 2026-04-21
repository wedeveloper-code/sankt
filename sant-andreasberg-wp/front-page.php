<?php get_header(); ?>

<main id="main" role="main">

  <!-- HERO -->
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <?php
        $h1 = sa_get_custom_meta('h1');
        echo '<h1>' . esc_html($h1 ?: __('Willkommen in Sankt Andreasberg', 'sant-andreasberg')) . '</h1>';
        ?>
        <p class="lead">
          <?php esc_html_e('Die Nationalpark-Gemeinde im Oberharz – Wintersport, Wandern, Geschichte und Natur.', 'sant-andreasberg'); ?>
        </p>
        <div class="hero-badges">
          <span class="badge">&#127952; <?php esc_html_e('Nationalpark Harz', 'sant-andreasberg'); ?></span>
          <span class="badge">&#127968; <?php esc_html_e('Bergstadt seit 1487', 'sant-andreasberg'); ?></span>
          <span class="badge">&#9981; <?php esc_html_e('UNESCO-Welterbe', 'sant-andreasberg'); ?></span>
          <span class="badge">&#127976; <?php esc_html_e('Luftkurort', 'sant-andreasberg'); ?></span>
        </div>
        <div class="flex" style="justify-content:center;gap:1rem;flex-wrap:wrap">
          <a href="<?php echo esc_url(home_url('/winter/')); ?>" class="btn btn-primary">
            &#9924; <?php esc_html_e('Winter entdecken', 'sant-andreasberg'); ?>
          </a>
          <a href="<?php echo esc_url(home_url('/summer/')); ?>" class="btn btn-outline">
            &#127795; <?php esc_html_e('Sommer erleben', 'sant-andreasberg'); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <section class="section section--light">
    <div class="container">
      <div class="stats-row">
        <div class="stat-item">
          <div class="stat-number">870 m</div>
          <div class="stat-label"><?php esc_html_e('Höhenlage', 'sant-andreasberg'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">200 km</div>
          <div class="stat-label"><?php esc_html_e('Wanderwege', 'sant-andreasberg'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">40 km</div>
          <div class="stat-label"><?php esc_html_e('Loipen im Winter', 'sant-andreasberg'); ?></div>
        </div>
        <div class="stat-item">
          <div class="stat-number">500+</div>
          <div class="stat-label"><?php esc_html_e('Jahre Bergbaugeschichte', 'sant-andreasberg'); ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- SEASON TABS -->
  <section class="section">
    <div class="container">
      <h2 class="text-center" style="margin-bottom:2rem">
        <?php esc_html_e('Aktivitäten das ganze Jahr', 'sant-andreasberg'); ?>
      </h2>
      <div class="season-tabs" role="tablist">
        <button class="season-tab" role="tab" data-target="tab-winter" aria-selected="true">
          &#9924; <?php esc_html_e('Winter', 'sant-andreasberg'); ?>
        </button>
        <button class="season-tab" role="tab" data-target="tab-sommer">
          &#127795; <?php esc_html_e('Sommer', 'sant-andreasberg'); ?>
        </button>
        <button class="season-tab" role="tab" data-target="tab-ganzjahr">
          &#9889; <?php esc_html_e('Ganzjährig', 'sant-andreasberg'); ?>
        </button>
      </div>

      <div id="tab-winter" class="season-panel">
        <div class="feature-grid">
          <?php sa_feature_card('&#9979;', __('Skifahren & Snowboard', 'sant-andreasberg'), __('Matthias-Schmidt-Berg und Sonnenberg bieten moderne Pisten mit Beschneiung.', 'sant-andreasberg'), home_url('/winter/ski-slopes/')); ?>
          <?php sa_feature_card('&#127938;', __('Langlauf / Loipen', 'sant-andreasberg'), __('Rund 40 km gespurte Loipen rund um die Bergstadt, teils mit separater Skatingspur.', 'sant-andreasberg'), home_url('/winter/ski-trails/')); ?>
          <?php sa_feature_card('&#128752;', __('Rodeln & Snowtubing', 'sant-andreasberg'), __('Rodelhänge im Teichtal und auf dem Sonnenberg – Spaß für die ganze Familie.', 'sant-andreasberg'), home_url('/winter/sledding/')); ?>
          <?php sa_feature_card('&#129494;', __('Winterwandern', 'sant-andreasberg'), __('Schneeschuhtouren und Winterwanderwege durch den verschneiten Nationalpark.', 'sant-andreasberg'), home_url('/winter/winter-hiking/')); ?>
        </div>
      </div>

      <div id="tab-sommer" class="season-panel">
        <div class="feature-grid">
          <?php sa_feature_card('&#127968;', __('Wandern', 'sant-andreasberg'), __('Über 200 km Wanderwege – von der leichten Runde bis zur anspruchsvollen Tagestour.', 'sant-andreasberg'), home_url('/summer/hiking/')); ?>
          <?php sa_feature_card('&#128690;', __('Mountainbiking', 'sant-andreasberg'), __('Herausfordernde MTB-Touren mit GPS-Daten zum Download für alle Schwierigkeitsstufen.', 'sant-andreasberg'), home_url('/summer/mountain-biking/')); ?>
          <?php sa_feature_card('&#127939;', __('Nordic Walking', 'sant-andreasberg'), __('Ausgeschilderte Walking-Routen: Blaue, Rote und Schwarze Route rund um die Bergstadt.', 'sant-andreasberg'), home_url('/summer/nordic-walking/')); ?>
          <?php sa_feature_card('&#129327;', __('Abenteuer & Action', 'sant-andreasberg'), __('Hochseilgarten, Felsklettern, Kanutour – Abenteuer im Harz für Groß und Klein.', 'sant-andreasberg'), home_url('/summer/adventure/')); ?>
        </div>
      </div>

      <div id="tab-ganzjahr" class="season-panel">
        <div class="feature-grid">
          <?php sa_feature_card('&#9968;', __('Grube Samson', 'sant-andreasberg'), __('UNESCO-Welterbe: 500 Jahre Bergbaugeschichte hautnah erleben.', 'sant-andreasberg'), home_url('/about-sankt-andreasberg/history/')); ?>
          <?php sa_feature_card('&#127963;', __('Nationalpark Harz', 'sant-andreasberg'), __('Mitten im größten Mittelgebirge Norddeutschlands – Natur pur.', 'sant-andreasberg'), home_url('/about-sankt-andreasberg/')); ?>
          <?php sa_feature_card('&#127758;', __('Sehenswürdigkeiten', 'sant-andreasberg'), __('Viel zu entdecken in der Region: von Goslar bis Wernigerode.', 'sant-andreasberg'), home_url('/sights/')); ?>
          <?php sa_feature_card('&#127966;', __('Luftkurort', 'sant-andreasberg'), __('Heilsame Luft und therapeutisches Klima – ideal für Erholung und Gesundheit.', 'sant-andreasberg'), home_url('/about-sankt-andreasberg/')); ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT TEASER -->
  <section class="section section--light">
    <div class="container">
      <div class="grid grid-2" style="align-items:center;gap:3rem">
        <div>
          <h2><?php esc_html_e('Die Bergstadt im Oberharz', 'sant-andreasberg'); ?></h2>
          <p class="lead">
            <?php esc_html_e('Sankt Andreasberg liegt zwischen 400 und 870 m über dem Meeresspiegel, mitten im Nationalpark Harz. Das Stadtzentrum befindet sich auf einem sonnigen Hochplateau mit weiter Sicht über den Südharz.', 'sant-andreasberg'); ?>
          </p>
          <p>
            <?php esc_html_e('Seit November 2011 gehört die Stadt zu Braunlage (Landkreis Goslar). Die erste urkundliche Erwähnung stammt aus dem Jahr 1487. Über vier Jahrhunderte war der Bergbau die wichtigste Lebensgrundlage der Bevölkerung.', 'sant-andreasberg'); ?>
          </p>
          <a href="<?php echo esc_url(home_url('/about-sankt-andreasberg/')); ?>" class="btn btn-secondary" style="margin-top:1rem">
            <?php esc_html_e('Mehr über Sankt Andreasberg', 'sant-andreasberg'); ?>
          </a>
        </div>
        <div>
          <div class="feature-grid" style="grid-template-columns:1fr 1fr">
            <?php sa_fact('1487', __('Erste urkundliche Erwähnung', 'sant-andreasberg')); ?>
            <?php sa_fact('2010', __('UNESCO-Welterbe Grube Samson', 'sant-andreasberg')); ?>
            <?php sa_fact('90%', __('Strom aus Wasserkraft', 'sant-andreasberg')); ?>
            <?php sa_fact('&#127866;', __('Luftkurort & Nationalparkgemeinde', 'sant-andreasberg')); ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- LATEST NEWS -->
  <?php
  $latest = new WP_Query(['posts_per_page' => 3, 'ignore_sticky_posts' => true]);
  if ($latest->have_posts()): ?>
  <section class="section">
    <div class="container">
      <div class="flex justify-between" style="margin-bottom:2rem;flex-wrap:wrap;gap:1rem">
        <h2><?php esc_html_e('Aktuelles', 'sant-andreasberg'); ?></h2>
        <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn btn-primary">
          <?php esc_html_e('Alle Neuigkeiten', 'sant-andreasberg'); ?>
        </a>
      </div>
      <div class="posts-grid">
        <?php while ($latest->have_posts()): $latest->the_post(); ?>
          <?php get_template_part('templates/card', 'post'); ?>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>

<?php
function sa_feature_card(string $icon, string $title, string $text, string $url): void { ?>
  <div class="feature-item">
    <div class="feature-icon" aria-hidden="true" style="font-size:1.75rem;background:none"><?php echo esc_html($icon); ?></div>
    <h3><?php echo esc_html($title); ?></h3>
    <p style="font-size:.9rem;color:var(--color-text-light)"><?php echo esc_html($text); ?></p>
    <a href="<?php echo esc_url($url); ?>" class="card-link"><?php esc_html_e('Mehr erfahren', 'sant-andreasberg'); ?></a>
  </div>
<?php }

function sa_fact(string $value, string $label): void { ?>
  <div class="feature-item" style="padding:1rem">
    <div class="stat-number" style="font-size:1.75rem"><?php echo esc_html($value); ?></div>
    <div class="stat-label"><?php echo esc_html($label); ?></div>
  </div>
<?php }
?>
