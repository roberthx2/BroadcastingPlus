<?php

/**
 * This is the model class for table "operadora_cliente".
 *
 * The followings are the available columns in table 'operadora_cliente':
 * @property string $id_operadora
 * @property string $id_cliente
 * @property string $id_op
 *
 * The followings are the available model relations:
 * @property Operadora $idOperadora
 * @property Cliente $idCliente
 */
class OperadoraCliente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operadora_cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_operadora, id_cliente, id_op', 'required'),
			array('id_operadora, id_cliente, id_op', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_operadora, id_cliente, id_op', 'safe', 'on'=>'search'),
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
			'idOperadora' => array(self::BELONGS_TO, 'Operadora', 'id_operadora'),
			'idCliente' => array(self::BELONGS_TO, 'Cliente', 'id_cliente'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_operadora' => 'Id Operadora',
			'id_cliente' => 'Id Cliente',
			'id_op' => 'Id Op',
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

		$criteria->compare('id_operadora',$this->id_operadora,true);
		$criteria->compare('id_cliente',$this->id_cliente,true);
		$criteria->compare('id_op',$this->id_op,true);

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
	 * @return OperadoraCliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
