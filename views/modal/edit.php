<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use app\models\Template;
use app\models\ModalForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\color\ColorInput;
use dosamigos\selectize\SelectizeTextInput;
use kartik\sortable\Sortable;
use kartik\date\DatePicker;

$this->title = 'Edit Modal window';
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
            <div class="col-lg-4">
            <div class="box box-success">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'modal-edit-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                
                <div style="float:right;" 
                <?php if (empty($has_visible_slides)): ?>
                  data-toggle="tooltip" data-placement="top" title="Create at least one slide for preview mode or make Visible!" 
                <?php endif; ?>>
                <a class="btn btn-app" onClick="previewModal(<?=$model->id?>)"
                <?php if (empty($has_visible_slides)): ?>
                  disabled style="pointer-events: none;"
                <?php endif; ?>>
                                <i class="fa fa-tv"></i> Preview
                            </a>    
                </div>
                            
                <b>Visible for users:</b>
                
                    <?php
                    if (empty($has_visible_slides)) {
                        echo '<div class="checkbox-block"  data-toggle="tooltip" data-placement="top" title="Create at least one visible slide for make modal Visible!">';
                        echo $form->field($model, 'show')->checkbox(['disabled' => true, 'options'=>['data-abide'=>true]])->label('');
                        echo '</div>';
                    } else {
                        echo $form->field($model, 'show')->checkbox()->label('');
                    }
                    ?>
                    
                    

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->orderBy(['order' => 'ASC'])->all(), 'id', 'name'), ['prompt'=>'']) ?>
                    <!--
                    <?= $form->field($model, 'logoFile')->fileInput()->label('Logo file (gif, video, image)') ?>
                    <?= $form->field($model, 'show_logo')->checkbox()->label('Show logo');?>
                    
                    <div class="form-group">   
                      <img class="img-thumbnail" src="/<?=$model->logo?>" alt="Photo">  
                    </div>
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
                          <?= $form->field($model, 'theme_color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select color ...'],])->label('Primary color') ?>
                          <?= $form->field($model, 'secondary_theme_color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select color ...'],])->label('Secondary color') ?>
                    
                        </div>
                    
                    </div>
                    <?=$form->field($model, 'feature_announ')->checkbox()->label('<span class="checkbox-label">Feature announcement window <span>')->hint('When this flag ON attached modal window shows in Feature New notification tab');?>
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
                    )->label('Showing start date (Works when Auto show: ON)')->hint('Select a display date (the modal window will be shown as Feature Announcement for 7 days period)') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Cancel', ['/modal'], ['class'=>'btn btn-danger']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
            </div>
            </div>
            
        <div class="col-md-8">
          <!--  col-md-8 start -->

          <!--- blue box  --->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header ui-sortable-handle">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Start slide</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="box-body border-radius-none">
            <?php if (!empty($modal_slides->start_slide)) {?>
            <table class="table">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                
                <tr>
                  <td><?=$modal_slides->start_slide->id?></td>
                  <td><?=$modal_slides->start_slide->name?></td>
                  
                  <td>
                  <?php if ($modal_slides->start_slide->show) {?>
                    <span class="label label-success">Active</span>
                  <?php } else {?>
                    <span class="label label-warning">Disabled</span>
                  <?php }?>
                  </td>
                  <td>
                  <a href="<?=Url::toRoute(['modal-slide/edit', 'id' => $modal_slides->start_slide->id])?>"><button type="button" class="btn  btn-success btn-xs">Edit</button></a>
                  <?php echo Html::a('Delete', ['modal-slide/delete', 'id' => $modal_slides->start_slide->id], [
                      'class' => 'btn btn-danger btn-xs',
                      'data' => [
                          'confirm' => 'Are you sure you want to delete this item?',
                          'method' => 'post',
                      ],
                  ]) ?>
                  
                  </td>
                </tr>
                
                
              </tbody></table>
            <?php } else {?>
                <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 4,'slide_type'=>1]);?>" class="btn btn-sm btn-info btn-flat pull-left">CREATE START SLIDE</a>
            <?php } ?>
            </div>
            <!-- /.box-body -->
          
          </div>


          <!---- Yellow box ---->
          
          <div class="box bg-yellow-gradient">
            
            <div class="box-header ui-sortable-handle">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Modal slides</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
              </div>
            </div>
            <div class="box-body border-radius-none">
            <?php if (empty($modal_slides->slides) || sizeof($modal_slides->slides) < 6) {?>
              <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-flat pull-left" id="create-slide-open" style="display: block;margin-bottom: 20px;">CREATE SLIDE</a>
              <br/>
            <?php } else { ?>
              Maximum slides in modal window - 6
            <?php } ?>
            <div class="col-sm-12" style="display:none;" id="modal-action-slide-block">
            <br/><br/>
                <div class="form-group field-modal-template_id">
                  <label class="control-label">Click on image for choose template:</label>
                
                </div>
                 <div class="col-sm-6 template-thumb">
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 1]);?>">
                    <img src="/img/video_text.png" alt="..." class="margin">
                    </a>
                    <h6>Youtube video and Text Template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 8]);?>">
                    <img src="http://placehold.it/140x100" alt="..." class="margin">
                    </a>
                    <h6>Media file and text template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 9]);?>">
                    <img src="http://placehold.it/140x100" alt="..." class="margin">
                    </a>
                    <h6>Media file template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 4]);?>">
                    <img src="/img/first_slide.png" alt="..." class="margin">
                    </a>
                    <h6>Text and button template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 5]);?>">
                    <img src="/img/video.png" alt="..." class="margin">
                    </a>
                    <h6>Youtube video Template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 6]);?>">
                    <img src="/img/html_content.png" alt="..." class="margin">
                    </a>
                    <h6>HTML Content Template<h6>
                 </div>
                 <!--div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 10]);?>">
                    <img src="http://placehold.it/140x100" alt="..." class="margin">
                    </a>
                    <h6>Wide template<h6>
                 </div>
                 <div class="col-sm-6 template-thumb" >
                    <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 11]);?>">
                    <img src="http://placehold.it/140x100" alt="..." class="margin">
                    </a>
                    <h6>Custom video<h6>
                 </div-->
            </div>
            <?php if (!empty($modal_slides->slides)) {?>
              <div class="box-body no-padding">
              <table class="table">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Slide name</th>
                  <th>Show</th>
                  <th>Actions</th>
                  </tbody></table>
                </tr>
                <?php
                $list = [];
                foreach ($modal_slides->slides as $modal_slide) {
                    $status = ($modal_slide->show) ? '<span style="margin-right:120px;width:20px;"  class="label label-success">Active</span>' : '<span style="margin-right:108px;width:20px;"  class="label label-warning">Disabled</span>';
                
                    $list[] = ['content' =>'
                          <span class="handle ui-sortable-handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                          </span>
                      
                      <span class="text slide" style="width:40%;" data-slide-id="' . $modal_slide->id . '">' . $modal_slide->name . '</span>
                      ' . $status . '
                    
                      <span>
                      <a href="' . Url::toRoute(['modal-slide/edit', 'id' => $modal_slide->id]) . '"><button type="button" class="btn  btn-success btn-xs">Edit</button></a>
                      
                      ' . Html::a('Delete', ['modal-slide/delete', 'id' => $modal_slide->id], [
                        'class' => 'btn btn-danger btn-xs',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) . '
                      </span>
                            
                      
                    '];
                }
                echo Sortable::widget([
                  'type' => Sortable::TYPE_LIST,
                  'items' => $list,
                  'pluginEvents' => [
                    'sortupdate' => 'function() { console.log("sortupdate Slides"); sortSlides();}',
                  ],
                  'options' => ['class' => 'todo-list', 'data-modal-id' => $model->id]
                ]);

                ?>
</tbody></table>
            <?php } ?>
          </div>
           
        </div>
        




          <!-- green box ---->

          <div class="box box-solid bg-green-gradient">
            <div class="box-header ui-sortable-handle">
              <i class="fa fa-th"></i>

              <h3 class="box-title">End slide</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
            </div>
          </div>
          <div class="box-body border-radius-none">
          <?php if (!empty($modal_slides->end_slide)) {?>
            <table class="table">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                
                <tr>
                  <td><?=$modal_slides->end_slide->id?></td>
                  <td><?=$modal_slides->end_slide->name?></td>
                  
                  <td>
                  <?php if ($modal_slides->end_slide->show) {?>
                    <span class="label label-success">Active</span>
                  <?php } else {?>
                    <span class="label label-warning">Disabled</span>
                  <?php }?>
                  </td>
                  <td>
                  <a href="<?=Url::toRoute(['modal-slide/edit', 'id' => $modal_slides->end_slide->id])?>"><button type="button" class="btn  btn-success btn-xs">Edit</button></a>
                  <?php echo Html::a('Delete', ['modal-slide/delete', 'id' => $modal_slides->end_slide->id], [
                      'class' => 'btn btn-danger btn-xs',
                      'data' => [
                          'confirm' => 'Are you sure you want to delete this item?',
                          'method' => 'post',
                      ],
                  ]) ?>
                  </td>
                </tr>
                
                
              </tbody></table>
          <?php } else {?>
              <a href="<?=Url::toRoute(['modal-slide/create', 'modal_id' => $model->id, 'template_id' => 4,'slide_type'=>2]);?>" class="btn btn-sm btn-success btn-flat pull-left">CREATE END SLIDE</a>
          <?php } ?>
          </div>



<!--col-md-8 end -->
          </div>








          