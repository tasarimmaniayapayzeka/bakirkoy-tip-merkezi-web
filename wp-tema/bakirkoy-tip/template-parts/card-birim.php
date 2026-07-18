<?php
/**
 * Tıbbi birim kartı (.dept) — dept-grid içinde kullanılır.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<a class="dept" href="<?php the_permalink(); ?>">
  <span class="ico" aria-hidden="true">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail( 'thumbnail', array( 'alt' => '' ) ); ?>
    <?php else : ?>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3v18M3 12h18"/><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
    <?php endif; ?>
  </span>
  <h3><?php the_title(); ?></h3>
  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
</a>
