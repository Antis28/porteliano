<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrderContent */

$this->title = 'Create Order Content';
$this->params['breadcrumbs'][] = ['label' => 'Order Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
