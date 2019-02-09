<?php
/**
 * BOT TELEGRAM
 * -------------------------------------------------
 * @package Teatralmente Gioia BOT
 * @version 1.0.0 beta
 * @token   306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0
 * @author  Mattia Leonardo Angelillo
 * @email   mattiangemon@gmail.com
 */

include_once './load.php';

use app\Bot\TelegramBot;
use app\Bot\DB\MysqliDb;

//Togen BOT
$token = "306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0";
$name = '@TeatralmenteGioiaBot';
$name_id = '52697838';
//$name_id = "306960917";//ID BOT

$telegram = new TelegramBot($token, $name);
$mysqli = new MysqliDb($pdo);

$updates = json_decode(file_get_contents('php://input'), TRUE);
$text = $updates["message"]["text"];
$chat_id = $updates["message"]["chat"]["id"];

$up = json_decode(file_get_contents(
        'https://api.telegram.org/bot306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0/getUpdates',
        TRUE)
);

$chatid = array();
foreach ($up->result as $key => $value){
    foreach ($value as $k => $v){
        $chatid[] = $value->message->chat->id;
    }
}
$chatid = array_unique($chatid);

if(isset($_GET['command'])){
    $text = $_GET['command'];
}

//Execute commands
switch ($text){
    case '/start'://Start application
    case '/news'://User request
    case 'sendall'://Admin send newsletter
        $news = $mysqli->get('news');
        
        $contMessaggio = 0;
        foreach ($chatid as $k_ChatID => $v_ChatID){
            foreach ($news as $k_news => $v_news){
                $messaggio[$contMessaggio]['chat_id'] = $v_ChatID;
                $messaggio[$contMessaggio]['messaggio'] = urlencode("<strong>".$v_news['titolo']."</strong>\n");
                if($v_news['data_evento'] != NULL){
                    $messaggio[$contMessaggio]['messaggio'] = urlencode("<strong>Data: </strong>"
                                                                        . $v_news['data_evento']."\n");
                }
                if($v_news['luogo_evento'] != NULL && $v_news['luogo_evento'] != ""){
                    $messaggio[$contMessaggio]['messaggio'] = urlencode("<strong>Luogo: </strong>"
                                                                        . $v_news['luogo_evento']."\n");
                }
                $messaggio[$contMessaggio]['messaggio'] .= urlencode($v_news['link']."\n");
                $messaggio[$contMessaggio]['photo'] = urlencode($v_news['immagine']);
                
                
                $contMessaggio ++;
            }
        }
        
        foreach ($messaggio as $k_M => $v_M){
            $mex = $v_M['messaggio'];
            if($v_M['photo'] != ""){
                $url = 'https://api.telegram.org/bot306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0/sendPhoto?chat_id='
                    . $v_M['chat_id']
                    . '&photo='
                    . $v_M['photo']
                    . '&disable_web_page_preview=1'
                    . '&parse_mode=html';
                
                file_get_contents($url);
            }
            $url = 'https://api.telegram.org/bot306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0/sendMessage?chat_id='
                . $v_M['chat_id']
                . '&text='
                . $mex
                . '&disable_web_page_preview=1'
                . '&parse_mode=html';
            
            file_get_contents(
                $url
            );
        }
        
        break;
}
?>
<html>
    <head>
        <title>Teatralmente Gioia BOT</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <style type="text/css">
            .image-cover img{
                width: 1280px;
                height: 400px;
            }
        </style>
    </head>
    
    <body>
        <?php include_once './menu.php' ?>
        
        <?php if(isset($_GET['command']) && $_GET['command'] == 'sendall'):?>
        <div class="alert alert-success">Record salvato e messaggio inviato a tutti gli utent.</div>
        <?php endif; ?>
        
        <div  class="image-cover">
            <img src="images/copertina_BOT.jpg" />
        </div>
    </body>
</html>