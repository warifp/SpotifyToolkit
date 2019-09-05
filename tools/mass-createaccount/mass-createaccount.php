<?php
error_reporting(0);

/**
 * Author : Wahyu Arif Purnomo
 * Update : 5 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */

$climate->br()->shout('The spotify country will be based on your IP when running this tool.');

$input_list = $climate->info()->input('List?');
$list       = $input_list->prompt();

$input_pass = $climate->info()->input('Default Password?');
$pass       = $input_pass->prompt();

$input_save = $climate->info()->input('Save success results?');
$save_file  = $input_save->prompt();

$file = file_get_contents("$list") or die("" . $climate->br()->error('File not found. Check the file name and try again.') . "");
$data = explode("\n", str_replace("\r", "", $file));

$no = 0;
for ($a = 0; $a < count($data); $a++) {
    $email            = $data[$a];
    $no++;
    
    $version_ua_phone = array(
        'ASUS_T00F',
        'ASUS_T00J',
        'ASUS_T00Q',
        'ASUS_Z007',
        'ASUS_Z00AD',
        'ASUS_X00HD'
    );
    
    $ua_phone = $version_ua_phone[mt_rand(0, sizeof($version_ua_phone) - 1)];
    
    $headers   = array();
    $headers[] = 'User-Agent: Spotify/8.4.98 Android/25 (' . $ua_phone . ')';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Connection: Keep-Alive';
    
    $send = curl('https://spclient.wg.spotify.com:443/signup/public/v1/account/', 'iagree=true&birth_day=12&platform=Android-ARM&creation_point=client_mobile&password=' . $pass . '&key=142b583129b2df829de3656f9eb484e6&birth_year=1998&email=' . $email . '&gender=male&app_version=849800892&birth_month=12&password_repeat=' . $pass, $headers);
    $hasil = json_decode($send[0]);
    
    $array    = objectToArray($hasil);
    #var_dump($array);
    $berhasil = $array['status'];
    $gagal    = $array['errors'];
    
    if ($berhasil == 1) {
        $climate->br()->info($no . '. Success | Email : ' . $email . ' | Username : ' . $array['username'] . ' | Password : ' . $pass);
        
        $save = fopen("result/" . $save_file, 'a');
        fwrite($save, $email . " | " . $pass . " | " . $array['username'] . "\n");
    } else {
        $climate->br()->error($no . '. Failed | Email : ' . $email . ' | Username : ' . $pass . ' | ' . $gagal['email'] . ' ' . $gagal['password']);
    }
}

function objectToArray($d)
{
    if (is_object($d)) {
        // Wahyu Arif Purnomo - System Spotify - Array Object
        $d = get_object_vars($d);
    }
    
    if (is_array($d)) {
        /*
         * Wahyu Arif Purnomo - System Spotify - Array Function
         */
        return array_map(__FUNCTION__, $d);
    } else {
        // Wahyu Arif Purnomo - System Spotify - Return array
        return $d;
    }
}

function curl($url, $fields = null, $headers = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($fields !== null) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    }
    if ($headers !== null) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $result   = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return array(
        $result,
        $httpcode
    );
}

/**
 * Author : Wahyu Arif Purnomo
 * Update : 5 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */