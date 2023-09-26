<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sw_metadata".
 *
 * @property string $workflow_id
 * @property string $status_id
 * @property string $key
 * @property string $value
 *
 * @property Status $status
 * @property Workflow $workflow
 */
class Metadata extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sw_metadata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['workflow_id', 'status_id'], 'string', 'max' => 32],
            [['key'], 'string', 'max' => 64],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'workflow_id' => 'unico identidicador',
            'status_id' => "estado del metadata",
            'key' => 'llave del metadata',
            'value' => 'valor del metadata',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id'])->andWhere(['workflow_id' => $this->workflow_id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::className(), ['id' => 'workflow_id']);
    }
}