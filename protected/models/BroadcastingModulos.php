<?php

/**
 * This is the model class for table "broadcasting_modulos".
 *
 * The followings are the available columns in table 'broadcasting_modulos':
 * @property integer $id_modulo
 * @property string $descripcion_corta
 * @property string $descripcion_larga
 * @property integer $estado
 */
class BroadcastingModulos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'broadcasting_modulos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_modulo, descripcion_corta, descripcion_larga', 'required'),
			array('id_modulo, estado', 'numerical', 'integerOnly'=>true),
			array('descripcion_corta', 'length', 'max'=>10),
			array('descripcion_larga', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_modulo, descripcion_corta, descripcion_larga, estado', 'safe', 'on'=>'search'),
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
			'id_modulo' => 'Id Modulo',
			'descripcion_corta' => 'Descripcion Corta',
			'descripcion_larga' => 'Descripcion Larga',
			'estado' => 'Estado',
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

		$criteria->compare('id_modulo',$this->id_modulo);
		$criteria->compare('descripcion_corta',$this->descripcion_corta,true);
		$criteria->compare('descripcion_larga',$this->descripcion_larga,true);
		$criteria->compare('estado',$this->estado);

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
	 * @return BroadcastingModulos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
