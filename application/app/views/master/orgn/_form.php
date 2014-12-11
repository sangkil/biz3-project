<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\master\Orgn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning orgn-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'code')->textInput(['maxlength' => 4]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
