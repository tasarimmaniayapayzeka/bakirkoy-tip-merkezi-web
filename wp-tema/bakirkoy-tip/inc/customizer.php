<?php
/**
 * Customizer ayarları: iletişim + mevzuat künyesi.
 * Topbar, footer künyesi, mobilebar ve JSON-LD bu ayarlardan beslenir.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ayar oku (varsayılanlar statik demodaki temsili değerlerdir).
 *
 * @param string $key Ayar anahtarı (bakirkoy_ öneksiz).
 * @return string
 */
function bakirkoy_tip_option( $key ) {
	$defaults = array(
		'telefon'          => '444 0 000',
		'whatsapp'         => '905000000000',
		'adres'            => 'Zuhuratbaba Mah. Örnek Cad. No:00, 34147 Bakırköy / İstanbul',
		'calisma_saatleri' => 'Hafta içi 08:30–20:00 · Cumartesi 09:00–17:00',
		'mesul_mudur'      => 'Uzm. Dr. [Ad Soyad]',
		'editor_ad'        => '[Ad Soyad]',
		'editor_eposta'    => 'editor@ornek.com.tr',
		'faaliyet_no'      => 'İstanbul İl Sağlık Müdürlüğü — No: 00000',
	);
	$default = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return (string) get_theme_mod( 'bakirkoy_' . $key, $default );
}

/**
 * Telefonun tel: bağlantısı (veya çıplak E.164 benzeri hali).
 *
 * @param bool $as_href true ise "tel:+90..." döner.
 * @return string
 */
function bakirkoy_tip_phone_href( $as_href = true ) {
	$digits = preg_replace( '/[^0-9+]/', '', bakirkoy_tip_option( 'telefon' ) );
	if ( '' !== $digits && '+' !== $digits[0] ) {
		$digits = '+90' . ltrim( $digits, '0' );
	}
	return $as_href ? 'tel:' . $digits : $digits;
}

/**
 * WhatsApp bağlantısı.
 *
 * @return string
 */
function bakirkoy_tip_wa_url() {
	$num = preg_replace( '/[^0-9]/', '', bakirkoy_tip_option( 'whatsapp' ) );
	return 'https://wa.me/' . $num;
}

/**
 * Customizer kayıtları.
 *
 * @param WP_Customize_Manager $wp_customize Customizer nesnesi.
 */
function bakirkoy_tip_customize_register( $wp_customize ) {

	$wp_customize->add_section(
		'bakirkoy_iletisim',
		array(
			'title'       => __( 'Tıp Merkezi Bilgileri', 'bakirkoy-tip' ),
			'description' => __( 'Topbar, footer künyesi, mobil CTA barı ve Schema.org verileri bu ayarlardan beslenir.', 'bakirkoy-tip' ),
			'priority'    => 30,
		)
	);

	$fields = array(
		'telefon'          => array( __( 'Telefon (görünen)', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
		'whatsapp'         => array( __( 'WhatsApp numarası (905XXXXXXXXX)', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
		'adres'            => array( __( 'Adres', 'bakirkoy-tip' ), 'textarea', 'sanitize_textarea_field' ),
		'calisma_saatleri' => array( __( 'Çalışma saatleri', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
		'mesul_mudur'      => array( __( 'Mesul müdür', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
		'editor_ad'        => array( __( 'Site içerik editörü (ad soyad)', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
		'editor_eposta'    => array( __( 'Editör e-postası', 'bakirkoy-tip' ), 'email', 'sanitize_email' ),
		'faaliyet_no'      => array( __( 'Faaliyet izin belgesi', 'bakirkoy-tip' ), 'text', 'sanitize_text_field' ),
	);

	foreach ( $fields as $key => $conf ) {
		$wp_customize->add_setting(
			'bakirkoy_' . $key,
			array(
				'default'           => bakirkoy_tip_option( $key ),
				'sanitize_callback' => $conf[2],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'bakirkoy_' . $key,
			array(
				'label'   => $conf[0],
				'section' => 'bakirkoy_iletisim',
				'type'    => $conf[1],
			)
		);
	}
}
add_action( 'customize_register', 'bakirkoy_tip_customize_register' );
