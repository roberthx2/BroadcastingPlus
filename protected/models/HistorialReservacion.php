<?php

/**
 * This is the model class for table "historial_reservacion".
 *
 * The followings are the available columns in table 'historial_reservacion':
 * @property integer $id_usuario
 * @property string $lunes
 * @property string $martes
 * @property string $miercoles
 * @property string $jueves
 * @property string $viernes
 * @property string $sabado
 * @property string $domingo
 * @property integer $id_operadora
 */
class HistorialReservacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'historial_reservacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_operadora', 'required'),
			array('id_usuario, id_operadora', 'numerical', 'integerOnly'=>true),
			array('lunes, martes, miercoles, jueves, viernes, sabado, domingo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, lunes, martes, miercoles, jueves, viernes, sabado, domingo, id_operadora', 'safe', 'on'=>'search'),
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
			'lunes' => 'Lunes',
			'martes' => 'Martes',
			'miercoles' => 'Miercoles',
			'jueves' => 'Jueves',
			'viernes' => 'Viernes',
			'sabado' => 'Sabado',
			'domingo' => 'Domingo',
			'id_operadora' => 'Id Operadora',
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

		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('lunes',$this->lunes,true);
		$criteria->compare('martes',$this->martes,true);
		$criteria->compare('miercoles',$this->miercoles,true);
		$criteria->compare('jueves',$this->jueves,true);
		$criteria->compare('viernes',$this->viernes,true);
		$criteria->compare('sabado',$this->sabado,true);
		$criteria->compare('domingo',$this->domingo,true);
		$criteria->compare('id_operadora',$this->id_operadora);

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
	 * @return HistorialReservacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
