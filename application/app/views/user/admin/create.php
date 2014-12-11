<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 * modify view
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 */
$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8">
    <div class="alert alert-info">
        <?= Yii::t('user', 'Password and username will be sent to user by email') ?>.
        <?= Yii::t('user', 'If you want password to be generated automatically leave its field empty') ?>.
    </div>
    <?php echo $this->render('flash') ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
        <div class="box-header">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="box-body">

            <?= $form->field($model, 'username')->textInput(['maxlength' => 25, 'autofocus' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
