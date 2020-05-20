<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReplenishmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Replenishments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="replenishment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Replenishment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'filter' =>
                DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'createTimeRange',
                    'convertFormat' => true,
                    'startAttribute' => 'createTimeStart',
                    'endAttribute' => 'createTimeEnd',
                    'pluginOptions' => [
                        'timePicker' => true,
                        'timePickerIncrement' => 15,
                        'showDropdowns' => true,
                        'timePicker24Hour' => true,
                        'locale' => [
                            'format' => $searchModel::TIME_FORMAT,
                        ]
                    ]
                ])
            ],
            [
                'attribute' => 'user_id',
                'value' => 'user.name'
            ],
            // 'user.id',
            'amount',

            [
                'header' => 'Action',
                'content' => function ($model) {
                    return  Html::a('Cancel', ['delete'], ['class' => 'btn btn-danger']);
                }
            ],
        ],
    ]); ?>


</div>