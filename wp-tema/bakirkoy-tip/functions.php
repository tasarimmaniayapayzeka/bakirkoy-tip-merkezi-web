<?php
/**
 * Avrupa Tıp Merkezi tema fonksiyonları.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BAKIRKOY_TIP_VERSION', '0.1.0' );

require get_template_directory() . '/inc/customizer.php';

/* --------------------------------------------------------------------------
 * Tema destekleri + menüler
 * ------------------------------------------------------------------------ */

function bakirkoy_tip_setup() {
	load_theme_textdomain( 'bakirkoy-tip', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 88,
			'width'       => 88,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary'          => __( 'Ana Menü', 'bakirkoy-tip' ),
			'footer-kurumsal'  => __( 'Footer — Kurumsal', 'bakirkoy-tip' ),
			'footer-hizmetler' => __( 'Footer — Hizmetler', 'bakirkoy-tip' ),
		)
	);

	// Hekim kartları 3:4 dikey görsel kullanır (statik demo: 600x800).
	add_image_size( 'bakirkoy-hekim', 600, 800, true );
}
add_action( 'after_setup_theme', 'bakirkoy_tip_setup' );

/* --------------------------------------------------------------------------
 * Stil ve script enqueue
 * Gerçek stiller statik demodan temaya kopyalanan assets/css/style.css'tedir.
 * ------------------------------------------------------------------------ */

function bakirkoy_tip_enqueue_assets() {
	// Google Fonts (statik demodaki Plus Jakarta Sans).
	wp_enqueue_style(
		'bakirkoy-tip-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Ana tasarım sistemi (statik demodaki style.css'in kopyası).
	wp_enqueue_style(
		'bakirkoy-tip-main',
		get_theme_file_uri( 'assets/css/style.css' ),
		array( 'bakirkoy-tip-fonts' ),
		BAKIRKOY_TIP_VERSION
	);

	// Chatbot stilleri.
	wp_enqueue_style(
		'bakirkoy-tip-chatbot',
		get_theme_file_uri( 'assets/css/chatbot.css' ),
		array( 'bakirkoy-tip-main' ),
		BAKIRKOY_TIP_VERSION
	);

	// Tema başlık dosyası (boş; sadece tema kimliği için).
	wp_enqueue_style( 'bakirkoy-tip-style', get_stylesheet_uri(), array( 'bakirkoy-tip-main' ), BAKIRKOY_TIP_VERSION );

	// Site geneli JS (mobil menü) + chatbot.
	wp_enqueue_script( 'bakirkoy-tip-main', get_theme_file_uri( 'assets/js/main.js' ), array(), BAKIRKOY_TIP_VERSION, true );
	wp_enqueue_script( 'bakirkoy-tip-chatbot', get_theme_file_uri( 'assets/js/chatbot.js' ), array(), BAKIRKOY_TIP_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'bakirkoy_tip_enqueue_assets' );

// Statik demodaki gibi defer ile yükle.
function bakirkoy_tip_defer_scripts( $tag, $handle ) {
	if ( in_array( $handle, array( 'bakirkoy-tip-main', 'bakirkoy-tip-chatbot' ), true ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'bakirkoy_tip_defer_scripts', 10, 2 );

/* --------------------------------------------------------------------------
 * Özel içerik tipleri (CPT) + taksonomi
 * ------------------------------------------------------------------------ */

function bakirkoy_tip_register_post_types() {

	// Hekim.
	register_post_type(
		'hekim',
		array(
			'labels'       => array(
				'name'          => __( 'Hekimler', 'bakirkoy-tip' ),
				'singular_name' => __( 'Hekim', 'bakirkoy-tip' ),
				'add_new_item'  => __( 'Yeni Hekim Ekle', 'bakirkoy-tip' ),
				'edit_item'     => __( 'Hekimi Düzenle', 'bakirkoy-tip' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-id-alt',
			'menu_position'=> 20,
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'      => array( 'slug' => 'hekimler', 'with_front' => false ),
			'show_in_rest' => true,
		)
	);

	// Tıbbi birim.
	register_post_type(
		'birim',
		array(
			'labels'       => array(
				'name'          => __( 'Tıbbi Birimler', 'bakirkoy-tip' ),
				'singular_name' => __( 'Tıbbi Birim', 'bakirkoy-tip' ),
				'add_new_item'  => __( 'Yeni Birim Ekle', 'bakirkoy-tip' ),
				'edit_item'     => __( 'Birimi Düzenle', 'bakirkoy-tip' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-plus-alt',
			'menu_position'=> 21,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'rewrite'      => array( 'slug' => 'bolumler', 'with_front' => false ),
			'show_in_rest' => true,
		)
	);

	// Sağlık raporu türü.
	register_post_type(
		'rapor_turu',
		array(
			'labels'       => array(
				'name'          => __( 'Sağlık Raporları', 'bakirkoy-tip' ),
				'singular_name' => __( 'Rapor Türü', 'bakirkoy-tip' ),
				'add_new_item'  => __( 'Yeni Rapor Türü Ekle', 'bakirkoy-tip' ),
				'edit_item'     => __( 'Rapor Türünü Düzenle', 'bakirkoy-tip' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-media-document',
			'menu_position'=> 22,
			'supports'     => array( 'title', 'editor', 'excerpt' ),
			'rewrite'      => array( 'slug' => 'saglik-raporlari', 'with_front' => false ),
			'show_in_rest' => true,
		)
	);

	// Branş: hekim ↔ birim ilişkisi (hekim arşivi filtresi de bundan beslenir).
	register_taxonomy(
		'brans',
		array( 'hekim', 'birim' ),
		array(
			'labels'       => array(
				'name'          => __( 'Branşlar', 'bakirkoy-tip' ),
				'singular_name' => __( 'Branş', 'bakirkoy-tip' ),
			),
			'hierarchical' => true,
			'public'       => true,
			'rewrite'      => array( 'slug' => 'brans', 'with_front' => false ),
			'show_in_rest' => true,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'bakirkoy_tip_register_post_types' );

/* --------------------------------------------------------------------------
 * Saf WP post meta (CMB2/ACF yok) — show_in_rest ile Gutenberg uyumlu
 * ------------------------------------------------------------------------ */

function bakirkoy_tip_register_meta() {
	$auth = function () {
		return current_user_can( 'edit_posts' );
	};
	$string = function ( $post_type, $key, $single_line = true ) use ( $auth ) {
		register_post_meta(
			$post_type,
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'sanitize_callback' => $single_line ? 'sanitize_text_field' : 'sanitize_textarea_field',
				'auth_callback'     => $auth,
			)
		);
	};

	// Hekim: unvan, çalışma günleri, diller, üyelikler.
	$string( 'hekim', 'bakirkoy_unvan' );                       // Örn: "Kardiyoloji Uzmanı".
	$string( 'hekim', 'bakirkoy_calisma_gunleri', false );      // Satır başına: "Pazartesi: 09:00 – 17:00".
	$string( 'hekim', 'bakirkoy_diller' );                      // Virgülle: "Türkçe, İngilizce".
	$string( 'hekim', 'bakirkoy_uyelikler', false );            // Satır başına bir üyelik.

	// Birim: tetkik listesi.
	$string( 'birim', 'bakirkoy_tetkikler', false );            // Satır başına: "EKG | Kısa açıklama".

	// Rehber yazısı: kaynakça (satır başına bir kaynak).
	$string( 'post', 'bakirkoy_kaynakca', false );
}
add_action( 'init', 'bakirkoy_tip_register_meta' );

/**
 * Klasik editör için basit meta kutuları (saf WP; eklenti yok).
 */
function bakirkoy_tip_meta_boxes() {
	add_meta_box( 'bakirkoy_hekim_meta', __( 'Hekim Bilgileri', 'bakirkoy-tip' ), 'bakirkoy_tip_render_hekim_meta', 'hekim', 'normal', 'high' );
	add_meta_box( 'bakirkoy_birim_meta', __( 'Birim Bilgileri', 'bakirkoy-tip' ), 'bakirkoy_tip_render_birim_meta', 'birim', 'normal', 'high' );
	add_meta_box( 'bakirkoy_rehber_meta', __( 'Kaynakça', 'bakirkoy-tip' ), 'bakirkoy_tip_render_rehber_meta', 'post', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'bakirkoy_tip_meta_boxes' );

function bakirkoy_tip_meta_field( $post, $key, $label, $hint, $textarea = false ) {
	$value = get_post_meta( $post->ID, $key, true );
	echo '<p><label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $label ) . '</strong></label><br>';
	if ( $textarea ) {
		echo '<textarea class="widefat" rows="5" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input type="text" class="widefat" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
	}
	echo '<span class="description">' . esc_html( $hint ) . '</span></p>';
}

function bakirkoy_tip_render_hekim_meta( $post ) {
	wp_nonce_field( 'bakirkoy_tip_meta', 'bakirkoy_tip_meta_nonce' );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_unvan', __( 'Unvan / rol', 'bakirkoy-tip' ), __( 'Örn: Kardiyoloji Uzmanı', 'bakirkoy-tip' ) );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_calisma_gunleri', __( 'Çalışma günleri', 'bakirkoy-tip' ), __( 'Satır başına bir gün. Örn: "Pazartesi: 09:00 – 17:00" veya "Salı: Muayene yok"', 'bakirkoy-tip' ), true );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_diller', __( 'Konuşulan diller', 'bakirkoy-tip' ), __( 'Virgülle ayırın. Örn: Türkçe, İngilizce', 'bakirkoy-tip' ) );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_uyelikler', __( 'Mesleki üyelikler', 'bakirkoy-tip' ), __( 'Satır başına bir üyelik.', 'bakirkoy-tip' ), true );
}

function bakirkoy_tip_render_birim_meta( $post ) {
	wp_nonce_field( 'bakirkoy_tip_meta', 'bakirkoy_tip_meta_nonce' );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_tetkikler', __( 'Uygulanan tetkikler', 'bakirkoy-tip' ), __( 'Satır başına bir tetkik: "Tetkik adı | Kısa açıklama"', 'bakirkoy-tip' ), true );
}

function bakirkoy_tip_render_rehber_meta( $post ) {
	wp_nonce_field( 'bakirkoy_tip_meta', 'bakirkoy_tip_meta_nonce' );
	bakirkoy_tip_meta_field( $post, 'bakirkoy_kaynakca', __( 'Kaynakça', 'bakirkoy-tip' ), __( 'Satır başına bir kaynak. Yazı sonunda "Kaynaklar" bölümü olarak listelenir.', 'bakirkoy-tip' ), true );
}

function bakirkoy_tip_save_meta( $post_id ) {
	if ( ! isset( $_POST['bakirkoy_tip_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['bakirkoy_tip_meta_nonce'] ), 'bakirkoy_tip_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$single_line = array( 'bakirkoy_unvan', 'bakirkoy_diller' );
	$multi_line  = array( 'bakirkoy_calisma_gunleri', 'bakirkoy_uyelikler', 'bakirkoy_tetkikler', 'bakirkoy_kaynakca' );

	foreach ( $single_line as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
	foreach ( $multi_line as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post', 'bakirkoy_tip_save_meta' );

/* --------------------------------------------------------------------------
 * Güvenlik sertleştirme (EsteTouch eklentisindeki yaklaşım)
 * ------------------------------------------------------------------------ */

// 1) XML-RPC tamamen kapalı.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
function bakirkoy_tip_remove_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'bakirkoy_tip_remove_pingback_header' );

// 2) WP sürümünü gizle.
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// 3) Kullanıcı numaralandırma engeli: ?author=N → ana sayfa.
function bakirkoy_tip_block_author_enum() {
	if ( is_admin() ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- salt okunur kontrol.
	if ( isset( $_GET['author'] ) || is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'bakirkoy_tip_block_author_enum' );

// 4) REST üzerinden kullanıcı listesi yalnızca yetkili kullanıcıya.
function bakirkoy_tip_restrict_rest_users( $endpoints ) {
	if ( ! current_user_can( 'list_users' ) ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}
add_filter( 'rest_endpoints', 'bakirkoy_tip_restrict_rest_users' );

// 5) Yazar/kullanıcı sitemap'ini kaldır.
function bakirkoy_tip_remove_users_sitemap( $provider, $name ) {
	return ( 'users' === $name ) ? false : $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'bakirkoy_tip_remove_users_sitemap', 10, 2 );

// 6) oEmbed keşfi ve gereksiz head satırları.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/* --------------------------------------------------------------------------
 * Schema.org JSON-LD (statik demodaki bloklar meta/Customizer'dan beslenir)
 * ------------------------------------------------------------------------ */

function bakirkoy_tip_jsonld() {
	$schema = null;

	if ( is_front_page() ) {
		// Statik index.html'deki MedicalClinic bloğunun PHP'ye uyarlanmış hali.
		$schema = array(
			'@context'  => 'https://schema.org',
			'@type'     => 'MedicalClinic',
			'@id'       => home_url( '/#klinik' ),
			'name'      => get_bloginfo( 'name' ),
			'url'       => home_url( '/' ),
			'telephone' => bakirkoy_tip_phone_href( false ),
			'address'   => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => bakirkoy_tip_option( 'adres' ),
				'addressLocality' => 'Bakırköy',
				'addressRegion'   => 'İstanbul',
				'addressCountry'  => 'TR',
			),
			'openingHours' => bakirkoy_tip_option( 'calisma_saatleri' ),
			'potentialAction' => array(
				'@type'  => 'ReserveAction',
				'target' => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => home_url( '/randevu/' ),
				),
				'result' => array(
					'@type' => 'Reservation',
					'name'  => __( 'Randevu', 'bakirkoy-tip' ),
				),
			),
		);
	} elseif ( is_singular( 'hekim' ) ) {
		// Statik hekim-*.html'deki Physician bloğu; alanlar post meta'dan.
		$post_id  = get_the_ID();
		$brans    = get_the_terms( $post_id, 'brans' );
		$diller   = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $post_id, 'bakirkoy_diller', true ) ) ) );
		$uyelik   = array_filter( array_map( 'trim', explode( "\n", (string) get_post_meta( $post_id, 'bakirkoy_uyelikler', true ) ) ) );
		$member   = array();
		foreach ( $uyelik as $u ) {
			$member[] = array(
				'@type' => 'MedicalOrganization',
				'name'  => $u,
			);
		}

		$schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'Physician',
			'@id'              => get_permalink() . '#hekim',
			'name'             => get_the_title(),
			'jobTitle'         => get_post_meta( $post_id, 'bakirkoy_unvan', true ),
			'medicalSpecialty' => ( $brans && ! is_wp_error( $brans ) ) ? $brans[0]->name : '',
			'url'              => get_permalink(),
			'telephone'        => bakirkoy_tip_phone_href( false ),
			'worksFor'         => array(
				'@type' => 'MedicalClinic',
				'@id'   => home_url( '/#klinik' ),
				'name'  => get_bloginfo( 'name' ),
			),
		);
		if ( has_post_thumbnail() ) {
			$schema['image'] = get_the_post_thumbnail_url( $post_id, 'full' );
		}
		if ( $diller ) {
			$schema['knowsLanguage'] = array_values( $diller );
		}
		if ( $member ) {
			$schema['memberOf'] = $member;
		}
	} elseif ( is_singular( 'birim' ) ) {
		// Statik bolum-*.html'deki MedicalWebPage bloğu.
		$schema = array(
			'@context'     => 'https://schema.org',
			'@type'        => 'MedicalWebPage',
			'name'         => sprintf( '%1$s — %2$s', get_the_title(), get_bloginfo( 'name' ) ),
			'url'          => get_permalink(),
			'inLanguage'   => 'tr-TR',
			'about'        => array(
				'@type' => 'MedicalSpecialty',
				'name'  => get_the_title(),
			),
			'lastReviewed' => get_the_modified_date( 'Y-m-d' ),
			'publisher'    => array(
				'@type' => 'MedicalClinic',
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
			),
		);
	}

	if ( $schema ) {
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'bakirkoy_tip_jsonld' );

/* --------------------------------------------------------------------------
 * Menü walker: statik demodaki gibi çıplak <a> etiketleri (.nav a)
 * ------------------------------------------------------------------------ */

class Bakirkoy_Tip_Nav_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$current = in_array( 'current-menu-item', (array) $item->classes, true ) ? ' aria-current="page"' : '';
		$output .= '<a href="' . esc_url( $item->url ) . '"' . $current . '>' . esc_html( $item->title ) . '</a>';
	}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

/**
 * Menü atanmadıysa ana menü için mantıklı varsayılan bağlantılar.
 */
function bakirkoy_tip_primary_fallback() {
	$links = array(
		home_url( '/' )                   => __( 'Ana Sayfa', 'bakirkoy-tip' ),
		get_post_type_archive_link( 'birim' )      => __( 'Tıbbi Birimler', 'bakirkoy-tip' ),
		get_post_type_archive_link( 'hekim' )      => __( 'Hekimlerimiz', 'bakirkoy-tip' ),
		get_post_type_archive_link( 'rapor_turu' ) => __( 'Sağlık Raporları', 'bakirkoy-tip' ),
		home_url( '/saglik-rehberi/' )    => __( 'Sağlık Rehberi', 'bakirkoy-tip' ),
		home_url( '/iletisim/' )          => __( 'İletişim', 'bakirkoy-tip' ),
	);
	foreach ( $links as $url => $label ) {
		if ( $url ) {
			echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
		}
	}
}

/* --------------------------------------------------------------------------
 * Yardımcılar
 * ------------------------------------------------------------------------ */

/**
 * Meta değerini satırlara böler (boşları atar).
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta anahtarı.
 * @return string[]
 */
function bakirkoy_tip_meta_lines( $post_id, $key ) {
	$raw = (string) get_post_meta( $post_id, $key, true );
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ) ) );
}
