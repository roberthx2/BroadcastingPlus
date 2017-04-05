<?php

/**
 * This is the model class for table "configuracion_sistema_acciones".
 *
 * The followings are the available columns in table 'configuracion_sistema_acciones':
 * @property integer $id
 * @property string $nombre
 * @property string $propiedad
 * @property string $action
 */
class ConfiguracionSistemaAcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $valor;

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
			/*array('nombre, propiedad, action', 'required'),
			array('nombre, propiedad', 'length', 'max'=>50),
			array('action', 'length', 'max'=>300),*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, propiedad, action, valor', 'safe', 'on'=>'search'),
			//Required
			array("valor", "required","message"=>"{attribute} requerido"),
			//updateSCInSMS
			array('valor', 'numerical', 'min'=>6, 'max'=>158, 'integerOnly'=>true, "on"=>"updateSCInSMS"),
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
			'action' => 'Action',
			'valor' => 'Valor',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('propiedad',$this->propiedad,true);
		$criteria->compare('action',$this->action,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
