<?php
/**
 * Tema başlığı: topbar + header + mobil menü hook'u.
 * Mobil menü panelini assets/js/main.js, .nav içindeki bağlantılardan kurar.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'İçeriğe geç', 'bakirkoy-tip' ); ?></a>

<!-- Üst bilgi şeridi -->
<div class="topbar">
  <div class="wrap">
    <div class="topbar-info">
      <span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> <?php echo esc_html( bakirkoy_tip_option( 'adres' ) ); ?></span>
      <span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg> <?php echo esc_html( bakirkoy_tip_option( 'calisma_saatleri' ) ); ?></span>
    </div>
    <div class="topbar-actions">
      <a href="<?php echo esc_url( home_url( '/tahlil-sonuclari/' ) ); ?>"><?php esc_html_e( 'Tahlil Sonuçları', 'bakirkoy-tip' ); ?></a>
      <a href="<?php echo esc_url( home_url( '/anlasmali-kurumlar/' ) ); ?>"><?php esc_html_e( 'Anlaşmalı Kurumlar', 'bakirkoy-tip' ); ?></a>
    </div>
  </div>
</div>

<!-- Header -->
<header class="header">
  <div class="wrap">
    <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . __( 'ana sayfa', 'bakirkoy-tip' ) ); ?>">
      <span class="logo-mark" aria-hidden="true">
        <?php if ( has_custom_logo() ) : ?>
          <?php echo wp_kses_post( wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'thumbnail', false, array( 'alt' => '' ) ) ); ?>
        <?php else : ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 12h18"/></svg>
        <?php endif; ?>
      </span>
      <span class="logo-text">
        <strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
        <small><?php echo esc_html( get_bloginfo( 'description' ) ); ?></small>
      </span>
    </a>
    <?php
    // Statik demodaki gibi çıplak <a> etiketli menü (mobil panel bu bağlantılardan kurulur).
    if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '<nav class="nav" aria-label="' . esc_attr__( 'Ana menü', 'bakirkoy-tip' ) . '">%3$s</nav>',
				'walker'         => new Bakirkoy_Tip_Nav_Walker(),
			)
		);
	} else {
		echo '<nav class="nav" aria-label="' . esc_attr__( 'Ana menü', 'bakirkoy-tip' ) . '">';
		bakirkoy_tip_primary_fallback();
		echo '</nav>';
	}
	?>
    <div class="header-cta">
      <a class="btn btn--ghost" href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
        <?php echo esc_html( bakirkoy_tip_option( 'telefon' ) ); ?>
      </a>
      <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>"><?php esc_html_e( 'Randevu', 'bakirkoy-tip' ); ?> <span><?php esc_html_e( 'Al', 'bakirkoy-tip' ); ?></span></a>
      <button class="burger" aria-label="<?php esc_attr_e( 'Menüyü aç', 'bakirkoy-tip' ); ?>" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
      </button>
    </div>
  </div>
</header>

<main id="main">
