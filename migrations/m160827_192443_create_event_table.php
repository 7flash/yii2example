<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation for table `event`.
 */
class m160827_192443_create_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%event}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NULL",
            'location' => Schema::TYPE_STRING . "(255) NULL",
            'date' => Schema::TYPE_DATETIME . " NULL",
            'date_end' => Schema::TYPE_DATETIME . " NULL",
            'date_published' => Schema::TYPE_DATETIME . " NULL DEFAULT CURRENT_TIMESTAMP",
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('event');
    }
}
