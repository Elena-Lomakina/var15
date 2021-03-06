<?php
require_once "include/session.php";
require_once "include/mysqli.php";

if(!empty($_SESSION["status"])) {
    $user = $_SESSION["login"];
} else header("Location: /signup.php");


$id_prod = $_SESSION["id_prod"];

	if(!db_connect())
	{
		$query = "SELECT category, name, description, img, property, price, status FROM product WHERE id = '$id_prod'";
		$res2 = mysqli_query($conn, $query);
		$result = mysqli_fetch_array($res2);
		$categiry_for_img = $result['category'];
	}
	else
	{
		$error = "Ошибка подключения!";
	}
	db_close();

	if($_POST["addprod"])
	{
		if(!db_connect())
		{
			$name = htmlentities(mysqli_real_escape_string($conn, $_POST["name"]));
			$category = htmlentities(mysqli_real_escape_string($conn, $_POST["category"]));
			$description = htmlentities(mysqli_real_escape_string($conn, $_POST["description"]));
			$way_img = $_SESSION['img'];
			$property = htmlentities(mysqli_real_escape_string($conn, $_POST["property"]));
			$price = htmlentities(mysqli_real_escape_string($conn, $_POST["price"]));
			$status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));


			if (!empty($name) or !empty($description) or !empty($property) or !empty($price) or !empty($status))
			{
				add_product($name, $category, $description, $way_img, $property, $price, $status);
                header("Refresh: 2; url=add.php");
                $ok = "Продукт успешно добавлен";
				unset($_SESSION['img']);
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
<center><h2>Добавление товара</h2></center>
<?php
	if($_FILES['file'] and !$_POST['editprod'] and !$_POST['addprod']){
		$check = can_upload($_FILES['file']);

		if($check === true){
			$way = make_upload($_FILES['file'], $categiry_for_img);
			$_SESSION['img'] = $way;
			//header("Refresh: 1; url=edit.php");
		}else{
			echo <<<_OUT
			<script>
				alert("Ошибка загрузки изображения: $check");
			</script>
_OUT;
		}
	}
?>
  <div id="main">
      <center>
<?php

echo <<<_OUT
<form id="form_prod" method="post" enctype="multipart/form-data">
  <div>
    <p>Название: <input type="text" name="name" value=""></p>
  </div>
_OUT;
  if($way != ""){
    echo <<<_OUT
    <div class="img_prod" name="img" value="$way">
      <img src="$way">
_OUT;
  }else{
    echo <<<_OUT
    <div class="img_prod" name="img" value="">
      <img src="img/no_image.png">
_OUT;
  }
  echo <<<_OUT
    <p><input type="file" name="file">
    <input type="submit" value="Загрузить файл"></p>
  </div>
  <div class="destr_prod">
    <p>Категория:
    <select name="category">
      <option value="Кухонные">Кухонные</option>
      <option selected value="Уборочные">Уборочные</option>
      <option value="Для стирки">Для стирки</option>
      <option value="Дачные">Дачные</option>
      </select></p>
    <p>Описание: <input type="text" name="description" value="" ></p>
    <p>Свойства: <input type="text" name="property" value="" ></p>
    <p>Статус:
    <select name="status">
      <option value="empty">Нет в наличии</option>
      <option selected value="take">Есть в наличии</option>
      <option value="not">Не выпускается</option>
      </select></p>
    <p>Цена: <input type="text" name="price" value="" ></p>
  </div>
  <p>
    <button name="addprod" value="1">Добавить</button>

  </p>
</form>
_OUT;
?>
      </center>
</div>

</body>
<footer>
    <?php require_once "elements/footer.php"; ?>
</footer>
