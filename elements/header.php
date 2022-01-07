<?php
    if(isset($_SESSION["login"])){
        $status = $_SESSION["status"];
    }
    else{
        $status = "none";
    }
?>
<header>
	<ul class="ctrl-panel">
		<?php switch($status):
				 case "admin": ?>
			<div  class="widget">
				<ul class="topmenu">
					<li><h3 id="admp" class="widget-title1">Админ. панель</h3>
						<ul class="submenu">
							<li><h3 class="widget-title"><a id="3" href="add.php">Добавление товара</a></h3></li>
                            <li><h3 class="widget-title"><a id="3" href="vender.php">Добавление поставщика</a></h3></li>
                            <li><h3 class="widget-title"><a id="3" href="ord.php">Заказы</a></h3></li>
						</ul>
					</li>
				</ul>
			</div>
			<?php case "user": ?>
			<ul class="topmenu">
				<li><a href="index.php">Главная</a></li>
				<li><a href="category.php?category=Кухонные">Кухонные</a></li>
				<li><a href="category.php?category=Уборочные">Уборочные</a></li>
				<li><a href="category.php?category=Для стирки">Для стирки</a></li>
				<li><a href="category.php?category=Для мелкого ремонта">Для мелкого ремонта</a></li>
				<li><a href="contact.php">Контакты</a></li>
				<li><a href="include/logout.php">Выход</a></li>
			</ul>
			<?php break; ?>
			<?php default: ?>
			<ul class="topmenu">
				<li><a href="index.php">Главная</a></li>
                <li><a href="category.php?category=Кухонные">Кухонные</a></li>
                <li><a href="category.php?category=Уборочные">Уборочные</a></li>
                <li><a href="category.php?category=Для стирки">Для стирки</a></li>
                <li><a href="category.php?category=Для мелкого ремонта">Для мелкого ремонта</a></li>
				<li><a href="contact.php">Контакты</a></li>
				<li><a class="" href="signup.php">Вход</a></li>
				<li><a href="register.php">Регистрация</a></li>
			</ul>
		<?php endswitch; ?>
	</ul>
</header>
