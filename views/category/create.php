<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


$this->title = 'Add Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>Alert!</h4>
                <?php foreach ($model->errors as $field_name => $errors):?>
                    Field: "<?=$field_name?>"<br/>
                    Errors:<br/> 
                    <?php foreach ($errors as $error): ?>
                        <?=$error?><br/>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                  
        </div>
    <?php endif; ?>
        <div class="row">
            <div class="col-lg-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?php
                        echo $form->field($model, 'parent')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Category::find()->where(['parent'=>0])->orderBy('order', 'asc')->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Select parent category ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Parent category');
                        ?>

                    <!--
                    <?= $form->field($model, 'iconFile')->fileInput()->label('Icon file (image)') ?>
                    -->
                    <label class="control-label" for="category-name">Color</label>
                    <div class="category-color-box">
                        <?php for ($i = 1; $i <= 6; $i++) { ?>
                        <div class="category-color-item 
                            <?php if ($model->theme == 'theme-' . $i):?>
                            active
                            <?php endif;?>" data-theme-name="theme-<?=$i?>">
                                <div class="col-block theme-<?=$i?>"></div>
                            </div>
                        <?php }?>
                       
                    </div>
                    <?= $form->field($model, 'theme')->hiddenInput()->label(''); ?>
                    
                    <label class="control-label" for="category-name">Logo</label>
                    <div class="active-logo">
                        
                        <div class="category-icon-saved">
                            <div class="icon-saved-block <?php echo (!empty($model->theme)) ? $model->theme : 'theme-1'; ?>">
                            
                                <i class="material-icons white md-36"><?php echo (!empty($model->logo_name)) ? $model->logo_name : 'bookmark_border'; ?> </i>
                            
                            </div>
                        </div>
                        
                    </div>
                    <?= $form->field($model, 'logo_name')->hiddenInput()->label(''); ?>
                    
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/category'], ['class'=>'btn btn-danger']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>



            <div class="col-lg-8">
            <div class="box">
            <div class="box-body">
            <div class="box-header ui-sortable-handle with-border">
                <label>Click on Icon for choose:</label>

            
            </div>
            <div class="box-body border-radius-none icons-box">
                <?php
                $icon_names = Category::iconsList();
                foreach ($icon_names as $icon_name) {
                    echo '<div class="icon-item" data-logo-name="' . $icon_name . '"><i class="material-icons">' . $icon_name . '</i></div>';
                }
                ?>
                </div>
            </div>
            </div>
            </div>



        </div>
       
</div>

