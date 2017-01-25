<?php

Class Btl extends CFormModel
{
	public $password;
	public $id_usuario;
	public $sc;
	public $productos;
	public $fecha_inicio;
	public $fecha_fin;
	public $operadoras;
	public $all_operadoras;

	public function rules()
	{
		return array(
			// username and password are required
			array('password', 'required', 'message'=>'{attribute} requerido', 'on'=>'authenticate'),
			// password needs to be authenticated
			array('password', 'authenticate', 'on'=>'authenticate'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'password' => 'Contraseña',
			'sc' => 'Short Code',
			'productos' => 'Productos',
			'fecha_ini' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'operadoras' => 'Operadoras',
			'all_operadoras' => 'Todas',
		);
	}

	public function authenticate($attribute, $params)
	{
		$model = UsuarioMasivo::model()->find("id_usuario =? AND pwd =?", array(Yii::app()->user->id, md5($this->$attribute)));

		if (!$model)
		{
			$this->addError($attribute, "La contraseña es incorrecta");
		}
	}
}

?>