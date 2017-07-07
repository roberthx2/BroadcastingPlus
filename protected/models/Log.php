<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $id
 * @property integer $id_usuario
 * @property string $ip_usuario
 * @property string $ip_servidor
 * @property string $fecha
 * @property string $hora
 * @property string $descripcion
 * @property string $controller_action
 */
class Log extends CActiveRecord
{
	public $buscar;
	public $login;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, ip_usuario, ip_servidor, fecha, hora, descripcion, controller_action', 'required'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('ip_usuario, ip_servidor', 'length', 'max'=>25),
			array('descripcion', 'length', 'max'=>300),
			array('controller_action', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usuario, ip_usuario, ip_servidor, fecha, hora, descripcion, controller_action', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'ip_usuario' => 'Ip Usuario',
			'ip_servidor' => 'Ip Servidor',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'descripcion' => 'Descripcion',
			'controller_action' => 'Controller Action',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('ip_usuario',$this->ip_usuario,true);
		$criteria->compare('ip_servidor',$this->ip_servidor,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('controller_action',$this->controller_action,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_usuario, hora, descripcion, CASE t.id_usuario WHEN 0 THEN 'SISTEMA' ELSE u.login END AS login";
		$criteria->join = "LEFT JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario";
		$criteria->condition = "fecha = '".date("Y-m-d")."' AND ";
		$criteria->condition .= "(login LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "hora LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "descripcion LIKE '%".$this->buscar."%')";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'hora DESC',
        		'attributes'=>array(
             		'hora'
        		),
    		),
    		'pagination'=>array(
		        'pageSize'=>20,
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
	 * @return Log the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
