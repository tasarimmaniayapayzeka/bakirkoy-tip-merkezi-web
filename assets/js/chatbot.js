/* ==========================================================================
   Özel Avrupa Tıp Merkezi — Sağlık Asistanı (DEMO)
   Kurallı (rule-based) sohbet motoru — saf vanilla JS, harici istek YOK.
   KVKK sadeliği: localStorage / çerez / sunucu kaydı KULLANILMAZ.
   Tüm DOM'u kendisi kurar; sayfaya eklemek için chatbot.css + bu dosya yeter.
   ========================================================================== */
(() => {
  "use strict";

  const TEL_MERKEZ  = "tel:+904440000";
  const REPLY_DELAY = 400; // ms — "yazıyor…" göstergesi süresi

  /* ---------------------------------------------------------------------
     Türkçe normalizasyon: küçük harf + türkçe karakter sadeleştirme
     --------------------------------------------------------------------- */
  const TR_MAP = { "ç":"c", "ğ":"g", "ı":"i", "ö":"o", "ş":"s", "ü":"u", "â":"a", "î":"i", "û":"u" };
  const norm = (s) => s
    .toLocaleLowerCase("tr")
    .replace(/[çğıöşüâîû]/g, (ch) => TR_MAP[ch] || ch)
    .replace(/[^a-z0-9\s]/g, " ")
    .replace(/\s+/g, " ")
    .trim();

  /* Anahtar kelime eşleşme kuralları:
     "~kok"      → herhangi bir kelime bu kökle BAŞLIYORSA (agri → agrisi, agriyor)
     "iki kelime"→ metin içinde kalıp olarak geçiyorsa
     >= 5 harf   → metin içinde parça olarak geçiyorsa (sonuc → sonuclarim)
     <  5 harf   → kelimenin TAM kendisiyse (yanlış pozitif önlenir: "acil" ≠ "açılıyor") */
  const hits = (kw, text, tokens) => {
    if (kw.charAt(0) === "~") {
      const root = kw.slice(1);
      return tokens.some((t) => t.indexOf(root) === 0);
    }
    if (kw.indexOf(" ") > -1 || kw.length >= 5) return text.indexOf(kw) > -1;
    return tokens.indexOf(kw) > -1;
  };
  const scoreOf = (kws, text, tokens) =>
    kws.reduce((sum, kw) => sum + (hits(kw, text, tokens) ? Math.max(kw.replace("~", "").length, 3) : 0), 0);

  /* ---------------------------------------------------------------------
     GÜVENLİK KURALLARI (öncelik sırasıyla kontrol edilir)
     --------------------------------------------------------------------- */
  // a) EN ÖNCELİKLİ: acil durum kalıpları
  const ACIL_KW = [
    "acil", "acilen", "112", "ambulans",
    "nefes alamiyorum", "nefes alamiyor", "nefes daralmasi", "nefesim daraliyor",
    "gogsumde baski", "gogus agrisi", "gogsum sikisiyor", "gogsum agriyor",
    "bilinc", "bayildi", "bayiliyor", "bayilma", "~zehirlen",
    "kalp krizi", "inme", "felc", "intihar", "kriz geciriyor"
  ];
  const ACIL_REPLY = {
    alert: true,
    text: "🚨 Acil bir durum yaşıyorsanız lütfen hemen 112'yi arayın.\nBu asistan acil durumlar için uygun değildir; zaman kaybetmeyin.",
    actions: [{ label: "112'yi Ara", href: "tel:112", danger: true }]
  };

  // b) Semptom / teşhis kalıpları → sabit güvenli yanıt
  const SEMPTOM_KW = [
    "~agri", "sanci", "~ates", "carpinti", "kanama", "bas donmesi", "~donme",
    "bulanti", "kusma", "ishal", "~kabiz", "oksuruk", "~ilac", "tedavi",
    "teshis", "tani", "belirti", "semptom", "uyusma", "sislik", "kasinti",
    "kirik", "~burkul", "migren", "alerji", "tansiyon", "halsiz", "~titreme",
    "morarma", "~kramp", "yanma hissi", "iltihap"
  ];
  const SEMPTOM_REPLY = {
    text: "Belirtileriniz hakkında yorum yapamam; değerlendirmeyi yalnızca hekiminiz yapabilir.\nUygun birimi bulmanıza ve randevu oluşturmanıza yardımcı olabilirim.",
    actions: [
      { label: "Tıbbi Birimler", href: "bolumler.html" },
      { label: "Randevu Al", href: "randevu.html" }
    ]
  };

  /* ---------------------------------------------------------------------
     INTENT LİSTESİ — {ad, anahtar kelimeler, yanıt + hızlı eylemler}
     Skorlama: eşleşen anahtar kelimelerin ağırlık toplamı; en yüksek kazanır.
     --------------------------------------------------------------------- */
  const INTENTS = [
    {
      name: "fiyat",
      kw: ["fiyat", "ucret", "ne kadar", "kac para", "kac tl", "kac lira", "kaca", "maliyet", "fiyat listesi", "muayene ucreti"],
      reply: {
        text: "Mevzuat gereği web üzerinden fiyat bilgisi paylaşamıyoruz; 444 0 000 numaralı çağrı merkezimizden güncel bilgi alabilirsiniz.",
        actions: [{ label: "444 0 000'ı Ara", href: TEL_MERKEZ }]
      }
    },
    {
      name: "randevu",
      kw: ["randevu", "randevu al", "muayene ol", "kayit yaptir", "rezervasyon", "saat sec"],
      reply: {
        text: "Online randevu sayfamızdan branş ve hekim seçerek size uygun saati belirleyebilirsiniz. Dilerseniz 444 0 000'dan telefonla da randevu oluşturabilirsiniz.",
        actions: [
          { label: "Randevu Sayfasına Git", href: "randevu.html" },
          { label: "444 0 000'ı Ara", href: TEL_MERKEZ }
        ]
      }
    },
    {
      name: "saatler",
      kw: ["saat", "saatler", "calisma saat", "kacta", "kaca kadar", "acik mi", "kapali mi", "~kapanis", "~acilis", "mesai", "hafta sonu", "cumartesi", "pazar"],
      reply: {
        text: "Çalışma saatlerimiz:\n• Hafta içi 08:30 – 20:00\n• Cumartesi 09:00 – 17:00\n• Pazar günleri kapalıyız.",
        actions: [{ label: "Randevu Al", href: "randevu.html" }]
      }
    },
    {
      name: "ulasim",
      kw: ["adres", "~ulas", "nerede", "neredesiniz", "nasil gelir", "nasil giderim", "yol tarifi", "otopark", "park", "marmaray", "metrobus", "metro", "konum", "harita", "toplu tasima"],
      reply: {
        text: "Adresimiz: Zuhuratbaba Mah. Örnek Cad. No:00, Bakırköy / İstanbul.\n• Marmaray Bakırköy istasyonundan 6 dk yürüme\n• Metrobüs İncirli / Zuhuratbaba durağından 4 dk\n• Kapalı otoparkımızda hasta ve refakatçilere 2 saat ücretsiz",
        actions: [{ label: "Yol Tarifi ve İletişim", href: "iletisim.html" }]
      }
    },
    {
      name: "telefon",
      kw: ["telefon", "numara", "cagri merkezi", "444", "hattiniz", "aramak", "arayabilir", "whatsapp"],
      reply: {
        text: "Çağrı merkezimiz: 444 0 000. Çalışma saatleri içinde randevu, sıra durumu ve kapsam sorularınız için arayabilirsiniz.",
        actions: [
          { label: "444 0 000'ı Ara", href: TEL_MERKEZ },
          { label: "İletişim Sayfası", href: "iletisim.html" }
        ]
      }
    },
    {
      name: "tahlil",
      kw: ["tahlil", "sonuc", "laboratuvar", "~test", "kan tahlili", "kan sonucu", "tetkik"],
      reply: {
        text: "Tahlil sonuçlarınıza online sayfamızdan ulaşabilirsiniz. Rutin tetkik sonuçları genellikle aynı gün sisteme düşer.",
        actions: [{ label: "Tahlil Sonuçları", href: "tahlil-sonuclari.html" }]
      }
    },
    {
      name: "rapor",
      kw: ["rapor", "ise giris", "ehliyet", "sporcu", "evlilik", "portor", "yurt raporu", "ogrenci raporu", "saglik raporu"],
      reply: {
        text: "İşe giriş, ehliyet, sporcu, evlilik, portör ve öğrenci/yurt raporlarını tek ziyarette, aynı gün teslim ediyoruz. Gerekli belgeleri sayfamızda bulabilirsiniz.",
        actions: [{ label: "Rapor İşlemleri", href: "saglik-raporlari.html" }]
      }
    },
    {
      name: "sigorta",
      kw: ["sigorta", "sgk", "anlasmali", "tamamlayici", "police", "kurum", "gecerli mi"],
      reply: {
        text: "SGK anlaşmamız ve 12 tamamlayıcı sağlık sigortasıyla anlaşmamız bulunmaktadır. Poliçe kapsamınızı randevu öncesi 444 0 000'dan teyit edebilirsiniz.",
        actions: [{ label: "Anlaşmalı Kurumlar", href: "anlasmali-kurumlar.html" }]
      }
    },
    {
      name: "hekim",
      kw: ["hekim", "doktor", "uzman", "kadro", "prof", "dr", "kim bakiyor"],
      reply: {
        text: "26 uzman hekimimizin eğitim geçmişini, uzmanlık alanlarını ve çalışma günlerini profil sayfalarında görebilirsiniz.",
        actions: [{ label: "Hekim Kadromuz", href: "hekimler.html" }]
      }
    },
    {
      name: "branslar",
      kw: ["brans", "bolum", "birim", "poliklinik", "kardiyoloji", "dahiliye", "ic hastaliklari", "cocuk", "pediatri", "kadin hastaliklari", "kadin dogum", "jinekoloji", "ortopedi", "cerrahi", "goz", "kbb", "kulak burun", "dermatoloji", "cildiye", "psikoloji", "goruntuleme", "rontgen", "ultrason", "mamografi", "hangi bolumler"],
      reply: {
        text: "14 tıbbi birimimiz var: Kardiyoloji, İç Hastalıkları, Çocuk Sağlığı, Kadın Hastalıkları, Ortopedi, Genel Cerrahi, Göz, KBB, Dermatoloji, Psikoloji ile Laboratuvar ve Görüntüleme başlıcaları.",
        actions: [{ label: "Tıbbi Birimler", href: "bolumler.html" }]
      }
    },
    {
      name: "selam",
      kw: ["merhaba", "selam", "gunaydin", "iyi gunler", "iyi aksamlar", "kolay gelsin", "nasilsin", "naber"],
      reply: {
        text: "Merhaba! Size nasıl yardımcı olabilirim? Aşağıdaki hızlı seçenekleri kullanabilir veya sorunuzu yazabilirsiniz."
      }
    },
    {
      name: "tesekkur",
      kw: ["tesekkur", "sagol", "saol", "eyvallah", "harika", "super", "cok iyi", "rica"],
      reply: {
        text: "Rica ederim! Başka bir konuda yardımcı olabileceğim bir şey olursa buradayım. Sağlıklı günler dileriz."
      }
    }
  ];

  const FALLBACK_REPLY = {
    text: "Bunu tam anlayamadım. Randevu, çalışma saatleri, ulaşım, tahlil sonuçları, sağlık raporları, anlaşmalı kurumlar ve hekim kadromuz hakkında yardımcı olabilirim.\nAşağıdaki hızlı seçenekleri de kullanabilirsiniz.",
    actions: [
      { label: "Randevu Al", href: "randevu.html" },
      { label: "İletişim", href: "iletisim.html" }
    ]
  };

  const WELCOME_TEXT =
    "Merhaba! Ben yapay zekâ destekli sağlık asistanıyım (demo). " +
    "Tıbbi tavsiye ve teşhis veremem; randevu, çalışma saatleri, ulaşım ve hizmetler hakkında yardımcı olabilirim.";
  const KVKK_NOTE = "Gizlilik: Yazdıklarınız demo sürümde kaydedilmez. Lütfen kişisel sağlık bilgisi paylaşmayın.";

  const CHIPS = [
    "Randevu almak istiyorum",
    "Çalışma saatleri",
    "Nasıl gelirim?",
    "Sağlık raporu",
    "Tahlil sonucu"
  ];

  /* ---------------------------------------------------------------------
     Yanıt seçici
     --------------------------------------------------------------------- */
  function pickReply(raw) {
    const text = norm(raw);
    if (!text) return null;
    const tokens = text.split(" ");

    // a) Acil — her şeyden önce
    if (ACIL_KW.some((kw) => hits(kw, text, tokens))) return ACIL_REPLY;
    // b) Semptom / teşhis — sabit güvenli yanıt
    if (SEMPTOM_KW.some((kw) => hits(kw, text, tokens))) return SEMPTOM_REPLY;
    // c) Intent skorlaması
    let best = null, bestScore = 0;
    for (const it of INTENTS) {
      const s = scoreOf(it.kw, text, tokens);
      if (s > bestScore) { bestScore = s; best = it; }
    }
    return best ? best.reply : FALLBACK_REPLY;
  }

  /* ---------------------------------------------------------------------
     Arayüz kurulumu
     --------------------------------------------------------------------- */
  const SVG_CHAT  = '<svg class="cbx-i-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5c-1.4 0-2.8-.3-4-1L3 20l1-5.5a8.5 8.5 0 1 1 17-3z"/><path d="M8 10.5h8M8 14h5"/></svg>';
  const SVG_X     = '<svg class="cbx-i-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>';
  const SVG_CROSS = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M12 3v18M3 12h18"/></svg>';
  const SVG_SEND  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/></svg>';

  function buildUI() {
    const root = document.createElement("div");
    root.className = "cbx";
    root.innerHTML =
      '<div class="cbx-panel" id="cbx-panel" role="dialog" aria-label="Sağlık Asistanı (DEMO)" hidden>' +
        '<header class="cbx-head">' +
          '<div class="cbx-id">' +
            '<span class="cbx-ava" aria-hidden="true">' + SVG_CROSS + "</span>" +
            "<div><strong>Sağlık Asistanı</strong><small>DEMO · Kurallı yanıt</small></div>" +
          "</div>" +
          '<button type="button" class="cbx-close" aria-label="Sohbeti kapat">' + SVG_X.replace("cbx-i-close", "") + "</button>" +
        "</header>" +
        '<div class="cbx-msgs" aria-live="polite" aria-label="Sohbet mesajları"></div>' +
        '<div class="cbx-foot">' +
          '<div class="cbx-chips" role="group" aria-label="Hızlı yanıtlar"></div>' +
          '<form class="cbx-form">' +
            '<input class="cbx-input" type="text" maxlength="300" autocomplete="off" placeholder="Mesajınızı yazın…" aria-label="Mesajınız">' +
            '<button type="submit" class="cbx-send" aria-label="Mesajı gönder">' + SVG_SEND + "</button>" +
          "</form>" +
        "</div>" +
      "</div>" +
      '<button type="button" class="cbx-fab" aria-label="Sağlık asistanı sohbetini aç" aria-expanded="false" aria-controls="cbx-panel">' +
        SVG_CHAT + SVG_X +
      "</button>";
    document.body.appendChild(root);
    return root;
  }

  /* ---------------------------------------------------------------------
     Uygulama
     --------------------------------------------------------------------- */
  function init() {
    const root  = buildUI();
    const fab   = root.querySelector(".cbx-fab");
    const panel = root.querySelector(".cbx-panel");
    const msgs  = root.querySelector(".cbx-msgs");
    const chips = root.querySelector(".cbx-chips");
    const form  = root.querySelector(".cbx-form");
    const input = root.querySelector(".cbx-input");
    const close = root.querySelector(".cbx-close");

    let welcomed = false;
    let busy = false;

    const scrollDown = () => { msgs.scrollTop = msgs.scrollHeight; };

    function addMsg(text, who, opts) {
      const el = document.createElement("div");
      el.className = "cbx-msg cbx-msg--" + who + (opts && opts.alert ? " cbx-msg--alert" : "");
      el.textContent = text; // XSS güvenli
      if (opts && opts.actions && opts.actions.length) {
        const acts = document.createElement("div");
        acts.className = "cbx-acts";
        opts.actions.forEach((a) => {
          const btn = document.createElement("a");
          btn.className = "cbx-btn" + (a.danger ? " cbx-btn--danger" : "");
          btn.href = a.href;
          btn.textContent = a.label;
          acts.appendChild(btn);
        });
        el.appendChild(acts);
      }
      msgs.appendChild(el);
      scrollDown();
      return el;
    }

    function addMicro(text) {
      const el = document.createElement("div");
      el.className = "cbx-micro";
      el.textContent = text;
      msgs.appendChild(el);
      scrollDown();
    }

    function botReply(reply, done) {
      busy = true;
      const t = document.createElement("div");
      t.className = "cbx-msg cbx-msg--bot cbx-typing";
      t.setAttribute("aria-hidden", "true");
      t.innerHTML = "<i></i><i></i><i></i>";
      msgs.appendChild(t);
      scrollDown();
      window.setTimeout(() => {
        t.remove();
        addMsg(reply.text, "bot", { actions: reply.actions, alert: reply.alert });
        busy = false;
        if (done) done();
      }, REPLY_DELAY);
    }

    function send(rawText) {
      const value = rawText.trim();
      if (!value || busy) return;
      addMsg(value, "user");
      const reply = pickReply(value);
      botReply(reply || FALLBACK_REPLY);
    }

    /* Hızlı çipler */
    CHIPS.forEach((label) => {
      const b = document.createElement("button");
      b.type = "button";
      b.className = "cbx-chip";
      b.textContent = label;
      b.addEventListener("click", () => send(label));
      chips.appendChild(b);
    });

    /* Aç / kapat + odak yönetimi */
    function openPanel() {
      panel.hidden = false;
      root.classList.add("is-open");
      fab.setAttribute("aria-expanded", "true");
      fab.setAttribute("aria-label", "Sağlık asistanı sohbetini kapat");
      if (!welcomed) {
        welcomed = true;
        botReply({ text: WELCOME_TEXT }, () => addMicro(KVKK_NOTE));
      }
      window.setTimeout(() => input.focus(), 60);
    }
    function closePanel() {
      panel.hidden = true;
      root.classList.remove("is-open");
      fab.setAttribute("aria-expanded", "false");
      fab.setAttribute("aria-label", "Sağlık asistanı sohbetini aç");
      fab.focus();
    }

    fab.addEventListener("click", () => (panel.hidden ? openPanel() : closePanel()));
    close.addEventListener("click", closePanel);
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && !panel.hidden) closePanel();
    });

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      send(input.value);
      input.value = "";
      input.focus();
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
