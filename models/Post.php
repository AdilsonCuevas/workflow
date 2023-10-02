<?php

namespace app\models;
/**
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $status column used to store the status of the post
 */
class Post extends \yii\db\ActiveRecord
{
    
    public function behaviors()
    {
        return [
            'class'                    => '\raoul2000\workflow\base\SimpleWorkflowBehavior',

            // model attribute to store status
            'statusAttribute'          => 'col_status',

            // workflow source component name
            'source'                   => 'my_workflow_source',

            'defaultWorkflowId'        => 'MyWorkflow',
            'statusConverter'          => null,
            'statusAccessor'           => null,

            // Event Sequence Component Name
            'eventSequence'            => 'eventSequence',

            'propagateErrorsToModel'   => false,
            'stopOnFirstInvalidEvent'  => true,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['col_status'], 'required'],
            [['col_status'], 'string', 'max' => 32],
            [['radicado'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'identificador unico',
            'radicado' => 'workflow identificador',
            'col_status' => 'estado',
        ];
    }
}