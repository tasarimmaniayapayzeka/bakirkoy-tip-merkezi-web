<?php
/**
 * Ana sayfa: hero + triyaj + birim grid'i + raporlar bandı + hekim grid'i
 * + rehber son yazılar + lokasyon + randevu CTA.
 * Statik index.html'in birebir sınıf isimleriyle WP'ye uyarlanmış hali.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- Hero: slider yok, tek net mesaj -->
<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <span class="eyebrow"><?php esc_html_e( "1998'den beri Bakırköy'de", 'bakirkoy-tip' ); ?></span>
      <h1><?php echo wp_kses_post( __( 'Semtinizde, <em>randevu beklemeden</em> uzman hekim muayenesi.', 'bakirkoy-tip' ) ); ?></h1>
      <p><?php esc_html_e( '14 branşta uzman kadro, aynı çatı altında laboratuvar ve görüntüleme. Tahlilinizi verdiğiniz gün sonucunuzu alın, hekiminizle aynı gün değerlendirin.', 'bakirkoy-tip' ); ?></p>
      <div class="hero-actions">
        <a class="btn btn--gold" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
          <?php esc_html_e( 'Online Randevu Al', 'bakirkoy-tip' ); ?>
        </a>
        <a class="btn btn--outline-light" href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
          <?php esc_html_e( 'Hemen Ara', 'bakirkoy-tip' ); ?>
        </a>
      </div>
      <div class="hero-trust">
        <div><strong><?php echo esc_html( wp_count_posts( 'birim' )->publish ); ?></strong><span><?php esc_html_e( 'Tıbbi birim', 'bakirkoy-tip' ); ?></span></div>
        <div><strong><?php echo esc_html( wp_count_posts( 'hekim' )->publish ); ?></strong><span><?php esc_html_e( 'Uzman hekim', 'bakirkoy-tip' ); ?></span></div>
        <div><strong><?php echo esc_html( absint( date_i18n( 'Y' ) ) - 1998 ); ?></strong><span><?php esc_html_e( 'Yıllık deneyim', 'bakirkoy-tip' ); ?></span></div>
        <div><strong><?php esc_html_e( 'SGK', 'bakirkoy-tip' ); ?></strong><span><?php esc_html_e( 've tamamlayıcı sigorta', 'bakirkoy-tip' ); ?></span></div>
      </div>
    </div>
    <div class="hero-media">
      <?php if ( has_post_thumbnail() ) : ?>
        <?php the_post_thumbnail( 'large', array( 'alt' => get_bloginfo( 'name' ), 'fetchpriority' => 'high' ) ); ?>
      <?php else : ?>
        <div class="ph" aria-hidden="true"></div>
      <?php endif; ?>
      <div class="float-card">
        <h3><?php esc_html_e( 'Bugün müsait misiniz?', 'bakirkoy-tip' ); ?></h3>
        <p><?php esc_html_e( 'Aynı gün randevu bulunabilir.', 'bakirkoy-tip' ); ?></p>
        <div class="row"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <?php esc_html_e( 'Muayene öncesi ödeme yok', 'bakirkoy-tip' ); ?></div>
        <a class="btn btn--primary btn--wide" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>"><?php esc_html_e( 'Saat Seç', 'bakirkoy-tip' ); ?></a>
      </div>
    </div>
  </div>
</section>

<!-- Triyaj: ziyaretçiyi niyetine göre ayır -->
<section class="triage">
  <div class="wrap triage-grid">
    <a class="triage-card" href="<?php echo esc_url( home_url( '/randevu/' ) ); ?>">
      <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg></span>
      <h3><?php esc_html_e( 'Randevu almak istiyorum', 'bakirkoy-tip' ); ?></h3>
      <p><?php esc_html_e( 'Branş ve hekim seçerek saat belirleyin.', 'bakirkoy-tip' ); ?></p>
      <span class="go"><?php esc_html_e( 'Randevu al', 'bakirkoy-tip' ); ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
    </a>
    <a class="triage-card" href="<?php echo esc_url( get_post_type_archive_link( 'birim' ) ); ?>">
      <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 3v18M3 12h18"/><rect x="3" y="3" width="18" height="18" rx="3"/></svg></span>
      <h3><?php esc_html_e( 'Şikâyetim var, nereye gideceğim?', 'bakirkoy-tip' ); ?></h3>
      <p><?php esc_html_e( 'Şikâyetinize göre doğru birimi bulun.', 'bakirkoy-tip' ); ?></p>
      <span class="go"><?php esc_html_e( 'Birimleri gör', 'bakirkoy-tip' ); ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
    </a>
    <a class="triage-card" href="<?php echo esc_url( get_post_type_archive_link( 'rapor_turu' ) ); ?>">
      <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 15h6M9 11h3"/></svg></span>
      <h3><?php esc_html_e( 'Sağlık raporu almam gerekiyor', 'bakirkoy-tip' ); ?></h3>
      <p><?php esc_html_e( 'İşe giriş, ehliyet, sporcu, evlilik raporu.', 'bakirkoy-tip' ); ?></p>
      <span class="go"><?php esc_html_e( 'Rapor işlemleri', 'bakirkoy-tip' ); ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
    </a>
    <a class="triage-card" href="<?php echo esc_url( home_url( '/iletisim/' ) ); ?>">
      <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
      <h3><?php esc_html_e( 'Nasıl gelirim, nereye park ederim?', 'bakirkoy-tip' ); ?></h3>
      <p><?php esc_html_e( 'Marmaray, metrobüs ve otopark bilgisi.', 'bakirkoy-tip' ); ?></p>
      <span class="go"><?php esc_html_e( 'Yol tarifi', 'bakirkoy-tip' ); ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
    </a>
  </div>
</section>

<!-- Tıbbi birimler: birim CPT loop -->
<section class="section">
  <div class="wrap">
    <div class="sec-head sec-head--row">
      <div>
        <span class="eyebrow"><?php esc_html_e( 'Tıbbi Birimler', 'bakirkoy-tip' ); ?></span>
        <h2><?php esc_html_e( 'Aynı çatı altında tüm branşlar', 'bakirkoy-tip' ); ?></h2>
        <p><?php esc_html_e( 'Muayene, tahlil ve görüntülemeyi tek ziyarette tamamlayın; birimler arası yönlendirme merkez içinde yapılır.', 'bakirkoy-tip' ); ?></p>
      </div>
      <a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'birim' ) ); ?>"><?php esc_html_e( 'Tüm birimler', 'bakirkoy-tip' ); ?></a>
    </div>
    <div class="dept-grid">
      <?php
      $bakirkoy_birimler = new WP_Query(
			array(
				'post_type'      => 'birim',
				'posts_per_page' => 12,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
				'no_found_rows'  => true,
			)
		);
		while ( $bakirkoy_birimler->have_posts() ) :
			$bakirkoy_birimler->the_post();
			get_template_part( 'template-parts/card-birim' );
		endwhile;
		wp_reset_postdata();
		?>
    </div>
  </div>
</section>

<!-- Sağlık raporları: yerel farklılaşma bandı -->
<section class="section section--tint">
  <div class="wrap">
    <div class="reports">
      <div class="reports-grid">
        <div>
          <span class="eyebrow"><?php esc_html_e( 'Aynı Gün Teslim', 'bakirkoy-tip' ); ?></span>
          <h2><?php esc_html_e( 'Sağlık raporunuzu tek ziyarette tamamlayın', 'bakirkoy-tip' ); ?></h2>
          <p><?php esc_html_e( 'Muayene, tahlil, işitme ve görme testi merkez içinde yapılır; raporunuz aynı gün elinize geçer. Randevu almanıza gerek yok, sıra bekleme süresini telefonla öğrenebilirsiniz.', 'bakirkoy-tip' ); ?></p>
          <a class="btn btn--gold" href="<?php echo esc_url( get_post_type_archive_link( 'rapor_turu' ) ); ?>"><?php esc_html_e( 'Rapor işlemleri ve gerekli belgeler', 'bakirkoy-tip' ); ?></a>
        </div>
        <ul class="report-list">
          <?php
          $bakirkoy_raporlar = new WP_Query(
				array(
					'post_type'      => 'rapor_turu',
					'posts_per_page' => 6,
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
					'no_found_rows'  => true,
				)
			);
			while ( $bakirkoy_raporlar->have_posts() ) :
				$bakirkoy_raporlar->the_post();
				?>
            <li><a href="<?php the_permalink(); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg> <?php the_title(); ?></a></li>
          <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Hekimler: hekim CPT loop -->
<section class="section">
  <div class="wrap">
    <div class="sec-head sec-head--row">
      <div>
        <span class="eyebrow"><?php esc_html_e( 'Hekim Kadromuz', 'bakirkoy-tip' ); ?></span>
        <h2><?php esc_html_e( 'Hekiminizi tanıyarak randevu alın', 'bakirkoy-tip' ); ?></h2>
        <p><?php esc_html_e( 'Her hekimimizin eğitim geçmişi, uzmanlık alanları ve çalışma günleri profilinde açıkça yer alır.', 'bakirkoy-tip' ); ?></p>
      </div>
      <a class="btn btn--ghost" href="<?php echo esc_url( get_post_type_archive_link( 'hekim' ) ); ?>"><?php esc_html_e( 'Tüm hekimler', 'bakirkoy-tip' ); ?></a>
    </div>
    <div class="doc-grid">
      <?php
      $bakirkoy_hekimler = new WP_Query(
			array(
				'post_type'      => 'hekim',
				'posts_per_page' => 4,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
				'no_found_rows'  => true,
			)
		);
		while ( $bakirkoy_hekimler->have_posts() ) :
			$bakirkoy_hekimler->the_post();
			get_template_part( 'template-parts/card-hekim' );
		endwhile;
		wp_reset_postdata();
		?>
    </div>
  </div>
</section>

<!-- Neden biz: kurumsal güven sinyalleri -->
<section class="section section--dark">
  <div class="wrap">
    <div class="sec-head center">
      <span class="eyebrow"><?php esc_html_e( 'Neden Bakırköy Tıp Merkezi', 'bakirkoy-tip' ); ?></span>
      <h2><?php esc_html_e( 'Zincire gitmeden, semtinizde tam donanım', 'bakirkoy-tip' ); ?></h2>
      <p><?php esc_html_e( 'Büyük hastanelerin sıra ve mesafe yükü olmadan, tıp merkezi ölçeğinde kişisel ilgi.', 'bakirkoy-tip' ); ?></p>
    </div>
    <div class="why-grid">
      <div class="why">
        <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
        <h3><?php esc_html_e( 'Aynı gün sonuç', 'bakirkoy-tip' ); ?></h3>
        <p><?php esc_html_e( 'Rutin biyokimya ve hemogram tetkikleri merkez laboratuvarımızda çalışılır, sonuçlar ortalama 2 saat içinde hekiminize ulaşır.', 'bakirkoy-tip' ); ?></p>
      </div>
      <div class="why">
        <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg></span>
        <h3><?php esc_html_e( 'SGK ve tamamlayıcı sigorta', 'bakirkoy-tip' ); ?></h3>
        <p><?php esc_html_e( 'SGK anlaşmamız ve tamamlayıcı sağlık sigortası anlaşmalarımız bulunmaktadır. Kapsam sorgusunu telefonla yapabilirsiniz.', 'bakirkoy-tip' ); ?></p>
      </div>
      <div class="why">
        <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 20h16M6 20V9l6-5 6 5v11"/><path d="M10 20v-5h4v5"/></svg></span>
        <h3><?php esc_html_e( 'Tek binada tüm süreç', 'bakirkoy-tip' ); ?></h3>
        <p><?php esc_html_e( 'Muayene, kan alma, ultrason ve röntgen aynı katlarda. Birimler arası yönlendirmede kayıt bilgileriniz tekrar istenmez.', 'bakirkoy-tip' ); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- Sağlık rehberi: son yazılar (E-E-A-T motoru) -->
<section class="section">
  <div class="wrap">
    <div class="sec-head sec-head--row">
      <div>
        <span class="eyebrow"><?php esc_html_e( 'Sağlık Rehberi', 'bakirkoy-tip' ); ?></span>
        <h2><?php esc_html_e( 'Hekimlerimizin kaleminden', 'bakirkoy-tip' ); ?></h2>
        <p><?php esc_html_e( 'Tüm içerikler ilgili branş hekimi tarafından yazılır ve güncellenir.', 'bakirkoy-tip' ); ?></p>
      </div>
      <a class="btn btn--ghost" href="<?php echo esc_url( home_url( '/saglik-rehberi/' ) ); ?>"><?php esc_html_e( 'Tüm yazılar', 'bakirkoy-tip' ); ?></a>
    </div>
    <div class="guide-grid">
      <?php
      $bakirkoy_yazilar = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'no_found_rows'  => true,
			)
		);
		while ( $bakirkoy_yazilar->have_posts() ) :
			$bakirkoy_yazilar->the_post();
			get_template_part( 'template-parts/card-rehber' );
		endwhile;
		wp_reset_postdata();
		?>
    </div>
  </div>
</section>

<!-- Lokasyon -->
<section class="section section--tint">
  <div class="wrap loc-grid">
    <div>
      <span class="eyebrow"><?php esc_html_e( 'Bize Ulaşın', 'bakirkoy-tip' ); ?></span>
      <h2 style="font-size:clamp(1.75rem,3.2vw,2.5rem); margin-bottom:.9rem"><?php esc_html_e( 'Bakırköy meydanına yürüme mesafesinde', 'bakirkoy-tip' ); ?></h2>
      <p class="lead" style="margin-bottom:1.5rem"><?php esc_html_e( 'Toplu taşımayla kolay ulaşım, merkeze ait kapalı otopark.', 'bakirkoy-tip' ); ?></p>
      <ul class="loc-list">
        <li>
          <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="4" y="3" width="16" height="14" rx="3"/><path d="M8 21l-2-3M16 21l2-3M4 11h16"/></svg></span>
          <div><strong><?php esc_html_e( 'Marmaray Bakırköy', 'bakirkoy-tip' ); ?></strong><span><?php esc_html_e( 'İstasyondan 6 dakika yürüme mesafesi', 'bakirkoy-tip' ); ?></span></div>
        </li>
        <li>
          <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="12" rx="2"/><path d="M7 21h10M6 17v4M18 17v4M3 11h18"/></svg></span>
          <div><strong><?php esc_html_e( 'Metrobüs İncirli / Zuhuratbaba', 'bakirkoy-tip' ); ?></strong><span><?php esc_html_e( 'Duraktan 4 dakika, düz yol', 'bakirkoy-tip' ); ?></span></div>
        </li>
        <li>
          <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M5 17h14M6 17V9l2-4h8l2 4v8"/><circle cx="8" cy="17" r="2"/><circle cx="16" cy="17" r="2"/></svg></span>
          <div><strong><?php esc_html_e( 'Kapalı otopark', 'bakirkoy-tip' ); ?></strong><span><?php esc_html_e( 'Hasta ve refakatçilere 2 saat ücretsiz', 'bakirkoy-tip' ); ?></span></div>
        </li>
        <li>
          <span class="ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
          <div><strong><?php esc_html_e( 'Çalışma saatleri', 'bakirkoy-tip' ); ?></strong><span><?php echo esc_html( bakirkoy_tip_option( 'calisma_saatleri' ) ); ?></span></div>
        </li>
      </ul>
    </div>
    <div>
      <div class="map-facade">
        <div>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <strong><?php echo esc_html( bakirkoy_tip_option( 'adres' ) ); ?></strong>
          <small><?php esc_html_e( 'Haritayı açmak için tıklayın', 'bakirkoy-tip' ); ?></small>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_template_part( 'template-parts/cta-randevu' ); ?>

<?php
get_footer();
