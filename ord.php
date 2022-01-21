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
	<title>Ресторан ШИРЕ ХАРИ</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<button style="width:100px;" value="Назад" onclick="location.href='index.php'"/><= Назад</button>
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

						echo <<<_OUT
							<tr>
								<td>{$result['time']}</td>
								<td>{$result['price']}</td>
								<td>{$result['user_id']}</td>
								<td>{$result['product']}</td>
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
</body>
