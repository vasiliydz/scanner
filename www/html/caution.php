<!DOCTYPE html>
<?php
session_start();
if (!$_SESSION['caution']) {
	header('Location: index.php');
	exit;
}

if ($_GET['do'] == 'yabolshetaknebudu') {
  unset($_SESSION['caution']);
  header('Location: index.php'); 
}

?>
<h1>ВНИМАНИЕ</h1>
<h1>ОБНАРУЖЕНА ПОПЫТКА ЭКСПЛУАТАЦИИ GET-ПАРАМЕТРА</h1>
<h1>ВЫ БОЛЬШЕ ТАК НЕ ДЕЛАЙТЕ</h1>
<a href="caution.php?do=yabolshetaknebudu">Я больше так не буду</a>
