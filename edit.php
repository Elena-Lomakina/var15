<?php
require_once "include/session.php";
require_once "include/mysqli.php";

if(!empty($_SESSION["status"])) {
    $user = $_SESSION["login"];
} else header("Location: /");


$id_prod = $_GET["product"];

if($_POST["editprod"])
{
	if(!db_connect())
	{
		$name = htmlentities(mysqli_real_escape_string($conn, $_POST["name"]));
		$description = htmlentities(mysqli_real_escape_string($conn, $_POST["description"]));
		$way_img = $_SESSION['img'];
		$property = htmlentities(mysqli_real_escape_string($conn, $_POST["property"]));
		$price = htmlentities(mysqli_real_escape_string($conn, $_POST["price"]));
		$vender_id = htmlentities(mysqli_real_escape_string($conn, $_POST["vender_id"]));
		$status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));
		$category = htmlentities(mysqli_real_escape_string($conn, $_POST["category"]));

		if (!empty($name) or !empty($description) or !empty($property) or !empty($price) or !empty($vender_id) or !empty($status))
		{
			edit_product($id_prod, $name, $description, $way_img, $property, $price, $vender_id, $status);
			//header("Refresh: 1; url=edit.php");
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

if(!db_connect())
{
	$query = "SELECT category, name, description, img, property, price, vender_id, status FROM product WHERE id = '$id_prod'";
	$res2 = mysqli_query($conn, $query);
	$result = mysqli_fetch_array($res2);
	$categiry_for_img = $result['category'];
}
else
{
	$error = "Ошибка подключения!";
}
db_close();

if($_POST["ex"])
{
	session_destroy();
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/style.css">
    <?php require_once "elements/head.php"; ?>
</head>
<body>
    <?php
    require_once "elements/header.php";
    ?>
    <center><h2>Редактирование товара</h2></center>
	<?php
        if($_FILES['file'] and !$_POST['editprod']){
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
			<p>Название: </p>
			<input type="text" name="name" value="{$result['name']}" required>
		</div>
_OUT;
if($way != ""){
	echo <<<_OUT
	<div class="img_prod" name="img" value="$way">
		<img src="$way">
_OUT;
}else{
	echo <<<_OUT
	<div class="img_prod" name="img" value="{$result['img']}">
		<img src="{$result['img']}">
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
          <option value="Дачные">Дачные</option></select></p>
			<p>Описание: <input type="text" name="description" value="{$result['description']}" required></p>
			<p>Свойства: <input type="text" name="property" value="{$result['property']}" required></p>
			<p>Производитель:
			<select name="vender_id">
_OUT;
if(!db_connect())
{
	$query = "SELECT * FROM vender";
	$res2 = mysqli_query($conn, $query);

	while ($result2 = mysqli_fetch_array($res2)) {

		echo <<<_OUT
			<option value="{$result2['id']}">{$result2['name']}</option>
_OUT;
	}
}
			echo <<<_OUT
		    </select>
			</p>
			<p>Статус:
			<select name="status">
				<option value="empty">Нет в наличии</option>
				<option selected value="take">Есть в наличии</option>
				<option value="not">Не выпускается</option>
		    </select></p>
			<p>Цена: <input type="text" name="price" value="{$result['price']}" required></p>
		</div>
		<p>
			<button name="editprod" value="1">Сохранить</button>
		</p>
	</form>
_OUT;
		?>
            <center>
</div>

</body>
<footer>
    <?php require_once "elements/footer.php"; ?>
</footer>