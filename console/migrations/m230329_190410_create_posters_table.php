<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posters}}`.
 */
class m230329_190410_create_posters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posters}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'price' => $this->integer(),
            'category' => $this->integer(),
            'image' => $this->string(100),
            'description' => $this->text(),
            'user_id' => $this->integer(),
            'address' => $this->integer(),
            'poster_id' => $this->integer(),
            'date' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posters}}');
    }
}
