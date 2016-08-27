<?php
namespace app\models;

class Manager
{
    public static function findItems($types)
    {
        $items = array();
        if (empty($types)) {
            $items = array_merge(Movie::find()->all(), Audio::find()->all(), Event::find()->all());
        } else {
            if (in_array('movie', $types)) {
                $items = array_merge($items, Movie::find()->all());
            }
            if (in_array('audio', $types)) {
                $items = array_merge($items, Audio::find()->all());
            }
            if (in_array('event', $types)) {
                $items = array_merge($items, Event::find()->all());
            }
        }
        return $items;
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
