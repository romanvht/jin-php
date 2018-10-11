<?php
include_once 'inc/db.php';
include_once 'inc/func.php';

$do = in_t($_GET['do']);
$answer = int($_GET['a']);
$error = false;

switch ($do) {
	default:
		if (empty($_SESSION['sess']) || empty($_SESSION['sig']) || isset($_GET['start'])) {
			$arr = new_session();
			if (empty($arr['question'])) $error = 1;
		}
		else {
			if (isset($_GET['excl'])) {
				$arr = exclusion();
			}
			else {
				if (isset($_GET['cancel'])) $arr = cancel_answer();
				else $arr = answer($answer);
			}
		}

		$session = int($_SESSION['sess']);
		$sig = int($_SESSION['sig']);
		$answer = int($_GET['a']);
		$step = int($_SESSION['step']);
		if (empty($arr['question'])) $arr = new_session();
		if ($error == 1) {
			$title = 'Технические работы';
			include_once 'inc/head.php';

			echo '<div class="news3"><div class="news">Ведутся технические работы, повторите позднее<br/>' . $arr['query'] . '</div></div>';
		}
		else {
			if (($step < 50 && $arr['progress'] < 99) || isset($_GET['excl'])) {
				$title = 'Вопрос №' . ($step + 1);
				$back_url = empty($step) ? '/' : '?cancel';
				include_once 'inc/head.php';

				echo '<div class="news3"><div class="news">';
				echo logos();
				echo '<br /><span class="vopros">' . $arr['question'] . '</span></div></div>';
				if (empty($arr['progress'])) $arr['progress'] = '0';
				elseif ($arr['progress'] <= 25) $color = 'repeating-linear-gradient(45deg, #FF0000, #FF0000 5px, #B22222 5px, #B22222 10px)';
				elseif ($arr['progress'] > 25 && $arr['progress'] <= 50) $color = 'repeating-linear-gradient(45deg, #FFFF00, #FFFF00 5px, #FFD700 5px, #FFD700 10px)';
				elseif ($arr['progress'] > 50 && $arr['progress'] <= 75) $color = 'repeating-linear-gradient(45deg, #FFA500, #FFA500 5px, #FF7F50 5px, #FF7F50 10px)';
				elseif ($arr['progress'] > 75) $color = 'repeating-linear-gradient(45deg, #32CD32, #32CD32 5px, #008000 5px, #008000 10px)';
				echo '<div class="progress">
				<div class="progress_bar" style="background: ' . $color . '; width: ' . $arr['progress'] . '%;"></div>
				<span class="progress_text">' . $arr['progress'] . '%</span>
				</div>';
				echo '<a class="vote_link yeah" href="?a=0"><img src="style/ico/yes.png"/> Да</a>';
				echo '<a class="vote_link not"  href="?a=1"><img src="style/ico/no.png"/> Нет</a>';
				echo '<a class="vote_link maybe"  href="?a=3"><img src="style/ico/yesque.png"/> Возможно</a>';
				echo '<a class="vote_link scarcely"  href="?a=4"><img src="style/ico/noque.png"/> Не совсем</a>';
				echo '<a class="vote_link not_know"  href="?a=2"><img src="style/ico/que.png"/> Я не знаю</a>';
				echo '<a class="vote_link edit_vote"  href="?cancel"><img src="style/ico/arrow.png"/> Исправить ответ</a>';
				echo '<a class="menu" href="?start"><img src="style/ico/replay.png"/> Начать с начала</a>';
			}
			else {
				$arr = lists();
				$title = 'Я думаю, это...';
				$back_url = '?';
				include_once 'inc/head.php';

				$_SESSION['orig_img'] = '//photos.clarinea.fr/BL_6_ru/600/' . in_t($_SESSION['img']);
				if ($_SESSION['img'] == 'none.jpg') $_SESSION['img'] = '/logos/none.png';
				else $_SESSION['img'] = '//photos.clarinea.fr/BL_6_ru/600/' . in_t($_SESSION['img']);
				$ic = $vht->query("SELECT `img` FROM `pers_img` WHERE `name` = '" . in_t($_SESSION['name']) . "' AND `mod` = '1' LIMIT 1")->fetch_assoc();
				if (!empty($ic['img'])) $_SESSION['img'] = $ic['img'];
				echo '<div class="news3"><div class="news">
				<span class="vopros" style="text-align: center;">
				<img style="max-width: 100%" src="' . in_t($_SESSION['img']) . '"><br/>
				<b>' . in_t($_SESSION['name']) . '</b>
				<br/>' . in_t($_SESSION['info']) . '</span>';
							echo '<br/><a class="yes" href="?do=yes">Да</a>  
				<a class="no" href="?do=no">Нет</a></div></div>';
			}
		}
	break;

	case 'yes':
		$title = 'Я снова угадал!';
		$back_url = '?do=yes';
		include_once 'inc/head.php';

		$q = $vht->query("SELECT * FROM `history` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
		if ($q['name'] != in_t($_SESSION['name']) && !empty($_SESSION['name'])) {
			$sql = $vht->prepare("INSERT INTO `history` (ip, ua, hash, name, info, img, original, status, time) VALUES (?,?,?,?,?,?,?,?,?)");
			$status = 'yes';
			$sql->bind_param("ssssssssi", $myip, $myua, $myhash, in_t($_SESSION['name']) , in_t($_SESSION['info']) , in_t($_SESSION['img']) , in_t($_SESSION['orig_img']) , $status, time());
			$sql->execute();
			$end_step = $step + 1;
			$ar = game_end(int($_SESSION['pers']));
		}

		$c = $vht->query("SELECT `id` FROM `history` WHERE `name` = '" . in_t($_SESSION['name']) . "'")->num_rows;
		echo '<div class="news3"><div class="news">' . logos() . '<br/>
		<span class="vopros" style="text-align: center;">Ура! Я смог отгадать!
		</span></div></div>
		<div class="text" style="text-align: center;"><b>' . in_t($_SESSION['name']) . '</b><br/>' . in_t($_SESSION['info']) . '
		<br/>Персонажа загадывали ' . $c . ' раз(а). </div>';
		echo '<a class="menu" href="/book.php"><img src="style/ico/que.png"/> Оставить отзыв</a>';
		echo '<a class="menu" href="?do=report"><img src="style/ico/game.png"/> Игровой отчет</a>';
		echo '<a class="menu" href="new_img.php?name=' . in_url($_SESSION['name']) . '"><img src="style/ico/foto.png"/> Изменить фото</a>';
		echo '<a class="menu" href="?start"><img src="style/ico/replay.png"/> Загадать еще</a>';
		echo '<div class="text" style="text-align: center;"><script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="//yastatic.net/share2/share.js"></script>
		<div class="ya-share2" data-size="m" data-services="vkontakte,facebook,odnoklassniki,twitter,viber,whatsapp,telegram"></div></div>';
		echo '<div class="title"><span class="tit">Поиграй с Джинни</span></div>';
		echo '<a class="menu" href="http://alphabet.romanvht.ru"><img src="style/ico/alfa.png"/> Головоломка "Алфавит"</a>';
		echo '<a class="menu" href="/modules/chislo.php"><img src="style/ico/que.png"/> Угадай число?</a>';
		echo '<a class="menu" href="/modules/xo"><img src="style/img/bovo.png"/> Крестики-нолики</a>';
		echo '<a class="menu" href="/modules/chess"><img src="style/ico/chess.png"/> Шахматы</a>';
		echo '<a class="menu" href="/modules/corners"><img src="style/ico/check.png"/> Уголки</a>';
	break;

	case 'no':
		$title = 'Я не отгадал!';
		$back_url = '?do=no';
		include_once 'inc/head.php';

		$text = in_t($_POST['text']);
		echo '<div class="news3"><div class="news">' . logos() . '<br/>
		<span class="vopros" style="text-align: center;">    
		Кого вы загадали? Если вы нашли загаданного вами персонажа в списке ниже, то кликните на его имя. Если вашего персонажа нет в списке, то введите свой вариант. Или продолжим с последнего вопроса?
		</span></div></div>';
		echo '<div class="text"><center><form action="?do=no" method="post">';
		echo 'Имя персонажа: <input type="text" value="' . $text . '" name="text" size="25"/>';
		echo '<input name="submit" type="submit" value="Поиск"/></div>';
		
		if (isset($_POST['submit'])) {
			$search = list_search($text);
			if ($search['soundlikes'] != null) {
				foreach($search['soundlikes'] as $key => $value) {
					$name = in_url($value->element->name . ' - ' . $value->element->description);
					echo '<a href="?do=no&pers=' . $key . '&name=' . $name . '" class="menu">- <b>' . in_t($value->element->name) . '</b> - ' . in_t($value->element->description) . "</a>";
				}
			}
			else {
				echo '<div class="text">Не найдено</div>';
			}

			echo '<div class="text"><center><form action="?do=no" method="post">';
			echo 'Имя персонажа: <input type="text" value="' . $text . '" name="name" size="25"/><br/>';
			echo 'Краткое описание: <input type="text" value="" name="desc" size="25"/><br/>';
			echo '<input name="addpers" type="submit" value="Сохранить"/></div>';
		}

		if (isset($_GET['pers']) && !empty($_GET['name'])) {
			$name = in_t($_GET['name']);
			$q = $vht->query("SELECT * FROM `history` WHERE `ip` = '$myip' ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
			$status = 'no';
			if ($q['name'] != $_SESSION['name'] && !empty($_SESSION['name'])) {
				$sql = $vht->prepare("INSERT INTO `history` (ip, ua, hash, name, info, img, original, status, text, time) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$sql->bind_param("sssssssssi", $myip, $myua, $myhash, in_t($_SESSION['name']) , in_t($_SESSION['info']) , in_t($_SESSION['img']) , in_t($_SESSION['orig_img']) , $status, $name, time());
				$sql->execute();
			}

			$ar = pers_sel(int($_GET['pers']));
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="1; URL=/game.php?start">';
			echo '<div class="text"><center>' . $ar['completion'] . '<br/>Перенаправление</center></div>';
			include_once 'inc/foot.php';

			exit();
		}

		if (isset($_POST['addpers'])) {
			$name = in_t($_POST['name']);
			$desc = in_t($_POST['desc']);
			$who = $name . ' - ' . $desc;
			$status = 'no';
			$q = $vht->query("SELECT * FROM `history` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
			if ($q['name'] != $_SESSION['name'] && !empty($_SESSION['name'])) {
				$sql = $vht->prepare("INSERT INTO `history` (ip, ua, hash, name, info, img, original, status, text, time) VALUES (?,?,?,?,?,?,?,?,?,?)");
				$sql->bind_param("sssssssssi", $myip, $myua, $myhash, in_t($_SESSION['name']) , in_t($_SESSION['info']) , in_t($_SESSION['img']) , in_t($_SESSION['orig_img']) , $status, $who, time());
				$sql->execute();
			}

			$ar = pers_add($name, $desc);
			echo '<META HTTP-EQUIV="REFRESH" CONTENT="1; URL=/game.php?start">';
			echo '<div class="text"><center>' . $ar['completion'] . '<br/>Перенаправление</center></div>';
			include_once 'inc/foot.php';

			exit();
		}

		echo '<a class="menu" href="?excl"><img src="style/ico/next.png"/> Продолжить отгадывать</a>';
		echo '<a class="menu" href="?start"><img src="style/ico/replay.png"/> Начать заново</a>';
	break;

	case 'report':
		$title = 'Игровой отчет';
		include_once 'inc/head.php';

		$search = game_report();
		echo '<div class="news3"><div class="news">' . logos() . '<br/>
		<span class="vopros" style="text-align: center;">    
		А теперь можно посмотреть, как вы отвечали на мои вопросы<br/><b>' . in_t($_SESSION['name']) . '</b></span></div></div>';
		if ($search['steps'] != null) {
			foreach($search['steps'] as $key => $value) {
				echo '<div class="text"><b>' . in_t($value->step->question) . '</b><br/>Ответ дан: <b>' . in_t($value->step->given_answer) . '</b> | Ожидаемый ответ: <b>' . in_t($value->step->expected_answer) . '</b></div>';
			}
		}
		else {
			echo '<div class="text">Не найдено</div>';
		}

		echo '<a class="menu" href="javascript:history.back()"><img src="style/ico/arrow.png"/> Назад</a>';
		echo '<a class="menu" href="?start"><img src="style/ico/replay.png"/> Начать заново</a>';
	break;
}

include_once 'inc/foot.php';
