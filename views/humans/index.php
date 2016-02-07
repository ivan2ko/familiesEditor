<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HumanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Люди';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="human-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить человека', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'surname',
            'name',
            [
                'attribute' => 'id_ancestry_family',
                'format' => 'raw',
                'filter' => false,
                'value' => function($model) {
                    $family = $model->ancestryFamily;
                    return $family ? Html::a($family->name,
                        ['family/view', 'id' => $family->id])
                         : null;
                }
            ],
            [
                'attribute' => 'id_descendant_family',
                'format' => 'raw',
                'filter' => false,
                'value' => function($model) {
                    $family = $model->descendantFamily;
                    return $family ? Html::a($family->name,
                        ['family/view', 'id' => $family->id])
                        : null;
                }
            ],
            // 'ancestry',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}'
            ],
        ],
    ]); ?>

</div>
