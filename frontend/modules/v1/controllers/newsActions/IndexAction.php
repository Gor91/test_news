<?php

namespace frontend\modules\v1\controllers\newsActions;

use frontend\modules\v1\models\News;
use yii\rest\Action;

class IndexAction extends Action
{
    public function run($id = null)
    {
        return News::find()->getByCategoryID($id);
    }
}