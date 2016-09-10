<?php

/**
 * This is the model class for table "accesos".
 *
 * The followings are the available columns in table 'accesos':
 * @property string $id_usuario
 * @property string $acceso_conciliacion
 * @property string $acceso_CRS
 * @property string $crear_promo
 * @property string $ver_detalles
 * @property string $ver_destinatarios
 * @property string $sms_enviados
 * @property string $crear_lista
 * @property string $ver_lista
 * @property string $editar_lista
 * @property string $editar_detalles
 * @property string $editar_destinatarios
 * @property string $sms_prog
 * @property string $crear_not
 * @property string $ver_not
 * @property string $agregar_exen
 * @property string $ver_exen
 * @property string $eliminar_exen
 * @property string $num_cruzados
 * @property string $admin_accesos
 * @property string $admin_puertos_usuario
 * @property string $admin_puertos_ver
 * @property string $admin_puertos_crear
 * @property string $admin_puertos_editar
 * @property string $admin_puertos_eliminar
 * @property string $admin_cupo
 * @property string $admin_prefijos_ver
 * @property string $admin_prefijos_editar
 * @property string $admin_prefijos_eliminar
 * @property string $sms_recibidos
 * @property string $administrar_exentos_propuestos
 * @property string $sms_enviados_por_cliente
 * @property string $crear_promo_personalizada
 * @property string $admin_pruebas_modems
 * @property string $administrar_modem_sin_saldo
 * @property string $administrar_reasignar_puertos_por_promo
 * @property string $administrar_reporte_vigilancia
 * @property string $administrar_terminos_condiciones
 * @property string $administrar_aprobar_promocion
 * @property string $administrar_operadoras
 * @property string $habilitar_modem_inactivos
 * @property string $generar_reporte_sms_recibidos
 * @property string $broadcasting
 * @property string $broadcasting_premium
 * @property string $crear_promo_premium
 * @property string $ver_detalles_premium
 * @property string $ver_reporte_premium
 * @property string $generar_reporte_sms_recibidos_premium
 * @property string $broadcasting_lite
 * @property string $crear_promo_lite
 * @property integer $reactivar_promo
 * @property string $acceso_en_suspension
 */
class Accesos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accesos';
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
			array('reactivar_promo', 'numerical', 'integerOnly'=>true),
			array('id_usuario', 'length', 'max'=>11),
			array('acceso_conciliacion, acceso_CRS, crear_promo, ver_detalles, ver_destinatarios, sms_enviados, crear_lista, ver_lista, editar_lista, editar_detalles, editar_destinatarios, sms_prog, crear_not, ver_not, agregar_exen, ver_exen, eliminar_exen, num_cruzados, admin_accesos, admin_puertos_usuario, admin_puertos_ver, admin_puertos_crear, admin_puertos_editar, admin_puertos_eliminar, admin_cupo, admin_prefijos_ver, admin_prefijos_editar, admin_prefijos_eliminar, sms_recibidos, administrar_exentos_propuestos, sms_enviados_por_cliente, crear_promo_personalizada, admin_pruebas_modems, administrar_modem_sin_saldo, administrar_reasignar_puertos_por_promo, administrar_reporte_vigilancia, administrar_terminos_condiciones, administrar_aprobar_promocion, administrar_operadoras, habilitar_modem_inactivos, broadcasting, broadcasting_premium, crear_promo_premium, ver_detalles_premium, ver_reporte_premium, generar_reporte_sms_recibidos_premium, broadcasting_lite, crear_promo_lite, acceso_en_suspension', 'length', 'max'=>1),
			array('generar_reporte_sms_recibidos', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, acceso_conciliacion, acceso_CRS, crear_promo, ver_detalles, ver_destinatarios, sms_enviados, crear_lista, ver_lista, editar_lista, editar_detalles, editar_destinatarios, sms_prog, crear_not, ver_not, agregar_exen, ver_exen, eliminar_exen, num_cruzados, admin_accesos, admin_puertos_usuario, admin_puertos_ver, admin_puertos_crear, admin_puertos_editar, admin_puertos_eliminar, admin_cupo, admin_prefijos_ver, admin_prefijos_editar, admin_prefijos_eliminar, sms_recibidos, administrar_exentos_propuestos, sms_enviados_por_cliente, crear_promo_personalizada, admin_pruebas_modems, administrar_modem_sin_saldo, administrar_reasignar_puertos_por_promo, administrar_reporte_vigilancia, administrar_terminos_condiciones, administrar_aprobar_promocion, administrar_operadoras, habilitar_modem_inactivos, generar_reporte_sms_recibidos, broadcasting, broadcasting_premium, crear_promo_premium, ver_detalles_premium, ver_reporte_premium, generar_reporte_sms_recibidos_premium, broadcasting_lite, crear_promo_lite, reactivar_promo, acceso_en_suspension', 'safe', 'on'=>'search'),
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
			'acceso_conciliacion' => 'Acceso Conciliacion',
			'acceso_CRS' => 'Acceso Crs',
			'crear_promo' => 'Crear Promo',
			'ver_detalles' => 'Ver Detalles',
			'ver_destinatarios' => 'Ver Destinatarios',
			'sms_enviados' => 'Sms Enviados',
			'crear_lista' => 'Crear Lista',
			'ver_lista' => 'Ver Lista',
			'editar_lista' => 'Editar Lista',
			'editar_detalles' => 'Editar Detalles',
			'editar_destinatarios' => 'Editar Destinatarios',
			'sms_prog' => 'Sms Prog',
			'crear_not' => 'Crear Not',
			'ver_not' => 'Ver Not',
			'agregar_exen' => 'Agregar Exen',
			'ver_exen' => 'Ver Exen',
			'eliminar_exen' => 'Eliminar Exen',
			'num_cruzados' => 'Num Cruzados',
			'admin_accesos' => 'Admin Accesos',
			'admin_puertos_usuario' => 'Admin Puertos Usuario',
			'admin_puertos_ver' => 'Admin Puertos Ver',
			'admin_puertos_crear' => 'Admin Puertos Crear',
			'admin_puertos_editar' => 'Admin Puertos Editar',
			'admin_puertos_eliminar' => 'Admin Puertos Eliminar',
			'admin_cupo' => 'Admin Cupo',
			'admin_prefijos_ver' => 'Admin Prefijos Ver',
			'admin_prefijos_editar' => 'Admin Prefijos Editar',
			'admin_prefijos_eliminar' => 'Admin Prefijos Eliminar',
			'sms_recibidos' => 'Sms Recibidos',
			'administrar_exentos_propuestos' => 'Administrar Exentos Propuestos',
			'sms_enviados_por_cliente' => 'Sms Enviados Por Cliente',
			'crear_promo_personalizada' => 'Crear Promo Personalizada',
			'admin_pruebas_modems' => 'Admin Pruebas Modems',
			'administrar_modem_sin_saldo' => 'Administrar Modem Sin Saldo',
			'administrar_reasignar_puertos_por_promo' => 'Administrar Reasignar Puertos Por Promo',
			'administrar_reporte_vigilancia' => 'Administrar Reporte Vigilancia',
			'administrar_terminos_condiciones' => 'Administrar Terminos Condiciones',
			'administrar_aprobar_promocion' => 'Administrar Aprobar Promocion',
			'administrar_operadoras' => 'Administrar Operadoras',
			'habilitar_modem_inactivos' => 'Habilitar Modem Inactivos',
			'generar_reporte_sms_recibidos' => 'Generar Reporte Sms Recibidos',
			'broadcasting' => 'Broadcasting',
			'broadcasting_premium' => 'Broadcasting Premium',
			'crear_promo_premium' => 'Crear Promo Premium',
			'ver_detalles_premium' => 'Ver Detalles Premium',
			'ver_reporte_premium' => 'Ver Reporte Premium',
			'generar_reporte_sms_recibidos_premium' => 'Generar Reporte Sms Recibidos Premium',
			'broadcasting_lite' => 'Broadcasting Lite',
			'crear_promo_lite' => 'Crear Promo Lite',
			'reactivar_promo' => 'Reactivar Promo',
			'acceso_en_suspension' => 'Acceso En Suspension',
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
		$criteria->compare('acceso_conciliacion',$this->acceso_conciliacion,true);
		$criteria->compare('acceso_CRS',$this->acceso_CRS,true);
		$criteria->compare('crear_promo',$this->crear_promo,true);
		$criteria->compare('ver_detalles',$this->ver_detalles,true);
		$criteria->compare('ver_destinatarios',$this->ver_destinatarios,true);
		$criteria->compare('sms_enviados',$this->sms_enviados,true);
		$criteria->compare('crear_lista',$this->crear_lista,true);
		$criteria->compare('ver_lista',$this->ver_lista,true);
		$criteria->compare('editar_lista',$this->editar_lista,true);
		$criteria->compare('editar_detalles',$this->editar_detalles,true);
		$criteria->compare('editar_destinatarios',$this->editar_destinatarios,true);
		$criteria->compare('sms_prog',$this->sms_prog,true);
		$criteria->compare('crear_not',$this->crear_not,true);
		$criteria->compare('ver_not',$this->ver_not,true);
		$criteria->compare('agregar_exen',$this->agregar_exen,true);
		$criteria->compare('ver_exen',$this->ver_exen,true);
		$criteria->compare('eliminar_exen',$this->eliminar_exen,true);
		$criteria->compare('num_cruzados',$this->num_cruzados,true);
		$criteria->compare('admin_accesos',$this->admin_accesos,true);
		$criteria->compare('admin_puertos_usuario',$this->admin_puertos_usuario,true);
		$criteria->compare('admin_puertos_ver',$this->admin_puertos_ver,true);
		$criteria->compare('admin_puertos_crear',$this->admin_puertos_crear,true);
		$criteria->compare('admin_puertos_editar',$this->admin_puertos_editar,true);
		$criteria->compare('admin_puertos_eliminar',$this->admin_puertos_eliminar,true);
		$criteria->compare('admin_cupo',$this->admin_cupo,true);
		$criteria->compare('admin_prefijos_ver',$this->admin_prefijos_ver,true);
		$criteria->compare('admin_prefijos_editar',$this->admin_prefijos_editar,true);
		$criteria->compare('admin_prefijos_eliminar',$this->admin_prefijos_eliminar,true);
		$criteria->compare('sms_recibidos',$this->sms_recibidos,true);
		$criteria->compare('administrar_exentos_propuestos',$this->administrar_exentos_propuestos,true);
		$criteria->compare('sms_enviados_por_cliente',$this->sms_enviados_por_cliente,true);
		$criteria->compare('crear_promo_personalizada',$this->crear_promo_personalizada,true);
		$criteria->compare('admin_pruebas_modems',$this->admin_pruebas_modems,true);
		$criteria->compare('administrar_modem_sin_saldo',$this->administrar_modem_sin_saldo,true);
		$criteria->compare('administrar_reasignar_puertos_por_promo',$this->administrar_reasignar_puertos_por_promo,true);
		$criteria->compare('administrar_reporte_vigilancia',$this->administrar_reporte_vigilancia,true);
		$criteria->compare('administrar_terminos_condiciones',$this->administrar_terminos_condiciones,true);
		$criteria->compare('administrar_aprobar_promocion',$this->administrar_aprobar_promocion,true);
		$criteria->compare('administrar_operadoras',$this->administrar_operadoras,true);
		$criteria->compare('habilitar_modem_inactivos',$this->habilitar_modem_inactivos,true);
		$criteria->compare('generar_reporte_sms_recibidos',$this->generar_reporte_sms_recibidos,true);
		$criteria->compare('broadcasting',$this->broadcasting,true);
		$criteria->compare('broadcasting_premium',$this->broadcasting_premium,true);
		$criteria->compare('crear_promo_premium',$this->crear_promo_premium,true);
		$criteria->compare('ver_detalles_premium',$this->ver_detalles_premium,true);
		$criteria->compare('ver_reporte_premium',$this->ver_reporte_premium,true);
		$criteria->compare('generar_reporte_sms_recibidos_premium',$this->generar_reporte_sms_recibidos_premium,true);
		$criteria->compare('broadcasting_lite',$this->broadcasting_lite,true);
		$criteria->compare('crear_promo_lite',$this->crear_promo_lite,true);
		$criteria->compare('reactivar_promo',$this->reactivar_promo);
		$criteria->compare('acceso_en_suspension',$this->acceso_en_suspension,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accesos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
