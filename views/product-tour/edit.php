<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dosamigos\selectize\SelectizeTextInput;

$this->title = 'Edit Product tour';
$this->params['breadcrumbs'][] = ['label' => 'Product tours','url' => ['/product-tour'],];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
        <div class="row">
            <div class="col-lg-4">
            <div class="box">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'modal-edit-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <b>Visible for users:</b>
                            
                    <?=$form->field($model, 'show')->checkbox()->label('');?>
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy(['order' => 'ASC'])->all(), 'id', 'name'), ['prompt'=>'']) ?>
                    <?= $form->field($model, 'tagValues')->widget(SelectizeTextInput::className(), [
                        // calls an action that returns a JSON object with matched
                        // tags
                        'loadUrl' => ['tag/list'],
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'plugins' => ['remove_button'],
                            'valueField' => 'name',
                            'labelField' => 'name',
                            'searchField' => ['name'],
                            'create' => true,
                        ],
                    ])->hint('Use commas to separate tags')->label('Tags') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/product-tour'], ['class'=>'btn btn-danger']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
            </div>
            </div>
            
            <div class="col-md-8">
          

          <div class="box">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Product tour steps</h3>
            </div>
            <!-- /.box-header -->
            <?php if (!empty($product_tour_steps)) {?>
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Step name</th>
                  <th>Event</th>
                  <th>Actions</th>
                </tr>
                  <?php foreach ($product_tour_steps as $key => $product_tour_step):?>
                    <tr>
                      <td><?=$key+1?></td>
                      <td><?=$product_tour_step->name?></td>
                      <td>
                        <?=$product_tour_step->action?>
                      </td>
                      <td>
                        <a href="<?=Url::toRoute(['product-tour-step/edit', 'id' => $product_tour_step->id]);?>"><button type="button" class="btn  btn-success btn-xs">Edit</button>
                        <a href="<?=Url::toRoute(['product-tour-step/delete', 'id' => $product_tour_step->id]);?>"><button type="button" class="btn  btn-danger btn-xs">Delete</button>
                      </a>
                      </td>
                    </tr>
                  <?php endforeach;?>
              </tbody></table>
            </div>
            <?php } else {?>
                  <div class="box-footer clearfix">
                  <h5 class="box-title">Create at leas one step. Link to instructions.</h3>
            </div>
            <?php } ?>
            <!-- /.box-body -->
          </div>
          
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        </div>
</div>