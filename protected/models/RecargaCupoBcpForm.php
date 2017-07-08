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

}
