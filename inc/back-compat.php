<?php
/**
 * Back compat functionality
 *
 * Prevents the theme from running on WordPress versions prior to 5.3,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 5.3.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

/**
 * Prevent switching to the theme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since 1.0.0
 */
function twenty_twenty_one_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] ); // phpcs:ignore WordPress.Security.NonceVerification
	add_action( 'admin_notices', 'twenty_twenty_one_upgrade_notice' );
}
add_action( 'after_switch_theme', 'twenty_twenty_one_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * the theme on WordPress versions prior to 5.3.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function twenty_twenty_one_upgrade_notice() {
	echo '<div class="error"><p>';
	printf(
		/* Translators: %s: WordPress Version. */
		esc_html__( 'This theme requires at least WordPress version 5.3. You are running version %s. Please upgrade and try again.', 'twentytwentyone' ),
		esc_html( $GLOBALS['wp_version'] )
	);
	echo '</p></div>';
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 5.3.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function twenty_twenty_one_customize() {
	wp_die(
		sprintf(
			/* Translators: %s: WordPress Version. */
			esc_html__( 'This theme requires at least WordPress version 5.3. You are running version %s. Please upgrade and try again.', 'twentytwentyone' ),
			esc_html( $GLOBALS['wp_version'] )
		),
		'',
		array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'twenty_twenty_one_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 5.3.
 *
 * @since 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function twenty_twenty_one_preview() {
	if ( isset( $_GET['preview'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		wp_die(
			sprintf(
				/* Translators: %s: WordPress Version. */
				esc_html__( 'This theme requires at least WordPress version 5.3. You are running version %s. Please upgrade and try again.', 'twentytwentyone' ),
				esc_html( $GLOBALS['wp_version'] )
			)
		);
	}
}
add_action( 'template_redirect', 'twenty_twenty_one_preview' );
