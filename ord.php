<?php
	require_once "include/mysqli.php";
    require_once "include/session.php";

	if($_POST["delord"])
	{
		$id = $_POST["delord"];
		if(!db_connect())
		{
			del_ord($id);
			db_close();
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
