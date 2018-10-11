<?php
include_once 'inc/db.php';
include_once 'inc/func.php';
$title = 'История';
include_once 'inc/head.php';
?>
<script>
document.addEventListener("DOMContentLoaded", function(event) {
	var images = document.querySelectorAll('.image');
	for (var i = 0; i < images.length; i++) {
		images[i].addEventListener("click", function(event){
			var img = this;	
			var src = img.getAttribute('src'); 
			document.getElementsByTagName("body")[0].insertAdjacentHTML("afterBegin", "<div class='popup'>"+ 
							 "<div class='popup_bg'></div><div class='popup_close top_pos'>Закрыть</div><div class='popup_close bottom_pos'>Закрыть</div>"+ 
							 "<img src='"+src+"' class='popup_img' />"+ 
							 "</div>"); 
							 
			document.querySelector(".popup_close.top_pos").addEventListener("click", function(){	   
				  popup = document.querySelector(".popup");
				  popup.parentNode.removeChild(popup);
			});
			document.querySelector(".popup_close.bottom_pos").addEventListener("click", function(){	   
				  popup = document.querySelector(".popup");
				  popup.parentNode.removeChild(popup);
			});
			
		});
	}
});	
</script>

<?php
if($_SESSION['admin'] == 1){
	switch($_GET['adm']){
		case 'del':
			$id = int($_GET['id']);
			$a = $vht->query("SELECT `id` FROM `history` WHERE `id`='$id'")->fetch_assoc();
				if(empty($a[id])){
					echo '<div class="text">Ошибка при удалении</div>';
				}else{
					$vht->query('DELETE FROM `history` WHERE `id` = "'.$id.'"');
					echo '<div class="text">Успешно удалено</div>';
				}
		break;	

		case 'mov':
			$id = int($_GET['id']);
			$a = $vht->query("SELECT `id`,`status` FROM `history` WHERE `id`='$id'")->fetch_assoc();
				if(empty($a[id])){
					echo '<div class="text">Ошибка!</div>';
				}else{
					$status = ($a['status'] == 'yes' ? 'no' : 'yes');
					$vht->query('UPDATE `history` SET `status` = "'.$status.'" WHERE `id` = "'.$id.'"');
					echo '<div class="text">Успешно изменено</div>';
				}
		break;
}
}

	$page=intval($_GET['page']);  
	$count= $vht->query("SELECT `id` FROM `history`")->num_rows;  
	$n = new navigator($count, '10', '/history.php?'.$nav);
	
	$today = $vht->query("SELECT `id` FROM `history` WHERE `time` > '".strtotime(date("d.m.Y", time()))."' AND `time` < '".strtotime(date("d.m.Y", time()+86400))."'")->num_rows;
	
	$sql = $vht->query("SELECT * FROM `history` ORDER BY `id` DESC ".$n->limit);	
	echo '<div class="text"><center>Сегодня загадывали: '.$today.' раз.</center></div>';
	while($a = $sql->fetch_assoc()){
		if($a['img'] == '//photos.clarinea.fr/BL_6_ru/600/none.jpg')$a['img'] = '/logos/none.png';
		echo '<div class="text"><table class="noclip">';
		echo '<tr><td width="70px" style="vertical-align: middle; text-align: center;">
		<img class="image" style="width: 60px; border-radius: 5px;" src="'.$a['img'].'"/>
		</td>
		<td style="vertical-align: middle;">';
		echo 'Дата: '.r_time($a['time']).'<br/>
		Имя: '.$a['name'].' ('.$a['info'].')<br/>';
		echo ($a['status'] == 'yes') ? '<span style="color: green;">Я отгадал!</span>' : '<span style="color: red;">Я не отгадал! Загадывали: </span>'.$a['text'].'<br/>';
			if($_SESSION['admin'] == 1){
			echo '<br/><a href="/adminka.php?do=ban&ip='.$a['ip'].'&hash='.$a['hash'].'">[Забанить]</a><br/><b>IP:</b> '.$a['ip'].'<br/><b>UA:</b> '.$a['ua'].'<br/><b>Hash:</b> '.$a['hash'].'<br/>';
			echo '<a href="?adm=mov&id='.$a['id'].'">Изменить статус</a><br/>';
			echo '<a href="?adm=del&id='.$a['id'].'">Удалить из истории</a><br/>';
			}
		echo '<br/><a href="/new_img.php?name='.$a['name'].'">Предложить фото</a>';
		echo '</td></tr>';
		echo '</table></div>';
	}	
	$sql->free();
	echo '<center>'.$n->navi($str = true, $button = true, $form = true).'</center>';

include_once 'inc/foot.php';
?>