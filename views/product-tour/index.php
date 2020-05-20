<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Product Tour List';
?>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
            
            <?php  if (!empty($product_tours)) { ?>
              <table id="product-tour-list-table" class="display" style="width:100%">
                <thead>
                    <tr>
                    <th>Name</th>
                  <th>Author (Checker username)</th>
                  <th>Status</th>
                  <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($product_tours as $product_tour):?>
                  <tr>
                  <td><?=$product_tour->name?></td>
                  <td>
                    <?php $user = $product_tour->getProductTourAdmin()->one();
                    echo $user->checker_username; ?></td>
                  <td>
                    <?php if ($product_tour->show) {?>
                        <span class="label label-success">Active</span>
                    <?php } else {?>
                        <span class="label label-warning">Disabled</span>
                    <?php }?>
                  </td>
                  <td>
                  <a href="<?=Url::toRoute(['product-tour/edit', 'id' => $product_tour->id]);?>"><button type="button" class="btn  btn-success btn-xs">Edit</button>
                    <?php echo Html::a('Delete', ['product-tour/delete', 'id' => $product_tour->id], [
                      'class' => 'btn  btn-danger btn-xs',
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
                    <th>Name</th>
                  <th>Author (Checker username)</th>
                  <th>Status</th>
                  <th>Actions</th>
                    </tr>
                </tfoot>
            </table>             
            <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>