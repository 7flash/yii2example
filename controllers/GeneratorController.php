<?php
namespace app\controllers;

use yii\console\Controller;
use app\models\Manager;

class GeneratorController extends Controller
{
    private $preparedDataFile = 'prepared_data.json';
    private $timeoutInSeconds = 10;

    public function actionIndex()
    {
        $items_json = file_get_contents($this->preparedDataFile);
        $items = json_decode($items_json, true);
        shuffle($items);
        while (true) {
            if (empty($items)) {
                break;
            }
            $item = array_shift($items);
            print_r($item);
            Manager::createItem($item['type'], $item);
            sleep($this->timeoutInSeconds);
        }
        return 0;
    }
}