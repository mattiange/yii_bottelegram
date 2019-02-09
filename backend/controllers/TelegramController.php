<?php
/**
 * BOT Telegram
 * -------------------------------------------
 * @author  Mattia Leonardo Angelillo
 * @email   mattia.angelillo@gmail.com
 * @version 0.1.0
 */
namespace backend\controllers;;

use Yii;
use yii\web\Controller;
use backend\models\News;
use backend\models\NewsSearch;
use backend\models\Followers;

class TelegramController extends Controller{
    /**
     * Telegram URL
     * 
     * @var string
     */
    protected $t_url = "https://api.telegram.org/bot";
    
    /**
     * Telegram bot's Token
     * 
     * @var string
     */
    private $token='306960917:AAHT1LUvB2fDyWtdtc6iCXZKXGMc_-jFyY0';
    
    /**
     * Telegram bot's name
     * 
     * @var string
     */
    protected $name='@teatralmentegioiabot';
    
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
            'parse_mode' => 'html',
            'reply_to_message_id' => $reply,
            'reply_markup' => $keyboard
        ));
    }
    
    /**
     * Create request
     * 
     * @param type $method
     * @param type $data
     * @return int
     * @throws TelegramException
     */
    protected function makeRequest($method, $data){
        $url = $this->t_url.$this->token.'/'.$method.'?';
        $url .= http_build_query($data);
        
        //Send message
        try{
            file_get_contents($url);
        } catch (\yii\base\ErrorException $ex) {
        }
        
        return true;
    }
    
    /**
     * Show index page
     * 
     * DA CANCELLARE
     * 
     * @return mixed
     */
    public function actionIndex(){
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Send message to all user
     * 
     * @return mixed
     */
    public function actionSendall()
    {
        $news = News::find()->all();
        $users = Followers::find()->all();
        $cont = 0;
        $text = [];
        
        foreach ($users as $user){
            
            foreach ($news as $v_news){
                if($v_news->data_evento>=date("Y-m-d") || $v_news->data_evento==NULL){
                    $text[$user->utente][$cont] = "<strong>".$v_news->titolo."</strong>\n";
                    if($v_news->data_evento!=NULL){
                        $text[$user->utente][$cont] .= "<strong>Data: </strong>".$v_news->data_evento."\n";
                    }else{
                        $text[$user->utente][$cont] .= "<i>Prossimamente</i>\n";
                    }
                    if($v_news->luogo_evento!=NULL){
                        $text[$user->utente][$cont] .= "<strong>Luogo: </strong>".$v_news->luogo_evento."\n";
                    }
                    $text[$user->utente][$cont] .= $v_news->link."\n";
                }
                
                $cont ++;
            }
        }
        
            /*echo "<br /><br /><br />";
            echo "<pre>";
            print_r($text);
            echo "</pre>";*/
            
        if(count($text)>0){
            foreach ($text as $chat_id => $v){
                foreach($v as $k => $v_1){                
                    $this->sendMessage($chat_id, $v_1);
                }
            }
        }
        
        return $this->render('sendall', [
            'news' => $news,
        ]);
    }
}