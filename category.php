<?php
	require_once "include/session.php";
	require_once "include/mysqli.php";

	define("MAX_PRODUCTS_ON_PAGE", 4);

	if(!empty($_GET["category"])) {
		$category = $_GET["category"];

		db_connect();

		$result = db_select("product", "category='$category'");
		db_close();
	} else
		header("Location: /");
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once "elements/head.php"; ?>

	<link rel="stylesheet" href="css/category.css">
</head>

<body>

	<?php
		require_once "elements/header.php";
	?>

	<main>
        <center>
		<?php
			$count_article = 0;

			foreach($result as $key => $val) {
				$id = $val["id"];
				$name = $val["name"];
				$price = $val["price"];
				$decsription = $val["description"];
				$img = $val["img"] == "" ? "img/noimg.png" : $val["img"];

				$count_article++;

				switch($_SESSION["status"]) {
					case "user":
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img class="picture" src="$img">
								</figure>

							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price руб.</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>
							<button type="button" onclick="productInTrash($id)">Заказать</button>
						</article><br>
_OUT;
						break;

					case "admin":
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img class="picture" src="$img">
								</figure>

							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price руб.</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>

							<button type="button" onclick="productInTrash($id)">Заказать</button>

							<a class="tools" href="edit.php?product=$id"><img src="img/editor.png"></a>
							<a class="tools" href="delete.php?product=$id"><img src="img/trash.png"></a>
						</article>
_OUT;
						break;

					default:
						$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img class="picture" src="$img">
								</figure>

							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price руб.</footer>
							<a href="viewer.php?product=$id" class="btn">Посмотреть</a>
						</article>
_OUT;
					break;
				}

				/*
				if(isset($_SESSION["status"]))
					$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>

							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price</footer>
							<a href="viewer.html?product=$id" class="btn">Посмотреть</a>
							<button type="button" onclick="productInTrash($id)">Заказать</button>
						</article>
_OUT;
				else
					$article = <<<_OUT
						<article id="$id">
							<header class="name">$name</header>
							<div class="wrap">
								<figure>
									<img src="$img">
								</figure>

							<p class="description">$decsription</p>
							</div>
							<footer class="price">$price</footer>
							<a href="viewer.html?product=$id" class="btn">Посмотреть</a>
						</article>
_OUT;
					*/

				echo $article;

				//if(count_article == MAX_PRODUCTS_ON_PAGE ) break;
			}
		?>
        </center>
	</main>


</body>
<footer>
    <?php require_once "elements/footer.php"; ?>
</footer>
</html>
