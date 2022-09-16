<?php
require_once("connect.php");
$hash = $_GET['hash'];

$sql = "SELECT * FROM `link` WHERE `hash` = '$hash'";

$s_file = "file/Desert.jpg";
$file = "get_url.txt";


$check = false;

$arr = file($file);

$fd = fopen($file,"w");
if(!$fd) {
	exit("Не возможно открыть файл");
}

if(!flock($fd,LOCK_EX)) {
	exit("Блокировка файла не удалась");
}

for ($i = 0; count($arr) > $i; $i++) {
	
	if($hash == rtrim($arr[$i])) {
		
		$check = TRUE;
	}
	else {
		fwrite($fd,$arr[$i]);
	}
}

if(!flock($fd,LOCK_UN)) {
	exit("Не возможно разблокировать файл");
}
fclose($fd);


if(strlen($hash) != 32) {
	exit("Не правильныая ссылка");
}

if($check) {
	echo "<h3>Добро пожаловать</h3>";
	$sql = "DELETE FROM `link` WHERE `hash` = '$hash'";
	$con->query($sql);
} else{
	exit("Ой что-то пошло не так :D");
}


?>