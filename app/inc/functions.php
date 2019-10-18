<?php 
//Functions
function cutString($string, $string_limit){
	//avoid breaking html
	$string = strip_tags($string);
		
	//check length of string
	if(strlen($string) > $string_limit){
		//truncate string
		$stringCut = substr($string, 0, $string_limit);
		$string = substr($stringCut, 0, strrpos($stringCut, ' ')).' ...';
	}
	echo $string;
}

function generateRandomString($length){
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function getTheIp(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
}
?>
