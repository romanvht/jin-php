<?php
include_once 'inc/db.php';
include_once 'inc/func.php';

switch($_GET['do']){
	case 'del':
		if($_SESSION['admin'] == $admhash){
			$id = int($_GET['id']);
			$a = $vht->query("SELECT `id` FROM `book` WHERE `id`='$id'")->fetch_assoc();
				if(empty($a[id])){
					$title = 'Гостевая книга';
					include_once 'inc/head.php';
					echo '<div class="text">Ошибка при удалении</div>';
					echo '<div class="menu"><a href="book.php"><img src="/style/ico/back.png"/>  Вернуться</a></div>';
					include_once 'inc/foot.php';
				}else{
					$vht->query('DELETE FROM `book` WHERE `id` = "'.$id.'"');
					header("Location: /book.php?");
					exit();
				}
		}else{
			header("Location: /book.php?");
			exit();   
		}
	break;	
			
	case 'edit':
	if($_SESSION['admin'] == $admhash){
		$id = int($_GET['id']);
		$i = $vht->query("SELECT * FROM `book` WHERE `id`='$id'")->fetch_assoc();
			if(empty($i[id])){
				$title = 'Гостевая книга';
				include_once 'inc/head.php';
				echo '<div class="text">Ошибка при изменении</div>';
				echo '<div class="menu"><a href="book.php"><img src="/style/ico/back.png"/>  Вернуться</a></div>';
				include_once 'inc/foot.php';
			}else{
				if(empty($_POST['submit'])){
					$title = 'Гостевая книга';
					include_once 'inc/head.php';
					echo '<div class="text"><b>IP:</b> '.$i['ip'].'<br/><b>UA:</b> '.$i['ua'].'<br/><b>Hash:</b> '.$i['hash'].' <br/><a href="/adminka.php?do=ban&ip='.$i['ip'].'&hash='.$i['hash'].'">[Забанить]</a></div>';
					echo '<div class="text"><img src="/style/ico/user.png"/> <b>'.$i['name'].'</b> ['.r_time($i['time']).']<br/>'.$i['text'];
					if(!empty($i['otv']))echo '<br/><img src="/style/ico/user.png"/> <span style="color: red;">Ответ:</span> '.$i['otv'];
					echo '</div><div class="text"><form action="?do=edit&id='.$id.'" method="post">';
					echo 'Сообщение:<br/>';    
					echo '<textarea name="msg">'.$i['text'].'</textarea><br />'; 
					echo 'Ответ:<br/>';    
					echo '<textarea name="otv">'.$i['otv'].'</textarea><br />'; 
					echo '<input type="submit" name="submit" value="Изменить">';
					echo '</form></div>';
					echo '<div class="menu"><a href="book.php"><-  Вернуться</a></div>';
					include_once 'inc/foot.php';
				}else{
					$msg = in_t($_POST['msg']);
					$otv = in_t($_POST['otv']);
					
					$sql = $vht->prepare("UPDATE `book` SET `text` = ?, `otv` = ? WHERE `id` = ?");
					$sql->bind_param("ssi", $msg, $otv, $id);
					$sql->execute();
					
					header("Location: /book.php?");
					exit();
				}
			}
	}else{
		 header("Location: /book.php?");
		 exit();
	}
	break;

	default:
		$title = 'Гостевая книга';
		include_once 'inc/head.php';
		$page=intval($_GET['page']);  
		$count= $vht->query("SELECT `id` FROM `book`")->num_rows;  
		$n = new navigator($count, '10', '/book.php?'.$nav);

		$sql = $vht->query("SELECT * FROM `book` ORDER BY `id` DESC ".$n->limit);	

		while($a = $sql->fetch_assoc()){
			$name = $a['adm'] == 0 ? $a['name'] : '<span style="color: red;">Admin</span>';
			echo '<div class="text">';
			echo '<img src="/style/ico/user.png"/> <b>'.$name.'</b> ['.r_time($a['time']).']<br/>'.$a['text'];
			if($_SESSION['admin'] == $admhash)echo '<span style="float: right;"><a href="?do=edit&id='.$a[id].'">[изменить]</a> ==||== <a href="?do=del&id='.$a[id].'">[удалить]</a></span>';
			if(!empty($a['otv']))echo '<br/><img src="/style/ico/que.png"/> <span style="color: red;">Ответ:</span> '.$a['otv'];
			echo '</div>';
		}	

		if($count == 0)echo '<div class="text">Сообщений нет</div>';

		echo '<center>'.$n->navi($str = true, $button = true, $form = true).'</center>';

		echo'<div class="text">';
		echo '<form action="?do=add" method="post">';
		if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $admhash){
			echo 'Ник: ';
			echo empty($_SESSION[nick]) ? '<br/><input type="text" name="nick" value="'.in_t($_SESSION['nick']).'"><br>' : '<b>'.($_SESSION[nick]).'</b><br/>';
		}
		echo 'Сообщение:<br/>';    
		echo '<textarea name="msg"></textarea><br/>';
		if(!isset($_SESSION['admin']) || $_SESSION['admin'] != $admhash){
			echo '<img src="captha.php"/><br>';
			echo 'Bвeдитe Koд:<br>';
			echo '<input type="text" name="code" size="7" maxlength="6"><br/>';
		}
		echo '<input type="submit" value="Написать">
		</form></div>';
		include_once 'inc/foot.php';
	break;

	case 'add':
		$cap = int($_SESSION[code]);
		$code = int($_POST[code]);
		$ip = in_t($_SERVER[REMOTE_ADDR]);

		$name = !empty($_SESSION[nick]) ? in_t($_SESSION[nick]) : in_t($_POST[nick]);
		$msg = in_t($_POST[msg]);
		$adm = 0;
		
		if($_SESSION['admin'] == $admhash)$adm = 1;
		else {
			if($cap != $code)$err='- Неверный код проверки!';
			if(empty($name))$err='- Не заполнено имя!';
		}  
		if(empty($msg))$err='- Не заполнено сообщение!';

		if(empty($err)){
			$sql = $vht->prepare("INSERT INTO `book` (name, text, ip, time, ua, hash, adm) VALUES (?,?,?,?,?,?,?)");
			$sql->bind_param("sssissi", $name, $msg, $ip, time(), $myua, $myhash, $adm);
			$sql->execute();
			
			$_SESSION['nick'] = $name;
			header("Location: /book.php?");
			exit();
		}else{
			$title = 'Гостевая книга';
			include_once 'inc/head.php';
			echo'<div class="text">';
			echo $err;
			echo '</div><div class="menu"><a href="book.php"><img src="/style/ico/back.png"/>  Вернуться</a></div>';
			include_once 'inc/foot.php';
		}
	break;
}
?>