<?php

/**
 * This is the model class for table "configuracion_operadora_reservacion".
 *
 * The followings are the available columns in table 'configuracion_operadora_reservacion':
 * @property integer $id_operadora
 * @property string $descripcion
 * @property integer $sms_x_seg
 * @property integer $porcentaje_permitido
 */
class ConfiguracionOperadoraReservacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'configuracion_operadora_reservacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_operadora, descripcion, sms_x_seg, porcentaje_permitido', 'required', 'message'=>'{attribute} requerido'),
			array('sms_x_seg, porcentaje_permitido', 'numerical', 'min'=>0, 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_operadora, descripcion, sms_x_seg, porcentaje_permitido', 'safe', 'on'=>'search'),
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
			'id_operadora' => 'Id Operadora',
			'descripcion' => 'Descripcion',
			'sms_x_seg' => 'SMS por seg.',
			'porcentaje_permitido' => 'Porcentaje Permitido',
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

		$criteria->compare('id_operadora',$this->id_operadora);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('sms_x_seg',$this->sms_x_seg);
		$criteria->compare('porcentaje_permitido',$this->porcentaje_permitido);

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
	 * @return ConfiguracionOperadoraReservacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
