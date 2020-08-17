<?php

namespace frontend\controllers;

use yii\base\ActionFilter;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class RestController extends ActiveController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formatParam' => 'format',
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ]
        ];

        $behaviors['access'] = [
            'class' => ActionFilter::class
        ];

        return $behaviors;
    }
}