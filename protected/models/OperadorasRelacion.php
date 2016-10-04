<?php

/**
 * This is the model class for table "operadoras_relacion".
 *
 * The followings are the available columns in table 'operadoras_relacion':
 * @property integer $id_operadora_bcnl
 * @property integer $id_operadora_bcp
 * @property string $prefijo
 * @property string $descripcion
 */
class OperadorasRelacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_operadora;
	
	public function tableName()
	{
		return 'operadoras_relacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_operadora_bcnl, id_operadora_bcp, prefijo, descripcion', 'required'),
			array('id_operadora_bcnl, id_operadora_bcp', 'numerical', 'integerOnly'=>true),
			array('prefijo', 'length', 'max'=>4),
			array('descripcion', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_operadora_bcnl, id_operadora_bcp, prefijo, descripcion', 'safe', 'on'=>'search'),
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
			'id_operadora_bcnl' => 'Id Operadora Bcnl',
			'id_operadora_bcp' => 'Id Operadora Bcp',
			'prefijo' => 'Prefijo',
			'descripcion' => 'Descripcion',
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

		$criteria->compare('id_operadora_bcnl',$this->id_operadora_bcnl);
		$criteria->compare('id_operadora_bcp',$this->id_operadora_bcp);
		$criteria->compare('prefijo',$this->prefijo,true);
		$criteria->compare('descripcion',$this->descripcion,true);

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
	 * @return OperadorasRelacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
