<?php
Class PromocionPersonalizadaForm extends CFormModel
{
	//Tipo ---> 1. BCNL / 2. BCP / 3. CPEI
	public $tipo;
	public $id_cliente;
	public $nombre;
	public $fecha;
	public $hora_inicio;
	public $hora_fin;
	public $duracion;
	public $puertos;
	public $all_puertos;
	public $sc_bcp;
	public $archivo;

	public function rules()
	{
		return array(
			//Required
			array("tipo, id_cliente, nombre, fecha, hora_inicio, hora_fin, duracion", "required", "message"=>"{attribute} requerido"),
			//Length
			array('nombre', 'length', 'max'=>25),
			//Archivo
			array('archivo', 'file', 'allowEmpty' => true, 'types'=>'txt', 'wrongType'=>'La extenxion del archivo debe ser *.txt'),
			//Safe
			array("prefijo, puertos, fecha_inicio, fecha_fin, sc_bcp", "safe"),
			//array("prefijo, puertos, destinatarios, listas", "safe"),
			array('all_puertos', 'boolean'),
			array('fecha', 'date', 'format'=>'yyyy-M-d'),
			//Filter
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),
			//Validaciones
			//Nombre
			array("nombre", "ext.ValidarNombre"), //Valida los caracteres
			array("nombre", "existe"), //Valida si existe el nombre de la promoción segun su tipo
			array("hora_fin", "horaActual"), //Valida que la hora fin sea mayor que la hora actual
			array("hora_inicio, hora_fin", "compararHoras"), //Valida que la hora inicio sea menor que la hora fin
			array("hora_inicio, hora_fin", "horarioPermitido"), //Valida que la hora este en el rango permitido para la carga de promociones
			array("puertos", "puertosSeleccionados"), //Valida que se seleccione por lo menos 1 puerto
			array("sc_bcp", "validarScBCP"),
			
		);
	}

	public function attributeLabels()
	{
		return array(
			'tipo' => 'Tipo',
			'id_cliente' => 'Cliente',
			'nombre' => 'Nombre',
			'fecha' => 'Fecha',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
			'puertos' => 'Puertos',
			'all_puertos' => 'Todos',
			'duracion' => 'Duración',
			'sc_bcp' => 'Short Code',
			'archivo' => 'Archivo'
		);
	}

	public function limpiarNombre($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
	}

	public function existe($attribute, $params)
	{
		if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			if ($this->tipo == 1)
			{
				$pref = "BCNL";
			}
			else 
			{
				$pref = "CPEI";
				$this->fecha = date("Y-m-d");
			}

			$criteria = new CDbCriteria;
			$criteria->select = "SUBSTRING(iniciales_cliente, 1, 4) AS iniciales_cliente";
			$criteria->compare("id_cliente", $this->id_cliente);
			$cliente = ClienteSms::model()->find($criteria);
			$nombre_completo = strtoupper(str_replace(" ", "_", str_replace("-", "", $this->fecha)."_".$pref."_".$cliente->iniciales_cliente."_".$this->$attribute));
			
			$model = Promociones::model()->find("fecha =? AND cliente =? AND nombrePromo =?", array($this->fecha, $this->id_cliente, $nombre_completo));
		}
		else if ($this->tipo == 3) //BCP
		{
			$criteria = new CDbCriteria;
            $criteria->select = "DISTINCT descripcion";
            $criteria->group = "id_operadora_bcnl";
            $operadoras = OperadorasRelacion::model()->findAll($criteria);

			$criteria = new CDbCriteria;
			$criteria->select = "SUBSTRING(iniciales_cliente, 1, 4) AS iniciales_cliente";
			$criteria->compare("id_cliente", $this->id_cliente);
			$cliente = ClienteSms::model()->find($criteria);

			foreach ($operadoras as $value)
			{
				$nombre_completo = preg_replace('/_{2,}/', "_",strtoupper(str_replace(" ", "_", str_replace("-", "", $this->fecha)."_BCP_".$cliente->iniciales_cliente."_".$this->sc_bcp."_".$this->$attribute)))."_".$value->descripcion;

				$criteria = new CDbCriteria;
				$criteria->select = "id_promo";
				$criteria->condition = "t.fecha = '".$this->fecha."'";
				$criteria->condition .= " AND (t.nombrePromo LIKE '".$nombre_completo."%') ";
				$model = PromocionesPremium::model()->find($criteria);

				if($model != null)
				{
					$this->addError($attribute, "El nombre de la promoción ya existe");
					break;	
				}
			}
			
		}
	}

    public function horaActual($attribute, $params)
    {
    	if ($this->tipo == 1 || $this->tipo == 3) //BCNL o BCP
    	{
	    	if (strtotime($this->$attribute) < strtotime(date("H:i")))
	    	{
	    		$this->addError($attribute, "La hora fin debe ser mayor que la hora actual");
	    	}
	    }
    }

    public function compararHoras($attribute, $params)
    {
    	if (strtotime($this->hora_inicio) == strtotime($this->hora_fin))
    	{
    		$this->addError($attribute, "La hora inicio y hora fin deben ser diferentes");
    	}
    	else if (strtotime($this->hora_inicio) > strtotime($this->hora_fin))
    	{
    		$this->addError($attribute, "La hora inicio debe ser mayor que la hora fin");
    	}
    }

    public function horarioPermitido($attribute, $params)
    {
    	if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			$criteria = new CDbCriteria;
			$criteria->select = "propiedad, valor";
			$criteria->addInCondition("propiedad", array('hora_inicio_bcnl', 'hora_fin_bcnl'));
			$resultado = ConfiguracionSistema::model()->findAll($criteria);
			
			foreach ($resultado as $value)
			{
				if ($value["propiedad"] == 'hora_inicio_bcnl')
					$hora_inicio = $value["valor"];
				else if ($value["propiedad"] == 'hora_fin_bcnl')
					$hora_fin = $value["valor"];
			}
		}
	    else if ($this->tipo == 3) //BCP
		{
			$criteria = new CDbCriteria;
			$criteria->select = "propiedad, valor";
			$criteria->addInCondition("propiedad", array('hora_inicio_bcp', 'hora_fin_bcp'));
			$resultado = ConfiguracionSistema::model()->findAll($criteria);
			
			foreach ($resultado as $value)
			{
				if ($value["propiedad"] == 'hora_inicio_bcp')
					$hora_inicio = $value["valor"];
				else if ($value["propiedad"] == 'hora_fin_bcp')
					$hora_fin = $value["valor"];
			}
		}

		if (strtotime($this->$attribute) < strtotime($hora_inicio) || strtotime($this->$attribute) > strtotime($hora_fin))
		{
			$hora_inicio = new DateTime($hora_inicio);
			$hora_inicio = $hora_inicio->format("h:i a");

			$hora_fin = new DateTime($hora_fin);
			$hora_fin = $hora_fin->format("h:i a");
			
			$this->addError($attribute, "El horario permitido para el envio de promociones es de : ".$hora_inicio." a ".$hora_fin);
		}
    }

    public function puertosSeleccionados($attribute, $params)
    {
    	if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			if (COUNT($this->$attribute) == 0 && $this->all_puertos == 0)
			{
				$this->addError($attribute, "Debe seleccionar sus puertos");
			}
			else if	($this->all_puertos == 1)
			{
				$sql = "SELECT puertos FROM usuario WHERE id_usuario = ".Yii::app()->user->id;
                $puertos_tmp = Yii::app()->db->createCommand($sql)->queryRow();

                if ($puertos_tmp["puertos"] == "")
                {
             		$this->addError($attribute, "No posee puertos asociados");   	
                }
			}
		}
    }

    public function validarScBCP($attribute, $params)
    {
    	if ($this->tipo == 3)
    	{
    		if ($this->$attribute == null || $this->$attribute == "")
	    	{
	    		$this->addError($attribute, "No ha seleccionado ningún short code");
	    	}		
    	}
    }
}
?>
