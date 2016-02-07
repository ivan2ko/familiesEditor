<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FamilyForm */

$this->title = 'Создать семью';
$this->params['breadcrumbs'][] = ['label' => 'Семьи', 'url' => ['families']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
