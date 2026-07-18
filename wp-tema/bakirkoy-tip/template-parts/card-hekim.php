<?php
/**
 * Hekim kartı (.doc) — doc-grid içinde kullanılır.
 * data-spec özniteliği brans terim slug'ıdır; arşiv sayfasındaki JS filtre bunu kullanır.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bakirkoy_terms   = get_the_terms( get_the_ID(), 'brans' );
$bakirkoy_brans   = ( $bakirkoy_terms && ! is_wp_error( $bakirkoy_terms ) ) ? $bakirkoy_terms[0] : null;
$bakirkoy_gunler  = bakirkoy_tip_meta_lines( get_the_ID(), 'bakirkoy_calisma_gunleri' );
?>
<article class="doc" data-spec="<?php echo esc_attr( $bakirkoy_brans ? $bakirkoy_brans->slug : 'diger' ); ?>">
  <div class="doc-photo">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail( 'bakirkoy-hekim', array( 'alt' => get_the_title() . ( $bakirkoy_brans ? ', ' . $bakirkoy_brans->name : '' ), 'loading' => 'lazy' ) ); ?>
    <?php else : ?>
      <span class="ph" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6 8-6s8 2 8 6"/></svg></span>
    <?php endif; ?>
    <?php if ( $bakirkoy_brans ) : ?>
      <span class="doc-spec"><?php echo esc_html( $bakirkoy_brans->name ); ?></span>
    <?php endif; ?>
  </div>
  <div class="doc-body">
    <h3><?php the_title(); ?></h3>
    <?php if ( $bakirkoy_gunler ) : ?>
      <p class="sub"><?php echo esc_html( $bakirkoy_gunler[0] ); ?></p>
    <?php endif; ?>
    <a class="btn btn--ghost" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Profili ve randevu', 'bakirkoy-tip' ); ?></a>
  </div>
</article>
