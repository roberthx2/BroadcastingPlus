<?php

/**
 * This is the model class for table "configuracion_sms_por_dia".
 *
 * The followings are the available columns in table 'configuracion_sms_por_dia':
 * @property string $id_dia
 * @property string $descripcion
 * @property integer $cantidad
 */
class ConfiguracionSmsPorDia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'configuracion_sms_por_dia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dia, descripcion, cantidad', 'required','message'=>'{attribute} requerido'),
			array('cantidad', 'numerical', 'min'=>1, 'integerOnly'=>true),
			array('id_dia', 'length', 'max'=>2),
			array('descripcion', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_dia, descripcion, cantidad', 'safe', 'on'=>'search'),
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
			'id_dia' => 'Id Dia',
			'descripcion' => 'Descripcion',
			'cantidad' => 'Cantidad',
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

		$criteria->compare('id_dia',$this->id_dia,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('cantidad',$this->cantidad);

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
	 * @return ConfiguracionSmsPorDia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
