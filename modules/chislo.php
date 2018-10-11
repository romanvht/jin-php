<?php
	include_once '../inc/db.php';
	include_once '../inc/func.php';
	$title = 'Угадай число';
	include_once '../inc/head.php';

	echo '<div class="news3"><div class="news">';
	echo logos().'<br/><span class="vopros result" style="text-align: center;">Перед Вами игра "Угадай число".<br/>
	Ваша задача - отгадать задуманное компьютером 4-значное число (от 1000 до 9999) за минимальное число попыток.<br/>
	Число состоит из различных между собой цифр.<br/>
	После каждого Вашего хода компьютер выдаст сообщение о том, сколько всего цифр из четырех угадано, и сколько из угаданных стоят на своих местах.Чем быстрее Вы отгадаете все число, тем больше очков получите.';
	echo '</span><br/>';
	echo '</div></div>';
?>
<script>
	var n,h=0; 
	function Ask (s) { 
	 document.querySelector(".result").insertAdjacentHTML("beforeEnd", "<br/>"+s+"<br/>");
	}

	function Check () {
	 if (h==0) New();
	 var c=document.Q.number.value;
	 if (c.length==0) {
	  Ask ('Сначала введите пробное число в поле ввода!');
	 }
	 else {
	  var n2=parseInt (c);
	  if (isNaN(n2)==true) {
	   document.Q.number.value='';
	   Ask ('Невозможно прочитать целое число из поля ввода!');
	  }
	  else if (n2<1000) {
	   document.Q.number.value=n2;
	   Ask ('Введенное число должно быть больше 1000!');
	  }
	  else {
	   t=n.toString(); 
	   t2=n2.toString(); 
	   c1=0; 
	   c2=0; 
	   for (i=0; i<4; i++) {
		if (t.charAt(i)==t2.charAt(i)) c2++;
		for (j=0; j<4; j++) {
		 if (t.charAt(i)==t2.charAt(j)) { 
		  c1++; break; 
		 }
		}
	   }
	   if (c2==4) { 
		Ask ('Верно! Это число '+t+'\r\nВаше количество очков:'+(100-h));
		h=0;
	   }
	   else if (h>100) {
		h=0;
		Ask ('Это безнадежно... Вы потратили 100 попыток, но до сих пор не угадали');
	   }
	   else {
		Ask ('<b>Ход ' + h + ') ' + t2+':</b> угадано '+c1+' из 4 цифр, на своих местах '+c2+' из 4');
		h++;
	   }
	  }
	 }
	}

	function Digits (s) {
	 var k=s.length;
	 for (var i=0; i<s.length; i++)
	 for (var j=i+1; j<s.length; j++)
	  if (s.charAt(i)==s.charAt(j)) k--;
	 return k;
	}

	function New () { 
	 do {
	  n=Math.round(Math.random()*10000);
	  s=n.toString();
	  while (s.length < 4) s+='0';
	  n=parseInt(s);
	 } while (Digits (s)<4);
	 document.querySelector(".result").innerHTML = 'Новая игра началась, я задумал число...';
	 h=1;
	}

	function Help () { 
		 document.querySelector(".result").innerHTML = 'Перед Вами игра "Угадай число".'+
		'Ваша задача - отгадать задуманное компьютером 4-значное число (от 1000 до 9999) за минимальное число попыток.'+
		'Число состоит из различных между собой цифр.'+
		'После каждого Вашего хода компьютер выдаст сообщение о том, сколько всего цифр из четырех угадано, и сколько из угаданных стоят на своих местах.'+
		'Чем быстрее Вы отгадаете все число, тем больше очков получите.';
	}
</script>
<div class="text">
	<center>
		<input type=number size=4 min=1000 max=9999 name=number maxlength=4 size=4><input type=Button value="Ход" onClick="Check()">
		<br/><br/>
		<input type=Button value="Помощь" onClick="Help()">&nbsp;<input type=Button value="Заново" onClick="New()">
	</center>
</div>    
<?php
	include_once '../inc/foot.php';
?>
