<?php

/**
 * This is the model class for table "sc_id".
 *
 * The followings are the available columns in table 'sc_id':
 * @property string $Id_sc
 * @property string $sc_id
 * @property double $tarifa
 * @property string $fecha
 * @property integer $id_op
 * @property string $id_integ
 * @property string $Mensaje_Error
 * @property string $selectivo
 * @property integer $diccionario
 * @property string $Desc_Envio_Mensaje_Error
 */
class ScId extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sc_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_op, diccionario', 'numerical', 'integerOnly'=>true),
			array('tarifa', 'numerical'),
			array('sc_id', 'length', 'max'=>20),
			array('id_integ', 'length', 'max'=>3),
			array('Mensaje_Error', 'length', 'max'=>160),
			array('selectivo, Desc_Envio_Mensaje_Error', 'length', 'max'=>1),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_sc, sc_id, tarifa, fecha, id_op, id_integ, Mensaje_Error, selectivo, diccionario, Desc_Envio_Mensaje_Error', 'safe', 'on'=>'search'),
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
			'Id_sc' => 'Id Sc',
			'sc_id' => 'Sc',
			'tarifa' => 'Tarifa',
			'fecha' => 'Fecha',
			'id_op' => 'Id Op',
			'id_integ' => 'Id Integ',
			'Mensaje_Error' => 'Mensaje Error',
			'selectivo' => 'Selectivo',
			'diccionario' => 'Diccionario',
			'Desc_Envio_Mensaje_Error' => 'Desc Envio Mensaje Error',
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

		$criteria->compare('Id_sc',$this->Id_sc,true);
		$criteria->compare('sc_id',$this->sc_id,true);
		$criteria->compare('tarifa',$this->tarifa);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_op',$this->id_op);
		$criteria->compare('id_integ',$this->id_integ,true);
		$criteria->compare('Mensaje_Error',$this->Mensaje_Error,true);
		$criteria->compare('selectivo',$this->selectivo,true);
		$criteria->compare('diccionario',$this->diccionario);
		$criteria->compare('Desc_Envio_Mensaje_Error',$this->Desc_Envio_Mensaje_Error,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_sms;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScId the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
