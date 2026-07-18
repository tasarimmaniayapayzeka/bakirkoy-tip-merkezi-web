<?php
/**
 * Tıbbi birimler arşivi (statik bolumler.html karşılığı) — dept-grid listesi.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- Sayfa başlığı -->
<section class="pagehead">
  <div class="wrap">
    <nav class="crumbs" aria-label="<?php esc_attr_e( 'Sayfa yolu', 'bakirkoy-tip' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span> <?php esc_html_e( 'Tıbbi Birimler', 'bakirkoy-tip' ); ?>
    </nav>
    <h1><?php esc_html_e( 'Tıbbi Birimler', 'bakirkoy-tip' ); ?></h1>
    <p><?php esc_html_e( 'Muayene, tahlil ve görüntüleme aynı çatı altında. Şikâyetinize uygun birimi seçin; hangi durumlara bakıldığını ve uygulanan tetkikleri birim sayfasında bulabilirsiniz.', 'bakirkoy-tip' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="dept-grid">
      <?php
      if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card-birim' );
			endwhile;
		endif;
		?>
    </div>
    <?php the_posts_pagination(); ?>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
get_footer();
