<?php 
include 'inc/db.php'; 
include 'inc/func.php'; 
$title = 'Посетители';
include 'inc/head.php'; 

$do = in_t($_GET['do']);
switch($do){
	default:
		$page=intval($_GET['page']);  
		$count= $vht->query("SELECT `id` FROM `online` WHERE `bot` = '0'")->num_rows;  
		$count_bots= $vht->query("SELECT `id` FROM `online` WHERE `bot` = '1'")->num_rows;  
		$n = new navigator($count, '10', '/online.php?');
		$query = $vht->query('SELECT * FROM `online` WHERE `bot` = 0 ORDER BY `time` DESC '.$n->limit);
		$info = false;
		
	echo '<div class="text" style="text-align: center;">';	
	echo '<a class="link selected">Посетители ('.$count.')</a> <a href="?do=bots" class="link">Боты ('.$count_bots.')</a>';	
	echo '</div>';	
	
	while($arr = $query->fetch_assoc()){
		if($_SESSION['hash'] == $arr['hash'])$style = ' style="background: green; color: #fff"';
		else $style = '';
		echo '<div class="text"'.$style.'>';
		echo '<b>IP:</b> '.$arr['ip'];
		echo '<br/><b>UA:</b> '.$arr['ua'];
		if($_SESSION['admin'] == 1)echo '<br/><b>Hash:</b> '.$arr['hash'];
		echo '</div>';
	}
	echo $n->navi();
	break;
	
	case 'bots':
		$page=intval($_GET['page']);  
		$count= $vht->query("SELECT `id` FROM `online` WHERE `bot` = '1'")->num_rows;  
		$count_users= $vht->query("SELECT `id` FROM `online` WHERE `bot` = '0'")->num_rows;  
		$n = new navigator($count, '10', '/online.php?do=bots&');
		$query = $vht->query('SELECT * FROM `online` WHERE `bot` = 1 ORDER BY `time` DESC '.$n->limit);
		$info = false;
		
		echo '<div class="text" style="text-align: center;">';	
		echo '<a href="?" class="link">Посетители ('.$count_users.')</a> <a class="link selected">Боты ('.$count.')</a>';	
		echo '</div>';	
		
	while($arr = $query->fetch_assoc()){
		if($_SESSION['hash'] == $arr['hash'])$style = ' style="background: green; color: #fff"';
		else $style = '';
		echo '<div class="text"'.$style.'>';
		echo '<b>IP:</b> '.$arr['ip'];
		echo '<br/><b>UA:</b> '.$arr['ua'];
		if($_SESSION['admin'] == 1)echo '<br/><b>Hash:</b> '.$arr['hash'];
		echo '</div>';
	}
	echo $n->navi();
	break;
}

include 'inc/foot.php'; 
?>