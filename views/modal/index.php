<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Modal Windows List';
?>
<div class="row">
  <div class="col-xs-12">
      <a href="<?= \yii\helpers\Url::to('modal/create') ?>" class="btn btn-success btn-sm ad-click-event">
        CREATE MODAL WINDOW
      </a>
  </div>
</div>
<br/>
<div class="row">
  

        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            <?php if (!empty($modalWindows)):?>
              <table id="modal-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                    <th>Modal Window Name</th>
                  <th>Feature Announ.</th>
                  <th>Auto Show</th>
                  <th>Author</th>
                  <th>Status</th>
                  
                  <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($modalWindows as $modalWindow):?>
                  <tr>
                    
                    <td style="width:40%;"><?=$modalWindow->name?></td>
                    <td><?php if ($modalWindow->feature_announ) {?>
                          <span class="label label-success">ON</span>
                        <?php } else {?>
                          <span class="label label-default">OFF</span>
                        <?php }?>
                    </td>
                    <td><?php if ($modalWindow->auto_show) {?>
                          <span class="label label-success">ON</span>
                        <?php } else {?>
                          <span class="label label-default">OFF</span>
                        <?php }?>
                    </td>
                    <td>
                      <?php
                        $user = $modalWindow->getUser()->one();
                        echo $user->username; ?>
                    </td>
                    <td><?php if ($modalWindow->show) {?>
                          <span class="label label-success">Active</span>
                        <?php } else {?>
                          <span class="label label-warning">Disabled</span>
                        <?php }?>
                    </td>
                    
                    <td style="width:20%;">

                    <a class="btn btn-default" href="<?=Url::toRoute(['modal/edit', 'id' => $modalWindow->id]);?>">
                      <i class="fa fa-edit"></i> Edit
                    </a>
                    <?php echo Html::a('<i class="fa fa-remove"></i>Delete', ['modal/delete', 'id' => $modalWindow->id], [
                      'class' => 'btn btn-default',
                      'data' => [
                          'confirm' => 'Are you sure you want to delete this item?',
                          'method' => 'post',
                      ],
                  ]) ?>

                    </td>
                  </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Modal Window Name</th>
                    <th>Feature Announ.</th>
                    <th>Auto Show</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>