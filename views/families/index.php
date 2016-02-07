<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Семьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать семью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'header' => 'Родители',
                'format' => 'raw',
                'content' => function($model) {
                    $res = [];
                    foreach($model->spouses as $s ) {
                        $res[] = Html::a($s->toString(), ['humans/view', 'id' => $s->id]);
                    }
                    return implode('<br/>', $res);
                }
            ],
            [
                'header' => 'Дети',
                'format' => 'raw',
                'content' => function($model) {
                    $res = [];
                    foreach($model->children as $c ) {
                        $res[] = Html::a($c->toString(), ['humans/view', 'id' => $c->id]);
                    }
                    return implode('<br/>', $res);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
