<!DOCTYPE html>
<?php
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 1);
require_once('utils.php');
session_start();
check_caution();
if((!$_SESSION['admin']) or is_scanning()){
 header("Location: enter.php");
 exit;
}
?>
<p><a href="index.php">Главная</a> | <a href="admin.php">Админка</a> | <a href="admin.php?do=logout">Выйти</a></p>
<hr />
<?php
$output_text = '';
if($_POST['submit']) {
	if ($_POST['submit'] == 'Remove') {
		if ($_POST['ip_selected'] == '') {
			$output_text = '<p>Вы не выбрали IP-адрес для удаления</p>';
		} else {
			$ret = change_ip_list($_POST['ip_selected'], 'remove');
			if ($ret == 'ok') {
				$output_text = '<p>IP-адрес успешно удалён из списка!</p>';
			}
		}
	} else if ($_POST['submit'] == 'Info') {
		if ($_POST['ip_selected'] == '') {
			$output_text = '<p>Для просмотра информации выберите IP из списка</p>';
		} else {
			header('Location: settings.php?ip_info='.standartize_ip($_POST['ip_selected']));
			exit;
		}
	} else if ($_POST['submit'] == 'Add') {
		if (!check_ip($_POST['new_ip'])) {
			$output_text = '<p>Введённое значение не является IP-адресом</p>';
		} else {
			$new_ip = standartize_ip($_POST['new_ip']);
			$ret = change_ip_list($new_ip, 'add');
			if ($ret == 'ok') {
				$output_text = '<p>IP-адрес успешно добавлен в список!</p>';
			} else if ($ret == 'exists') {
				$output_text = '<p>Такой IP-адрес уже есть в списке</p>';
			} else {
				$output_text = '<p><font color="#FF0000">Произошла какая-то ошибка</font></p>';
			}
		}
	}
}

if ($_GET['ip_info']) {
	if (!check_ip($_GET['ip_info'])) {
		$_SESSION['caution'] = true;
		header('Location: caution.php');
	} else if ($_GET['ip_info'] != standartize_ip($_GET['ip_info'])) {
		$_SESSION['caution'] = true;
		header('Location: caution.php');
	} else {
		$output_text = $_GET['ip_info'];
		$ip_info = get_ip_info(standartize_ip($_GET['ip_info']));
	}
}
?>
<?=$output_text?>
<table><tr>
<td><form action="settings.php" method="post">
Список адресов:<br>
<select size=13 name="ip_selected">
<?php
$file = fopen(ip_list(), 'r');
if ($file) {
	while (($s = fgets($file)) != false) {
		echo '<option>'.$s.'</option>';
	}
}
fclose($file);
?>
</select><br>
<input type="submit" name="submit" value="Remove" />
<input type="submit" name="submit" value="Info" /><br><br>
<input type="text" name="new_ip" /><br><br>
<input type="submit" name="submit" value="Add">
</form></td>
<td><?=$ip_info?></td>
</tr></table>
