<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FindDrons */

$this->title = 'Update Find Drons: ' . $model->name_surname;
$this->params['breadcrumbs'][] = ['label' => 'Find Drons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_surname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="find-drons-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
