<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 menu-view">
    <?=
    Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            ['label' => 'Update', 'url' => ['update', 'id' => $model->id], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            ['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <div class="box box-info menu-view">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'menuParent.name:text:Parent',
                    'name',
                    'route',
                    'order',
                ],
            ])
            ?>
        </div>
    </div>
</div>
