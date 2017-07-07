<?php

/**
 * This is the model class for table "configuracion_sistema_acciones".
 *
 * The followings are the available columns in table 'configuracion_sistema_acciones':
 * @property integer $id
 * @property string $nombre
 * @property string $propiedad
 * @property string $escenario
 * @property string $vista
 */
class ConfiguracionSistemaAcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $valor;
	public $descripcion;
	public $buscar;

	public function tableName()
	{
		return 'configuracion_sistema_acciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('nombre, propiedad, escenario, vista', 'required'),
			//array('nombre, propiedad, vista', 'length', 'max'=>50),
			//array('escenario', 'length', 'max'=>300),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, nombre, propiedad, escenario, vista', 'safe', 'on'=>'search'),

			array('id, nombre, propiedad, escenario, vista', 'safe'),
			//Required
			array("valor", "required","message"=>"{attribute} requerido"),
			//Valores numericos que tienen como minimo el 1
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"smsXnumero, cupoMultBase, cupoDiasConsulta, puertoDiasInhab, puertoDiasWarning, reservacionIntervalo, reporteMesesConsulta"),
			//Tipo consulta cupo BCP
			array('valor', 'numerical', 'min'=>1, 'max'=>2, 'integerOnly'=>true, "on"=>"cupoTipoConsulta"),
			//Cantidad de meses para la consulta de cupo BCP
			array('valor', 'numerical', 'min'=>1, 'max'=>12, 'integerOnly'=>true, "on"=>"cupoMesesConsulta"),
			//updateSCInSMS
			array('valor', 'numerical', 'min'=>6, 'max'=>158, 'integerOnly'=>true, "on"=>"scInSMS"),
			//Clave de recargas
			array("valor","filter","filter"=>array($this, "password"), "on"=>"cupoClave"),
			//Horas
			array('valor', 'date', 'format'=>'H:m',"message"=>"El formato de Valor es inválido. Ej: 14:30", "on"=>"horaIniBCP, horaFinBCP, horaIniBCNL, horaIniBCNL, horaFinReservacion"),
			//Validar horas menor/mayor
			array('valor', 'validarHora'),
			//Validar usuarios master
			array('valor', 'validarUserMaster'),
			//Cambiar formato de usuarios master
			array("valor","filter","filter"=>array($this, "usuariosMaster"), "on"=>"usersMaster"),
			//Filtro Levenshtein para las palabras obscenas
			array('valor', 'numerical', 'min'=>50, 'max'=>100, 'integerOnly'=>true, "on"=>"levenshteinPorcentaje"),
			
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'propiedad' => 'Propiedad',
			'escenario' => 'eScenario',
			'vista' => 'Vista',
		);
	}

	public function password($password)
	{
		$count = ConfiguracionSistema::model()->COUNT("propiedad=:propiedad AND valor=:valor", array(":propiedad"=>"clave_recarga_bcp", ":valor"=>$password));

		if ($count == 0)
			return md5($password);
		else
			return $password;
	}

	public function validarHora($attribute, $params)
	{
		$array = array("horaIniBCP", "horaFinBCP", "horaIniBCNL", "horaFinBCNL", "horaFinReservacion");

		if (in_array($this->escenario, $array))
		{
			if ($this->escenario == "horaIniBCP") {
				$propiedad = "hora_fin_bcp";
			}
			else if ($this->escenario == "horaFinBCP" || $this->escenario == "horaFinReservacion") {
				$propiedad = "hora_inicio_bcp";
			}
			else if ($this->escenario == "horaIniBCNL") {
				$propiedad = "hora_fin_bcnl";
			}
			else if ($this->escenario == "horaFinBCNL") {
				$propiedad = "hora_inicio_bcnl";
			}

			$model = ConfiguracionSistema::model()->find("propiedad=:propiedad", array(":propiedad"=>$propiedad));

			if ($this->escenario == "horaIniBCP" || $this->escenario == "horaIniBCNL") 
			{
				if (strtotime($this->$attribute) > strtotime($model->valor))
		    	{
		    		$this->addError($attribute, "La hora inicio debe ser menor que la hora fin (".$model->valor.")");
		    	}
			}
			elseif ($this->escenario == "horaFinBCP" || $this->escenario == "horaFinBCNL" || $this->escenario == "horaFinReservacion") 
			{
				if (strtotime($this->$attribute) < strtotime($model->valor))
		    	{
		    		$this->addError($attribute, "La hora fin debe ser mayor que la hora inicio (".$model->valor.")");
		    	}
			}			
    	}
	}

	public function validarUserMaster($attribute, $params)
	{
		if ($this->escenario == "usersMaster")
		{
			if (!Yii::app()->user->isMaster())
			{
				$this->addError($attribute, "Debe ser un usuario master para poder realizar cambios a esta configuración");
			}
		}
	}

	function cmp($a, $b)
	{
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}

	public function usuariosMaster($usuarios)
	{
		sort($usuarios);
		return implode(",", $usuarios);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	/*public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('propiedad',$this->propiedad,true);
		$criteria->compare('escenario',$this->escenario,true);
		$criteria->compare('vista',$this->vista,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.id, t.nombre, c.valor, c.descripcion";
		$criteria->join = "INNER JOIN configuracion_sistema c ON t.propiedad = c.propiedad";
		$criteria->condition = "t.nombre LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "c.valor LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "c.descripcion LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'nombre ASC',
        		'attributes'=>array(
             		'id', 'nombre', 'c.valor', 'c.descripcion'
        		),
    		),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_masivo_premium;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConfiguracionSistemaAcciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
