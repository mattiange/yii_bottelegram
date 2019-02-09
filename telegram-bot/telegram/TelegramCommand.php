<?php
/**
 * Telegram Command
 * -------------------------------------------
 * @author  Mattia Leonardo Angelillo
 * @email   mattia.angelillo@gmail.com
 * @version 0.1.0
 */
namespace app\Bot;

use app\Bot\Exception\TelegramException;

class TelegramCommand {
    /**
     * 
     * @var array
     */
    protected $command = array(
        //User commands
        'public' => array(
            '/start',
            '/news',
            '/stop'
        ),
        //Admin commands
        'private' => array(
            '/sendall'
        ),
    );
    
    /**
     *
     * @var TelegramBot 
     */
    protected $telegram;
    
    /**
     * 
     * @param TelegramBot $telegram
     */
    public function __construct(TelegramBot $telegram) {
        $this->telegram = $telegram;
    }
    
    /**
     * 
     * @param string $command
     * @param string $chat
     * @param string $content
     * @param string $privacy
     * @throws TelegramException
     */
    public function getCommand($command='/start', $chat, $content=null, $privacy='public'){
        if($command==null){
            $command = '/start';
        }
        if($privacy==null || $privacy==""){
            $privacy = 'public';
        }
        
        //Exist command?
        foreach ($this->command[$privacy] as $v_Command){
            if($v_Command == $command){
                $this->_command($command, $chat, $content);
            }
        }
    }
    
    /**
     * 
     * @param string $chat
     * @param string $content
     * @return boolean
     */
    protected function _commandSendall($chat, $content){
        if(!is_array($chat)){
            throw new TelegramException('chat_is must be array for command <b>/sendall</b>');
        }
        
        foreach ($chat as $v_chat){
            $this->telegram->sendMessage($v_chat['utente'], $content);
        }
        
        return $this->telegram->sendMessage($chat, $content);
    }
    
    /**
     * 
     * @param type $chat
     * @param type $content
     * @return type
     */
    protected function _commandNews($chat, $content){
        if($content == null || empty($content)){
            throw new TelegramException("Content /news command is empty");
        }
        
        return $this->telegram->sendMessage($chat, $content);
    }
    
    /**
     * 
     * @param type $chat
     * @param type $content
     */
    protected function _commandHelp($chat, $content){
        $this->_commandNews($chat, $content);
    }

    /**
     * 
     * @param type $chat
     * @param type $content
     */
    protected function _commandStart($chat, $content){
        $this->_commandNews($chat, $content);
    }
    
    /**
     * 
     * @param type $chat
     * @param type $content
     */
    protected function _commandStop($chat, $content){
        $this->_commandNews($chat, $content);
    }

        /**
     * 
     * @param string $command
     * @param string $chat
     * @param string $content
     */
    private function _command($command, $chat, $content){
        $c = '_command'.ucfirst(str_replace('/', '', $command));
        
        $this->$c($chat, $content);
    }
}
