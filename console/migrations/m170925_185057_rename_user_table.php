<?php

use yii\db\Migration;

class m170925_185057_rename_user_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->renameTable('{{%user}}', '{{%users}}');
    }

    public function safeDown()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }
}
