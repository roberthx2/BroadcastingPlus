<?php

/**
 * This is the model class for table "cliente".
 *
 * The followings are the available columns in table 'cliente':
 * @property string $id
 * @property string $descripcion
 * @property string $sc
 * @property string $cuota
 * @property string $burst
 * @property integer $onoff
 * @property integer $segundos
 * @property integer $id_cliente_sms
 * @property string $contacto_del_cliente
 * @property integer $id_cliente_sc_numerico
 *
 * The followings are the available model relations:
 * @property OperadoraCliente[] $operadoraClientes
 */
class ClienteAlarmas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('onoff, segundos, id_cliente_sms, id_cliente_sc_numerico', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>100),
			array('sc, cuota, burst', 'length', 'max'=>10),
			array('contacto_del_cliente', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion, sc, cuota, burst, onoff, segundos, id_cliente_sms, contacto_del_cliente, id_cliente_sc_numerico', 'safe', 'on'=>'search'),
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
			'operadoraClientes' => array(self::HAS_MANY, 'OperadoraCliente', 'id_cliente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descripcion' => 'Descripcion',
			'sc' => 'Sc',
			'cuota' => 'Cuota',
			'burst' => 'Burst',
			'onoff' => 'Onoff',
			'segundos' => 'Segundos',
			'id_cliente_sms' => 'Id Cliente Sms',
			'contacto_del_cliente' => 'Contacto Del Cliente',
			'id_cliente_sc_numerico' => 'Id Cliente Sc Numerico',
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
	public function search($id_cliente_sms)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "id, sc, onoff";
		$criteria->compare('id_cliente_sms',$id_cliente_sms);
		$criteria->addCondition("sc NOT REGEXP '[a-zA-Z]+'"); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_insignia_alarmas;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClienteAlarmas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
