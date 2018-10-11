<?php 
include 'inc/db.php'; 
include 'inc/func.php'; 

$name = in_t($_GET['name']);

switch($_GET['do']){
	default:
		$title = 'Загрузка нового фото';
		include 'inc/head.php'; 
		
		echo'<div class="text">';
		echo '<form action="?do=add&name='.$name.'" method="post"  enctype="multipart/form-data">';
		echo 'Персонаж: <b>'.$name.'</b><br />';
		echo 'Изображение: (max. 1mb)<br /><input type="file" name="file"/><br />';
		echo '<img src="captha.php"/><br>';
		echo 'Bвeдитe Koд:<br>';
		echo '<input type="text" name="code" size="7" maxlength="6"><br>';
		echo '<input type="submit" value="Изменить изображение">
		</form></div>';
		echo'<div class="text">';
		echo '* Фото станет доступно после одобрения администратором';
		echo '</form></div>';
		include 'inc/foot.php'; 
	break;

	case 'add':
		$cap = int($_SESSION[code]);
		$code = int($_POST[code]);
		$date = time();

		$pics = array('.jpg', '.jpeg', '.gif', '.png', '.bmp', '.JPG', '.JPEG'); 
		$fname = $_FILES['file']['name'];
		$ext = strtolower(strrchr($fname, '.'));
		$fsize = $_FILES['file']['size']; 
		if ($fsize > (1048576 * 1)) {
			$err .= 'Размер фото превышает допустимое значение. [Max. 1mb.]<br />';
		} 
		if (preg_match('/.php/i', $fname) || preg_match('/.pl/i', $fname) || $fname == '.htaccess' || !in_array($ext, $pics)) {
			$err .= 'Не верное расширение файла.<br />';
		} 

		if($cap != $code)$err='- Неверный код проверки!';

		if(empty($err)){
			$foto = 'foto/' . md5(time()) . $ext;
			if(copy($_FILES['file']['tmp_name'], $foto)){
				$sql = $vht->prepare("INSERT INTO `pers_img` (name, img, ip, ua, hash, time) VALUES (?,?,?,?,?,?)");
				$sql->bind_param("sssssi", $name, $foto, $myip, $myua, $myhash, time());
				$sql->execute();
				$id = $sql->insert_id;
				$sql->close();
				header("Location: /img.php?id=$id");
				exit();
			}else{
				$title = 'Загрузка нового фото';
				include 'inc/head.php';
				
				echo '<div class="text">Не удалось загрузить</div>';
				include 'inc/foot.php'; 
			}
		}else{
			$title = 'Загрузка нового фото';
			include 'inc/head.php'; 
			
			echo'<div class="text">';
			echo $err;
			echo '</div><div class="menu"><a href="?name='.$name.'"><- Вернуться</a></div>';
			include 'inc/foot.php'; 
		}
	break;
}
?>