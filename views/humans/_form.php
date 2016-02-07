<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Family;

/* @var $this yii\web\View */
/* @var $model app\models\Human */
/* @var $form yii\widgets\ActiveForm */
/* @var $create boolean */

$families = Family::getFamiliesDropDown();
?>

<div class="human-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_ancestry_family')->dropDownList($families,
        ['disabled' => !$create, 'prompt' => 'нет']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
