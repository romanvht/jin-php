<?php
include_once '../../inc/db.php';
include_once '../../inc/func.php';
$title = 'Шахматы';
include_once '../../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br/><span class="vopros result" style="text-align: center;">Вы можете играть! Ваши фигуры - белые';
echo '</span><br/>';
echo '</div></div>';
?>

<div class="text">
<script type="text/javascript" src="chess.js"></script>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
  <td>&nbsp;</td>
  <td>
   <center>
   <table><tr><td> 
    <img src="t.png" style="vertical-align: bottom;"><br>
    <script>
	for (var i=0;i<8;++i) {
		document.write("<img src=\"l.png\">");
		for (var j=0;j<8;++j) document.write("<span onclick=\"hu("+j+","+i+")\" id=\""+j+i+"\"><img></span>");
		document.write("<img src=\"r.png\"><br>");
	}

	l();
	</script>
    <img src="u.png" style="vertical-align: top;"><br></td>
   </tr></table>
   </center>
  </td>
  <td>&nbsp;</td>
 </tr>
</table>
</div>  

<div class="title"><span class="tit"><b>Лог игры</b></span></div>
  <div class="text">
	<div id="m0"></div>
	<div id="m1"></div>
	<div id="m2"></div>
	<div id="m3"></div>
	<div id="m4"></div>
	<div id="m5"></div>
  </div>
<?php
echo '<a class="menu" href="?"><img src="/style/ico/replay.png"/> Начать заново</a>';
include_once '../../inc/foot.php';
?>
