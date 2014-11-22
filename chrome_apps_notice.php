<?php 
$debug = false;
if (!$debug) {
	$f = @fopen('chrome_stat'. date('d') .'.txt', "a+");
	@fwrite($f, "{". date('h:i:s d/m/y') ."} " . $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'] . " {{". $_SERVER['HTTP_USER_AGENT'] ."}}" . " \n");
	@fclose($f);
}
$config['url'] = 'http://daa.uit.edu.vn/';
$config['rss'] = 'http://daa.uit.edu.vn/thongbao.xml';

echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>Rss DAA Chrome Apps by 13520171</title>";
echo "<style>body{font-family: \"Segoe UI\",Arial; background: #F4F4F4; }a{text-decoration: none; color: #0060A6} a:hover{color:#CF274B} p{width:100%; margin:0;}</style></head>";
echo "<body>";

$xmlDoc = new DOMDocument();
$xmlDoc->load($config['rss']);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=15; $i++)
  {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;

  echo ("<p><a target='_blank' href='" . $item_link
  . "'>" . $item_title . "</a>");
  echo ("<br /></p>");
  }

echo "</body></html>";
