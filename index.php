<?php 
$f = @fopen('stat'. date('d') .'.txt', "a+");
@fwrite($f, "{". date('h:i:s d/m/y') ."} " . $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'] . " {{". $_SERVER['HTTP_USER_AGENT'] ."}}" . " \n");
@fclose($f);
@header('Content-type: xml; charset=utf-8');
$content = @file_get_contents('http://daa.uit.edu.vn/thongbao.xml');
echo $content;
die;
$config['url'] = 'http://daa.uit.edu.vn/';
echo ypParseRss(ypLoadPage($config['url']));

// --------------------

function ypParseRss($xml = array()) {
	$rss = "<?xml version=\"1.0\" encoding=\"utf-8\" ?> \n";
	$rss .= "<rss version=\"2.0\"> \n";
	$rss .= "<channel>";
	$rss .= "<title>UIT DAA FEED by 13520171</title>\n";
	$rss .= "<link>http://go.use.vn/UIT/daaFeed.php</link>\n";
	$rss .= "<description>Phòng đào tạo UIT Feed</description>\n";
	if (is_array($xml) AND count($xml)) {
		foreach($xml as $_xml) {
			$rss .= "  <item>\n";
			$rss .= "    <title>$_xml[title]</title>\n";
			$rss .= "    <link>$_xml[link]</link>\n";
			$rss .= "    <description></description>\n";
			$rss .= "  </item>\n";
		}
	}
	$rss .= "</channel>\n";
	$rss .= "</rss>\n";
	
	return $rss;
}

function ypLoadPage($url) {
	if (!$url OR empty($url)) {
		die('Error:: URL not found!');
	}
	
	$content = @file_get_contents($url);
	if (!$content OR empty($content)) {
		die('Error:: URL not found!');
	}
	
	$content = explode('<h2 class="block-title">Thông báo mới</h2>', $content);
	$content = $content[1];
	$rss = array();
	preg_match_all('/<a(\s)href="\/node\/([0-9]+)">([^<]*)<\/a>/i', $content, $matches);
	if ($matches AND is_array($matches) AND count($matches) > 0) {
		for($i = 0; $i <= count($matches[0]); $i++) {
			$rss[$i]['title'] = $matches[3][$i];
			$rss[$i]['link'] = 'http://daa.uit.edu.vn/node/' . $matches[2][$i];
			$rss[$i]['description'] = $matches[3][$i];
		}
	}
	
	return $rss;
}