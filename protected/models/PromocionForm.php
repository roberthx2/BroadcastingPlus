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
	public $duracion;
	public $destinatarios;
	public $listas;
	public $btl;
	public $puertos;
	public $all_puertos;

	public function rules()
	{
		return array(
			//Required
			array("tipo, id_cliente, nombre, mensaje, fecha, hora_inicio, hora_fin, duracion", "required", "message"=>"{attribute} requerido"),
			//Length
			array('nombre', 'length', 'max'=>25),
			array('mensaje', 'length', 'max'=>158),
			//Safe
			array("puertos, destinatarios, listas, btl", "safe"),
			array('all_puertos', 'boolean'),
			array('fecha', 'date', 'format'=>'yyyy-M-d'),
			//Filter
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),
			array("mensaje","filter","filter"=>array($this, "limpiarMensaje")),
			array("destinatarios","filter","filter"=>array($this, "limpiarNumeros")),
			//Validaciones
			//Nombre
			array("nombre", "ext.ValidarNombre"), //Valida los caracteres
			array("nombre", "existe"), //Valida si existe el nombre de la promoción segun su tipo
			array("mensaje", "spam"), //Valida si el mensaje ya existe para el dia seleccionado
			array("mensaje", "palabrasObscenas"), //Valida si el mensaje contiuene palabras obscenas 
			array("mensaje", "scEnSMS"), //Valida que el Short Code este en el mensaje (Para clientes hipicos y loteros)
			array("mensaje", "numerosTelefonicos"), //Valida si existen numeros telefonicos o sc en el mensaje (Para clientes hipicos y loteros)
			array("hora_inicio, hora_fin", "compararHoras"), //Valida que la hora inicio sea menor que la hora fin
			array("hora_inicio, hora_fin", "horarioPermitido"), //Valida que la hora este en el rango permitido para la carga de promociones
			array("puertos", "puertosSeleccionados"), //Valida que se seleccione por lo menos 1 puerto
			array("destinatarios, listas, btl", "ingresarDestinatarios"), //Valida que se ingrese por lo menos 1 destinatario
			array("destinatarios", "ext.ValidarNumerosTexarea"), //Valida los caracteres
			
		);
	}

	public function attributeLabels()
	{
		return array(
			'tipo' => 'Tipo',
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
			'all_puertos' => 'Todos',
			'duracion' => 'Duración',
		);
	}

	public function limpiarNombre($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
	}

	public function limpiarMensaje($cadena)
	{
		return Yii::app()->Funciones->limpiarMensaje($cadena);
	}

	public function limpiarNumeros($cadena)
	{
		return Yii::app()->Funciones->limpiarNumerosTexarea($cadena);
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
			$cliente_alarmas = ClienteAlarmas::model()->find("id =? ", array($this->id_cliente));
			$criteria = new CDbCriteria;
			$criteria->select = "SUBSTRING(iniciales_cliente, 1, 4) AS iniciales_cliente";
			$criteria->compare("id_cliente", $cliente_alarmas->id_cliente_sms);
			$cliente = ClienteSms::model()->find($criteria);
			$nombre_completo = strtoupper(str_replace(" ", "_", str_replace("-", "", $this->fecha)."_BCP_".$cliente->iniciales_cliente."_".$cliente_alarmas->sc."_".$this->$attribute));

			$model = PromocionesPremium::model()->find("fecha =? AND id_cliente =? AND nombrePromo =?", array($this->fecha, $this->id_cliente, $nombre_completo));
		}
		
		if($model != null)
			$this->addError($attribute, "El nombre de la promoción ya existe");	
	}

	public function spam($attribute, $params)
	{
		if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			$model = null;
		}
		else if ($this->tipo == 3) //BCP
		{
			$model = PromocionesPremium::model()->find("fecha =? AND contenido LIKE ?", array($this->fecha, $this->$attribute));
		}

		if($model != null)
			$this->addError($attribute, "El mensaje ya existe para la fecha seleccionada por favor cambie su contenido ya que puede ser considerado como spam");	
	}

	public function palabrasObscenas($attribute, $params)
	{
		$sql = "SELECT group_concat(palabra separator '|') AS palabras FROM palabras_obscenas";
        $sql = Yii::app()->db->createCommand($sql)->queryRow();

        $palabras = strtolower($sql["palabras"]);

        $contenido = strtolower($this->$attribute);

        preg_match_all('('.$palabras.')', $contenido, $palabras_obscenas);
        
        if (count($palabras_obscenas[0]) > 0)
        {
            $palabras_obscenas = "<br>(".implode(",",$palabras_obscenas[0]).")";
            $this->addError($attribute, "El mensaje contiene palabras obscenas debe corregirlo para continuar ".$palabras_obscenas);
        }
	}

	public function scEnSMS($attribute, $params)
    {
    	if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			if (Yii::app()->Procedimientos->clienteIsHipicoLotero($this->id_cliente))
	    	{
        		$cadena_sc = Yii::app()->Procedimientos->getScClienteBCNL($this->id_cliente);
        		$cadena_sc = explode(",", $cadena_sc);

        		$sql = "SELECT valor FROM configuracion_sistema WHERE propiedad = 'sc_en_n_caracteres'";
		        $caracteres = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		        $mensaje = strtoupper(substr($this->$attribute, 0, $caracteres["valor"]));

		        preg_match_all('/[0-9]{3,8}/', $mensaje, $mensaje_partes);

		        $valido = false;

		        foreach ($cadena_sc as $value)
		        {
		        	if (in_array($value, $mensaje_partes[0]))
			        {
			        	$valido = true;
			            break;
			        }
		        }

		        if (!$valido)
		        {
		        	$this->addError($attribute, "El mensaje debe incluir su Short Code en los primeros ".$caracteres["valor"]." caracteres");
		        }
	    	}						
		}
		else if ($this->tipo == 3) //BCP
		{
	    	$cliente_alarmas = ClienteAlarmas::model()->find("id =? ", array($this->id_cliente));

	    	if (Yii::app()->Procedimientos->clienteIsHipicoLotero($cliente_alarmas->id_cliente_sms))
	    	{
		        $sql = "SELECT valor FROM configuracion_sistema WHERE propiedad = 'sc_en_n_caracteres'";
		        $caracteres = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		        $mensaje = strtoupper(substr($this->$attribute, 0, $caracteres["valor"]));

		        $tam_sc = strlen($cliente_alarmas->sc);

		        preg_match_all('/[0-9]{'.$tam_sc.'}|[A-Za-z]{'.$tam_sc.'}/', $mensaje, $mensaje_partes);

		        if (!in_array($cliente_alarmas->sc, $mensaje_partes[0]))
		        {
		            $this->addError($attribute, "El mensaje debe incluir el Short Code seleccionado en los primeros ".$caracteres["valor"]." caracteres");
		        }
		    }
		}
    }

    public function numerosTelefonicos($attribute, $params)
    {
    	if ($this->tipo == 1 || $this->tipo == 2) //BCNL / CPEI
		{
			if (Yii::app()->Procedimientos->clienteIsHipicoLotero($this->id_cliente))
	    	{
	    		$sql = "SELECT GROUP_CONCAT(cadena_sc) AS cadena_sc FROM usuario WHERE id_cliente = :id_cliente";
	    		$sql = Yii::app()->db_sms->createCommand($sql);
        		$sql->bindParam(":id_cliente", $this->id_cliente, PDO::PARAM_STR);
        		$cadena_sc = $sql->queryRow();

        		$cadena_sc = trim(preg_replace('/,{2,}/', ",", $cadena_sc["cadena_sc"]), ",");
        		
        		if ($cadena_sc == "")
        			$cadena_sc = "null";

        		$sql = "SELECT DISTINCT(sc_id) AS sc FROM sc_id WHERE id_sc IN(".$cadena_sc.")";
        		$sql_sc = Yii::app()->db_sms->createCommand($sql)->queryAll();

        		preg_match_all('/\d{7,}/', $this->$attribute, $mensaje_partes);
		        $mensaje_partes = array_unique($mensaje_partes[0]);
		        $posicion_arr[] = "";

		        foreach ($sql_sc as $value)
		        {
		        	$posicion = array_search($value["sc"], $mensaje_partes);
		        	
		        	if ($posicion ==! '')
		        		$posicion_arr[] = $posicion; 
		        }

		        foreach ($posicion_arr as $value)
		        {
		        	unset($mensaje_partes[$value]);	
		        }

		        if (count($mensaje_partes) > 0)
		        {
		            $this->addError($attribute, "El mensaje no puede incluir números telefónicos");
		        }
	    	}
	    }
	    else if ($this->tipo == 3) //BCP
		{
	    	$cliente_alarmas = ClienteAlarmas::model()->find("id =? ", array($this->id_cliente));

	    	if (Yii::app()->Procedimientos->clienteIsHipicoLotero($cliente_alarmas->id_cliente_sms))
	    	{
		        preg_match_all('/\d{3,}/', $this->$attribute, $mensaje_partes);
		        $mensaje_partes = array_unique($mensaje_partes[0]);
		        $posicion = array_search($cliente_alarmas->sc, $mensaje_partes);
		       
		        if ($posicion ==! 'false')
		        {
		            unset($mensaje_partes[$posicion]);
		        }

		        if (count($mensaje_partes) > 0)
		        {
		            $this->addError($attribute, "El mensaje no puede incluir números telefónicos o cadenas de números diferentes a su Short Code");
		        }
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
		}
    }

    public function ingresarDestinatarios($attribute, $params)
    {
    	if ($this->destinatariosIsset() && $this->listasIsset() && $this->btlIsset())
    	{
    		$this->addError($attribute, "Debe ingresar algún destinatario");
    	}	
    }

    public function destinatariosIsset()
    {
    	//Retorna true para no tomarlo en cuenta
    	if (!isset($this->destinatarios))
    		return true;
    	if (isset($this->destinatarios) && $this->destinatarios == "")
    		return true;
    	if (isset($this->destinatarios) && $this->destinatarios != "")
    		return false;
    }

    public function listasIsset()
    {
    	//Retorna true para no tomarlo en cuenta
    	if (!isset($this->listas))
    		return true;
    	if (isset($this->listas) && COUNT($this->listas) == 0)
    		return true;
    	if (isset($this->listas) && COUNT($this->listas) != 0)
    		return false;
    }

    public function btlIsset()
    {
    	//Retorna true para no tomarlo en cuenta
    	if (!isset($this->btl))
    		return true;
    	if (isset($this->btl) && $this->btl == "")
    		return true;
    	if (isset($this->btl) && $this->btl != "")
    		return false;
    }
}
?>
