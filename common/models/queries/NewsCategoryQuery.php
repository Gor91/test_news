<?php

namespace common\models\queries;

use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\common\models\NewsCategory]].
 *
 * @see \common\models\NewsCategory
 */
class NewsCategoryQuery extends \yii\db\ActiveQuery
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
     * @param $news_id
     * @param bool $only_ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCategoriesByNewsID($news_id, $only_ids = false)
    {
        $query = self::where(['news_id' => $news_id]);

        if ($query->exists() && $only_ids) {
            return array_keys(ArrayHelper::map($query->asArray()->all(), 'category_id', 'category_id'));
        }

        return $query->all();
    }

    /**
     * @param $news_id
     * @param $cat_id
     * @return bool
     */
    public function categoryNewsExists($news_id, $cat_id)
    {
        return self::where(['news_id' => $news_id, 'category_id' => $cat_id])->exists();
    }
}
