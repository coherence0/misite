<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FindDronsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Find Drons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="find-drons-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Find Drons', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'name_surname',
                'format' => 'text',
                'label' => 'Имя и Фамилия',
            ],

            'email:email',

            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'drone_reg_number',
                'format' => 'text',
                'label' => 'Регистрационный номер дрона',
            ],

            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'drone_serial_number',
                'format' => 'text',
                'label' => 'Серийный номер дрона',
            ],

            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'FindDrons',
                'value' => function($model){
                    return $model->drons->model;
                },
                'format' => 'text',
                'label' => 'Дрон',
            ],
            // [
            //     //'class' => DataColumn::className(), // Не обязательно
            //     'attribute' => 'drons.model',
            //     'format' => 'text',
            //     'label' => 'Дрон',
            // ],
            //'drone_id',
            //'date',
            //'x_coords',
            //'y_coords',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Действиe',
             'headerOptions' => ['width' => '30','align'=>'center'],
             'template' => '{delete} {view} {update}',
             'buttons' => [

            'update' => function ($url, $model) {
                return Html::a('<i class="fa fa-pen"></i>', $url, [
                    'title' => 'Update','id'=>'update'
                ]);
            },

            'view' => function ($url, $model) {
                return Html::a('<i class="fa fa-eye"></i>', $url, [
                    'title' => 'View','id'=>'view'
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>', $url, [
                    'title' => 'Delete',
                    'data' => [
                        'method' => 'post',
                        'confirm' =>'Вы действительно хотите удалить этот дрон?',
                    ]
                ]);
            },
        ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
