<?php
/**
 * @var $this yii\web\View;
 * @var $model app\models\Human
 */

use yii\helpers\Html;

$this->title = 'Генеалогическое древо: '. $model->toString();
$this->params['breadcrumbs'][] = ['label' => 'Люди', 'url' => ['/humans/index']];
$this->params['breadcrumbs'][] = ['label' => $model->toString(), 'url' => ['/humans/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

$currentGen = 0;
/** @var app\models\Human[] $genealogy */
$genealogy = $model->genealogy;

$count = count($genealogy);
?>

<div class="genealogy-tree">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
        <?php for( $i = 0; $i < $count; $i += 2 ) : ?>
            <?php
            $first = $genealogy[$i];
            $second = $genealogy[$i+1];
            $gen = min($first->generation, $second->generation);
            ?>
            <?php if ( $gen !== $currentGen ) : ?>
                <?php $currentGen = $gen; ?>
                </div><div class="row">
                <div class="col-md-1" style="margin-left: <?= (25 * $currentGen) .'px' ?>;">&nbsp;</div>
            <?php endif; ?>
            <div class="col-md-2 genealogy-family-block">
                <?= Html::encode($first->toString()) ?>
                <br/>
                <?= Html::encode($second->toString()) ?>
            </div>
        <?php endfor; ?>

        </div>
        <div class="row">
            <div class="col-md-1" style="margin-left: <?= (25 * $currentGen) ?>px;">&nbsp;</div>
            <div class="col-md-2 genealogy-family-block genealogy-person">
                <?= Html::encode($model->toString()) ?>
            </div>
        </div>
    </div>
</div>
