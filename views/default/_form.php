<?php
/**
 * @var yii\web\View $this
 * @var cornernote\workflow\manager\models\Workflow $model
 * @var ActiveForm $form
 */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>

<div class="workflow-default-form">

    <?php $form = ActiveForm::begin([
        'id' => ' Workflow',
        'enableClientValidation' => false,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]) ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' . ($model->isNewRecord ? 'Create' : 'Save'), [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
    ]) ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

</div>