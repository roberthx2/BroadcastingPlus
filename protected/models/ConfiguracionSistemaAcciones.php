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
			//updateSCInSMS
			array('valor', 'numerical', 'min'=>6, 'max'=>158, 'integerOnly'=>true, "on"=>"scInSMS"),
			//SmsXnumero
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"smsXnumero"),
			//Clave de recargas
			array("valor","filter","filter"=>array($this, "password"), "on"=>"cupoClave"),
			//Multiplicacion base cupo BCP
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"cupoMultBase"),
			//Tipo consulta cupo BCP
			array('valor', 'numerical', 'min'=>1, 'max'=>2, 'integerOnly'=>true, "on"=>"cupoTipoConsulta"),
			//Cantidad de dia para la consulta de cupo BCP
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"cupoDiasConsulta"),
			//Cantidad de meses para la consulta de cupo BCP
			array('valor', 'numerical', 'min'=>1, 'max'=>12, 'integerOnly'=>true, "on"=>"cupoMesesConsulta"),
			//Cantidad de dias para inhabilitar los puertos BCNL
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"puertoDiasInhab"),
			//Cantidad de dias para inhabilitar los puertos BCNL
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"puertoDiasWarning"),
			//Intervalo de reservacion
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"reservacionIntervalo"),
			//Cantidad de meses maximos que pueden ser consultados por los reportes
			array('valor', 'numerical', 'min'=>1, 'integerOnly'=>true, "on"=>"reservacionIntervalo"),
			
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
		return md5($password);
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
