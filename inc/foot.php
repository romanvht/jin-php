<?php
if($_SERVER['PHP_SELF'] != '/index.php')echo '<a class="main" href="/"><img src="/style/ico/home.png"/> На главную</a>';

	$prints = array(
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/c7127.jpg"/></a>', 
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/46a57.gif"/></a>', 
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/46a57.gif"/></a>', 
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/32c0e.gif"/></a>',
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/2ff5e.gif"/></a>',
						'<a href="http://printlike.romanvht.ru" target="_blank"><img style="width: 100%; border-radius: 3px;" src="https://printbar.ru/upload/partners/images/banners/cc229.jpg"/></a>',
						'<iframe style="vertical-align: top; border: none;" width="100%" height="100px" src="https://printbar.ru/widget/?id=439"></iframe>'
						);
	echo '<div class="rekl">'.$prints[rand(0,6)].'</div>';
	echo '<div class="foot">
	<div class="copyright"><a href="/online.php">Онлайн: '.who().' чел.</a><br/>&copy; <a href="http://romanvht.ru">'.$set['copy'].'</a></div>
	<span class="color-button">Сменить стиль</span>
	<div class="count"><a href="http://statok.net/go/18469"><img style="opacity: .5;" src="//statok.net/image/18469" alt="Statok.net" /></a></div>
	</div>';
	$end_time = round((microtime(true) - $st_time), 6);
?> 	
	<script src="/js/main.js?<?php echo $version; ?>"></script>
	<center><span style="font-size: 8px">&copy; API provided by Elocence</span></center>
	</body></html>
	<!-- Время генерации скрипта: <?php echo $end_time ?> сек. -->