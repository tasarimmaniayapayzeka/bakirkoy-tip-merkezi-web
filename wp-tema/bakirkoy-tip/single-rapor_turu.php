<?php
/**
 * Sağlık raporu türü detay sayfası (işe giriş, ehliyet, sporcu, evlilik...).
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>

<!-- Sayfa başlığı -->
<section class="pagehead">
  <div class="wrap">
    <nav class="crumbs" aria-label="<?php esc_attr_e( 'Sayfa yolu', 'bakirkoy-tip' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span>
      <a href="<?php echo esc_url( get_post_type_archive_link( 'rapor_turu' ) ); ?>"><?php esc_html_e( 'Sağlık Raporları', 'bakirkoy-tip' ); ?></a> <span>/</span>
      <span aria-current="page"><?php the_title(); ?></span>
    </nav>
    <h1><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
      <p><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="wrap" style="max-width:820px">
    <span class="eyebrow"><?php esc_html_e( 'Rapor İşlemleri', 'bakirkoy-tip' ); ?></span>
    <?php the_content(); ?>
    <p style="margin-top:1.5rem; font-size:.85rem; color:var(--muted)">
      <?php
      printf(
			/* translators: %s: son güncelleme tarihi */
			esc_html__( 'Bu sayfadaki bilgilerin son güncellenme tarihi: %s', 'bakirkoy-tip' ),
			esc_html( get_the_modified_date( 'd.m.Y' ) )
		);
		?>
    </p>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
endwhile;

get_footer();
