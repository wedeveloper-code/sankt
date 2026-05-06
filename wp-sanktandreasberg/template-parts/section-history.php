<?php
$history_url = home_url( '/geschichte/' );
?>
<section id="history" class="section cream">
	<div class="wrap history">
		<div class="history-inner">
			<div>
				<h2><?php esc_html_e( 'Unsere Bergstadt mit Geschichte', 'wp-sanktandreasberg' ); ?></h2>
				<p><?php esc_html_e( 'Seit dem 15. Jahrhundert geprägt vom Bergbau. Besuchen Sie die Erlebniswelt Grube Samson und tauchen Sie ein in die faszinierende Geschichte des Erzbergbaus im Harz.', 'wp-sanktandreasberg' ); ?></p>
				<a class="btn btn-gold" href="<?php echo esc_url( $history_url ); ?>"><?php esc_html_e( 'Mehr zur Geschichte', 'wp-sanktandreasberg' ); ?> ›</a>
			</div>
			<div class="timeline">
				<div class="time"><b>1487</b><span><?php esc_html_e( 'Erste urkundliche Erwähnung', 'wp-sanktandreasberg' ); ?></span></div>
				<div class="time"><b>1527</b><span><?php esc_html_e( 'Beginn des Erzbergbaus', 'wp-sanktandreasberg' ); ?></span></div>
				<div class="time"><b>1910</b><span><?php esc_html_e( 'Ende des aktiven Bergbaus', 'wp-sanktandreasberg' ); ?></span></div>
				<div class="time"><b>1992</b><span><?php esc_html_e( 'Besucherbergwerk', 'wp-sanktandreasberg' ); ?></span></div>
			</div>
		</div>
	</div>
</section>
