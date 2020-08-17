<?php

namespace common\models\queries;

use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\News]].
 *
 * @see \common\models\News
 */
class NewsQuery extends \yii\db\ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return ActiveDataProvider
     */
    public function getProvider()
    {
        $query = self::joinWith('categoriesList');

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param $id
     * @return array|ActiveDataProvider
     */
    public function getByCategoryID($id)
    {
        if (!$id) {
            return [];
        }

        $query = self::joinWith('categoriesList');

        $sub_category_ids = $this->menuTree($id);

        $query->where(['category_id' => ArrayHelper::merge($sub_category_ids, [$id])]);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * @param null $parent_id
     * @param array $ids
     * @return array
     */
    function menuTree($parent_id = null, &$ids = [])
    {
        $sub_categories = Category::findAll(['parent_id' => $parent_id]);

        foreach ($sub_categories as $category) {
            $ids[] = $category['id'];
            $this->menuTree($category['id'], $ids);
        }

        return $ids;
    }
}
