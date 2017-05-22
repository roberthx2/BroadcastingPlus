<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id_usuario
 * @property string $login
 * @property string $pwd
 * @property integer $id_perfil
 * @property string $id_cliente
 * @property string $id_integ
 * @property string $email_u
 * @property string $cadena_sc
 * @property string $creado
 * @property string $cadena_serv
 * @property string $acceso_masivo
 * @property string $acceso_triviaweb
 * @property string $cadena_promo
 * @property string $edicion_clasificados
 * @property string $reportes_clasificados
 * @property string $acceso_digitelstats
 * @property string $cadena_cintillo
 * @property string $acceso_admin
 * @property integer $acceso_analisis
 * @property string $ver_numero
 */
class UsuarioSms extends CActiveRecord
{
	public $buscar;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cadena_sc, cadena_promo, cadena_cintillo, acceso_analisis', 'required'),
			array('id_perfil, acceso_analisis', 'numerical', 'integerOnly'=>true),
			array('login', 'length', 'max'=>60),
			array('pwd', 'length', 'max'=>90),
			array('id_cliente, ver_numero', 'length', 'max'=>3),
			array('id_integ, email_u', 'length', 'max'=>255),
			array('creado', 'length', 'max'=>50),
			array('acceso_masivo, acceso_triviaweb, edicion_clasificados, reportes_clasificados, acceso_digitelstats, acceso_admin', 'length', 'max'=>1),
			array('cadena_serv', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, login, pwd, id_perfil, id_cliente, id_integ, email_u, cadena_sc, creado, cadena_serv, acceso_masivo, acceso_triviaweb, cadena_promo, edicion_clasificados, reportes_clasificados, acceso_digitelstats, cadena_cintillo, acceso_admin, acceso_analisis, ver_numero', 'safe', 'on'=>'search'),
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
			'login' => 'Login',
			'pwd' => 'Pwd',
			'id_perfil' => 'Id Perfil',
			'id_cliente' => 'Id Cliente',
			'id_integ' => 'Id Integ',
			'email_u' => 'Email U',
			'cadena_sc' => 'Cadena Sc',
			'creado' => 'Creado',
			'cadena_serv' => 'Cadena Serv',
			'acceso_masivo' => 'Acceso Masivo',
			'acceso_triviaweb' => 'Acceso Triviaweb',
			'cadena_promo' => 'Cadena Promo',
			'edicion_clasificados' => 'Edicion Clasificados',
			'reportes_clasificados' => 'Reportes Clasificados',
			'acceso_digitelstats' => 'Acceso Digitelstats',
			'cadena_cintillo' => 'Cadena Cintillo',
			'acceso_admin' => 'Acceso Admin',
			'acceso_analisis' => 'Acceso Analisis',
			'ver_numero' => 'Ver Numero',
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
	/*public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('id_perfil',$this->id_perfil);
		$criteria->compare('id_cliente',$this->id_cliente,true);
		$criteria->compare('id_integ',$this->id_integ,true);
		$criteria->compare('email_u',$this->email_u,true);
		$criteria->compare('cadena_sc',$this->cadena_sc,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('cadena_serv',$this->cadena_serv,true);
		$criteria->compare('acceso_masivo',$this->acceso_masivo,true);
		$criteria->compare('acceso_triviaweb',$this->acceso_triviaweb,true);
		$criteria->compare('cadena_promo',$this->cadena_promo,true);
		$criteria->compare('edicion_clasificados',$this->edicion_clasificados,true);
		$criteria->compare('reportes_clasificados',$this->reportes_clasificados,true);
		$criteria->compare('acceso_digitelstats',$this->acceso_digitelstats,true);
		$criteria->compare('cadena_cintillo',$this->cadena_cintillo,true);
		$criteria->compare('acceso_admin',$this->acceso_admin,true);
		$criteria->compare('acceso_analisis',$this->acceso_analisis);
		$criteria->compare('ver_numero',$this->ver_numero,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->select = "id_usuario, login";
		$criteria->condition = "login LIKE '%".$this->buscar."%'";

		if (Yii::app()->user->id != 1)//Godadmin
			$criteria->condition .= " AND id_usuario != ".Yii::app()->user->id;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'login ASC',
        		'attributes'=>array(
             		'login'
        		),
    		),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_sms;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuarioSms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
