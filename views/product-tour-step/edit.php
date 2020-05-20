<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Product tour';
$this->params['breadcrumbs'][] = ['label' => 'Product tour edit','url' => ['product-tour/edit', 'id' => $model->product_tour_id],];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
        <div class="row">
            <div class="col-lg-7">
            <div class="box">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'modal-edit-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'action')->dropDownList(['click' => 'click','next' => 'next'], ['prompt'=>'']) ?>
                    <?= $form->field($model, 'element')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'position')->dropDownList(['top' => 'top','bottom' => 'bottom'], ['prompt'=>'']) ?>
                    <?= $form->field($model, 'path')->textInput(['autofocus' => true]) ?>
                    
                    <?= $form->field($model, 'content')->textArea() ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/product-tour/edit?id=' . $model->product_tour_id], ['class'=>'btn btn-danger']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
            </div>
            </div>
          
        </div>
</div>