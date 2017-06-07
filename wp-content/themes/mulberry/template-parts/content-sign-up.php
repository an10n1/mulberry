<div class="popup-sign-up">
	<div class="container">
		<div class="cancel-button"></div>
		<h2 class="popup-sign-up__tittle">Пожалуйста, заполните регистрационную форму</h2>
		<form action="http://Mulberry.com/getForms.php" class="popup-sign-up__form" method="post">
			<div class="popup-sign-up__wrapper">
				<label for="name">Имя</label>
				<input type="text" name="name" id="name" value="" placeholder="Иван" required>
			</div>

			<div class="popup-sign-up__wrapper">
				<label for="email">E-mail</label>
				<input type="text" name="email" id="email" value="" placeholder="example@mail.com" required>
			</div>

			<div class="popup-sign-up__wrapper">
				<label for="skype">Skype</label>
				<input type="text" name="skype" id="skype" value="" placeholder="Ivan01">
			</div>

			<div class="popup-sign-up__wrapper">
				<label for="site">Сайт</label>
				<input type="text" name="site" id="site" value="" placeholder="www.example.com">
			</div>
			<input class="button" type="submit" value="Отправить">
		</form>
	</div>
</div>
