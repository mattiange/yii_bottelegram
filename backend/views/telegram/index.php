<?php
$this->title = "Newsletter";
?>
<p class="alert alert-info">Vuoi inviare la newsletter?</p>
<a class="btn btn-success" href="<?= \yii\helpers\Url::to(['telegram/sendall']) ?>">S&igrave;</a>
<a class="btn btn-danger" href="<?= \yii\helpers\Url::to(['site/index']) ?>">NO</a>