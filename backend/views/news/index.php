<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus fa-ico-action fa-green"></span>', ['create', 'id' => $model->id], ['class' => '', 'title' => 'Nuova voce']) ?>
        <?= Html::a('<i class="fab fa-telegram-plane fa-ico-action"></i>', ['site/send'], ['class' => '', 'title'=>Yii::t('app', 'Invia tutte le news')]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'titolo',
            'data_evento',
            //'link',
            //'immagine',
            //'luogo_evento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
$this->registerCssFile('https://use.fontawesome.com/releases/v5.5.0/css/all.css', 
    [
        'depends' => [yii\bootstrap\BootstrapAsset::className()]
    ]);