<?php
/**
 * Hekim profili: prof-hero + içerik blokları + randevu yan paneli.
 * Statik hekim-selim-arikan.html'in uyarlaması; alanlar post meta'dan gelir:
 * - bakirkoy_unvan            (tek satır)
 * - bakirkoy_calisma_gunleri  (satır başına "Gün: saat")
 * - bakirkoy_diller           (virgülle ayrılmış)
 * - bakirkoy_uyelikler        (satır başına bir üyelik)
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$bakirkoy_id      = get_the_ID();
	$bakirkoy_unvan   = get_post_meta( $bakirkoy_id, 'bakirkoy_unvan', true );
	$bakirkoy_gunler  = bakirkoy_tip_meta_lines( $bakirkoy_id, 'bakirkoy_calisma_gunleri' );
	$bakirkoy_diller  = array_filter( array_map( 'trim', explode( ',', (string) get_post_meta( $bakirkoy_id, 'bakirkoy_diller', true ) ) ) );
	$bakirkoy_uyelik  = bakirkoy_tip_meta_lines( $bakirkoy_id, 'bakirkoy_uyelikler' );
	$bakirkoy_terms   = get_the_terms( $bakirkoy_id, 'brans' );
	$bakirkoy_brans   = ( $bakirkoy_terms && ! is_wp_error( $bakirkoy_terms ) ) ? $bakirkoy_terms[0] : null;
	?>

<style>
/* Sayfaya özel stiller — statik hekim profil sayfası ile birebir */
.prof-hero{background:var(--brand-950); color:#fff; padding:clamp(1.75rem,4vw,2.75rem) 0 clamp(2.5rem,5vw,4rem)}
.prof-hero .crumbs{margin-bottom:clamp(1.25rem,3vw,1.75rem)}
.prof-head{display:grid; grid-template-columns:290px 1fr; gap:clamp(1.5rem,4vw,3rem); align-items:center}
@media (max-width:820px){ .prof-head{grid-template-columns:1fr; gap:1.5rem} }
.prof-photo{position:relative; border-radius:var(--radius-l); overflow:hidden; aspect-ratio:3/4; max-width:290px; border:1px solid rgba(255,255,255,.14); box-shadow:var(--shadow-l); background:var(--brand-800)}
@media (max-width:820px){ .prof-photo{max-width:220px} }
.prof-photo img{width:100%; height:100%; object-fit:cover}
.prof-spec-badge{display:inline-flex; align-items:center; gap:.5rem; background:rgba(217,180,95,.15); color:var(--gold-400); border:1px solid rgba(217,180,95,.32); padding:.4rem .9rem; border-radius:999px; font-weight:700; font-size:.8rem; letter-spacing:.03em; margin-bottom:1rem}
.prof-spec-badge svg{width:16px; height:16px}
.prof-head h1{font-size:clamp(1.85rem,3.8vw,2.8rem); margin-bottom:.4rem; letter-spacing:-.03em}
.prof-role{color:var(--gold-400); font-weight:700; font-size:1.08rem; margin-bottom:1rem}
.prof-intro{color:#B9D3CE; max-width:58ch; margin-bottom:1.6rem}
.prof-actions{display:flex; flex-wrap:wrap; gap:.85rem}
.prof-facts{display:flex; flex-wrap:wrap; gap:1.6rem; margin-top:1.6rem; padding-top:1.5rem; border-top:1px solid rgba(255,255,255,.13)}
.prof-facts div span{display:block; font-size:.72rem; color:#9CBAB5; text-transform:uppercase; letter-spacing:.11em; margin-bottom:.2rem}
.prof-facts div strong{font-size:.98rem; color:#fff; font-weight:700}
.profwrap{display:grid; grid-template-columns:1.7fr .9fr; gap:clamp(2rem,4vw,3.5rem); align-items:start}
@media (max-width:940px){ .profwrap{grid-template-columns:1fr} }
.profblock{margin-bottom:clamp(2rem,4vw,3rem)}
.profblock:last-child{margin-bottom:0}
.profblock h2{font-size:clamp(1.35rem,2.4vw,1.85rem); margin-bottom:1.1rem; padding-bottom:.65rem; border-bottom:1px solid var(--line); position:relative}
.profblock h2::after{content:""; position:absolute; left:0; bottom:-1px; width:54px; height:3px; background:var(--gold-500); border-radius:2px}
.profblock > p{color:var(--ink-2); margin-bottom:1rem}
.tags{display:flex; flex-wrap:wrap; gap:.6rem}
.tags span{background:var(--brand-50); color:var(--brand-800); border:1px solid var(--brand-100); border-radius:999px; padding:.5rem 1rem; font-weight:600; font-size:.9rem}
.langs{display:grid; gap:.7rem}
.langs li{display:flex; align-items:center; gap:.8rem; font-size:.96rem}
.langs .dot{width:10px; height:10px; border-radius:50%; background:var(--brand-500); flex:none}
.langs b{font-weight:700}
.days-table{width:100%; border-collapse:collapse; border:1px solid var(--line); border-radius:var(--radius); overflow:hidden}
.days-table th,.days-table td{padding:.8rem 1.1rem; text-align:left; border-bottom:1px solid var(--line); font-size:.94rem}
.days-table th{background:var(--brand-50); font-weight:700; width:48%}
.days-table tr:last-child td,.days-table tr:last-child th{border-bottom:0}
.days-table td.on{color:var(--brand-700); font-weight:700}
.days-table td.off{color:var(--muted)}
.prof-aside{display:grid; gap:1.25rem; position:sticky; top:100px}
@media (max-width:940px){ .prof-aside{position:static} }
.form-card h3{font-size:1.2rem; margin-bottom:.35rem}
.form-card .form-sub{font-size:.9rem; color:var(--muted); margin-bottom:1.25rem}
.quick-card{background:var(--bg-2); border:1px solid var(--line); border-radius:var(--radius-l); padding:1.35rem 1.5rem}
.quick-card h3{font-size:1.02rem; margin-bottom:1rem}
.quick-card ul{display:grid; gap:.7rem}
.quick-card li{display:flex; gap:.75rem; align-items:flex-start; font-size:.92rem}
.quick-card .ico{width:34px; height:34px; border-radius:10px; background:var(--brand-50); display:grid; place-items:center; flex:none}
.quick-card .ico svg{width:18px; height:18px; color:var(--brand-700)}
.quick-card b{display:block; font-weight:700; font-size:.86rem}
.quick-card span{color:var(--muted); font-size:.85rem}
.prof-legal{margin-top:clamp(2rem,4vw,3rem); padding:1.1rem 1.35rem; background:var(--bg-2); border:1px solid var(--line); border-radius:var(--radius); color:var(--muted); font-size:.83rem; line-height:1.65}
</style>

<!-- Profil başlık bölümü -->
<section class="prof-hero">
  <div class="wrap">
    <nav class="crumbs" aria-label="<?php esc_attr_e( 'Sayfa yolu', 'bakirkoy-tip' ); ?>">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Ana Sayfa', 'bakirkoy-tip' ); ?></a> <span>/</span>
      <a href="<?php echo esc_url( get_post_type_archive_link( 'hekim' ) ); ?>"><?php esc_html_e( 'Hekimlerimiz', 'bakirkoy-tip' ); ?></a> <span>/</span>
      <?php the_title(); ?>
    </nav>
    <div class="prof-head">
      <div class="prof-photo">
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'bakirkoy-hekim', array( 'alt' => get_the_title() . ( $bakirkoy_unvan ? ', ' . $bakirkoy_unvan : '' ), 'fetchpriority' => 'high' ) ); ?>
        <?php endif; ?>
      </div>
      <div>
        <?php if ( $bakirkoy_brans ) : ?>
          <span class="prof-spec-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 5.6a5.5 5.5 0 0 0-7.8 0L12 6.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 22l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
            <?php echo esc_html( $bakirkoy_brans->name ); ?>
          </span>
        <?php endif; ?>
        <h1><?php the_title(); ?></h1>
        <?php if ( $bakirkoy_unvan ) : ?>
          <p class="prof-role"><?php echo esc_html( $bakirkoy_unvan ); ?></p>
        <?php endif; ?>
        <?php if ( has_excerpt() ) : ?>
          <p class="prof-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
        <div class="prof-actions">
          <a class="btn btn--gold" href="#randevu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
            <?php esc_html_e( 'Randevu Al', 'bakirkoy-tip' ); ?>
          </a>
          <a class="btn btn--outline-light" href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            <?php echo esc_html( __( 'Ara:', 'bakirkoy-tip' ) . ' ' . bakirkoy_tip_option( 'telefon' ) ); ?>
          </a>
        </div>
        <div class="prof-facts">
          <?php if ( $bakirkoy_brans ) : ?>
            <div><span><?php esc_html_e( 'Branş', 'bakirkoy-tip' ); ?></span><strong><?php echo esc_html( $bakirkoy_brans->name ); ?></strong></div>
          <?php endif; ?>
          <?php if ( $bakirkoy_gunler ) : ?>
            <div><span><?php esc_html_e( 'Çalışma günleri', 'bakirkoy-tip' ); ?></span><strong><?php echo esc_html( $bakirkoy_gunler[0] ); ?></strong></div>
          <?php endif; ?>
          <?php if ( $bakirkoy_diller ) : ?>
            <div><span><?php esc_html_e( 'Diller', 'bakirkoy-tip' ); ?></span><strong><?php echo esc_html( implode( ' · ', $bakirkoy_diller ) ); ?></strong></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Profil gövdesi -->
<section class="section">
  <div class="wrap profwrap">

    <!-- Sol: içerik blokları -->
    <div>

      <div class="profblock">
        <h2><?php esc_html_e( 'Hakkında', 'bakirkoy-tip' ); ?></h2>
        <?php the_content(); ?>
      </div>

      <?php if ( $bakirkoy_uyelik ) : ?>
      <div class="profblock">
        <h2><?php esc_html_e( 'Mesleki Üyelikler', 'bakirkoy-tip' ); ?></h2>
        <div class="tags">
          <?php foreach ( $bakirkoy_uyelik as $bakirkoy_u ) : ?>
            <span><?php echo esc_html( $bakirkoy_u ); ?></span>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <?php if ( $bakirkoy_diller ) : ?>
      <div class="profblock">
        <h2><?php esc_html_e( 'Konuşulan Diller', 'bakirkoy-tip' ); ?></h2>
        <ul class="langs">
          <?php foreach ( $bakirkoy_diller as $bakirkoy_dil ) : ?>
            <li><span class="dot"></span><b><?php echo esc_html( $bakirkoy_dil ); ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <?php if ( $bakirkoy_gunler ) : ?>
      <div class="profblock">
        <h2><?php esc_html_e( 'Çalışma Günleri', 'bakirkoy-tip' ); ?></h2>
        <table class="days-table">
          <tbody>
            <?php
            foreach ( $bakirkoy_gunler as $bakirkoy_satir ) :
					// Beklenen biçim: "Pazartesi: 09:00 – 17:00" — ilk iki nokta üstü üzerinden ayrılır.
					$bakirkoy_parca = array_map( 'trim', explode( ':', $bakirkoy_satir, 2 ) );
					$bakirkoy_gun   = $bakirkoy_parca[0];
					$bakirkoy_saat  = isset( $bakirkoy_parca[1] ) ? $bakirkoy_parca[1] : '';
					$bakirkoy_yok   = ( '' === $bakirkoy_saat || false !== mb_stripos( $bakirkoy_saat, 'yok' ) || false !== mb_stripos( $bakirkoy_saat, 'kapalı' ) );
					?>
              <tr>
                <th scope="row"><?php echo esc_html( $bakirkoy_gun ); ?></th>
                <td class="<?php echo $bakirkoy_yok ? 'off' : 'on'; ?>"><?php echo esc_html( $bakirkoy_saat ? $bakirkoy_saat : __( 'Muayene yok', 'bakirkoy-tip' ) ); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p style="margin-top:1rem; font-size:.85rem; color:var(--muted)"><?php esc_html_e( 'Randevu saatleri yoğunluğa göre değişebilir; kesin saat için randevu oluşturmanız önerilir.', 'bakirkoy-tip' ); ?></p>
      </div>
      <?php endif; ?>

    </div>

    <!-- Sağ: randevu formu + hızlı bilgi -->
    <aside class="prof-aside" aria-label="<?php esc_attr_e( 'Randevu ve iletişim', 'bakirkoy-tip' ); ?>">

      <form class="form-card" action="#" method="post" id="randevu">
        <h3><?php esc_html_e( 'Randevu Al', 'bakirkoy-tip' ); ?></h3>
        <p class="form-sub"><?php echo esc_html( get_the_title() . ( $bakirkoy_brans ? ' — ' . $bakirkoy_brans->name : '' ) ); ?></p>
        <div class="field">
          <label for="bakirkoy-ad"><?php esc_html_e( 'Ad Soyad', 'bakirkoy-tip' ); ?></label>
          <input id="bakirkoy-ad" name="ad" type="text" autocomplete="name" required>
        </div>
        <div class="field">
          <label for="bakirkoy-tel"><?php esc_html_e( 'Telefon', 'bakirkoy-tip' ); ?></label>
          <input id="bakirkoy-tel" name="tel" type="tel" inputmode="tel" autocomplete="tel" placeholder="05XX XXX XX XX" required>
        </div>
        <div class="field">
          <label for="bakirkoy-zaman"><?php esc_html_e( 'Size ne zaman ulaşalım?', 'bakirkoy-tip' ); ?></label>
          <select id="bakirkoy-zaman" name="zaman">
            <option><?php esc_html_e( 'En kısa sürede', 'bakirkoy-tip' ); ?></option>
            <option><?php esc_html_e( 'Bugün öğleden sonra', 'bakirkoy-tip' ); ?></option>
            <option><?php esc_html_e( 'Yarın sabah', 'bakirkoy-tip' ); ?></option>
            <option><?php esc_html_e( 'Hafta içi mesai sonrası', 'bakirkoy-tip' ); ?></option>
          </select>
        </div>
        <label class="consent">
          <input type="checkbox" name="kvkk" required>
          <span><a href="<?php echo esc_url( home_url( '/kvkk/' ) ); ?>"><?php esc_html_e( 'Aydınlatma metnini', 'bakirkoy-tip' ); ?></a> <?php esc_html_e( 'okudum; iletişim bilgilerimin yalnızca randevu oluşturmak amacıyla işlenmesine açık rıza veriyorum.', 'bakirkoy-tip' ); ?></span>
        </label>
        <button class="btn btn--gold btn--wide" type="submit"><?php esc_html_e( 'Beni Arayın', 'bakirkoy-tip' ); ?></button>
      </form>

      <div class="quick-card">
        <h3><?php esc_html_e( 'Hızlı bilgi', 'bakirkoy-tip' ); ?></h3>
        <ul>
          <?php if ( $bakirkoy_brans ) : ?>
          <li>
            <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.8 5.6a5.5 5.5 0 0 0-7.8 0L12 6.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 22l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg></span>
            <div><b><?php esc_html_e( 'Branş', 'bakirkoy-tip' ); ?></b><span><?php echo esc_html( $bakirkoy_brans->name ); ?></span></div>
          </li>
          <?php endif; ?>
          <li>
            <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
            <div><b><?php esc_html_e( 'Konum', 'bakirkoy-tip' ); ?></b><span><?php echo esc_html( bakirkoy_tip_option( 'adres' ) ); ?></span></div>
          </li>
          <li>
            <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span>
            <div><b><?php esc_html_e( 'Telefon', 'bakirkoy-tip' ); ?></b><span><a href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>" style="color:var(--brand-700); font-weight:700"><?php echo esc_html( bakirkoy_tip_option( 'telefon' ) ); ?></a></span></div>
          </li>
        </ul>
      </div>

    </aside>

  </div>

  <div class="wrap">
    <p class="prof-legal"><?php esc_html_e( 'Hekim unvanları yalnızca resmî akademik ve tıbbi unvanlar (Uzm. Dr., Op. Dr., Doç. Dr., Prof. Dr.) ile belirtilir. Sayfadaki içerikler bilgilendirme amaçlıdır; hekim muayenesi ve tıbbi değerlendirme yerine geçmez.', 'bakirkoy-tip' ); ?></p>
  </div>
</section>

<?php
endwhile;

get_footer();
