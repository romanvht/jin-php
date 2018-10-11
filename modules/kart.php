<?php
include_once '../inc/db.php';
include_once '../inc/func.php';
$title = 'Магические карточки';
include_once '../inc/head.php';

echo '<div class="news3"><div class="news">';
switch($_GET[step]){
default:
echo logos().'<br/><span class="vopros" style="text-align: center;">Веришь в магию? Загадай число от 1 до 100, а я постараюсь отгадать его!';
echo '</span><br/>';
echo '<a class="link" href="?step=1">Я загадал!</a>';
echo '</div></div>';
break;

case '1':
$_SESSION['num'] = 0;
echo logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: red;">
1	3	5	7	9
11	13	15	17	19
21	23	25	27	29
31	33	35	37	39
41	43	45	47	49
51	53	55	57	59
61	63	65	67	69
71	73	75	77	79
81	83	85	87	89
91	93	95	97	99
</span><br/>';
echo '<a class="yes" href="?step=2&yes">Да</a> <a class="no" href="?step=2">Нет</a>';
echo '</div></div>';
break;

case '2':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 1;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: green;">
2	3	6	7	10
11	14	15	18	19
22	23	26	27	30
31	34	35	38	39
42	43	46	47	50
51	54	55	58	59
62	63	66	67	70
71	74	75	78	79
82	83	86	87	90
91	94	95	98	99
</span><br/>';
echo '<a class="yes" href="?step=3&yes">Да</a> <a class="no" href="?step=3">Нет</a>';
echo '</div></div>';
break;

case '3':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 2;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: yellow; color: black;">
64	65	66	67	68	69	70
71	72	73	74	75	76	77
78	79	80	 	 	 	 
81	82	83	84	85	86	87
88	89	90	 	 	 	 
91	92	93	94	95	96	97
98	99	100	 	 	 	 
</span><br/>';
echo '<a class="yes" href="?step=4&yes">Да</a> <a class="no" href="?step=4">Нет</a>';
echo '</div></div>';
break;

case '4':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 64;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: orange;">
4	5	6	7	 	 
12	13	14	15	20	 
21	22	23	28	29	30
31	36	37	38	39	 
44	45	46	47	 	 
52	53	54	55	60	 
61	62	63	68	69	70
71	76	77	78	79	 
84	85	86	87	 	 
92	93	94	95	100	
</span><br/>';
echo '<a class="yes" href="?step=5&yes">Да</a> <a class="no" href="?step=5">Нет</a>';
echo '</div></div>';
break;

case '5':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 4;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: violet;">
8	9	10	 	 	 	 	 
11	12	13	14	15	 	 	 
24	25	26	27	28	29	30	 
31	 	 	 	 	 	 	 
40	41	42	43	44	45	46	47
56	57	58	59	60	 	 	 
61	62	63	 	 	 	 	 
72	73	74	75	76	77	78	79
88	89	90	 	 	 	 	 
91	92	93	94	95	 	 	
</span><br/>';
echo '<a class="yes" href="?step=6&yes">Да</a> <a class="no" href="?step=6">Нет</a>';
echo '</div></div>';
break;

case '6':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 8;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: pink;">
16	17	18	19	20	 
21	22	23	24	25	26
27	28	29	30	 	 
31	 	 	 	 	 
48	49	50	 	 	 
51	52	53	54	55	56
57	58	59	60	 	 
61	62	63	 	 	 
80	 	 	 	 	 
81	82	83	84	85	86
87	88	89	90	 	 
91	92	93	94	95		 	
</span><br/>';
echo '<a class="yes" href="?step=7&yes">Да</a> <a class="no" href="?step=7">Нет</a>';
echo '</div></div>';
break;

case '7':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 16;
echo  logos().'<br/><span class="vopros" style="text-align: center;">Тут есть ваша цифра?</span><br/>';
echo '<span class="vopros" style="text-align: center; background: blue;">
32	33	34	35	36	37	38	39	40
41	42	43	44	45	46	47	 	 
48	49	50	 	 	 	 	 	 
51	52	53	54	55	56	57	 	 
58	59	60	 	 	 	 	 	 
61	62	63	 	 	 	 	 	 
96	97	98	99	100	 	 	 		 	
</span><br/>';
echo '<a class="yes" href="?step=ok&yes">Да</a> <a class="no" href="?step=ok">Нет</a>';
echo '</div></div>';
break;

case 'ok':
if(isset($_GET['yes']))$_SESSION['num'] = $_SESSION['num'] + 32;
echo  logos().'<br/>';
echo '<span class="vopros" style="text-align: center;">Я думаю ваше число: <big><b>'.$_SESSION['num'].'</b></big></span><br/>';
echo '</div></div><div>';
break;
}
if(!empty($_GET[step]))echo '<a class="menu" href="?"><img src="/style/ico/replay.png"/> Еще раз?</a>';

include_once '../inc/foot.php';
?>
