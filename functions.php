<?php
/**
 * Salient NoCap child theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nocap_homepage_plugin = WP_PLUGIN_DIR . '/nocap-homepage-content/nocap-homepage-content.php';
if ( ! class_exists( 'NoCap_Homepage_Content' ) && file_exists( $nocap_homepage_plugin ) ) {
	require_once $nocap_homepage_plugin;
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

		if ( function_exists( 'nocap_homepage_translations' ) ) {
			wp_add_inline_script(
				'nocap-home-modern',
				'window.nocapHomeTranslations = ' . wp_json_encode( nocap_homepage_translations() ) . ';',
				'before'
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'nocap_child_enqueue_assets', 120 );

if ( ! function_exists( 'nocap_child_update_homepage_cta_text' ) ) {
	function nocap_child_update_homepage_cta_text() {
		$content = get_option( 'nocap_homepage_content', array() );

		if ( ! is_array( $content ) ) {
			$content = array();
		}

		if ( ! isset( $content['hero'] ) || ! is_array( $content['hero'] ) ) {
			$content['hero'] = array();
		}

		$current = isset( $content['hero']['primary_cta'] ) && is_array( $content['hero']['primary_cta'] ) ? $content['hero']['primary_cta'] : array();
		$next    = array(
			'de' => isset( $current['de'] ) && ! in_array( $current['de'], array( '', 'Online Booking' ), true ) ? $current['de'] : 'Jetzt Termin sichern',
			'en' => isset( $current['en'] ) && ! in_array( $current['en'], array( '', 'Online Booking' ), true ) ? $current['en'] : 'Book your appointment',
		);

		if ( $next !== $current ) {
			$content['hero']['primary_cta'] = $next;
			update_option( 'nocap_homepage_content', $content );
		}
	}
}

if ( ! function_exists( 'nocap_child_asset_url' ) ) {
	function nocap_child_asset_url( $path ) {
		return get_stylesheet_directory_uri() . '/assets/' . ltrim( (string) $path, '/' );
	}
}

if ( ! function_exists( 'nocap_child_normalize_asset_url' ) ) {
	function nocap_child_normalize_asset_url( $url ) {
		$url = (string) $url;

		if ( '' === $url || false === strpos( $url, '/wp-content/themes/salient-nocap-child/assets/' ) ) {
			return $url;
		}

		$path = wp_parse_url( $url, PHP_URL_PATH );
		$needle = '/wp-content/themes/salient-nocap-child/assets/';
		$asset_pos = is_string( $path ) ? strpos( $path, $needle ) : false;

		if ( false === $asset_pos ) {
			return $url;
		}

		return nocap_child_asset_url( substr( $path, $asset_pos + strlen( $needle ) ) );
	}
}

if ( ! function_exists( 'nocap_child_tiktok_url' ) ) {
	function nocap_child_tiktok_url() {
		if ( function_exists( 'nocap_homepage_content' ) ) {
			$content = nocap_homepage_content( 'de' );
			if ( ! empty( $content['settings']['tiktok_url'] ) ) {
				return $content['settings']['tiktok_url'];
			}
		}

		return 'https://www.tiktok.com/@nocap.barbershop';
	}
}

if ( ! function_exists( 'nocap_child_brand_logo_url' ) ) {
	function nocap_child_brand_logo_url() {
		if ( function_exists( 'nocap_homepage_content' ) ) {
			$content = nocap_homepage_content( 'de' );
			$logo_raw = isset( $content['settings']['brand_logo'] ) ? trim( (string) $content['settings']['brand_logo'] ) : '';
			$logo     = '';

			if ( '' !== $logo_raw ) {
				if ( ctype_digit( $logo_raw ) ) {
					$logo = wp_get_attachment_image_url( (int) $logo_raw, 'full' );
				} elseif ( filter_var( $logo_raw, FILTER_VALIDATE_URL ) ) {
					$logo = $logo_raw;
				}
			}

			if ( $logo ) {
				return $logo;
			}
		}

		return nocap_child_asset_url( 'images/new_logo/ncp_barbers_cropped.png' );
	}
}

if ( ! function_exists( 'nocap_child_partner_defaults' ) ) {
	function nocap_child_partner_defaults() {
		return array(
			'items' => array(
				array(
					'name'     => 'REUZEL',
					'url'      => 'https://www.reuzel.com/',
					'logo'     => '',
					'logo_url' => nocap_child_asset_url( 'images/partners/reuzel.png' ),
				),
				array(
					'name'     => '1922 by J.M. Keune',
					'url'      => 'https://www.keune.com/men/',
					'logo'     => '',
					'logo_url' => nocap_child_asset_url( 'images/partners/jm_keune.jpg' ),
				),
				array(
					'name'     => 'Proraso',
					'url'      => 'https://proraso.com/en/',
					'logo'     => '',
					'logo_url' => nocap_child_asset_url( 'images/partners/poraso.svg' ),
				),
				array(
					'name'     => 'Slick Gorilla',
					'url'      => 'https://slickgorilla.com/',
					'logo'     => '',
					'logo_url' => nocap_child_asset_url( 'images/partners/slick_gorilla.png' ),
				),
			),
		);
	}
}

if ( ! function_exists( 'nocap_child_extra_product_defaults' ) ) {
	function nocap_child_extra_product_defaults() {
		return array(
			array(
				'image'     => '',
				'image_url' => nocap_child_asset_url( 'images/new_products/proraso.jpg' ),
				'number'    => array( 'de' => 'Rasur', 'en' => 'Shave' ),
				'kicker'    => array( 'de' => 'Shave + Beard', 'en' => 'Shave + Beard' ),
				'title'     => array( 'de' => 'PRORASO', 'en' => 'PRORASO' ),
				'text'      => array( 'de' => 'Italienische Barber-Klassiker für Rasur, Bart und Haut. Frisch, direkt und verlässlich, wenn Konturen sauber bleiben sollen.', 'en' => 'Italian barber classics for shaving, beard and skin. Fresh, direct and reliable when contours need to stay clean.' ),
				'points'    => array(
					array( 'de' => 'Pre-shave, Rasiercreme und Aftershave', 'en' => 'Pre-shave, shaving cream and aftershave' ),
					array( 'de' => 'Starker Standard für saubere Konturen', 'en' => 'Strong standard for clean contours' ),
					array( 'de' => 'Bewährt für Bartpflege im Shop', 'en' => 'Proven for beard care in the shop' ),
				),
			),
			array(
				'image'     => '',
				'image_url' => nocap_child_asset_url( 'images/new_products/slick_gorilla.webp' ),
				'number'    => array( 'de' => 'Textur', 'en' => 'Texture' ),
				'kicker'    => array( 'de' => 'Volume + Matte', 'en' => 'Volume + Matte' ),
				'title'     => array( 'de' => 'Slick Gorilla', 'en' => 'Slick Gorilla' ),
				'text'      => array( 'de' => 'Moderne Texturprodukte für matte Looks mit Griff. Gut für lockere Styles, die leicht bleiben und trotzdem Form halten.', 'en' => 'Modern texture products for matte looks with grip. Good for loose styles that stay light while keeping shape.' ),
				'points'    => array(
					array( 'de' => 'Styling Powder, Clay und Sea Salt Finish', 'en' => 'Styling powder, clay and sea salt finish' ),
					array( 'de' => 'Volumen ohne schweres Produktgefühl', 'en' => 'Volume without a heavy product feel' ),
					array( 'de' => 'Ideal für messy, matte und natürliche Looks', 'en' => 'Ideal for messy, matte and natural looks' ),
				),
			),
		);
	}
}

if ( ! function_exists( 'nocap_child_seed_homepage_extension_content' ) ) {
	function nocap_child_seed_homepage_extension_content() {
		$content = get_option( 'nocap_homepage_content', array() );

		if ( ! is_array( $content ) ) {
			$content = array();
		}

		$changed = false;

		if ( ! isset( $content['settings'] ) || ! is_array( $content['settings'] ) ) {
			$content['settings'] = array();
		}

		foreach ( array(
			'tiktok_url' => 'https://www.tiktok.com/@nocap.barbershop',
			'brand_logo' => '',
		) as $key => $value ) {
			if ( ! array_key_exists( $key, $content['settings'] ) ) {
				$content['settings'][ $key ] = $value;
				$changed = true;
			}
		}

		if ( ! isset( $content['partners']['items'] ) || ! is_array( $content['partners']['items'] ) ) {
			$content['partners'] = nocap_child_partner_defaults();
			$changed = true;
		}

		if ( ! isset( $content['products'] ) || ! is_array( $content['products'] ) ) {
			$content['products'] = array();
		}

		$old_titles = array( '', 'Produkte, denen wir vertrauen' );
		if ( empty( $content['products']['title']['de'] ) || in_array( $content['products']['title']['de'], $old_titles, true ) ) {
			$content['products']['title'] = array( 'de' => 'Partner denen wir vertrauen', 'en' => 'Partners we trust' );
			$changed = true;
		}

		$current_intro_de = is_array( $content['products']['intro'] ?? null ) ? (string) ( $content['products']['intro']['de'] ?? '' ) : (string) ( $content['products']['intro'] ?? '' );
		if ( ! array_key_exists( 'intro', $content['products'] ) || 'Zwei Linien, zwei StÃ¤rken: Styling und Pflege.' === $current_intro_de || 'Zwei Linien, zwei Stärken: Styling und Pflege.' === $current_intro_de ) {
			$content['products']['intro'] = array( 'de' => '', 'en' => '' );
			$changed = true;
		}

		if ( ! isset( $content['products']['items'] ) || ! is_array( $content['products']['items'] ) ) {
			$content['products']['items'] = array();
		}

		if ( empty( $content['products']['items'] ) && class_exists( 'NoCap_Homepage_Content' ) ) {
			$plugin_defaults = NoCap_Homepage_Content::defaults();
			if ( ! empty( $plugin_defaults['products']['items'] ) && is_array( $plugin_defaults['products']['items'] ) ) {
				$content['products']['items'] = $plugin_defaults['products']['items'];
				$changed = true;
			}
		}

		$existing_products = array_map(
			static function( $item ) {
				return strtolower( (string) ( $item['title']['de'] ?? $item['title'] ?? '' ) );
			},
			$content['products']['items']
		);

		foreach ( nocap_child_extra_product_defaults() as $product ) {
			if ( ! in_array( strtolower( $product['title']['de'] ), $existing_products, true ) ) {
				$content['products']['items'][] = $product;
				$changed = true;
			}
		}

		if ( $changed ) {
			update_option( 'nocap_homepage_content', $content, false );
		}
	}
}

if ( ! function_exists( 'nocap_child_normalize_brand_logo_setting' ) ) {
	function nocap_child_normalize_brand_logo_setting() {
		$content = get_option( 'nocap_homepage_content', array() );

		if ( ! is_array( $content ) || empty( $content['settings']['brand_logo'] ) || ! function_exists( 'attachment_url_to_postid' ) ) {
			return;
		}

		$brand_logo = trim( (string) $content['settings']['brand_logo'] );
		if ( '' === $brand_logo || ctype_digit( $brand_logo ) || ! filter_var( $brand_logo, FILTER_VALIDATE_URL ) ) {
			return;
		}

		$attachment_id = (int) attachment_url_to_postid( $brand_logo );
		if ( $attachment_id > 0 ) {
			$content['settings']['brand_logo'] = $attachment_id;
			update_option( 'nocap_homepage_content', $content, false );
		}
	}
}

if ( ! function_exists( 'nocap_child_homepage_extension_defaults' ) ) {
	function nocap_child_homepage_extension_defaults() {
		return array(
			'settings'     => array(
				'tiktok_url'        => 'https://www.tiktok.com/@nocap.barbershop',
				'brand_logo'        => '',
				'hero_news_enabled' => '1',
			),
			'partners'     => nocap_child_partner_defaults(),
			'hero_reviews' => array(
				'eyebrow'        => array( 'de' => 'Bewertet auf Google & Treatwell', 'en' => 'Rated on Google & Treatwell' ),
				'count'          => array( 'de' => '3700+', 'en' => '3700+' ),
				'label'          => array( 'de' => 'Bewertungen', 'en' => 'reviews' ),
				'score'          => array( 'de' => '4.9/5 Durchschnitt', 'en' => '4.9/5 average' ),
				'treatwell_meta' => array( 'de' => '3000+ Treatwell', 'en' => '3000+ Treatwell' ),
				'google_meta'    => array( 'de' => '700+ Google', 'en' => '700+ Google' ),
			),
			'hero_news'    => array(
				'kicker'  => array( 'de' => 'Neu in 1010 Wien', 'en' => 'New in 1010 Vienna' ),
				'title'   => array( 'de' => 'Zweiter Shop kommt', 'en' => 'Second shop coming' ),
				'text'    => array( 'de' => 'Wir eröffnen bald am Bauernmarkt 10, 1010 Wien.', 'en' => 'We are opening soon at Bauernmarkt 10, 1010 Vienna.' ),
				'address' => array( 'de' => 'Bauernmarkt 10, 1010 Wien', 'en' => 'Bauernmarkt 10, 1010 Vienna' ),
			),
		);
	}
}

if ( ! function_exists( 'nocap_child_localize_extension_defaults' ) ) {
	function nocap_child_localize_extension_defaults( $lang = 'de' ) {
		$defaults = nocap_child_homepage_extension_defaults();

		if ( class_exists( 'NoCap_Homepage_Content' ) ) {
			return NoCap_Homepage_Content::localize( $defaults, 'en' === $lang ? 'en' : 'de' );
		}

		$localize = function( $value ) use ( &$localize, $lang ) {
			if ( is_array( $value ) && isset( $value['de'], $value['en'] ) ) {
				return ( 'en' === $lang && '' !== (string) $value['en'] ) ? $value['en'] : $value['de'];
			}

			if ( is_array( $value ) ) {
				foreach ( $value as $key => $item ) {
					$value[ $key ] = $localize( $item );
				}
			}

			return $value;
		};

		return $localize( $defaults );
	}
}

if ( ! function_exists( 'nocap_child_homepage_extension_admin_fields' ) ) {
	function nocap_child_homepage_extension_admin_fields() {
		$defaults = nocap_child_homepage_extension_defaults();
		$saved    = get_option( 'nocap_homepage_content', array() );
		$content  = array_replace_recursive( $defaults, is_array( $saved ) ? $saved : array() );
		?>
		<script>
			window.nocapChildHomepageExtension = <?php echo wp_json_encode( array( 'content' => $content ) ); ?>;
		</script>
		<?php
	}
}

if ( ! function_exists( 'nocap_child_homepage_extension_admin_assets' ) ) {
	function nocap_child_homepage_extension_admin_assets( $hook ) {
		if ( 'toplevel_page_nocap-homepage-content' !== $hook ) {
			return;
		}

		wp_enqueue_media();
	}
}

if ( ! function_exists( 'nocap_child_homepage_extension_admin_save_bar_style' ) ) {
	function nocap_child_homepage_extension_admin_save_bar_style() {
		?>
		<style>
			body.toplevel_page_nocap-homepage-content .nocap-save-bar {
				position: fixed !important;
				top: auto !important;
				left: auto !important;
				right: 28px !important;
				bottom: 26px !important;
				z-index: 100100;
				display: inline-flex !important;
				align-items: center;
				justify-content: flex-end;
				gap: 18px;
				width: auto !important;
				min-width: 0 !important;
				max-width: min(520px, calc(100vw - 56px)) !important;
				height: auto !important;
				min-height: 74px !important;
				max-height: none !important;
				padding: 14px 16px 14px 22px !important;
				background:
					linear-gradient(90deg, rgba(255, 255, 255, 0.08) 0 1px, transparent 1px 24px),
					linear-gradient(135deg, #111319 0%, #1a1f2a 100%);
				border: 1px solid rgba(195, 154, 98, 0.42);
				border-radius: 0;
				clip-path: polygon(0 0, calc(100% - 18px) 0, 100% 18px, 100% 100%, 18px 100%, 0 calc(100% - 18px));
				box-shadow: 0 20px 54px rgba(0, 0, 0, 0.34);
				transform: translateY(24px);
				opacity: 0;
				pointer-events: none;
				transition: opacity 180ms ease, transform 180ms ease;
				inset-block-start: auto !important;
				inset-inline-start: auto !important;
				inset-inline-end: 28px !important;
			}

			body.toplevel_page_nocap-homepage-content.nocap-homepage-dirty .nocap-save-bar,
			body.toplevel_page_nocap-homepage-content.nocap-homepage-saving .nocap-save-bar {
				opacity: 1;
				pointer-events: auto;
				transform: translateY(0);
			}

			body.toplevel_page_nocap-homepage-content .nocap-save-bar::before {
				content: "Änderungen bereit";
				color: rgba(255, 255, 255, 0.74);
				font-size: 12px;
				font-weight: 800;
				letter-spacing: 0.14em;
				text-transform: uppercase;
				white-space: nowrap;
			}

			body.toplevel_page_nocap-homepage-content.nocap-homepage-saving .nocap-save-bar::before {
				content: "Speichert";
			}

			body.toplevel_page_nocap-homepage-content .nocap-save-bar .button,
			body.toplevel_page_nocap-homepage-content .nocap-save-bar .button-primary,
			body.toplevel_page_nocap-homepage-content .nocap-save-bar input[type="submit"],
			body.toplevel_page_nocap-homepage-content .nocap-save-bar button[type="submit"] {
				min-height: 46px;
				padding: 0 26px;
				border: 1px solid rgba(255, 255, 255, 0.2);
				border-radius: 0;
				background: linear-gradient(135deg, #c39a62 0%, #a87d42 100%) !important;
				color: #111319 !important;
				font-weight: 800;
				font-size: 13px;
				letter-spacing: 0.08em;
				text-transform: uppercase;
				box-shadow: none;
				clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
			}

			body.toplevel_page_nocap-homepage-content.nocap-homepage-dirty .nocap-admin,
			body.toplevel_page_nocap-homepage-content.nocap-homepage-saving .nocap-admin {
				padding-bottom: 98px;
			}

			@media (max-width: 782px) {
				body.toplevel_page_nocap-homepage-content .nocap-save-bar {
					bottom: 14px !important;
					right: 12px !important;
					width: calc(100vw - 24px) !important;
					max-width: calc(100vw - 24px) !important;
					inset-inline-end: 12px !important;
					flex-wrap: wrap;
					justify-content: space-between;
				}
			}
		</style>
		<?php
	}
}

if ( ! function_exists( 'nocap_child_homepage_extension_admin_script' ) ) {
	function nocap_child_homepage_extension_admin_script() {
		?>
		<script>
			(function () {
				var data = window.nocapChildHomepageExtension && window.nocapChildHomepageExtension.content;
				var form = document.querySelector('.nocap-admin form');
				var saveBar = document.querySelector('.nocap-save-bar');

				if (!data || !form || !saveBar || form.querySelector('[data-nocap-child-extension]')) {
					return;
				}

				var markDirty = function () {
					document.body.classList.add('nocap-homepage-dirty');
					document.body.classList.remove('nocap-homepage-saving');
				};
				var markSaving = function () {
					document.body.classList.remove('nocap-homepage-dirty');
					document.body.classList.add('nocap-homepage-saving');
				};

				saveBar.setAttribute('aria-live', 'polite');
				form.addEventListener('input', markDirty, true);
				form.addEventListener('change', markDirty, true);
				form.addEventListener('click', function (event) {
					if (event.target.closest('.nocap-add-card, .nocap-remove-card, .nocap-remove-media')) {
						markDirty();
					}
				}, true);
				form.addEventListener('submit', markSaving);

				var labels = {
					hero_reviews: 'Hero Bewertungs-Komponente - neue Felder',
					hero_news: 'Shop News Anzeige - neue Felder'
				};
				var fields = {
					hero_reviews: ['eyebrow', 'count', 'label', 'score', 'treatwell_meta', 'google_meta'],
					hero_news: ['kicker', 'title', 'text', 'address']
				};
				var niceLabel = function (key) {
					return key.replace(/_/g, ' ').replace(/\b\w/g, function (letter) {
						return letter.toUpperCase();
					});
				};
				var field = function (section, key, lang, value) {
					var label = document.createElement('label');
					var text = document.createElement('span');
					var input = document.createElement('textarea');
					label.className = 'nocap-field';
					text.textContent = lang === 'de' ? 'Deutsch' : 'English';
					input.name = 'nocap_homepage_content[' + section + '][' + key + '][' + lang + ']';
					input.rows = 2;
					input.value = value || '';
					label.appendChild(text);
					label.appendChild(input);
					return label;
				};
				var simpleField = function (name, labelText, value) {
					var label = document.createElement('label');
					var text = document.createElement('span');
					var input = document.createElement('textarea');
					label.className = 'nocap-field';
					text.textContent = labelText;
					input.name = name;
					input.rows = 2;
					input.value = value || '';
					label.appendChild(text);
					label.appendChild(input);
					return label;
				};
				var checkboxField = function (name, labelText, value) {
					var label = document.createElement('label');
					var text = document.createElement('span');
					var hidden = document.createElement('input');
					var input = document.createElement('input');
					label.className = 'nocap-field nocap-checkbox-field';
					text.textContent = labelText;
					hidden.type = 'hidden';
					hidden.name = name;
					hidden.value = '0';
					input.type = 'checkbox';
					input.name = name;
					input.value = '1';
					input.checked = String(value || '1') !== '0';
					label.appendChild(text);
					label.appendChild(hidden);
					label.appendChild(input);
					return label;
				};
				var mediaField = function (name, labelText, value) {
					var label = document.createElement('label');
					var text = document.createElement('span');
					var input = document.createElement('input');
					var button = document.createElement('button');
					var remove = document.createElement('button');
					var preview = document.createElement('span');
					var frame = null;

					label.className = 'nocap-field nocap-media-field';
					text.textContent = labelText;
					input.type = 'hidden';
					input.name = name;
					input.value = value || '';

					button.type = 'button';
					button.className = 'button nocap-pick-media';
					button.textContent = 'Datei aus Mediathek w\u00e4hlen';

					remove.type = 'button';
					remove.className = 'button-link-delete nocap-remove-media';
					remove.textContent = 'Entfernen';

					preview.className = 'nocap-media-preview';

					var syncPreview = function () {
						preview.innerHTML = '';
						if (!input.value) {
							preview.classList.remove('has-value');
							return;
						}
						preview.classList.add('has-value');
						var img = document.createElement('img');
						img.src = input.value.match(/^\d+$/) ? '' : input.value;
						img.alt = '';
						if (img.src) {
							preview.appendChild(img);
						}
					};

					button.addEventListener('click', function (event) {
						event.preventDefault();
						if (!window.wp || !wp.media) {
							return;
						}
						if (!frame) {
							frame = wp.media({
								title: labelText,
								button: { text: 'Auswählen' },
								multiple: false
							});
							frame.on('select', function () {
								var attachment = frame.state().get('selection').first().toJSON();
								input.value = attachment.id || '';
								preview.innerHTML = '';
								preview.classList.add('has-value');
								var img = document.createElement('img');
								img.src = (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) || attachment.url || '';
								img.alt = '';
								preview.appendChild(img);
								markDirty();
							});
						}
						frame.open();
					});

					remove.addEventListener('click', function (event) {
						event.preventDefault();
						input.value = '';
						syncPreview();
						markDirty();
					});

					label.appendChild(text);
					label.appendChild(input);
					label.appendChild(button);
					label.appendChild(remove);
					label.appendChild(preview);
					syncPreview();
					return label;
				};
				var upgradeBrandLogoField = function () {
					var input = form.querySelector('[name="nocap_homepage_content[settings][brand_logo]"]');
					if (!input || input.dataset.nocapBrandLogoUpgraded) {
						return;
					}

					var field = input.closest('label, .nocap-field, .redux-field-container, .form-field, p, div');
					var container = field || input.parentNode;
					var button = document.createElement('button');
					var preview = document.createElement('span');
					var frame = null;

					input.type = 'number';
					input.placeholder = '';
					input.dataset.nocapBrandLogoUpgraded = '1';

					button.type = 'button';
					button.className = 'button nocap-pick-media';
					button.textContent = 'Datei aus Mediathek w\u00e4hlen';

					preview.className = 'nocap-media-preview';

					var syncPreview = function () {
						preview.innerHTML = '';
						preview.classList.toggle('has-value', !!input.value);
					};

					button.addEventListener('click', function (event) {
						event.preventDefault();
						if (!window.wp || !wp.media) {
							return;
						}
						if (!frame) {
							frame = wp.media({
								title: 'Brand Logo',
								button: { text: 'Auswählen' },
								multiple: false
							});
							frame.on('select', function () {
								var attachment = frame.state().get('selection').first().toJSON();
								input.value = attachment.id || '';
								syncPreview();
								markDirty();
							});
						}
						frame.open();
					});

					container.appendChild(button);
					container.appendChild(preview);
					syncPreview();
				};
				var insertSettings = function () {
					var wrapper = document.createElement('section');
					var grid = document.createElement('div');
					var settings = data.settings || {};
					wrapper.className = 'nocap-admin-section';
					wrapper.setAttribute('data-nocap-child-extension', 'settings-social-brand');
					wrapper.innerHTML = '<h2>Logo & TikTok - Child Theme</h2><p class="description">Diese Werte ueberschreiben Fallbacks aus dem Child Theme.</p>';
					grid.className = 'nocap-grid';
					grid.appendChild(simpleField('nocap_homepage_content[settings][tiktok_url]', 'TikTok URL', settings.tiktok_url || ''));
					wrapper.appendChild(grid);
					form.insertBefore(wrapper, saveBar);
				};
				var insertNewsToggleInTopSection = function () {
					var firstSection = form.querySelector('.nocap-admin-section');
					var settings = data.settings || {};
					if (!firstSection || firstSection.querySelector('[name="nocap_homepage_content[settings][hero_news_enabled]"]')) {
						return;
					}

					var grid = firstSection.querySelector('.nocap-grid') || firstSection;
					var field = checkboxField('nocap_homepage_content[settings][hero_news_enabled]', 'Shop News anzeigen', settings.hero_news_enabled || '1');
					field.setAttribute('data-nocap-child-extension', 'hero-news-toggle-top');
					grid.insertBefore(field, grid.firstChild);
				};
				var partnerCard = function (item, index) {
					var card = document.createElement('div');
					var title = document.createElement('div');
					var grid = document.createElement('div');
					var base = 'nocap_homepage_content[partners][items][' + index + ']';
					card.className = 'nocap-repeater-card';
					title.className = 'nocap-card-title';
					title.innerHTML = '<strong>Partner ' + (index + 1) + '</strong><button type="button" class="button-link-delete nocap-remove-card">Entfernen</button>';
					grid.className = 'nocap-grid';
					grid.appendChild(simpleField(base + '[name]', 'Name', item.name || ''));
					grid.appendChild(simpleField(base + '[url]', 'Website URL', item.url || ''));
					grid.appendChild(mediaField(base + '[logo]', 'Logo aus Mediathek', item.logo || ''));
					grid.appendChild(simpleField(base + '[logo_url]', 'Fallback Logo URL', item.logo_url || ''));
					card.appendChild(title);
					card.appendChild(grid);
					return card;
				};
				var insertPartners = function () {
					var wrapper = document.createElement('section');
					var repeater = document.createElement('div');
					var add = document.createElement('button');
					var partners = (data.partners && data.partners.items) || [];
					wrapper.className = 'nocap-admin-section';
					wrapper.setAttribute('data-nocap-child-extension', 'partners');
					wrapper.innerHTML = '<h2>Partner Logo Carousel - Child Theme</h2><p class="description">Logos drehen im dunklen Produkte-Bereich. Website URL oeffnet bei Klick.</p>';
					repeater.className = 'nocap-repeater';
					repeater.setAttribute('data-section', 'partners');
					repeater.setAttribute('data-field', 'items');
					partners.forEach(function (item, index) {
						repeater.appendChild(partnerCard(item, index));
					});
					add.type = 'button';
					add.className = 'button nocap-add-card';
					add.textContent = 'Eintrag duplizieren';
					wrapper.appendChild(repeater);
					wrapper.appendChild(add);
					form.insertBefore(wrapper, saveBar);
				};
				var insertProductFallbackFields = function () {
					var products = (data.products && data.products.items) || [];
					var repeater = form.querySelector('.nocap-repeater[data-section="products"][data-field="items"]');
					if (!repeater) {
						return;
					}

					Array.prototype.slice.call(repeater.querySelectorAll('.nocap-repeater-card')).forEach(function (card, index) {
						if (card.querySelector('[name="nocap_homepage_content[products][items][' + index + '][image_url]"]')) {
							return;
						}

						var grid = card.querySelector('.nocap-grid');
						if (!grid) {
							return;
						}

						grid.appendChild(simpleField(
							'nocap_homepage_content[products][items][' + index + '][image_url]',
							'Fallback Bild URL',
							products[index] && products[index].image_url ? products[index].image_url : ''
						));
						grid.appendChild(mediaField(
							'nocap_homepage_content[products][items][' + index + '][logo]',
							'Produkt Logo aus Mediathek',
							products[index] && products[index].logo ? products[index].logo : ''
						));
						grid.appendChild(simpleField(
							'nocap_homepage_content[products][items][' + index + '][logo_url]',
							'Produkt Logo Fallback URL',
							products[index] && products[index].logo_url ? products[index].logo_url : ''
						));
					});
				};

				upgradeBrandLogoField();
				insertNewsToggleInTopSection();
				insertSettings();
				insertPartners();
				insertProductFallbackFields();

				Object.keys(fields).forEach(function (section) {
					var wrapper = document.createElement('section');
					wrapper.className = 'nocap-admin-section';
					wrapper.setAttribute('data-nocap-child-extension', section);
					wrapper.innerHTML = '<h2>' + labels[section] + '</h2><p class="description">Neue Child-Theme Felder. Bewertungsfelder erscheinen in der Hero Section; Shop News erscheint unter den Services. CTA Text nutzt das bestehende Hero Feld Primary Cta.</p><div class="nocap-grid"></div>';

					var grid = wrapper.querySelector('.nocap-grid');
					fields[section].forEach(function (key) {
						var group = document.createElement('div');
						var title = document.createElement('strong');
						var value = (data[section] && data[section][key]) || {};
						group.className = 'nocap-lang-field';
						title.textContent = niceLabel(key);
						group.appendChild(title);
						group.appendChild(field(section, key, 'de', value.de));
						group.appendChild(field(section, key, 'en', value.en));
						grid.appendChild(group);
					});

					form.insertBefore(wrapper, saveBar);
				});
			})();
		</script>
		<?php
	}
}

if ( ! function_exists( 'nocap_child_skip_link' ) ) {
	function nocap_child_skip_link() {
		if ( ! is_front_page() ) {
			return;
		}

		echo '<a class="skip-link" href="#nocap-main">' . esc_html__( 'Skip to main content', 'salient-nocap-child' ) . '</a>';
	}
}
add_action( 'nectar_hook_after_body_open', 'nocap_child_skip_link', 2 );

if ( ! function_exists( 'nocap_child_instagram_url' ) ) {
	function nocap_child_instagram_url() {
		if ( function_exists( 'nocap_homepage_content' ) ) {
			$content = nocap_homepage_content( 'de' );
			if ( ! empty( $content['settings']['instagram_url'] ) ) {
				return $content['settings']['instagram_url'];
			}
		}

		return 'https://www.instagram.com/nocap.barbers';
	}
}

if ( ! function_exists( 'nocap_child_normalize_instagram_links' ) ) {
	function nocap_child_normalize_instagram_links() {
		$instagram_url = nocap_child_instagram_url();
		?>
		<script>
			(function () {
				var instagramUrl = <?php echo wp_json_encode( esc_url_raw( $instagram_url ) ); ?>;
				if (!instagramUrl) {
					return;
				}
				document.querySelectorAll('a[href*="instagram.com"]').forEach(function (link) {
					link.setAttribute("href", instagramUrl);
				});
			})();
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'nocap_child_normalize_instagram_links', 99 );

if ( ! function_exists( 'nocap_child_brand_social_footer_script' ) ) {
	function nocap_child_brand_social_footer_script() {
		$brand_logo_url = nocap_child_brand_logo_url();
		$tiktok_url     = nocap_child_tiktok_url();
		?>
		<script>
			(function () {
				var logoUrl = <?php echo wp_json_encode( esc_url_raw( $brand_logo_url ) ); ?>;
				var tiktokUrl = <?php echo wp_json_encode( esc_url_raw( $tiktok_url ) ); ?>;
				var tikTokIcon = '<span class="nocap-social-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M15.2 3c.35 2.43 1.72 3.88 4.05 4.03v3.08a7.1 7.1 0 0 1-4.01-1.24v5.92c0 3-1.82 5.21-4.64 5.21-2.7 0-4.85-2.05-4.85-4.72 0-2.93 2.45-5.03 5.35-4.59v3.2c-1.08-.34-2.18.36-2.18 1.46 0 .89.73 1.62 1.63 1.62 1.05 0 1.62-.68 1.62-1.95V3h3.03Z" fill="currentColor"/></svg></span>';

				if (logoUrl) {
					document.querySelectorAll('#header-outer #logo img, #header-outer .logo img, #footer-outer #block-3 img, #footer-outer .widget_media_image img').forEach(function (image) {
						var src = image.getAttribute('src') || '';
						var alt = (image.getAttribute('alt') || '').toLowerCase();
						if (image.closest('#footer-outer') && !image.closest('#block-3') && src.indexOf('logo') === -1 && alt.indexOf('nocap') === -1 && alt.indexOf('no cap') === -1) {
							return;
						}
						image.setAttribute('src', logoUrl);
						image.setAttribute('data-src', logoUrl);
						image.removeAttribute('srcset');
						image.removeAttribute('data-srcset');
						image.removeAttribute('sizes');
						image.removeAttribute('data-sizes');
						image.setAttribute('alt', 'NoCap Barbers');
						image.classList.remove('lazyload', 'lazyloaded');
					});
				}

				if (!tiktokUrl) {
					return;
				}

				document.querySelectorAll('.nocap-gallery-cta-row').forEach(function (row) {
					if (row.querySelector('a[href*="tiktok.com"]')) {
						return;
					}

					var instagram = row.querySelector('a[href*="instagram.com"]');
					if (!instagram) {
						return;
					}

					var tiktok = instagram.cloneNode(true);
					tiktok.className = 'nocap-gallery-cta nocap-gallery-cta-tiktok';
					tiktok.setAttribute('href', tiktokUrl);
					tiktok.setAttribute('aria-label', 'TikTok');
					tiktok.innerHTML = '<span class="nocap-gallery-cta-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M15.2 3c.35 2.43 1.72 3.88 4.05 4.03v3.08a7.1 7.1 0 0 1-4.01-1.24v5.92c0 3-1.82 5.21-4.64 5.21-2.7 0-4.85-2.05-4.85-4.72 0-2.93 2.45-5.03 5.35-4.59v3.2c-1.08-.34-2.18.36-2.18 1.46 0 .89.73 1.62 1.63 1.62 1.05 0 1.62-.68 1.62-1.95V3h3.03Z" fill="currentColor"/></svg></span><span class="nocap-gallery-cta-copy"><span>TikTok</span><strong>@nocap.<br>barbershop</strong></span>';
					var booking = row.querySelector('.nocap-gallery-cta-booking');
					if (booking) {
						booking.insertAdjacentElement('afterend', tiktok);
					} else {
						instagram.insertAdjacentElement('afterend', tiktok);
					}
				});

				document.querySelectorAll('.nocap-social, #social-in-menu, #footer-outer .social, #footer-outer .nectar-social').forEach(function (list) {
					if (list.querySelector('a[href*="tiktok.com"]')) {
						return;
					}

					var instagram = list.querySelector('a[href*="instagram.com"]');
					if (!instagram) {
						return;
					}

					var tiktok = instagram.cloneNode(true);
					tiktok.setAttribute('href', tiktokUrl);
					tiktok.setAttribute('aria-label', 'TikTok');
					tiktok.setAttribute('target', '_blank');
					tiktok.setAttribute('rel', 'noopener');
					tiktok.classList.add('nocap-tiktok-link');

					if (list.matches('.nocap-social')) {
						tiktok.innerHTML = tikTokIcon;
					} else {
						tiktok.innerHTML = '<svg viewBox="0 0 24 24" class="nocap-tiktok-svg" style="display:inline-block;width:1em;height:1em;vertical-align:middle;" fill="currentColor" role="presentation" focusable="false" aria-hidden="true"><path d="M15.2 3c.35 2.43 1.72 3.88 4.05 4.03v3.08a7.1 7.1 0 0 1-4.01-1.24v5.92c0 3-1.82 5.21-4.64 5.21-2.7 0-4.85-2.05-4.85-4.72 0-2.93 2.45-5.03 5.35-4.59v3.2c-1.08-.34-2.18.36-2.18 1.46 0 .89.73 1.62 1.63 1.62 1.05 0 1.62-.68 1.62-1.95V3h3.03Z"/></svg>';
					}

					if (list.tagName && list.tagName.toLowerCase() === 'ul' && instagram.closest('li')) {
						var sourceLi = instagram.closest('li');
						var item = sourceLi.cloneNode(false);
						item.className = (sourceLi.className || '') + ' nocap-tiktok-li';
						item.appendChild(tiktok);
						sourceLi.insertAdjacentElement('afterend', item);
					} else {
						instagram.insertAdjacentElement('afterend', tiktok);
					}
				});
			})();
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'nocap_child_brand_social_footer_script', 101 );

if ( ! function_exists( 'nocap_child_footer_credit_override' ) ) {
	function nocap_child_footer_credit_override() {
		?>
		<script>
			(function () {
				var creditPattern = /(Created|Crafted) by\s+webhouse Digital/i;
				var footer = document.querySelector("footer, #footer-outer, #copyright");

				if (!footer) {
					return;
				}

				footer.querySelectorAll("a, span, p, div, small, li").forEach(function (element) {
					var text = element.textContent || "";

					if (!creditPattern.test(text)) {
						return;
					}

					var childHasCredit = Array.prototype.some.call(element.children, function (child) {
						return creditPattern.test(child.textContent || "");
					});

					if (childHasCredit) {
						return;
					}

					if (element.tagName.toLowerCase() === "a") {
						element.href = "https://wilde.cc";
						element.target = "_blank";
						element.rel = "noopener";
						element.textContent = text.replace(/(Created|Crafted) by\s+webhouse Digital/i, "Created by Timo Wilde");
						return;
					}

					element.innerHTML = 'Website created by <a href="https://wilde.cc" target="_blank" rel="noopener">Timo Wilde</a>';
				});
			})();
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'nocap_child_footer_credit_override', 100 );

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
		$logo_url    = $logo_url ? $logo_url : nocap_child_brand_logo_url();
		$hero_image  = wp_get_attachment_image_url( 6142, 'full' );
		$image_url   = $hero_image ? $hero_image : $logo_url;
		$email       = 'office@nocap-barbers.at';
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
				nocap_child_instagram_url(),
				nocap_child_tiktok_url(),
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

if ( ! function_exists( 'nocap_child_frontpage_local_business_schema' ) ) {
	function nocap_child_frontpage_local_business_schema() {
		if ( ! is_front_page() || ! nocap_child_has_primary_seo_plugin() ) {
			return;
		}

		$seo      = nocap_child_seo_data();
		$place_id = trailingslashit( $seo['site_url'] ) . '#barbershop';
		$schema   = array(
			'@context' => 'https://schema.org',
			'@type'    => array( 'Barbershop', 'LocalBusiness' ),
			'@id'      => $place_id,
			'name'     => 'NoCap Barbers',
			'url'      => $seo['site_url'],
			'telephone' => $seo['phone'],
			'email'    => $seo['email'],
			'priceRange' => $seo['price_range'],
			'image'    => $seo['image'],
			'logo'     => $seo['logo'],
			'address'  => array_merge( array( '@type' => 'PostalAddress' ), $seo['address'] ),
			'areaServed' => array(
				array(
					'@type' => 'City',
					'name'  => 'Wien',
				),
			),
			'hasMap'   => 'https://www.google.com/maps?q=Hoher+Markt+3,+1010+Wien',
			'sameAs'   => $seo['same_as'],
			'potentialAction' => array(
				'@type'  => 'ReserveAction',
				'target' => $seo['booking_url'],
				'name'   => 'Termin online buchen',
			),
			'makesOffer' => array(
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
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
}
add_action( 'wp_head', 'nocap_child_frontpage_local_business_schema', 35 );

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
