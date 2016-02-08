<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Human */

$this->title = $model->toString();
$this->params['breadcrumbs'][] = ['label' => 'Люди', 'url' => ['/humans/index']];
$this->params['breadcrumbs'][] = $this->title;

$parentsFamily = $model->ancestryFamily;
$hisFamily = $model->descendantFamily;
?>
<div class="human-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Генеалогическое древо', ['genealogy', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'surname',
            'ancestry',
            [
                'label' => 'Семья родителей',
                'value' => $parentsFamily ?
                    Html::a($parentsFamily->name, ['families/view', 'id' => $parentsFamily->id])
                    : null,
                'format' => 'raw'
            ],
            [
                'label' => 'Собственная семья',
                'value' => $hisFamily ?
                    Html::a($hisFamily->name, ['families/view', 'id' => $hisFamily->id])
                    : null,
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
