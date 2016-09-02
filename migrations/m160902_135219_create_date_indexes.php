<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m160902_135219_create_date_indexes extends Migration
{
    public function safeUp()
    {
        $this->createIndex(
            'idx-audio-date_published',
            'audio',
            'date_published'
        );
        $this->createIndex(
            'idx-movie-date_published',
            'movie',
            'date_published'
        );
        $this->createIndex(
            'idx-event-date_published',
            'event',
            'date_published'
        );
    }

    public function safeDown()
    {
        $this->dropIndex(
            'idx-audio-date_published',
            'movie'
        );
        $this->dropIndex(
            'idx-movie-date_published',
            'movie'
        );
        $this->dropIndex(
            'idx-event-date_published',
            'movie'
        );
    }
}
