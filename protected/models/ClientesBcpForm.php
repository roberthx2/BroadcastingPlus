<?php

class ClientesBcpForm extends CFormModel
{
	public $id_cliente;
	public $sc;
	//public $operadoras;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('id_cliente, sc', 'required'),
			//array('id_cliente_bcp, id_cliente_sms, sc, id_operadora, alfanumerico', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cliente' => 'Cliente',
			'sc' => 'Short Code',
			//'operadoras' => 'Operadoras',
		);
	}

}
