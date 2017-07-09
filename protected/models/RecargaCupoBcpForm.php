<?php

class RecargaCupoBcpForm extends CFormModel
{
	public $id_usuario;
	public $cantidad;

	//public $operadoras;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('cantidad', 'required'),
			array('cantidad', 'numerical', 'min'=>1, 'integerOnly'=>true),
			array('cantidad', 'maximo')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Usuario',
			'cantidad' => 'Cantidad',
		);
	}

	public function maximo($attribute, $params)
	{
		if ($this->id_usuario != "")
            $id_usuario = $this->id_usuario;
        else 
            $id_usuario = Yii::app()->user->id;

        $criteria = new CDbCriteria;
        $criteria->select = "valor";
        $criteria->compare('propiedad', 'usuarios_master');
        $model_conf = ConfiguracionSistema::model()->find($criteria);
        $array_admin = explode(",", $model_conf->valor);
        
        $cantidad_maxima = CupoController::actionMaximoMontoBcp($id_usuario);
        
        if( ($this->$attribute <= $cantidad_maxima) || ($this->$attribute > $cantidad_maxima && in_array(Yii::app()->user->id, $array_admin)) )
        {

        }
        else
        {
        	$this->addError($attribute, "Debe ingresar una cantidad menor o igual al monto máximo a recargar");
        }
	}

}
