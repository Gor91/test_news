<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'content:ntext',
            [
                'attribute' => 'categories',
                'format' => 'html',
                'value' => function ($model) {
                    if (!empty($model->categoriesList)) {
                        return implode(',<br>', ArrayHelper::map($model->categoriesList, 'id', 'title'));
                    }

                    return null;
                },
            ],
            [
                'attribute' => 'created',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated',
                'format' => 'datetime',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
