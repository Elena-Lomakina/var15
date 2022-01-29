<?php
	require_once "session.php";
	
	session_unset();//уничтажаем данные сессии
	session_destroy();
	header("Location: /signup.php");//перенаправляем на стартовую страницу
	exit;
?>