<?php
use yii\bootstrap\BaseHtml;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use app\assets\AppAsset;
use yii\widgets\Pjax;

AppAsset::register($this);

$dataProvider = new ActiveDataProvider(['query' => $itemsQuery, 'pagination' => ['pageSize' => 10], 'sort' => ['attributes' => ['date'], 'defaultOrder' => ['date' => (int)$sort]]]);
$models = $dataProvider->getModels();
$pagination = $dataProvider->getPagination();
?>
<?php $this->beginPage() ?>
    <!doctype html>
    <html>
    <head>
        <title>Yii2Example</title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="container">
        <?php Pjax::begin(); ?>
        <?php echo BaseHtml::beginForm(['site/index'], 'get', ['data-pjax' => '']); ?>
        <div class="row">
            <div class="col-xs-4"><h1>Лента событий</h1></div>
            <div class="col-xs-4"><?php echo Html::submitInput('Обновить'); ?></div>
            <div class="col-xs-4">
                <?php
                Modal::begin([
                    'header' => '<h2>Статистика</h2>',
                    'toggleButton' => [
                        'label' => 'Статистика',
                    ]
                ]);
                ?>
                За день: <?= $stats['today']['total']; ?><br>
                &nbsp;&nbsp;&nbsp;Аудио: <?= $stats['today']['audio']; ?><br>
                &nbsp;&nbsp;&nbsp;Видео: <?= $stats['today']['movie']; ?><br>
                &nbsp;&nbsp;&nbsp;Событий: <?= $stats['today']['event']; ?>
                <hr>
                Всего: <?= $stats['total']; ?>
                <?php
                Modal::end();
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?php
                echo Html::checkboxList('types', $types, ['movie' => 'Видео', 'audio' => 'Аудио', 'event' => 'События']);
                echo Html::radioList('sort', $sort, [SORT_DESC => 'Нисходящий', SORT_ASC => 'Восходящий']);
                ?>
            </div>
        </div>
        <?php echo BaseHtml::endForm(); ?>
        <?php
        foreach ($models as $model) {
            echo $this->render($model['type'], ArrayHelper::toArray($model));
        }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <?php
                echo LinkPager::widget(['pagination' => $pagination]);
                ?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>