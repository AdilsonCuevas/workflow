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
 * @property int $idwfFlujo Identificador único de la transaccion de flujo
 * @property int $idwfWorkflow identificador unico del flujo de trabajo
 * @property int $start_idwfProceso identificador del proceso inical
 * @property int $end_idwfProceso identificador del proceso final
*/

namespace app\models;

use yii\db\ActiveRecord;

class WfFlujo extends ActiveRecord
{
    /**
     * @return string El nombre de la tabla referenciada
     */
    public static function tableName() : string
    {
        return 'wfFlujo';
    }

        /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idwfWorkflow', 'start_idwfProceso', 'end_idwfProceso'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idwfFlujo' => 'Identificador único de la transaccion de flujo',
            'idwfWorkflow' => 'identificador unico del flujo de trabajo',
            'start_idwfProceso' => 'identificador del proceso inical',
            'end_idwfProceso' => 'identificar del proceso final',
        ];
    }
}