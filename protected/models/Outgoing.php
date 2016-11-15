<?php

/**
 * This is the model class for table "outgoing".
 *
 * The followings are the available columns in table 'outgoing':
 * @property string $id_sms
 * @property string $id_promo
 * @property string $number
 * @property string $status
 * @property string $frecuency
 * @property string $date_sent
 * @property string $time_sent
 * @property string $date_loaded
 * @property string $time_loaded
 * @property string $loaded_by
 * @property string $date_program
 * @property string $time_program
 * @property string $content
 * @property string $id_cliente
 */
class Outgoing extends CActiveRecord
{
	public $buscar;
	public $descripcion_oper;
	public $descripcion_estado;
	public $id_operadora;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'outgoing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number', 'required'),
			array('id_promo, frecuency, id_cliente', 'length', 'max'=>10),
			array('number', 'length', 'max'=>15),
			array('status', 'length', 'max'=>1),
			array('loaded_by', 'length', 'max'=>45),
			array('content', 'length', 'max'=>255),
			array('date_sent, time_sent, date_loaded, time_loaded, date_program, time_program', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sms, id_promo, number, status, frecuency, date_sent, time_sent, date_loaded, time_loaded, loaded_by, date_program, time_program, content, id_cliente', 'safe', 'on'=>'search'),
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
			'id_sms' => 'Id Sms',
			'id_promo' => 'Id Promo',
			'number' => 'Number',
			'status' => 'Status',
			'frecuency' => 'Frecuency',
			'date_sent' => 'Date Sent',
			'time_sent' => 'Time Sent',
			'date_loaded' => 'Date Loaded',
			'time_loaded' => 'Time Loaded',
			'loaded_by' => 'Loaded By',
			'date_program' => 'Date Program',
			'time_program' => 'Time Program',
			'content' => 'Content',
			'id_cliente' => 'Id Cliente',
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

		$criteria->compare('id_sms',$this->id_sms,true);
		$criteria->compare('id_promo',$this->id_promo,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('frecuency',$this->frecuency,true);
		$criteria->compare('date_sent',$this->date_sent,true);
		$criteria->compare('time_sent',$this->time_sent,true);
		$criteria->compare('date_loaded',$this->date_loaded,true);
		$criteria->compare('time_loaded',$this->time_loaded,true);
		$criteria->compare('loaded_by',$this->loaded_by,true);
		$criteria->compare('date_program',$this->date_program,true);
		$criteria->compare('time_program',$this->time_program,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('id_cliente',$this->id_cliente,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchDetalleBCNL($id_promo)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.number, t.status, e.descripcion AS descripcion_estado, o.descripcion AS descripcion_oper, o.id_operadora_bcnl AS id_operadora";
		$criteria->join =  "LEFT JOIN status_outgoing e ON t.status = e.status ";
		$criteria->join .= "LEFT JOIN (SELECT descripcion, prefijo, id_operadora_bcnl FROM insignia_masivo_premium.operadoras_relacion GROUP BY prefijo) AS o
							ON SUBSTRING(number,2,3) = o.prefijo";
		$criteria->compare('id_promo',$id_promo);
		$criteria->condition .= " AND (number LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "e.descripcion LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= " o.descripcion LIKE '%".$this->buscar."%') ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'number', 'o.descripcion', 'e.descripcion'
        		),
    		),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Outgoing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
