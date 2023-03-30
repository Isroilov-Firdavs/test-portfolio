<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use frontend\models\Category;
use frontend\models\Country;


/** @var yii\web\View $this */
/** @var frontend\models\Posters $model */
/** @var ActiveForm $form */
?>
<div class="site-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
        <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'price') ?>
        </div>
        <div class="col-lg-6">
            <?=$form->field($model, 'category')->dropdownList(
                Category::find()
                    ->select(['category_name', 'id'])
                    ->indexBy('id')
                    ->column(),
                ['prompt'=>'Kategoriyani tanlang']
            )?>
        </div>
        <div class="col-lg-6">
            <?=$form->field($model, 'address')->dropdownList(
                Country::find()
                    ->select(['c_name', 'id'])
                    ->indexBy('id')
                    ->column(),
                ['prompt'=>'Hudidni tanglang']
            )?>
        </div>
    </div>


        <?= $form->field($model, 'description')->textarea(['rows' => '10']) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-form -->
