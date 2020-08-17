<?php

namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['news/index']);
        }

        $model = new Admin();
        $model->setScenario(Admin::SCENARIO_LOGIN);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $admin = Admin::findByEmail($model->email);

            if ($admin && (Yii::$app->getSecurity()->validatePassword(md5($model->password), $admin->password))) {
                try {
                    if (Yii::$app->user->login($admin)) {
                        Yii::$app->getSession()->setFlash('success', Yii::t('app', sprintf('Привет, %s', Yii::$app->user->identity->name)));

                        return $this->redirect(['news/index']);
                    }
                } catch (\Exception $e) {
                    Yii::error($e->getMessage(), 'app');
                }
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
