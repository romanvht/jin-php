<?php
$vht = new mysqli('mysql101.1gb.ru', 'gb_jin_base', '3z64ef868hj', 'gb_jin_base');
if($vht->connect_errno){
	die('Ошибка подключения '.$vht->connect_error);
}
$vht->set_charset('utf8');

$set = $vht->query("SELECT * FROM `setting` WHERE `id` = '1' LIMIT 1")->fetch_assoc();

$admlogin = $set['login'];
$admpass = md5(sha1($set['pass']));