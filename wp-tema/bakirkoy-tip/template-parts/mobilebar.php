<?php
/**
 * Mobil sabit CTA barı (Ara / WhatsApp / Randevu).
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav class="mobilebar" aria-label="<?php esc_attr_e( 'Hızlı iletişim', 'bakirkoy-tip' ); ?>">
  <a class="mb-call" href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
    <?php esc_html_e( 'Hemen Ara', 'bakirkoy-tip' ); ?>
  </a>
  <a class="mb-wa" href="<?php echo esc_url( bakirkoy_tip_wa_url() ); ?>">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2zm5.3 14.1c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .1-1.7-.1a11 11 0 0 1-5.9-5.2c-.4-.7-.7-1.5-.7-2.3 0-.8.4-1.4.8-1.7.2-.2.4-.2.6-.2h.4c.2 0 .4 0 .6.4l.8 1.9c.1.2 0 .4-.1.5l-.4.5c-.1.1-.2.3-.1.5.4.8 1.5 2 2.7 2.5.2.1.4.1.5-.1l.6-.7c.1-.2.3-.2.5-.1l1.8.9c.2.1.3.2.3.4 0 .1 0 .5-.1.7z"/></svg>
    <?php esc_html_e( 'WhatsApp', 'bakirkoy-tip' ); ?>
  </a>
  <a class="mb-app" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
    <?php esc_html_e( 'Randevu', 'bakirkoy-tip' ); ?>
  </a>
</nav>
