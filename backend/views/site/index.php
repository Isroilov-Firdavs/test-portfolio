<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Opsiyalar</th>
                                <th>Qo'shish</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Kategoriya</td>
                                <td><a href="<?=Url::to(['/category'])?>" class="btn btn-success">+</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Viloyatlar</td>
                                <td><a href="<?=Url::to(['/country'])?>" class="btn btn-warning">+</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Rol</td>
                                <td><a href="<?=Url::to(['/authassignment'])?>" class="btn btn-danger">+</a></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
