			</div>
			<!-- End Main Area -->
		</div><!--end container-->
	</div><!--end wrap-->
	<!-- Footer Information -->
	<footer class="group">
		<?php
		// social links
		$facebook = get_option( 'director_facebook' );
		$twitter  = get_option( 'director_twitter' );
		$rss      = get_option( 'director_rss' ); ?>
		<ul class="social">
			<?php
			if ( $facebook ) :
				?>
			<li><a href="<?php print $facebook; ?>"><img src="<?php echo IMAGES; ?>/facebook.png" /></li><?php endif; ?>
			<?php
			if ( $twitter ) :
				?>
			<li><a href="<?php print $twitter; ?>"><img src="<?php echo IMAGES; ?>/twitter.png" /></li><?php endif; ?>
			<?php
			if ( $rss ) :
			?>
			<li><a href="<?= site_url('/feed')  ?>"><img src="<?php echo IMAGES; ?>/feed.png" /></a></li><?php endif; ?>
		</ul>
		<p>&copy; <?php bloginfo( 'name' ); ?>, <?php echo date( 'Y' ); ?>. All Rights Reserved</p>
	</footer>
	<!-- End Footer Information -->
	<?php wp_footer(); ?>
	<?php print get_option( 'director_analytics' ); ?>
</body>
</html>
