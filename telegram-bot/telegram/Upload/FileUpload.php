<?php
/**
 * Upload File
 * 
 * N.B.: This version upload only image files
 * -------------------------------------------------
 * @package Teatralmente Gioia BOT
 * @version 1.0.0 beta
 * @date    24-09-2017
 * @author  Mattia Leonardo Angelillo
 * @email   mattiangemon@gmail.com
 */

namespace app\Bot\upload;

use Exception;

class FileUpload{
    /**
     * Directory to upload files
     * 
     * @var String
     */
    protected $_dirUpload = "";
    
    /**
     * File's info
     * 
     * @var array
     */
    protected $_file = array();
    
    
    
    /**
     * Constructor
     * 
     * @param type $dirUpload   File's upload directory
     * @param array $file       File info
     */
    public function __construct($dirUpload, $file) {
        $this->_dirUpload   = $dirUpload;
        $this->_file        = $file;
    }
    
    /**
     * Upload Image file
     * 
     * @return boolean
     * @throws Exception
     */
    public function uploadImage(){
        if($this->_imageSize() !== false){
            $error      = $this->_file['error'];
            $file_name  = $this->_file['image']['name'];
            $file_tmp   = $this->_file['image']['tmp_name'];
            
            if(empty($error)==true){
                return move_uploaded_file($file_tmp,  $this->_dirUpload.$file_name);
            }
            
            throw new Exception($this->_errors($error));
        }
    }
    
    /**
     * 
     * @return type
     */
    public function getFileLink(){
        return $this->_dirUpload.$this->_file['image']['name'];
    }

    /**
     * File's type
     * 
     * @return string   Type of file
     */
    protected function fileType(){
        return pathinfo($this->_dirUpload, PATHINFO_EXTENSION);
    }
    
    /**
     * Image's size
     * @return int
     */
    protected function _imageSize(){
        return getimagesize($this->_file['image']['tmp_name']);
    }
    
    /**
     * Errors of upload
     * 
     * @param int $error   Error
     * @return string
     */
    protected function _errors($error){
        switch($error) { 
            case 1 : 
                $output = "The uploaded file exceeds the upload_max_filesize directive in php.ini.<br />";
                
                break; 
            case 2 : 
                $output = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.<br />";
                
                break; 
            case 3 : 
                $output = "The uploaded file was only partially uploaded.<br />";
                
                break; 
            case 4 : 
                $output = "No file was uploaded.<br />";
                
                break; 
            case 6 : 
                $output = "Missing a temporary folder.<br />";
                
                break; 
            case 7 : 
                $output = "Failed to write file to disk.<br />";
                
                break; 
            case 8 : 
                $output = "File upload stopped by extension.<br />";
                
                break;
            default :
                $output = "";
                
                break;
            
        } 
        
        return $output; 
    }
}