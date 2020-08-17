<?php

namespace common\models;

use common\models\queries\CategoryQuery;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $title
 * @property int|null $parent_id
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property NewsCategory[] $newsCategories
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'unique'],
            ['parent_id', 'integer'],
            ['title', 'string', 'max' => 100],
            ['parent_id', 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategory::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id'])->viaTable('{{%news_category}}', ['category_id' => 'id']);
    }

    /**
     * @return CategoryQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
