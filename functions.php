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

if ( ! function_exists( 'nocap_child_seo_data' ) ) {
	function nocap_child_seo_data() {
		$site_url    = home_url( '/' );
		$host        = wp_parse_url( $site_url, PHP_URL_HOST );
		$logo_id     = get_theme_mod( 'custom_logo' );
		$logo_url    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
		$hero_image  = wp_get_attachment_image_url( 6142, 'full' );
		$image_url   = $hero_image ? $hero_image : $logo_url;
		$email       = ( 'nocap-barbers.local' === $host ) ? 'office@nocap-barbers.local' : 'office@nocap-barbers.at';
		$title       = 'Barber Shop 1010 Wien | NoCap Barbers | Premium Barber';
		$description = 'NoCap Barbers am Hohen Markt 3 in 1010 Wien: moderne Haarschnitte, Fade Cuts, Bartpflege und ehrliche Beratung. Online Termin buchen.';

		return array(
			'site_url'       => $site_url,
			'canonical'      => $site_url,
			'title'          => $title,
			'description'    => $description,
			'image'          => $image_url,
			'logo'           => $logo_url,
			'email'          => $email,
			'phone'          => '+43 1 4374527',
			'phone_display'  => '01 4374527',
			'price_range'    => '$$',
			'address'        => array(
				'streetAddress'   => 'Hoher Markt 3',
				'addressLocality' => 'Wien',
				'postalCode'      => '1010',
				'addressCountry'  => 'AT',
			),
			'same_as'        => array(
				'https://www.facebook.com/NoCapBarbersVienna/',
				'https://www.instagram.com/nocap.barbers_mens_grooming/',
				'https://www.treatwell.at/ort/no-cap-barbers/',
			),
			'booking_url'    => 'https://buchung.treatwell.at/ort/412028/menue/',
		);
	}
}

if ( ! function_exists( 'nocap_child_document_title' ) ) {
	function nocap_child_document_title( $title ) {
		if ( is_front_page() && ! nocap_child_has_primary_seo_plugin() ) {
			return nocap_child_seo_data()['title'];
		}

		return $title;
	}
}
add_filter( 'pre_get_document_title', 'nocap_child_document_title', 20 );

if ( ! function_exists( 'nocap_child_frontpage_seo_title_filter' ) ) {
	function nocap_child_frontpage_seo_title_filter( $title ) {
		if ( is_front_page() ) {
			return nocap_child_seo_data()['title'];
		}

		return $title;
	}
}
add_filter( 'rank_math/frontend/title', 'nocap_child_frontpage_seo_title_filter', 99 );

if ( ! function_exists( 'nocap_child_frontpage_seo_description_filter' ) ) {
	function nocap_child_frontpage_seo_description_filter( $description ) {
		if ( is_front_page() ) {
			return nocap_child_seo_data()['description'];
		}

		return $description;
	}
}
add_filter( 'rank_math/frontend/description', 'nocap_child_frontpage_seo_description_filter', 99 );

if ( ! function_exists( 'nocap_child_frontpage_seo_url_filter' ) ) {
	function nocap_child_frontpage_seo_url_filter( $url ) {
		if ( is_front_page() ) {
			return nocap_child_seo_data()['canonical'];
		}

		return $url;
	}
}
add_filter( 'rank_math/frontend/canonical', 'nocap_child_frontpage_seo_url_filter', 99 );
add_filter( 'rank_math/opengraph/url', 'nocap_child_frontpage_seo_url_filter', 99 );

if ( ! function_exists( 'nocap_child_frontpage_meta' ) ) {
	function nocap_child_frontpage_meta() {
		if ( ! is_front_page() || nocap_child_has_primary_seo_plugin() ) {
			return;
		}

		$seo = nocap_child_seo_data();
		?>
		<meta name="description" content="<?php echo esc_attr( $seo['description'] ); ?>">
		<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
		<link rel="canonical" href="<?php echo esc_url( $seo['canonical'] ); ?>">
		<meta property="og:locale" content="de_AT">
		<meta property="og:type" content="website">
		<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		<meta property="og:title" content="<?php echo esc_attr( $seo['title'] ); ?>">
		<meta property="og:description" content="<?php echo esc_attr( $seo['description'] ); ?>">
		<meta property="og:url" content="<?php echo esc_url( $seo['canonical'] ); ?>">
		<?php if ( ! empty( $seo['image'] ) ) : ?>
			<meta property="og:image" content="<?php echo esc_url( $seo['image'] ); ?>">
			<meta name="twitter:card" content="summary_large_image">
		<?php else : ?>
			<meta name="twitter:card" content="summary">
		<?php endif; ?>
		<meta name="twitter:title" content="<?php echo esc_attr( $seo['title'] ); ?>">
		<meta name="twitter:description" content="<?php echo esc_attr( $seo['description'] ); ?>">
		<?php
	}
}
add_action( 'wp_head', 'nocap_child_frontpage_meta', 4 );

if ( ! function_exists( 'nocap_child_resource_hints' ) ) {
	function nocap_child_resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' !== $relation_type ) {
			return $urls;
		}

		$urls[] = array(
			'href'        => 'https://fonts.googleapis.com',
			'crossorigin' => '',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);

		return $urls;
	}
}
add_filter( 'wp_resource_hints', 'nocap_child_resource_hints', 10, 2 );

if ( ! function_exists( 'nocap_child_robots_txt' ) ) {
	function nocap_child_robots_txt( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}

		$sitemap = home_url( '/wp-sitemap.xml' );
		if ( false === strpos( $output, $sitemap ) ) {
			$output .= "\nSitemap: " . $sitemap . "\n";
		}

		return $output;
	}
}
add_filter( 'robots_txt', 'nocap_child_robots_txt', 10, 2 );

if ( ! function_exists( 'nocap_child_frontpage_schema' ) ) {
	function nocap_child_frontpage_schema() {

		if ( ! is_front_page() || nocap_child_has_primary_seo_plugin() ) {
			return;
		}

		$seo      = nocap_child_seo_data();
		$place_id = trailingslashit( $seo['site_url'] ) . '#barbershop';
		$page     = array(
			'@type'       => 'WebPage',
			'@id'         => trailingslashit( $seo['site_url'] ) . '#webpage',
			'url'         => $seo['site_url'],
			'name'        => $seo['title'],
			'description' => $seo['description'],
			'inLanguage'  => 'de-AT',
			'isPartOf'    => array( '@id' => trailingslashit( $seo['site_url'] ) . '#website' ),
			'about'       => array( '@id' => $place_id ),
		);

		if ( ! empty( $seo['image'] ) ) {
			$page['primaryImageOfPage'] = array(
				'@type' => 'ImageObject',
				'url'   => $seo['image'],
			);
		}

		$schema   = array(
			'@context' => 'https://schema.org',
			'@graph'   => array(
				array(
					'@type'       => 'WebSite',
					'@id'         => trailingslashit( $seo['site_url'] ) . '#website',
					'url'         => $seo['site_url'],
					'name'        => get_bloginfo( 'name' ),
					'description' => $seo['description'],
					'inLanguage'  => 'de-AT',
					'publisher'   => array( '@id' => $place_id ),
				),
				$page,
				array(
					'@type'      => array( 'Barbershop', 'LocalBusiness' ),
					'@id'        => $place_id,
					'name'       => 'NoCap Barbers',
					'url'        => $seo['site_url'],
					'telephone'  => $seo['phone'],
					'email'      => $seo['email'],
					'priceRange' => $seo['price_range'],
					'image'      => $seo['image'],
					'logo'       => $seo['logo'],
					'address'    => array_merge( array( '@type' => 'PostalAddress' ), $seo['address'] ),
					'areaServed'  => array(
						array(
							'@type' => 'City',
							'name'  => 'Wien',
						),
					),
					'hasMap'      => 'https://www.google.com/maps?q=Hoher+Markt+3,+1010+Wien',
					'sameAs'      => $seo['same_as'],
					'makesOffer'  => array(
						array(
							'@type' => 'Offer',
							'itemOffered' => array(
								'@type' => 'Service',
								'name'  => 'Traditional Cut',
								'serviceType' => 'Herrenhaarschnitt',
							),
						),
						array(
							'@type' => 'Offer',
							'itemOffered' => array(
								'@type' => 'Service',
								'name'  => 'Fade Cut',
								'serviceType' => 'Fade Haircut',
							),
						),
						array(
							'@type' => 'Offer',
							'itemOffered' => array(
								'@type' => 'Service',
								'name'  => 'Beard Service',
								'serviceType' => 'Bart trimmen und stylen',
							),
						),
					),
					'aggregateRating' => array(
						'@type'       => 'AggregateRating',
						'ratingValue' => '4.9',
						'reviewCount' => '3700',
					),
					'openingHoursSpecification' => array(
						array(
							'@type'     => 'OpeningHoursSpecification',
							'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Friday' ),
							'opens'     => '10:00',
							'closes'    => '19:00',
						),
						array(
							'@type'     => 'OpeningHoursSpecification',
							'dayOfWeek' => 'Thursday',
							'opens'     => '10:00',
							'closes'    => '20:00',
						),
						array(
							'@type'     => 'OpeningHoursSpecification',
							'dayOfWeek' => 'Saturday',
							'opens'     => '10:00',
							'closes'    => '17:00',
						),
					),
				),
				array(
					'@type' => 'FAQPage',
					'@id'   => trailingslashit( $seo['site_url'] ) . '#faq',
					'mainEntity' => array(
						array(
							'@type' => 'Question',
							'name'  => 'Wo ist NoCap Barbers in Wien?',
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => 'NoCap Barbers befindet sich am Hohen Markt 3 im 1. Bezirk, 1010 Wien.',
							),
						),
						array(
							'@type' => 'Question',
							'name'  => 'Kann ich online einen Termin buchen?',
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => 'Ja, Termine koennen direkt online ueber Treatwell gebucht werden.',
							),
						),
						array(
							'@type' => 'Question',
							'name'  => 'Welche Services bietet NoCap Barbers an?',
							'acceptedAnswer' => array(
								'@type' => 'Answer',
								'text'  => 'NoCap Barbers bietet Traditional Cuts, Fade Cuts, Bartservice, Styling und Beratung fuer Herren an.',
							),
						),
					),
				),
				array(
					'@type' => 'BreadcrumbList',
					'@id'   => trailingslashit( $seo['site_url'] ) . '#breadcrumbs',
					'itemListElement' => array(
						array(
							'@type'    => 'ListItem',
							'position' => 1,
							'name'     => 'NoCap Barbers Wien',
							'item'     => $seo['site_url'],
						),
					),
				),
			),
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
}
add_action( 'wp_head', 'nocap_child_frontpage_schema', 35 );

if ( ! function_exists( 'nocap_child_frontpage_faq_schema_fallback' ) ) {
	function nocap_child_frontpage_faq_schema_fallback() {
		if ( ! is_front_page() || ! nocap_child_has_primary_seo_plugin() ) {
			return;
		}

		$seo    = nocap_child_seo_data();
		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'FAQPage',
			'@id'      => trailingslashit( $seo['site_url'] ) . '#faq',
			'mainEntity' => array(
				array(
					'@type' => 'Question',
					'name'  => 'Wo ist NoCap Barbers in Wien?',
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => 'NoCap Barbers befindet sich am Hohen Markt 3 im 1. Bezirk, 1010 Wien.',
					),
				),
				array(
					'@type' => 'Question',
					'name'  => 'Kann ich online einen Termin buchen?',
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => 'Ja, Termine koennen direkt online ueber Treatwell gebucht werden.',
					),
				),
				array(
					'@type' => 'Question',
					'name'  => 'Welche Services bietet NoCap Barbers an?',
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => 'NoCap Barbers bietet Traditional Cuts, Fade Cuts, Bartservice, Styling und Beratung fuer Herren an.',
					),
				),
			),
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
}
add_action( 'wp_head', 'nocap_child_frontpage_faq_schema_fallback', 36 );
