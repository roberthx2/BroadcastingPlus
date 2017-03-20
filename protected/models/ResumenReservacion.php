<?php

/**
 * This is the model class for table "resumen_reservacion".
 *
 * The followings are the available columns in table 'resumen_reservacion':
 * @property integer $id_resumen
 * @property string $fecha
 * @property string $time_slot
 * @property integer $total_sms
 * @property integer $id_operadora
 * @property integer $diff_cant_maxima
 */
class ResumenReservacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resumen_reservacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_operadora', 'required'),
			array('total_sms, id_operadora, diff_cant_maxima', 'numerical', 'integerOnly'=>true),
			array('fecha, time_slot', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_resumen, fecha, time_slot, total_sms, id_operadora, diff_cant_maxima', 'safe', 'on'=>'search'),
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
			'id_resumen' => 'Id Resumen',
			'fecha' => 'Fecha',
			'time_slot' => 'Time Slot',
			'total_sms' => 'Total Sms',
			'id_operadora' => 'Id Operadora',
			'diff_cant_maxima' => 'Diff Cant Maxima',
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

		$criteria->compare('id_resumen',$this->id_resumen);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('time_slot',$this->time_slot,true);
		$criteria->compare('total_sms',$this->total_sms);
		$criteria->compare('id_operadora',$this->id_operadora);
		$criteria->compare('diff_cant_maxima',$this->diff_cant_maxima);

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
	 * @return ResumenReservacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
