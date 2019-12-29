<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DronsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drons-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Drons', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin((['enablePushState'=>false,
                        'timeout' => 3000,
                        ])); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'model',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete}',
             'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<i class="fa fa-bath" aria-hidden="true"></i>', $url, [
                    'title' => 'View',
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => 'Update',
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => 'Delete',
                    'data' => [
                        'method' => 'post',
                        'confirm' =>'Are you sure you want to delete this item?',
                    ]
                ]);
            },
        ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
