<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Handles the creation for table `movie`.
 */
class m160827_192435_create_movie_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%movie}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(255) NULL",
            'cover' => Schema::TYPE_STRING . "(255) NULL",
            'artist' => Schema::TYPE_STRING . "(255) NULL",
            'album' => Schema::TYPE_STRING . "(255) NULL",
            'date' => Schema::TYPE_STRING . "(255) NULL",
            'date_published' => Schema::TYPE_DATETIME . " NULL DEFAULT CURRENT_TIMESTAMP",
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('movie');
    }
}
