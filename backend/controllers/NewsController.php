<?php

namespace backend\controllers;

use common\models\Category;
use common\models\NewsCategory;
use Yii;
use common\models\News;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class NewsController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => News::find()->getProvider(),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {
                    foreach ($model->categories as $category) {
                        $news_category = new NewsCategory();
                        $news_category->news_id = $model->id;
                        $news_category->category_id = $category;
                        $news_category->save();
                    }

                    $transaction->commit();

                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), 'app');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => Category::find()->getList()
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_categories = NewsCategory::find()->getCategoriesByNewsID($id, true);
        $model->categories = $old_categories;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {
                    $isOk = true;

                    foreach ($model->categories as $category) {
                        if (!NewsCategory::find()->categoryNewsExists($id, $category)) {
                            $news_category = new NewsCategory();
                            $news_category->news_id = $model->id;
                            $news_category->category_id = $category;

                            if (!$news_category->save()) {
                                $isOk = false;
                                break;
                            };
                        }
                    }

                    $deleted = array_diff($old_categories, (array)$model->categories);

                    NewsCategory::deleteAll(['news_id' => $model->id, 'category_id' => $deleted]);

                    if (!$isOk) {
                        $transaction->rollBack();

                        return $this->refresh();
                    }

                    $transaction->commit();

                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), 'app');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => Category::find()->getList()
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return News|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
