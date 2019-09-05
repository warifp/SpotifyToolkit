<?php
require_once('vendor/autoload.php');
$climate = new League\CLImate\CLImate;
$progress = $climate->progress()->total(100);

/**
 * Author : Wahyu Arif Purnomo
 * Update : 5 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */

function progress($progress){
    for ($i = 0; $i <= 100; $i++) {
        $progress->current($i);
        usleep(30000);
     }
}   

################################
$banner     = "
......00000000000...... ||
....000000000000000.... ||
...000........000000... || Author  : Wahyu Arif Purnomo
..000..000000.....000.. || Version : 3.0
..00000......00000000.. || Create  : 01 September 2019
..00000000000,...0000.. || Update  : 05 September 2019
..00000.......0000000.. || Name    : Spotify Toolkit
...00000000000..0000... || ## Spotify - Music For Everyone
....000000000000000.... ||
......00000000000...... ||

[!] Spotify is a digital music streaming service, I made several tools for you.
";
print $banner;

$climate->br()->info('Oops, additional programs are needed to run this tool.');
sleep(5);
$climate->br()->info('Start a check for needs..');
progress($progress);

if(!fsockopen("spotify.com", 80)) {
    die ("" . $climate->br()->backgroundRed()->out("Could not open the server, connection issues?"));
}  

if(phpversion() < "7.0.0"){
    die ("" . $climate->br()->backgroundRed()->out("Your PHP Version is " . phpversion() . ", this PHP Version no support, please update to PHP Version 7."));
}

$climate->br()->backgroundGreen()->out('Congratulations, the requirements for the program have been fulfilled.');
sleep(5);

$input = $climate->br()->input('See the tool menu? (y/n)');
$input->accept(['n', 'y']);
$input->strict();

$lihatmenu = $input->prompt();

################## MENU ##################
if ($lihatmenu == "y"){
    $menulist = "
    [1] Check all accounts
    [2] Check account email
    [3] Create an account
    [4] Create an account [mass]
    [5] Music or Playlist Downloader [Maintenance]
    ";
    print $menulist;
} else if ($lihatmenu == "n") {
    // Die menu [WahyuArifPurnomo]
}

################## Pilih Menu ##################
/** Select */
$input_pilih = $climate->br()->shout()->input('> Enter your choice (1-4) : ');

$pilih = $input_pilih->prompt();
/** End Select */

if($pilih>30 OR $pilih<1){
    $climate->br()->error('Options not available, please choose existing ones!');

    /** Enter Select return */
    $input_pilih = $climate->br()->shout()->input('> Enter your choice (1-4) : ');

    $pilih = $input_pilih->prompt();
    /** End Select return */

    if($pilih>30 OR $pilih<1) $type = "wahyuarifpurnomo";
}
if($pilih==1){
    $type = "tools/accountchecker/accountchecker";
    $namatools = "\e[1;32mCheck all accounts\e[0m";
}elseif($pilih==2){
    $type = "tools/emailchecker/emailchecker";
    $namatools = "\e[1;32mCheck account email\e[0m";
}elseif($pilih==3){
    $type = "tools/createaccount/createaccount";
    $namatools = "\e[1;32mCreate an account\e[0m";
}elseif($pilih==4){
    $type = "tools/mass-createaccount/mass-createaccount";
    $namatools = "\e[1;32mCreate an account [mass]\e[0m";
}elseif($pilih==5){
    $type = "tools/maintenance/maintenance";
    $namatools = "\e[1;32mMusic or Playlist Downloader\e[0m";
}
if($type=="wahyuarifpurnomo"){
    $climate->br()->error("You don't choose anywhere tools.");
}else{
    $climate->br()->info('You have selected tools ' . $namatools);
    $climate->br()->info('load the tool you requested');
    $climate->br();
    progress($progress);

    require_once($type.".php");
}

/**
 * Author : Wahyu Arif Purnomo
 * Update : 5 September 2019
 * Please don't edit, respect me, if you want to be appreciated.
 */