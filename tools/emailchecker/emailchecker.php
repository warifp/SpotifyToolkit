<?php
error_reporting(0);
/**
 * Author : Wahyu Arif Purnomo
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */

$input_list = $climate->info()->input('List?');
$list = $input_list->prompt();

$input_save = $climate->info()->input('Save live results?');
$save_file = $input_save->prompt();

$file = file_get_contents("$list") or die ("" . $climate->br()->error('File not found. Check the file name and try again.') . "");

$total = preg_split('/\r\n?/', $file);
$climate->br()->comment('There are ' . count($total) . ' accounts in the list that you entered.');
$climate->br();
$no = 0;
for ($a = 0; $a < count($total); $a++) {
    $email   = $total[$a];
    $no++;
	
    $login = http("https://www.spotify.com/id/xhr/json/isEmailAvailable.php?email=" . $email);
    
	$data = json_decode($login);
    $arifJSON = json_encode($data);

    if($arifJSON == "false"){
        $climate->info( $no . '. Live | ' . $email);
        $save = fopen("result/" . $save_file, 'a');
        fwrite($save, $email . "\n");
    } else {
        $climate->error( $no . '. Die  | ' . $email);
    }
}

$climate->br()->shout('Done, your result live saved in folder : result/' . $save_file);

function http($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

/**
 * Author : Wahyu Arif Purnomo
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */
