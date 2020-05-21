<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Replenishment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="replenishment-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'action' => ['/replenishments/create'],
        'enableAjaxValidation' => true,
        'id' => 'replenishment-form',
    ]); ?>


    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>