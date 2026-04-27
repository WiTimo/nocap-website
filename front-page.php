<?php
/**
 * Front page redesign for NoCap Barbers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$booking_url       = 'https://buchung.treatwell.at/ort/no-cap-barbers/';
$booking_cta       = 'https://buchung.treatwell.at/ort/412028/menue/';
$google_reviews_url = 'https://www.google.com/search?q=NoCap+Barbers+Wien';
$treatwell_reviews_url = 'https://www.treatwell.at/ort/no-cap-barbers/';
$map_embed_url     = 'https://www.google.com/maps?q=Hoher+Markt+3,+1010+Wien&output=embed';
$asset_base_url    = get_stylesheet_directory_uri() . '/assets/images';
$about_video_url   = get_stylesheet_directory_uri() . '/assets/video/about-us.mp4';
$google_logo_url   = $asset_base_url . '/google.jpg';
$treatwell_logo_url = $asset_base_url . '/treatwell.png';
$host              = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
$contact_email     = ( 'nocap-barbers.local' === $host ) ? 'office@nocap-barbers.local' : 'office@nocap-barbers.at';
$contact_phone     = '01 4374527';
$contact_phone_href = 'tel:014374527';

$image_url = static function( $attachment_id, $size = 'full' ) {
	$url = wp_get_attachment_image_url( (int) $attachment_id, $size );
	return $url ? $url : '';
};

$hero_image    = $image_url( 6100, 'full' );
$quote_image   = $image_url( 6103, 'large' );
$product_1_img = $image_url( 5966, 'large' );
$product_2_img = $image_url( 5941, 'large' );

$service_items = array(
	array(
		'number'  => '01',
		'image'   => 6009,
		'title'   => 'Traditional Cut',
		'kicker'  => 'Klassisch sauber',
		'text'    => 'Der traditionelle Haarschnitt',
	),
	array(
		'number'  => '02',
		'image'   => 6007,
		'title'   => 'Fade Cut',
		'kicker'  => 'Modern und definiert',
		'text'    => 'Mit einem modernen übergang',
	),
	array(
		'number'  => '03',
		'image'   => 6008,
		'title'   => 'Beard Service',
		'kicker'  => 'Kontur und Struktur',
		'text'    => 'Trimmen & Stylen nach Wunsch',
	),
);

$team_members = array(
	array(
		'name'   => 'Dave',
		'role'   => 'Barber, Geschäftsführer',
		'image'  => 6121,
		'bio_de' => 'Dave war von Beginn an Teil von NoCap Barbers. Mit kreativen Ideen, sauberer Technik und echtem Servicegedanken hat er das Konzept mit aufgebaut und führt heute das Team mit klarer Qualitätsorientierung.',
		'bio_en' => 'Dave has been part of NoCap Barbers from day one. With strong technical work, creativity and a clear service mindset, he helped shape the concept and now leads the team.',
	),
	array(
		'name'   => 'Steph',
		'role'   => 'Barber',
		'image'  => 6122,
		'bio_de' => 'Steph verbindet sauberes Handwerk mit internationaler Erfahrung. Nach Stationen in verschiedenen Barbershops und einer Zeit in Kanada bringt er moderne und klassische Styles präzise auf den Punkt.',
		'bio_en' => 'Steph combines clean craftsmanship with international experience. After working in several barbershops and in Canada, he delivers modern and classic cuts with precision.',
	),
);

$gallery_ids = array( 6142, 6143, 6144, 6145, 6146, 6147, 6148, 6149, 6150, 6151, 6152 );

$review_entries = array(
	array(
		'key'         => 'praezision',
		'label'       => 'Praezision',
		'headline'    => 'Saubere Linien, sauberes Finish.',
		'quote'       => 'Super Schnitt, super sauber, super nett!',
		'author'      => 'Thomas',
		'service'     => 'Men\'s Haircut',
		'relative'    => 'Verifizierte Bewertung auf Treatwell',
		'source_name' => 'Treatwell',
		'source_url'  => 'https://www.treatwell.at/en/place/no-cap-barbers/',
		'tags'        => array( 'sauber', 'praezise', 'freundlich' ),
	),
	array(
		'key'         => 'schnitt',
		'label'       => 'Schnitt',
		'headline'    => 'Starker Schnitt beginnt mit Zuhoeren.',
		'quote'       => 'A great barber doesn\'t just cut hair, they understand you.',
		'author'      => 'Noel',
		'service'     => 'Men\'s Haircut',
		'relative'    => 'Verifizierte Bewertung auf Treatwell',
		'source_name' => 'Treatwell',
		'source_url'  => $treatwell_reviews_url,
		'tags'        => array( 'verstaendnis', 'stilgefuehl', 'konstanz' ),
	),
	array(
		'key'         => 'services',
		'label'       => 'Service',
		'headline'    => 'Der Ton bleibt so gut wie das Ergebnis.',
		'quote'       => 'Wie immer tolles Service und ein toller Haarschnitt.',
		'author'      => 'Michael',
		'service'     => 'Herrenhaarschnitt',
		'relative'    => 'Verifizierte Bewertung auf Treatwell',
		'source_name' => 'Treatwell',
		'source_url'  => 'https://www.treatwell.at/ort/no-cap-barbers/bewertungen/seite-167/',
		'tags'        => array( 'service', 'qualitaet', 'wiederkehr' ),
	),
);

$hero_media_attr   = $hero_image ? ' style="--hero-image:url(' . esc_url( $hero_image ) . ');"' : '';
$quote_media_attr  = $quote_image ? ' style="--quote-image:url(' . esc_url( $quote_image ) . ');"' : '';
$product_stage_attr = $product_1_img ? ' style="--active-image:url(' . esc_url( $product_1_img ) . ');"' : '';

?>

<main id="nocap-main" class="nocap-modern-home" role="main">

	<section id="home" class="nocap-hero" aria-labelledby="nocap-hero-title">
		<div class="nocap-hero-media" data-reveal style="--reveal-delay: 0.12s;">
			<video id="nocap-hero-video" class="nocap-hero-video" autoplay muted loop playsinline preload="auto"
				data-src-desktop="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/video/hero-bg.mp4' ); ?>"
				data-src-mobile="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/video/hero-bg-mobile.mp4' ); ?>">
				<source src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/video/hero-bg.mp4' ); ?>" type="video/mp4">
				<?php esc_html_e( 'Your browser does not support the video tag.', 'salient-nocap-child' ); ?>
			</video>
			<div class="nocap-hero-overlay"></div>
		</div>
		<div class="nocap-shell">
			<div class="nocap-hero-copy">
				<p class="nocap-kicker" data-reveal>Barber Shop 1010 Wien</p>
				<h1 id="nocap-hero-title" data-reveal style="--reveal-delay: 0.08s;">NoCap Barber Shop</h1>
				<p class="nocap-lead" data-reveal style="--reveal-delay: 0.16s;">Wir sind NoCap Barbers, der neue Barbershop im Herzen Wiens! Bei uns finden Sie professionelle und moderne Haar- und Bartschnitte.</p>
				<div class="nocap-actions" data-reveal style="--reveal-delay: 0.24s;">
					<a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener">Online Booking</a>
					<a class="nocap-btn nocap-btn-ghost" href="#kontakt">Kontakt</a>
				</div>
				<div class="nocap-proof" data-reveal style="--reveal-delay: 0.3s;">
					<span>3700+ Bewertungen</span>
					<span>Hoher Markt 3, 1010 Wien</span>
					<span>Montag bis Samstag geöffnet</span>
				</div>
			</div>
		</div>
	</section>

	<section id="service" class="nocap-section nocap-services" aria-labelledby="nocap-service-title">
		<div class="nocap-shell">
			<div class="nocap-services-head">
				<div>
					<p class="nocap-kicker nocap-kicker-dark" data-reveal>Services</p>
					<h2 id="nocap-service-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.04s;">Die wichtigsten Services auf einen Blick.</h2>
				</div>
				<div class="nocap-services-summary" data-reveal style="--reveal-delay: 0.1s;">
					<p>Klassisch, modern oder Bartservice: schnell erfassbar, klar beschrieben und direkt buchbar.</p>
				</div>
			</div>

			<div class="nocap-services-grid">
				<div class="nocap-services-list">
					<?php foreach ( $service_items as $index => $service_item ) : ?>
						<article class="nocap-service-item" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) ( 0.18 + ( $index * 0.06 ) ) ); ?>s;">
							<?php
							$service_image = wp_get_attachment_image(
								(int) $service_item['image'],
								'large',
								false,
								array(
									'class'    => 'nocap-service-image',
									'loading'  => 'lazy',
									'decoding' => 'async',
								)
							);
							?>
							<div class="nocap-service-visual">
								<?php if ( ! empty( $service_image ) ) : ?>
									<?php echo $service_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php endif; ?>
							</div>
							<div class="nocap-service-item-top">
								<span class="nocap-service-number"><?php echo esc_html( $service_item['number'] ); ?></span>
								<div class="nocap-service-heading">
									<h3 class="nocap-service-kicker"><?php echo esc_html( $service_item['title'] ); ?></h3>
								</div>
							</div>
							<div class="nocap-service-body">
								<p><?php echo esc_html( $service_item['text'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<div class="nocap-services-cta" data-reveal style="--reveal-delay: 0.34s;">
					<p class="nocap-services-cta-line">Direkt zu Preisen, Services und Online-Buchung.</p>
					<a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_url ); ?>" target="_blank" rel="noopener">Service &amp; Preise</a>
				</div>
			</div>
		</div>
	</section>

	<section class="nocap-section nocap-quote" aria-labelledby="nocap-quote-title">
		<div class="nocap-shell">
			<div class="nocap-quote-grid">
				<div class="nocap-quote-copy">
					<p class="nocap-kicker" data-reveal>Anspruch</p>
					<h2 id="nocap-quote-title" data-reveal style="--reveal-delay: 0.04s;">"Ich habe einen ganz einfachen Geschmack: Ich bin immer mit dem Besten zufrieden."</h2>
					<div class="nocap-quote-meta" data-reveal style="--reveal-delay: 0.1s;">
						<span>Oscar Wilde</span>
						<span>Passt zu unserem Handwerk</span>
					</div>
				</div>
				<div class="nocap-quote-stage" data-reveal style="--reveal-delay: 0.14s;">
					<div class="nocap-quote-media"<?php echo $quote_media_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
					<div class="nocap-quote-caption">
						<span>Qualitaet ohne Theater.</span>
						<span>Saubere Arbeit. Klares Finish.</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="uber-uns" class="nocap-section" aria-labelledby="nocap-story-title">
		<div class="nocap-shell">
			<div class="nocap-story-grid">
				<div class="nocap-story-media-column" data-reveal>
					<div class="nocap-story-video-wrap">
						<video class="nocap-story-video" autoplay muted loop playsinline preload="auto">
							<source src="<?php echo esc_url( $about_video_url ); ?>" type="video/mp4">
							<?php esc_html_e( 'Your browser does not support the video tag.', 'salient-nocap-child' ); ?>
						</video>
					</div>
					<div class="nocap-story-video-caption" aria-hidden="true">
						<span>Hoher Markt 3</span>
						<span>1010 Wien</span>
						<span>NoCap Barbers</span>
					</div>
				</div>
				<div class="nocap-story-copy-column">
					<h2 id="nocap-story-title" class="nocap-section-title" data-reveal>Über Uns</h2>
					<p class="nocap-section-intro nocap-story-lead" data-reveal style="--reveal-delay: 0.08s;">NoCap Barbers steht fuer praezise Arbeit, ehrliche Beratung und eine Atmosphaere, die gleichzeitig entspannt und fokussiert ist. Wir glauben nicht an laute Versprechen, sondern an saubere Linien, gute Gespraeche und Ergebnisse, die auch nach Tagen noch stark aussehen.</p>
					<div class="nocap-story-flow nocap-story-flow-editorial">
						<article class="nocap-story-node nocap-story-node-feature" data-reveal style="--reveal-delay: 0.14s;">
							<span class="nocap-story-index">01</span>
							<div class="nocap-story-node-copy">
								<h3>Ein Barbershop mit Haltung</h3>
								<p>Wir sind ein junges Team mit Energie, Blick fuers Detail und Respekt vor klassischem Handwerk. Daraus entsteht ein Stil, der modern wirkt, aber nicht beliebig aussieht.</p>
							</div>
						</article>
						<article class="nocap-story-node nocap-story-node-feature" data-reveal style="--reveal-delay: 0.2s;">
							<span class="nocap-story-index">02</span>
							<div class="nocap-story-node-copy">
								<h3>Beratung, die tragbar bleibt</h3>
								<p>Ein guter Look muss nicht nur im Shop, sondern auch im Alltag funktionieren. Darum schauen wir auf Kopfform, Stil, Pflege und Routine, statt einfach nur Trends zu kopieren.</p>
							</div>
						</article>
						<article class="nocap-story-node nocap-story-node-feature" data-reveal style="--reveal-delay: 0.26s;">
							<span class="nocap-story-index">03</span>
							<div class="nocap-story-node-copy">
								<h3>Service ohne Showeffekte</h3>
								<p>Bei uns geht es um Gastlichkeit ohne Theater: entspannte Stimmung, gekuehlte Getraenke, klare Kommunikation und ein Team, das lieber solide abliefert als sich hinter grossen Worten versteckt.</p>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="nocap-section nocap-meaning-section" aria-labelledby="nocap-meaning-title">
		<div class="nocap-shell">
			<div class="nocap-meaning-section-grid">
				<div class="nocap-meaning-section-title" data-reveal>
					<h2 id="nocap-meaning-title">Was bedeutet No Cap?</h2>
				</div>
				<div class="nocap-meaning-section-copy" data-reveal style="--reveal-delay: 0.08s;">
					<p>Der Ausdruck steht fuer Ehrlichkeit. Keine Uebertreibung, keine Fassade, kein unnoetiger Laerm.</p>
					<p>Genau so verstehen wir unseren Shop: transparent in der Beratung, konsequent in der Qualitaet und aufmerksam in jedem Detail. Nicht mehr versprechen. Besser arbeiten.</p>
				</div>
				<div class="nocap-meaning-section-mark" aria-hidden="true" data-reveal style="--reveal-delay: 0.14s;">
					<span>NO</span>
					<span>CAP</span>
				</div>
			</div>
		</div>
	</section>

	<section id="google" class="nocap-section nocap-reviews" aria-labelledby="nocap-reviews-title">
		<div class="nocap-shell">
			<div class="nocap-review-layout" data-reveal>
				<aside class="nocap-review-badge" data-reveal style="--reveal-delay: 0.04s;" aria-label="Bewertungsquellen und Kennzahlen">
					<div class="nocap-review-ledger">
						<p class="nocap-review-ledger-kicker">Rezensionen</p>
						<div class="nocap-review-scoreboard">
							<p class="nocap-review-score">
                                4.9
                                <span class="nocap-review-star" aria-hidden="true">&#9733;</span>
                            </p>
							<p class="nocap-review-score-note">3700+ Rezensionen</p>
						</div>
						<div class="nocap-review-source-list">
							<a class="nocap-review-source" href="<?php echo esc_url( $treatwell_reviews_url ); ?>" target="_blank" rel="noopener">
								<span class="nocap-review-source-badge" aria-hidden="true">
									<img src="<?php echo esc_url( $treatwell_logo_url ); ?>" alt="" loading="lazy">
								</span>
								<span class="nocap-review-source-copy-wrap">
									<span class="nocap-review-source-name">Treatwell</span>
									<span class="nocap-review-source-meta">3000+ Treatwell Reviews</span>
								</span>
							</a>
							<a class="nocap-review-source" href="<?php echo esc_url( $google_reviews_url ); ?>" target="_blank" rel="noopener">
								<span class="nocap-review-source-badge" aria-hidden="true">
									<img src="<?php echo esc_url( $google_logo_url ); ?>" alt="" loading="lazy">
								</span>
								<span class="nocap-review-source-copy-wrap">
									<span class="nocap-review-source-name">Google</span>
									<span class="nocap-review-source-meta">700+ Google Reviews</span>
								</span>
							</a>
						</div>
						<div class="nocap-review-proofline" aria-hidden="true">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
					<div class="nocap-review-badge-cta">
						<p class="nocap-review-badge-copy">Termin direkt online sichern und den naechsten Cut bei uns buchen.</p>
						<a class="nocap-review-booking" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener">Jetzt Termin buchen</a>
					</div>
				</aside>
				<div class="nocap-review-content">
					<h2 id="nocap-reviews-title" class="nocap-section-title" data-reveal style="--reveal-delay: 0.08s;">Was Kunden über uns sagen</h2>
					<p class="nocap-section-intro" data-reveal style="--reveal-delay: 0.14s;">Kurz, echt und nachvollziehbar: jede gezeigte Stimme basiert auf einer oeffentlich sichtbaren Treatwell-Bewertung und ist direkt verlinkt.</p>
					<div class="nocap-review-switch" data-reveal style="--reveal-delay: 0.26s;" role="tablist" aria-label="Bewertungsfokus">
						<?php foreach ( $review_entries as $review_index => $review_entry ) : ?>
							<button class="nocap-review-chip<?php echo 0 === $review_index ? ' is-active' : ''; ?>" type="button" role="tab" aria-selected="<?php echo 0 === $review_index ? 'true' : 'false'; ?>" data-review-tab="<?php echo esc_attr( $review_entry['key'] ); ?>">
								<?php echo esc_html( $review_entry['label'] ); ?>
							</button>
						<?php endforeach; ?>
					</div>
					<div class="nocap-review-stream" data-reveal style="--reveal-delay: 0.32s;">
						<?php foreach ( $review_entries as $review_index => $review_entry ) : ?>
							<a class="nocap-review-quote<?php echo 0 === $review_index ? ' is-active' : ''; ?>" role="tabpanel" aria-hidden="<?php echo 0 === $review_index ? 'false' : 'true'; ?>" data-review-panel="<?php echo esc_attr( $review_entry['key'] ); ?>" href="<?php echo esc_url( $review_entry['source_url'] ); ?>" target="_blank" rel="noopener" aria-label="Review von <?php echo esc_attr( $review_entry['author'] ); ?> auf Treatwell ansehen">
								<p class="nocap-review-panel-label"><?php echo esc_html( $review_entry['headline'] ); ?></p>
								<blockquote class="nocap-review-quote-copy">
									<p>&ldquo;<?php echo esc_html( $review_entry['quote'] ); ?>&rdquo;</p>
								</blockquote>
								<div class="nocap-review-meta">
									<p class="nocap-review-author"><?php echo esc_html( $review_entry['author'] ); ?></p>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="nocap-section nocap-products" aria-labelledby="nocap-products-title">
		<div class="nocap-shell">
			<div class="nocap-products-head">
				<h2 id="nocap-products-title" class="nocap-section-title" data-reveal>Produkte, denen wir vertrauen</h2>
				<p class="nocap-section-intro" data-reveal style="--reveal-delay: 0.08s;">Zwei Linien, zwei Staerken: Styling und Pflege. Beide Produkte sind sichtbar, damit Sie direkt vergleichen koennen, was besser zu Ihrer Routine passt.</p>
			</div>
			<div class="nocap-products-atlas">
				<article class="nocap-product-feature" data-reveal style="--reveal-delay: 0.14s;">
					<div class="nocap-product-media" style="--product-image:url(<?php echo esc_url( $product_1_img ); ?>);">
						<span class="nocap-product-number">01</span>
					</div>
					<div class="nocap-product-copy">
						<p class="nocap-product-kicker">Texture + Hold</p>
						<h3>REUZEL</h3>
						<p>Tradition aus Rotterdam mit modernen Styling-Ergebnissen. Ideal für Pompadour, Textur oder kontrolliertes Volumen inklusive passender Pflege.</p>
						<ul class="nocap-product-points" aria-label="Reuzel Highlights">
							<li>Clay, Pomade und Grooming Tonics</li>
							<li>Starker Halt ohne steifes Finish</li>
							<li>Ideal für strukturierte Styles</li>
						</ul>
					</div>
				</article>
				<article class="nocap-product-feature nocap-product-feature-alt" data-reveal style="--reveal-delay: 0.2s;">
					<div class="nocap-product-media" style="--product-image:url(<?php echo esc_url( $product_2_img ); ?>);">
						<span class="nocap-product-number">02</span>
					</div>
					<div class="nocap-product-copy">
						<p class="nocap-product-kicker">Care + Finish</p>
						<h3>1922 by J.M. Keune</h3>
						<p>Pflege für Haare, Kopfhaut und Bart - entwickelt für Männer, die auf saubere Routinen und lang haltbare Ergebnisse setzen.</p>
						<ul class="nocap-product-points" aria-label="1922 Highlights">
							<li>Shampoo, Scalp und Beard Care</li>
							<li>Sauberes, alltagstaugliches Pflege-System</li>
							<li>Für sensible Kopfhaut und definierte Bärte</li>
						</ul>
					</div>
				</article>
			</div>
			</div>
	</section>

	<section id="gallerie" class="nocap-section" aria-labelledby="nocap-gallery-title">
		<div class="nocap-shell">
			<h2 id="nocap-gallery-title" class="nocap-section-title" data-reveal>Galerie</h2>
			<p class="nocap-section-intro" data-reveal style="--reveal-delay: 0.08s;">Ein Blick auf reale Ergebnisse aus dem Shop.</p>
			<div class="nocap-gallery-track" data-reveal style="--reveal-delay: 0.14s;">
				<?php foreach ( $gallery_ids as $gallery_id ) :
					$image_html = wp_get_attachment_image(
						(int) $gallery_id,
						'large',
						false,
						array(
							'class'    => 'nocap-gallery-image',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					if ( empty( $image_html ) ) {
						continue;
					}
					?>
					<figure class="nocap-gallery-item"><?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figure>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section id="team" class="nocap-section" aria-labelledby="nocap-team-title">
		<div class="nocap-shell">
			<h2 id="nocap-team-title" class="nocap-section-title" data-reveal>Das Team</h2>
			<div class="nocap-team-grid">
				<?php foreach ( $team_members as $index => $member ) :
					$team_img = wp_get_attachment_image(
						(int) $member['image'],
						'large',
						false,
						array(
							'class'    => 'nocap-team-photo',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					$delay = 0.08 + ( $index * 0.08 );
					?>
					<article class="nocap-team-card" data-reveal style="--reveal-delay: <?php echo esc_attr( (string) $delay ); ?>s;">
						<?php if ( ! empty( $team_img ) ) : ?>
							<?php echo $team_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endif; ?>
						<div class="nocap-team-copy">
							<h3><?php echo esc_html( $member['name'] ); ?></h3>
							<p class="nocap-team-role"><?php echo esc_html( $member['role'] ); ?></p>
							<p><?php echo esc_html( $member['bio_de'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="nocap-booking-strip" data-reveal style="--reveal-delay: 0.24s;">
				<div>
					<h3>Vereinbaren Sie ganz einfach online Ihren naechsten Termin.</h3>
					<p>Buchen Sie Ihren Wunschtermin schnell, direkt und unkompliziert online.</p>
				</div>
				<a class="nocap-btn nocap-btn-primary" href="<?php echo esc_url( $booking_cta ); ?>" target="_blank" rel="noopener">Jetzt buchen</a>
			</div>
		</div>
	</section>

	<section id="kontakt" class="nocap-section nocap-contact" aria-labelledby="nocap-contact-title">
		<div class="nocap-shell">
			<div class="nocap-contact-grid">
				<div class="nocap-map" data-reveal>
					<iframe src="<?php echo esc_url( $map_embed_url ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="NoCap Barbers Location"></iframe>
				</div>
				<div class="nocap-contact-card" data-reveal style="--reveal-delay: 0.1s;">
					<h2 id="nocap-contact-title">Kontakt</h2>
					<ul class="nocap-hours" aria-label="Öffnungszeiten">
						<li><span>Montag - Mittwoch, Freitag</span><strong>10:00 - 19:00</strong></li>
						<li><span>Donnerstag</span><strong>10:00 - 20:00</strong></li>
						<li><span>Samstag</span><strong>10:00 - 17:00</strong></li>
						<li><span>Feiertage</span><strong>geschlossen</strong></li>
					</ul>
					<div class="nocap-contact-links">
						<a href="<?php echo esc_attr( $contact_phone_href ); ?>">Tel.: <?php echo esc_html( $contact_phone ); ?></a>
						<a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
						<span>Hoher Markt 3, 1010 Wien</span>
					</div>
					<div class="nocap-social" aria-label="Social links">
						<a href="https://www.facebook.com/NoCapBarbersVienna/" target="_blank" rel="noopener" aria-label="Facebook">FB</a>
						<a href="https://www.instagram.com/nocap.barbers_mens_grooming/" target="_blank" rel="noopener" aria-label="Instagram">IG</a>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
