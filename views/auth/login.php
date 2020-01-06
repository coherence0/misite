<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DronsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php
    Modal::begin([
        'title'=>'<h4>Авторизация</h4>',
        'id' => 'modal',
        'size' => 'modal-lg'
    ]);

    echo "<div id = 'modalContent'></div>";
?>
<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
<?php
    Modal::end();  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#modal').modal('show') 
    });
</script>