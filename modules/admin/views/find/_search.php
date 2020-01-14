<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FindDronsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="find-drons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_surname') ?>

    <?= $form->field($model, 'thirdname') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'drone_id') ?>

    <?php // echo $form->field($model, 'drone_reg_number') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'x_coords') ?>

    <?php // echo $form->field($model, 'y_coords') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
