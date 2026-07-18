<?php
/**
 * Hekim arşivi: brans taksonomisine göre JS filtreli liste.
 * Statik hekimler.html'in uyarlaması (docfilter / doc-grid / data-spec).
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$bakirkoy_branslar = get_terms(
	array(
		'taxonomy'   => 'brans',
		'hide_empty' => true,
	)
);
?>
<style>
/* Sayfaya özel stiller — statik hekimler.html ile birebir */
.doclead{max-width:640px; margin-bottom:clamp(1.5rem,3vw,2.25rem)}
.doclead p{color:var(--ink-2); margin:0}
.docfilter{display:flex; flex-wrap:wrap; gap:.6rem; align-items:center; margin-bottom:clamp(1.5rem,3vw,2.25rem)}
.docfilter .flabel{font-size:.78rem; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:var(--brand-600); margin-right:.35rem}
.docfilter button{min-height:44px; padding:.55rem 1.15rem; border-radius:999px; border:1.5px solid var(--line); background:#fff; color:var(--ink-2); font-weight:700; font-size:.9rem; letter-spacing:-.01em; transition:.18s ease}
.docfilter button:hover{border-color:var(--brand-300); color:var(--brand-800); background:var(--brand-50)}
.docfilter button.is-active{background:var(--brand-700); border-color:var(--brand-700); color:#fff; box-shadow:0 6px 16px rgba(18,93,84,.24)}
.doc-count{font-size:.9rem; color:var(--muted); margin:0 0 1.25rem}
.doc-count strong{color:var(--ink)}
.doc-grid .doc[hidden]{display:none}
.docfilter-empty{display:none; text-align:center; padding:clamp(2rem,5vw,3.5rem); background:var(--bg-2); border:1px dashed var(--brand-300); border-radius:var(--radius-l); color:var(--ink-2)}
.docfilter-empty.show{display:block}
.docfilter-empty strong{display:block; font-size:1.1rem; color:var(--ink); margin-bottom:.4rem}
</style>

<!-- Sayfa başlığı -->
<section class="pagehead">
  <div class="wrap">
    <nav class="crumbs" aria-label="<?php esc_attr_e( 'Sayfa yolu', 'bakirkoy-tip' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span> <?php esc_html_e( 'Hekimlerimiz', 'bakirkoy-tip' ); ?>
    </nav>
    <h1><?php esc_html_e( 'Hekimlerimiz', 'bakirkoy-tip' ); ?></h1>
    <p><?php esc_html_e( 'Her hekimimizin eğitim geçmişi, uzmanlık alanları ve çalışma günleri açıkça yer alır. Branşınızı seçerek uygun hekimi bulun, profilini inceleyip randevu oluşturun.', 'bakirkoy-tip' ); ?></p>
  </div>
</section>

<!-- Hekim kadrosu — filtreli liste -->
<section class="section">
  <div class="wrap">

    <div class="doclead">
      <span class="eyebrow"><?php esc_html_e( 'Uzman Kadro', 'bakirkoy-tip' ); ?></span>
      <p><?php esc_html_e( 'Aşağıdaki listeyi branşa göre filtreleyebilirsiniz. Kartlardaki "Profili ve randevu" bağlantısı, hekimin ayrıntılı özgeçmişini ve randevu formunu açar.', 'bakirkoy-tip' ); ?></p>
    </div>

    <!-- Branş filtre çubuğu (brans taksonomisinden) -->
    <div class="docfilter" role="group" aria-label="<?php esc_attr_e( 'Branşa göre filtrele', 'bakirkoy-tip' ); ?>">
      <span class="flabel"><?php esc_html_e( 'Branş:', 'bakirkoy-tip' ); ?></span>
      <button type="button" data-filter="all" class="is-active" aria-pressed="true"><?php esc_html_e( 'Tümü', 'bakirkoy-tip' ); ?></button>
      <?php if ( ! is_wp_error( $bakirkoy_branslar ) ) : ?>
        <?php foreach ( $bakirkoy_branslar as $bakirkoy_brans ) : ?>
          <button type="button" data-filter="<?php echo esc_attr( $bakirkoy_brans->slug ); ?>" aria-pressed="false"><?php echo esc_html( $bakirkoy_brans->name ); ?></button>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <p class="doc-count" aria-live="polite"><strong id="docShown">0</strong> <?php esc_html_e( 'hekim listeleniyor', 'bakirkoy-tip' ); ?></p>

    <div class="doc-grid" id="docGrid">
      <?php
      if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card-hekim' );
			endwhile;
		endif;
		?>
    </div>

    <div class="docfilter-empty" id="docEmpty">
      <strong><?php esc_html_e( 'Bu branşta hekim bulunamadı.', 'bakirkoy-tip' ); ?></strong>
      <?php esc_html_e( 'Farklı bir branş seçebilir veya bize telefonla ulaşabilirsiniz.', 'bakirkoy-tip' ); ?>
    </div>

    <?php the_posts_pagination(); ?>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<script>
/* Branş filtresi — data-spec (brans slug) üzerinden istemci tarafı filtre */
(function(){
  var grid = document.getElementById('docGrid');
  var empty = document.getElementById('docEmpty');
  var shown = document.getElementById('docShown');
  var buttons = document.querySelectorAll('.docfilter button');
  if (!grid || !buttons.length) return;

  function apply(filter){
    var count = 0;
    grid.querySelectorAll('.doc').forEach(function(card){
      var match = (filter === 'all') || (card.getAttribute('data-spec') === filter);
      card.hidden = !match;
      if (match) count++;
    });
    if (shown) shown.textContent = String(count);
    if (empty) empty.classList.toggle('show', count === 0);
  }

  buttons.forEach(function(btn){
    btn.addEventListener('click', function(){
      buttons.forEach(function(b){
        b.classList.toggle('is-active', b === btn);
        b.setAttribute('aria-pressed', String(b === btn));
      });
      apply(btn.getAttribute('data-filter'));
    });
  });

  apply('all');
})();
</script>

<?php
get_footer();
