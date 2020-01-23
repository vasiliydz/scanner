<!DOCTYPE html>
<?php
require_once('utils.php');
check_caution();
session_start();

if (!$_SESSION['admin']) {
	header('Location: enter.php');
	exit;
}

$file = fopen("/var/www/something", "r");
$username = fgets($file);
$password = fgets($file);
fclose($file);
$username = substr($username, 0, strlen($username)-1);
$password = substr($password, 0, strlen($password)-1);

$output_text = '';
if($_POST['submit']) {
	if (!$_SESSION['admin']) {
		header("Location: enter.php");
		exit;
	} elseif (md5($_POST['old']) != $password) {
		$output_text = '<p><font color="#FF0000">Старый пароль введён неправильно!</font></p>';
	} elseif ($_POST['new'] != $_POST['new_again']) {
		$output_text = '<p><font color="#FF0000">Пароли не совпадают!</font></p>';
	} elseif ($_POST['new'] == '') {
		$output_text = '<p><font color="#FF0000">Не надо оставлять пароль пустым</font></p>';
	} elseif ($_POST['new'] == $_POST['old']) {
		$output_text = '<p>Пароль не изменён, потому что он совпадает со старым</p>';
	} else {
		$file = fopen('/var/www/something', 'w');
		fwrite($file, 'admin'.PHP_EOL.md5($_POST['new']).PHP_EOL);
		fclose($file);
		$output_text = '<p>Пароль успешно изменён</p>';
	}
}
?>
<p><a href="index.php">Главная</a> | <a href="admin.php">Админка</a> | <a href="admin.php?do=logout">Выйти</a></p>
<hr />
<br />
<?=$output_text?>
<form method="post">
<table>
<tr>
<td>Old password:</td> <td><input type="password" name="old" /></td>
</tr><tr>
<td>New password:</td> <td><input type="password" name="new" /></td>
</tr><tr>
<td>New password again:</td> <td><input type="password" name="new_again" /></td>
</table>
<input type="submit" name="submit" value="Изменить пароль" />
</form>
