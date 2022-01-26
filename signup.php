<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";
	$status = "admin";
	if(!empty($_POST))
		if( !db_connect() ) {

			$usr= htmlentities(mysqli_real_escape_string($conn,$_POST["login"]));
			$passwd = htmlentities(mysqli_real_escape_string($conn,$_POST["password"]));

			if (!empty($usr))
				if (!db_check_login($usr, $passwd)) {
						$ok = "Добро пожаловть!!";
						$_SESSION["login"] = $usr;
						$_SESSION["status"] = get_user_status($usr);
						header("Refresh: 2; url=index.php");

				} else {
					$error = "Не правильный логин или пароль";
				}
			else
				$error = "Логин не может быть пустым";
			db_close();
		} else
			$error = "Ошибка подключения";
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "elements/head.php"; ?>
	<link rel="stylesheet" href="style/sign-up.css">
	<script src="js/sign-up.js"></script>

</head>

<body>

	<?php
		require_once "elements/header.php";
	?>

	<main>
		<?php
		if(isset($error))
			echo <<<_OUT
				<div id="msg-error" class="msg msg-error">
					<div>$error</div>
					<div class="closed" onclick="msgClose('msg-error')">&#10006;</div>
				</div>
_OUT;
		else if(isset($ok))
			echo <<<_OUT
				<div id="msg-ok" class="msg msg-ok">
					<div>$ok</div>
					<div class="closed" onclick="msgClose('msg-ok')">&#10006;</div>
				</div>
_OUT;
		?>
<center>
		<form id="sign-up" method="POST">
			<div class="sig-container">
				<div class="sigtext"><center><h1>Авторизация</h1><center></div>
				<div class="siglogin"><input type="email" name="login" placeholder="e-mail" ></div>
				<div class="sigpasswd"><input type="password" name="password" placeholder="пароль" ></div>
				<div class="sigsubm"><input class="sigbut" type="submit" name="sign-up-submit" value="Войти"></div>
			</div>
		</form>
		</center>
	</main>


</body>
	<?php require_once "elements/footer.php"; ?>
</html>
