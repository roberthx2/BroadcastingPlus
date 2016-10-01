<?php
Class ListaForm extends CFormModel
{
	public $id_usuario;
	public $nombre;
	public $numeros;

	public function rules()
	{
		return array(
			array("nombre, numeros", "required"),
			array("id_usuario", "safe"),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_usuario' => 'Usuario',
			'nombre' => 'Nombre',
			'numeros' => 'Numeros',
		);
	}
}

?>