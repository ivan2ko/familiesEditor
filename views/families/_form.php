<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Human;

/* @var $this yii\web\View */
/* @var $model app\models\FamilyForm */
/* @var $form yii\widgets\ActiveForm */

$unmarried = Human::getUnmarriedDropDown();
?>

<div class="family-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => false
    ]); ?>

    <?= $form->field($model, 'firstSpouseId')->dropDownList($unmarried) ?>

    <?= $form->field($model, 'secondSpouseId')->dropDownList($unmarried) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
