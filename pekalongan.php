<?php
/**
 * @author Shinchan
 * @package Grabber CheatPekalongan.com
 */
error_reporting(0);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.cheatpekalongan.com/feeds/posts/default");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0");
$source = curl_exec($ch);
curl_close($ch);
echo "NgeGrab cheats at ".date("l, j F Y")."\n\n";

$parse = explode("<link rel='alternate' type='text/html' ",$source);
for($i = 0; $i <= count($parse)-1; $i++){
	$parseTag = explode("/>",$parse[$i]);
	if(preg_match("/title/i",$parseTag[0])){
		preg_match("/href='(.*?)'/",$parseTag[0],$link);
		preg_match("/title='(.*?)'/",$parseTag[0],$title);
		if(preg_match("/\ ".date("j")."\ /",str_replace(date("Y"),"",$title[1]))){
			$titles = str_replace("Link Download File ","",$title[1]);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link[1]);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0");
			$source = curl_exec($ch);
			curl_close($ch);
			preg_match("/<a href=\"(.*?) target=\"_blank\">Donwload File/",$source,$getCheat);
			preg_match("/url=(.*?)\"/",$getCheat[1],$shortLink);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.linkgenerate.com/link.php?token=LG&link=".urlencode(base64_decode($shortLink[1])));
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0");
			$source = curl_exec($ch);
			curl_close($ch);
			preg_match("/<a target='blank' href='(.*?)'>/",$source,$downloadLink);
			echo "$titles\nLink Download => {$downloadLink[1]}\n\n";
		}
	}
}