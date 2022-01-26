<?php
    if(!empty($_SESSION["status"])) {
        $user = $_SESSION["login"];
    }
    else header("Location: /");
	require_once "include/session.php";
	require_once "include/mysqli.php";
	db_connect();
	db_delete_product($_GET["product"]);
	header("Refresh: 2; url=" . $_SERVER['HTTP_REFERER'] );
	db_close();
?>