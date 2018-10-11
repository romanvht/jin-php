<?php
session_start();

function in_t($a){
	global $vht;
	$a = $vht->real_escape_string(htmlspecialchars(trim($a)));
	return $a;
}

function in_url($a){
	global $vht;
	$a = $vht->real_escape_string(htmlentities(urlencode(trim($a))));
	return $a;
}

function int($a){
	$a = abs(intval($a));
	return $a;
}

function isClient(){
	return preg_match("/JinnyApp/i", $_SERVER["HTTP_USER_AGENT"]);
}

function isMobile(){
	return preg_match("/(android|avantgo|Alphabet|Jinny|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function isBot(){
	return preg_match("/(YandexBot|Googlebot|yandex.com\/bots|msnbot|Yahoo|StackRambler)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function who(){
	global $vht;
	$ip_on = in_t($_SERVER['REMOTE_ADDR']);
	$ua_on = in_t($_SERVER['HTTP_USER_AGENT']);
	$hash = isset($_COOKIE['hash']) ? in_t($_COOKIE['hash']) : md5($ip_on . $ua_on);
	$_SESSION['hash'] = $hash;
	$bot = 0;
	if (isBot()) $bot = 1;
	$onl = $vht->query("SELECT `id` FROM `online` WHERE `hash` = '$hash'")->num_rows;
	if (empty($onl)){
		$vht->query("INSERT INTO `online`(`time`,`ip`,`ua`, `hash`, `bot`) VALUES ('" . (time() + 600) . "','" . $ip_on . "','" . $ua_on . "', '" . $hash . "', '" . $bot . "')");
	}else{	
		$vht->query("UPDATE `online` SET `time` = '" . (time() + 600) . "',  `ip` = '" . $ip_on . "', `ua` = '" . $ua_on . "', `bot` = '" . $bot . "' WHERE `hash` = '" . $hash . "'");
	}
	setcookie("hash", $hash, time() + 86400 * 365);
	$vht->query("DELETE FROM `online` WHERE `time`< '" . time() . "'");
	$online = $vht->query("SELECT `id` FROM `online` WHERE `bot` = '0'")->num_rows;
	return $online;
}

class navigator{
	public $all = 0;
	public $page;
	public $start = 0;
	public $end = 0;
	public $limit = 'LIMIT 0';
	public $htmlForm = '<form action="%s" method="post">На стр: <input type="text" name="page" size="2" value="%s"><input type="submit" name="" value=">"></form>';
	public $buttonBack = '<a href="%spage=%s"><span class="back">« Назад</span></a> | ';
	public $buttonBackName = '<span class="selected">« Назад</span> | ';
	public $buttonForward = '<a href="%spage=%s"><span class="next">Далее »</span></a>';
	public $buttonForwardName = '<span class="selected">Далее »</span>';
	public $separator = ' ';
	public $listStr = '<br/>Стр: %s <span class="next"><a href="%spage=%s" title="Далее">»</a></span><br />';
	public $blocAllNavi = '%1$s %2$s %3$s';

	function __construct($all, $pnumber, $skript = ''){
		$this->all = $all;
		$this->skript = $skript == '' ? $_SERVER['SCRIPT_NAME'] . '?' : rtrim($skript);
		$this->page = isset($_REQUEST['page']) && (int)$_REQUEST['page'] ? (int)$_REQUEST['page'] : 1;
		$this->num_pages = ceil($all / $pnumber);
		if (isset($_GET['last'])) $this->page = $this->num_pages;
		if ($this->page > $this->num_pages || $this->page < 1) $this->page = 1;
		if ($all) {
			$this->start = $this->page * $pnumber - $pnumber;
			$this->end = ($end = $this->start + $pnumber) > $all ? $all : $end;
			$this->limit = sprintf('LIMIT %s,%s', $this->start, $pnumber);
		}

		$this->pnumber = $pnumber;
	}

	function form(){
		return ($this->num_pages < 2) ? '' : sprintf($this->htmlForm, $this->skript, $this->page);
	}

	function button(){
		$back = $this->page > 1 ? sprintf($this->buttonBack, $this->skript, $this->page - 1) : $this->buttonBackName;
		$forward = $this->page != $this->num_pages ? sprintf($this->buttonForward, $this->skript, $this->page + 1) : $this->buttonForwardName;
		return ($this->num_pages < 2) ? '' : $back . $this->separator . $forward;
	}

	function str(){
		$buff = '';
		for ($pr = '', $i = 1; $i <= $this->num_pages; $i++) {
			$buff.= $pr = (($i == 1 || $i == $this->num_pages || abs($i - $this->page) < 3) ? ($i == $this->page ? '<span class="selected">' . $i . '</span>' : sprintf(' <span class="nosel"><a href="%spage=%s">%2$s</a></span> ', $this->skript, $i)) : (($pr == ' ... ' || $pr == '') ? '' : ' ... '));
		}

		return ($this->num_pages < 2) ? '' : sprintf($this->listStr, $buff, $this->skript, ($this->page != $this->num_pages ? $this->page + 1 : $this->page));
	}

	function navi($str = true, $button = true, $form = true){
		$str = $str ? $this->str() : '';
		$button = $button ? $this->button() : '';
		$form = ($form AND $this->num_pages >= 10) ? $this->form() : '';
		$div1 = ($this->num_pages > 1) ? '<div class="text">' : '';
		$div2 = ($this->num_pages > 1) ? '</div>' : '';
		return $div1 . sprintf($this->blocAllNavi, $button, $str, $form) . $div2;
	}
}

function vrem($time){
	$timep = date("j M Y", $time);
	if (date("Y", $time) == date("Y")) $timep = date("j M", $time);
	$time_p[0] = date("j n Y", $time);
	$time_p[1] = date("H:i", $time);
	if ($time_p[0] == date("j n Y")) $timep = 'Сегодня';
	if ($time_p[0] == date("j n Y", time() - 60 * 60 * 24)) $timep = "Вчера";
	$timep = str_replace("Jan", "Янв", $timep);
	$timep = str_replace("Feb", "Фев", $timep);
	$timep = str_replace("Mar", "Марта", $timep);
	$timep = str_replace("May", "Мая", $timep);
	$timep = str_replace("Apr", "Апр", $timep);
	$timep = str_replace("Jun", "Июня", $timep);
	$timep = str_replace("Jul", "Июля", $timep);
	$timep = str_replace("Aug", "Авг", $timep);
	$timep = str_replace("Sep", "Сент", $timep);
	$timep = str_replace("Oct", "Окт", $timep);
	$timep = str_replace("Nov", "Ноября", $timep);
	$timep = str_replace("Dec", "Дек", $timep);
	return $timep;
}

function r_time($time){
	$timep = date("j M Y в H:i", $time);
	if (date("Y", $time) == date("Y")) $timep = date("j M в H:i", $time);
	$time_p[0] = date("j n Y", $time);
	$time_p[1] = date("H:i", $time);
	if ($time_p[0] == date("j n Y")) $timep = 'Сегодня в ' . date("H:i", $time);
	if ($time_p[0] == date("j n Y", time() - 60 * 60 * 24)) $timep = "Вчера в $time_p[1]";
	$timep = str_replace("Jan", "Янв", $timep);
	$timep = str_replace("Feb", "Фев", $timep);
	$timep = str_replace("Mar", "Марта", $timep);
	$timep = str_replace("May", "Мая", $timep);
	$timep = str_replace("Apr", "Апр", $timep);
	$timep = str_replace("Jun", "Июня", $timep);
	$timep = str_replace("Jul", "Июля", $timep);
	$timep = str_replace("Aug", "Авг", $timep);
	$timep = str_replace("Sep", "Сент", $timep);
	$timep = str_replace("Oct", "Окт", $timep);
	$timep = str_replace("Nov", "Ноября", $timep);
	$timep = str_replace("Dec", "Дек", $timep);
	return $timep;
}

function data($time){
	$timep = date("j M Y H:i", $time);
	$time_p[0] = date("j n Y", $time);
	$time_p[1] = date("H:i", $time);
	$timep = str_replace("Jan", "Янв", $timep);
	$timep = str_replace("Feb", "Фев", $timep);
	$timep = str_replace("Mar", "Марта", $timep);
	$timep = str_replace("May", "Мая", $timep);
	$timep = str_replace("Apr", "Апр", $timep);
	$timep = str_replace("Jun", "Июня", $timep);
	$timep = str_replace("Jul", "Июля", $timep);
	$timep = str_replace("Aug", "Авг", $timep);
	$timep = str_replace("Sep", "Сент", $timep);
	$timep = str_replace("Oct", "Окт", $timep);
	$timep = str_replace("Nov", "Ноября", $timep);
	$timep = str_replace("Dec", "Дек", $timep);
	return $timep;
}

function tim($date){
	$check_time = strtotime($date) - time();
	if ($check_time <= 0) {
		return false;
	}

	$days = floor($check_time / 86400);
	$hours = floor(($check_time % 86400) / 3600);
	$minutes = floor(($check_time % 3600) / 60);
	$seconds = $check_time % 60;
	$str = '';
	if ($days > 0) $str.= tim_name($days, array(
		'день',
		'дня',
		'дней'
	)) . ' ';
	if ($hours > 0) $str.= tim_name($hours, array(
		'час',
		'часа',
		'часов'
	)) . ' ';
	if ($minutes > 0) $str.= tim_name($minutes, array(
		'минута',
		'минуты',
		'минут'
	)) . ' ';
	if ($seconds > 0) $str.= tim_name($seconds, array(
		'секунда',
		'секунды',
		'секунд'
	));
	return $str;
}

function tim_name($digit, $expr, $onlyword = false){
	if (!is_array($expr)) $expr = array_filter(explode(' ', $expr));
	if (empty($expr[2])) $expr[2] = $expr[1];
	$i = preg_replace('/[^0-9]+/s', '', $digit) % 100;
	if ($onlyword) $digit = '';
	if ($i >= 5 && $i <= 20) $res = $digit . ' ' . $expr[2];
	else {
		$i%= 10;
		if ($i == 1) $res = $digit . ' ' . $expr[0];
		elseif ($i >= 2 && $i <= 4) $res = $digit . ' ' . $expr[1];
		else $res = $digit . ' ' . $expr[2];
	}

	return trim($res);
}

$api = $set['api'];

// if(!file_get_contents($api))$api = '';

function new_session(){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/new_session?partner=0&player=website-desktop&constraint=ETAT<>%27AV%27"));
	$_SESSION['sess'] = $data->parameters->identification->session;
	$_SESSION['sig'] = $data->parameters->identification->signature;
	$_SESSION['step'] = $data->parameters->step_information->step;
	$_SESSION['orig_img'] = null;
	$_SESSION['img'] = null;
	$_SESSION['name'] = null;
	$_SESSION['info'] = null;
	$_SESSION['pers'] = null;
	$arr['question'] = $data->parameters->step_information->question;
	return $arr;
}

function exclusion(){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/exclusion?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&forward_answer=1"));
	$arr['question'] = $data->parameters->question;
	$arr['progress'] = round($data->parameters->progression);
	$_SESSION['step'] = $data->parameters->step;
	return $arr;
}

function lists(){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/list?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&size=2&pref_photos=VO-OK&mode_question=0"));
	$_SESSION['img'] = $data->parameters->elements[0]->element->picture_path;
	$_SESSION['name'] = $data->parameters->elements[0]->element->name;
	$_SESSION['info'] = $data->parameters->elements[0]->element->description;
	$_SESSION['pers'] = $data->parameters->elements[0]->element->id;
	return $arr;
}

function answer($answer){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/answer?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&answer=$answer"));
	$arr['question'] = $data->parameters->question;
	$arr['progress'] = round($data->parameters->progression);
	$_SESSION['step'] = $data->parameters->step;
	return $arr;
}

function cancel_answer(){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/cancel_answer?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&answer=-1"));
	$arr['question'] = $data->parameters->question;
	$arr['progress'] = round($data->parameters->progression);
	$_SESSION['step'] = $data->parameters->step;
	return $arr;
}

function list_search($str){
	global $api;
	$str = htmlentities(urlencode($str));
	$data = json_decode(file_get_contents("$api/ws/soundlike_search?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&name=$str"));
	$arr['soundlikes'] = $data->parameters->soundlikes;
	return $arr;
}

function pers_sel($num){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/soundlike_acceptance?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&number=$num"));
	$arr['completion'] = $data->completion;
	return $arr;
}

function pers_add($name, $desc){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/new_element?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&name=$name&description=$desc"));
	$arr['completion'] = $data->completion;
	return $arr;
}

function game_report(){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/report?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . ""));
	$arr['steps'] = $data->parameters->steps;
	$arr['query'] = "$api/ws/report?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "";
	return $arr;
}

function game_end($pers){
	global $api;
	$data = json_decode(file_get_contents("$api/ws/choice?session=" . $_SESSION['sess'] . "&signature=" . $_SESSION['sig'] . "&step=" . $_SESSION['step'] . "&element=$pers"));
	$arr['completion'] = $data->completion;
	return $arr;
}

function logos($text = false){
	$log = '<img src="/logos/' . rand(1, 7) . '.png" style="margin-bottom: 2px; height: 200px;">' . $text;
	return $log;
}

$myip = in_t($_SERVER['REMOTE_ADDR']);
$myua = in_t($_SERVER['HTTP_USER_AGENT']);
$myhash = in_t($_SESSION['hash']);
$st_time = microtime(true);