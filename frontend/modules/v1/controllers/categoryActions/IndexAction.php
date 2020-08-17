<?php

namespace frontend\modules\v1\controllers\categoryActions;

use frontend\modules\v1\models\Category;
use yii\rest\Action;

class IndexAction extends Action
{
    public function run()
    {
        return Category::find()->all();
    }
}