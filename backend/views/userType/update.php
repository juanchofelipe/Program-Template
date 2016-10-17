<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserType */

$this->title = 'Update User Type: ' . $model->int;
$this->params['breadcrumbs'][] = ['label' => 'User Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->int, 'url' => ['view', 'id' => $model->int]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
