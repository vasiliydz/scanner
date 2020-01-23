<!DOCTYPE html>
<?php
session_start();
require_once('utils.php');
check_caution();
if($_GET['do'] == 'logout') {
 unset($_SESSION['admin']);
 session_destroy();
}

if(!$_SESSION['admin']){
 header("Location: enter.php");
 exit;
}
?>
<p><a href="index.php">Главная</a> | <a href="admin.php">Админка</a> | <a href="admin.php?do=logout">Выйти</a></p>
<hr />
<a href="chpas.php">Сменить пароль</a>
