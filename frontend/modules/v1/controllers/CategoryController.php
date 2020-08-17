<?php

namespace frontend\modules\v1\controllers;

use frontend\controllers\RestController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;

class CategoryController extends RestController
{
    /**
     * Allows two types of authorization.
     *   1.Query param authorization
     *   2.Oauth2 authorization(bearer authorization).
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class,
                    QueryParamAuth::class
                ]
            ]
        ], parent::behaviors());
    }

    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = 'frontend\modules\v1\models\Category';

    /**
     * @return array
     */
    public function actions()
    {
        $actions = [];

        $actions['index'] = [
            'class' => 'frontend\modules\v1\controllers\categoryActions\IndexAction',
            'modelClass' => $this->modelClass
        ];

        return $actions;
    }
}