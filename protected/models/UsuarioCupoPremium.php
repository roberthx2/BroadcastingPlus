<?php

/**
 * This is the model class for table "usuario_cupo_premium".
 *
 * The followings are the available columns in table 'usuario_cupo_premium':
 * @property integer $id_usuario
 * @property integer $disponible
 */
class UsuarioCupoPremium extends CActiveRecord
{
	public $buscar;
	public $login;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario_cupo_premium';
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
			array('id_usuario, disponible', 'numerical', 'integerOnly'=>true),
			array('fecha_vencimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_usuario, disponible, fecha_vencimiento', 'safe', 'on'=>'search'),
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
			'disponible' => 'Disponible',
			'fecha_vencimiento' => 'Vencimiento'
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

		$criteria->select = "t.id_usuario, t.disponible, t.fecha_vencimiento, u.login AS login";
		$criteria->join = "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario";
		$criteria->condition = "login LIKE '%".$this->buscar."%'";

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
		return Yii::app()->db_masivo_premium;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuarioCupoPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
