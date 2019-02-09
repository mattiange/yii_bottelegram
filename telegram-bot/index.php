<?php
/**
 * BOT TELEGRAM
 * 
 * Gestione dei comandi di Teatralmentegioiabot
 * ----------------------------------------------------------------------------
 * @package Teatralmente Gioia BOT
 * @version 1.0.0 beta
 * @token   306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0
 * @author  Mattia Leonardo Angelillo
 * @email   mattia.angelillo@gmail.com
 */
include_once './load.php';

//Includo gli oggetti
use app\Bot\TelegramBot;
use app\Bot\DB\MysqliDb;
use app\Bot\JsonConverter;
//-----------------------------------------------------------------

//Istanzio gli oggetti
$telegram = new TelegramBot($bot['token'], $bot['name']);
$command  = new \app\Bot\TelegramCommand($telegram);
$json_converter = new JsonConverter();
$mysqli = new MysqliDb($pdo);
//-----------------------------------------------------------------

$updates = $json_converter->toObject(file_get_contents('php://input'));
$text = $updates['message']['text'];
$chat_id = $updates['message']['chat']['id'];
$privacy = 'public';

$news = $mysqli->get('news');
$cont = 0;
foreach ($news as $k_news => $v_news){
    if(($v_news['data_evento']>date('Y-m-d')) ||$v_news['data_evento']==NULL){
        if($v_news['immagine'] != NULL){
            //$content[$cont] = "[logo]: {$v_news['immagine']} \n";
        }
        $content[$cont] .= "__".$v_news['titolo']."__\n";
        if($v_news['data_evento'] != NULL){
            $content[$cont] .= "Data: ".$v_news['data_evento']."\n";
        }else{
            $content[$cont] .= "Prossimamente\n";
        }
        if($v_news['luogo_evento'] != NULL){
            $content[$cont] .= "Luogo: ".$v_news['luogo_evento']."\n";
        }
        $content[$cont] .= $v_news['link']."\n";
        
        $cont ++;
    }
}
            
if($chat_id != ""){
    switch ($text){
        //Comando di aiuto
        case '/help':
            $content = "Ciao! Io sono teatralmentegioiabot\n\n"
                        . "Il mio compito è quello di inviarti tutte le nostre news.\n\n"
                        . "I comandi disponibili sono:\n\n"
                        . "/start - Iscriviti alle news di Teatralmente Gioia\n"
                        . "/start - Sospendi la ricezione delle news di Teatralmente Gioia\n"
                        . "/news - Vedi le ultime novità di Teatralmente Gioia\n"
                        . "/help - Visualizza la guida dei comandi\n\n\n"
                        . "Perfavore vota il nostro bot e condividilo con tutti i tuoi amici e i gruppi. "
                        . "https://telegram.me/storebot?start=teatralmentegioiabot";
            
            $command->getCommand('/news', $chat_id, $content, $privacy);
            
            break;
        //Avvia bot
        case '/start':
            $mysqli->where("utente", $chat_id);
            $users = $mysqli->getOne("followers");
            
            if(count($users)==0){
                $mysqli->insert('followers', array(
                    'utente' => $chat_id
                ));

                $content = "Ciao!\n\nTi ringraziamo per esserti iscritto alle nostre newsletter!\n\n
Non perderti nulla seguici su:\n
• Facebook\n
• Twitter (@teatralgioia)\n
• Instagram (@teatralmentegioia)\n
• Google+\n
• YouTube\n
• Sul nostro sito: http://bit.ly/teatralmentegioia\n\n
A presto!";
            }else{
                $content = "Sei già iscritto alla nostra newsletter!";
            }
            
            $command->getCommand($text, $chat_id, $content, $privacy);
            
            break;
        //Visualizza le news
        case '/news':
            $mysqli->where("utente", $chat_id);
            $users = $mysqli->getOne("followers");
            
            if(count($users)>0){
                for ($i=0;$i<count($content);$i ++){
                    $command->getCommand($text, $chat_id, $content[$i], $privacy);
                }
            }else{
                $content = "Non sei iscritto alle nostre newsletter, iscriviti ora per non perdere nessuna delle nostre iniziative!";
                
                $command->getCommand($text, $chat_id, $content, $privacy);
            }
            
            break;
        //Ferma il bot
        case '/stop':
            $mysqli->where("utente", $chat_id);
            $users = $mysqli->getOne("followers");
            
            if(count($users)>0){
                $mysqli->where('utente', $chat_id);
                $mysqli->delete('followers');

                $content = "Non sei più iscritto alle nostre newsletter :'(\n\n\nSperiamo di riaverti presto con noi!";
            }else{
                $content = "Non sei iscritto alle nostre newsletter, iscriviti ora per non perdere nessuna delle nostre iniziative!";
            }
            
            $command->getCommand($text, $chat_id, $content, $privacy);
            
            
            break;
    }
}