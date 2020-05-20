<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    
<div class="col-xs-6">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Product tour Clients (<a href="#" target="_blank">details</a>)</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <?php if (!empty($product_tour_clients)): ?>
        <table class="table table-bordered">
        <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Hostname</th>
            <th>Sub directory name</th>
            <th>Actions</th>
            
        </tr>
        
        <?php foreach ($product_tour_clients as $key => $product_tour_admin):?>
            <tr>
            <td><?=$key+1?></td>
            <td><?=$product_tour_admin->hostname?></td>
            <td><?=$product_tour_admin->sub_directory_name?></td>
            
            <td>
            <?php echo Html::a('Delete', ['product-tour-client/delete', 'id' => $product_tour_admin->id], [
                      'class' => 'btn btn-danger btn-xs',
                      'data' => [
                          'confirm' => 'Are you sure you want to delete this item?',
                          'method' => 'post',
                      ],
                  ]) ?>
               

            </td>
        </tr>
        <?php endforeach;?>
        
        </tbody></table>
    <?php endif; ?>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        
    </div>
    </div>


    </div>
    <div class="col-xs-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add new Client</h3>
        </div>
        
        <?php $form = ActiveForm::begin(['id' => 'product-tour-admin-form']); ?>
            <div class="box-body">
            <?= $form->field($model, 'hostname')->textInput()->label('Hostname') ?>
            <?= $form->field($model, 'sub_directory_name')->textInput()->label('Sub directory name') ?>
            
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            </div>
        <?php ActiveForm::end(); ?>
        
</div>
</div>
</div>