<?php

/**
 * This is the model class for table "usuario_cupo_historico_premium".
 *
 * The followings are the available columns in table 'usuario_cupo_historico_premium':
 * @property integer $id
 * @property integer $id_usuario
 * @property integer $id_cliente
 * @property integer $cantidad
 * @property string $descripcion
 * @property string $fecha
 * @property string $hora
 * @property integer $tipo_operacion
 */
class UsuarioCupoHistoricoPremium extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario_cupo_historico_premium';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_cliente, cantidad, descripcion, fecha, hora, tipo_operacion', 'required'),
			array('id_usuario, id_cliente, cantidad, tipo_operacion', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usuario, id_cliente, cantidad, descripcion, fecha, hora, tipo_operacion', 'safe', 'on'=>'search'),
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
			'id_usuario' => 'Id Usuario',
			'id_cliente' => 'Id Cliente',
			'cantidad' => 'Cantidad',
			'descripcion' => 'Descripcion',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'tipo_operacion' => 'Tipo Operacion',
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
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_cliente',$this->id_cliente);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('tipo_operacion',$this->tipo_operacion);

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
	 * @return UsuarioCupoHistoricoPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
