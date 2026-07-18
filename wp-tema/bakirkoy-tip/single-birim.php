<?php
/**
 * Tıbbi birim (branş) detay şablonu — statik bolum-kardiyoloji.html'in uyarlaması.
 * - Birim tanıtımı: the_content()
 * - Tetkik listesi: bakirkoy_tetkikler meta'sı (satır başına "Ad | Açıklama")
 * - Bu birimdeki hekimler: aynı brans terimini taşıyan hekim CPT sorgusu
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$bakirkoy_id       = get_the_ID();
	$bakirkoy_tetkik   = bakirkoy_tip_meta_lines( $bakirkoy_id, 'bakirkoy_tetkikler' );
	$bakirkoy_terms    = get_the_terms( $bakirkoy_id, 'brans' );
	$bakirkoy_brans    = ( $bakirkoy_terms && ! is_wp_error( $bakirkoy_terms ) ) ? $bakirkoy_terms[0] : null;
	?>

<style>
/* Sayfaya özel stiller — statik bolum-*.html ile birebir */
.kd-intro{display:grid; grid-template-columns:1.4fr .85fr; gap:clamp(1.75rem,4vw,3.5rem); align-items:start}
@media (max-width:900px){ .kd-intro{grid-template-columns:1fr} }
.kd-intro p{color:var(--ink-2)}
.kd-sign{display:flex; align-items:center; gap:.85rem; margin-top:1.5rem; padding-top:1.25rem; border-top:1px solid var(--line)}
.kd-sign img{width:52px; height:52px; border-radius:50%; object-fit:cover; flex:none; border:1px solid var(--line)}
.kd-sign strong{display:block; font-size:.98rem}
.kd-sign span{font-size:.85rem; color:var(--muted)}
.kd-aside{background:var(--bg-2); border:1px solid var(--line); border-radius:var(--radius-l); padding:1.5rem 1.6rem}
.kd-aside h3{font-size:1.05rem; margin-bottom:1rem}
.kd-aside li{display:flex; gap:.7rem; padding:.55rem 0; font-size:.92rem; color:var(--ink-2)}
.kd-aside li svg{width:18px; height:18px; color:var(--brand-600); flex:none; margin-top:.15rem}
.test-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:1.2rem}
@media (max-width:860px){ .test-grid{grid-template-columns:repeat(2,1fr)} }
@media (max-width:520px){ .test-grid{grid-template-columns:1fr} }
.test-card{background:#fff; border:1px solid var(--line); border-radius:var(--radius-l); padding:1.5rem 1.5rem 1.6rem}
.test-card .ico{width:46px; height:46px; border-radius:13px; background:var(--brand-50); display:grid; place-items:center; margin-bottom:1rem}
.test-card .ico svg{width:23px; height:23px; color:var(--brand-700)}
.test-card h3{font-size:1.05rem; margin-bottom:.4rem}
.test-card p{font-size:.9rem; color:var(--ink-2); margin:0; line-height:1.55}
</style>

<!-- Sayfa başlığı -->
<section class="pagehead">
  <div class="wrap">
    <nav class="crumbs" aria-label="<?php esc_attr_e( 'Konum', 'bakirkoy-tip' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a><span>›</span>
      <a href="<?php echo esc_url( get_post_type_archive_link( 'birim' ) ); ?>"><?php esc_html_e( 'Tıbbi Birimler', 'bakirkoy-tip' ); ?></a><span>›</span>
      <span aria-current="page"><?php the_title(); ?></span>
    </nav>
    <h1><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?>
      <p><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- Bölüm hakkında + son inceleme imzası -->
<section class="section">
  <div class="wrap kd-intro">
    <div>
      <span class="eyebrow"><?php esc_html_e( 'Birim Hakkında', 'bakirkoy-tip' ); ?></span>
      <?php the_content(); ?>
      <div class="kd-sign">
        <div>
          <strong>
            <?php
            printf(
				/* translators: %s: içeriği hazırlayan yazar adı */
				esc_html__( 'Bu içerik %s tarafından hazırlanmıştır.', 'bakirkoy-tip' ),
				esc_html( get_the_author() )
			);
			?>
          </strong>
          <span>
            <?php
            printf(
				/* translators: %s: son güncelleme tarihi */
				esc_html__( 'Son güncelleme: %s', 'bakirkoy-tip' ),
				esc_html( get_the_modified_date( 'd.m.Y' ) )
			);
			?>
          </span>
        </div>
      </div>
    </div>
    <aside class="kd-aside">
      <h3><?php esc_html_e( 'Ne zaman randevu almalı?', 'bakirkoy-tip' ); ?></h3>
      <ul>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <?php esc_html_e( 'Şikâyetiniz tekrarlıyor veya günlük yaşamınızı etkiliyorsa', 'bakirkoy-tip' ); ?></li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <?php esc_html_e( 'Düzenli takip ve kontrol muayenesi gerekiyorsa', 'bakirkoy-tip' ); ?></li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <?php esc_html_e( 'Hekiminiz bu birime yönlendirme yaptıysa', 'bakirkoy-tip' ); ?></li>
      </ul>
      <a class="btn btn--gold btn--wide" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>" style="margin-top:1.1rem"><?php esc_html_e( 'Randevu Al', 'bakirkoy-tip' ); ?></a>
    </aside>
  </div>
</section>

<?php if ( $bakirkoy_tetkik ) : ?>
<!-- Uygulanan tetkikler (bakirkoy_tetkikler meta'sından) -->
<section class="section section--tint">
  <div class="wrap">
    <div class="sec-head">
      <span class="eyebrow"><?php esc_html_e( 'Tetkikler', 'bakirkoy-tip' ); ?></span>
      <h2><?php esc_html_e( 'Uygulanan tetkikler', 'bakirkoy-tip' ); ?></h2>
      <p><?php esc_html_e( 'Hangi tetkiklerin gerekli olduğuna, muayene sonrasında hekiminiz karar verir. Tetkikler merkezimizde uygulanır.', 'bakirkoy-tip' ); ?></p>
    </div>
    <div class="test-grid">
      <?php
      foreach ( $bakirkoy_tetkik as $bakirkoy_satir ) :
			$bakirkoy_parca = array_map( 'trim', explode( '|', $bakirkoy_satir, 2 ) );
			?>
        <div class="test-card">
          <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12h4l2-7 4 14 2-7h8"/></svg></span>
          <h3><?php echo esc_html( $bakirkoy_parca[0] ); ?></h3>
          <?php if ( ! empty( $bakirkoy_parca[1] ) ) : ?>
            <p><?php echo esc_html( $bakirkoy_parca[1] ); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
// Bu birimdeki hekimler: aynı brans terimini taşıyan hekimler.
if ( $bakirkoy_brans ) :
	$bakirkoy_hekimler = new WP_Query(
		array(
			'post_type'      => 'hekim',
			'posts_per_page' => 8,
			'no_found_rows'  => true,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'brans',
					'field'    => 'term_id',
					'terms'    => $bakirkoy_brans->term_id,
				),
			),
		)
	);
	if ( $bakirkoy_hekimler->have_posts() ) :
		?>
<!-- Bu birimdeki hekimler -->
<section class="section">
  <div class="wrap">
    <div class="sec-head sec-head--row">
      <div>
        <span class="eyebrow"><?php esc_html_e( 'Hekim Kadromuz', 'bakirkoy-tip' ); ?></span>
        <h2><?php esc_html_e( 'Bu birimdeki hekimler', 'bakirkoy-tip' ); ?></h2>
        <p><?php esc_html_e( 'Hekimlerimizin eğitim geçmişi, uzmanlık alanları ve çalışma günleri profilinde yer alır.', 'bakirkoy-tip' ); ?></p>
      </div>
      <a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'hekim' ) ); ?>"><?php esc_html_e( 'Tüm hekimler', 'bakirkoy-tip' ); ?></a>
    </div>
    <div class="doc-grid">
      <?php
      while ( $bakirkoy_hekimler->have_posts() ) :
			$bakirkoy_hekimler->the_post();
			get_template_part( 'template-parts/card-hekim' );
		endwhile;
		wp_reset_postdata();
		?>
    </div>
  </div>
</section>
		<?php
	endif;
endif;
?>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
endwhile;

get_footer();
