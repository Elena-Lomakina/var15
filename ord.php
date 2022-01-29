<?php
	require_once "include/mysqli.php";
    require_once "include/session.php";

    if(!empty($_SESSION["status"])) {
        $user = $_SESSION["login"];
    } else header("Location: /signup.php");

	if($_POST["delord"])
	{
		$id = $_POST["delord"];
		if(!db_connect())
		{
			del_ord($id);
			db_close();
            $ok = "Заказ успешно удален !";
            header("Refresh: 2; url=trash.php");
		}
		else
		{
			$error = "Ошибка подключения!";
		}
	}

	if($_POST["ex"])
	{
		session_destroy();
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<head>
    <?php require_once "elements/head.php"; ?>
	<meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php require_once "elements/header.php"; ?>
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
<center><h2>Просмотр заказов</h2>
	<form id="main" style="font-size: 14pt" method="post">
		<table>
			<tr>
				<td>Время</td>
				<td>Цена</td>
				<td>id пользователя</td>
				<td>Продукт</td>
				<td>Статус</td>
			</tr>
			<?php
				if(!db_connect())
				{
					$query = "SELECT * FROM ord";
					$res2 = mysqli_query($conn, $query);

					while ($result = mysqli_fetch_array($res2)) {
						if($result['status'] == 'closed') {
							$st = "Закрыт";
						}elseif($result['status'] == 'processed'){
							$st = "В процессе";
						}else{
							$st = "Просрочен";
						}
						$prod = json_decode($result['product'], true);
						echo <<<_OUT
							<tr>
								<td>{$result['time']}</td>
								<td>{$result['price']}</td>
								<td>{$result['user_id']}</td>
								<td>{$prod[0]['name']}</td>
								<td>$st</td>
								<td><button name="delord" value="{$result['id']}">Удалить</button></td>
							</tr>
_OUT;
					}
				}
				else
				{
					$error = "Ошибка подключения!";
				}
			?>
		</table>
	</form>
</center>
</body>
<footer>
    <?php require_once "elements/footer.php"; ?>
</footer>
