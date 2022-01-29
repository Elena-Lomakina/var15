<?php

	$host = "localhost";
	$login = "root";
	$password = "root";
	$db = "lomakina_db";
	$conn = FALSE;

	//Подключение к БД
	function db_connect($host = "localhost", $login = "root", $password = "root", $db = "lomakina_db") {
		global $conn;
		$err = false;

		$conn = @mysqli_connect($host, $login, $password, $db);
		if($conn)
			return $err;
		else {
			return $err = true;
		}
	}

	//Закрытие подключения
	function db_close() {
		@mysqli_close($GLOBALS["conn"]);
	}
	//Регистрация пользователя
	function add_user ($login, $password, $status = "user") {
		global $conn;
		$salt = salt_gen();
		$password = hash("sha256", $password . $salt);

		$query = "INSERT INTO login VALUES(NULL, '$login', '$password', '$salt', '$status')";
		//var_dump($query);
		mysqli_query($conn, $query);
	}
    //Добавление продукта
	function add_product($name, $category, $description, $img, $property, $price, $status) {
		global $conn;
		$query = "INSERT INTO product VALUES(NULL, '$category', '$name', '$description', '$img', '$property', $price, '$status')";
		//var_dump($query);
		mysqli_query($conn, $query);
	}
    //Редактирование продукта
    function edit_product($id, $name, $description, $way, $property, $price, $status) {
        global $conn;
        $query = "UPDATE product SET name='$name', description='$description', img='$way', property='$property', price=$price, status='$status' WHERE id = $id";
        mysqli_query($conn, $query);

    }
    //Редактирование продукта
    function edit_user($id, $login, $password, $status) {
        global $conn;
        $query = "UPDATE login SET login='$login', password='$password', status='$status' WHERE id = $id";
        //var_dump($query);
        mysqli_query($conn, $query);

    }
    //Добавление вендера
    function add_customer($name, $inn, $dir, $phone, $ur_adr, $fiz_adr, $status, $status2) {
        global $conn;
        $query = "INSERT INTO customer VALUES(NULL, '$name', '$inn', '$dir', '$phone', '$ur_adr', '$fiz_adr', $status, $status2)";
        //var_dump($query);
        mysqli_query($conn, $query);
    }
    //Редактирование вендреа
    function edit_customer($id_customer, $name, $inn, $dir, $phone, $ur_adr, $fiz_adr, $status, $status2) {
        global $conn;
        $query = "UPDATE customer SET name='$name', inn='$inn', director='$dir', tel='$phone', legal_address='$ur_adr', actual_address='$fiz_adr', status=$status, responsibility= $status2 WHERE id = $id_customer";
        //var_dump($query);
        mysqli_query($conn, $query);
    }
    //Удаление вендера
    function del_customer($id_customer) {
        global $conn;
        $query = "DELETE FROM customer WHERE id = $id_customer";
        mysqli_query($conn, $query);
    }

    //Удаление вендера
    function del_user($id_user) {
        global $conn;
        $query = "DELETE FROM login WHERE id = $id_user";
        mysqli_query($conn, $query);
    }

	// проверка пары логин/пароль
	function db_check_login($login, $password) {
		global $conn;
		$query = "SELECT * FROM login WHERE login = '$login'";

		$result = mysqli_query($conn, $query);
		if( mysqli_num_rows($result) != 0 ) {

			$row = mysqli_fetch_assoc($result);
			$password = hash("sha256", $password . $row["salt"]);

			return strcmp($password, $row["password"]);
		} else
			return TRUE;
	}
    //новый пароль
	function update_password($login, $password) {
		global $conn;
		$salt = salt_gen(); //новый пароль - новая соль
		$password = hash("sha256", $password . $salt);
		$query = "UPDATE usr SET password = '$password', salt = '$salt' WHERE login = '$login'";
		mysqli_query($conn, $query);
	}
	//проверка на существование пользователя
	function db_check_user($login) {
		global $conn;
		$query = "SELECT * FROM login WHERE login = '$login'";

		$result = mysqli_query($conn, $query);

		return mysqli_num_rows($result) != 0; // смотрим на количество строк результирующего запроса
	}
    //проверка на существование пользователя
    function db_check_user_info($id) {
        global $conn;
        $query = "SELECT * FROM login WHERE id = '$id'";

        $result = mysqli_query($conn, $query);

        return mysqli_fetch_assoc($result); // смотрим на количество строк результирующего запроса
    }
	//уникальная соль
	function salt_gen() {
		return md5(uniqid() . time . mt_rand());
	}
    // формируем из результурующей таблицы один массив(все записи в таблицы постепенно добавляем в один массив)
	function rowSet($result) {
		$fetchArray = array();

		while($row = mysqli_fetch_assoc($result))
			array_push($fetchArray, $row);

		return $fetchArray;
	}
    // получение продукта
	function get_product($id = ""){
		global $conn;
		$query = $id === "" ? "SELECT * FROM product" : "SELECT * FROM product WHERE id = $id";
		//var_dump($query);
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
			return rowSet($result);
	}

	// по сути данная фкнция похожа на предыдущие, она и делает тоже самое
	// будем её использовать для выборки продуктов по категориям
	function db_select($table = "", $where = "") {
		global $conn;
		$table = $table == "" ? "product" : $table;
		$where = $where == "" ? "" : " WHERE $where";
		$query = "SELECT * FROM $table $where"; // !!! НЕ НАДО писать ключевое слово WHERE

		//var_dump($query);

		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) > 0)
			return rowSet($result);
	}
    //статус пользователя
	function get_user_status($login) {
		global $conn;
		$query = "SELECT status FROM login WHERE login = '$login'";

		//var_dump($query);

		$result = mysqli_query($conn, $query);

		return mysqli_fetch_array($result)["status"];
	}
    //обновление продукта
	function db_update_product($id, $category, $name, $description, $img, $property, $price, $status) {
		global $conn;
		$query = "UPDATE product SET category='$category', name='$name', description='$description', img='$img', property='$property', price='$price', status='$status' WHERE id=$id";

		//var_dump($query);

		mysqli_query($conn, $query);
	}
	//обновление продукта тест
	function db_update_product1($id, $category, $name, $description, $property, $price, $status) {
		global $conn;
		$query = "UPDATE product SET category='$category', name='$name', description='$description', property='$property', price='$price', status='$status' WHERE id=$id";

		//var_dump($query);

		mysqli_query($conn, $query);
	}
    //удаление продукта
	function db_delete_product($id) {
		global $conn;
		$query = "DELETE FROM product WHERE id=$id";

		//var_dump($query);

		mysqli_query($conn, $query);
	}
    //удаление продукта
    function del_ord($id) {
        global $conn;
        $query = "DELETE FROM ord WHERE id=$id";
        //var_dump($query);
        mysqli_query($conn, $query);
    }
    //Оформление заказа
    function order_ofert ($price, $login, $product) {
        global $conn;
        $user_id = db_select("login", "login = '$login'")[0]["id"];
        $time = date("Y-m-d H:i:s");
        $query = "INSERT INTO `ord` VALUES(NULL, '$time', $price, $user_id, '$product', 'processed')";

        //var_dump($query);

        if(mysqli_query($conn, $query) == true){
            return 1;
        } else{
            return 0;
        }
    }
    //Проверка возможности загрузки картинки
    function can_upload($file){
        if($file['name'] == ''){
            return 'Вы не выбрали файл';
        }
        if($file['size'] == 0){
            return 'Файл слишком большой';
        }

        $getMime = explode('.', $file['name']);

        $mime = strtolower(end($getMime));

        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

        if(in_array($mime, $types)){
            return true;
        }else{
            return 'Недопустимый тип файла';
        }
    }
    //Загрузка картинки
    function make_upload($file, $way_categiry){
        $name = $file['name'];
        $way = 'img/' . $way_categiry . '/' . $name;
        //var_dump($way);
        copy($file['tmp_name'], $way);
        return $way;
    }

