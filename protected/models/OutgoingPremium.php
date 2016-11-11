<?php

/**
 * This is the model class for table "outgoing_premium".
 *
 * The followings are the available columns in table 'outgoing_premium':
 * @property string $id
 * @property string $destinatario
 * @property string $mensaje
 * @property string $fecha_in
 * @property string $hora_in
 * @property string $fecha_out
 * @property string $hora_out
 * @property string $tipo_evento
 * @property string $cliente
 * @property string $operadora
 * @property integer $status
 * @property string $id_promo
 * @property string $id_insignia_alarmas
 */
class OutgoingPremium extends CActiveRecord
{
	public $buscar;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'outgoing_premium';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('destinatario, id_promo, id_insignia_alarmas', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('destinatario', 'length', 'max'=>20),
			array('mensaje', 'length', 'max'=>160),
			array('tipo_evento, cliente, operadora, id_promo', 'length', 'max'=>10),
			array('id_insignia_alarmas', 'length', 'max'=>100),
			array('fecha_in, hora_in, fecha_out, hora_out', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, destinatario, mensaje, fecha_in, hora_in, fecha_out, hora_out, tipo_evento, cliente, operadora, status, id_promo, id_insignia_alarmas', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'destinatario' => 'Destinatario',
			'mensaje' => 'Mensaje',
			'fecha_in' => 'Fecha In',
			'hora_in' => 'Hora In',
			'fecha_out' => 'Fecha Out',
			'hora_out' => 'Hora Out',
			'tipo_evento' => 'Tipo Evento',
			'cliente' => 'Cliente',
			'operadora' => 'Operadora',
			'status' => 'Status',
			'id_promo' => 'Id Promo',
			'id_insignia_alarmas' => 'Id Insignia Alarmas',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('destinatario',$this->destinatario,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('fecha_in',$this->fecha_in,true);
		$criteria->compare('hora_in',$this->hora_in,true);
		$criteria->compare('fecha_out',$this->fecha_out,true);
		$criteria->compare('hora_out',$this->hora_out,true);
		$criteria->compare('tipo_evento',$this->tipo_evento,true);
		$criteria->compare('cliente',$this->cliente,true);
		$criteria->compare('operadora',$this->operadora,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('id_promo',$this->id_promo,true);
		$criteria->compare('id_insignia_alarmas',$this->id_insignia_alarmas,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDetalleBCP($id_promo)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('destinatario',$this->destinatario,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('fecha_in',$this->fecha_in,true);
		$criteria->compare('hora_in',$this->hora_in,true);
		$criteria->compare('fecha_out',$this->fecha_out,true);
		$criteria->compare('hora_out',$this->hora_out,true);
		$criteria->compare('tipo_evento',$this->tipo_evento,true);
		$criteria->compare('cliente',$this->cliente,true);
		$criteria->compare('operadora',$this->operadora,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('id_promo',$id_promo);
		$criteria->compare('id_insignia_alarmas',$this->id_insignia_alarmas,true);

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
	 * @return OutgoingPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
