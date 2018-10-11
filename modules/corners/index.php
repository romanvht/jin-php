<?php
include_once '../../inc/db.php';
include_once '../../inc/func.php';
$title = 'Уголки';
include_once '../../inc/head.php';

echo '<div class="news3"><div class="news">';
echo logos().'<br/><span class="vopros result" style="text-align: center; max-height: 100px;">';
echo '</span><br/>';
echo '</div></div>';
?>

<div class="text">
<script>
<!--
var local_path=new Array(60);
var vars;
var f_hod=new Array(60);
var hod=new Array(60);
var hod_k=new Array(60);
var len,g;
var start_search;
var letr=new Array ('a','b','c','d','e','f','g','h');
var c1,c2,c3; //счет игры
var square_dim = 35; //размер клетки поля
var my_turn = 1; //ход человека?
var selected,to;
var game_is_over = false; //конец игры?

function preload() {
 window.status="Загружаются рисунки...";
 this.length = preload.arguments.length;
 for (var i = 0; i < this.length; i++) {
  this[i] = new Image();
  this[i].src = preload.arguments[i];
 }
 window.status="Готово";
}
var pics = new preload("1.gif","0.gif",
 "00.gif","01.gif","10.gif","11.gif","00a.gif","10a.gif");

var compr = new Array(12);//!!!

var board;
Board(20,21,20,21,01,11,01,11,
      21,20,21,20,11,01,11,01,
      20,21,20,21,01,11,01,11,
      21,20,21,20,21,20,21,20,
      20,21,20,21,20,21,20,21,
      10,00,10,00,21,20,21,20,
      00,10,00,10,20,21,20,21,
      10,00,10,00,21,20,21,20);


function Board() {
 board = new Array();
 for (var i=0;i<8; i++) {
  board[i] = new Array();
  for (var j=0;j<8;j++)
   board[i][j] = Board.arguments[8*i+j];
 }
 board[-2] = new Array(); // во избежание глюков
 board[-1] = new Array();
 board[8] = new Array(); 
 board[9] = new Array();
 initCompr();//!!!
 c1=0;c2=0;c3=0;
}

function initCompr() { //иниц. массив начальной расстановки для компьютера
 var k=0;
 for (var i=0; i<3; i++)
 for (var j=0; j<4; j++) {
  compr[k++]=4+i*10+j;
 }
}  

function newGame() { //кнопка Новая игра
 var s="";
 game_is_over=false;
 for (var i=0; i<8; i++)
 for (var j=0; j<8; j++) {
  if ((i<5) && (j<4) || (i>2) && (j>3)) board[i][j]=((i+j)%2==0 ? 20 : 21);
  else if ((i>4) && (j<4)) board[i][j]=((i+j)%2==0 ? 0 : 10);
  else board[i][j]=((i+j)%2==0 ? 1 : 11);
  if (board[i][j]==1) s="01.gif";
  else if (board[i][j]==0) s="00.gif";
  else if (board[i][j]==10) s="10.gif";
  else if (board[i][j]==11) s="11.gif";
  else if (board[i][j]==21) s="1.gif";
  else if (board[i][j]==20) s="0.gif";
  draw (i,j,s);
 }
 initCompr();
 document.disp.msg.value="";
 message("Вы можете ходить! Вы играете белыми...");
 my_turn = 1;
}

function aboutGame() {
 win2=window.open("help.html","win2", "toolbar=no,scrollbars=yes,directories=no,status=no,menubar=no,resizable=yes,width=640,height=480");
}

var fil;
document.write("<center><table border=0 cellspacing=0 cellpadding=0>"
  +"<tr><td><img src='0.gif'  width=1 height=1></td><td colspan=10><img style='vertical-align: bottom' src='1.gif' width="+(square_dim*8+8)
  +" height=4></td></tr>");
for(var i=0;i<8;i++) {
 document.write("<tr><td valign=center><small>"+(8-i) +"&nbsp;</small></td><td><img src='1.gif' width=4 height="+square_dim+"></td>");
 for(var j=0;j<8;j++) {
  document.write("<td><a href='javascript:clicked("+i+","+j+")'>");
  document.write("<img src='");
  if (board[i][j]==1) document.write("01.gif");
  else if (board[i][j]==0) document.write("00.gif");
  else if (board[i][j]==10) document.write("10.gif");
  else if (board[i][j]==11) document.write("11.gif");
  else if (board[i][j]==21) document.write("1.gif");
  else if (board[i][j]==20) document.write("0.gif");
  fil=getcompcoord(i*10+j);
  document.write("' width="+square_dim+" height="+square_dim+" alt='"+notate(fil)+"'"
   +" name='space"+i+""+j+"' border=0>");
  document.write("</a></td>");
 }
 document.write("<td><img src='1.gif' width=4 height="+square_dim+"></td></tr>");
}
document.write("<tr><td><img src='0.gif' width=1 height=1></td><td colspan=10><img src='1.gif' style='vertical-align: top' width="+(square_dim*8+8)
 +" height=4></td></tr>"
 +"<tr><td colspan=2><small>&nbsp;</small></td>");
for (var t=0; t<8; t++)
 document.write ('<td align=center valign=top><small>'+letr[t]+'</small></td>');
document.write( "</tr></table></center>");
message("Вы можете ходить! Вы играете белыми...");
my_turn = 1;

function left (f,dir,n) { 
 //вернет координаты клетки, отстоящей от поля f на n клеток в направлении dir
 //или (10,10), если нет такой клетки
 var to=coord(10,10);
 if (dir==0) {//вверх
  if (f.x-n>=0) {
   to.x=f.x-n;
   to.y=f.y;
  }
 }
 else if (dir==1) {//вниз
  if (f.x+n<=7) {
   to.x=f.x+n;
   to.y=f.y;
  }
 }
 else if (dir==2) {//влево
  if (f.y-n>=0) {
   to.x=f.x;
   to.y=f.y-n;
  }
 }
 else if (dir==3) {//вправо
  if (f.y+n<=7) {
   to.x=f.x;
   to.y=f.y+n;
  }
 }
 return to;
}

function free (x,y) { //да, если поле (x,y) свободно
 if (board[x][y]>19) return true;
 return false;
}

function kol_free(x,y) { //количество свободных полей рядом с (x,y)
 var kol=0;
 if ((x>0) && (free(x-1,y)==true)) { kol++; }
 if ((x<7) && (free(x+1,y)==true)) { kol++; }
 if ((y>0) && (free(x,y-1)==true)) { kol++; }
 if ((y<7) && (free(x,y+1)==true)) { kol++; }
 return kol;
}

function white (x,y) { //да, если на поле (x,y) белая фишка и ей можно ходить
 if ((board[x][y]==10) || (board[x][y]==00)) {
  var n=0;
  var from=coord(x,y);
  for (var i=0; i<4; i++) {
   var to=left(from,i,2);
   if ((to.x<10) && (free(to.x,to.y)==true)) n++;
  }
  if ((n>0) || (kol_free(x,y)>0)) return true;
  else { message ("Извините, этой шашкой некуда ходить ;-)"); }
 }
 else {
  message("Извините, но ходить можно только своей шашкой ;-)");
 }
 return false;
}

function message(str) { //Вывод сообщения в поле сообщений
 document.querySelector('.result').innerHTML = str;
}

function Coord(x,y) { //конструктор для типа "координаты"
 this.x = x;
 this.y = y;
}

function coord(x,y) { //функция возвращает объект "координаты"
 var c = new Coord(x,y);
 return c;
}

function clicked(i,j) { //щелчок по полю - первая вызываемая функция
 if (game_is_over==false) {
  if (my_turn==1) {
   if (white(i,j)==true) {
    selected = coord(i,j);
    message ("Вы ходите с поля "+notate(selected));
    draw (selected.x,selected.y,((selected.x+selected.y)%2==0 ? "00a" : "10a")+".gif");
    my_turn=2;
   }
  }
  else if (my_turn==2) {
   to=coord(i,j);
   if (legal_move(selected,to)==true) {
    move (selected,to);
    message("Вы сходили на поле "+notate(to));
    my_turn=0;
    move_comp();
    my_turn=1;
   }
   else if ((to.x==selected.x) && (to.y==selected.y)) { //отмена хода
    my_turn=1;
    message("Ход с поля "+notate(selected)+" отменен");
    draw (selected.x,selected.y,((selected.x+selected.y)%2==0 ? "00" : "10")+".gif");
   }
   else {
    message("Недопустимый ход c поля "+notate(selected)+" на "+notate(to)+". Щелкните по клетке назначения заново или повторно щелкните по полю для отмены");
   }
  }
  else {
   message("Дождитесь Вашего хода;-)");
  }
 }
 else {
  message ("Вы не в игре ;-) Нажмите кнопку \"Новая игра\"");
 }
}

function abs(num) { //модуль числа
 return Math.abs(num);
}

function near (f1,f2) { //да, если поля f1 и f2 рядом
 var dx=abs(f1.x-f2.x);
 var dy=abs(f1.y-f2.y);
 if ( (dx==1) && (dy==0) ||
      (dx==0) && (dy==1)) return true;
 return false;
}

function opposite (dir) { //вернет направление, противоположное dir
 if (dir==0) return 1;
 else if (dir==1) return 0;
 else if (dir==2) return 3;
 else if (dir==3) return 2;
}

function way (f1,f2,fromdir) { //да, если есть путь через шашки с f1 на f2
//fromdir - направление, откуда пришли - во избежание переполнения стека
 for (var i=0;i<4;i++) { //перебираем направления
  var to=left(f1,i,2);
  if ((to.x<10) && (free(to.x,to.y)==true)) {//клетка через одну есть и свободна
   var f0=left(f1,i,1);
   if (free(f0.x,f0.y)==false) { //клетка рядом занята
    if ((to.x==f2.x) && (to.y==f2.y)) {
     return true;
    }
    else if (i!=fromdir) {
     var go=true;
     for (var k=0; k<len; k++) {
      if ( (local_path[k].x==to.x) && (local_path[k].y==to.y) ) { go=false; }
     }
     if (go==true) {
      local_path[len++]=to;
      var r=way(to,f2,opposite(i));
      if (len>0) len--;
      if (r==true) return true;
      continue;
     }
     delete go;
    }
   }
   delete f0;
  }
  delete to;
 }
 return false; 
}

function legal_move (from,to) { //допустимость хода
 if ((to.x < 0) || (to.y < 0) || (to.x > 7) || (to.y > 7)) return false;
 if ((free(to.x,to.y)==true) && (near(from,to)==true)) return true;
 len=1;
 local_path[0]=from;
 return way(from,to,-1);
}

function draw(x,y,name) { //нарисовать по координатам (x,y) рисунок name
 document.images["space"+x+""+y].src = name;
}

function move (from,to) { //перемещение фишки
 var col=board[from.x][from.y]%10;
 if ((from.x+from.y)%2==0) board[from.x][from.y]=20;
 else board[from.x][from.y]=21;
 draw (from.x,from.y,board[from.x][from.y]%10+".gif");
 if ((to.x+to.y)%2==0) {
  board[to.x][to.y]=col;
 }
 else {
  board[to.x][to.y]=10+col;
 }
 draw (to.x,to.y,((to.x+to.y)%2==0?"0":"")+board[to.x][to.y]+".gif");
}

function distance (from,to) { //Клеточное расстояние от from до to
 return (abs(from.x-to.x)+abs(from.y-to.y));
}

function getcompcoord(n) { //получить x- и y- координаты по адресу ячейки n
 var y=n%10;
 var x=(n-y)/10;
 var my=coord(x,y);
 return my;
}

function max (a,b) { return ((a)>(b)?(a):(b)); }
function min (a,b) { return ((a)<(b)?(a):(b)); }

function placed (my) { //да, если фишка компьютера на месте
 if ((my.x>4) && (my.y<4)) return true;
 else return false;
}

function comp_placed () { //Количество фишек компа на местах
 var kol=0;
 var my;
 for (var t=0; t<12; t++) {
  my=getcompcoord(compr[t]);
  if (placed (my)==true) kol++;
 }
 return kol;
}

function man_placed () { //Количество фишек человека на местах
 var kol=0;
 for (var i=0; i<3; i++) 
 for (var j=4; j<8; j++) 
  if ((board[i][j]==10) || (board[i][j]==00)) kol++;
 return kol;
}

function near_dist (f) { //минимальное расстояние от f1 до ближайшая к данной фишка компа
 var num=8;
 var my=getcompcoord(f);
 var his,d;
 for (var t=0; t<12; t++) {
  if (compr[t]!=f) {
   his=getcompcoord(compr[t]);
   d=distance(my,his);
   if (d<num) num=d;
  }
 }
 return num;
}

function goal (nin,n) { 
 //Расчет целевой функции для данной позиции фишек после хода фишкой nin на compr[nin] (длина шага=n)
 var res,my,pen;
 var to=getcompcoord(compr[nin]);
 var start=getcompcoord(start_search);
 var corner;
 var dist1=near_dist(compr[nin]);//расстояние до своих фишек в рез-те хода
 res=0; pent=0;
 corner=coord(7,0);
 var pl=comp_placed();//кол-во фишек на местах
 if (pl==12) { g=-1e10; return g; }

 for (var i=0; i<12; i++) { //основная минимизируемая ф-я - сумма клеточных расстояний до угла
  my=getcompcoord(compr[i]);
  res+=distance(my,corner);
 }

 //штрафы:
 if (start.x<2) {
  if (pl<3) {
   if ((start.x==0) && (to.x==0)) pent+=5;
  } 
  if ( (start.x>5) && (to.x>=start.x) ) pent-=5; //подгоняем хвосты
 } 

 if ( !( (start.x<2) && (start.y<2) || (start.x>4) && (start.y>4)  ) ) { //если идем не из угла
  if ( ((to.x<3) && (to.y<3)) || ((to.x>4) && (to.y>4))) { //понижаем приоритет у ходов в угол
   if ( (to.x==2) && (to.y==2) || (to.x==5) && (to.y==5) ) pent++; //кроме c6,f3
   else if (max(to.x,to.y)==2 || min(to.x,to.y)==5) pent+=3;
   else if (max(to.x,to.y)==1 || min(to.x,to.y)==6) pent+=7;
   else pent+=11;
  }
 }
 if (n<2) {//ходы на крайние линии
  if ((start.y>0) && (to.y==0) && (to.x<4) || (start.x<7) && (to.x==7) && (to.y>4)) pent+=5;
 }

 if (pl<7) { 
  if (placed(start)==true) pent+=2; //в начале снижаем приоритет ходов уже размещенными
//  if ((n==0) && (dist1>1)) pent+=2; //а также ходы-передвижения, ведущие к отрыву
 }
 if (pl>7) { //в конце штрафуем за ходы назад и ходы с поля назначения
  if (to.x<start.x) pent+=10;
  if ( (placed(start)==false) && (placed(to)==true) )  pent-=10;
  if ( (to.x<=start.x) && ((to.x==3) || (to.x==4)) && ((to.y==0) || (to.y==1)) ) pent+=10; //ходы на a4-b5 в конце - неэффективно
  //else if ((start.x<7) && (to.x==7) && (to.y==4)) pent+=10; //e1 тоже
 }
 if (pl>9) { //в конце контролируем ходы внутри размещенных
  if ((placed(start)==true) && (placed(to)==false)) pent+=10;
  if (placed(start)==false) {
   if (placed(to)==true) pent-=10;
  }
  if (distance(to,corner)<distance(start,corner)) pent-=5;
  if ( (start.y!=2) && (to.x<=start.x) && (to.y==2) && (to.x<4) ) pent+=6; //c5-c8
 }

//!!! if (pl>9) document.forms[0].msg.value='\r\nstart:'+start.x+' '+start.y+' to:'+to.x+' '+to.y+'g='+(res+pent)+document.forms[0].msg.value;
 return (res+pent);
}

function Rand (n) { //Случайное целое k, 0<=k<n 
 var d=new Date();
 return d.getTime()%n;
}

function links (my,nin,fromdir,compr) { //ходы по цепочке для поля my (номер фишки=nin)
 //compr - массив координат фишек, так как будем его переопределять
 //fromdir - направление, откуда пришли - во избежание переполнения стека
 for (var dir=0;dir<4;dir++) { //перебираем направления
  var to=left(my,dir,2);
  if ((to.x<10) && (free(to.x,to.y)==true)) {//клетка через одну есть и свободна
   var f0=left(my,dir,1);
   if ( (free(f0.x,f0.y)==false) && (len<59)) { //клетка рядом занята
    var temp=compr[nin];
    compr[nin]=to.x*10+to.y;
    var g2=goal(nin,len);
    var go=true;
    for (var k=0; k<len; k++) { //исключаем самопересечения пути, чтоб не переполнить стек
     if (local_path[k]==compr[nin]) { go=false; break; }
    }
    if (go==true) {
     if (g2<g) { 
      vars=0;
      g=g2;
     }
     if (g2<=g) {
      if (vars<59) {
       f_hod[vars]=start_search;//откуда ходим - в данном случае всегда с точки входа!
       hod[vars]=compr[nin]; //куда ходим
       hod_k[vars++]=nin; //какой фишкой
      }
     }
     local_path[len++]=compr[nin];
     links (to,nin,opposite(dir),compr);
     if (len>0) len--;
    }
    compr[nin]=temp;
   }
   delete f0;
  }
  delete to;
 }
}

function notate (f) { //нотация для поля f
 return letr[f.y]+(8-f.x);
}

function notation (from,to) { //возвращает нотацию для хода с from на to
 return ""+notate(from)+"-"+notate(to);
}

function make_move (from,to) { //Выполнить ход компьютера плюс проверка окончания
 move (from,to);
 message("Я сходил "+notation(from,to)+" Ваш ход ;-)");
 if (comp_placed()==12) {
  if (man_placed()<12) {
   c3++;
   results();
   message("Ура, я выиграл! ;-) Сыграем еще?");
  }
  else {
   c2++;
   results();
   message("Боевая ничья! ;-) Сыграем еще?");
  }
  game_is_over=true;
 }
 else if (man_placed()==12) {
  c1++;
  results();
  message("Что ж, Вы выиграли ;-( Сыграем еще?");
  game_is_over=true;
 }
}

var minlen; //минимальная длина цепочки заключит. ходов
var from_r, to_r, fish_r;
var rec_deep=5; //глубина рекурсии в конце

function recurse (fil,rec) { //рекурсивный поиск для установки последней фишки (текущая глубина rec)
 if (comp_placed()==12) {
  if (len<minlen) {
   minlen=len;
   from_r=getcompcoord(f_hod[0]);
   to_r=getcompcoord(hod[0]);
   fish_r=hod_k[0];
  }
  return;
 }
 if (rec==rec_deep) return;
 for (var i=0; i<12; i++) {
  var my=getcompcoord(compr[i]);  
  for (var dir=0; dir<4; dir++) {
   for (var dis=1; dis<3; dis++) {
    var to=left(my,dir,dis);
    if ((to.x==fil.x) && (to.y==fil.y)) {
     f_hod[len]=compr[i];//откуда ходим
     hod[len]=fil.x*10+fil.y; //куда ходим
     hod_k[len++]=i; //какой фишкой
     fil=getcompcoord(compr[i]);
     compr[i]=to.x*10+to.y;
     recurse (fil,rec+1);
     if (len>0) len--;
     compr[i]=f_hod[len];
     fil=getcompcoord(hod[len]);
    }
   } 
  }
 }
}

function move_comp() { //ход компьютера
 if (comp_placed()==11) { //финальный анализ !!!
  var fil,fish;
  fil=coord(10,10);
  for (var i0=5; i0<8; i0++)
  for (var j0=0; j0<4; j0++) {
   if (free(i0,j0)==true) fil=coord (i0,j0);
  }
  if (fil.x<10) { //свободная клетка есть в зоне заставления
   for (var i0=0; i0<12; i0++) {
    fish=getcompcoord(compr[i0]);
    if (placed (fish)==false) break;
   }
   if ( (fish.x!=4) && (fish.y!=4) || (fish.x==4) && (fish.y==4)) {} //еще не подошел к линии
   else {
    len=0;
    minlen=rec_deep;
    recurse (fil,0);
    if (minlen<rec_deep) {
     compr[fish_r]=to_r.x*10+to_r.y;
     make_move (from_r,to_r);
     return;
    }
   }
  }
 }

 g=1e10;
 vars=0;
 for (var i=0; i<12; i++) {
  var my=getcompcoord(compr[i]);
  for (var dir=0; dir<4; dir++) { //ходы на соседние клетки
   var to=left(my,dir,1);
   if ((to.x<10) && (free(to.x,to.y)==true)) {
    start_search=compr[i]; 
    compr[i]=to.x*10+to.y;
    var g2=goal(i,0);
    if (g2<g) {
     vars=0; g=g2;
    }
    if (g2<=g) {
     if (vars<59) {
      f_hod[vars]=start_search;//откуда ходим
      hod[vars]=compr[i]; //куда ходим
      hod_k[vars++]=i; //какой фишкой
     }
    }
    compr[i]=start_search;
   }
  }
  len=1; //ищем новый путь
  local_path[0]=compr[i];
  start_search=compr[i]; 
  links(my,i,-1,compr); //ходы по цепочке из этой клетки
 }
 if (vars>0) {
  var num=Rand(vars); //выбираем ход из равных
  var num_k=hod_k[num]; //номер фишки
  compr[num_k]=hod[num];
  var to=getcompcoord(compr[num_k]);
  var from=getcompcoord(f_hod[num]);
  make_move(from,to);
 }
 else {
  c1++;
  message("Я не нашел вариантов хода! Сдаюсь, Вы выиграли ;-(");
  game_is_over=true;
 }
}

function results() { //результаты игры
 message('Ваши результаты: побед - '+c1+', ничьих - '+c2+', поражений - '+c3);
}

/*function check_best () { //таблица лучших
}*/

// -->
</script>
</div>
<div class="title"><span class="tit"><b>Правила игры</b></span></div>
  <div class="text">
Игроки ходят по очереди своими фишками. Ваши - белые ;-)<br/><br/>
Цель игры - первым провести свои фишки на место положения фишек соперника, то есть, поля от e6 до h8 для Вас, и на поля от a1 до d3 для компа.
<br/><br/>Можно делать ходы двух видов: сдвинуть свою фишку на одну клетку в любом направлении или прыгать через фишки на любое возможное количество клеток. Каждый прыжок выполняется через одну свою или чужую фишку, все поля "приземления" должны быть свободны, делать ходы по кругу (то есть, завершать ход на поле, где он начался), нельзя.
<br/><br/>Для того, чтобы сделать ход, просто щелкните по фишке, которой Вы ходите (она при этом пожелтеет), а затем по полю, куда Вы собираетесь ходить. Комп сообщает о своих и Ваших ходах, а также о возникающих проблемах (например, Вы пытаетесь выполнить недопустимый ход) в текстовом окне под доской. Если Вы щелкнули по фишке, а затем передумали ей ходить, щелкните по ней повторно для отмены хода. По завершении партии комп сообщает об ее результате и общем счете текущей игры. 
  </div>
<?php
echo '<a class="menu" href="?"><img src="/style/ico/replay.png"/> Начать заново</a>';
include_once '../../inc/foot.php';
?>
