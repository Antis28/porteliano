<?php
/**
 * Created by PhpStorm.
 * User: Antis
 * Date: 05.12.2016
 * Time: 09:05
 */
/* @var $this yii\web\View */
/* @var $model app\models\Product *//*Временно*/

/*  models  */

/*  widgets  */
use yii\helpers\Html;

use yii\bootstrap\ActiveForm;
use yii\jui\Spinner;

/*  assets  */
use app\assets\BasketAsset;
use app\assets\BackAsset;

BasketAsset::register($this);
BackAsset::register($this);

Yii::setAlias('@img', '@web/img/');
?>
<div class="wrap-basket">
    <!-- заголовок -->
    <div class="row">
        <div class="col-md-2 col-md-offset-3 ">
            <h1 class="basket-header">Ваша корзина</h1>
        </div>
        <div class="col-md-2 col-md-offset-2 ">
            <h4 id="goods-name">Наименование</h4>
            <h4 id="count-goods">Количество</h4>
        </div>
    </div>
    <!-- товары -->
    <div id="tab-cart">
        <? if ($cart->getQuantity() === 0): ?>

            <H2>Корзина пуста!</H2>


        <?php else: ?>

            <?php $form = ActiveForm::begin() ?>
            <?php foreach ($cart->get() as $id => $item): ?>
                <?php if (((int)($id) > 0) && $item['quantity'] > 0): ?>
                    <div class="row goods-row">

                        <?=
                        $form->field($modelOrder->newOrderContent[$id], '[' . $id . ']' . 'product_id')->label('')->
                        hiddenInput(
                            [
                                'value' => $item['product']->id,
                            ]
                        )
                        ?>
                        <!-- иконка -->
                        <div class="col-md-1 col-md-offset-3 basket-icon">
                            <?= Html::img($item['product']->image,
                                ['class' => 'door-icon', 'alt' => "door icon"]) ?>
                        </div>
                        <!-- описание-->
                        <div class="col-md-3 basket-describ">
            <span class="description">
             <?= $item['product']->title ?>
            </span>

                        </div>
                        <!-- счетик? пределать в Yii2 widget -->
                        <div class="col-md-1 button-area">

                            <?=

                             $form->field(
                                 $modelOrder->newOrderContent[$id],
                                 '[' . $id . ']' . 'quantity')
                                 ->widget(\yii\jui\Spinner::classname(), [
                                'clientOptions' =>
                                    ['step' => 1, 'min' => 1,],
                            ])
                            /*
                            Spinner::widget([
                                'model' => $modelOrder->
                                newOrderContent[$id],
                                'attribute' => '[' . $id . ']' . 'quantity',
                                'clientOptions' => ['step' => 1, 'min' => 1],
                            ]);
                            */
                            /*
                            $form->field($modelOrder->
                            newOrderContent[$id],'['.$id.']'.'quantity')
                                ->widget(\yii\jui\Spinner::classname(), [
                                    'clientOptions' => ['step' => 1],
                                ]);
                            */
                            /* ->label(false)
                             ->textInput([
                             'type' => 'number',
                             'min' => 1,
                             //'value' => $item['quantity'],
                         ])
                         /**/
                            ?>

                        </div>
                        <!-- удаление из корзины текущего товара-->
                        <div class="col-md-1 delete-area">
                            <a class="delete" href="#" onclick="delItem(event, 'cart', <?= $item['product']->id ?> )">Удалить</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <!-- разделитель -->
            <div class="row separator">
                <div class="col-md-6 col-md-offset-3 ">
                    <hr/>
                </div>
            </div>


            <!-- удаление из корзины всего товара-->
            <div class="row">
                <div class="col-md-1 col-md-offset-3 delete-all-area">
                    <a class="delete" href="#" onclick=clearCart("cart")>
                        Очистить корзину
                    </a>
                </div>


                <div class="col-md-1 col-md-offset-3 delete-all-area form-area">
                    <?= $form->field($modelOrder, 'customer')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelOrder, 'phone')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelOrder, 'email')->textInput(['type' => 'email']) ?>

                    <?= Html::submitButton('<span
                    class="btn btn-default send-button"
                    role="button" >ОТПРАВИТЬ ЗАЯВКУ</span>', ['class' => 'btn btn-default send-button']) ?>


                </div>

            </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>

<script>/*
     $( function() {
     $( "#currency" ).on( "change", function() {
     $( "#spinner" ).spinner( "option", "culture", $( this ).val() );
     });

     $( "#spinner" ).spinner({
     min: 1,
     max: 2500,
     step: 1,
     start: 1000,
     numberFormat: "C"
     });
     } );
</script>

