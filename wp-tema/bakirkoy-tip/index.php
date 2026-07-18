<?php
/**
 * Genel yedek şablon (blog listesi / "Sağlık Rehberi" arşivi de buraya düşer).
 * WordPress'in zorunlu tuttuğu son çare şablonudur.
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
    <h1>
      <?php
      if ( is_home() ) {
			esc_html_e( 'Sağlık Rehberi', 'bakirkoy-tip' );
		} elseif ( is_archive() ) {
			the_archive_title();
		} elseif ( is_search() ) {
			printf(
				/* translators: %s: arama terimi */
				esc_html__( 'Arama sonuçları: %s', 'bakirkoy-tip' ),
				esc_html( get_search_query() )
			);
		} else {
			esc_html_e( 'Yazılar', 'bakirkoy-tip' );
		}
		?>
    </h1>
    <?php if ( is_home() ) : ?>
      <p><?php esc_html_e( 'Tüm içerikler ilgili branş hekimi tarafından yazılır ve güncellenir; bilgilendirme amaçlıdır, tıbbi tavsiye yerine geçmez.', 'bakirkoy-tip' ); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <?php if ( have_posts() ) : ?>
      <div class="guide-grid">
        <?php
        while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/card-rehber' );
		endwhile;
		?>
      </div>
      <?php the_posts_pagination(); ?>
    <?php else : ?>
      <p><?php esc_html_e( 'Henüz içerik eklenmemiş.', 'bakirkoy-tip' ); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
get_footer();
