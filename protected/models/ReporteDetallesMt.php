<?php

/**
 * This is the model class for table "reporte_detalles_mt".
 *
 * The followings are the available columns in table 'reporte_detalles_mt':
 * @property integer $id_fecha
 * @property integer $id_cliente
 * @property string $descripcion
 * @property string $sc
 * @property integer $movistar
 * @property integer $movilnet
 * @property integer $digitel
 * @property integer $tipo
 *
 * The followings are the available model relations:
 * @property ReporteFecha $idFecha
 */
class ReporteDetallesMt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reporte_detalles_mt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_fecha, id_cliente, tipo', 'required'),
			array('id_fecha, id_cliente, movistar, movilnet, digitel, tipo', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>70),
			array('sc', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_fecha, id_cliente, descripcion, sc, movistar, movilnet, digitel, tipo', 'safe', 'on'=>'search'),
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
			'movistar' => 'Movistar',
			'movilnet' => 'Movilnet',
			'digitel' => 'Digitel',
			'tipo' => 'Tipo',
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
		$criteria->compare('sc',$this->sc,true);
		$criteria->compare('movistar',$this->movistar);
		$criteria->compare('movilnet',$this->movilnet);
		$criteria->compare('digitel',$this->digitel);
		$criteria->compare('tipo',$this->tipo);

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
	 * @return ReporteDetallesMt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
