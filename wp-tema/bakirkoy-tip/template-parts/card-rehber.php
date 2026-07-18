<?php
/**
 * Sağlık rehberi (blog) kartı (.guide) — guide-grid içinde kullanılır.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bakirkoy_cats = get_the_category();
?>
<a class="guide" href="<?php the_permalink(); ?>">
  <?php if ( $bakirkoy_cats ) : ?>
    <span class="chip"><?php echo esc_html( $bakirkoy_cats[0]->name ); ?></span>
  <?php endif; ?>
  <h3><?php the_title(); ?></h3>
  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
  <div class="byline">
    <span class="av"><?php echo get_avatar( get_the_author_meta( 'ID' ), 60, '', '' ); ?></span>
    <?php
    printf(
		/* translators: 1: yazar adı, 2: güncelleme tarihi */
		esc_html__( '%1$s · Güncelleme: %2$s', 'bakirkoy-tip' ),
		esc_html( get_the_author() ),
		esc_html( get_the_modified_date( 'd.m.Y' ) )
	);
	?>
  </div>
</a>
