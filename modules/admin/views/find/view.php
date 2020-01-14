<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FindDrons */

$this->title = $model->name_surname;
$this->params['breadcrumbs'][] = ['label' => 'Find Drons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="find-drons-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'id',
                'value'=>$model['id'],
            ],
            //'name',
            [
                'attribute' => 'name_surname',
                'value'=>$model['name_surname'],
                'label'=>'Имя и Фамилия' 
            ],
            //'thirdname',
            
            [
                'attribute' => 'thirdname',
                'value'=>$model['thirdname'],
                'label'=>'Отчество'
            ],
            //'email:email',
            [
                'attribute' => 'email',
                'value'=>$model['email'],
                'label'=>'Email'
            ],

            [
                //'attribute' => 'email',
                'value'=>$model['phones']['phone'],
                'label'=>'Телефон'
            ],
            //'drone_id',
            [
                //'attribute' => 'drone_id',
                'value'=>$model['drons']['model'],
                'label'=>'Модель дрона'
            ],
            //'drone_reg_number',
            [
                'attribute' => 'drone_reg_number',
                'value'=>$model['drone_reg_number'],
                'label'=>'Регистарционный номер дрона'
            ],

            [
                'attribute' => 'drone_serial_number',
                'value'=>$model['drone_serial_number'],
                'label'=>'Серийный номер дрона'
            ],
            //'date',
            [
                'attribute' => 'date',
                'value'=>$model['date'],
                'label'=>'Дата потери'
            ],
            // 'x_coords',
            // 'y_coords',
            //'created_at',
        ],
    ]) ?>

</div>
