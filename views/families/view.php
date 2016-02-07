<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\family */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Семьи', 'url' => ['/families/index']];
$this->params['breadcrumbs'][] = $this->title;

$spouses = [];
$children = [];
foreach( $model->spouses as $spouse ) {
    $spouses[] = Html::a($spouse->toString(), ['humans/view', 'id' => $spouse->id]) ;
}

foreach( $model->children as $child ) {
    $children[] = Html::a($child->toString(), ['humans/view', 'id' => $child->id]);
}
?>
<div class="human-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить ребенка', ['humans/create', 'idFamily' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Супруги',
                'value' => implode('<br/>', $spouses),
                'format' => 'raw'
            ],
            [
                'label' => 'Дети',
                'value' => implode('<br/>', $children),
                'format' => 'raw'
            ]
        ],
    ]) ?>


</div>
