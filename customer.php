<?php
    require_once "include/session.php";
	require_once "include/mysqli.php";

    if(!empty($_SESSION["status"])) {
        $user = $_SESSION["login"];
    } else header("Location: /signup.php");

	if($_POST["addcust"])
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
            $status_responsibility = htmlentities(mysqli_real_escape_string($conn, $_POST["status_responsibility"]));
			if (!empty($name) or !empty($inn) or !empty($director) or !empty($tel) or !empty($legal_address) or !empty($actual_address) or !empty($status) or !empty($status_responsibility))
			{
                add_customer($name, $inn, $director, $tel, $legal_address, $actual_address, $status, $status_responsibility);
                $ok = "Заказчик успешно добавлен !";
                header("Refresh: 2; url=customer.php");
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

	if($_POST["delcust"]) {
		$id = $_POST["delcust"];
		if(!db_connect())
		{
			del_customer($id);
			db_close();
            $ok = "Заказчик успешно удален !";
            header("Refresh: 2; url=customer.php");
		}
		else
		{
			$error = "Ошибка подключения!";
		}
	}

	if($_POST["savecust"])
	{
		$id_cust = $_POST["savecust"];
		if(!db_connect())
		{
			$name2 = htmlentities(mysqli_real_escape_string($conn, $_POST["name"]));
			$inn2 = htmlentities(mysqli_real_escape_string($conn, $_POST["inn"]));
			$director2 = htmlentities(mysqli_real_escape_string($conn, $_POST["director"]));
			$tel2 = htmlentities(mysqli_real_escape_string($conn, $_POST["tel"]));
			$legal_address2 = htmlentities(mysqli_real_escape_string($conn, $_POST["legal_address"]));
			$actual_address2 = htmlentities(mysqli_real_escape_string($conn, $_POST["actual_address"]));
			$status2 = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));
			$status_responsibility2 = htmlentities(mysqli_real_escape_string($conn, $_POST["status_responsibility"]));
			if (!empty($name2) or !empty($inn2) or !empty($director2) or !empty($tel2) or !empty($legal_address2) or !empty($actual_address2) or !empty($status2) or !empty($status_responsibility2))
			{
                edit_customer($id_cust, $name2, $inn2, $director2, $tel2, $legal_address2, $actual_address2, $status2, $status_responsibility2);
                $ok = "Заказчик успешно обновлен !";
			}
			else
			{
				$error = "Все поля должны быть заполнены!";
			}
			db_close();
			header("Refresh: 1; url=customer.php");
            header("Refresh: 2; url=customer.php");
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
    <center><h2>Добавление заказчика</h2></center>
	<?php
		if($_POST["editcust"]) {
			$id = $_POST["editcust"];

			if(!db_connect()){
				global $conn;
				$query = "SELECT * FROM customer WHERE id = $id";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($result);
				$name = $row["name"];
				$inn = $row["inn"];
				$director = $row["director"];
				$tel = $row["tel"];
				$legal_address = $row["legal_address"];
				$actual_address = $row["actual_address"];
				$responsibility = $row["responsibility"];
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
                            <p>Юридический адрес: <input type="text" name="legal_address" value="$legal_address" ></p>
                            <p>Физический адрес: <input type="text" name="actual_address" value="$actual_address" ></p>
                            <p>Статус активности:
                                <select name="status">
                                    <option value="1">Активен</option>
                                    <option selected value="0">Не активен</option>
                                </select>
                            </p>
                            <p>Правовой статус:
                                <select name="status_responsibility">
                                    <option value="0">Физическое лицо</option>
                                    <option selected value="1">Юридическое лицо</option>
                                </select>
                            </p>
                            <button name="savecust" value="$id">Сохранить</button>
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
                    <p>Юридический адрес: <input type="text" name="legal_address" value="" ></p>
                    <p>Физический адрес: <input type="text" name="actual_address" value="" ></p>
                    <p>Статус активности:
                                <select name="status">
                                    <option value="1">Активен</option>
                                    <option selected value="0">Не активен</option>
                                </select>
                            </p>
                            <p>Правовой статус:
                                <select name="status_responsibility">
                                    <option value="0">Физическое лицо</option>
                                    <option selected value="1">Юридическое лицо</option>
                                </select>
                            </p>
                    <button name="addcust" value="1">Добавить</button>
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
                <td>Юр.Статус</td>
			</tr>
			<?php
				if(!db_connect())
				{
					$query = "SELECT * FROM customer";
					$res2 = mysqli_query($conn, $query);

					while ($result = mysqli_fetch_array($res2)) {
						if($result['status'] == 1) {
							$st = "Активен";
						}else{
							$st = "Не активен";
						}
                        if($result['responsibility'] == 1) {
                            $st2 = "Юр.лицо";
                        }else{
                            $st2 = "Физ.лицо";
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
								<td>$st2</td>
								
								
							</tr>
                                <td><button name="editcust" value="{$result['id']}">Редактировать</button></td>
								<td><button name="delcust" value="{$result['id']}">Удалить</button></td>
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