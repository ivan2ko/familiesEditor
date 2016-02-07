<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Human */

$this->title = 'Создать человека';
$this->params['breadcrumbs'][] = ['label' => 'Люди', 'url' => ['humans']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="human-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'create' => true
    ]) ?>

</div>
