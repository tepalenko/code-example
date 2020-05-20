<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            [
                'attribute'=>'level',
                'label'=>'Role',
                'value' => function ($data, $key, $index, $column) {
                    $levels = User::getUserLevels();
                    return $levels[$data->level];
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($data, $key, $index, $column) {
                    if ($data->created_at > 0) {
                        return date('d/m/Y', $data->created_at);
                    } else {
                        return $data->created_at;
                    }
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data, $key, $index, $column) {
                    if ($data->updated_at > 0) {
                        return date('d/m/Y', $data->updated_at);
                    } else {
                        return $data->updated_at;
                    }
                },

            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
