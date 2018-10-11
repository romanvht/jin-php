<?
include_once '../../inc/db.php';
include_once '../../inc/func.php';
$title = 'Мой характер';
include_once '../../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br><span class="vopros" style="text-align: center;">Сейчас я определю кто вы по характеру!<br/>Для этого ответьте мне на несколько вопросов. Вы?</span></div></div>';
echo'<div class="text"><form method="post" action="rez.php"><input type="checkbox" name="x[]" value="1"  />1.Отличаетесь неусидчивостью.
<br/><input type="checkbox" name="x[]" value="1"  />2.Вспыльчивы и импульсивны.
<br/><input type="checkbox" 
name="x[]" value="1"  />3.Чаще всего нетерпеливы.
<br/><input type="checkbox" name="x[]" value="1"  />4.Инициативны и решительны.
<br/><input type="checkbox" name="x[]" value="1"  />5.Упорны, даже упрямы.
<br/><input type="checkbox" name="x[]" value="1"  />6.Быстро ориентируетесь в спорах, находчивы.
<br/><input type="checkbox" name="x[]" value="1"  />7.Ритм вашей деятельности неравномерный, скачкообразный.
<br/><input type="checkbox" name="x[]" value="1"  />8.Любите рисковать.
<br/><input type="checkbox" name="x[]" value="1"  />9.Легко прощаете обиды.
<br/><input type="checkbox" name="x[]" value="1"  />10.Ваша речь быстрая и пылкая.
<br/><input type="checkbox" name="s[]" value="1"  />15.Вы жизнерадостный и веселый человек.
<br/><input type="checkbox" name="s[]" value="1"  />16.Энергия бьет ключом, вы всегда собранны.
<br/><input type="checkbox" name="s[]" value="1"  />17.Часто бросаете начатое на полдороге.
<br/><input type="checkbox" name="s[]" value="1"  />18.Не всегда адекватно оцениваете свои силы.
<br/><input type="checkbox" name="s[]" value="1"  />19.Ваши интересы и увлечения часто меняются.
<br/><input type="checkbox" name="s[]" value="1"  />20.К изменившимся планам и новым обстоятельствам привыкаете легко.
<br/><input type="checkbox" name="s[]" value="1"  />21.Вам не трудно отвлекаться от своих дел, вы быстро разбираетесь с чужой проблемой.
<br/><input type="checkbox" name="s[]" value="1"  />22.Тщательная проработка деталей и кропотливый труд не для вас.
<br/><input type="checkbox" name="s[]" value="1"  />23.Вы отзывчивы, любите общение.
<br/><input type="checkbox" name="s[]" value="1"  />24.Ваша речь внятная и громкая.
<br/><input type="checkbox" name="f[]" value="1"  />29.Вы рассеяны, невнимательны.
<br/><input type="checkbox" name="f[]" value="1"  />30.Вы сдержанный и хладнокровный человек.
<br/><input type="checkbox" name="f[]" value="1"  />31.В своих словах и делах вы отличаетесь последовательностью.
<br/><input type="checkbox" name="f[]" value="1"  />32.Вы осторожны и рассудительны.
<br/><input type="checkbox" name="f[]" value="1"  />33.Выдержанны, умеете выжидать.
<br/><input type="checkbox" name="f[]" value="1"  />34.Неразговорчивы, не любите пусто-порожней болтовни.
<br/><input type="checkbox" name="f[]" value="1"  />35.Ваша речь размеренна, спокойна.
<br/><input type="checkbox" name="f[]" value="1"  />36.Вы грамотно распределяете свои силы, никогда не выкладываетесь полностью.
<br/><input type="checkbox" name="f[]" value="1"  />37.У вас существует четкий режим дня, вы планируете свои рабочие дела.
<br/><input type="checkbox" name="f[]" value="1"  />38.Спокойно воспринимаете критику, равнодушны к порицанию.
<br/><input type="checkbox" name="m[]" value="1"  />43.Вы не любите много двигаться, медлительны.
<br/><input type="checkbox" name="m[]" value="1"  />44.Вы застенчивый человек.
<br/><input type="checkbox" name="m[]" value="1"  />45.Новая обстановка вызывает у вас замешательство.
<br/><input type="checkbox" name="m[]" value="1"  />46.Вы неуверенны в себе, своих силах.
<br/><input type="checkbox" name="m[]" value="1"  />47.Одиночество не тяготит вас.
<br/><input type="checkbox" name="m[]" value="1"  />48.Неудачи и неприятности надолго выбивают вас из колеи.
<br/><input type="checkbox" name="m[]" value="1"  />49.В сложные жизненные периоды вы замыкаетесь в себе.
<br/><input type="checkbox" name="m[]" value="1"  />50.Вы не слишком выносливы, быстро устаете.
<br/><input type="checkbox" name="m[]" value="1"  />51.Ваша речь тихая, иногда невнятная.
<br/><input type="checkbox" name="m[]" value="1"  />52.Вы автоматически перенимаете черты характера собеседника и его манеру говорить.
<br/><input type="submit" value="Узнать" /></form></div>';
include_once '../../inc/foot.php';
?>
