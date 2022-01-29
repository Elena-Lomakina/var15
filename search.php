<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";

    if(!empty($_SESSION["status"])) {
        $user = $_SESSION["login"];
    } else header("Location: /signup.php");

	if($_POST["ord"])
	{
		$id_prod = $_POST["ord"];
		$id_user = $_SESSION["id_user"];
		$time = date('H:i');
		if(!db_connect())
		{
			$price_prod = get_price_prod($id_prod);
			$name_prod =  get_name_prod($id_prod);
			add_ord($time, $price_prod, $id_user, $name_prod);
			db_close();
			//header("Refresh: 1; url=index.php");
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

	if($_POST["edit"])
	{
		$_SESSION["id_prod"] = $_POST["edit"];
		header('Location: edit.php?product='. $_POST['edit']);
	}

	if($_POST["add"])
	{
		$_SESSION["id_prod"] = $_POST["add"];
		header('Location: edit.php');
	}

	if($_POST["del"])
	{
		$id = $_POST["del"];
		if(!db_connect())
		{
			del_prod($id);
			db_close();
			header('Location: index.php');
		}
		else
		{
			$error = "Ошибка подключения!";
		}
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

<link rel="stylesheet" type="text/css" href="style/search.css">
<link rel="stylesheet" type="text/css" href="style.css">
<center>
    <div class = 'search'>
        <div class="d1">
            <div class="helpsearch">
                <form method="POST" name = 'form' action="search.php">
                    <input name="mytext">
                    <button id='search_button' type="submit">
                </form>
            </div>

        </div>
</div>
      <?php
      require_once "include/mysqli.php";
      if(isset($_POST['mytext'])){
        $sqlr = $_POST['mytext'];
        $conn = @mysqli_connect($host, $login, $password, $db);
    		$query = "SELECT * FROM product WHERE name LIKE '%$sqlr%' OR description LIKE '%$sqlr%' OR property LIKE '%$sqlr%';";
    		$res2 = mysqli_query($conn, $query);
    		if($res2 != ""){
    			$html .= "
    				<div id='main'>
    ";
    			while ($result = mysqli_fetch_array($res2)) {
    				if($result['status'] == "take")
    				{
    					$status_p = "Есть в наличии";
    				}elseif($result['status'] == "empty")
    				{
    					$status_p = "Нет в наличии";
    				}elseif($result['status'] == "not")
    				{
    					$status_p = "Не выпускается";
    				}

    				$id_customer = $result['customer_id'];
    				$html .= "
    					<div id='form_prod' id='{$result['id']}'>
    						<div class='name_prod'>
    							<p>{$result['name']}</p>
    						</div>
    						<div class='img_prod'>
    							<img src='{$result['img']}'>
    						</div>
    						<div class='destr_prod'>
    							<p>Описание: {$result['description']}</p>
    							<p>Статус: $status_p</p>
    							<p>Цена: {$result['price']} р.</p>
    ";
    				if($_SESSION["status"] == "admin" )
    				{
    					$html .= "
    							<form method='post'>
    								<button name='edit' value='{$result['id']}'>Редактировать</button>
    								<button name='del' value='{$result['id']}'>Удалить</button>
    							</form>
    						</div>
    					</div>
    ";
    				}elseif($_SESSION["status"] == "user"){
    					$html .= "
    							<form method='post'>
    								<button name='ord' value='{$result['id']}'>Заказать</button>
    							</form>
    						</div>
    					</div>
    ";
    				}
    				else{
    					$html .= "
    						</div>
    					</div>
    ";
    				}
    			}
    			$html .= "
    				</div>
    ";
    		}
    	else
    	{
    		$html = "Ошибка подключения!";
    	}
        echo $html;
      }
      ?>
</center>
</body>
<footer>
    <?php require_once "elements/footer.php"; ?>
</footer>