<?php

Class ConfiguracionSistemaAccionesForm extends CFormModel
{
	public $valor;

	public function rules()
	{
		return array(
			//Required
			array("valor", "required","message"=>"{attribute} requerido"),
			//updateSCInSMS
			array('valor', 'numerical', 'min'=>6, 'max'=>158, 'integerOnly'=>true, "on"=>"updateSCInSMS"),
		);
	}

	public function attributeLabels()
	{
		return array(
			'valor' => 'Valor',
		);
	}
}

?>