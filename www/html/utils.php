<?php

function get_path() {
	return '/home/user/scanner';
}

function ip_list() {
	return get_path().'/ips';
}

function is_scanning() {
  $file = fopen(get_path().'/status', 'r');
  if ($file) {
    $s = explode(' ', fgets($file));
    fclose($file);
    return ($s[0] == 'scanning');
  }
  return false;
}

function check_ip($str) {
    $arr = explode('.', $str);
    if (count($arr) != 4) {
        return false;
    }
    for ($i = 0; $i < 4; $i++) {
        if ((int)$arr[$i] > 255 or (int)$arr[$i] < 0) {
	    return false;
        }
    }
    return true;
}

function standartize_ip($str) {
    $a = explode('.', $str);
    for ($i = 0; $i < 4; $i++) {
        $a[$i] = (int) $a[$i];
    }
    return implode('.', $a);
}

function change_ip_list($ip, $action) {
	$fin = fopen(ip_list(), 'r');
	$fout = fopen(ip_list().'tmp', 'w');
	$ret = '';
	if ($action == 'add') {
		while (($s = fgets($fin)) != false) {
			if ($s != $ip.PHP_EOL) {
				fwrite($fout, $s);
			} else {
				fclose($fin);
				fclose($fout);
				exec('rm '.ip_list().'tmp');
				return 'exists';		# ЕСЛИ IP УЖЕ ЕСТЬ В СПИСКЕ
			}
		}
		fwrite($fout, $ip.PHP_EOL);
		$ret = 'ok';
	} else if ($action == 'remove') {
		while (($s = fgets($fin)) != false) {
			if ($s != $ip.PHP_EOL) {
				fwrite($fout, $s);
			}
		}
		$ret = 'ok';
	}
	fclose($fin);
	fclose($fout);
	exec('rm '.ip_list());
	exec('mv '.ip_list().'tmp '.ip_list());
	return $ret;				# ЕСЛИ ВСЁ НОРМ ВОЗВРАЩАЕТ ok
}

function check_caution() {
	if ($_SESSION['caution']) {
		header('Location: caution.php');
	}
}

function get_warn_ips() {
	$file = fopen(get_path().'/warns', 'r');
	$ret = '';
	while (($s = fgets($file)) != false) {
		$ip = substr($s, 0, -1);
		$ret = $ret.PHP_EOL.'<a href="settings.php?ip_info='.$ip.'">'.$ip.'</a><br>';
	}
	fclose($file);
	return $ret.PHP_EOL;
}

function get_ip_info($ip) {
	$nothing = true;
	$ret = 'Информация про IP '.$ip.':<br>'.PHP_EOL;
	$files_array = array('diff_info', 'ports', 'ports_old');
	foreach($files_array as &$filename) {
	$file = fopen(get_path().'/ip_info/'.$ip.'/'.$filename, 'r');
		if ($file) {
			$nothing = false;
			$ret = $ret.'<br><i>'.$filename.'</i>:<br>'.PHP_EOL;
			while (($s = fgets($file)) != false) {
				$ret = $ret.$s.'<br>'.PHP_EOL;
			}
			fclose($file);
		}
	}
	if ($nothing == true) {
		$ret = $ret.'По данному IP нет никакой информации.<br>Чтобы её получить, добавьте его в список и начните сканирование.';
	}
	return $ret;	
}
?>
