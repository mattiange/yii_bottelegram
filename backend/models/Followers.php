<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "bottelegram_followers".
 *
 * @property int $id
 * @property string $utente chat_id
 */
class Followers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bottelegram_followers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['utente'], 'required'],
            [['utente'], 'string', 'max' => 255],
            [['utente'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'utente' => Yii::t('app', 'Utente'),
        ];
    }
}
