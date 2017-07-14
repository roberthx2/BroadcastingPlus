<?php

/**
 * This is the model class for table "contactos_administrativos".
 *
 * The followings are the available columns in table 'contactos_administrativos':
 * @property integer $id_contacto
 * @property string $nombre
 * @property string $correo
 * @property string $numero
 * @property integer $id_operadora
 * @property integer $estado
 */
class ContactosAdministrativos extends CActiveRecord
{
	public $buscar;
	public $estado_descripcion;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contactos_administrativos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, correo, numero', 'required'),
			array('id_operadora, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, correo', 'length', 'max'=>50),
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),

			array("nombre", "ext.validator.Nombre"), //Valida los caracteres
			array("numero", "ext.validator.Numero"),
			array("numero", "ext.validator.PrefijoOperadora"),
			array("correo", "ext.validator.Email"),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_contacto, nombre, correo, numero, id_operadora, estado, buscar', 'safe', 'on'=>'search'),
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
			'id_contacto' => 'Id Contacto',
			'nombre' => 'Nombre',
			'correo' => 'Correo',
			'numero' => 'Numero',
			'id_operadora' => 'Id Operadora',
			'estado' => 'Estado',
		);
	}

	public function limpiarNombre($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
 
		$criteria=new CDbCriteria;
		$criteria->select = "id_contacto, nombre, correo, numero, estado, CASE estado WHEN 1 THEN 'ACTIVO' ELSE 'INACTIVO' END AS estado_descripcion";
		$criteria->having  = "nombre LIKE '%".$this->buscar."%' OR ";
		$criteria->having .= "correo LIKE '%".$this->buscar."%' OR ";
		$criteria->having .= "numero LIKE '%".$this->buscar."%' OR ";
		$criteria->having .= "estado_descripcion LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'nombre ASC',
        		'attributes'=>array(
             		'nombre', 'correo', 'numero', 'estado'
        		),
    		),
    		'pagination'=>array(
		        'pageSize'=>10,
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
	 * @return ContactosAdministrativos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
