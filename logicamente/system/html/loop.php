<?php
//$handle = fopen('http://tribunadonorte.com.br/', 'r');
/*
$file = file_get_contents( 'http://tribunadonorte.com.br/' );

$a = array();

$file = preg_replace("/<img.*?>/","",$file);
$file = preg_replace("/href=\"/","href=\"http://www.tribunadonorte.com.br/",$file);
$file = preg_replace("/href='/","href='http://www.tribunadonorte.com.br/",$file);
$file = preg_replace("/com.br\/\//",".com.br/",$file);
$file = preg_replace("/http:\/\/www.tribunadonorte.com.br\/http/","http",$file);


//$file = preg_replace("/http:\/\/www.tribunadonorte.com.br\/\//","http://www.tribunadonorte.com.br/",$file);

preg_match_all("/<a.*?>.*?<\/a>/",$file, $a, PREG_OFFSET_CAPTURE);

foreach ($a[0] as $b) print "<p>".$b[0]."</p>";

//foreach ($a as $b) print_r ($b);
die();

$doc->loadHTML( $file );

$params = $doc->getElementsByTagName('a');
foreach ($params as $param) {
       print $param.'<br>';
}
*/
for( $i = 1; $i <= 100; $i++ ){
	//$file1 = file_get_contents( "http://www.facildownloads.com.br/" );
	$file2 = file_get_contents( "http://www.facildownloads.com.br/new/" );	
	//$doc->loadHTML( $file );
	//$params = $doc->getElementsByTagName('a');
	//foreach ($params as $param) {
       //print $param.'<br>';
	//}	
	//print $file2;
	print $i."<br/>";
}
?>