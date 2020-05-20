<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;
use dosamigos\selectize\SelectizeTextInput;
use kartik\date\DatePicker;

$this->title = 'Add Modal window';
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
            <div class="col-lg-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                            
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true])->hint('Name in Knowledge base') ?>

                    <?=$form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy(['order' => 'ASC'])->all(), 'id', 'name'), ['prompt'=>''])?>
                    <!--
                    <?=$form->field($model, 'show_logo')->checkbox()->label('Show logo');?>
                    
                    <?= $form->field($model, 'logoFile')->fileInput()->label('Logo file (gif, video, image)') ?>
                    -->
                    
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

                    <div class="box collapsed-box">
                        <div class="box-header" style="padding-left:0;">
                        <b>Theme colors</b>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-plus"></i></button>

                        </div>
                        </div>
                        <div class="box-body" style="">
                        <?= $form->field($model, 'theme_color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select color ...']])->label('Primary color') ?>
                                    <?= $form->field($model, 'secondary_theme_color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select color ...'],])->label('Secondary color') ?>
                        </div>
                    
                    </div>
                    <?=$form->field($model, 'feature_announ')->checkbox()->label('<span class="checkbox-label">Feature announcement window<span>')->hint('When this flag ON attached modal window shows in Feature New notification tab. <a href="https://learning-be.checker-soft.com/documentation#feature-announ" target="_blank">More details in documentation.</a> ');?>
                    <?=$form->field($model, 'auto_show')->checkbox()->label('<span class="checkbox-label">Auto show after page load<span>')->hint('When this flag ON modal window shows for all users when page loads');?>
                    
                    <?= $form->field($model, 'auto_show_start_date')->widget(
                        DatePicker::classname(),
                        [
                            'options' => ['placeholder' => 'Select start date ...'],
                            'pluginOptions' => [
                                'format' => 'dd-M-yyyy',
                                'todayHighlight' => true
                            ]
                        ]
                    )->label('Showing start date (Works when Auto show:ON)')->hint('Select a display date (the modal window will be shown as Feature Announcement for 7 days period)') ?>
                    
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/modal'], ['class'=>'btn btn-danger']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
       
</div>

