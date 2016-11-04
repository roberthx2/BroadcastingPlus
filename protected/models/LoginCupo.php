<?php

/**
 * This is the model class for table "login_cupo".
 *
 * The followings are the available columns in table 'login_cupo':
 * @property integer $id_cupo
 * @property integer $asignado
 * @property integer $consumido
 * @property integer $disponible
 * @property integer $sms_por_mes
 * @property string $fecha
 * @property string $hora
 * @property string $id_usuario
 *
 * The followings are the available model relations:
 * @property Usuario $idUsuario
 */
class LoginCupo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'login_cupo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario', 'required'),
			array('asignado, consumido, disponible, sms_por_mes', 'numerical', 'integerOnly'=>true),
			array('id_usuario', 'length', 'max'=>10),
			array('fecha, hora', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cupo, asignado, consumido, disponible, sms_por_mes, fecha, hora, id_usuario', 'safe', 'on'=>'search'),
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
			'idUsuario' => array(self::BELONGS_TO, 'Usuario', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cupo' => 'Id Cupo',
			'asignado' => 'Asignado',
			'consumido' => 'Consumido',
			'disponible' => 'Disponible',
			'sms_por_mes' => 'Sms Por Mes',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'id_usuario' => 'Id Usuario',
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

		$criteria->compare('id_cupo',$this->id_cupo);
		$criteria->compare('asignado',$this->asignado);
		$criteria->compare('consumido',$this->consumido);
		$criteria->compare('disponible',$this->disponible);
		$criteria->compare('sms_por_mes',$this->sms_por_mes);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('id_usuario',$this->id_usuario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoginCupo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
