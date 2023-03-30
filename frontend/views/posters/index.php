<?php

use frontend\models\Posters;
use yii\helpers\Html; 
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\PostersSerch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Posters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posters-index">
    <p>
        <?= Html::a('Create Posters', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'price',
            [
                'attribute' => 'category',
                'format' => 'raw',
                'value' => function($data)
                {
                    return $data->cate->category_name;
                }
            ],
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($data)
                {
                    return "<img src='../../../frontend/web/images/".$data->image."' width='50px'>";
                }
            ],
            [
                'attribute' => 'address',
                'format' => 'raw',
                'value' => function($data)
                {
                    return $data->addres->c_name;
                }
            ],
            //'poster_id',
            'date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Posters $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
