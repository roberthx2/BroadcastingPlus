<?php

/**
 * This is the model class for table "tmp_usuario_puerto".
 *
 * The followings are the available columns in table 'tmp_usuario_puerto':
 * @property string $id_usuario
 * @property string $id_puerto
 * @property string $tipo
 * @property string $fecha
 * @property string $hora
 */
class TmpUsuarioPuerto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmp_usuario_puerto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_puerto, tipo, fecha, hora', 'required'),
			array('id_usuario, id_puerto', 'length', 'max'=>10),
			array('tipo', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, id_puerto, tipo, fecha, hora', 'safe', 'on'=>'search'),
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
			'id_usuario' => 'Id Usuario',
			'id_puerto' => 'Id Puerto',
			'tipo' => 'Tipo',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
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

		$criteria->compare('id_usuario',$this->id_usuario,true);
		$criteria->compare('id_puerto',$this->id_puerto,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TmpUsuarioPuerto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
