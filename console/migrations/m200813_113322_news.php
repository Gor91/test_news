<?php
/**
 * Table news
 */

use yii\db\Migration;

class m200813_113322_news extends Migration
{
    public function up()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
            'created' => $this->integer()->unsigned(),
            'updated' => $this->integer()->unsigned()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%news}}');
    }
}
