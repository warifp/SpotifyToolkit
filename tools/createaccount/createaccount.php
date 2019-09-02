<?php
error_reporting(0);

/**
 * Author : Wahyu Arif Purnomo
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */
$climate->br()->shout('The spotify country will be based on your IP when running this tool.');

$input_list = $climate->br()->info()->input('Email?');
$email = $input_list->prompt();

$input_list = $climate->info()->input('Password?');
$pass = $input_list->prompt();

$version_ua_phone = array(
    'ASUS_T00F',
    'ASUS_T00J',
    'ASUS_T00Q',
    'ASUS_Z007',
    'ASUS_Z00AD',
    'ASUS_X00HD',
);

$ua_phone = $version_ua_phone[mt_rand(0, sizeof($version_ua_phone) - 1)];

        $headers = array();
        $headers[] = 'User-Agent: Spotify/8.4.98 Android/25 (' . $ua_phone . ')';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Connection: Keep-Alive';
        
        $send = curl('https://spclient.wg.spotify.com:443/signup/public/v1/account/', 'iagree=true&birth_day=12&platform=Android-ARM&creation_point=client_mobile&password='.$pass.'&key=142b583129b2df829de3656f9eb484e6&birth_year=1998&email='.$email.'&gender=male&app_version=849800892&birth_month=12&password_repeat='.$pass,$headers);
        $data = json_decode($send[0]);
        
        function objectToArray($d) {
            if (is_object($d)) {
                // Wahyu Arif Purnomo - System Spotify - Array Object
                $d = get_object_vars($d);
            }
            
            if (is_array($d)) {
                /*
                * Wahyu Arif Purnomo - System Spotify - Array Function
                */
                return array_map(__FUNCTION__, $d);
            }
            else {
                // Wahyu Arif Purnomo - System Spotify - Return array
                return $d;
            }
        }
        $array = objectToArray($data);
        #var_dump($array);
        $berhasil = $array['status'];
        $gagal = $array['errors'];

        if($berhasil == 1){
            $climate->br()->info('Success Register | Email : ' . $email . ' | Username : ' . $array['username'] . ' | Password : ' . $pass);
        } else {
            $climate->br()->error('Oppps, failed register, ' . $gagal['email'] . ' ' . $gagal['password']);
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
 * Update : 2 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */