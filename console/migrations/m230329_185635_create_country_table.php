<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m230329_185635_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'c_name' => $this->string(60),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
