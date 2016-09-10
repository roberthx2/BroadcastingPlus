<?php

/**
 * This is the model class for table "promociones_premium".
 *
 * The followings are the available columns in table 'promociones_premium':
 * @property string $id_promo
 * @property string $nombrePromo
 * @property string $id_cliente
 * @property string $estado
 * @property string $fecha
 * @property string $hora
 * @property string $loaded_by
 * @property string $contenido
 * @property string $fecha_cargada
 * @property string $hora_cargada
 * @property integer $verificada
 */
class PromocionesPremium extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promociones_premium';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrePromo, id_cliente, estado, fecha, hora, loaded_by, contenido, fecha_cargada, hora_cargada', 'required'),
			array('verificada', 'numerical', 'integerOnly'=>true),
			array('nombrePromo', 'length', 'max'=>100),
			array('id_cliente', 'length', 'max'=>45),
			array('estado, loaded_by', 'length', 'max'=>10),
			array('contenido', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_promo, nombrePromo, id_cliente, estado, fecha, hora, loaded_by, contenido, fecha_cargada, hora_cargada, verificada', 'safe', 'on'=>'search'),
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
			'id_promo' => 'Id Promo',
			'nombrePromo' => 'Nombre Promo',
			'id_cliente' => 'Id Cliente',
			'estado' => 'Estado',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'loaded_by' => 'Loaded By',
			'contenido' => 'Contenido',
			'fecha_cargada' => 'Fecha Cargada',
			'hora_cargada' => 'Hora Cargada',
			'verificada' => 'Verificada',
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

		$criteria->compare('id_promo',$this->id_promo,true);
		$criteria->compare('nombrePromo',$this->nombrePromo,true);
		$criteria->compare('id_cliente',$this->id_cliente,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('loaded_by',$this->loaded_by,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('fecha_cargada',$this->fecha_cargada,true);
		$criteria->compare('hora_cargada',$this->hora_cargada,true);
		$criteria->compare('verificada',$this->verificada);

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
	 * @return PromocionesPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
