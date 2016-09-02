<?php
namespace app\models;

use yii\db\Expression;
use yii\db\Query;

class Manager
{
    public static function findItems($types)
    {
        $null = new Expression('NULL');
        $fields = [
            'audio' => ['name', 'cover', 'artist', $null, 'album', 'date', $null, 'date_published', new Expression("'audio' as `type`")],
            'event' => ['name', $null,  $null, 'location', $null, 'date', 'date_end', 'date_published', new Expression("'event' as `type`")],
            'movie' => ['name', 'cover', 'artist', new Expression('NULL as `location`'), 'album', 'date', new Expression('NULL as `date_end`'), 'date_published', new Expression("'movie' as `type`")]
        ];
        $queries = [];
        foreach($types as $type) {
            if(isset($fields[$type])) {
                $typeFields = $fields[$type];
                $queries[] = (new Query())->select($typeFields)->from($type);
            }
        }
        $firstQuery = array_shift($queries);
        $unionQuery = array_reduce($queries, function($previousQuery, $currentQuery) {
            return $previousQuery->union($currentQuery, true);
        }, $firstQuery);
        $itemsQuery = (new Query)->from(['union' => $unionQuery]);
        return $itemsQuery;
    }

    public static function createItem($type, $params)
    {
        switch ($type) {
            case 'movie':
                $item = new Movie();
                break;
            case 'audio':
                $item = new Audio();
                break;
            case 'event':
                $item = new Event();
                break;
        }
        $item->setAttributes($params, false);
        return $item->save(false);
    }

    public static function createMovie($params)
    {
        return self::createItem('movie', $params);
    }

    public static function createAudio($params)
    {
        return self::createItem('audio', $params);
    }

    public static function createEvent($params)
    {
        return self::createItem('event', $params);
    }

    public static function getStatistics()
    {
        $current_date = Date('Y-m-d');
        $stats = array();
        $stats['total'] = Audio::find()->count() + Movie::find()->count() + Event::find()->count();
        $stats['today'] = [
            'audio' => Audio::find()->where(['>=', 'date_published', $current_date])->count(),
            'movie' => Movie::find()->where(['>=', 'date_published', $current_date])->count(),
            'event' => Event::find()->where(['>=', 'date_published', $current_date])->count()
        ];
        $stats['today']['total'] = $stats['today']['audio'] + $stats['today']['movie'] + $stats['today']['event'];
        return $stats;
    }
}
