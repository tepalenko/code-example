<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    
<div class="col-xs-6">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Product tour Admins</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    <?php if (!empty($product_tour_admins)): ?>
        <table class="table table-bordered">
        <tbody><tr>
            <th style="width: 10px">#</th>
            <th>Checker Username</th>
            <th>Actions</th>
            
        </tr>
        
        <?php foreach ($product_tour_admins as $key => $product_tour_admin):?>
            <tr>
            <td><?=$key+1?></td>
            <td><?=$product_tour_admin->checker_username?></td>
            
            <td>
            <?php echo Html::a('Delete', ['product-tour-admin/delete', 'id' => $product_tour_admin->id], [
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
            <h3 class="box-title">Add new Admin</h3>
        </div>
        
        <?php $form = ActiveForm::begin(['id' => 'product-tour-admin-form']); ?>
            <div class="box-body">
            <?= $form->field($model, 'checker_username')->textInput()->label('') ?>
            
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            </div>
        <?php ActiveForm::end(); ?>
        
</div>
</div>
</div>