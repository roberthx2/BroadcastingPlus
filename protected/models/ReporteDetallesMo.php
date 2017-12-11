<?php

/**
 * This is the model class for table "reporte_detalles_mo".
 *
 * The followings are the available columns in table 'reporte_detalles_mo':
 * @property integer $id_fecha
 * @property integer $id_cliente
 * @property string $descripcion
 * @property integer $sc
 * @property integer $total
 *
 * The followings are the available model relations:
 * @property ReporteFecha $idFecha
 */
class ReporteDetallesMo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reporte_detalles_mo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_fecha, id_cliente, sc, total', 'required'),
			array('id_fecha, id_cliente, sc, total', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>70),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_fecha, id_cliente, descripcion, sc, total', 'safe', 'on'=>'search'),
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
			'idFecha' => array(self::BELONGS_TO, 'ReporteFecha', 'id_fecha'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_fecha' => 'Id Fecha',
			'id_cliente' => 'Id Cliente',
			'descripcion' => 'Descripcion',
			'sc' => 'Sc',
			'total' => 'Total',
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

		$criteria->compare('id_fecha',$this->id_fecha);
		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('sc',$this->sc);
		$criteria->compare('total',$this->total);

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
	 * @return ReporteDetallesMo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
