<?php
/**
 * @var yii\web\View $this
 * @var app\models\Workflow $model
 */

use app\models\Transition;
use yii\helpers\Html;
use raoul2000\workflow\view\WorkflowViewWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use components\WorkflowDbSource;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Workflow', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="workflow-default-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . 'Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Are you sure?',
                'data-method' => 'post',
            ]) ?> 
        </div>
    </h1>

    <div class="row">
        <div class="col-md-6">
            <?php
            $sortables = [];
            foreach ($model->statuses as $status) {
                $actions = [];
                $actions[] = '<span class="glyphicon glyphicon-move sortable-handle" style="cursor: move"></span>';
                if ($model->initial_status_id != $status->id) {
                    $actions[] = Html::a('<span class="glyphicon glyphicon-star"></span>', ['initial', 'id' => $model->id, 'status_id' => $status->id], ['title' => 'Set Initial']);
                }
                $actions[] = Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['status/update', 'id' => $status->id, 'workflow_id' => $status->workflow_id], ['title' => 'Update']);
                $actions[] = Html::a('<span class="glyphicon glyphicon-trash"></span>', ['status/delete', 'id' => $status->id, 'workflow_id' => $status->workflow_id], [
                    'title' => 'Delete',
                    'data-confirm' => 'Are you sure?',
                    'data-method' => 'post',
                ]);
                $transitions = $status->startTransitions ? '<br><small><span class="glyphicon glyphicon-chevron-right"></span>&nbsp; &nbsp;' . implode(', ', ArrayHelper::map($status->startTransitions, 'end_status_id', 'endName')) . '</small>' : '';
                $metadatas = $status->metadatas ? '<br><small><span class="glyphicon glyphicon-tags"></span>&nbsp; &nbsp;' . Json::encode(ArrayHelper::map($status->metadatas, 'key', 'value')) . '</small>' : '';
                $sortables[] = [
                    'content' => '<div class="pull-right">' . implode(' ', $actions) . '</div>' . $status->name . $transitions . $metadatas,
                    'options' => [
                        'id' => 'Status_' . $status->id,
                        'class' => 'list-group-item',
                    ],
                ];
            }
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'value' => Html::tag('span', $model->id, ['class' => 'label label-default', 'style' => 'color:#fff;background:' . $model->getColor()]),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'color',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'initial_status_id',
                        'value' => $model->initial_status_id,
                    ],
                    [
                        'label' => 'Status' . '<br>' . Html::a('Create Status', ['status/create', 'workflow_id' => $model->id], ['class' => 'btn btn-success btn-xs']),
                        'value' => Sortable::widget([
                            'items' => $sortables,
                            'options' => [
                                'class' => 'list-group',
                                'style' => 'margin-bottom:0;',
                            ],
                            'clientOptions' => [
                                'axis' => 'y',
                                'update' => new JsExpression("function(event, ui){
                                    $.ajax({
                                        type: 'POST',
                                        url: '" . Url::to(['sort', 'id' => $model->id]) . "',
                                        data: $(event.target).sortable('serialize') + '&_csrf=" . Yii::$app->request->getCsrfToken() . "',
                                        success: function() {
                                            location.reload();
                                        }
                                    });
                                }"),
                            ],
                        ]),
                        'format' => 'raw',
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-md-6">
            <?php
            if ($model->statuses) {
                echo WorkflowViewWidget::widget([
                    'workflow' => Yii::$app->workflowSource->getWorkflow($model->id),
                    'containerId' => 'workflowView'
                ]);
                echo '<div id="workflowView" style="height: 400px;"></div>';
            }
            ?>
        </div>
    </div>

    <?php if ($model->statuses) { ?>
        <?= Html::beginForm(); ?>
        <h2><?= 'Transitions' ?></h2>
        <table class="table table-bordered table-condensed">
            <tr>
                <th colspan="2" rowspan="2"></th>
                <th class="text-center" colspan="<?= count($model->statuses) ?>"><?= 'End Status' ?></th>
            </tr>
            <tr>
                <?php foreach ($model->statuses as $endStatus) { ?>
                    <th class="text-center">
                        <?= $endStatus->name ?>
                    </th>
                <?php } ?>
            </tr>
            <?php foreach ($model->statuses as $k => $startStatus) { ?>
                <tr>
                    <?php if (!$k) { ?>
                        <th class="text-center" rowspan="<?= count($model->statuses) ?>"><?= 'Start Status' ?></th>
                    <?php } ?>
                    <th class="text-right"><?= $startStatus->name ?></th>
                    <?php foreach ($model->statuses as $endStatus) { ?>
                        <td class="text-center">
                            <?php
                            $options = ['uncheck' => 0];
                            if ($startStatus->id == $endStatus->id) {
                                unset($options['uncheck']);
                                $options['disabled'] = true;
                            }
                            $transition = Transition::findOne(['workflow_id' => $model->id, 'start_status_id' => $startStatus->id, 'end_status_id' => $endStatus->id]);
                            echo Html::checkbox('Status[' . $startStatus->id . '][' . $endStatus->id . ']', $transition ? true : false, $options);
                            ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::endForm(); ?>
    <?php } ?>

</div>