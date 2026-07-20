# Avrupa Tıp Merkezi — WordPress Teması (iskelet v0.1.0)

Statik demo sitenin (`bakirkoy-tip-merkezi-web/`) WordPress'e taşınması için hazırlanmış özel tema.
Tasarım sistemi statik demodaki `assets/css/style.css` ile birebir aynıdır; şablonlar aynı class
isimlerini kullanır, CSS değişmeden oturur.

> Not: Tema şu an **iskelet**tir. Çalışan bir WP kurulumu üzerinde test edilmemiştir;
> kurulum sonrası ilk kontrol listesi en alttadır.

## 1) Yerel WordPress kurulumu

1. Yerel sunucu (Laragon / LocalWP / XAMPP) üzerinde boş bir WordPress 6.x kurun (PHP 7.4+).
2. `Ayarlar → Genel`: Site başlığı **Özel Avrupa Tıp Merkezi**, slogan **Bakırköy · İstanbul**
   (header'daki logo-text bu iki alandan beslenir).
3. `Ayarlar → Kalıcı bağlantılar`: **Yazı adı** (post name) seçin (CPT rewrite'ları için şart).

## 2) Temayı kurma + statik assets kopyalama

1. Bu klasörü (`wp-tema/bakirkoy-tip/`) WP kurulumundaki `wp-content/themes/` altına kopyalayın.
2. Statik demodaki assets'i **temanın içine** kopyalayın (enqueue yolları buraya bakar):

   | Kaynak (statik demo)      | Hedef (tema içi)                          |
   |---------------------------|-------------------------------------------|
   | `assets/css/style.css`    | `wp-content/themes/bakirkoy-tip/assets/css/style.css` |
   | `assets/css/chatbot.css`  | `wp-content/themes/bakirkoy-tip/assets/css/chatbot.css` |
   | `assets/js/main.js`       | `wp-content/themes/bakirkoy-tip/assets/js/main.js` |
   | `assets/js/chatbot.js`    | `wp-content/themes/bakirkoy-tip/assets/js/chatbot.js` |
   | `assets/img/*`            | `wp-content/themes/bakirkoy-tip/assets/img/` (favicon vb.) — hekim/hero fotoğrafları ise **Medya kütüphanesine** yüklenecek |

   > `main.js` içindeki mobil menü CTA'sında `randevu.html` ve sabit telefon geçer;
   > WP'ye geçişte bu iki satırı `/randevu/` ve Customizer'daki telefona göre güncelleyin.
3. `Görünüm → Temalar` → **Avrupa Tıp Merkezi**'ni etkinleştirin.
   (Etkinleştirme sonrası bir kez `Ayarlar → Kalıcı bağlantılar → Kaydet` yapın; CPT rewrite'ları tazelenir.)

## 3) Customizer ayarları

`Görünüm → Özelleştir → Tıp Merkezi Bilgileri`:
telefon, WhatsApp, adres, çalışma saatleri, **mesul müdür**, **site içerik editörü + e-postası**, faaliyet izin belgesi.
Topbar, footer künyesi, mobil CTA barı ve Schema.org JSON-LD bu ayarlardan beslenir.
`Site kimliği` bölümünden logo da yükleyebilirsiniz (yüklenmezse demodaki artı işaretli SVG logo kullanılır).

## 4) İçerik girişi sırası

1. **Branşlar** (taksonomi, `Hekimler → Branşlar`): Kardiyoloji, İç Hastalıkları, Çocuk Sağlığı,
   Kadın Hastalıkları, Ortopedi, Genel Cerrahi, Göz Hastalıkları, KBB, Dermatoloji,
   Laboratuvar, Görüntüleme, Psikoloji, Fizik Tedavi, Beslenme ve Diyet.
2. **Tıbbi Birimler** (`birim` CPT): her birim için başlık + özet (pagehead açıklaması) + içerik
   (Birim Hakkında) + branş terimi + **Birim Bilgileri → Uygulanan tetkikler** meta'sı
   (satır başına `Tetkik adı | Kısa açıklama`).
3. **Hekimler** (`hekim` CPT): başlık = "Prof. Dr. Selim Arıkan" biçiminde; öne çıkan görsel (600×800, 3:4);
   özet = profil giriş paragrafı; içerik = "Hakkında"; branş terimi; **Hekim Bilgileri** meta kutusu:
   - Unvan: `Kardiyoloji Uzmanı`
   - Çalışma günleri: satır başına `Pazartesi: 09:00 – 17:00` / `Salı: Muayene yok` (ilk satır kartta özet olarak görünür)
   - Diller: `Türkçe, İngilizce`
   - Üyelikler: satır başına bir dernek (JSON-LD `memberOf` alanına da gider)
4. **Sağlık Raporları** (`rapor_turu` CPT): işe giriş, ehliyet, sporcu, evlilik, portör, öğrenci/yurt.
5. **Rehber yazıları** (normal Yazı): kategori = branş adı (kartlardaki chip); yazar = ilgili hekim
   kullanıcısı (yazar kutusu ve byline bundan beslenir); **Kaynakça** meta kutusuna satır başına bir kaynak.
6. **Sayfalar**: Hakkımızda, İletişim, Randevu, KVKK, Hasta Hakları, Anlaşmalı Kurumlar,
   Tahlil Sonuçları, Sağlık Rehberi (boş sayfa — yazı sayfası olarak atanacak).
7. `Ayarlar → Okuma`: "Ana sayfa" = statik bir sayfa (ör. boş "Ana Sayfa" sayfası; `front-page.php` devreye girer),
   "Yazılar sayfası" = **Sağlık Rehberi**.

## 5) Statik sayfa → WP eşlemesi

| Statik dosya                   | WP karşılığı                | Şablon                  |
|--------------------------------|-----------------------------|-------------------------|
| `index.html`                   | Ana sayfa (statik ön sayfa) | `front-page.php`        |
| `bolumler.html`                | `birim` arşivi `/bolumler/` | `archive-birim.php`     |
| `bolum-*.html` (14 adet)       | `birim` kayıtları           | `single-birim.php`      |
| `hekimler.html`                | `hekim` arşivi `/hekimler/` | `archive-hekim.php`     |
| `hekim-*.html` (12 adet)       | `hekim` kayıtları           | `single-hekim.php`      |
| `saglik-raporlari.html`        | `rapor_turu` arşivi `/saglik-raporlari/` | `archive-rapor_turu.php` |
| — (raporlar tek sayfadaydı)    | rapor türü başına bir kayıt | `single-rapor_turu.php` |
| `saglik-rehberi.html`          | Yazılar sayfası             | `index.php`             |
| `rehber-*.html` (9 adet)       | Yazılar (kategori = branş)  | `single.php`            |
| `hakkimizda/iletisim/kvkk/hasta-haklari/anlasmali-kurumlar/tahlil-sonuclari/randevu.html` | Sayfalar | `page.php` |
| `404.html`                     | —                           | `404.php`               |
| `en/index.html`                | (iskelet kapsamı dışı — çok dillilik için Polylang/WPML) | — |

## 6) Menü kurulumu

`Görünüm → Menüler`de üç menü oluşturup konumlara atayın:

- **Ana Menü** (`primary`): Ana Sayfa, Tıbbi Birimler (birim arşivi), Hekimlerimiz (hekim arşivi),
  Sağlık Raporları (rapor arşivi), Sağlık Rehberi, İletişim.
  (Şablon çıplak `<a>` üretir; mobil paneli `main.js` bu bağlantılardan kurar.)
- **Footer — Kurumsal** (`footer-kurumsal`): Hakkımızda, Hekimlerimiz, Anlaşmalı Kurumlar, Hasta Hakları, İletişim.
- **Footer — Hizmetler** (`footer-hizmetler`): Tıbbi Birimler, Sağlık Raporları, Online Randevu,
  Tahlil Sonuçları, Sağlık Rehberi.

## Teknik notlar

- **Meta alanları** saf WP `register_post_meta` ile kayıtlıdır (`show_in_rest: true`) ve klasik
  meta kutuları eklenmiştir; ACF/CMB2 gerekmez.
- **Güvenlik**: XML-RPC kapalı, `?author=` numaralandırma 301 ile engelli, REST `/users` yetkisiz
  erişime kapalı, kullanıcı sitemap'i kaldırıldı, WP sürümü gizli (EsteTouch eklentisindeki yaklaşım).
- **JSON-LD**: ana sayfa `MedicalClinic`, hekim `Physician`, birim `MedicalWebPage` —
  alanlar Customizer + post meta'dan üretilir.
- Sayfaya özel stiller (docfilter, prof-*, kd-*, art-*) statik demodaki gibi şablon içi
  `<style>` bloklarındadır; istenirse ayrı dosyalara taşınıp koşullu enqueue edilebilir.
- Randevu formları iskelettir (`action="#"`); canlıda bir form işleyiciye bağlanmalıdır.

## Kurulum sonrası ilk kontrol listesi

- [ ] Kalıcı bağlantılar kaydedildi, `/hekimler/`, `/bolumler/`, `/saglik-raporlari/` açılıyor.
- [ ] Hekim arşivinde branş filtresi çalışıyor (buton → kartlar süzülüyor).
- [ ] Footer künyesinde mesul müdür / editör / son güncelleme doğru görünüyor.
- [ ] Hekim detayında JSON-LD `Physician` çıktısı doğrulandı (Rich Results Test).
- [ ] `main.js` içindeki `randevu.html` ve telefon satırları WP'ye göre güncellendi.
