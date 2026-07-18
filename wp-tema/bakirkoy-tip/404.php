<?php
/**
 * 404 sayfası.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="pagehead">
  <div class="wrap">
    <h1><?php esc_html_e( 'Sayfa bulunamadı', 'bakirkoy-tip' ); ?></h1>
    <p><?php esc_html_e( 'Aradığınız sayfa taşınmış veya kaldırılmış olabilir. Aşağıdaki bağlantılardan devam edebilirsiniz.', 'bakirkoy-tip' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="wrap center">
    <div class="hero-actions" style="justify-content:center">
      <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a>
      <a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'birim' ) ); ?>"><?php esc_html_e( 'Tıbbi Birimler', 'bakirkoy-tip' ); ?></a>
      <a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'hekim' ) ); ?>"><?php esc_html_e( 'Hekimlerimiz', 'bakirkoy-tip' ); ?></a>
      <a class="btn btn--gold" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>"><?php esc_html_e( 'Randevu Al', 'bakirkoy-tip' ); ?></a>
    </div>
  </div>
</section>

<?php
get_footer();
