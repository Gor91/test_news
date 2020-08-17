<?php
/**
 * Table news_category
 */

use yii\db\Migration;

class m200813_113324_news_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%news_category}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'news_id' => $this->integer()->notNull()->unsigned(),
            'category_id' => $this->integer()->notNull()->unsigned()
        ]);

        $this->createIndex('newsCategoryNewsIdCategoryIdIndex', '{{%news_category}}', ['news_id', 'category_id'], true);

        $this->addForeignKey('newsCategoryNewsIdFK', '{{%news_category}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('newsCategoryCategoryIdFK', '{{%news_category}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('newsCategoryNewsIdFK', '{{%news_category}}');
        $this->dropForeignKey('newsCategoryCategoryIdFK', '{{%news_category}}');

        $this->dropTable('{{%news_category}}');
    }
}
