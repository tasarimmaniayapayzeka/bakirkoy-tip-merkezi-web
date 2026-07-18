<?php
/**
 * Tema alt bilgisi: footer menüleri + mevzuat künyesi + mobil CTA barı.
 * Künyedeki "son güncellenme" görüntülenen içeriğin değiştirilme tarihidir;
 * mesul müdür / editör bilgileri Customizer'dan gelir.
 *
 * @package Bakirkoy_Tip
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bakirkoy_last_update = is_singular() ? get_the_modified_date( 'd.m.Y' ) : date_i18n( 'd.m.Y' );
?>
</main>

<!-- Footer -->
<footer class="footer">
  <div class="wrap">
    <div class="footer-grid">
      <div>
        <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <span class="logo-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 3v18M3 12h18"/></svg></span>
          <span class="logo-text"><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong><small><?php echo esc_html( get_bloginfo( 'description' ) ); ?></small></span>
        </a>
        <p class="footer-note">
          <?php echo esc_html( bakirkoy_tip_option( 'adres' ) ); ?><br>
          <a href="<?php echo esc_url( bakirkoy_tip_phone_href() ); ?>"><?php echo esc_html( bakirkoy_tip_option( 'telefon' ) ); ?></a> ·
          <a href="mailto:<?php echo esc_attr( antispambot( bakirkoy_tip_option( 'editor_eposta' ) ) ); ?>"><?php echo esc_html( antispambot( bakirkoy_tip_option( 'editor_eposta' ) ) ); ?></a>
        </p>
      </div>
      <div>
        <h4><?php esc_html_e( 'Kurumsal', 'bakirkoy-tip' ); ?></h4>
        <?php
        wp_nav_menu(
			array(
				'theme_location' => 'footer-kurumsal',
				'container'      => false,
				'menu_class'     => '',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		?>
      </div>
      <div>
        <h4><?php esc_html_e( 'Hizmetler', 'bakirkoy-tip' ); ?></h4>
        <?php
        wp_nav_menu(
			array(
				'theme_location' => 'footer-hizmetler',
				'container'      => false,
				'menu_class'     => '',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		?>
      </div>
      <div>
        <h4><?php esc_html_e( 'Yasal', 'bakirkoy-tip' ); ?></h4>
        <ul>
          <li><a href="<?php echo esc_url( home_url( '/kvkk/' ) ); ?>"><?php esc_html_e( 'KVKK Aydınlatma Metni', 'bakirkoy-tip' ); ?></a></li>
          <li><a href="<?php echo esc_url( home_url( '/kvkk/' ) ); ?>"><?php esc_html_e( 'Çerez Politikası', 'bakirkoy-tip' ); ?></a></li>
          <li><a href="<?php echo esc_url( home_url( '/hasta-haklari/' ) ); ?>"><?php esc_html_e( 'Hasta Hakları', 'bakirkoy-tip' ); ?></a></li>
        </ul>
      </div>
    </div>

    <!-- Mevzuat gereği zorunlu künye -->
    <div class="compliance">
      <strong><?php esc_html_e( 'Kurum unvanı:', 'bakirkoy-tip' ); ?></strong> <?php echo esc_html( get_bloginfo( 'name' ) ); ?> &nbsp;·&nbsp;
      <strong><?php esc_html_e( 'Mesul müdür:', 'bakirkoy-tip' ); ?></strong> <?php echo esc_html( bakirkoy_tip_option( 'mesul_mudur' ) ); ?> &nbsp;·&nbsp;
      <strong><?php esc_html_e( 'Faaliyet izin belgesi:', 'bakirkoy-tip' ); ?></strong> <?php echo esc_html( bakirkoy_tip_option( 'faaliyet_no' ) ); ?><br>
      <strong><?php esc_html_e( 'Site içerik editörü:', 'bakirkoy-tip' ); ?></strong> <?php echo esc_html( bakirkoy_tip_option( 'editor_ad' ) ); ?> — <?php echo esc_html( antispambot( bakirkoy_tip_option( 'editor_eposta' ) ) ); ?> &nbsp;·&nbsp;
      <strong><?php esc_html_e( 'Bu sayfadaki bilgilerin son güncellenme tarihi:', 'bakirkoy-tip' ); ?></strong> <?php echo esc_html( $bakirkoy_last_update ); ?><br>
      <?php esc_html_e( 'Bu sitedeki içerikler yalnızca bilgilendirme amaçlıdır, hekim muayenesi ve tıbbi tavsiye yerine geçmez.', 'bakirkoy-tip' ); ?>
    </div>

    <div class="footer-legal">
      <span>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'Tüm hakları saklıdır.', 'bakirkoy-tip' ); ?></span>
    </div>
  </div>
</footer>

<?php get_template_part( 'template-parts/mobilebar' ); ?>

<?php wp_footer(); ?>
</body>
</html>
