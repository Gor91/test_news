<?php
/**
 * Table admin
 */

use yii\db\Migration;

class m200813_113249_admin extends Migration
{
    public function up()
    {
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'name' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'password' => $this->string(200)->notNull(),
            'created' => $this->integer()->unsigned(),
            'updated' => $this->integer()->unsigned()
        ]);

        $this->insert('{{%admin}}', [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$13$D3Ro1KWrxqAFhwrQ3gb8AuuNWXTfmehe7zT9A.Z7M6oMX9cCjxKUC', // admin
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%admin}}');
    }
}
