<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\sortable\Sortable;
use yii\helpers\Url;

$this->title = 'Edit category';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php if ($model->hasErrors()):?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Alert!</h4>
            <?php foreach ($model->errors as $field_name => $errors): ?>
                Field: "<?=$field_name?>"<br/>
                Errors:<br/> 
                <?php foreach ($errors as $error):?>
                    <?=$error?><br/>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <div class="row">
            <div class="col-lg-4">
            <div class="box">
            <div class="box-body">
                
                <?php $form = ActiveForm::begin(['id' => 'modal-edit-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

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
                    <?= $form->field($model, 'iconFile')->fileInput()->label('Logo file (gif, video, image)') ?>
                    <?php if (!empty($model->icon)): ?>
                        <div class="form-group">
                            <img class="img-thumbnail" src="/<?=$model->icon?>" alt="Photo">  
                        </div>
                    <?php endif; ?>
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

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sub categories</h3>
                        <span class="label label-primary pull-right"></span>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                    <div class="box todo-list">
            
                    <?php
                    $list = [];
                    foreach ($sub_categories as $category) {
                        $category_modals = $category->getModals()->all();
                        if (sizeof($category_modals) > 0) {
                            $delete_button = Html::a('<i class="fa fa-trash-o"></i>', null, [
                            'class' => '',
                            'href' => 'javascript:void(0);',
                            'data' => [
                                'title' => 'Delete categories with tutorials NOT ALLOWED. Delete or un touch tutorials first.',
                                'toggle' => 'tooltip',
                                'placement' => 'top'
                            ],
                            ]);
                        } else {
                            $delete_button = Html::a('<i class="fa fa-trash-o"></i>', ['category/delete', 'id' => $category->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                            ]);
                        };
                        $list[] = ['content' =>'
                            <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                        
                        <span class="text category" data-category-id="' . $category->id . '">' . $category->name . '</span>
                        <small class="label label-warning"><i class="fa fa-clock-o"></i> ' . sizeof($category_modals) . ' items</small>
                        <div class="tools">
                            <a href="' . Url::toRoute(['category/edit', 'id' => $category->id]) . '"><i class="fa fa-edit"></i></a>
                            ' . $delete_button . '
                        </div>
                        '];
                    }
                    echo Sortable::widget([
                        'type' => Sortable::TYPE_LIST,
                        'items' => $list,
                        'pluginEvents' => [
                        'sortupdate' => 'function() {sortCategory();}',
                        ],
                        'options' => ['class' => 'todo-list']
                    ]);
                    ?>
                        <!-- /.box-body -->
                    </div>
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
                    if ($icon_name == $model->logo_name) {
                        echo '<div class="icon-item active" data-logo-name="' . $icon_name . '"><i class="material-icons">' . $icon_name . '</i></div>';
                    } else {
                        echo '<div class="icon-item" data-logo-name="' . $icon_name . '"><i class="material-icons">' . $icon_name . '</i></div>';
                    }
                }
                ?>
                </div>
            </div>
            </div>
            </div>


        </div>
</div>