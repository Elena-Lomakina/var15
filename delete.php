<?php

    if(!empty($_SESSION["status"])) {
        $user = $_SESSION["login"];
    } else header("Location: /");

	require_once "include/session.php";
	require_once "include/mysqli.php";
	
	db_connect();
	
	$id = $_GET["product"];
	db_delete_product($id);


	header("Refresh: 2; url=" . $_SERVER['HTTP_REFERER'] );
	db_close();


?>