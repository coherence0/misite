<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drons */

$this->title = 'Create Drons';
$this->params['breadcrumbs'][] = ['label' => 'Drons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drons-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
