<!DOCTYPE html>
<?php
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 1);
require_once('utils.php');
session_start();
check_caution();
if (!$_SESSION['admin']) {
echo '<p><a href="index.php">Главная</a> | <a href="enter.php">Вход</a></p>
<hr />
Ступай отсюда своей дорогой путник';
exit;
}
?>
<p><a href="index.php">Главная</a> | <a href="admin.php">Админка</a> | <a href="admin.php?do=logout">Выйти</a></p>
<hr />
Привет админ!<br><br>
Статус: 
<?php
$file = fopen('/home/user/scanner/status', 'r');
if ($file) {
	$s = explode(' ', fgets($file));
	fclose($file);
	$scanner_links = '<a href="settings.php">Параметры сканера</a><br><br>
		<form action="scanner.php?do=start" method="GET">
		<input type="submit" name="submit" value="Начать сканирование" />
		<input type="hidden" name="do" value="start">
		<input type="checkbox" name="ignore_ping" value="yes">Игнорировать пинг</form><br>';
	if ($s[0] == 'done') {
		echo '<i>Сканирование завершено</i><br><br>';
		echo 'Изменение обнаружено в адресах:<br>';
		echo get_warn_ips();
		echo '<br><br>';
		echo $scanner_links;
	} else if ($s[0] == 'scanning') {
		echo '<i>Сканирование: '.$s[1].' из '.$s[2].'адресов просканировано'.'</i>';
	} else if ($s[0] == 'interrupted') {
		echo '<i>Сканирование прервано</i><br><br>';
		echo $scanner_links;
	} else {
		echo '<i><font color="#FF0000">Статус неизвестен</font></i><br><br>';
		echo $scanner_links;
	}
} else {
	echo '<i><font color="#FF0000">Статус неизвестен</font></i><br><br>';
	echo $scanner_links;
}
?>
