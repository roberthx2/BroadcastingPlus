<?php

/**
 * This is the model class for table "permisos".
 *
 * The followings are the available columns in table 'permisos':
 * @property string $id_usuario
 * @property string $acceso_sistema
 * @property string $broadcasting
 * @property string $broadcasting_premium
 * @property string $broadcasting_cpei
 * @property string $modulo_promocion
 * @property string $crear_promo_bcnl
 * @property string $crear_promo_bcp
 * @property string $detalles_promo_bcnl
 * @property string $detalles_promo_bcp
 * @property string $modulo_listas
 * @property string $crear_listas
 * @property string $administrar_listas
 * @property string $modulo_cupo
 * @property string $recargar_cupo_bcnl
 * @property string $recargar_cupo_bcp
 * @property string $historico_cupo_bcnl
 * @property string $historico_cupo_bcp
 * @property string $modulo_exentos
 * @property string $agregar_exentos
 * @property string $administrar_exentos
 * @property string $modulo_reportes
 * @property string $reporte_sms_programados_bcnl
 * @property string $reporte_sms_programados_bcp
 * @property string $reporte_mensual_sms_bcnl
 * @property string $reporte_mensual_sms_bcp
 * @property string $reporte_mensual_sms_por_cliente_bcnl
 * @property string $reporte_mensual_sms_por_cliente_bcp
 * @property string $reporte_mensual_sms_por_codigo_bcp
 * @property string $reporte_sms_recibidos_bcnl
 * @property string $reporte_sms_recibidos_bcp
 * @property string $reporte_vigilancia_bcnl
 * @property string $reporte_vigilancia_bcp
 * @property string $modulo_administracion
 */
class Permisos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permisos';
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
			array('id_usuario, acceso_sistema', 'length', 'max'=>10),
			array('broadcasting, broadcasting_premium, broadcasting_cpei, modulo_promocion, crear_promo_bcnl, crear_promo_bcp, detalles_promo_bcnl, detalles_promo_bcp, modulo_listas, crear_listas, administrar_listas, modulo_cupo, recargar_cupo_bcnl, recargar_cupo_bcp, historico_cupo_bcnl, historico_cupo_bcp, modulo_exentos, agregar_exentos, administrar_exentos, modulo_reportes, reporte_sms_programados_bcnl, reporte_sms_programados_bcp, reporte_mensual_sms_bcnl, reporte_mensual_sms_bcp, reporte_mensual_sms_por_cliente_bcnl, reporte_mensual_sms_por_cliente_bcp, reporte_mensual_sms_por_codigo_bcp, reporte_sms_recibidos_bcnl, reporte_sms_recibidos_bcp, reporte_vigilancia_bcnl, reporte_vigilancia_bcp, modulo_administracion', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, acceso_sistema, broadcasting, broadcasting_premium, broadcasting_cpei, modulo_promocion, crear_promo_bcnl, crear_promo_bcp, detalles_promo_bcnl, detalles_promo_bcp, modulo_listas, crear_listas, administrar_listas, modulo_cupo, recargar_cupo_bcnl, recargar_cupo_bcp, historico_cupo_bcnl, historico_cupo_bcp, modulo_exentos, agregar_exentos, administrar_exentos, modulo_reportes, reporte_sms_programados_bcnl, reporte_sms_programados_bcp, reporte_mensual_sms_bcnl, reporte_mensual_sms_bcp, reporte_mensual_sms_por_cliente_bcnl, reporte_mensual_sms_por_cliente_bcp, reporte_mensual_sms_por_codigo_bcp, reporte_sms_recibidos_bcnl, reporte_sms_recibidos_bcp, reporte_vigilancia_bcnl, reporte_vigilancia_bcp, modulo_administracion', 'safe', 'on'=>'search'),
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
			'acceso_sistema' => 'Acceso Sistema',
			'broadcasting' => 'Broadcasting',
			'broadcasting_premium' => 'Broadcasting Premium',
			'broadcasting_cpei' => 'Broadcasting Cpei',
			'modulo_promocion' => 'Modulo Promocion',
			'crear_promo_bcnl' => 'Crear Promo Bcnl',
			'crear_promo_bcp' => 'Crear Promo Bcp',
			'detalles_promo_bcnl' => 'Detalles Promo Bcnl',
			'detalles_promo_bcp' => 'Detalles Promo Bcp',
			'modulo_listas' => 'Modulo Listas',
			'crear_listas' => 'Crear Listas',
			'administrar_listas' => 'Administrar Listas',
			'modulo_cupo' => 'Modulo Cupo',
			'recargar_cupo_bcnl' => 'Recargar Cupo Bcnl',
			'recargar_cupo_bcp' => 'Recargar Cupo Bcp',
			'historico_cupo_bcnl' => 'Historico Cupo Bcnl',
			'historico_cupo_bcp' => 'Historico Cupo Bcp',
			'modulo_exentos' => 'Modulo Exentos',
			'agregar_exentos' => 'Agregar Exentos',
			'administrar_exentos' => 'Administrar Exentos',
			'modulo_reportes' => 'Modulo Reportes',
			'reporte_sms_programados_bcnl' => 'Reporte Sms Programados Bcnl',
			'reporte_sms_programados_bcp' => 'Reporte Sms Programados Bcp',
			'reporte_mensual_sms_bcnl' => 'Reporte Mensual Sms Bcnl',
			'reporte_mensual_sms_bcp' => 'Reporte Mensual Sms Bcp',
			'reporte_mensual_sms_por_cliente_bcnl' => 'Reporte Mensual Sms Por Cliente Bcnl',
			'reporte_mensual_sms_por_cliente_bcp' => 'Reporte Mensual Sms Por Cliente Bcp',
			'reporte_mensual_sms_por_codigo_bcp' => 'Reporte Mensual Sms Por Codigo Bcp',
			'reporte_sms_recibidos_bcnl' => 'Reporte Sms Recibidos Bcnl',
			'reporte_sms_recibidos_bcp' => 'Reporte Sms Recibidos Bcp',
			'reporte_vigilancia_bcnl' => 'Reporte Vigilancia Bcnl',
			'reporte_vigilancia_bcp' => 'Reporte Vigilancia Bcp',
			'modulo_administracion' => 'Modulo Administracion',
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
		$criteria->compare('acceso_sistema',$this->acceso_sistema,true);
		$criteria->compare('broadcasting',$this->broadcasting,true);
		$criteria->compare('broadcasting_premium',$this->broadcasting_premium,true);
		$criteria->compare('broadcasting_cpei',$this->broadcasting_cpei,true);
		$criteria->compare('modulo_promocion',$this->modulo_promocion,true);
		$criteria->compare('crear_promo_bcnl',$this->crear_promo_bcnl,true);
		$criteria->compare('crear_promo_bcp',$this->crear_promo_bcp,true);
		$criteria->compare('detalles_promo_bcnl',$this->detalles_promo_bcnl,true);
		$criteria->compare('detalles_promo_bcp',$this->detalles_promo_bcp,true);
		$criteria->compare('modulo_listas',$this->modulo_listas,true);
		$criteria->compare('crear_listas',$this->crear_listas,true);
		$criteria->compare('administrar_listas',$this->administrar_listas,true);
		$criteria->compare('modulo_cupo',$this->modulo_cupo,true);
		$criteria->compare('recargar_cupo_bcnl',$this->recargar_cupo_bcnl,true);
		$criteria->compare('recargar_cupo_bcp',$this->recargar_cupo_bcp,true);
		$criteria->compare('historico_cupo_bcnl',$this->historico_cupo_bcnl,true);
		$criteria->compare('historico_cupo_bcp',$this->historico_cupo_bcp,true);
		$criteria->compare('modulo_exentos',$this->modulo_exentos,true);
		$criteria->compare('agregar_exentos',$this->agregar_exentos,true);
		$criteria->compare('administrar_exentos',$this->administrar_exentos,true);
		$criteria->compare('modulo_reportes',$this->modulo_reportes,true);
		$criteria->compare('reporte_sms_programados_bcnl',$this->reporte_sms_programados_bcnl,true);
		$criteria->compare('reporte_sms_programados_bcp',$this->reporte_sms_programados_bcp,true);
		$criteria->compare('reporte_mensual_sms_bcnl',$this->reporte_mensual_sms_bcnl,true);
		$criteria->compare('reporte_mensual_sms_bcp',$this->reporte_mensual_sms_bcp,true);
		$criteria->compare('reporte_mensual_sms_por_cliente_bcnl',$this->reporte_mensual_sms_por_cliente_bcnl,true);
		$criteria->compare('reporte_mensual_sms_por_cliente_bcp',$this->reporte_mensual_sms_por_cliente_bcp,true);
		$criteria->compare('reporte_mensual_sms_por_codigo_bcp',$this->reporte_mensual_sms_por_codigo_bcp,true);
		$criteria->compare('reporte_sms_recibidos_bcnl',$this->reporte_sms_recibidos_bcnl,true);
		$criteria->compare('reporte_sms_recibidos_bcp',$this->reporte_sms_recibidos_bcp,true);
		$criteria->compare('reporte_vigilancia_bcnl',$this->reporte_vigilancia_bcnl,true);
		$criteria->compare('reporte_vigilancia_bcp',$this->reporte_vigilancia_bcp,true);
		$criteria->compare('modulo_administracion',$this->modulo_administracion,true);

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
	 * @return Permisos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
