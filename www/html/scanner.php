<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
require_once('utils.php');
session_start();
check_caution();
if ($_GET['do'] == 'start') {
	if (!is_scanning()) {
		if ($_GET['ignore_ping']) {
			exec('nohup bash /home/user/scanner/main.sh ign > a &');
		} else {
			exec('nohup bash /home/user/scanner/main.sh noign > a &');
		}
	}
} else if ($_GET['do'] == 'interrupt') {
	if (is_scanning()) {
		exec('nohup bash /home/user/scanner/interrupt.sh > a &');
	}
}
usleep(500000);
header("Location: index.php");
exit;
?>
