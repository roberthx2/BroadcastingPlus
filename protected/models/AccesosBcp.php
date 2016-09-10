<?php

/**
 * This is the model class for table "accesos_bcp".
 *
 * The followings are the available columns in table 'accesos_bcp':
 * @property string $id_usuario
 * @property integer $broadcasting_premium
 * @property integer $crear_promo_premium
 * @property integer $ver_detalles_premium
 * @property integer $ver_reporte_premium
 * @property integer $generar_reporte_sms_recibidos_premium
 * @property integer $ver_sms_programados
 * @property integer $ver_mensual_sms
 * @property integer $ver_mensual_sms_por_cliente
 * @property integer $ver_mensual_sms_por_codigo
 * @property integer $ver_reporte_vigilancia
 */
class AccesosBcp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accesos_bcp';
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
			array('broadcasting_premium, crear_promo_premium, ver_detalles_premium, ver_reporte_premium, generar_reporte_sms_recibidos_premium, ver_sms_programados, ver_mensual_sms, ver_mensual_sms_por_cliente, ver_mensual_sms_por_codigo, ver_reporte_vigilancia', 'numerical', 'integerOnly'=>true),
			array('id_usuario', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, broadcasting_premium, crear_promo_premium, ver_detalles_premium, ver_reporte_premium, generar_reporte_sms_recibidos_premium, ver_sms_programados, ver_mensual_sms, ver_mensual_sms_por_cliente, ver_mensual_sms_por_codigo, ver_reporte_vigilancia', 'safe', 'on'=>'search'),
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
			'broadcasting_premium' => 'Broadcasting Premium',
			'crear_promo_premium' => 'Crear Promo Premium',
			'ver_detalles_premium' => 'Ver Detalles Premium',
			'ver_reporte_premium' => 'Ver Reporte Premium',
			'generar_reporte_sms_recibidos_premium' => 'Generar Reporte Sms Recibidos Premium',
			'ver_sms_programados' => 'Ver Sms Programados',
			'ver_mensual_sms' => 'Ver Mensual Sms',
			'ver_mensual_sms_por_cliente' => 'Ver Mensual Sms Por Cliente',
			'ver_mensual_sms_por_codigo' => 'Ver Mensual Sms Por Codigo',
			'ver_reporte_vigilancia' => 'Ver Reporte Vigilancia',
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
		$criteria->compare('broadcasting_premium',$this->broadcasting_premium);
		$criteria->compare('crear_promo_premium',$this->crear_promo_premium);
		$criteria->compare('ver_detalles_premium',$this->ver_detalles_premium);
		$criteria->compare('ver_reporte_premium',$this->ver_reporte_premium);
		$criteria->compare('generar_reporte_sms_recibidos_premium',$this->generar_reporte_sms_recibidos_premium);
		$criteria->compare('ver_sms_programados',$this->ver_sms_programados);
		$criteria->compare('ver_mensual_sms',$this->ver_mensual_sms);
		$criteria->compare('ver_mensual_sms_por_cliente',$this->ver_mensual_sms_por_cliente);
		$criteria->compare('ver_mensual_sms_por_codigo',$this->ver_mensual_sms_por_codigo);
		$criteria->compare('ver_reporte_vigilancia',$this->ver_reporte_vigilancia);

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
	 * @return AccesosBcp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
