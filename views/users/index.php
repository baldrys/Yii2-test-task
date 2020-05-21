<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use lo\widgets\Toggle;
use app\models\User;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\User */
/* @var $replenishmentModel app\models\Replenishment */

$js = <<< JS
    function sendRequest(status, id){
        $.ajax({
            url:'/users/status-update',
            method:'post',
            data:{status:Number(status), id:id},
            success:function(data){
                console.log(data);
            },
            error:function(jqXhr,status,error){
                console.log(error);
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);

$this->title = 'Users';
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    Modal::begin([
        'header' => '<h2>Register new user</h2>',
        'toggleButton' => [
            'label' => 'Add user',
            'class' => 'btn btn-success',
        ],

    ]); ?>


    <div class="user-create">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>



    <?php Modal::end(); ?>



    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'phone_number',
            'name',
            'balance',


            [
                'attribute' => 'status',
                'content' => function ($model) {
                    return Toggle::widget(
                        [
                            'name' => 'status', // input name. Either 'name', or 'model' and 'attribute' properties must be specified.
                            'checked' => $model->status,
                            'options' => [
                                'data-on' =>  $model->getStatusLabels()[User::STATUS_ACTIVE],
                                'data-off' =>  $model->getStatusLabels()[User::STATUS_BANNED]
                            ], // checkbox options. More data html options [see here](http://www.bootstraptoggle.com)
                            'clientEvents' => [
                                "change" => "function(e){ sendRequest(e.currentTarget.checked, $model->id); }",
                            ]
                        ]
                    );
                }

            ],
        ],
    ]); ?>

    <?php
    Modal::begin([
        'header' => '<h2>Add balance to the user</h2>',
        'toggleButton' => [
            'label' => 'Add balance',
            'class' => 'btn btn-success',
        ],

    ]); ?>


    <div class="replenishment-create">

        <?= $this->render('../replenishments/_form', [
            'model' => $replenishmentModel,
        ]) ?>

    </div>



    <?php Modal::end(); ?>

</div>