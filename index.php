<?php
/**
 * PHP+Conky - Bitcoin ticker (Conky graphic and Cmdline alerter)
 * I've made this script:
 * - Show exchanges prices at Conky terminal embedd on my desktop(linux)
 * - Generate an Alert when price changes x USDs
 * - Draw a graphic on desktop to easily see if is a relevant change
 * 
* @package php-bitcointicker-cmdline
* @version 1.0
* @category conky
* @author intrd - http://dann.com.br/
* @copyright 2016 intrd
* @license Creative Commons Attribution-ShareAlike 4.0 International License - http://creativecommons.org/licenses/by-sa/4.0/
* @link https://github.org/intrd/php-bitcointicker-cmdline/
* Dependencies: Yes, see README.md
*/

$root=dirname(__FILE__)."/";
$ext_path=$root."../";
$tmp_path=$ext_path."TMP/";
$data_path=$ext_path."DATA/";
include_once("functions.php");
$browser_agent="Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0";
$cookie=$tmp_path."php-bitcointicker"; 

$alert=3; // <<<<<<<<<< CHANGE HERE YOUR DESIRED USD INTERVAL TO ALERT!

function get_tickerLast($exchange){
	global $cookie, $tmp_path;
	$ticker_tmp=$tmp_path."php-bitcointicker-$exchange"; 	
	$header=array();
	if($exchange=="okcoin.com"){
		$result=url_get("https://www.okcoin.com/api/ticker.do?ok=1",$cookie,"r",$header);
		$ticker=json_decode($result["content"]);
		$last_price=$ticker->ticker->last;
	}
	if($exchange=="foxbit"){
		$result=url_get("https://api.blinktrade.com/api/v1/BRL/ticker",$cookie,"r",$header);
		$ticker=json_decode($result["content"]);
		$last_price=$ticker->last;
	}
	// <<<<<<<<<<<<<< add other exchanges here if u need!
	if (!file_exists($ticker_tmp)){
		fwrite_w($ticker_tmp,$last_price);
		$data["change"]="0";
	}else{
		$fc=file($ticker_tmp);
		$fc=$fc[0];
		$data["change"]=$last_price-$fc;
		fwrite_w($ticker_tmp,$last_price);
	}
	$data["last"]=$last_price;
	return $data;
}

if ($argv[1]=="graph"){
	//echo date("s");
	$ticker=get_tickerLast("okcoin.com");
	//echo 1410/50;
	echo $ticker["last"]/50;
	die;
}

$ticker=get_tickerLast("okcoin.com");
echo "* OKCoin.com -> ".$ticker["last"]." USD";
if($ticker["change"]>=$alert){
	echo ' + + ALERT! Price changed '.round($ticker["change"]).' USD';
}
echo"\n";

$ticker=get_tickerLast("foxbit");
echo "* Foxbit.com.br -> ".$ticker["last"]." BRL";
if($ticker["change"]>=$alert){
	echo ' + + ALERT! Price changed '.round($ticker["change"]).' BRL';
}

?>