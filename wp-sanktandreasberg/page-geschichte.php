<?php
/*
 * Template Name: Geschichte
 */
get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Geschichte', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: 'https://images.unsplash.com/photo-1534870330274-5f7a3485702b?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Bergstadt', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Geschichte', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Über 500 Jahre Bergbau, Glaube und Bergstädtisches Leben im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article class="card place-main">

				<div class="history" style="margin-bottom:24px">
					<div class="history-inner">
						<div>
							<h2><?php esc_html_e( 'Eine Stadt mit tiefen Wurzeln', 'wp-sanktandreasberg' ); ?></h2>
							<p><?php esc_html_e( 'Seit dem 15. Jahrhundert geprägt vom Bergbau. Die Grube Samson und das historische Stadtbild erzählen von einer bewegten Vergangenheit.', 'wp-sanktandreasberg' ); ?></p>
						</div>
						<div class="timeline">
							<div class="time"><b>1487</b><span><?php esc_html_e( 'Erste urkundliche Erwähnung als „sanct andrews berges"', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1521</b><span><?php esc_html_e( 'Erste Bergfreiheit — Grube Samson wird in Betrieb genommen', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1527</b><span><?php esc_html_e( 'Zweite Bergfreiheit — Bergleute aus dem Erzgebirge siedeln sich an', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1537</b><span><?php esc_html_e( '300 Häuser, ca. 2.000 Einwohner, hohe Ausbeute', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1579</b><span><?php esc_html_e( '480 Bergleute, ca. 2.500 Einwohner — Hochblüte des Bergbaus', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>um 1600</b><span><?php esc_html_e( 'Bau des Rehberger Grabens — liefert noch heute Strom aus Wasserkraft', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1908</b><span><?php esc_html_e( 'Grube Samson erhält neue Förderanlage', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1910</b><span><?php esc_html_e( 'Einstellung des aktiven Bergbaus in Sankt Andreasberg', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1992</b><span><?php esc_html_e( 'Grube Samson öffnet als Besucherbergwerk', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>2010</b><span><?php esc_html_e( 'Grube Samson wird UNESCO-Weltkulturerbe', 'wp-sanktandreasberg' ); ?></span></div>
						</div>
					</div>
				</div>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php if ( get_the_content() ) : ?>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
					<?php else : ?>
					<div class="article-body">
						<h2><?php esc_html_e( 'Die Geschichte der Bergstadt', 'wp-sanktandreasberg' ); ?></h2>
						<p><?php esc_html_e( 'Die Geschichte der Bergstadt Sankt Andreasberg ist eng mit der Bergbaugeschichte des Ortes verknüpft. Über vier Jahrhunderte lebte die Bevölkerung fast ausschließlich vom Bergbau. Weil der Rehberger Graben seit mehr als 300 Jahren das Oder-Wasser in die Bergstadt führt, kann die Stadt heute zu ca. 90 % mit Strom aus Wasserkraft versorgt werden – zumindest lokal ist die Energiewende schon geschafft.', 'wp-sanktandreasberg' ); ?></p>

						<h3><?php esc_html_e( 'Gründung und Bergbau-Blütezeit (1487–1580)', 'wp-sanktandreasberg' ); ?></h3>
						<p><?php esc_html_e( '1487 wird „sanct andrews berges" erstmals urkundlich erwähnt. Zwei Gewerke (Bergbaubetriebe) streiten über Grubenfelder – eine feste Ansiedlung von Bergleuten ist noch unwahrscheinlich. 1521 rufen die Hohnsteiner Grafen die erste Bergfreiheit aus und die Grube Samson wird in Betrieb genommen. Die zweite erweiterte Bergfreiheit von 1527 zeigt schnell Wirkung: Bergleute aus dem Erzgebirge siedeln sich in Sankt Andreasberg an.', 'wp-sanktandreasberg' ); ?></p>
						<p><?php esc_html_e( '1528 beginnt der Aufbau der Bergstadt: 116 Gruben sind in Betrieb. 1537 stehen 300 Wohnhäuser, ca. 2.000 Einwohner leben hier, Richter und Rat nehmen ihre Arbeit auf. In den Jahren 1566 bis 1572 gibt es sehr hohe Ausbeute. 1579 zählt man 480 Bergleute und ca. 2.500 Einwohner – die Hochblüte der Bergstadt.', 'wp-sanktandreasberg' ); ?></p>

						<h3><?php esc_html_e( 'Krisen und Wiederaufbau (1580–1700)', 'wp-sanktandreasberg' ); ?></h3>
						<p><?php esc_html_e( 'Um 1590 wird der Sonnenberger Graben gebaut. 1577 und 1625 wütet die Pest in der Bergstadt und reduziert die Einwohnerzahl. Der Dreißigjährige Krieg (1618–1648) lähmt den gesamten Harzer Bergbau. 1653 wird der Ackerbau verboten, um mehr Bergleute zur Verfügung zu haben. 1672 wird das Direktorialprinzip eingeführt: Das Bergamt übernimmt die Betriebsführung.', 'wp-sanktandreasberg' ); ?></p>

						<h3><?php esc_html_e( 'Das Wasserkraft-Erbe: Rehberger Graben', 'wp-sanktandreasberg' ); ?></h3>
						<p><?php esc_html_e( 'Um 1600 wurde der Alte Rehberger Graben gebaut. Er führt seit mehr als 300 Jahren das Oderwasser in die Bergstadt und ermöglicht heute die weitgehende Stromversorgung aus Wasserkraft. Dieser Graben ist Teil des Oberharzer Wasserwirtschaftssystems – heute UNESCO-Welterbe.', 'wp-sanktandreasberg' ); ?></p>

						<h3><?php esc_html_e( 'Von der Bergstadt zum Luftkurort (1800–2011)', 'wp-sanktandreasberg' ); ?></h3>
						<p><?php esc_html_e( 'Mit dem schrittweisen Niedergang des Bergbaus im 19. und frühen 20. Jahrhundert wandelt sich Sankt Andreasberg. 1910 wird der aktive Bergbau endgültig eingestellt. Die Grube Samson, das bedeutendste Bergwerk, öffnet 1992 als Besucherbergwerk. Seit November 2011 gehört Sankt Andreasberg zur Stadt Braunlage (Landkreis Goslar). Das Stadtgebiet erstreckt sich zwischen 400 und 870 m über dem Meeresspiegel, mitten im Nationalpark Harz.', 'wp-sanktandreasberg' ); ?></p>

						<h3><?php esc_html_e( 'UNESCO-Welterbe 2010', 'wp-sanktandreasberg' ); ?></h3>
						<p><?php esc_html_e( 'Im Jahr 2010 wurde die Grube Samson als Teil des Oberharzer Wasserwirtschaftssystems in die UNESCO-Welterbeliste aufgenommen. Das einzigartige Wasserkunstwerk aus dem 19. Jahrhundert zählt zu den bedeutendsten Bergbaudenkmälern Europas. Als Besucherbergwerk bietet die Grube Samson heute einzigartige Einblicke in die Bergbaugeschichte.', 'wp-sanktandreasberg' ); ?></p>
					</div>
					<?php endif; ?>
				<?php endwhile; endif; ?>

				<div class="tile-grid" style="margin-top:24px">
					<article class="card tile">
						<div class="photo mine"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Grube Samson', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Das bedeutendste Bergbau-Denkmal im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="photo forest"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Bergbau-Erbe', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Oberharz als UNESCO-Weltkulturerbe.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Zum UNESCO-Erbe', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="photo town"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Stadtgeschichte', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Die Entwicklung der Bergstadt vom Mittelalter bis heute.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Stadtgeschichte', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
				</div>
			</article>

			<?php get_sidebar(); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
