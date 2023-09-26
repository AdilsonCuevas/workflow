<?php
/*
 * @var yii\web\View $this
 */

use app\models\Workflow;
use yii\bootstrap5\Nav;
use yii\helpers\Html;

$this->title = 'workflow';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-default-index">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?php
    $items = [
        [
            'label' => '<span class="glyphicon glyphicon-plus"></span> ' . 'Create',
            'url' => ['create'],
            'encode' => false,
        ],
    ];
    foreach (Workflow::find()->orderBy(['id' => SORT_ASC])->all() as $workflow) {
        /** @var Workflow $workflow */
        $items[] = [
            'label' => $workflow->id,
            'url' => ['view', 'id' => $workflow->id],
            'linkOptions' => ['style' => 'color:#fff;background:' . $workflow->getColor()],
        ];
    }
    echo Nav::widget([
        'items' => $items,
        'options' => ['class' => 'nav-pills'],
    ]);
    ?>

</div>