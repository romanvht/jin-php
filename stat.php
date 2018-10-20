<?php
include_once 'inc/db.php';
include_once 'inc/func.php';
$title = 'Статистика';
include_once 'inc/head.php';
?>
<?php
	$all = $vht->query("SELECT COUNT(id) FROM history")->fetch_row();

	$today = $vht->query("SELECT COUNT(id) FROM history WHERE time > ".strtotime(date("d.m.Y", time()))." AND time < ".strtotime(date("d.m.Y", time()+86400)))->fetch_row();
	$todayYes = $vht->query("SELECT COUNT(id) FROM history WHERE time > ".strtotime(date("d.m.Y", time()))." AND time < ".strtotime(date("d.m.Y", time()+86400))." AND status = 'yes'")->fetch_row();
	$todayNo = $vht->query("SELECT COUNT(id) FROM history WHERE time > ".strtotime(date("d.m.Y", time()))." AND time < ".strtotime(date("d.m.Y", time()+86400))." AND status = 'no'")->fetch_row();

	$yes = $vht->query("SELECT COUNT(id) FROM history WHERE status = 'yes'")->fetch_row();
	$no = $vht->query("SELECT COUNT(id) FROM history WHERE status = 'no'")->fetch_row();

	$userAll = $vht->query("SELECT COUNT(id) FROM history WHERE hash = '$myhash'")->fetch_row();
	$userToday = $vht->query("SELECT COUNT(id) FROM history WHERE hash = '$myhash' AND time > ".strtotime(date("d.m.Y", time()))." AND time < ".strtotime(date("d.m.Y", time()+86400)))->fetch_row();

	$userYes = $vht->query("SELECT COUNT(id) FROM history WHERE status = 'yes' AND hash = '$myhash'")->fetch_row();
	$userNo = $vht->query("SELECT COUNT(id) FROM history WHERE status = 'no' AND hash = '$myhash'")->fetch_row();
?>
<div class="text">
<b>Загадано сегодня:</b> <?php echo $today[0]; ?><br/>
<b>Отгадано:</b> <?php echo $todayYes[0]; ?><br/>  
<b>Не отгадано:</b> <?php echo $todayNo[0]; ?><br/>   
</div> 
<div class="title"><span class="tit">Ваша статистика</span></div> 
<div class="text">
<b>Загадано всего:</b> <?php echo $userAll[0]; ?><br/>
<b>Загадано сегодня:</b> <?php echo $userToday[0]; ?><br/>
<b>Отгадано:</b> <?php echo $userYes[0]; ?> (<?php echo round(100*$userYes[0]/$userAll[0]); ?>%)<br/>  
<b>Не отгадано:</b> <?php echo $userNo[0]; ?> (<?php echo round(100*$userNo[0]/$userAll[0]); ?>%)<br/>
</div>  
<div class="title"><span class="tit">За всё время</span></div> 
<div class="text">
<b>Загадано всего:</b> <?php echo $all[0]; ?><br/>
<b>Загадано вами:</b> <?php echo $userAll[0]; ?><br/>
<b>Отгадано:</b> <?php echo $yes[0]; ?> (<?php echo round(100*$yes[0]/$all[0]); ?>%)<br/>  
<b>Не отгадано:</b> <?php echo $no[0]; ?> (<?php echo round(100*$no[0]/$all[0]); ?>%)<br/>
</div> 
<?php
include_once 'inc/foot.php';
?>
