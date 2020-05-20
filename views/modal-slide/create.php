<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Modal;
use app\models\ModalSlide;
use app\models\ProductTour;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Add Slide for ' . $modal_window->name . ' window';
$this->params['breadcrumbs'][] = ['label' => 'Edit Modal "' . $modal_window->name . '"','url' => ['/modal/edit?id=' . $modal_window->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Alert!</h4>
            <?php foreach ($errors as $field_name => $errors): ?>
                Field: "<?=$field_name?>"<br/>
                Errors:<br/> 
                <ul>
                    <?php foreach ($errors as $error):?>
                        <li><?=$error?></li>
                    <?php endforeach; ?>
                </ul>
                <br/>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php $form = ActiveForm::begin(['id' => 'slide-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                            
                        <div>
                            <a class="btn btn-app" onClick="previewSlide({theme_color:'<?=$modal_window->theme_color?>', secondary_theme_color:'<?=$modal_window->secondary_theme_color?>', show_logo:'<?=$modal_window->show_logo?>'});">
                                <i class="fa fa-tv"></i> Preview
                            </a>
                            </div>
                            
                            <?= $form->field($model, 'type')->dropDownList(ModalSlide::modalSlideTypes(), ['prompt' => ' -- Select Slide Type --'])->hiddenInput()->label('') ?>
                            
                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                            <?php if (in_array('title', $template_params)):?>
                                <?= $form->field($model, 'title')->textInput() ?>
                            <?php endif;?>
                            <?php if (in_array('show_description', $template_params)):?>
                                <?=$form->field($model, 'show_description')->checkbox()->label('Show Description');?>
                            <?php endif;?>
                            <?php if (in_array('description', $template_params)):?>
                                <?= $form->field($model, 'description')->textArea(['rows' => '6']) ?>
                            <?php endif;?>
                            
                            <?php if (in_array('imageFile', $template_params)):?>
                                <?= $form->field($model, 'imageFile')->fileInput()->label('Media file (gif, video, image)') ?>
                                <button style="width:45px;display:none;float: left;margin-top: 18px;" id="file-input-reset" onClick="clearInputFile();" type="button" class="btn btn-block btn-info btn-xs">Reset</button>
                                <div style="clear:both;"></div>
                            <?php endif;?>
                            <?php if (in_array('content', $template_params)):?>
                                <?= $form->field($model, 'content')->textArea(['rows' => '6']) ?>
                            <?php endif;?>
                            <?php if (in_array('text', $template_params)):?>
                                <?= $form->field($model, 'text')->textArea() ?>
                            <?php endif;?>
                            <?php if (in_array('youtube_link', $template_params)):?>
                                <?= $form->field($model, 'youtube_link')->textInput() ?>
                            <?php endif;?>
                            <?php if (in_array('show_button', $template_params)):?>
                                <?=$form->field($model, 'show_button')->checkbox()->label('<span class="show-link-text">Show button</span>');?>
                            <?php endif;?>
                            <!-- Special links for end slide (type = 2) -->


                            <?php if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE): ?>
                            <div class="box box-success collapsed-box">
                                <div class="box-header ui-sortable-handle with-border">
                                <label>Related Tutorials</label>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                    
                                </div>
                                </div>
                                <div class="box-body border-radius-none">
                                    <?php if (in_array('related_tutorial_1_text', $template_params)):?>
                                        <?= $form->field($model, 'related_tutorial_1_text')->textInput()->hint('Max length 30 characters') ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_1_modal_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_1_modal_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a modal window ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Modal window to button');
                                        ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_1_product_tour_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_1_product_tour_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a product tour ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Product tour to button');
                                        ?>
                                    <?php endif;?>

                                    <?php if (in_array('related_tutorial_2_text', $template_params)):?>
                                        <?= $form->field($model, 'related_tutorial_2_text')->textInput()->hint('Max length 30 characters') ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_2_modal_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_2_modal_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a modal window ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Modal window to button');
                                        ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_2_product_tour_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_2_product_tour_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a product tour ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Product tour to button');
                                        ?>
                                    <?php endif;?>

                                    <?php if (in_array('related_tutorial_3_text', $template_params)):?>
                                        <?= $form->field($model, 'related_tutorial_3_text')->textInput()->hint('Max length 30 characters') ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_3_modal_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_3_modal_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a Modal window ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Modal window to button');
                                        ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_3_product_tour_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_3_product_tour_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a product tour ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Product tour to button');
                                        ?>
                                    <?php endif;?>

                                    <?php if (in_array('related_tutorial_4_text', $template_params)):?>
                                        <?= $form->field($model, 'related_tutorial_4_text')->textInput()->hint('Max length 30 characters') ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_4_modal_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_4_modal_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a Modal window ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Modal window to button');
                                        ?>
                                    <?php endif;?>
                                    <?php if (in_array('related_tutorial_4_product_tour_id', $template_params) && in_array($model->type, [0, 2])):?>
                                        <?php
                                            echo $form->field($model, 'related_tutorial_4_product_tour_id')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                                'options' => ['placeholder' => 'Select a product tour ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Attach Product tour to button');
                                        ?>
                                    <?php endif;?>`
                                </div>
                                <!-- /.box-body -->
                            </div>
                            

                            <!-- Special links for end slide -->
                            <?php endif; ?>
                            <?php if (in_array('button_text', $template_params)):?>
                                <?= $form->field($model, 'button_text')->textInput()->hint('Max length 30 characters') ?>
                            <?php endif;?>
                            <?php if (in_array('button_modal_id', $template_params) && in_array($model->type, [0, 2])):?>
                                <?php
                                    echo $form->field($model, 'button_modal_id')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                        'options' => ['placeholder' => 'Select a Modal window ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('Attach Modal window to button');
                                ?>
                                
                            <?php endif;?>
                            <?php if (in_array('button_product_tour_id', $template_params) && in_array($model->type, [0, 2])):?>
                                <?php
                                    echo $form->field($model, 'button_product_tour_id')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                        'options' => ['placeholder' => 'Select a product tour ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('Attach Product tour to button');
                                ?>
                            <?php endif;?>
                            
                            <?php if (in_array('button_action_next', $template_params) && $model->type == ModalSlide::MODAL_SLIDE_REGULAR_TYPE):?>
                                <label class="control-label" for="dynamictemplate-button_action_next">Open next slide on click</label>
                                <?=$form->field($model, 'button_action_next')->checkbox()->label('');?>
                            <?php endif;?>
                            
                            <?php if (in_array('product_tour_link_show', $template_params)):?>
                                <?=$form->field($model, 'product_tour_link_show')->checkbox()->label('<span class="show-link-text">Show product tour link</span>');?>
                            <?php endif;?>
                            <?php if (in_array('product_tour_link_text', $template_params)):?>
                                <?= $form->field($model, 'product_tour_link_text')->textInput()->label('Text for link (For example : Show me how it works).') ?>
                            <?php endif;?>
                            <?php if (in_array('product_tour_id', $template_params)):?>
                                <?php
                                    echo $form->field($model, 'product_tour_id')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(ProductTour::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                        'options' => ['placeholder' => 'Select a product tour ...'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('Attach Product tour to button');
                                ?>
                            <?php endif;?>
                            <?php if (in_array('next_modal_link_show', $template_params)):?>
                                <?=$form->field($model, 'next_modal_link_show')->checkbox()->label('<span class="show-link-text">Show modal window link</span>');?>
                            <?php endif;?>
                            <?php if (in_array('next_modal_link_text', $template_params)):?>
                                <?= $form->field($model, 'next_modal_link_text')->textInput()->label('Text for link (For example : Show me how it works).') ?>
                            <?php endif;?>
                            <?php if (in_array('next_modal_id', $template_params)):?>
                                <?php
                                echo $form->field($model, 'next_modal_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Modal::find()->where(['show'=>true])->orderBy('name', 'asc')->all(), 'id', 'name'),
                                    'options' => ['placeholder' => 'Select a modal window ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Attach Modal Window to link');
                                ?>
                            <?php endif;?>
                            <?= $form->field($model, 'template')->hiddenInput()->label(''); ?>
                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                                <?= Html::a('Cancel', ['/modal/edit?id=' . $modal_window->id], ['class'=>'btn btn-danger']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        Slide example
                    </div>
                    <div class="box-body border-radius-none">
                        <img src="/img/doc/template-example-<?=$_GET['template_id']?>.png" class="slide-example-img"/>
                    </div>
                </div>
            </div>
        </div>
        
</div>

