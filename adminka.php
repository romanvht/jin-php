<?php 
include_once 'inc/db.php'; 
include_once 'inc/func.php'; 

$do = in_t($_GET['do']); 

if(empty($_SESSION['admin'])){
	switch ($do){
		default:
			$title = 'Админка';
			include_once 'inc/head.php';  

			echo'<div class="text">';
			echo'<form action="?do=auth" method="post">
			Логин:<br />
			<input name="login" type="login" size="30" maxlength="30" /><br />
			Пароль:<br />
			<input name="pass" type="password" size="30" maxlength="30" /><br />
			<input name="" type="submit" value="Войти" />
			</form></div>';
		break;

		case 'auth':
			setcookie ("admlogin", "$admlogin",time()+86400*30);
			setcookie ("admpass", "$admpass",time()+86400*30);
			$log = in_t($_POST['login']);
			$pass = in_t($_POST['pass']);

			$title = 'Админка';
			include_once 'inc/head.php';  

				if($log == $admlogin && md5(sha1($pass)) == $admpass){
					$_SESSION['admin'] = 1;
					echo '<div class="text">Добро пожаловать! '.$admlogin.'</div>'; 
				}else{ 
					echo '<div class="text">Введенный логин или пароль неверный!</div>'; 
				}
		break;
	}
}else{
		switch ($do){
		default:
			$title = 'Админка';
			include_once 'inc/head.php';

			echo'<a class="menu" href="?do=img">Модерация</a>
			<a class="menu" href="?do=ban">Забанить IP</a>
			<a class="menu" href="?do=noban">Разбанить IP</a>
			<a class="menu" href="?do=set">Настройки</a>
			<a class="menu" href="?do=exit">Снести сессию</a>';
		break;

		case 'img':
		$title = 'Админка';
		include_once 'inc/head.php';  

			switch($_GET['adm']){
				case 'del':
					$id = int($_GET['id']);
					$a = $vht->query("SELECT `id`, `img`,`mod`,`name` FROM `pers_img` WHERE `id`='$id'")->fetch_assoc();
						if(empty($a[id])){
							echo '<div class="text">Ошибка при удалении</div>';
						}else{
							if(!empty($a['img']))unlink($a['img']);
							$vht->query('UPDATE `history` SET `img` = `original` WHERE `name` = "'.$a['name'].'"');
							$vht->query('DELETE FROM `pers_img` WHERE `id` = "'.$id.'"');
							echo '<div class="text">Успешно удалено</div>';
						}

				break;	

				case 'yes':
					$id = int($_GET['id']);
					$a = $vht->query("SELECT `id`,`mod`,`name`,`img` FROM `pers_img` WHERE `id`='$id'")->fetch_assoc();
						if(empty($a[id])){
							echo '<div class="text">Ошибка!</div>';
						}else{
							$vht->query('UPDATE `history` SET `img` = "'.$a['img'].'" WHERE `name` = "'.$a['name'].'"');
							$vht->query('UPDATE `pers_img` SET `mod` = "1" WHERE `id` = "'.$id.'"');
							$vht->query('UPDATE `pers_img` SET `mod` = "0" WHERE `name` = "'.$a['name'].'" AND `id` != "'.$id.'"');
							echo '<div class="text">Успешно изменено</div>';
						}

				break;

				case 'no':
					$id = int($_GET['id']);
					$a = $vht->query("SELECT `id`,`mod`,`name`,`img` FROM `pers_img` WHERE `id`='$id'")->fetch_assoc();
						if(empty($a[id])){
							echo '<div class="text">Ошибка!</div>';
						}else{
							$vht->query('UPDATE `history` SET `img` = `original` WHERE `name` = "'.$a['name'].'"');
							$vht->query('UPDATE `pers_img` SET `mod` = "2" WHERE `id` = "'.$id.'"');
							echo '<div class="text">Успешно изменено</div>';
						}

				break;
		}

			$page=intval($_GET['page']);  
			$count=$vht->query("SELECT `id` FROM `pers_img`")->num_rows;  
			$n=new navigator($count, '10', '/adminka.php?do=img&'.$nav);
			
			$sql = $vht->query("SELECT * FROM `pers_img` ORDER BY `id` DESC ".$n->limit);	

			while($a = $sql->fetch_assoc()){
				echo '<div class="text"><table class="noclip">';
				echo '<tr><td width="60px" style="vertical-align: middle;">
				<img style="width: 50px; height: 50px; border-radius: 5px;" src="'.$a['img'].'"/>
				</td>
				<td width="90%" style="vertical-align: middle;">';
				echo 'Дата: '.r_time($a['time']).'<br/>
				Персонаж: <b>'.$a['name'].'</b><br/>';
				if($a['mod'] == '0')echo '<a href="/adminka.php?do=img&adm=yes&id='.$a['id'].'">[Принять]</a> | <span style="color: orange;">Не принято</span> | <a href="/adminka.php?do=img&adm=no&id='.$a['id'].'">[Отклонить]</a><br/>';
				if($a['mod'] == '1')echo '<span style="color: green;">Принято</span> | <a href="/adminka.php?do=img&adm=no&id='.$a['id'].'">[Отклонить]</a><br/>';
				if($a['mod'] == '2')echo '<span style="color: red;">Отклонено</span> | <a href="/adminka.php?do=img&adm=yes&id='.$a['id'].'">[Принять]</a><br/>';
				echo '<b>IP:</b> '.$a['ip'].'<br/><b>UA:</b> '.$a['ua'].'<br/><b>Hash:</b> '.$a['hash'].' <br/><a href="/adminka.php?do=ban&ip='.$a['ip'].'&hash='.$a['hash'].'">[Забанить]</a><br/>';
				echo '<br/><a href="/adminka.php?do=img&adm=del&id='.$a['id'].'">Удалить</a><br/>';
				echo '</td></tr>';
				echo '</table></div>';
			}	

			echo '<center>'.$n->navi($str = true, $button = true, $form = true).'</center>';

			if($count == 0)echo '<div class="text">Нет изображений на модерации</div>';

		break;

		case 'ban':
			$title = 'Админка';
			include_once 'inc/head.php';  

			$bip = in_t($_GET['ip']);
			$bhash = in_t($_GET['hash']);

			echo'<div class="text">';
			echo '<form action="?do=ban" method="post">
			Введите IP:<br />
			<input value="'.$bip.'" name="ip" type="text" size="30" maxlength="30" /><br />
			Hash:<br />
			<input value="'.$bhash.'" name="hash" type="text" size="30" maxlength="30" /><br />
			Причина:<br />
			<textarea rows="5" cols="30" name="message"></textarea><br>
			<input name="" type="submit" value="Забанить!" />
			</form>';

			if(!empty($_POST['ip']) || !empty($_POST['hash'])){
				$ip = in_t($_POST['ip']);
				$hash = in_t($_POST['hash']);
				$message = in_t($_POST['message']);
				echo 'Посетитель внесен в черный список';
				$vht->query('INSERT INTO `ban`(`ip`,`hash`,`pri`) VALUES ("'.$ip.'","'.$hash.'","'.$message.'")');
			} 

			echo '</div>';
		break;

		case 'noban':
			$title = 'Админка';
			include_once 'inc/head.php';  

			$nob = int($_POST['nob']);
			echo'<div class="text">';
			if(!empty($nob)){
			echo 'IP разбанен';
			$vht->query('DELETE FROM `ban` WHERE `id` = "'.$nob.'"');
			}
			echo'<form action="?do=noban" method="post">
			Выберите:<br />';
			$sql = $vht->query("SELECT `id`,`ip` FROM `ban` ORDER BY id DESC");
			$c = $sql->num_rows;
			if($c > 0){
				echo '<select name="nob">';
				while($r = $sql->fetch_assoc()){     
					echo '<option value="'.$r['id'].'">'.$r['ip'].' | '.$r['hash'].'</option>';
				}
				echo '</select><br />';
			}else{
				echo 'Нет IP в бане<br />';   
			}    
			echo '<input name="" type="submit" value="Разбанить" />';
			echo'</form>';
			echo'</div>';
		break;

		case 'set':
			$title = 'Админка';
			include_once 'inc/head.php';    
			   
			if(isset($_GET['save'])){
				$sql = $vht->query("SHOW COLUMNS FROM  `setting` WHERE `Field` != 'id'");
				while($b = $sql->fetch_assoc()){
				$Field = str_replace(" ", "_", $b[Field]);
				$z .= ', `'.$b[Field].'` = "'.$vht->real_escape_string($_POST[$Field]).'"';
				}
				if($vht->query("UPDATE `setting` SET `id` = '1'$z WHERE `id` = '1'"))echo '<div class="text"><center>Сохранено успешно!</center></div>';
				else echo '<div class="text"><center>ERRRRRRROOOOOOOORRRRRRRR!</center></div>';
			  }
			echo '<div class="text"><form action="?do=set&save" method="post">';
			$sql = $vht->query("SHOW COLUMNS FROM `setting` WHERE `Field` != 'id'");
			 while($a = $sql->fetch_assoc()){
				$t = explode("(", $a[Type]); 
				echo $a[Field].': ';
				$Field = str_replace(" ", "_", $a[Field]);
				switch($t[0]){
				case 'varchar':
					echo '<input type="text" value="'.$set[$a[Field]].'" name="'.$Field.'" size="30"/><br/>';
				break;
				case 'int':
					echo '<input type="text" value="'.$set[$a[Field]].'" name="'.$Field.'" size="10"/><br/>';
				break;
				case 'text':
					echo '<textarea name="'.$Field.'" style="width: 250px">'.$set[$a[Field]].'</textarea><br/>';
				break;
				case 'set':
					$t[1] = str_replace(")", "", $t[1]);
					$t[1] = str_replace("'", "", $t[1]);
					$s = explode(',', $t[1]); 
						echo '<select name="'.$Field.'">';
							for($i2 = 0; $i2 < count($s); $i2++){
								if($set[$a[Field]] == "$s[$i2]")$select = ' selected';
								else $select = '';	
								echo '<option value="'.$s[$i2].'"'.$select.'>'.$s[$i2].'</option>';
							}
					echo '</select><br/>';
				break;
				case 'enum':
					$t[1] = str_replace(")", "", $t[1]);
					$t[1] = str_replace("'", "", $t[1]);
					$s = explode(',', $t[1]); 
						echo '<select name="'.$Field.'">';
							for($i2 = 0; $i2 < count($s); $i2++){
								if($u[$a[Field]] == "$s[$i2]")$select = ' selected';
								else $select = '';	
								echo '<option value="'.$s[$i2].'"'.$select.'>'.$s[$i2].'</option>';
							}
					echo '</select><br/>';
				break;
				}
			 }
			echo '<br/><input type="submit" value="Сохранить"/>';
			echo '</form></div>';
		break;

		case 'exit':
			setcookie ("admlogin", "0",time()-3600*60*30);
			setcookie ("admpass", "0",time()-3600*60*30);
			session_destroy();

			$title = 'Админка';
			include_once 'inc/head.php';  

			echo '<div class="text">Вы вышли</div>';
		break;

	}
}
if(!empty($do))echo'<div class="menu"><a href="adminka.php">В админку</a></div>';
include_once 'inc/foot.php';
?>