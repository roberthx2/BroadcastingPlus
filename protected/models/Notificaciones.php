<?php

/**
 * This is the model class for table "notificaciones".
 *
 * The followings are the available columns in table 'notificaciones':
 * @property integer $id_notificacion
 * @property integer $id_usuario
 * @property string $asunto
 * @property string $mensaje
 * @property string $fecha
 * @property string $hora
 * @property integer $estado
 */
class Notificaciones extends CActiveRecord
{
	public $buscar;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, asunto, mensaje, fecha, hora', 'required'),
			array('id_usuario, estado', 'numerical', 'integerOnly'=>true),
			array('asunto', 'length', 'max'=>50),
			array('mensaje', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_notificacion, id_usuario, asunto, mensaje, fecha, hora, estado', 'safe', 'on'=>'search'),
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
			'id_notificacion' => 'Id Notificacion',
			'id_usuario' => 'Id Usuario',
			'asunto' => 'Asunto',
			'mensaje' => 'Mensaje',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
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

		$criteria->compare('id_notificacion',$this->id_notificacion);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_usuario($id_usuario)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->condition = "(id_usuario = ".$id_usuario." AND ";
		$criteria->condition .= "estado = 0 ) AND (";
		$criteria->condition .= "asunto LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "fecha LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "hora LIKE '%".$this->buscar."%')";
		$criteria->order = "fecha, hora DESC";

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
	 * @return Notificaciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
