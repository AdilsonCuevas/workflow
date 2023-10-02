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
 * This is the model class for table "wfproceso".
 *
 * @property int $idwfProceso Identificador único del proceso
 * @property int $idwfWorkflow identificador del flujo de trabajo
 * @property int $nameradiTransaccion nombre del proceso establecido
 * @property int $order_wfProceso orden del proceso dentro del flujo de trabajo
 * @property int $estadoWfProceso Estado de ejecucion del proceso, 10 activo 0 Inactivo
*/

namespace app\models;

use yii\db\ActiveRecord;

class WfProceso extends ActiveRecord
{
    public static function tableName()
    {
        return "wfProceso"; 
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idwfWorkflow', 'nameradiTransaccion'], 'required'],
            [['order_wfProceso', 'estadoWfProceso'], 'integer'],
            [['nameradiTransaccion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idwfProceso' => 'Identificador único del proceso',
            'idwfWorkflow' => 'identificador del flujo de trabajo',
            'nameradiTransaccion' => 'nombre del proceso establecido',
            'order_wfProceso' => 'orden del proceso dentro del flujo de trabajo',
            'estadoWfProceso' => 'Estado de ejecucion del proceso, 10 activo 0 Inactivo',
        ];
    }

}