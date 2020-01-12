<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DronsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drons-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Create Drons', ['value'=>Url::to('/admin/drons/create'), 'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
    </p>

    <?php

        Modal::begin([
            'title'=>'<h4>Добавить дрон</h4>',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);

        echo "<div id = 'modalContent'></div>";

        Modal::end();
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){

            $('#modalButton').click(function(){
                $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            });
            
        });

    </script>


    <?php Pjax::begin((['enablePushState'=>false,
                        'timeout' => 3000,
                        ])); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterOnFocusOut'=>'false',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                //'class' => DataColumn::className(), // Не обязательно
                'attribute' => 'model',
                'format' => 'text',
                'label' => 'Модель дрона',
            ],

            ['class' => 'yii\grid\ActionColumn',
             'header'=>'Действиe',
             'headerOptions' => ['width' => '30','align'=>'center'],
             'template' => '{delete}',
             'buttons' => [
            // 'view' => function ($url, $model) {
            //     return Html::a('<i class="fa fa-eye"></i>', $url, [
            //         'title' => 'View','id'=>'view'
            //     ]);
            // },
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

<?php

        Modal::begin([
            'title'=>'<h4>Редактирование дрона</h4>',
            //'options'=>['class'=>'modal-dialog-centered'],
            'id' => 'editingDrone',
            'size' => 'modal-lg'
        ]);

        echo "<div id = 'modalContent'></div>";

        Modal::end();
?>


<script type="text/javascript">

        $('.grid-view tbody tr').on('click', function(){

            var data = $(this).data();
            var modalHtml = "";
            modalHtml = $("#editingDrone").html();
            $('#editingDrone').modal('show');
            $('#editingDrone').find('.modal-body').load('/admin/drons/update?id=' + data.key); 
            $('#editingDrone').on('hidden.bs.modal', function (e) {
            //$('#editingDrone').find("input,textarea,select").val('').end();
                $('#editingDrone').html(modalHtml); 
            });

        });

</script>
