<?php
/**
 * BOT Telegram
 * -------------------------------------------
 * @author  Mattia Leonardo Angelillo
 * @email   mattia.angelillo@gmail.com
 * @version 0.1.0
 */
namespace app\Bot;

use app\Bot\Exception\TelegramException;

class TelegramBot{
    /**
     *
     * @var string
     */
    protected $t_url = "https://api.telegram.org/bot";
    
    /**
     *
     * @var string
     */
    private $token;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     * 
     * @param string $token BOT's token
     * @param string $name  BOT's name
     */
    public function __construct($token, $name) {
        $this->token = $token;
        $this->name  = $name;
    }
    
    /**
     * Create array of text message to send
     * 
     * @param string $chat     Chat ID
     * @param string $content  Content
     * @param string $reply    Reply message
     * @param string $keyboard Keyboard type
     * 
     * @return boolean
     */
    public function sendMessage($chat, $content, $reply = null, $keyboard = null){
        return $this->makeRequest('sendMessage', array(
            'chat_id' => $chat,
            'text' => $content,
            'disable_web_page_preview' => 1,
            //'parse_mode' => 'html',
            'parse_mode' => 'markdown',
            'reply_to_message_id' => $reply,
            'reply_markup' => $keyboard
        ));
    }
    
    /**
     * 
     * 
     * @param string $chat
     * @param string $content
     * @param string $reply
     * @param string $keyboard
     * 
     * @return boolean
     */
    public function sendPhoto($chat, $content, $reply = null, $keyboard = null){
        return $this->makeRequest('sendPhoto', array(
            'chat_id' => $chat,
            'photo' => $content,
            'reply_to_message_id' => $reply,
            'reply_markup' => $keyboard
        ));
    }


    /**
     * 
     * @param type $website
     * 
     * @return type
     */
    public function setWebhook($website = ''){
        return $this->makeRequest('setWebhook', array(
            'url' => $website
        ));
    }
    /**
     * 
     * @param type $website
     * 
     * @return type
     */
    public function unsetWebhook(){
        return $this->makeRequest('setWebhook', array(
            'url' => ''
        ));
    }
    
    /**
     * 
     * @return boolean
     */
    public function getUpdates(){
        return $this->makeRequest('getUpdates', array());
    }
    
    /**
     * 
     * @param type $method
     * @param type $data
     * @return int
     * @throws TelegramException
     */
    protected function makeRequest($method, $data){
        $url = $this->t_url.$this->token.'/'.$method.'?';
        $url .= http_build_query($data);
        
        if(file_get_contents($url) == FALSE){
            throw new TelegramException('Error to send message');
        }
        
        return true;
    }
}
