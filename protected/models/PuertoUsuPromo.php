<?php

/**
 * This is the model class for table "puerto_usu_promo".
 *
 * The followings are the available columns in table 'puerto_usu_promo':
 * @property string $id_usuario
 * @property string $id_promo
 * @property string $id_modem
 * @property string $modem_principal
 */
class PuertoUsuPromo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'puerto_usu_promo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_promo, id_modem, modem_principal', 'required'),
			array('id_usuario, id_promo, modem_principal', 'length', 'max'=>10),
			array('id_modem', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, id_promo, id_modem, modem_principal', 'safe', 'on'=>'search'),
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
			'id_promo' => 'Id Promo',
			'id_modem' => 'Id Modem',
			'modem_principal' => 'Modem Principal',
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
		$criteria->compare('id_promo',$this->id_promo,true);
		$criteria->compare('id_modem',$this->id_modem,true);
		$criteria->compare('modem_principal',$this->modem_principal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PuertoUsuPromo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
