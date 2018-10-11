<?php
/* Автор: romanvht 
 roman.vkostin@gmail.com */ 

	$ban = $vht->query("SELECT * FROM `ban` WHERE `ip`='".$myip."' OR `hash`='".$myhash."'")->num_rows;
	if(!empty($ban) && $_SERVER['PHP_SELF'] != '/ban.php')header("Location: /ban.php");

	if(!empty($_COOKIE[admlogin]) && !empty($_COOKIE[admpass])){
		if($admlogin == $_COOKIE[admlogin] && $admpass == $_COOKIE[admpass]){
			$_SESSION[admin] = 1;
		}else{ 
			setcookie ("admlogin", "0",time()-3600*60*30);
			setcookie ("admpass", "0",time()-3600*60*30);
			unset($_SESSION[admin]);
		}
	}

	$style = empty($_COOKIE['style']) ? 'material' : in_t($_COOKIE['style']);
	$theme =  empty($_COOKIE['theme-meta']) ? '#2196F3' : in_t($_COOKIE['theme-meta']);
	
	if(empty($title))$title = $set['title'];
	$version = 'v.1.6.7';

	if(empty($back_url))$back_url = 'javascript:history.back()';
	$control = '';

	if($_SERVER['PHP_SELF'] != '/index.php'){
		$control .= '<a href="/" class="main_logo">Главная</a>';
		$control .= '<a href="'.$back_url.'" class="back_logo">Назад</a>';
	}
?>

	<!DOCTYPE html>
	<html><head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Не хочешь сыграть со мной в игру? Загадай любого реального или вымышленного персонажа, а я постараюсь его угадать!">
	<meta name="keywords" content="джин, джин читает мысли, угадать персонажа, загадай, персонажа, загадай персонажа, загадать вымышленного персонажа, реального, любого, отгадает героя, загадать актера, джин читает мысли">
	<title><?php echo $title; ?> | <?php echo $set['title']; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link id="style" rel="stylesheet" data-version="<?php echo $version; ?>" href="/style/<?php echo $style; ?>.css?<?php echo $version; ?>" type="text/css"/>
	<link rel="apple-touch-icon" sizes="57x57" href="/meta_images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/meta_images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/meta_images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/meta_images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/meta_images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/meta_images/-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/meta_images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/meta_images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/meta_images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/meta_images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/meta_images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/meta_images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/meta_images/favicon-16x16.png">
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#EDD09C">
	<meta name="msapplication-TileImage" content="/meta_images/ms-icon-144x144.png">
	<meta id="theme-meta" name="theme-color" content="<?php echo $theme; ?>">
	</head><body>
	<div class="top top_fix"><span class="tit"><?php echo $title; ?></span><?php echo $control ?></div>
