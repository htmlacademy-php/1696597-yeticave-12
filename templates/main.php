<main class="container">
  <section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
      <?php foreach ($categories as $category) : ?>
        <li class="promo__item promo__item--boards">
          <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category); ?></a>
        </li>
      <? endforeach; ?>
    </ul>
  </section>
  <section class="lots">
    <div class="lots__header">
      <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
      <!--заполните этот список из массива с товарами-->
      <?php foreach ($lots as $lot) : ?>
        <li class="lots__item lot">
          <div class="lot__image">
            <img src="<?= htmlspecialchars($lot['img_url']); ?>" width="350" height="260" alt="">
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= htmlspecialchars($lot['category']); ?></span>
            <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($lot['name']); ?></a></h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount">Стартовая цена</span>
                <span class="lot__cost"><?= htmlspecialchars(format_price($lot['price'])); ?></span>
              </div>
              <?php $time_to_expiry = get_time_to_expiry($lot['expiry_date']);
              if (intval($time_to_expiry[0]) < 1) {
                $timer_finishing = 'timer--finishing';
              } else {
                $timer_finishing = '';
              }
              ?>
              <div class="lot__timer timer <?= $timer_finishing ?>">
                <?= $time_to_expiry[0] . ':' . $time_to_expiry[1] ?>
              </div>
            </div>
          </div>
        </li>
      <? endforeach; ?>
    </ul>
  </section>
</main>