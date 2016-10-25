<?php

/**
 * This is the model class for table "cliente".
 *
 * The followings are the available columns in table 'cliente':
 * @property integer $Id_cliente
 * @property string $Des_cliente
 * @property string $persona_contacto
 * @property string $telf_fijo
 * @property string $telf_cel
 * @property string $email
 * @property string $direccion
 * @property string $logo
 * @property string $creado
 * @property string $downloads_info
 * @property string $iniciales_cliente
 */
class ClienteSms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persona_contacto, telf_fijo, telf_cel, email, direccion, logo, iniciales_cliente', 'required'),
			array('Des_cliente, persona_contacto, direccion, logo', 'length', 'max'=>150),
			array('telf_fijo, telf_cel', 'length', 'max'=>15),
			array('email', 'length', 'max'=>50),
			array('creado', 'length', 'max'=>255),
			array('iniciales_cliente', 'length', 'max'=>10),
			array('downloads_info', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_cliente, Des_cliente, persona_contacto, telf_fijo, telf_cel, email, direccion, logo, creado, downloads_info, iniciales_cliente', 'safe', 'on'=>'search'),
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
			'Id_cliente' => 'Id Cliente',
			'Des_cliente' => 'Des Cliente',
			'persona_contacto' => 'Persona Contacto',
			'telf_fijo' => 'Telf Fijo',
			'telf_cel' => 'Telf Cel',
			'email' => 'Email',
			'direccion' => 'Direccion',
			'logo' => 'Logo',
			'creado' => 'Creado',
			'downloads_info' => 'Downloads Info',
			'iniciales_cliente' => 'Iniciales Cliente',
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

		$criteria->compare('Id_cliente',$this->Id_cliente);
		$criteria->compare('Des_cliente',$this->Des_cliente,true);
		$criteria->compare('persona_contacto',$this->persona_contacto,true);
		$criteria->compare('telf_fijo',$this->telf_fijo,true);
		$criteria->compare('telf_cel',$this->telf_cel,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('downloads_info',$this->downloads_info,true);
		$criteria->compare('iniciales_cliente',$this->iniciales_cliente,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	 * @return ClienteSms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
