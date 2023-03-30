<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\Posters $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="posters-view">

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
            // 'id',
            'title',
            'price',
            // 'category',
            [
                'attribute' => 'category',
                'format' => 'raw',
                'value' => function($data)
                {
                    return $data->cate->category_name;
                }
            ],
            // 'image',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function($data)
                {
                    return "<img src='../../../frontend/web/images/".$data->image."' height='100px' width='100px'>";
                }
            ],
            'description:ntext',
            // 'user_id',
            // 'address',
            [
                'attribute' => 'address',
                'format' => 'raw',
                'value' => function($data)
                {
                    return $data->addres->c_name;
                }
            ],
            // 'poster_id',
            'date',
        ],
    ]) ?>

</div>
