<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus fa-ico-action fa-green"></span>', ['create', 'id' => $model->id], ['class' => '', 'title' => 'Nuova voce']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil fa-ico-action"></span>', ['update', 'id' => $model->id], ['class' => '', 'title' => 'Aggiorna voce']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove fa-red fa-ico-action"></span>', ['delete', 'id' => $model->id], [
            'class' => '',
            'title' => 'Cancella voce',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titolo',
            'data_evento',
            'link',
            'immagine',
            'luogo_evento',
        ],
    ]) ?>

</div>

<?php
$this->registerCssFile('https://use.fontawesome.com/releases/v5.5.0/css/all.css', 
    [
        'depends' => [yii\bootstrap\BootstrapAsset::className()]
    ]);