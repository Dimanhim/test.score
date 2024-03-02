<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m240301_170025_logs
 */
class m240301_170025_logs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%logs}}', [
            'id'                    => Schema::TYPE_PK,

            'type_id'               => Schema::TYPE_INTEGER . ' NOT NULL',
            'value'                 => Schema::TYPE_INTEGER . ' NOT NULL',
            'name'                  => Schema::TYPE_INTEGER . ' NOT NULL',
            'desc'                  => Schema::TYPE_STRING,
            'score_id'              => Schema::TYPE_INTEGER,

            'created_at'            => Schema::TYPE_INTEGER,
            'updated_at'            => Schema::TYPE_INTEGER,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('logs');
    }
}
