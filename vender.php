<?php
    require_once "include/session.php";
	require_once "include/mysqli.php";

	if($_POST["addven"])
	{
		if(!db_connect())
		{
			$name = htmlentities(mysqli_real_escape_string($conn, $_POST["name"]));
			$inn = htmlentities(mysqli_real_escape_string($conn, $_POST["inn"]));
			$director = htmlentities(mysqli_real_escape_string($conn, $_POST["director"]));
			$tel = htmlentities(mysqli_real_escape_string($conn, $_POST["tel"]));
			$legal_address = htmlentities(mysqli_real_escape_string($conn, $_POST["legal_address"]));
			$actual_address = htmlentities(mysqli_real_escape_string($conn, $_POST["actual_address"]));
			$status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));

			if (!empty($name) or !empty($inn) or !empty($director) or !empty($tel) or !empty($legal_address) or !empty($actual_address) or !empty($status))
			{
                add_vender($name, $inn, $director, $tel, $legal_address, $actual_address, $status);
			}
			else
			{
				$error = "Все поля должны быть заполнены!";
			}
			db_close();
		}
		else
		{
			$error = "Ошибка подключения!";
		}
	}

	if($_POST["delven"]) {
		$id = $_POST["delven"];
		if(!db_connect())
		{
			del_vender($id);
			db_close();
		}
		else
		{
			$error = "Ошибка подключения!";
		}
	}

	if($_POST["cancel"]) {
		header("Refresh: 1; url=vender.php");
	}

	if($_POST["saveven"])
	{
		$id_ven = $_POST["saveven"];
		if(!db_connect())
		{
			$name2 = htmlentities(mysqli_real_escape_string($conn, $_POST["name"]));
			$inn2 = htmlentities(mysqli_real_escape_string($conn, $_POST["inn"]));
			$director2 = htmlentities(mysqli_real_escape_string($conn, $_POST["director"]));
			$tel2 = htmlentities(mysqli_real_escape_string($conn, $_POST["tel"]));
			$legal_address2 = htmlentities(mysqli_real_escape_string($conn, $_POST["legal_address"]));
			$actual_address2 = htmlentities(mysqli_real_escape_string($conn, $_POST["actual_address"]));
			$status2 = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));

			if (!empty($name2) or !empty($inn2) or !empty($director2) or !empty($tel2) or !empty($legal_address2) or !empty($actual_address2) or !empty($status2))
			{
                edit_vender($id_ven, $name2, $inn2, $director2, $tel2, $legal_address2, $actual_address2, $status2);
			}
			else
			{
				$error = "Все поля должны быть заполнены!";
			}
			db_close();
			header("Refresh: 1; url=vender.php");
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
    <?php 	require_once "elements/header.php"; ?>
    <center><h2>Добавление поставщика</h2></center>
	<?php
		if($_POST["editven"]) {
			$id = $_POST["editven"];

			if(!db_connect()){
				global $conn;
				$query = "SELECT * FROM vender WHERE id = $id";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($result);
				$name = $row["name"];
				$inn = $row["inn"];
				$director = $row["director"];
				$tel = $row["tel"];
				$legal_address = $row["legal_address"];
				$actual_address = $row["actual_address"];
			}else{
				$error = "Все поля должны быть заполнены!";
			}
				db_close();
			echo <<<_OUT
            <center>
                <form id="main" method="post">
                            <p>Название: <input type="text" name="name" value="$name" required></p>
                            <p>ИНН: <input type="text" name="inn" value="$inn" required></p>
                            <p>Директор: <input type="text" name="director" value="$director" required></p>
                            <p>Телефон: <input type="text" name="tel" value="$tel" required></p>
                            <p>Юридический адрес: <input type="text" name="legal_address" value="$legal_address" required></p>
                            <p>Физический адрес: <input type="text" name="actual_address" value="$actual_address" required></p>
                            <p>Статус:
                                <select name="status">
                                    <option value="1">Активен</option>
                                    <option selected value="0">Не активен</option>
                                </select>
                            </p>
                            <button name="saveven" value="$id">Сохранить</button>
                            <button name="cancel" value="0">Отмена</button>
                        </form>
            </center>
			
_OUT;
		}else{
			echo <<<_OUT
            <center>
                <form id="main" method="post">
                    <p>Название: <input type="text" name="name" value="" required></p>
                    <p>ИНН: <input type="text" name="inn" value="" required></p>
                    <p>Директор: <input type="text" name="director" value="" required></p>
                    <p>Телефон: <input type="text" name="tel" value="" required></p>
                    <p>Юридический адрес: <input type="text" name="legal_address" value="" required></p>
                    <p>Физический адрес: <input type="text" name="actual_address" value="" required></p>
                    <p>Статус:
                        <select name="status">
                            <option value="1">Активен</option>
                            <option selected value="0">Не активен</option>
                        </select>
                    </p>
                    <button name="addven" value="1">Добавить</button>
                </form>
            </center>
_OUT;
		}
	?>
    <center>
	<form id="main" style="font-size: 14pt" method="post">
		<table>
			<tr>
				<td>Название</td>
				<td>ИНН</td>
				<td>Директор</td>
				<td>Телефон</td>
				<td>Юридический адрес</td>
				<td>Физический адрес</td>
				<td>Статус</td>
			</tr>
			<?php
				if(!db_connect())
				{
					$query = "SELECT * FROM vender";
					$res2 = mysqli_query($conn, $query);

					while ($result = mysqli_fetch_array($res2)) {
						if($result['status'] == 1) {
							$st = "Активен";
						}else{
							$st = "Не активен";
						}

						echo <<<_OUT
							<tr>
								<td>{$result['name']}</td>
								<td>{$result['inn']}</td>
								<td>{$result['director']}</td>
								<td>{$result['tel']}</td>
								<td>{$result['legal_address']}</td>
								<td>{$result['actual_address']}</td>
								<td>$st</td>
								<td><button name="editven" value="{$result['id']}">Редактировать</button></td>
								<td><button name="delven" value="{$result['id']}">Удалить</button></td>
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