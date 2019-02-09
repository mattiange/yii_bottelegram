<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bottelegram_user}}".
 *
 * @property string $id
 * @property string $utente
 */
class TelegramUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
