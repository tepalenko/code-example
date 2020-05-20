<?php

/* @var $this yii\web\View */
use kartik\sortable\Sortable;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Category';
?>
<?= Html::csrfMetaTags() ?>
<div class="row">
  <div class="col-xs-12">
      <a href="<?= \yii\helpers\Url::to('category/create') ?>" class="btn btn-success btn-sm ad-click-event">
        Create Category
      </a>
  </div>
</div>
<br/>
<div class="row">
        <div class="col-xs-6">
          <div class="box todo-list">
            
            <?php
             $list = [];
            foreach ($categories as $category) {
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
                    <a href="' . Url::toRoute(['category/tutorials', 'id' => $category->id]) . '"><i class="fa fa-reorder"></i></a>
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
          <!-- /.box -->
        </div>
      </div>