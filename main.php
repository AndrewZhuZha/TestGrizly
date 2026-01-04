<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Название страницы</title>
  <meta name="description" content="Краткое описание страницы" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Пример: подключение шрифта; заменим на твой -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <script src="main.js" defer></script>
</head>

<body>
 <header class="site-header">
  <div class="container header__inner">
    <a href="/" class="logo">
      <img src="assets/magento.svg" alt="nemer" width="120" height="32">
    </a>

    <nav class="nav" aria-label="Główna nawigacja">
      <ul class="nav__list">
        <li><a href="#about">O nas</a></li>
        <li><a href="#services">Usługi</a></li>
        <li><a href="#pricing">Cennik</a></li>
        <li><a href="#contact">Kontakt</a></li>
        <li><a href="#reviews">Opinie</a></li>
        <li><a href="#faq">Pytania i odpowiedzi</a></li>
      </ul>
    </nav>

    <div class="header__actions">
      <div class="phone">
        <a href="tel:+48690590089">+48 690 590 089</a>
        <a href="#offerForm" class="btn btn--sm">Zamów rozmowę</a>
      </div>
      <div class="lang-switcher">
        <button class="lang-btn" aria-haspopup="true" aria-expanded="false">
          PL <span class="arrow">▼</span>
        </button>
        <ul class="lang-menu" hidden>
          <li><a href="?lang=en">EN</a></li>
          <li><a href="?lang=de">DE</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>


  <main id="main">
<section id="couriers" class="section couriers">
  <div class="container couriers__inner">
    <div class="couriers__logos">
      <h2>Nasi kurierzy</h2>
      <ul class="couriers__list">
        <li><img src="assets/dpd.png" alt="DPD"></li>
        <li><img src="assets/gls.jpg" alt="GLS"></li>
        <li><img src="assets/dhl.jpg" alt="DHL"></li>
        <li><img src="assets/shopify.jpg" alt="Shopify"></li>
        <li><img src="assets/woocommerce.jpg" alt="WooCommerce"></li>
        <li><img src="assets/prestashop.jpg" alt="PrestaShop"></li>
        <li><img src="assets/ppl.jpg" alt="PPL"></li>
        <li><img src="assets/slovenska-posta.jpg" alt="Slovenská POŠTA"></li>
        <li><img src="assets/magento.svg" alt="Magento"></li>
      </ul>
    </div>
    <div class="couriers__image">
      <img src="assets/packing.jpg" alt="Pakowanie przesyłki">
    </div>
  </div>
</section>

<div class="offer-page">
   <form class="offer-form" id="offerForm" novalidate>
  <h2>Szukasz najlepszej oferty?</h2>
  <p class="subtitle">
    Zostaw aplikację, a nasz menedżer skontaktuje się z Tobą w celu konsultacji
  </p>

  <div class="grid-2">
    <div class="field">
      <label>Twoje imię *</label>
      <input type="text" name="firstName" maxlength="100" required />
      <div class="error"></div>
    </div>

    <div class="field">
      <label>Twoje nazwisko *</label>
      <input type="text" name="lastName" maxlength="100" required />
      <div class="error"></div>
    </div>

    <div class="field">
      <label>Twoje drugie imię</label>
      <input type="text" name="middleName" maxlength="100" />
      <div class="error"></div>
    </div>

    <div class="field">
      <label>Twoja data urodzenia *</label>
      <input type="date" name="birthDate" required />
      <div class="error"></div>
    </div>
  </div>

  <div class="grid-2">
    <div class="field">
      <label>E-mail</label>
      <input type="email" name="email" />
      <div class="error"></div>
    </div>

    <!-- TELEFONY -->
    <div class="field">
      <label>Telefon</label>

      <div id="phones">
        <div class="phone-row">
          <select name="country_codes[]" class="country-code" >
            <option value="+375">+375</option>
            <option value="+7">+7</option>
          </select>

          <input type="tel" class="phone-input" name="phones[]" placeholder="(___) ___ __ __" />
          <button type="button" class="remove-phone">×</button>
        </div>
      </div>

      <button type="button" class="add-phone" id="addPhone">+</button>
      <div class="error" id="phoneError"></div>
    </div>
  </div>

  <div class="field">
    <label>Stan cywilny *</label>
    <select class="form-select" name="maritalStatus" required>
      <option value="">Wybierz...</option>
      <option>Холост/не замужем</option>
      <option>Женат/замужем</option>
      <option>В разводе</option>
      <option>Вдовец/вдова</option>
    </select>
    <div class="error"></div>
  </div>

  <div class="field">
    <label>O mnie</label>
    <textarea
      name="about"
      rows="7"
      maxlength="1000"
      id="about"
    ></textarea>
    <div class="counter" id="aboutCounter">0 / 1000</div>
    <div class="error"></div>
  </div>

  <label class="checkbox">
    <input type="checkbox" name="rules" required />
    <span></span>
    Przeczytałem zasady *
  </label>
  <div class="error" id="rulesError"></div>

  <button type="submit" id="submitBtn" disabled>
    Wyślij
  </button>
</form>
</div>

  </main>

 <footer class="footer">
  <div class="footer-container">
    <div class="footer-col footer-brand">
      <div class="logo">enemer</div>

      <a href="tel:+48690590089" class="footer-link">+48690590089</a>
      <a href="#" class="footer-link">Zamów rozmowę</a>
      <a href="mailto:info@enemer.pl" class="footer-link">info@enemer.pl</a>

      <div class="footer-address">
        Błonie, Pass 20L, budynek 15,<br />
        05-870
      </div>
    </div>

    <div class="footer-col">
      <h4>Usługi</h4>
      <ul>
        <li>Usługi logistyczne dla e-commerce</li>
        <li>Outsourcing magazynu</li>
        <li>Outsourcing logistyczny</li>
        <li>Obsługa logistyczna sklepów internetowych</li>
        <li>Logistyka kontraktowa</li>
      </ul>
      <a href="#" class="footer-more">Zobacz wszystkie →</a>
    </div>

    <div class="footer-col">
      <h4>O nas</h4>
      <ul>
        <li>Cennik</li>
        <li>Pytania i odpowiedzi</li>
        <li>Kontakt</li>
        <li>Blog</li>
      </ul>
    </div>

    <div class="footer-col footer-company">
      <p>Space Logistics Sp.z.o.o. 02-727</p>
      <p>Warszawa ul. Wołodyjowskiego 67A</p>
      <p>KRS: 0000824771 NIP: 5213888029</p>
      <p>REGON: 385377605</p>
    </div>
  </div>

  <div class="footer-bottom">
    <a href="#">Polityka prywatności</a>

    <div class="footer-credits">
      <span>dev.grizzly.by</span>
      <span>seo.grizzly.by</span>
    </div>
  </div>
</footer>
</body>
</html>
