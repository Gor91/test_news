<?php

namespace common\models;

use common\models\queries\NewsQuery;
use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property int|null $created
 * @property int|null $updated
 *
 * @property NewsCategory[] $newsCategories
 * @property Category[] $categories
 */
class News extends BaseModel
{
    /** @var $categories array */
    public $categories;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'categories'], 'required'],
            [['content'], 'string'],
            ['categories', 'in', 'allowArray' => true, 'range' => array_keys(Category::find()->getList())],
            [['created', 'updated'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'content' => Yii::t('app', 'Content'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'categories' => Yii::t('app', 'Categories'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategory::class, ['news_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCategoriesList()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('{{%news_category}}', ['news_id' => 'id']);
    }

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        $fields[] = 'categoriesList';

        return $fields;
    }

    /**
     * @return NewsQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }
}
