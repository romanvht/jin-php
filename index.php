<?php
include_once 'inc/db.php';
include_once 'inc/func.php';
include_once 'inc/head.php';
$cb = $vht->query("SELECT `id` FROM `book`")->num_rows;

if($_SESSION[admin] == 1){
  $cm = $vht->query("SELECT `id` FROM `pers_img` WHERE `mod` = '0'")->num_rows;
  echo '<div class="text"><center><a href="/adminka.php">Админ панель</a> ('.$cm.')</center></div>';
}

echo '<div class="news3 last"><div class="news">';
echo '<img src="/logos/1.png" style="margin-bottom: 2px;"><br/><span class="vopros">'.$set['text_main'].'</span><br/>';
echo '<span ><a class="link" href="/game.php?start">'.$set['link_main'].'</a></span></div></div>';
echo '<div class="title first"><span class="tit">История</span></div>';
$sql = $vht->query("SELECT * FROM `history` ORDER BY `id` DESC LIMIT 5");
$i = 1;
while($a = $sql->fetch_assoc()){
  echo '<div class="link2">'.$i.'. <b>'.($a['status'] == 'yes' ? $a['name'] : '<span style="color: red;">'.$a['name'].'</span>').'</b> ['.r_time($a['time']).']</div>';  
  $i++;
}
echo '<a class="menu last" href="/history.php"><img src="style/ico/search.png"/> Показать всю историю...</a>';  
$file=file('modules/anek.txt');
$str=$file[array_rand($file)];
echo '<div class="title first"><span class="tit">Это интересно</span></div>';
echo '<a class="menu" href="/book.php"><img src="style/ico/quest.png"/> Гостевая книга ('.$cb.')</a>';
if(!isClient())echo '<a class="menu" href="/apk/jin.apk"><img src="style/ico/android.png"/> Джинни на Android</a>';
echo '<a class="menu" href="/modules/kart.php"><img src="style/ico/kart.png"/> Магические карточки</a>';
echo '<a class="menu" href="/modules/temp"><img src="style/ico/user.png"/> Мой характер</a>';
echo '<a class="menu last" href="/modules/kvadr.php"><img src="style/ico/kvad.png"/> Магический квадрат</a>';

echo '<div class="title first"><span class="tit">Поиграй с Джинни</span></div>';
echo '<a class="menu" href="http://alphabet.romanvht.ru"><img src="style/ico/alfa.png"/> Головоломка "Алфавит"</a>';
echo '<div class="text">Перемещайте буквы по полю. Когда две одинаковые буквы вместе, они сливаются в новую плитку со следующей буквой! Бейте рекорды игроков и соревнуйтесь с друзьями :)</div>';
echo '<a class="menu" href="/modules/chislo.php"><img src="style/ico/que.png"/> Угадай число?</a>';
echo '<a class="menu" href="/modules/xo"><img src="style/img/bovo.png"/> Крестики-нолики</a>';
echo '<a class="menu" href="/modules/checkers"><img src="style/ico/check.png"/> Шашки</a>';
echo '<a class="menu" href="/modules/chess"><img src="style/ico/chess.png"/> Шахматы</a>';
echo '<a class="menu last" href="/modules/corners"><img src="style/ico/check.png"/> Уголки</a>';

echo '<div class="title first"><span class="tit">Случайный анекдот</span></div>
<div class="text">'.$str.'</div>
<div class="link2">
- <a href="?rand='.rand(1111,9999).'">Обновить</a><br />
- <a href="/modules/anek.php?page=1">Все анекдоты</a><br />
</div>';  

include_once 'inc/foot.php';