<?php
/**
 * Randevu CTA bandı (koyu bölüm + geri arama formu).
 * Not: Form iskelettir; canlıda action bir form işleyiciye (ör. WPForms,
 * kendi REST endpoint'i vb.) bağlanmalıdır.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="section section--dark">
  <div class="wrap" style="display:grid; grid-template-columns:1fr 1fr; gap:clamp(2rem,5vw,4rem); align-items:center" id="randevu">
    <div>
      <span class="eyebrow"><?php esc_html_e( 'Randevu', 'bakirkoy-tip' ); ?></span>
      <h2 style="font-size:clamp(1.8rem,3.4vw,2.6rem); margin-bottom:.9rem"><?php esc_html_e( 'Üç bilgi yeterli, gerisini biz arıyoruz', 'bakirkoy-tip' ); ?></h2>
      <p class="lead"><?php esc_html_e( 'Formu doldurun, çalışma saatleri içinde 15 dakika içinde sizi arayarak size uygun saati birlikte belirleyelim. Dilerseniz doğrudan telefonla da randevu oluşturabilirsiniz.', 'bakirkoy-tip' ); ?></p>
      <div class="hero-actions" style="margin-top:1.5rem">
        <a class="btn btn--white" href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>"><?php echo esc_html( bakirkoy_tip_option( 'telefon' ) ); ?></a>
        <a class="btn btn--outline-light" href="<?php echo esc_url( bakirkoy_tip_wa_url() ); ?>"><?php esc_html_e( "WhatsApp'tan yazın", 'bakirkoy-tip' ); ?></a>
      </div>
    </div>
    <form class="form-card" action="#" method="post">
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
      <p class="hint" style="margin:.9rem 0 0; text-align:center; color:var(--muted); font-size:.82rem"><?php esc_html_e( 'Bilgileriniz üçüncü kişilerle paylaşılmaz.', 'bakirkoy-tip' ); ?></p>
    </form>
  </div>
</section>
