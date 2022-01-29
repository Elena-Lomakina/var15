<?php
require_once "include/session.php";
require_once "include/mysqli.php";

if(!empty($_SESSION["status"])) {
    $user = $_SESSION["login"];
} else header("Location: /signup.php");

if($_POST["adduser"])
{
    if(!db_connect())
    {
        $user = htmlentities(mysqli_real_escape_string($conn, $_POST["login"]));
        $password = htmlentities(mysqli_real_escape_string($conn, $_POST["password"]));
        $repeatpassword = htmlentities(mysqli_real_escape_string($conn, $_POST["repeatpassword"]));
        $status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));
        var_dump($user);
        if (!empty($user)){
            if (!db_check_user($user)){
                if (strcmp($password, $repeatpassword) === 0){
                    if(!empty($password) || !empty($repeatpassword)){
                        add_user($user, $password, $status);
                        header("Refresh: 1; url=add_user.php");
                    } else
                        $error = "Пароль не может быть пустым";
                }
                else {
                    $error = "Пароли не совпадают";
                }
            }
            else {
                $error = "Пользователь с таким именем уже существует";
            }
        }
        else {
            $error = "Логин не может быть пустым";
        }
        db_close();
        $ok = "Вы зарегистрировались";
    }
    else
    {
        $error = "Ошибка подключения!";
    }
}

if($_POST["deluser"]) {
    $id = $_POST["deluser"];
    if(!db_connect())
    {
        del_user($id);
        db_close();
    }
    else
    {
        $error = "Ошибка подключения!";
    }
}

if($_POST["cancel"]) {
    header("Refresh: 1; url=add_user.php");
}

if($_POST["saveuser"])
{
    $id_user = $_POST["saveuser"];
    if(!db_connect())
    {
        $user = htmlentities(mysqli_real_escape_string($conn, $_POST["login"]));
        $password = htmlentities(mysqli_real_escape_string($conn, $_POST["password"]));
        $repeatpassword = htmlentities(mysqli_real_escape_string($conn, $_POST["repeatpassword"]));
        $status = htmlentities(mysqli_real_escape_string($conn, $_POST["status"]));
        if (!empty($user)){
            if (!db_check_user($user)){
                if (strcmp($password, $repeatpassword) === 0){
                    if(!empty($password) || !empty($repeatpassword)){
                        edit_user($id_user, $user, $password, $status);
                        header("Refresh: 1; url=add_user.php");
                    } else
                        $error = "Пароль не может быть пустым";
                }
                else {
                    $error = "Пароли не совпадают";
                }
            }
            else {
                //echo $user;
                //echo "<br>";
                //$user_old =  db_check_user_info($id_user)['login'];
                //echo $user_old;
                if($user == $user_old){
                    if (strcmp($password, $repeatpassword) === 0){
                        if(!empty($password) || !empty($repeatpassword)){
                            edit_user($id_user, $user, $password, $status);
                            header("Refresh: 1; url=add_user.php");
                        } else
                            $error = "Пароль не может быть пустым";
                    }
                }
                else{
                    $error = "Пользователь с таким именем уже существует";
                }
            }
        }
        else {
            $error = "Логин не может быть пустым";
        }
        db_close();
        $ok = "Данные обновлены";
        //header("Refresh: 1; url=add_user.php");
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
<center><h2>Добавление пользователя</h2></center>
<?php
if($_POST["edituser"]) {
    $id = $_POST["edituser"];
    if(!db_connect()){
        global $conn;
        $query = "SELECT * FROM login WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $login = $row["login"];
        $status = $row["status"];
    }else{
        $error = "Все поля должны быть заполнены!";
    }
    db_close();
    echo <<<_OUT
            <center>
                <form id="main" method="post">
                            <p>E-mile: <input type="text" name="login" value="$login" ></p>
                            <p>Пароль: <input type="text" name="password" value="*******" ></p>
                            <p>Повторите пароль: <input type="text" name="repeatpassword" value="*******" ></p>                        
                            <p>Статус:
                                <select name="status">
                                    <option selected value="user">Пользователь</option>
                                    <option value="admin">Алдминистратор</option>
                                </select>
                            </p>
                            <button name="saveuser" value="$id">Сохранить</button>
                            <button name="cancel" value="0">Отмена</button>
                        </form>
            </center>
			
_OUT;
}else{
    echo <<<_OUT
            <center>
                <form id="main" method="post">
                            <p>E-mile: <input type="text" name="login" value="" required></p>
                            <p>Пароль: <input type="text" name="password" value="" required></p>
                            <p>Повторите пароль: <input type="text" name="repeatpassword" value="" required></p>                        
                            <p>Статус:
                                <select name="status">
                                    <option selected value="user">Пользователь</option>
                                    <option value="admin">Алдминистратор</option>
                                </select>
                            </p>
                            <button name="adduser" value="1">Добавить</button>
                        </form>
            </center>
_OUT;
}
?>
<center>
    <form id="main" style="font-size: 14pt" method="post">
        <table>
            <tr>
                <td>E-mail</td>
                <td>Статус</td>
            </tr>
            <?php
            if(!db_connect())
            {
                $query = "SELECT * FROM login";
                $res2 = mysqli_query($conn, $query);

                while ($result = mysqli_fetch_array($res2)) {
                    echo <<<_OUT
							<tr>
								<td>{$result['login']}</td>
								<td>{$result['status']}</td>
								<td><button name="edituser" value="{$result['id']}">Редактировать</button></td>
								<td><button name="deluser" value="{$result['id']}">Удалить</button></td>
							</tr>
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