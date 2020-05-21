<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReplenishmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Replenishments report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="replenishment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'footer' => 'Total'],
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
            [
                'attribute' => 'amount',
                'footer' => $totalAmount,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{deleteRep} {leadUpdate}',
                'buttons' => [
                    'deleteRep' => function ($url, $model) {
                        $url = Url::to(['replenishments/delete', 'id' => $model->id]);
                        return Html::a(
                            'Cancel',
                            $url,
                            ['class' => 'btn btn-danger', 'data-method' => 'post'],
                        );
                    },
                ]
            ],

        ],
    ]); ?>

</div>