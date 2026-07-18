<?php
/**
 * Sağlık rehberi yazısı (statik rehber-yazi.html'in uyarlaması):
 * yazar kutusu + son güncelleme + kaynakça alanı (bakirkoy_kaynakca meta).
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$bakirkoy_kaynaklar = bakirkoy_tip_meta_lines( get_the_ID(), 'bakirkoy_kaynakca' );
	$bakirkoy_cats      = get_the_category();
	?>

<style>
/* Sayfaya özel stiller — statik rehber-yazi.html ile birebir */
.art-shell{max-width:820px; margin-inline:auto}
.art-crumbs{display:flex; gap:.5rem; align-items:center; flex-wrap:wrap; font-size:.84rem; color:var(--muted); margin-bottom:1.4rem}
.art-crumbs a{color:var(--brand-700); font-weight:600}
.art-crumbs a:hover{text-decoration:underline}
.art-crumbs span{opacity:.5}
.art-head h1{font-size:clamp(1.85rem,4vw,2.75rem); margin:.75rem 0 0; line-height:1.18}
.art-author{display:flex; gap:1rem; align-items:center; flex-wrap:wrap; background:var(--bg-2); border:1px solid var(--line); border-radius:var(--radius-l); padding:1.1rem 1.35rem; margin:1.6rem 0 2rem}
.art-author .ava{width:56px; height:56px; border-radius:50%; overflow:hidden; flex:none; background:var(--brand-100); border:2px solid #fff; box-shadow:var(--shadow-s)}
.art-author .ava img{width:100%; height:100%; object-fit:cover}
.art-author .meta{display:flex; flex-direction:column; gap:.15rem; min-width:0}
.art-author .who{font-weight:800; font-size:1.02rem; color:var(--ink)}
.art-author .who small{display:block; font-weight:700; font-size:.78rem; letter-spacing:.02em; color:var(--brand-600); text-transform:uppercase}
.art-author .dates{display:flex; gap:.4rem 1.1rem; flex-wrap:wrap; font-size:.82rem; color:var(--muted); margin-top:.15rem}
.art-author .dates span{display:inline-flex; align-items:center; gap:.35rem}
.art-hero{border-radius:var(--radius-l); overflow:hidden; border:1px solid var(--line); margin-bottom:2rem}
.art-hero img{width:100%; aspect-ratio:16/9; object-fit:cover; display:block}
.art-body{font-size:1.05rem; line-height:1.75; color:var(--ink-2)}
.art-body h2{font-size:clamp(1.35rem,2.6vw,1.7rem); color:var(--ink); margin:2.4rem 0 .9rem; padding-top:.4rem}
.art-body p{margin:0 0 1.1rem}
.art-sources{margin-top:clamp(2rem,4vw,3rem); padding:1.25rem 1.4rem; background:var(--bg-2); border:1px solid var(--line); border-radius:var(--radius)}
.art-sources h2{font-size:1.05rem; margin-bottom:.85rem}
.art-sources li{position:relative; padding:.25rem 0 .25rem 1.4rem; font-size:.92rem; color:var(--ink-2)}
.art-sources li::before{content:""; position:absolute; left:.2rem; top:.85rem; width:6px; height:6px; border-radius:50%; background:var(--brand-500)}
.art-disclaimer{margin-top:1.5rem; font-size:.85rem; color:var(--muted); line-height:1.65}
</style>

<section class="section">
  <div class="wrap">
    <article class="art-shell" id="post-<?php the_ID(); ?>">

      <nav class="art-crumbs" aria-label="<?php esc_attr_e( 'Sayfa yolu', 'bakirkoy-tip' ); ?>">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span>
        <a href="<?php echo esc_url( home_url( '/saglik-rehberi/' ) ); ?>"><?php esc_html_e( 'Sağlık Rehberi', 'bakirkoy-tip' ); ?></a> <span>/</span>
        <?php the_title(); ?>
      </nav>

      <header class="art-head">
        <?php if ( $bakirkoy_cats ) : ?>
          <span class="chip"><?php echo esc_html( $bakirkoy_cats[0]->name ); ?></span>
        <?php endif; ?>
        <h1><?php the_title(); ?></h1>
      </header>

      <!-- Yazar kutusu + son güncelleme (E-E-A-T) -->
      <div class="art-author">
        <span class="ava"><?php echo get_avatar( get_the_author_meta( 'ID' ), 112, '', '' ); ?></span>
        <div class="meta">
          <span class="who">
            <small><?php esc_html_e( 'Yazan', 'bakirkoy-tip' ); ?></small>
            <?php the_author(); ?>
          </span>
          <div class="dates">
            <span>
              <?php
              printf(
					/* translators: %s: yayın tarihi */
					esc_html__( 'Yayın: %s', 'bakirkoy-tip' ),
					esc_html( get_the_date( 'd.m.Y' ) )
				);
				?>
            </span>
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

      <?php if ( has_post_thumbnail() ) : ?>
        <figure class="art-hero">
          <?php the_post_thumbnail( 'large' ); ?>
        </figure>
      <?php endif; ?>

      <div class="art-body">
        <?php the_content(); ?>
      </div>

      <?php if ( $bakirkoy_kaynaklar ) : ?>
        <!-- Kaynakça (bakirkoy_kaynakca meta'sından) -->
        <section class="art-sources" aria-label="<?php esc_attr_e( 'Kaynaklar', 'bakirkoy-tip' ); ?>">
          <h2><?php esc_html_e( 'Kaynaklar', 'bakirkoy-tip' ); ?></h2>
          <ul>
            <?php foreach ( $bakirkoy_kaynaklar as $bakirkoy_kaynak ) : ?>
              <li><?php echo esc_html( $bakirkoy_kaynak ); ?></li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>

      <p class="art-disclaimer"><?php esc_html_e( 'Bu yazı bilgilendirme amaçlıdır; hekim muayenesi ve tıbbi tavsiye yerine geçmez. Şikâyetiniz devam ediyorsa lütfen bir sağlık kuruluşuna başvurun.', 'bakirkoy-tip' ); ?></p>

    </article>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
endwhile;

get_footer();
