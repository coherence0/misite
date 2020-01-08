<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FindDrons */

$this->title = 'Create Find Drons';
$this->params['breadcrumbs'][] = ['label' => 'Find Drons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="find-drons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
