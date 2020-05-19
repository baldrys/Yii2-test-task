<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\User */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
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
                    return $model->getStatusLabels()[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>