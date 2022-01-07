<?php
	require_once "include/session.php";
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once "elements/head.php"; ?>
</head>
<body>
	<?php 	require_once "elements/header.php"; ?>
	<main>
		<div class="slider">
			<div><img src="img/download1.jpg" alt=""></div>
			<div><img src="img/download2.jpg" alt=""></div>
			<div><img src="img/download3.jpg" alt=""></div>
		</div>
		<center>
            <div class='dv_main2'>
                <a href="category.php?category=*">
                    <img class='img_main2' src='img/*.jpg'>
                    <h2>Бесплатная доставка<h2></a><br>
            </div>

            <div class='dv_main2'>
                <a href="category.php?category=*">
                    <img class='img_main2' src='img/*.jpg'>
                    <h2>Пункты самовывоза<h2></a><br>
            </div>

            <div class='dv_main2'>
                <a href="category.php?category=*">
                    <img class='img_main2' src='img/*.jpg'>
                    <h2>Покупка в кредит<h2></a><br>
            </div>
            <div class='dv_main2'>
                <a href="category.php?category=*">
                    <img class='img_main2' src='img/*.jpg'>
                    <h2>Оптовая закупка<h2></a><br>
            </div>
        <br>
            <br>
		<div class='dv_main'>
			<a href="category.php?category=*">
				<img class='img_main' src='img/*jpg'>
				<h2>Популярное<h2></a><br>
		</div>

		<div class='dv_main'>
			<a href="category.php?category=*">
				<img class='img_main' src='img/*.jpg'>
				<h2>Новинки<h2></a><br>
		</div>

		<div class='dv_main'>
			<a href="category.php?category=*">
				<img class='img_main' src='img/*.jpg'>
				<h2>Акции и скидки<h2></a><br>
		</div>
		</center>
	</main>
</body>
	<?php require_once "elements/footer.php"; ?>
</html>
