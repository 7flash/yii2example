<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `audio`.
 */
class m160827_192420_create_audio_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%audio}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NULL",
            'cover' => Schema::TYPE_STRING . "(255) NULL",
            'artist' => Schema::TYPE_STRING . "(255) NULL",
            'album' => Schema::TYPE_STRING . "(255) NULL",
            'date' => Schema::TYPE_DATETIME . " NULL",
            'date_published' => Schema::TYPE_DATETIME . " NULL DEFAULT CURRENT_TIMESTAMP",
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('audio');
    }
}
