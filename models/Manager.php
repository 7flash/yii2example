<?php
namespace app\models;

use yii\db\Expression;
use yii\db\Query;

class Manager
{
    public static function findItems($types)
    {
        $fields = array();
        $queries = array();
        $activeRecords = ['audio' => 'app\models\Audio', 'event' => 'app\models\Event', 'movie' => 'app\models\Movie'];
        foreach ($types as $type) {
            if (isset($activeRecords[$type])) {
                $activeRecord = $activeRecords[$type];
                $typeFields = $activeRecord::getTableSchema()->getColumnNames();
                $fields[$activeRecord] = $typeFields;
            }
        }
        $originalFields = $fields;
        foreach ($originalFields as $type => $typeFields) {
            foreach ($originalFields as $anotherTypeFields) {
                $diffFields = array_diff($anotherTypeFields, $typeFields);
                foreach ($diffFields as $diffField) {
                    $expression = new Expression("NULL as `$diffField`");
                    array_push($fields[$type], $expression);
                    array_push($typeFields, $diffField);
                }
            }
            $typeItem = array_search($type, $activeRecords);
            $typeExpression = new Expression("'$typeItem' as `type`");
            array_push($fields[$type], $typeExpression);
        }
        foreach ($fields as $activeRecord => $typeFields) {
            $queries[] = $activeRecord::find()->select($typeFields);
        }
        $firstQuery = array_shift($queries);
        $unionQuery = array_reduce($queries, function ($previousQuery, $currentQuery) {
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
