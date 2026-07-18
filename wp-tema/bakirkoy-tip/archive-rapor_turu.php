<?php
/**
 * Sağlık raporları arşivi (statik saglik-raporlari.html karşılığı).
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
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span> <?php esc_html_e( 'Sağlık Raporları', 'bakirkoy-tip' ); ?>
    </nav>
    <h1><?php esc_html_e( 'Sağlık Raporları', 'bakirkoy-tip' ); ?></h1>
    <p><?php esc_html_e( 'İşe giriş, ehliyet, sporcu, evlilik ve portör raporlarınızı tek ziyarette tamamlayın. Gerekli belgeleri ve süreci her rapor türünün sayfasında bulabilirsiniz.', 'bakirkoy-tip' ); ?></p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="sec-head">
      <span class="eyebrow"><?php esc_html_e( 'Aynı Gün Teslim', 'bakirkoy-tip' ); ?></span>
      <h2><?php esc_html_e( 'Rapor türleri', 'bakirkoy-tip' ); ?></h2>
      <p><?php esc_html_e( 'Muayene, tahlil, işitme ve görme testi merkez içinde yapılır; raporunuz aynı gün elinize geçer.', 'bakirkoy-tip' ); ?></p>
    </div>
    <div class="dept-grid">
      <?php
      if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
        <a class="dept" href="<?php the_permalink(); ?>">
          <span class="ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 15h6M9 11h3"/></svg></span>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
        </a>
				<?php
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
