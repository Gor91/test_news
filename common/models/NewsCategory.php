<?php

namespace common\models;

use common\models\queries\NewsCategoryQuery;
use Yii;

/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property int $id
 * @property int|null $news_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property News $news
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['news_id', 'category_id'], 'required'],
            [['news_id', 'category_id'], 'integer'],
            [['news_id', 'category_id'], 'unique', 'targetAttribute' => ['news_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'news_id' => Yii::t('app', 'News ID'),
            'category_id' => Yii::t('app', 'Category ID')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * @return NewsCategoryQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new NewsCategoryQuery(get_called_class());
    }
}
