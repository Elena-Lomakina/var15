<?php
	require_once "session.php";
	require_once "mysqli.php";
	
	if(!empty($_GET["product"])) {
		
		db_connect();
		
		$product = get_product($_GET["product"])[0];
		$_SESSION["trash"][] = $product;
		
		db_close();
		
		echo count($_SESSION["trash"]);
	}

?>