<?php get_header(); ?>
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$custom       = get_post_custom( $post->ID );
		$address      = $custom['address'][0];
		$address_two  = $custom['address_two'][0];
		$city         = $custom['city'][0];
		$state        = $custom['state'][0];
		$zip          = $custom['zip'][0];
		$website      = $custom['website'][0];
		$phone        = $custom['phone'][0];
		$email        = $custom['email'][0];
		$bigImage     = get_the_post_thumbnail( $post->ID, 'storefront' );
		if ( $website != '' && $website != 'http://' ) {
			$website = "<a href=\"$website\">$website</a>";
		} else {
			$website = '';
		}
		if ( $email != '' ) {
			$email = "<a href=\"mailto:$email\">$email</a>";
		}
		if ( $website == '' || $email == '' ) {
			$separator = '';
		} else {
			$separator = '<br/>';
		}
		$address .= '<br/>';
		if ( $address_two != '' ) {
			$address .= $address_two . '<br/>';
		}
		$address .= $city . ', ' . $state . ' ' . $zip;
		?>
	<div id="business-listing" class="group">
		<div class="info right-col">
			<h3>Contact Details:</h3>
			<h4><?php the_title(); ?></h4>
			<?php
			if ( $separator != '' ) {
				print "<p>$website $separator $email</p>";}
			?>
			<?php
			if ( $phone != '' ) {
				print "<p>$phone</p>";}
			?>
			<?php
			if ( $address != '' ) {
				print "<address>$address </address>";}
			?>
		</div>
		<div class="info left-col">
			<div class="impact-image">
				<?php print $bigImage; ?>
			</div>
			<?php the_content(); ?>
		</div>
	</div>
	<div class="navi">
		<div class="right">
			<?php previous_post_link(); ?> / <?php next_post_link(); ?>
		</div>
	</div>
	<?php endwhile; else : ?>
	<p><?php _e( 'No posts were found. Sorry!' ); ?></p>
	<?php endif; ?>
<?php get_footer(); ?>
