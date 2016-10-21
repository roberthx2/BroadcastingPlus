<?php
Class PromocionForm extends CFormModel
{
	//Tipo ---> 1. BCNL / 2. BCP / 3. CPEI
	public $tipo;
	public $id_cliente;
	public $nombre;
	public $mensaje;
	public $fecha;
	public $hora_inicio;
	public $hora_fin;
	public $destinatarios;
	public $listas;
	public $btl;
	public $puertos;

	public function rules()
	{
		return array(
			//Required
			array("id_cliente, nombre, mensaje, fecha, hora_inicio, hora_fin", "required", "message"=>"{attribute} requerido", "on"=>"create"),
			//Length
			array('nombre', 'length', 'max'=>30),
			array('mensaje', 'length', 'max'=>158),
			//Safe
			//array("id_usuario", "safe"),
			//array("nombre", "safe", "on"=>"agregarNumeros"),
			//Filter
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),
			array("destinatarios","filter","filter"=>array($this, "limpiarNumeros")),
			//Validaciones
			array("nombre", "ext.ValidarNombre", "on"=>"create"), //Valida los caracteres
			array("destinatarios", "ext.ValidarNumerosTexarea"), //Valida los caracteres
			//array("nombre", "existe", "usuario"=>$this->id_usuario)
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_cliente' => 'Cliente',
			'nombre' => 'Nombre',
			'mensaje' => 'Mensaje',
			'fecha' => 'Fecha',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
			'destinatarios' => 'Destinatarios',
			'listas' => 'Listas',
			'btl' => 'BTL',
			'puertos' => 'Puertos',
		);
	}

	public function existe($attribute, $params)
	{
		if ($this->id_usuario == "")
			$id_usuario = Yii::app()->user->id;
		else
			$id_usuario = $this->id_usuario;

		$model = Lista::model()->find("id_usuario =? AND LOWER(nombre) =?", array($id_usuario, $this->$attribute));
		
		if($model != null)
			$this->addError($attribute, "El nombre de la lista ya existe");	
	}

	public function limpiarNombre($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
	}

	public function limpiarNumeros($cadena)
	{
		return Yii::app()->Funciones->limpiarNumerosTexarea($cadena);
	}
}
?>
