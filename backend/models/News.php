<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $titolo
 * @property string $data_evento
 * @property string $link
 * @property string $immagine
 * @property string $luogo_evento
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titolo', 'link'], 'required'],
            [['data_evento'], 'safe'],
            [['titolo', 'link', 'immagine', 'luogo_evento'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'titolo' => Yii::t('app', 'Titolo'),
            'data_evento' => Yii::t('app', 'Data Evento'),
            'link' => Yii::t('app', 'Link'),
            'immagine' => Yii::t('app', 'Immagine'),
            'luogo_evento' => Yii::t('app', 'Luogo Evento'),
        ];
    }
}
