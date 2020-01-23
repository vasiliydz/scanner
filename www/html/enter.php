<!DOCTYPE html>
<?php
session_start();
if ($_SESSION['admin']) {
	header('Location: index.php');
	exit;
}

$file = fopen("/var/www/something", "r");
$username = fgets($file);
$password = fgets($file);
fclose($file);
$username = substr($username, 0, strlen($username)-1);
$password = substr($password, 0, strlen($password)-1);

$error_text='';
if($_POST['submit']) {
	if ($username == $_POST['user'] AND $password == md5($_POST['pass'])) {
		$_SESSION['admin'] = true;
		header("Location: index.php");
		exit;
	} else {
		$error_text = '<p><font color="#FF0000">Логин или пароль неверны!</font></p>';
	}
}
?>
<p><a href="index.php">Главная</a> | <a href="enter.php">Вход</a></p>
<hr />
Страница авторизации, но ты не пройдёшь.
<br />
<?=$error_text?>
<form method="post">
Username: <input type="text" name="user" /><br />
Password: <input type="password" name="pass" /><br />
<input type="submit" name="submit" value="Войти" />
</form>
