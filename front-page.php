<?php
/**
 * Front page redesign for NoCap Barbers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$booking_url           = 'https://buchung.treatwell.at/ort/no-cap-barbers/';
$booking_cta           = 'https://buchung.treatwell.at/ort/412028/menue/';
$instagram_url         = 'https://www.instagram.com/nocap.barbers';
$tiktok_url            = 'https://www.tiktok.com/@nocap.barbershop';
$google_reviews_url    = 'https://www.google.com/search?q=NoCap+Barbers+Wien';
$treatwell_reviews_url = 'https://www.treatwell.at/ort/no-cap-barbers/';
$map_embed_url         = 'https://www.google.com/maps?q=Hoher+Markt+3,+1010+Wien&output=embed';
$new_shop_map_embed_url = 'https://www.google.com/maps?q=Bauernmarkt+10,+1010+Wien&output=embed';
$asset_base_url        = get_stylesheet_directory_uri() . '/assets/images';
$about_video_url       = get_stylesheet_directory_uri() . '/assets/video/about-nocap-barber-best-barbershop-vienna.mp4';
$google_logo_url       = $asset_base_url . '/google.jpg';
$treatwell_logo_url    = $asset_base_url . '/treatwell.png';
$flag_de_url           = $asset_base_url . '/german.svg';
$flag_en_url           = $asset_base_url . '/english.svg';
$flag_ru_url           = $asset_base_url . '/russia.svg';
$flag_uk_url           = $asset_base_url . '/ukraine.svg';
$scissors_sound_url    = get_stylesheet_directory_uri() . '/assets/sound/scissors.mp3';
$scissors_volume       = '0.02';
$contact_email         = 'office@nocap-barbers.at';
$contact_phone         = '01 4374527';
$contact_phone_href    = 'tel:014374527';
$partners_section      = function_exists( 'nocap_child_partner_defaults' ) ? nocap_child_partner_defaults() : array( 'items' => array() );

$image_url = static function( $attachment_id, $size = 'full' ) {
	$url = wp_get_attachment_image_url( (int) $attachment_id, $size );
	return $url ? $url : '';
};

$media_url = static function( $attachment_id ) {
	$url = wp_get_attachment_url( (int) $attachment_id );
	return $url ? $url : '';
};

$product_image_url = static function( $product ) use ( $image_url ) {
	$image_id = isset( $product['image'] ) ? (int) $product['image'] : 0;
	$url      = $image_id ? $image_url( $image_id, 'large' ) : '';

	if ( ! $url && ! empty( $product['image_url'] ) ) {
		$url = $product['image_url'];
	}

	return function_exists( 'nocap_child_normalize_asset_url' ) ? nocap_child_normalize_asset_url( $url ) : $url;
};

$partner_logo_url = static function( $partner ) use ( $image_url ) {
	$logo_id = isset( $partner['logo'] ) ? (int) $partner['logo'] : 0;
	$url     = $logo_id ? $image_url( $logo_id, 'medium' ) : '';

	if ( ! $url && ! empty( $partner['logo_url'] ) ) {
		$url = $partner['logo_url'];
	}

	return function_exists( 'nocap_child_normalize_asset_url' ) ? nocap_child_normalize_asset_url( $url ) : $url;
};

$product_logo_url = static function( $product, $partners ) use ( $image_url, $partner_logo_url ) {
	$logo_id = isset( $product['logo'] ) ? (int) $product['logo'] : 0;
	$url     = $logo_id ? $image_url( $logo_id, 'medium' ) : '';

	if ( ! $url && ! empty( $product['logo_url'] ) ) {
		$url = $product['logo_url'];
	}

	if ( $url && function_exists( 'nocap_child_normalize_asset_url' ) ) {
		$url = nocap_child_normalize_asset_url( $url );
	}

	if ( $url || empty( $partners['items'] ) || empty( $product['title'] ) ) {
		return $url;
	}

	$title = strtolower( (string) $product['title'] );
	foreach ( $partners['items'] as $partner ) {
		$name = strtolower( (string) ( $partner['name'] ?? '' ) );
		if ( '' !== $name && ( false !== strpos( $title, $name ) || false !== strpos( $name, $title ) || ( false !== strpos( $title, 'keune' ) && false !== strpos( $name, 'keune' ) ) ) ) {
			return $partner_logo_url( $partner );
		}
	}

	return '';
};

$quote_image      = $image_url( 6103, 'large' );
$product_1_img    = $image_url( 5966, 'large' );
$product_2_img    = $image_url( 5941, 'large' );
$quote_media_attr = $quote_image ? ' style="--quote-image:url(' . esc_url( $quote_image ) . ');"' : '';

$service_items = array(
	array(
		'mark'   => 'Cut',
		'image'  => 6009,
		'title'  => 'Traditional Cut',
		'text'   => 'Der traditionelle Haarschnitt',
		'alt'    => 'Traditional Cut bei NoCap Barbers in Wien 1010',
	),
	array(
		'mark'   => 'Fade',
		'image'  => 6007,
		'title'  => 'Fade Cut',
		'text'   => 'Mit einem modernen Übergang',
		'alt'    => 'Fade Cut mit sauberem Übergang im Barber Shop Wien',
	),
	array(
		'mark'   => 'Bart',
		'image'  => 6008,
		'title'  => 'Beard Service',
		'text'   => 'Trimmen & Stylen nach Wunsch',
		'alt'    => 'Bart trimmen und stylen bei NoCap Barbers Wien',
	),
);

$team_members = array(
	array(
		'name'   => 'Dave',
		'role'   => 'Barber, Geschäftsführer',
		'image'  => 6121,
		'alt'    => 'Dave, Barber und Geschäftsführer bei NoCap Barbers Wien',
		'bio_de' => 'Dave war von Beginn an Teil von NoCap Barbers. Mit kreativen Ideen, sauberer Technik und echtem Servicegedanken hat er das Konzept mit aufgebaut und führt heute das Team mit klarer Qualitätsorientierung.',
	),
	array(
		'name'   => 'Steph',
		'role'   => 'Barber',
		'image'  => 6122,
		'alt'    => 'Steph, Barber bei NoCap Barbers am Hohen Markt Wien',
		'bio_de' => 'Steph verbindet sauberes Handwerk mit internationaler Erfahrung. Nach Stationen in verschiedenen Barbershops und einer Zeit in Kanada bringt er moderne und klassische Styles präzise auf den Punkt.',
	),
);

$gallery_video_1_url = get_stylesheet_directory_uri() . '/assets/video/gallery-barbershop-cuts-1.mp4';
$gallery_video_2_url = get_stylesheet_directory_uri() . '/assets/video/gallery-barbershop-cuts-2.mp4';
$gallery_media       = array(
	array( 'type' => 'image', 'id' => 6142, 'class' => 'nocap-gallery-item-xl', 'alt' => 'NoCap Barbers Shop in Wien mit modernem Barber Interior' ),
	array( 'type' => 'video', 'src' => $gallery_video_1_url, 'class' => 'nocap-gallery-item-video nocap-gallery-item-video-left', 'label' => 'Video aus dem NoCap Barbershop in Wien' ),
	array( 'type' => 'image', 'id' => 6143, 'class' => 'nocap-gallery-item-tall', 'alt' => 'Barber Arbeit bei NoCap Barbers am Hohen Markt' ),
	array( 'type' => 'image', 'id' => 6144, 'class' => 'nocap-gallery-item-wide', 'alt' => 'Herrenhaarschnitt und Styling im Barber Shop Wien' ),
	array( 'type' => 'image', 'id' => 6145, 'class' => 'nocap-gallery-item-medium', 'alt' => 'Detailaufnahme sauberer Barber Cut in 1010 Wien' ),
	array( 'type' => 'image', 'id' => 6146, 'class' => 'nocap-gallery-item-tall', 'alt' => 'Fade Cut Ergebnis bei NoCap Barbers' ),
	array( 'type' => 'video', 'src' => $gallery_video_2_url, 'class' => 'nocap-gallery-item-video nocap-gallery-item-video-right', 'label' => 'Video von Haarschnitt und Barber Service' ),
	array( 'type' => 'image', 'id' => 6147, 'class' => 'nocap-gallery-item-medium', 'alt' => 'Barbershop Stimmung bei NoCap Barbers Wien' ),
	array( 'type' => 'image', 'id' => 6148, 'class' => 'nocap-gallery-item-wide', 'alt' => 'Professioneller Herrenhaarschnitt in Wien Zentrum' ),
	array( 'type' => 'image', 'id' => 6149, 'class' => 'nocap-gallery-item-small', 'alt' => 'Barber Tools und Styling Details' ),
	array( 'type' => 'image', 'id' => 6150, 'class' => 'nocap-gallery-item-tall', 'alt' => 'NoCap Barbers Cut und Bartpflege' ),
	array( 'type' => 'image', 'id' => 6151, 'class' => 'nocap-gallery-item-medium', 'alt' => 'Moderner Barber Service in 1010 Wien' ),
	array( 'type' => 'image', 'id' => 6152, 'class' => 'nocap-gallery-item-wide', 'alt' => 'NoCap Barbers Galerie mit Shop und Schnitten' ),
);

$faq_items = array(
	array(
		'question' => 'Wo ist NoCap Barbers in Wien?',
		'answer'   => 'Sie finden uns am Hohen Markt 3 im 1. Bezirk, direkt im Zentrum von Wien.',
	),
	array(
		'question' => 'Kann ich online einen Termin buchen?',
		'answer'   => 'Ja. Termine für Haarschnitt, Fade Cut und Bartservice können direkt online über Treatwell gebucht werden.',
	),
	array(
		'question' => 'Welche Services bietet NoCap Barbers an?',
		'answer'   => 'Unser Fokus liegt auf Traditional Cuts, Fade Cuts, Bartpflege, Styling und ehrlicher Beratung für Herren.',
	),
);

$review_entries = array(
	array(
		'key'        => 'praezision',
		'label'      => 'Präzision',
		'headline'   => 'Saubere Linien, sauberes Finish.',
		'quote'      => 'Super Schnitt, super sauber, super nett!',
		'author'     => 'Thomas',
		'source_url' => 'https://www.treatwell.at/en/place/no-cap-barbers/',
	),
	array(
		'key'        => 'schnitt',
		'label'      => 'Schnitt',
		'headline'   => 'Starker Schnitt beginnt mit Zuhören.',
		'quote'      => 'A great barber doesn\'t just cut hair, they understand you.',
		'author'     => 'Noel',
		'source_url' => $treatwell_reviews_url,
	),
	array(
		'key'        => 'services',
		'label'      => 'Service',
		'headline'   => 'Der Ton bleibt so gut wie das Ergebnis.',
		'quote'      => 'Wie immer tolles Service und ein toller Haarschnitt.',
		'author'     => 'Michael',
		'source_url' => 'https://www.treatwell.at/ort/no-cap-barbers/bewertungen/seite-167/',
	),
);

$navigation_section = array(
	'home'     => 'Home',
	'services' => 'Service & Preise',
	'about'    => 'Über Uns',
	'gallery'  => 'Galerie',
	'team'     => 'Team',
	'faq'      => 'FAQ',
	'contact'  => 'Kontakt',
);

$homepage_content = function_exists( 'nocap_homepage_content' ) ? nocap_homepage_content( 'de' ) : array();

if ( ! empty( $homepage_content ) ) {
	$settings              = $homepage_content['settings'];
	$booking_url           = $settings['booking_url'];
	$booking_cta           = $settings['booking_cta'];
	$instagram_url         = $settings['instagram_url'];
	$tiktok_url            = ! empty( $settings['tiktok_url'] ) ? $settings['tiktok_url'] : $tiktok_url;
	$facebook_url          = $settings['facebook_url'];
	$google_reviews_url    = $settings['google_reviews_url'];
	$treatwell_reviews_url = $settings['treatwell_url'];
	$map_embed_url         = $settings['map_embed_url'];
	$contact_email         = $settings['email'];
	$contact_phone         = $settings['phone'];
	$contact_phone_href    = $settings['phone_href'];
	$google_logo_url       = $media_url( $settings['google_logo'] );
	$treatwell_logo_url    = $media_url( $settings['treatwell_logo'] );
	$google_logo_url       = $google_logo_url ? $google_logo_url : $asset_base_url . '/google.jpg';
	$treatwell_logo_url    = $treatwell_logo_url ? $treatwell_logo_url : $asset_base_url . '/treatwell.png';
	$flag_de_url           = $media_url( $settings['flag_de'] );
	$flag_en_url           = $media_url( $settings['flag_en'] );
	$flag_ru_custom        = ! empty( $settings['flag_ru'] ) ? $media_url( $settings['flag_ru'] ) : '';
	$flag_uk_custom        = ! empty( $settings['flag_uk'] ) ? $media_url( $settings['flag_uk'] ) : '';
	$scissors_sound_custom = ! empty( $settings['scissors_sound'] ) ? $media_url( $settings['scissors_sound'] ) : '';
	$flag_ru_url           = $flag_ru_custom ? $flag_ru_custom : $flag_ru_url;
	$flag_uk_url           = $flag_uk_custom ? $flag_uk_custom : $flag_uk_url;
	$scissors_sound_url    = $scissors_sound_custom ? $scissors_sound_custom : $scissors_sound_url;
	$scissors_volume       = isset( $settings['scissors_volume'] ) ? (string) $settings['scissors_volume'] : $scissors_volume;
	$hero                  = $homepage_content['hero'];
	$navigation_section    = ! empty( $homepage_content['navigation'] ) ? $homepage_content['navigation'] : $navigation_section;
	$hero['video_url']     = $media_url( isset( $hero['video'] ) ? $hero['video'] : 0 );
	$services_section      = $homepage_content['services'];
	$service_items         = $services_section['items'];
	$quote_section         = $homepage_content['quote'];
	$story_section         = $homepage_content['story'];
	$story_section['video_url'] = $media_url( isset( $story_section['video'] ) ? $story_section['video'] : 0 );
	$meaning_section       = $homepage_content['meaning'];
	$reviews_section       = $homepage_content['reviews'];
	$review_entries        = $reviews_section['items'];
	$products_section      = $homepage_content['products'];
	$partners_section      = ! empty( $homepage_content['partners'] ) && is_array( $homepage_content['partners'] ) ? $homepage_content['partners'] : $partners_section;
	$gallery_section       = $homepage_content['gallery'];
	$gallery_media         = $gallery_section['items'];
	$team_section          = $homepage_content['team'];
	$team_members          = $team_section['items'];
	$faq_section           = $homepage_content['faq'];
	$faq_items             = $faq_section['items'];
	$contact_section       = $homepage_content['contact'];
	$quote_image           = $image_url( (int) $quote_section['image'], 'large' );
	$quote_media_attr      = $quote_image ? ' style="--quote-image:url(' . esc_url( $quote_image ) . ');"' : '';
} else {
	$facebook_url     = 'https://www.facebook.com/NoCapBarbersVienna/';
	$hero             = array(
		'kicker'        => 'Barber Shop 1010 Wien',
		'title'         => 'NoCap Barber Shop',
		'lead'          => 'Wir sind NoCap Barbers, der neue Barbershop im Herzen Wiens! Bei uns finden Sie professionelle und moderne Haar- und Bartschnitte.',
		'primary_cta'   => 'Jetzt Termin sichern',
		'secondary_cta' => 'Kontakt',
		'proof_1'       => '3700+ Bewertungen',
		'proof_2'       => 'Hoher Markt 3, 1010 Wien',
		'proof_3'       => 'Montag bis Samstag geöffnet',
		'video_url'     => get_stylesheet_directory_uri() . '/assets/video/nocap-barbers-showcase-best-barber-shop-vienna.mp4',
	);
	$services_section = array(
		'kicker'    => 'Services',
		'title'     => 'Die wichtigsten Services auf einen Blick.',
		'cta_text'  => 'Direkt zu Preisen, Services und Online-Buchung.',
		'cta_label' => 'Service & Preise',
	);
	$quote_section    = array(
		'kicker'    => 'Anspruch',
		'title'     => '"Ich habe einen ganz einfachen Geschmack: Ich bin immer mit dem Besten zufrieden."',
		'author'    => 'Oscar Wilde',
		'meta'      => 'Passt zu unserem Handwerk',
		'caption_1' => 'Qualität ohne Theater.',
		'caption_2' => 'Saubere Arbeit. Klares Finish.',
	);
	$story_section    = array(
		'video_url'  => $about_video_url,
		'caption_1'  => 'Hoher Markt 3',
		'caption_2'  => '1010 Wien',
		'caption_3'  => 'NoCap Barbers',
		'title'      => 'Über Uns',
		'lead'       => 'NoCap Barbers steht für präzise Arbeit, ehrliche Beratung und eine Atmosphäre, die gleichzeitig entspannt und fokussiert ist.',
		'items'      => array(
			array( 'title' => 'Ein Barbershop mit Haltung', 'text' => 'Wir sind ein junges Team mit Energie, Blick fürs Detail und Respekt vor klassischem Handwerk.' ),
			array( 'title' => 'Beratung, die tragbar bleibt', 'text' => 'Ein guter Look muss nicht nur im Shop, sondern auch im Alltag funktionieren.' ),
			array( 'title' => 'Service ohne Showeffekte', 'text' => 'Entspannte Stimmung, klare Kommunikation und ein Team, das lieber solide abliefert als sich hinter großen Worten versteckt.' ),
		),
	);
	$meaning_section  = array(
		'title'  => 'Was bedeutet No Cap?',
		'text_1' => 'Der Ausdruck steht für Ehrlichkeit. Keine Übertreibung, keine Fassade, kein unnötiger Lärm.',
		'text_2' => 'Genau so verstehen wir unseren Shop: transparent in der Beratung, konsequent in der Qualität und aufmerksam in jedem Detail.',
	);
	$reviews_section  = array(
		'kicker'         => 'Rezensionen',
		'score'          => '4.9',
		'score_suffix'   => '/5',
		'score_note'     => '3700+ Rezensionen',
		'treatwell_meta' => '3000+ Treatwell Reviews',
		'google_meta'    => '700+ Google Reviews',
		'badge_copy'     => 'Termin direkt online sichern und den nächsten Cut bei uns buchen.',
		'badge_cta'      => 'Jetzt Termin buchen',
		'verified_label' => 'Verifizierte Bewertung',
		'title'          => 'Was Kunden über uns sagen',
	);
	$products_section = array(
		'title' => 'Partner denen wir vertrauen',
		'intro' => '',
		'items' => array(
			array( 'image' => 5966, 'number' => 'Styling', 'kicker' => 'Texture + Hold', 'title' => 'REUZEL', 'text' => 'Tradition aus Rotterdam mit modernen Styling-Ergebnissen. Ideal für Pompadour, Textur oder kontrolliertes Volumen.', 'points' => array( 'Clay, Pomade und Grooming Tonics', 'Starker Halt ohne steifes Finish', 'Ideal für strukturierte Styles' ) ),
			array( 'image' => 5941, 'number' => 'Pflege', 'kicker' => 'Care + Finish', 'title' => '1922 by J.M. Keune', 'text' => 'Pflege für Haare, Kopfhaut und Bart - entwickelt für saubere Routinen und lang haltbare Ergebnisse.', 'points' => array( 'Shampoo, Scalp und Beard Care', 'Sauberes, alltagstaugliches Pflege-System', 'Für sensible Kopfhaut und definierte Bärte' ) ),
			array( 'image_url' => get_stylesheet_directory_uri() . '/assets/images/new_products/proraso.jpg', 'number' => 'Rasur', 'kicker' => 'Shave + Beard', 'title' => 'PRORASO', 'text' => 'Italienische Barber-Klassiker für Rasur, Bart und Haut. Frisch, direkt und verlässlich, wenn Konturen sauber bleiben sollen.', 'points' => array( 'Pre-shave, Rasiercreme und Aftershave', 'Starker Standard für saubere Konturen', 'Bewährt für Bartpflege im Shop' ) ),
			array( 'image_url' => get_stylesheet_directory_uri() . '/assets/images/new_products/slick_gorilla.webp', 'number' => 'Textur', 'kicker' => 'Volume + Matte', 'title' => 'Slick Gorilla', 'text' => 'Moderne Texturprodukte für matte Looks mit Griff. Gut für lockere Styles, die leicht bleiben und trotzdem Form halten.', 'points' => array( 'Styling Powder, Clay und Sea Salt Finish', 'Volumen ohne schweres Produktgefühl', 'Ideal für messy, matte und natürliche Looks' ) ),
		),
	);
	$gallery_section  = array(
		'kicker'          => 'Galerie',
		'title'           => 'Blick in Shop, Schnitte und Stimmung.',
		'instagram_label' => 'Mehr Cuts auf Instagram',
		'instagram_handle' => '@nocap.barbers',
		'booking_label'   => 'Dein nächster Termin',
		'booking_strong'  => 'Jetzt online buchen',
	);
	$team_section     = array(
		'title'          => 'Team',
		'booking_kicker' => 'Nächster Cut',
		'booking_title'  => 'Termin sichern, Platz nehmen, frisch rausgehen.',
		'booking_text'   => 'Buchen Sie Ihren Wunschtermin direkt online.',
		'booking_label'  => 'Jetzt buchen',
	);
	$faq_section      = array(
		'kicker' => 'FAQ',
		'title'  => 'Barber Shop Wien: kurz beantwortet.',
	);
	$contact_section  = array(
		'title'       => 'Kontakt',
		'hours_label' => 'Öffnungszeiten',
		'phone_label' => 'Tel.',
		'address'     => 'Hoher Markt 3, 1010 Wien',
		'hours'       => array(
			array( 'day' => 'Montag - Mittwoch, Freitag', 'time' => '10:00 - 19:00' ),
			array( 'day' => 'Donnerstag', 'time' => '10:00 - 20:00' ),
			array( 'day' => 'Samstag', 'time' => '10:00 - 17:00' ),
			array( 'day' => 'Feiertage', 'time' => 'geschlossen' ),
		),
	);
}

$homepage_extension_defaults = function_exists( 'nocap_child_localize_extension_defaults' ) ? nocap_child_localize_extension_defaults( 'de' ) : array();
$hero_reviews                = isset( $homepage_extension_defaults['hero_reviews'] ) ? $homepage_extension_defaults['hero_reviews'] : array();
$hero_news                   = isset( $homepage_extension_defaults['hero_news'] ) ? $homepage_extension_defaults['hero_news'] : array();
$hero_news_enabled           = ! isset( $homepage_extension_defaults['settings']['hero_news_enabled'] ) || '0' !== (string) $homepage_extension_defaults['settings']['hero_news_enabled'];

if ( ! empty( $homepage_content['hero_reviews'] ) && is_array( $homepage_content['hero_reviews'] ) ) {
	$hero_reviews = array_replace_recursive( $hero_reviews, $homepage_content['hero_reviews'] );
}

if ( ! empty( $homepage_content['hero_news'] ) && is_array( $homepage_content['hero_news'] ) ) {
	$hero_news = array_replace_recursive( $hero_news, $homepage_content['hero_news'] );
}

$hero_news['image_url'] = ! empty( $hero_news['image'] ) ? $image_url( (int) $hero_news['image'], 'large' ) : '';

if ( isset( $homepage_content['settings']['hero_news_enabled'] ) ) {
	$hero_news_enabled = '0' !== (string) $homepage_content['settings']['hero_news_enabled'];
}

$new_shop_map_source = ! empty( $hero_news['cta_url'] ) ? $hero_news['cta_url'] : 'https://www.google.com/maps?q=' . rawurlencode( (string) ( $hero_news['address'] ?? 'Bauernmarkt 10, 1010 Wien' ) );
$new_shop_map_embed_url = add_query_arg( 'output', 'embed', $new_shop_map_source );
$contact_locations = array(
	array(
		'label' => 'NoCap Barbers Hoher Markt',
		'title' => 'NoCap Barbers am Hohen Markt 3 in 1010 Wien',
		'address' => $contact_section['address'],
		'map' => $map_embed_url,
	),
	array(
		'label' => 'NoCap Barbers Bauernmarkt',
		'title' => 'NoCap Barbers am Bauernmarkt 10 in 1010 Wien',
		'address' => ! empty( $hero_news['address'] ) ? $hero_news['address'] : 'Bauernmarkt 10, 1010 Wien',
		'map' => $new_shop_map_embed_url,
	),
);

foreach ( $gallery_media as $gallery_index => $gallery_item ) {
	if ( ! empty( $homepage_content ) && 'video' === ( $gallery_item['type'] ?? '' ) ) {
		$gallery_media[ $gallery_index ]['video_url'] = ! empty( $gallery_item['video'] ) ? $media_url( $gallery_item['video'] ) : '';
	}
	if ( empty( $homepage_content ) && isset( $gallery_item['video'] ) ) {
		$gallery_media[ $gallery_index ]['video_url'] = $media_url( $gallery_item['video'] );
	}
	if ( isset( $gallery_item['id'] ) && ! isset( $gallery_item['image'] ) ) {
		$gallery_media[ $gallery_index ]['image'] = $gallery_item['id'];
	}
	if ( isset( $gallery_item['src'] ) && ! isset( $gallery_item['video_url'] ) ) {
		$gallery_media[ $gallery_index ]['video_url'] = $gallery_item['src'];
	}
	if ( ! isset( $gallery_media[ $gallery_index ]['label'] ) ) {
		$gallery_media[ $gallery_index ]['label'] = isset( $gallery_item['alt'] ) ? $gallery_item['alt'] : '';
	}
}
?>

<main id="nocap-main" class="nocap-modern-home" role="main" data-flag-de="<?php echo esc_url( $flag_de_url ); ?>" data-flag-en="<?php echo esc_url( $flag_en_url ); ?>" data-flag-ru="<?php echo esc_url( $flag_ru_url ); ?>" data-flag-uk="<?php echo esc_url( $flag_uk_url ); ?>" data-scissors-sound="<?php echo esc_url( $scissors_sound_url ); ?>" data-scissors-volume="<?php echo esc_attr( $scissors_volume ); ?>" data-nav-home="<?php echo esc_attr( $navigation_section['home'] ); ?>" data-nav-services="<?php echo esc_attr( $navigation_section['services'] ); ?>" data-nav-about="<?php echo esc_attr( $navigation_section['about'] ); ?>" data-nav-gallery="<?php echo esc_attr( $navigation_section['gallery'] ); ?>" data-nav-team="<?php echo esc_attr( $navigation_section['team'] ); ?>" data-nav-faq="<?php echo esc_attr( $navigation_section['faq'] ); ?>" data-nav-contact="<?php echo esc_attr( $navigation_section['contact'] ); ?>">
	<section id="home" class="nocap-hero" aria-labelledby="nocap-hero-title">
		<div class="nocap-hero-media" data-reveal style="--reveal-delay: 0.12s;">
			<video id="nocap-hero-video" class="nocap-hero-video" autoplay muted loop playsinline preload="auto"><source src="<?php echo esc_url( $hero['video_url'] ); ?>" type="video/mp4"></video>
			<video class="nocap-hero-video nocap-hero-video-soft" aria-hidden="true" autoplay muted loop playsinline preload="auto"><source src="<?php echo esc_url( $hero['video_url'] ); ?>" type="video/mp4"></video>
			<div class="nocap-hero-overlay"></div>
		</div>
		<div class="nocap-shell"><div class="nocap-hero-copy">
			<div class="nocap-hero-language" data-nocap-language-switcher data-reveal aria-label="<?php esc_attr_e( 'Sprache wählen', 'salient-nocap-child' ); ?>"></div>
			<p class="nocap-kicker" data-reveal><?php echo esc_html( $hero['kicker'] ); ?></p>
			<h1 id="nocap-hero-title" data-reveal style="--reveal-delay: 0.08s;"><?php echo esc_html( $hero['title'] ); ?></h1>
			<p class="nocap-lead" data-reveal style="--reveal-delay: 0.16s;"><?php echo esc_html( $hero['lead'] ); ?></p>
			<div class="nocap-actions" data-reveal style="--reveal-delay: 0.24s;"><a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $hero['primary_cta'] ); ?></a><a class="nocap-btn nocap-btn-ghost" href="#kontakt"><?php echo esc_html( $hero['secondary_cta'] ); ?></a></div>
			<div class="nocap-hero-signal" data-reveal style="--reveal-delay: 0.3s;" aria-label="<?php echo esc_attr( $hero_reviews['label'] ); ?>">
				<a class="nocap-hero-reviews" href="<?php echo esc_url( $treatwell_reviews_url ); ?>" target="_blank" rel="noopener">
					<span class="nocap-hero-reviews-main"><span class="nocap-hero-stars" aria-hidden="true">★★★★★</span><strong><?php echo esc_html( $hero_reviews['score'] ); ?></strong></span>
					<span class="nocap-hero-reviews-foot"><span><?php echo esc_html( $hero_reviews['count'] ); ?> <?php echo esc_html( $hero_reviews['label'] ); ?></span><span class="nocap-hero-review-logos" aria-hidden="true"><?php if ( $treatwell_logo_url ) : ?><img src="<?php echo esc_url( $treatwell_logo_url ); ?>" alt="" loading="lazy"><?php endif; ?><?php if ( $google_logo_url ) : ?><img src="<?php echo esc_url( $google_logo_url ); ?>" alt="" loading="lazy"><?php endif; ?></span></span>
				</a>
			</div>
			<div class="nocap-proof" data-reveal style="--reveal-delay: 0.36s;"><span><?php echo esc_html( $hero['proof_2'] ); ?></span><span><?php echo esc_html( $hero['proof_3'] ); ?></span></div>
		</div></div>
	</section>

	<?php if ( $hero_news_enabled ) : ?>
	<section id="new-shop" class="nocap-section nocap-new-shop" aria-labelledby="nocap-new-shop-title">
		<div class="nocap-shell">
			<div class="nocap-new-shop-grid">
				<div class="nocap-new-shop-media">
					<?php if ( ! empty( $hero_news['image_url'] ) ) : ?>
						<img src="<?php echo esc_url( $hero_news['image_url'] ); ?>" alt="<?php echo esc_attr( $hero_news['title'] ); ?>" loading="eager" decoding="async">
					<?php endif; ?>
					<span class="nocap-new-shop-badge"><?php echo esc_html( $hero_news['badge'] ); ?></span>
				</div>
				<div class="nocap-new-shop-copy">
					<p class="nocap-kicker nocap-kicker-dark"><?php echo esc_html( $hero_news['kicker'] ); ?></p>
					<h2 id="nocap-new-shop-title" class="nocap-section-title"><?php echo esc_html( $hero_news['title'] ); ?></h2>
					<p class="nocap-new-shop-text"><?php echo esc_html( $hero_news['text'] ); ?></p>
					<div class="nocap-new-shop-details">
						<p class="nocap-new-shop-address"><?php echo esc_html( $hero_news['address'] ); ?></p>
						<?php if ( ! empty( $hero_news['meta'] ) ) : ?><p class="nocap-new-shop-meta"><?php echo esc_html( $hero_news['meta'] ); ?></p><?php endif; ?>
					</div>
					<?php if ( ! empty( $hero_news['cta_label'] ) && ! empty( $hero_news['cta_url'] ) ) : ?>
						<a class="nocap-btn nocap-btn-primary nocap-new-shop-cta" href="<?php echo esc_url( $hero_news['cta_url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $hero_news['cta_label'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section id="service" class="nocap-section nocap-services" aria-labelledby="nocap-service-title">
		<div class="nocap-shell"><div class="nocap-services-head"><div><p class="nocap-kicker nocap-kicker-dark" data-reveal><?php echo esc_html( $services_section['kicker'] ); ?></p><h2 id="nocap-service-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.04s;"><?php echo esc_html( $services_section['title'] ); ?></h2></div></div>
			<div class="nocap-services-grid"><div class="nocap-services-list">
				<?php foreach ( $service_items as $index => $service_item ) : ?>
					<article class="nocap-service-item" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.18 + ( $index * 0.06 ) ) ); ?>s;"><div class="nocap-service-visual"><?php echo wp_get_attachment_image( (int) $service_item['image'], 'large', false, array( 'class' => 'nocap-service-image', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $service_item['alt'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><div class="nocap-service-item-top"><span class="nocap-service-mark" aria-hidden="true"></span><div class="nocap-service-heading"><h3><?php echo esc_html( $service_item['title'] ); ?></h3></div></div><div class="nocap-service-body"><p><?php echo esc_html( $service_item['text'] ); ?></p></div></article>
				<?php endforeach; ?>
			</div><div class="nocap-services-cta" data-reveal style="--reveal-delay: 0.34s;"><p class="nocap-services-cta-line"><?php echo esc_html( $services_section['cta_text'] ); ?></p><a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $services_section['cta_label'] ); ?></a></div></div>
		</div>
	</section>

	<section class="nocap-section nocap-quote" aria-labelledby="nocap-quote-title"><div class="nocap-shell"><div class="nocap-quote-grid"><div class="nocap-quote-copy"><p class="nocap-kicker" data-reveal><?php echo esc_html( $quote_section['kicker'] ); ?></p><h2 id="nocap-quote-title" data-reveal style="--reveal-delay: 0.04s;"><?php echo esc_html( $quote_section['title'] ); ?></h2><div class="nocap-quote-meta" data-reveal style="--reveal-delay: 0.1s;"><span><?php echo esc_html( $quote_section['author'] ); ?></span><span><?php echo esc_html( $quote_section['meta'] ); ?></span></div></div><div class="nocap-quote-stage" data-reveal style="--reveal-delay: 0.14s;"><div class="nocap-quote-media"<?php echo $quote_media_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div><div class="nocap-quote-caption"><span><?php echo esc_html( $quote_section['caption_1'] ); ?></span><span><?php echo esc_html( $quote_section['caption_2'] ); ?></span></div></div></div></div></section>

	<section id="uber-uns" class="nocap-section" aria-labelledby="nocap-story-title"><div class="nocap-shell"><div class="nocap-story-grid"><div class="nocap-story-media-column" data-reveal><div class="nocap-story-video-wrap"><video class="nocap-story-video" autoplay muted loop playsinline preload="auto"><source src="<?php echo esc_url( $story_section['video_url'] ); ?>" type="video/mp4"></video></div><div class="nocap-story-video-caption" aria-hidden="true"><span><?php echo esc_html( $story_section['caption_1'] ); ?></span><span><?php echo esc_html( $story_section['caption_2'] ); ?></span><span><?php echo esc_html( $story_section['caption_3'] ); ?></span></div></div><div class="nocap-story-copy-column"><h2 id="nocap-story-title" class="nocap-section-title" data-reveal><?php echo esc_html( $story_section['title'] ); ?></h2><p class="nocap-section-intro nocap-story-lead" data-reveal style="--reveal-delay: 0.08s;"><?php echo esc_html( $story_section['lead'] ); ?></p><div class="nocap-story-flow nocap-story-flow-editorial"><?php foreach ( $story_section['items'] as $story_index => $story_item ) : ?><article class="nocap-story-node nocap-story-node-feature" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.14 + ( $story_index * 0.06 ) ) ); ?>s;"><span class="nocap-story-index" aria-hidden="true"></span><div class="nocap-story-node-copy"><h3><?php echo esc_html( $story_item['title'] ); ?></h3><p><?php echo esc_html( $story_item['text'] ); ?></p></div></article><?php endforeach; ?></div></div></div></div></section>

	<section class="nocap-section nocap-meaning-section" aria-labelledby="nocap-meaning-title"><div class="nocap-shell"><div class="nocap-meaning-section-grid"><div class="nocap-meaning-section-title" data-reveal><h2 id="nocap-meaning-title"><?php echo esc_html( $meaning_section['title'] ); ?></h2></div><div class="nocap-meaning-section-copy" data-reveal style="--reveal-delay: 0.08s;"><p><?php echo esc_html( $meaning_section['text_1'] ); ?></p><p><?php echo esc_html( $meaning_section['text_2'] ); ?></p></div><div class="nocap-meaning-section-mark" aria-hidden="true" data-reveal style="--reveal-delay: 0.14s;"><span>NO</span><span>CAP</span></div></div></div></section>

	<section id="google" class="nocap-section nocap-reviews" aria-labelledby="nocap-reviews-title"><div class="nocap-shell"><div class="nocap-review-layout" data-reveal><aside class="nocap-review-badge" data-reveal style="--reveal-delay: 0.04s;" aria-label="Bewertungsquellen und Kennzahlen"><div class="nocap-review-ledger"><p class="nocap-review-ledger-kicker"><?php echo esc_html( $reviews_section['kicker'] ); ?></p><div class="nocap-review-scoreboard"><p class="nocap-review-score"><span class="nocap-review-score-value"><?php echo esc_html( $reviews_section['score'] ); ?></span><span class="nocap-review-score-max"><?php echo esc_html( $reviews_section['score_suffix'] ); ?></span> <span class="nocap-review-star" aria-hidden="true">&#9733;</span></p><p class="nocap-review-score-note"><?php echo esc_html( $reviews_section['score_note'] ); ?></p></div><div class="nocap-review-source-list"><a class="nocap-review-source" href="<?php echo esc_url( $treatwell_reviews_url ); ?>" target="_blank" rel="noopener"><span class="nocap-review-source-badge" aria-hidden="true"><?php if ( $treatwell_logo_url ) : ?><img src="<?php echo esc_url( $treatwell_logo_url ); ?>" alt="" loading="lazy"><?php endif; ?></span><span class="nocap-review-source-copy-wrap"><span class="nocap-review-source-name">Treatwell</span><span class="nocap-review-source-meta"><?php echo esc_html( $reviews_section['treatwell_meta'] ); ?></span></span></a><a class="nocap-review-source" href="<?php echo esc_url( $google_reviews_url ); ?>" target="_blank" rel="noopener"><span class="nocap-review-source-badge" aria-hidden="true"><?php if ( $google_logo_url ) : ?><img src="<?php echo esc_url( $google_logo_url ); ?>" alt="" loading="lazy"><?php endif; ?></span><span class="nocap-review-source-copy-wrap"><span class="nocap-review-source-name">Google</span><span class="nocap-review-source-meta"><?php echo esc_html( $reviews_section['google_meta'] ); ?></span></span></a></div><div class="nocap-review-proofline" aria-hidden="true"><span></span><span></span><span></span></div></div><div class="nocap-review-badge-cta"><p class="nocap-review-badge-copy"><?php echo esc_html( $reviews_section['badge_copy'] ); ?></p><a class="nocap-review-booking" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener"><span><?php echo esc_html( $reviews_section['badge_cta'] ); ?></span><span class="nocap-review-booking-arrow" aria-hidden="true">&rarr;</span></a></div></aside><div class="nocap-review-content"><h2 id="nocap-reviews-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.08s;"><?php echo esc_html( $reviews_section['title'] ); ?></h2><div class="nocap-review-switch" data-reveal style="--reveal-delay: 0.26s;" role="tablist" aria-label="Bewertungsfokus"><?php foreach ( $review_entries as $review_index => $review_entry ) : ?><button class="nocap-review-chip<?php echo 0 === $review_index ? ' is-active' : ''; ?>" type="button" role="tab" aria-selected="<?php echo 0 === $review_index ? 'true' : 'false'; ?>" data-review-tab="<?php echo esc_attr( $review_entry['key'] ); ?>"><?php echo esc_html( $review_entry['label'] ); ?></button><?php endforeach; ?></div><div class="nocap-review-stream" data-reveal style="--reveal-delay: 0.32s;"><?php foreach ( $review_entries as $review_index => $review_entry ) : ?><a class="nocap-review-quote<?php echo 0 === $review_index ? ' is-active' : ''; ?>" role="tabpanel" aria-hidden="<?php echo 0 === $review_index ? 'false' : 'true'; ?>" data-review-panel="<?php echo esc_attr( $review_entry['key'] ); ?>" href="<?php echo esc_url( $review_entry['source_url'] ); ?>" target="_blank" rel="noopener"><p class="nocap-review-panel-label"><?php echo esc_html( $review_entry['headline'] ); ?></p><blockquote class="nocap-review-quote-copy"><p>&ldquo;<?php echo esc_html( $review_entry['quote'] ); ?>&rdquo;</p></blockquote><div class="nocap-review-meta"><p class="nocap-review-author"><?php echo esc_html( $review_entry['author'] ); ?></p><span class="nocap-review-verified"><span class="nocap-review-verified-icon" aria-hidden="true">&#10003;</span><?php echo esc_html( $reviews_section['verified_label'] ); ?></span></div></a><?php endforeach; ?></div></div></div></div></section>

	<section id="products" class="nocap-section nocap-products" aria-labelledby="nocap-products-title"><div class="nocap-shell"><div class="nocap-products-head"><h2 id="nocap-products-title" class="nocap-section-title" data-reveal><?php echo esc_html( $products_section['title'] ); ?></h2><?php if ( ! empty( $products_section['intro'] ) ) : ?><p class="nocap-section-intro" data-reveal style="--reveal-delay: 0.08s;"><?php echo esc_html( $products_section['intro'] ); ?></p><?php endif; ?></div><?php if ( ! empty( $partners_section['items'] ) ) : ?><div class="nocap-partner-runner" data-reveal style="--reveal-delay: 0.1s;" aria-label="NoCap Barbers Partner"><div class="nocap-partner-track"><?php for ( $partner_loop = 0; $partner_loop < 2; $partner_loop++ ) : foreach ( $partners_section['items'] as $partner ) : $partner_logo = $partner_logo_url( $partner ); if ( ! $partner_logo ) { continue; } ?><a class="nocap-partner-logo" href="<?php echo esc_url( $partner['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $partner['name'] ); ?>"><img src="<?php echo esc_url( $partner_logo ); ?>" alt="<?php echo esc_attr( $partner['name'] ); ?>" loading="lazy" decoding="async"></a><?php endforeach; endfor; ?></div></div><?php endif; ?><div class="nocap-products-atlas"><?php foreach ( $products_section['items'] as $product_index => $product ) : $product_img = $product_image_url( $product ); $product_logo = $product_logo_url( $product, $partners_section ); ?><article class="nocap-product-feature<?php echo 1 === $product_index % 2 ? ' nocap-product-feature-alt' : ''; ?>" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.14 + ( $product_index * 0.06 ) ) ); ?>s;"><div class="nocap-product-media" style="--product-image:url(<?php echo esc_url( $product_img ); ?>);"><span class="nocap-product-number"><?php echo esc_html( $product['number'] ); ?></span></div><div class="nocap-product-copy"><?php if ( $product_logo ) : ?><span class="nocap-product-copy-logo"><img src="<?php echo esc_url( $product_logo ); ?>" alt="" loading="lazy" decoding="async"></span><?php endif; ?><p class="nocap-product-kicker"><?php echo esc_html( $product['kicker'] ); ?></p><h3><?php echo esc_html( $product['title'] ); ?></h3><p><?php echo esc_html( $product['text'] ); ?></p><ul class="nocap-product-points" aria-label="<?php echo esc_attr( $product['title'] ); ?> Highlights"><?php foreach ( $product['points'] as $point ) : ?><li><?php echo esc_html( $point ); ?></li><?php endforeach; ?></ul></div></article><?php endforeach; ?></div></div></section>

	<section id="gallerie" class="nocap-section" aria-labelledby="nocap-gallery-title"><div class="nocap-shell"><div class="nocap-gallery-head"><div><p class="nocap-kicker nocap-kicker-dark" data-reveal><?php echo esc_html( $gallery_section['kicker'] ); ?></p><h2 id="nocap-gallery-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.04s;"><?php echo esc_html( $gallery_section['title'] ); ?></h2></div></div><div class="nocap-gallery-wall" aria-label="NoCap Barbers Galerie"><?php foreach ( $gallery_media as $gallery_index => $gallery_item ) : ?><figure class="<?php echo esc_attr( 'nocap-gallery-item ' . $gallery_item['class'] ); ?>" data-reveal data-reveal-style="<?php echo esc_attr( 0 === $gallery_index % 3 ? 'scale' : ( 1 === $gallery_index % 3 ? 'tilt' : 'lift' ) ); ?>" style="--reveal-delay: <?php echo esc_attr( (string) ( ( $gallery_index % 5 ) * 0.045 ) ); ?>s;"><?php if ( 'video' === $gallery_item['type'] ) : ?><video class="nocap-gallery-video" aria-label="<?php echo esc_attr( $gallery_item['label'] ); ?>" autoplay muted loop playsinline preload="metadata"><source src="<?php echo esc_url( $gallery_item['video_url'] ); ?>" type="video/mp4"></video><?php else : ?><?php echo wp_get_attachment_image( (int) $gallery_item['image'], 'large', false, array( 'class' => 'nocap-gallery-image', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $gallery_item['alt'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php endif; ?></figure><?php endforeach; ?></div><div class="nocap-gallery-cta-row" data-reveal style="--reveal-delay: 0.12s;" aria-label="Galerie Aktionen"><a class="nocap-gallery-cta nocap-gallery-cta-instagram" href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener"><span class="nocap-gallery-cta-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4Zm0 2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7Zm5 3.5A3.5 3.5 0 1 1 8.5 12 3.5 3.5 0 0 1 12 8.5Zm0 2A1.5 1.5 0 1 0 13.5 12 1.5 1.5 0 0 0 12 10.5Zm4.75-3.25a1 1 0 1 1-1 1 1 1 0 0 1 1-1Z" fill="currentColor"/></svg></span><span class="nocap-gallery-cta-copy"><span><?php echo esc_html( $gallery_section['instagram_label'] ); ?></span><strong><?php echo esc_html( $gallery_section['instagram_handle'] ); ?></strong></span></a><a class="nocap-gallery-cta nocap-gallery-cta-booking" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener"><span class="nocap-gallery-cta-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M7 2h2v2h6V2h2v2h2.5A2.5 2.5 0 0 1 22 6.5v12A2.5 2.5 0 0 1 19.5 21h-15A2.5 2.5 0 0 1 2 18.5v-12A2.5 2.5 0 0 1 4.5 4H7V2Zm12.5 8h-15v8.5c0 .28.22.5.5.5h14c.28 0 .5-.22.5-.5V10ZM5 6c-.28 0-.5.22-.5.5V8h15V6.5c0-.28-.22-.5-.5-.5H5Zm3 7h3v3H8v-3Z" fill="currentColor"/></svg></span><span class="nocap-gallery-cta-copy"><span><?php echo esc_html( $gallery_section['booking_label'] ); ?></span><strong><?php echo esc_html( $gallery_section['booking_strong'] ); ?></strong></span></a></div></div></section>

	<section id="team" class="nocap-section" aria-labelledby="nocap-team-title"><div class="nocap-shell"><div class="nocap-team-head"><h2 id="nocap-team-title" class="nocap-section-title" data-reveal><?php echo esc_html( $team_section['title'] ); ?></h2></div><div class="nocap-team-roster"><?php foreach ( $team_members as $index => $member ) : ?><article class="nocap-team-person" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.08 + ( $index * 0.08 ) ) ); ?>s;"><div class="nocap-team-photo-wrap"><?php echo wp_get_attachment_image( (int) $member['image'], 'large', false, array( 'class' => 'nocap-team-photo', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $member['alt'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div><div class="nocap-team-copy"><h3><?php echo esc_html( $member['name'] ); ?></h3><p class="nocap-team-role"><?php echo esc_html( $member['role'] ); ?></p><p><?php echo esc_html( isset( $member['bio'] ) ? $member['bio'] : $member['bio_de'] ); ?></p></div></article><?php endforeach; ?></div><div class="nocap-booking-strip" data-reveal style="--reveal-delay: 0.24s;"><div><p class="nocap-booking-kicker"><?php echo esc_html( $team_section['booking_kicker'] ); ?></p><h3><?php echo esc_html( $team_section['booking_title'] ); ?></h3><p><?php echo esc_html( $team_section['booking_text'] ); ?></p></div><a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $team_section['booking_label'] ); ?></a></div></div></section>

	<section id="faq" class="nocap-section nocap-faq" aria-labelledby="nocap-faq-title"><div class="nocap-shell"><div class="nocap-faq-grid"><div class="nocap-faq-heading"><p class="nocap-kicker nocap-kicker-dark" data-reveal><?php echo esc_html( $faq_section['kicker'] ); ?></p><h2 id="nocap-faq-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.04s;"><?php echo esc_html( $faq_section['title'] ); ?></h2></div><div class="nocap-faq-list"><?php foreach ( $faq_items as $faq_index => $faq_item ) : ?><article class="nocap-faq-item" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.1 + ( $faq_index * 0.06 ) ) ); ?>s;"><h3><?php echo esc_html( $faq_item['question'] ); ?></h3><p><?php echo esc_html( $faq_item['answer'] ); ?></p></article><?php endforeach; ?></div></div></div></section>

	<section id="kontakt" class="nocap-section nocap-contact" aria-labelledby="nocap-contact-title"><div class="nocap-shell"><div class="nocap-contact-grid"><div class="nocap-map-stack" data-reveal><?php foreach ( $contact_locations as $location ) : ?><article class="nocap-map"><iframe src="<?php echo esc_url( $location['map'] ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php echo esc_attr( $location['title'] ); ?>"></iframe><div class="nocap-map-caption"><strong><?php echo esc_html( $location['label'] ); ?></strong><span><?php echo esc_html( $location['address'] ); ?></span></div></article><?php endforeach; ?></div><div class="nocap-contact-card" data-reveal style="--reveal-delay: 0.1s;"><h2 id="nocap-contact-title"><?php echo esc_html( $contact_section['title'] ); ?></h2><ul class="nocap-hours" aria-label="<?php echo esc_attr( $contact_section['hours_label'] ); ?>"><?php foreach ( $contact_section['hours'] as $hours_item ) : ?><li><span><?php echo esc_html( $hours_item['day'] ); ?></span><strong><?php echo esc_html( $hours_item['time'] ); ?></strong></li><?php endforeach; ?></ul><div class="nocap-contact-links"><a href="<?php echo esc_attr( $contact_phone_href ); ?>"><?php echo esc_html( $contact_section['phone_label'] ); ?>: <?php echo esc_html( $contact_phone ); ?></a><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a><?php foreach ( $contact_locations as $location ) : ?><span><?php echo esc_html( $location['address'] ); ?></span><?php endforeach; ?></div><div class="nocap-social" aria-label="Social links"><a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><span class="nocap-social-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M13.5 9H15V6h-1.8C10.98 6 10 7.13 10 8.8V10H8v3h2v7h3v-7h2.1l.4-3H13v-.8c0-.7.2-1.2 1.5-1.2Z" fill="currentColor"/></svg></span></a><a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><span class="nocap-social-icon" aria-hidden="true"><svg viewBox="0 0 24 24" role="presentation" focusable="false"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4Zm0 2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H7Zm5 3.5A3.5 3.5 0 1 1 8.5 12 3.5 3.5 0 0 1 12 8.5Zm0 2A1.5 1.5 0 1 0 13.5 12 1.5 1.5 0 0 0 12 10.5Zm4.75-3.25a1 1 0 1 1-1 1 1 1 0 0 1 1-1Z" fill="currentColor"/></svg></span></a></div></div></div></div></section>
</main>

<?php
get_footer();
