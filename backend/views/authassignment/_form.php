<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use backend\models\AuthItem;
use backend\models\User;

/** @var yii\web\View $this */
/** @var backend\models\AuthAssignment $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'item_name')->dropdownList(
        ArrayHelper::map(AuthItem::find()->all(), 'name', 'description'), ['prompt' => 'Kate'])?>

    <?=$form->field($model, 'user_id')->dropdownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt' => 'Kate'])?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
