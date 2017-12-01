<?php

/**
 * This is the model class for table "mensajes_broadcasting".
 *
 * The followings are the available columns in table 'mensajes_broadcasting':
 * @property string $id_mensaje
 * @property string $mensaje
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property integer $tipo_mensaje
 *
 * The followings are the available model relations:
 * @property MensajesBroadcastingDias[] $mensajesBroadcastingDiases
 */
class MensajesBroadcasting extends CActiveRecord
{
	public $buscar;
	public $dias;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mensajes_broadcasting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mensaje, tipo_mensaje', 'required'),
			array('tipo_mensaje', 'numerical', 'integerOnly'=>true),
			array('mensaje', 'length', 'max'=>900),
			array('fecha_inicio, fecha_fin, hora_inicio, hora_fin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_mensaje, mensaje, fecha_inicio, fecha_fin, hora_inicio, hora_fin, tipo_mensaje', 'safe', 'on'=>'search'),
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
			'mensajesBroadcastingDiases' => array(self::HAS_MANY, 'MensajesBroadcastingDias', 'id_mensaje'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_mensaje' => 'Id Mensaje',
			'mensaje' => 'Mensaje',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
			'tipo_mensaje' => 'Tipo Mensaje',
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
		//$criteria->select = "t.id, t.prefijo, t.id_usuario, u.login";
		$criteria->condition = "mensaje LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "fecha_inicio LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "fecha_fin LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "hora_inicio LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "hora_fin LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'fecha_inicio ASC',
        		'attributes'=>array(
             		'fecha_inicio', 'hora_inicio'
        		),
    		),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MensajesBroadcasting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
