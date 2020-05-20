<?php

/* @var $this yii\web\View */
use kartik\sortable\Sortable;
use yii\helpers\Html;

$this->title = 'Category Tutorials Ordering Page';
?>
<?= Html::csrfMetaTags() ?>
<h2>Category: <?=$category->name?></h2>
<div class="row">
        <div class="col-xs-6">
          <div class="box todo-list">
            
            <?php
             $list = [];
            foreach ($tutorials as $tutorial) {

                $show_label = ($tutorial['show'] > 0) ? '' : '<small class="label label-warning"><i class="fa fa-clock-o"></i> Disabled</small>';
                $list[] = ['content' =>'
                      <span class="handle ui-sortable-handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <span class="text category-tutorial" data-tutorial-type="' . $tutorial['type'] . '" data-tutorial-id="' . $tutorial['id'] . '">' . $tutorial['name'] . '</span>
                  ' . $show_label . '
                '];
            }
              echo Sortable::widget([
                'type' => Sortable::TYPE_LIST,
                'items' => $list,
                'pluginEvents' => [
                  'sortupdate' => 'function() {sortCategoryTutorials();}',
                ],
                'options' => ['class' => 'todo-list']
              ]);
                ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>