<?php

namespace app\controllers;

use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use app\models\Item;
use app\models\Audio;
use app\models\Movie;
use app\models\Event;
use app\models\Manager;

class SiteController extends Controller
{
    public $layout = false;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $types = Yii::$app->request->get('types', ['movie', 'audio', 'event']);
        $sort = Yii::$app->request->get('sort', SORT_DESC);
        $items = Manager::findItems($types);
        $stats = Manager::getStatistics();
        return $this->render('default', ['items' => $items, 'types' => $types, 'sort' => $sort, 'stats' => $stats]);
    }
}