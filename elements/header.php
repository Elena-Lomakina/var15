<?php
    $status = $_SESSION["status"];
    $size_trash = count($_SESSION["trash"]);
    $trash = $size_trash != 0 ? "Корзина - $size_trash " : "Корзина";
?>
<header>
	<ul class="ctrl-panel">
		<?php switch($status):
				 case "admin": ?>
			<div  class="wg_s">
				<ul class="menu">
					<li><h3 id="admp" class="wg_t_s_1">Админ. панель</h3>
						<ul class="submenu">
							<li><h3 class="wg_t"><a id="3" href="add.php">Добавление товара</a></h3></li>
                            <li><h3 class="wg_t"><a id="3" href="customer.php">Добавление заказчика</a></h3></li>
                            <li><h3 class="wg_t"><a id="3" href="add_user.php">Добавление пользователя</a></h3></li>
                            <li><h3 class="wg_t"><a id="3" href="ord.php">Заказы</a></h3></li>
						</ul>
					</li>
				</ul>
			</div>
			<?php case "user": ?>
			<ul class="menu">
				<li><a href="index.php">Главная</a></li>
                <li><a href="search.php">Поиск</a></li>
				<li><a href="category.php?category=Кухонные">Кухонные</a></li>
				<li><a href="category.php?category=Уборочные">Уборочные</a></li>
				<li><a href="category.php?category=Для стирки">Для стирки</a></li>
				<li><a href="category.php?category=Дачные">Дачные</a></li>
                <li><a href="trash.php" id="trash_txt"><?=$trash?></a></li>
				<li><a href="include/logout.php">Выход</a></li>
			</ul>
			<?php break; ?>
			<?php default: ?>
			<ul class="menu">
				<li><a href="index.php">Главная</a></li>
                <li><a href="category.php?category=Кухонные">Кухонные</a></li>
                <li><a href="category.php?category=Уборочные">Уборочные</a></li>
                <li><a href="category.php?category=Для стирки">Для стирки</a></li>
                <li><a href="category.php?category=Дачные">Дачные</a></li>
				<li><a class="" href="signup.php">Вход</a></li>
				<li><a href="register.php">Регистрация</a></li>
			</ul>
		<?php endswitch; ?>
	</ul>
</header>
