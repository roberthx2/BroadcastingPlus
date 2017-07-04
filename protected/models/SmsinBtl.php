<?php

/**
 * This is the model class for table "smsin_btl".
 *
 * The followings are the available columns in table 'smsin_btl':
 * @property string $id_sms
 * @property string $origen
 * @property string $sc
 * @property string $data_arrive
 * @property string $desp_op
 * @property integer $id_producto
 */
class SmsinBtl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'smsin_btl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_producto', 'numerical', 'integerOnly'=>true),
			array('id_sms', 'length', 'max'=>150),
			array('origen', 'length', 'max'=>50),
			array('sc, desp_op', 'length', 'max'=>20),
			array('data_arrive', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sms, origen, sc, data_arrive, desp_op, id_producto', 'safe', 'on'=>'search'),
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
			'id_sms' => 'Id Sms',
			'origen' => 'Origen',
			'sc' => 'Sc',
			'data_arrive' => 'Data Arrive',
			'desp_op' => 'Desp Op',
			'id_producto' => 'Id Producto',
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

		$criteria->compare('id_sms',$this->id_sms,true);
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('sc',$this->sc,true);
		$criteria->compare('data_arrive',$this->data_arrive,true);
		$criteria->compare('desp_op',$this->desp_op,true);
		$criteria->compare('id_producto',$this->id_producto);

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
	 * @return SmsinBtl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
