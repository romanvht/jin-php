<?
include_once '../../inc/db.php';
include_once '../../inc/func.php';
$title = 'Мой характер';
include_once '../../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br><span class="vopros" style="text-align: center;">';
if(empty($_POST['x']))
{
echo '1. Вы точно не холерик<br/>';
}
else 
{
$xo1=array_sum($_POST['x']);
$r1=10*$xo1;
echo '1. Вы на '.$r1.'% обладаете качествами  холерик<br/>';
}

if(empty($_POST['s']))
{
echo '2. Вы точно не сангвиник<br/>';
}
else 
{
$xo2=array_sum($_POST['s']);
$r2=10*$xo2;
echo '2. Вы на '.$r2.'% обладаете качествами сангвиника<br/>';
}

if(empty($_POST['f']))
{
echo '3. Вы точно не флегматик<br/>';
}
else 
{
$xo3=array_sum($_POST['f']);
$r3=10*$xo3;
echo '3. Вы на '.$r3.'% обладаете качествами флегматика<br/>';
}

if(empty($_POST['m']))
{
echo '4. Вы точно не милонхолик<br/>';
}
else 
{
$xo4=array_sum($_POST['m']);
$r4=10*$xo4;
echo '4. Вы на '.$r4.'% обладаете качествами миланхолика<br/>';
}
echo '</span></div></div>';
include_once '../../inc/foot.php';
?>
