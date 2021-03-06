<?php
Class ListaForm extends CFormModel
{
	public $id_usuario;
	public $nombre;
	public $numeros;

	public function rules()
	{
		return array(
			//Required
			array("nombre, numeros", "required","message"=>"{attribute} requerido", "on"=>"create"),
			array("numeros", "required","message"=>"{attribute} requerido", "on"=>"agregarNumeros"),
			//Length
			array('nombre', 'length', 'max'=>30),
			//Safe
			array("id_usuario", "safe"),
			//array("nombre", "safe", "on"=>"agregarNumeros"),
			//Filter
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),
			array("numeros","filter","filter"=>array($this, "limpiarNumeros")),
			//Validaciones
			array("nombre", "ext.validator.Nombre", "on"=>"create"), //Valida los caracteres
			array("numeros", "ext.validator.NumerosTexarea"), //Valida los caracteres
			array("nombre", "existe", "usuario"=>$this->id_usuario)
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Usuario',
			'nombre' => 'Nombre',
			'numeros' => 'Números',
		);
	}

	public function existe($attribute,$params)
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