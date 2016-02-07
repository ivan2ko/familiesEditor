<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Human */

$fullName = $model->toString();
$this->title = 'Редактирование человека: ' . ' ' . $fullName;
$this->params['breadcrumbs'][] = ['label' => 'Humans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $fullName, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="human-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'create' => false
    ]) ?>

</div>
