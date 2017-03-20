<?php

/**
 * This is the model class for table "promociones_premium_acciones".
 *
 * The followings are the available columns in table 'promociones_premium_acciones':
 * @property integer $id_promo
 * @property integer $reintegro_cupo
 * @property integer $copy_tmp_outgoing_alf
 */
class PromocionesPremiumAcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promociones_premium_acciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_promo', 'required'),
			array('id_promo, reintegro_cupo, copy_tmp_outgoing_alf', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_promo, reintegro_cupo, copy_tmp_outgoing_alf', 'safe', 'on'=>'search'),
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
			'id_promo' => 'Id Promo',
			'reintegro_cupo' => 'Reintegro Cupo',
			'copy_tmp_outgoing_alf' => 'Copy Tmp Outgoing Alf',
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

		$criteria->compare('id_promo',$this->id_promo);
		$criteria->compare('reintegro_cupo',$this->reintegro_cupo);
		$criteria->compare('copy_tmp_outgoing_alf',$this->copy_tmp_outgoing_alf);

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
	 * @return PromocionesPremiumAcciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
