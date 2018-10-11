<?php
include_once '../inc/db.php';
include_once '../inc/func.php';
$title = 'Магический квадрат';
include_once '../inc/head.php';

$znak=array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm', '<', '>', '?', '%', '!',);
$otvet=rand(0, (count($znak)-1));
$x=$znak[$otvet];

$a1=rand(0, (count($znak)-1));
$a2=rand(0, (count($znak)-1));
$a3=rand(0, (count($znak)-1));
$a4=rand(0, (count($znak)-1));
$a5=rand(0, (count($znak)-1));
$a6=rand(0, (count($znak)-1));
$a7=rand(0, (count($znak)-1));
$a8=rand(0, (count($znak)-1));
$a9=rand(0, (count($znak)-1));
$a10=rand(0, (count($znak)-1));
$a11=rand(0, (count($znak)-1));
$a12=rand(0, (count($znak)-1));
$a13=rand(0, (count($znak)-1));
$a14=rand(0, (count($znak)-1));
$a15=rand(0, (count($znak)-1));
$a16=rand(0, (count($znak)-1));
$a17=rand(0, (count($znak)-1));
$a18=rand(0, (count($znak)-1));
$a19=rand(0, (count($znak)-1));
$a20=rand(0, (count($znak)-1));
$a21=rand(0, (count($znak)-1));
$a22=rand(0, (count($znak)-1));
$a23=rand(0, (count($znak)-1));
$a24=rand(0, (count($znak)-1));
$a25=rand(0, (count($znak)-1));
$a26=rand(0, (count($znak)-1));
$a27=rand(0, (count($znak)-1));
$a28=rand(0, (count($znak)-1));
$a29=rand(0, (count($znak)-1));
$a30=rand(0, (count($znak)-1));
$a31=rand(0, (count($znak)-1));
$a32=rand(0, (count($znak)-1));
$a33=rand(0, (count($znak)-1));
$a34=rand(0, (count($znak)-1));
$a35=rand(0, (count($znak)-1));
$a36=rand(0, (count($znak)-1));
$a37=rand(0, (count($znak)-1));
$a38=rand(0, (count($znak)-1));
$a39=rand(0, (count($znak)-1));
$a40=rand(0, (count($znak)-1));
$a41=rand(0, (count($znak)-1));
$a42=rand(0, (count($znak)-1));
$a43=rand(0, (count($znak)-1));
$a44=rand(0, (count($znak)-1));
$a45=rand(0, (count($znak)-1));
$a46=rand(0, (count($znak)-1));
$a47=rand(0, (count($znak)-1));
$a48=rand(0, (count($znak)-1));
$a49=rand(0, (count($znak)-1));
$a50=rand(0, (count($znak)-1));

switch($_GET[mod]){
default:
echo '<div class="news3"><div class="news">';
echo logos().'<br/><span class="vopros" style="text-align: center;">
1.Задумайте любое двухзначное число.<br/>
2.Вычтите из него составляющие его цифры (например, из числа 54 надо вычесть 5 и 4, получится 45).<br/>
3.Найдите это число в таблице и символ, которому оно соответствует.<br/>
4.Вообразите мысленно себе этот символ.</span><br/>';
echo '<a href="?mod=1&otvet='.$znak[$otvet].'" class="link">Я загадал!</a></div></div>';

echo "<div class='text'><center>
<span class='vopros_span'>1-<b>$znak[$a1]</b></span>
<span class='vopros_span'>2-<b>$znak[$a1]</b></span>
<span class='vopros_span'>3-<b>$znak[$a2]</b></span>
<span class='vopros_span'>4-<b>$znak[$a3]</b></span>
<span class='vopros_span'>5-<b>$znak[$a4]</b></span>
<span class='vopros_span'>6-<b>$znak[$a5]</b></span>
<span class='vopros_span'>7-<b>$znak[$a6]</b></span>
<span class='vopros_span'>8-<b>$znak[$a7]</b></span>
<span class='vopros_span'>9-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>10-<b>$znak[$a8]</b></span>
<span class='vopros_span'>11-<b>$znak[$a9]</b></span>
<span class='vopros_span'>12-<b>$znak[$a10]</b></span>
<span class='vopros_span'>13-<b>$znak[$a11]</b></span>
<span class='vopros_span'>14-<b>$znak[$a12]</b></span>
<span class='vopros_span'>15-<b>$znak[$a13]</b></span>
<span class='vopros_span'>16-<b>$znak[$a14]</b></span>
<span class='vopros_span'>17-<b>$znak[$a15]</b></span>
<span class='vopros_span'>18-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>19-<b>$znak[$a16]</b></span>
<span class='vopros_span'>20-<b>$znak[$a17]</b></span>
<span class='vopros_span'>21-<b>$znak[$a18]</b></span>
<span class='vopros_span'>22-<b>$znak[$a19]</b></span>
<span class='vopros_span'>23-<b>$znak[$a20]</b></span>
<span class='vopros_span'>24-<b>$znak[$a21]</b></span>
<span class='vopros_span'25->$znak[$a22]</b></span>
<span class='vopros_span'>26-<b>$znak[$a23]</b></span>
<span class='vopros_span'>27-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>28-<b>$znak[$a24]</b></span>
<span class='vopros_span'>29-<b>$znak[$a25]</b></span>
<span class='vopros_span'>30-<b>$znak[$a26]</b></span>
<span class='vopros_span'>31-<b>$znak[$a27]</b></span>
<span class='vopros_span'>32-<b>$znak[$a28]</b></span>
<span class='vopros_span'>33-<b>$znak[$a29]</b></span>
<span class='vopros_span'>34-<b>$znak[$a30]</b></span>
<span class='vopros_span'>35-<b>$znak[$a31]</b></span>
<span class='vopros_span'>36-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>37-<b>$znak[$a32]</b></span>
<span class='vopros_span'>38-<b>$znak[$a33]</b></span>
<span class='vopros_span'>39-<b>$znak[$a34]</b></span>
<span class='vopros_span'>40-<b>$znak[$a35]</b></span>
<span class='vopros_span'>41-<b>$znak[$a36]</b></span>
<span class='vopros_span'>42-<b>$znak[$a37]</b></span>
<span class='vopros_span'>43-<b>$znak[$a38]</b></span>
<span class='vopros_span'>44-<b>$znak[$a39]</b></span>
<span class='vopros_span'>45-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>46-<b>$znak[$a40]</b></span>
<span class='vopros_span'>47-<b>$znak[$a41]</b></span>
<span class='vopros_span'>48-<b>$znak[$a42]</b></span>
<span class='vopros_span'>49-<b>$znak[$a43]</b></span>
<span class='vopros_span'>50-<b>$znak[$a44]</b></span>
<span class='vopros_span'>51-<b>$znak[$a45]</b></span>
<span class='vopros_span'>52-<b>$znak[$a46]</b></span>
<span class='vopros_span'>53-<b>$znak[$a47]</b></span>
<span class='vopros_span'>54-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>55-<b>$znak[$a48]</b></span>
<span class='vopros_span'>56-<b>$znak[$a49]</b></span>
<span class='vopros_span'>57-<b>$znak[$a50]</b></span>
<span class='vopros_span'>58-<b>$znak[$a1]</b></span>
<span class='vopros_span'>59-<b>$znak[$a2]</b></span>
<span class='vopros_span'>60-<b>$znak[$a3]</b></span>
<span class='vopros_span'>61-<b>$znak[$a4]</b></span>
<span class='vopros_span'>62-<b>$znak[$a5]</b></span>
<span class='vopros_span'>63-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>64-<b>$znak[$a6]</b></span>
<span class='vopros_span'>65-<b>$znak[$a7]</b></span>
<span class='vopros_span'>66-<b>$znak[$a8]</b></span>
<span class='vopros_span'>67-<b>$znak[$a9]</b></span>
<span class='vopros_span'>68-<b>$znak[$a10]</b></span>
<span class='vopros_span'>69-<b>$znak[$a11]</b></span>
<span class='vopros_span'>70-<b>$znak[$a12]</b></span>
<span class='vopros_span'>71-<b>$znak[$a13]</b></span>
<span class='vopros_span'>72-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>73-<b>$znak[$a14]</b></span>
<span class='vopros_span'>74-<b>$znak[$a15]</b></span>
<span class='vopros_span'>75-<b>$znak[$a16]</b></span>
<span class='vopros_span'>76-<b>$znak[$a17]</b></span>
<span class='vopros_span'>77-<b>$znak[$a18]</b></span>
<span class='vopros_span'>78-<b>$znak[$a19]</b></span>
<span class='vopros_span'>79-<b>$znak[$a20]</b></span>
<span class='vopros_span'>80-<b>$znak[$a21]</b></span>
<span class='vopros_span'>81-<b>$znak[$otvet]</b></span>
<span class='vopros_span'>82-<b>$znak[$a22]</b></span>
<span class='vopros_span'>83-<b>$znak[$a23]</b></span>
<span class='vopros_span'>84-<b>$znak[$a24]</b></span>
<span class='vopros_span'>85-<b>$znak[$a25]</b></span>
<span class='vopros_span'>86-<b>$znak[$a26]</b></span>
<span class='vopros_span'>87-<b>$znak[$a27]</b></span>
<span class='vopros_span'>88-<b>$znak[$a28]</b></span>
<span class='vopros_span'>89-<b>$znak[$a29]</b></span>
<span class='vopros_span'>90-<b>$znak[$a30]</b></span>
<span class='vopros_span'>91-<b>$znak[$a31]</b></span>
<span class='vopros_span'>92-<b>$znak[$a32]</b></span>
<span class='vopros_span'>93-<b>$znak[$a33]</b></span>
<span class='vopros_span'>94-<b>$znak[$a34]</b></span>
<span class='vopros_span'>95-<b>$znak[$a35]</b></span>
<span class='vopros_span'>96-<b>$znak[$a36]</b></span>
<span class='vopros_span'>97-<b>$znak[$a37]</b></span>
<span class='vopros_span'>98-<b>$znak[$a39]</b></span>
<span class='vopros_span'>99-<b>$znak[$a39]</b></span></div>";
break;

case '1':
$ott=$_GET[otvet];
echo '<div class="news3"><div class="news">';
echo  logos().'<br/><span class="vopros" style="text-align: center;">Я думаю, ваш символ: <big><b>'.$ott.'</b></big></span></div></div>';
echo '<a class="menu" href="?"><img src="/style/ico/replay.png"/> Еще раз?</a>';
break;
}
include_once '../inc/foot.php';
?>
