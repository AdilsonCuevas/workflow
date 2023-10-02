<?php
/**
 * Que es este módulo o Archivo
 *
 * Descripcion Larga
 *
 * @category     Gestion Documental
 * @package      Orfeo NG 
 * @subpackage   XXXX 
 * @author       Skina Technologies SAS (http://www.skinatech.com)
 * @license      Mixta <https://orfeolibre.org/inicio/licencia-de-orfeo-ng/>
 * @license      ./LICENSE.txt
 * @link         http://www.orfeolibre.org
 * @since        Archivo disponible desde la version 1.0.0
 *
 * @copyright    2023 Skina Technologies SAS
 */

/**
 * This is the model class for table "workflow".
 *
 * @property int $idwfWorkflow Identificador único del flujo de trabajo
 * @property int $idRadiRadicado identificador del radicado que se le crea el flujo de trabajo
 * @property int $descripcion descripcion del flujo de trabajo
 * @property int $creacionWorkflow fecha de creacion del flujo de trabajo
 * @property int $estadowfWorkflow Estado del flujo de trabajo, 10 activo 0 Inactivo
*/

namespace app\models;

use yii\db\ActiveRecord;

/**
 *  Modelo para operar con la tabla gaWorkflow
 */
class WfWorkflow extends ActiveRecord
{
    /**
     * @return string El nombre de la tabla referenciada
     */
    public static function tableName() : string
    {
        return 'wfWorkflow';
    }

        /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idRadiRadicado', 'descripcion'], 'required'],
            [['estadowfWorkflow'], 'integer'],
            [['creacionWorkflow'], 'safe'],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idwfWorkflow' => 'Identificador único del flujo de trabajo',
            'idRadiRadicado' => 'identificador del radicado que se le crea el flujo de trabajo',
            'descripcion' => 'descripcion del flujo de trabajo',
            'creacionWorkflow' => 'fecha de creacion del flujo de trabajo',
            'estadowfWorkflow' => 'Estado del flujo de trabajo, 10 activo 0 Inactivo',
        ];
    }
}