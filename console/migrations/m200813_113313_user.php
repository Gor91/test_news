<?php
/**
 * Table user
 */

use yii\db\Migration;

class m200813_113313_user extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'name' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'password' => $this->string(200)->notNull(),
            'token' => $this->string(200)->notNull(),
            'created' => $this->integer()->unsigned(),
            'updated' => $this->integer()->unsigned()
        ]);

        $this->insert('{{%user}}', [
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => '$2y$13$LGvOO/1RpEjkATUiov1gqeJFLeRj2deWl5CyTAJSlxaAwmSTc1Qoq', // password
            'token' => 'yEODhwscP6cuBAv0tx4LRsm8qSjZ002U'
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
