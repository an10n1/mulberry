<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage Mulberry
 */
?>
<div class="page-buffer"></div>
</div> <!--./page-wrapper-->

<footer class="globalFooter">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <img class="small-logo" src="<?php echo get_template_directory_uri(); ?>/img/logo-small.png" alt="Logo"/>
        <p>Печать на одежде это форма искусства, и ничто нас не делает счастливее, чем создать новый шедевр. Мы верим в
          то, что футболка соединяет людей и может превратить группу в команду, поднять настроение и сделать кого-то
          немного счастливее. Вот почеиу мы это делаем и делаем с удовольствием! Принимаем самые сложные заказы, ведь мы
          команда лучших специалистов в своем деле.</p>
      </div>
      <div class="col-md-4 col-sm-6">
        <h4>Контактная информация</h4>
        <ul class="contact-list">
          <li>
	          <?php
	          $options = get_option('sample_theme_options');
	          echo '<p>' . $options['phonetext1'] . '</p>';
            echo '<p>' . $options['phonetext2'] . '</p>';
            echo '<p>' . $options['phonetext3'] . '</p>';
	          ?>
          </li>
          <li><a href="mailto:<?= $options['emailtext']?>"><?= $options['emailtext']?></a></li>
          <li><?= $options['addresstext']?></li>
        </ul>

        <ul class="social-list">
          <li><a href="https://vk.com/mulberryprint" target="_blank"></a></li>
          <li><a href="https://www.facebook.com/Mulberry-печать-на-одежде-121590811770659/" target="_blank"></a></li>
          <li><a href="https://www.instagram.com/mulberry.ua/" target="_blank"></a></li>
        </ul>
      </div>
      <div class="col-md-4 col-sm-6">

        <h4>Оставайтесь на связи</h4>
        <form action="" class="subscribeForm">
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Ваш email">
            <span class="input-group-btn">
            <button class="btn btn-default" type="button">Подписаться</button>
          </span>
          </div>
        </form>

        <p class="subscribe-text">Будьте в курсе последних новостей и предложений от нашей компании, подписавшись на нашу рассылку</p>

        <div class="footer-menu">
          <ul class="col-md-5 col-sm-6 col-xs-6">
            <!--<li><a href="">Доставка</a></li>-->
            <li><a href="/about">О нас</a></li>
            <!--<li><a href="/service">Продукция</a></li>-->
          </ul>

          <ul class="col-md-7 col-sm-6 col-xs-6">
            <!--<li><a href="">Возврат</a></li>-->
            <!--<li><a href="">Оптовым покупателям</a></li>-->
            <li><a href="/contact">Связь с нами</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p class="copyright">Copyright &copy; 2017 Mulberry. Все права защищены.</p>
      </div>
    </div>
  </div>
</footer>
<div class="header-line"></div>

<?php wp_footer(); ?>

</body>
</html>

