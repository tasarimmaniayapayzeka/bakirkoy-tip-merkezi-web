<?php
/**
 * Genel sayfa şablonu (Hakkımızda, KVKK, Hasta Hakları, İletişim vb.).
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
    <?php the_content(); ?>
  </div>
</section>

<?php
endwhile;

get_footer();
