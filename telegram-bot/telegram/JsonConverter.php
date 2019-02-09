<?php
/**
 * Convert JSON data to ARRAY data
 * -------------------------------------------
 * @author  Mattia Leonardo Angelillo
 * @email   mattia.angelillo@gmail.com
 * @version 0.1.0
 */
namespace app\Bot;

use \Exception;

class JsonConverter{
    public function __construct() {
    }
    
    public function toObject($json){
        if(!$this->_jsonControl($json)){
            throw new Exception('Json file must be passed');
        }
        
        return json_decode($json, TRUE);
    }
    
    /**
     * Control if file is json type
     * 
     * @param json $json
     */
    private function _jsonControl($json){
        if(
            (is_string($json) && (is_object(json_decode($json))))
            ||
            is_array(json_decode($json))
            || empty($json)
        ){
            return true;
        }
        
        return false;
    }
}
