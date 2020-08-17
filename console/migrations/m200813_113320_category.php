<?php
/**
 * Table category
 */

use yii\db\Migration;

class m200813_113320_category extends Migration
{
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'title' => $this->string(100)->notNull(),
            'parent_id' => $this->integer()->unsigned()
        ]);

        $this->addForeignKey('categoryParentIdFK', '{{%category}}', 'parent_id', '{{%category}}', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('categoryParentIdFK', '{{%category}}');

        $this->dropTable('{{%category}}');
    }
}
