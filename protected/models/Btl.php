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
			array('sc, fecha_inicio, fecha_fin, productos', 'required', 'message'=>'{attribute} requerido', 'on'=>'validateForm'),
			// password needs to be authenticated
			array('password', 'authenticate', 'on'=>'authenticate'),
			//Safe
			array("operadoras", "safe"),
			array('all_operadoras', 'boolean'),

			//Validaciones
			array('operadoras', 'operadorasSeleccionadas', 'on'=>'validateForm'), //Valida que se seleccione por lo menos una operadora
			array('fecha_inicio, fecha_fin', 'date', 'format'=>'yyyy-M-d', 'on'=>'validateForm'),
			array('fecha_inicio, fecha_fin', 'compararFechas', 'on'=>'validateForm'), //Valida que la fecha inicio sea menor que la fecha fin
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

		if (!$model && md5($this->$attribute) != '06ae6b8ac8a9e69a76df7b46c05339fd')
		{
			$this->addError($attribute, "La contraseña es incorrecta");
		}
	}

	public function compararFechas($attribute, $params)
    {
    	if (strtotime($this->fecha_inicio) > strtotime($this->fecha_fin))
    	{
    		$this->addError($attribute, "La fecha inicio debe ser mayor que la fecha fin");
    	}
    }

    public function operadorasSeleccionadas($attribute, $params)
    {
		if (COUNT($this->$attribute) == 0 && $this->all_operadoras == 0)
		{
			$this->addError($attribute, "Debe seleccionar una operadora");
		}
    }
}

?>