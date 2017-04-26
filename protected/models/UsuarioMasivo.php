<?php

/**
 * This is the model class for table "Usuario".
 *
 * The followings are the available columns in table 'Usuario':
 * @property string $id_usuario
 * @property string $login
 * @property string $pwd
 * @property integer $creado
 * @property string $cupo_sms
 * @property string $sms_usados
 * @property string $cadena_promo
 * @property string $acceso_listas
 * @property string $cadena_listas
 * @property string $puertos
 * @property string $fecha_creado
 * @property string $puertos_de_respaldo
 */
class UsuarioMasivo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $buscar;
	public $acceso_sistema;

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
			array('id_usuario, cadena_promo, cadena_listas, fecha_creado', 'required'),
			array('creado', 'numerical', 'integerOnly'=>true),
			array('id_usuario, acceso_listas', 'length', 'max'=>10),
			array('login', 'length', 'max'=>60),
			array('pwd', 'length', 'max'=>90),
			array('cupo_sms, sms_usados', 'length', 'max'=>14),
			array('puertos_de_respaldo', 'length', 'max'=>100),
			array('puertos', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, login, pwd, creado, cupo_sms, sms_usados, cadena_promo, acceso_listas, cadena_listas, puertos, fecha_creado, puertos_de_respaldo', 'safe', 'on'=>'search'),
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
			'creado' => 'Creado',
			'cupo_sms' => 'Cupo Sms',
			'sms_usados' => 'Sms Usados',
			'cadena_promo' => 'Cadena Promo',
			'acceso_listas' => 'Acceso Listas',
			'cadena_listas' => 'Cadena Listas',
			'puertos' => 'Puertos',
			'fecha_creado' => 'Fecha Creado',
			'puertos_de_respaldo' => 'Puertos De Respaldo',
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('creado',$this->creado);
		$criteria->compare('cupo_sms',$this->cupo_sms,true);
		$criteria->compare('sms_usados',$this->sms_usados,true);
		$criteria->compare('cadena_promo',$this->cadena_promo,true);
		$criteria->compare('acceso_listas',$this->acceso_listas,true);
		$criteria->compare('cadena_listas',$this->cadena_listas,true);
		$criteria->compare('puertos',$this->puertos,true);
		$criteria->compare('fecha_creado',$this->fecha_creado,true);
		$criteria->compare('puertos_de_respaldo',$this->puertos_de_respaldo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchAccesoBcplus()
	{
		$criteria = new CDbCriteria;

		$criteria->select = "t.id_usuario, login, IFNULL(p.acceso_sistema, 0) AS acceso_sistema";
		$criteria->join = "LEFT JOIN insignia_masivo_premium.permisos p ON t.id_usuario = p.id_usuario";
		$criteria->condition = "login LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'login ASC',
        		'attributes'=>array(
             		'login'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>1000000,
    		),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuarioMasivo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
