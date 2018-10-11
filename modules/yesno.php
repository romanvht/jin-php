<?php
include_once '../inc/db.php';
include_once '../inc/func.php';
$title = 'Комната решений';
include_once '../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br/>';

if(isset($_POST['submit'])){
  $answer = array(1 => 'Да!',
                     2 => 'Нет!',
                     3 => 'Безусловно!',
                     4 => 'Возможно!',
                     5 => 'Не стоит!',
                     6 => 'Конечено!');

  $answerr = $answer[rand(1,6)];

  echo '<span class="vopros" style="text-align: center;">'.$answerr.'</span>';

    $vht->query("INSERT INTO `yesno` (`time`,`answer`,`ip`) VALUES ('".time()."','".$answerr."','".$_SERVER['REMOTE_ADDR']."')");

} else {
  echo '<span class="vopros" style="text-align: center;">Не можете принять окончательное решение?<br/>Мысленно задайте вопрос, а я помогу вам в выборе!</span>';
}
  echo '<form method="post">
        <button style="cursor: pointer;" class="link" name="submit">Принять решение!</button>
        </form>';
echo '</div></div>';

echo '<div class="title"><span class="tit">Последние ответы</span></div>';

$q = $vht->query("SELECT * FROM `yesno` ORDER BY `id` DESC LIMIT 5");
$i = 1;
  while($table = $q->fetch_assoc()){
   echo '<div class="link2">'.$i.'. <b>'.$table['answer'].'</b> ('.r_time($table['time']).')</div>';
  $i++;
  }
	
include_once '../inc/foot.php';		

