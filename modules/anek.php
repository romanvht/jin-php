<?php
include_once '../inc/db.php';
include_once '../inc/func.php';
$title = 'Анекдоты';
include_once '../inc/head.php';

$file=file('anek.txt');
$page=int($_GET['page']);
if (preg_match("/[^0-9]/", $page)) { exit; }
$end=$page*10;
$start=$end-10;
for ($i=$start; $i<$end; $i++) {
if (!empty($file[$i])) {
$str=trim($file[$i]);
if ($i%2==0) {
echo '<div class="text">';
} else {
echo '<div class="text">';
}
echo '<b>'.($i+1).')</b> '.$str.'</div>
';
}}
$page_nav=ceil(count($file)/10);
if ($page<=$page_nav and $page_nav>1) {
echo '<div class="text">
Страницы: ';
$pages=3;
$link=0;
$link2=0;
if ($page>($page_nav-$pages)) {
$link2=$page_nav-$page;
$link2=$pages-$link2;
}
if ($page>($pages+1) and $page_nav>7) {
echo '<span class="nosel"><a href="?page=1">1</a></span> ';
}
if (($page-$pages)>2 and $page_nav>8) {
echo ' ... ';
}
for ($i=(($page-$pages)-$link2); $i<$page; $i++) {
if ($i>0) {
echo '<span class="nosel"><a href="?page='.$i.'">'.$i.'</a></span> ';
$link++;
}}
$link=$pages-$link;
echo '<span class="selected"><b>'.$page.'</b></span> ';
for ($i=($page+1); $i<((($page+$pages)+1)+$link); $i++) {
if ($i<=$page_nav) {
echo '<span class="nosel"><a href="?page='.$i.'">'.$i.'</a></span> ';
}}
if (($page+$pages)<($page_nav-1) and $page_nav>8) {
echo ' ... ';
}
if ($page<($page_nav-$pages) and $page_nav>7) {
echo '<span class="nosel"><a href="?page='.$page_nav.'">'.$page_nav.'</a></span>';
}
echo '</div>
';
}
include_once '../inc/foot.php';
?>
