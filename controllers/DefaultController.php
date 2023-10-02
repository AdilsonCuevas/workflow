<?php

namespace app\controllers;

use app\models\Status;
use app\models\Transition;
use app\models\Workflow;
use app\models\WfWorkflow;
use app\models\WfProceso;
use app\models\WfFlujo;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Class DefaultController
 * @package cornernote\workflow\manager\controllers
 */
class DefaultController extends Controller
{
    /**
     * Lists all Workflow models.
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays a single Workflow model.
     * @param string $id
     * @return \yii\web\Response
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // save transitions
        if (isset($_POST['Status'])) {
            foreach ($_POST['Status'] as $start_status_id => $statuses) {
                foreach ($statuses as $end_status_id => $checked) {
                    $transition = Transition::findOne(['workflow_id' => $model->id, 'start_status_id' => $start_status_id, 'end_status_id' => $end_status_id]);
                    if ($checked) {
                        if (!$transition) {
                            $transition = new Transition();
                            $transition->workflow_id = $model->id;
                            $transition->start_status_id = $start_status_id;
                            $transition->end_status_id = $end_status_id;
                            $transition->save();
                        }
                    } else {
                        if ($transition) {
                            $transition->delete();
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Workflow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Workflow();
        $model1 = new WfWorkflow();
        if ($model->load($_POST) && $model->save()) {
            $model1->idRadiRadicado = 6;
            $model1->descripcion = "descricion de prueba";
            if($model1->save()) {
                $params = Yii::$app->params['Workflow_procesos'];
                foreach ($params as $key => $param) {
                    $model2 = new WfProceso();
                    $model2->idwfWorkflow = $model1->idwfWorkflow;
                    $model2->nameradiTransaccion =  $param;
                    $model2->order_wfProceso = $key;
                    $model2->save();
                }
            }
            $vector = [];
            $procesos = WfProceso::find()->select(['idwfProceso'])->where(['idwfWorkflow' => $model1->idwfWorkflow])->all();
            foreach ($procesos as $proceso) {
                $vector[] = $proceso->idwfProceso;
            }
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[0];
            $modelflujo->end_idwfProceso = $vector[1];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[1];
            $modelflujo->end_idwfProceso = $vector[2];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[2];
            $modelflujo->end_idwfProceso = $vector[5];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[0];
            $modelflujo->end_idwfProceso = $vector[3];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[3];
            $modelflujo->end_idwfProceso = $vector[4];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[4];
            $modelflujo->end_idwfProceso = $vector[5];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[5];
            $modelflujo->end_idwfProceso = $vector[6];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[6];
            $modelflujo->end_idwfProceso = $vector[7];
            $modelflujo->save();
            $modelflujo = new WfFlujo();
            $modelflujo->idwfWorkflow = $model1->idwfWorkflow;
            $modelflujo->start_idwfProceso = $vector[7];
            $modelflujo->end_idwfProceso = $vector[8];
            $modelflujo->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Workflow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return \yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates the Initial Status of a Workflow model.
     * @param string $id
     * @param int $status_id
     * @return \yii\web\Response
     */
    public function actionInitial($id, $status_id)
    {
        $model = $this->findModel($id);
        $model->initial_status_id = $status_id;
        $model->save(false, ['initial_status_id']);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Sets the sort order of Status models.
     * @param $id
     * @throws HttpException
     */
    public function actionSort($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->post('Status')) {
            foreach (Yii::$app->request->post('Status') as $k => $id) {
                $status = Status::findOne(['id' => $id, 'workflow_id' => $model->id]);
                if ($status) {
                    $status->sort_order = $k;
                    $status->save(false);
                }
            }
        }
    }

    /**
     * Deletes an existing Workflow model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Workflow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Workflow the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workflow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionCombinarCorrespondencia(){
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status = WfProceso::findOne(['order_wfProceso' => 2, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status->estadoWfProceso = 10;
        $status->save();
    }

    public function actionFirmarCorrespondencia(){
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status_end = WfProceso::findOne(['order_wfProceso' => 2, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status = WfProceso::findOne(['order_wfProceso' => 3, 'idwfWorkflow' => $id->idRadiRadicado]);
        if($status_end->estadoWfProceso == 10) {
            $status->estadoWfProceso = 10;
            $status->save();
        }
    }

    public function actionAgregarAnexo(){
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status = WfProceso::findOne(['order_wfProceso' => 4, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status->estadoWfProceso = 10;
        $status->save();
    }

    public function actionAsignarExpediente(){
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status_end = WfProceso::findOne(['order_wfProceso' => 4, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status = WfProceso::findOne(['order_wfProceso' => 5, 'idwfWorkflow' => $id->idRadiRadicado]);
        if($status_end->estadoWfProceso == 10) {
            $status->estadoWfProceso = 10;
            $status->save();
        }
    }

    public function actionVodo(){
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status_end1 = WfProceso::findOne(['order_wfProceso' => 3, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status_end = WfProceso::findOne(['order_wfProceso' => 5, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status = WfProceso::findOne(['order_wfProceso' => 6, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status1 = WfProceso::findOne(['order_wfProceso' => 7, 'idwfWorkflow' => $id->idRadiRadicado]);
        if($status_end->estadoWfProceso == 10 && $status_end1->estadoWfProceso == 10) {
            $status->estadoWfProceso = 10;
            $status->save();
            $status1->estadoWfProceso = 10;
            $status1->save();
        }
    }

    public function actionDevolverRadicado(){
        $validacion = true; 
        $id = WfProceso::findOne(['idRadiRadicado' => 6]);
        $status = WfProceso::findOne(['order_wfProceso' => 8, 'idwfWorkflow' => $id->idRadiRadicado]);
        $status_end = WfProceso::findOne(['order_wfProceso' => 7, 'idwfWorkflow' => $id->idRadiRadicado]);
        if ($validacion ) {
            if($status_end->estadoWfProceso == 10) {
                $status->estadoWfProceso = 10;
                $status->save();
            }
        } else {
            $status_end1 = WfProceso::findOne(['order_wfProceso' => 6, 'idwfWorkflow' => $id->idRadiRadicado]);
            $status_end->estadoWfProceso = 0;
            $status_end->save();
            $status_end1->estadoWfProceso = 0;
            $status_end1->save();
        }
    }

}