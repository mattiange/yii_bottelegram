<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <button type="submit" style="background: transparent;border: 0;" title="Salva"><i class="far fa-save fa-ico-action"></i></button>
        <?= Html::a('<i class="fas fa-window-close fa-ico-action fa-red"></i>', ['news/index'], ['title' => 'Esci senza salvare']) ?>
    </div>
    
    <?= $form->field($model, 'titolo')->textInput([
            'maxlength' => true,
            'class' => 'form-control ico ico-title32x32 ico-27x27',
        ]) ?>

    <?= $form->field($model, 'data_evento')->widget(\yii\jui\DatePicker::class, [
        'language' => 'it',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control ico ico-calendar32x32 ico-27x27',
            'autocomplete' => 'off',
        ]
    ]) ?>

    <?= $form->field($model, 'link')->textInput([
            'maxlength' => true,
            'class' => 'form-control ico ico-link32x32 ico-27x27',
        ]) ?>

    <?= $form->field($model, 'immagine')->textInput([
            'maxlength' => true,
            'class' => 'form-control ico ico-picture32x32 ico-27x27',
        ]) ?>

    <?= $form->field($model, 'luogo_evento')->textInput([
            'maxlength' => true,
            'class' => 'form-control ico ico-placeholder32x32 ico-27x27',
        ]) ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerCssFile('https://use.fontawesome.com/releases/v5.5.0/css/all.css', 
    [
        'depends' => [yii\bootstrap\BootstrapAsset::className()]
    ]);