<?php

/**
 * This is the model class for table "control_cupo_usuario".
 *
 * The followings are the available columns in table 'control_cupo_usuario':
 * @property integer $id
 * @property integer $tipo_recarga
 * @property string $fecha_asignacion
 * @property string $fecha_vencimiento
 * @property integer $id_usuario
 * @property integer $id_usuario_recarga
 * @property integer $cupo_asignado
 * @property integer $cupo_consumido
 * @property integer $inicio_cupo
 */
class ControlCupoUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'control_cupo_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo_recarga, fecha_asignacion, id_usuario, id_usuario_recarga, cupo_asignado, cupo_consumido', 'required'),
			array('tipo_recarga, id_usuario, id_usuario_recarga, cupo_asignado, cupo_consumido, inicio_cupo', 'numerical', 'integerOnly'=>true),
			array('fecha_vencimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo_recarga, fecha_asignacion, fecha_vencimiento, id_usuario, id_usuario_recarga, cupo_asignado, cupo_consumido, inicio_cupo', 'safe', 'on'=>'search'),
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
			'tipo_recarga' => 'Tipo Recarga',
			'fecha_asignacion' => 'Fecha Asignacion',
			'fecha_vencimiento' => 'Fecha Vencimiento',
			'id_usuario' => 'Id Usuario',
			'id_usuario_recarga' => 'Id Usuario Recarga',
			'cupo_asignado' => 'Cupo Asignado',
			'cupo_consumido' => 'Cupo Consumido',
			'inicio_cupo' => 'Inicio Cupo',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('tipo_recarga',$this->tipo_recarga);
		$criteria->compare('fecha_asignacion',$this->fecha_asignacion,true);
		$criteria->compare('fecha_vencimiento',$this->fecha_vencimiento,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_usuario_recarga',$this->id_usuario_recarga);
		$criteria->compare('cupo_asignado',$this->cupo_asignado);
		$criteria->compare('cupo_consumido',$this->cupo_consumido);
		$criteria->compare('inicio_cupo',$this->inicio_cupo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ControlCupoUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
