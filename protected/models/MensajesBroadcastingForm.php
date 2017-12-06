<?php

Class MensajesBroadcastingForm extends CFormModel
{
	//Tipo ---> 1. Periodo / 2. Diario / 3. Personalizado

	public $id;
	public $mensaje;
	public $tipo_mensaje;
	public $fecha_inicio;
	public $fecha_fin;
	public $hora_inicio;
	public $hora_fin;
	public $dias;
	

	public function rules()
	{
		return array(
			array("mensaje, tipo_mensaje", "required", "message"=>"{attribute} requerido"),
			array('tipo_mensaje', 'numerical', 'integerOnly'=>true),
			//array('mensaje', 'length', 'max'=>900),
			array('dias, fecha_inicio, fecha_fin, hora_inicio, hora_fin', 'safe'),
			array('fecha_inicio, fecha_fin', 'date', 'format'=>'yyyy-M-d'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_mensaje, mensaje, fecha_inicio, fecha_fin, hora_inicio, hora_fin, tipo_mensaje', 'safe', 'on'=>'search'),
			array('tipo_mensaje', 'validarRango')
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_mensaje' => 'Id Mensaje',
			'mensaje' => 'Mensaje',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
			'tipo_mensaje' => 'Tipo Mensaje',
			'dias' => ''
		);
	}

	public function validarRango($attribute, $params)
	{
		if ($this->$attribute == 1) //Periodo
		{
			if ($this->fecha_inicio == "0000-00-00")
            {
            	$this->addError($attribute, "La fecha inicio debe ser diferente de '0000-00-00'");
            } 
            else if($this->fecha_fin == "0000-00-00")
            {
            	$this->addError($attribute, "La fecha fin debe ser diferente de '0000-00-00'");
            } 
            else if($this->fecha_inicio > $this->fecha_fin)
            {
            	$this->addError($attribute, "La fecha fin debe ser mayor o igual a la fecha inicio");
            } 
            else if($this->fecha_inicio == $this->fecha_fin && strtotime($this->hora_inicio) > strtotime($this->hora_fin))
            {
            	$this->addError($attribute, "La hora fin debe ser mayor a la hora inicio");
            }
		}
		else if ($this->$attribute == 2) //Diario
		{
			if(strtotime($this->hora_inicio) >= strtotime($this->hora_fin))
            {
            	$this->addError($attribute, "La hora fin debe ser mayor a la hora inicio");
            }
		}
		else if ($this->$attribute == 3) //Personalizado
		{
			if(strtotime($this->hora_inicio) >= strtotime($this->hora_fin))
            {
                $this->addError($attribute, "La hora fin debe ser mayor a la hora inicio");
            } 
            else if(COUNT($this->dias) == 0)
            {
                $this->addError($attribute, "Debe seleecionar los dias de suspensión");
            }
		}
	}
}
?>
