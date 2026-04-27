<?php
/**
 * Salient NoCap child theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nocap_child_version' ) ) {
	function nocap_child_version() {
		$theme = wp_get_theme();
		return $theme->get( 'Version' ) ? $theme->get( 'Version' ) : '1.0.0';
	}
}

if ( ! function_exists( 'nocap_child_frontpage_class' ) ) {
	function nocap_child_frontpage_class( $classes ) {
		if ( is_front_page() ) {
			$classes[] = 'nocap-frontpage-refresh';
		}
		return $classes;
	}
}
add_filter( 'body_class', 'nocap_child_frontpage_class' );

if ( ! function_exists( 'nocap_child_enqueue_assets' ) ) {
	function nocap_child_enqueue_assets() {

		wp_enqueue_style(
			'nocap-child-fonts',
			'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap',
			array(),
			null
		);

		if ( ! is_front_page() ) {
			return;
		}

		// Front-page template prints Salient [fancy_box] shortcodes directly.
		if ( wp_style_is( 'nectar-element-fancy-box', 'registered' ) ) {
			wp_enqueue_style( 'nectar-element-fancy-box' );
		}

		$script_rel_path = '/assets/js/home-modern.js';
		$script_path     = get_stylesheet_directory() . $script_rel_path;
		$script_version  = file_exists( $script_path ) ? (string) filemtime( $script_path ) : nocap_child_version();

		wp_enqueue_script(
			'nocap-home-modern',
			get_stylesheet_directory_uri() . $script_rel_path,
			array(),
			$script_version,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'nocap_child_enqueue_assets', 120 );

if ( ! function_exists( 'nocap_child_skip_link' ) ) {
	function nocap_child_skip_link() {
		if ( ! is_front_page() ) {
			return;
		}

		echo '<a class="skip-link" href="#nocap-main">' . esc_html__( 'Skip to main content', 'salient-nocap-child' ) . '</a>';
	}
}
add_action( 'nectar_hook_after_body_open', 'nocap_child_skip_link', 2 );

if ( ! function_exists( 'nocap_child_has_primary_seo_plugin' ) ) {
	function nocap_child_has_primary_seo_plugin() {
		return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || defined( 'AIOSEO_VERSION' );
	}
}

if ( ! function_exists( 'nocap_child_frontpage_schema' ) ) {
	function nocap_child_frontpage_schema() {

		if ( ! is_front_page() || nocap_child_has_primary_seo_plugin() ) {
			return;
		}

		$site_url  = home_url( '/' );
		$host      = wp_parse_url( $site_url, PHP_URL_HOST );
		$email     = ( 'nocap-barbers.local' === $host ) ? 'office@nocap-barbers.local' : 'office@nocap-barbers.at';
		$logo_id   = get_theme_mod( 'custom_logo' );
		$logo_url  = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
		$same_as   = array(
			'https://www.facebook.com/NoCapBarbersVienna/',
			'https://www.instagram.com/nocap.barbers_mens_grooming/',
		);
		$schema    = array(
			'@context' => 'https://schema.org',
			'@type'    => 'Barbershop',
			'@id'      => trailingslashit( $site_url ) . '#barbershop',
			'name'     => get_bloginfo( 'name' ),
			'url'      => $site_url,
			'telephone'=> '+43 1 4374527',
			'email'    => $email,
			'priceRange' => '$$',
			'address'  => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Hoher Markt 3',
				'addressLocality' => 'Wien',
				'postalCode'      => '1010',
				'addressCountry'  => 'AT',
			),
			'openingHoursSpecification' => array(
				array(
					'@type'    => 'OpeningHoursSpecification',
					'dayOfWeek'=> array( 'Monday', 'Tuesday', 'Wednesday', 'Friday' ),
					'opens'    => '10:00',
					'closes'   => '19:00',
				),
				array(
					'@type'    => 'OpeningHoursSpecification',
					'dayOfWeek'=> 'Thursday',
					'opens'    => '10:00',
					'closes'   => '20:00',
				),
				array(
					'@type'    => 'OpeningHoursSpecification',
					'dayOfWeek'=> 'Saturday',
					'opens'    => '10:00',
					'closes'   => '17:00',
				),
			),
			'sameAs' => $same_as,
		);

		if ( ! empty( $logo_url ) ) {
			$schema['logo']  = $logo_url;
			$schema['image'] = $logo_url;
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
}
add_action( 'wp_head', 'nocap_child_frontpage_schema', 35 );
