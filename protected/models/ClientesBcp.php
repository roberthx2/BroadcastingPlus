<?php

/**
 * This is the model class for table "clientes_bcp".
 *
 * The followings are the available columns in table 'clientes_bcp':
 * @property integer $id
 * @property integer $id_cliente_bcp
 * @property integer $id_cliente_sms
 * @property integer $sc
 * @property integer $id_operadora
 * @property integer $alfanumerico
 */
class ClientesBcp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $buscar;

	public function tableName()
	{
		return 'clientes_bcp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cliente_bcp, id_cliente_sms, sc, id_operadora, alfanumerico', 'required'),
			array('id_cliente_bcp, id_cliente_sms, sc, id_operadora, alfanumerico', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_cliente_bcp, id_cliente_sms, sc, id_operadora, alfanumerico', 'safe', 'on'=>'search'),
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
			'id_cliente_bcp' => 'Id Cliente Bcp',
			'id_cliente_sms' => 'Id Cliente Sms',
			'sc' => 'Sc',
			'id_operadora' => 'Id Operadora',
			'alfanumerico' => 'Alfanumerico',
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
		$criteria->compare('id_cliente_bcp',$this->id_cliente_bcp);
		$criteria->compare('id_cliente_sms',$this->id_cliente_sms);
		$criteria->compare('sc',$this->sc);
		$criteria->compare('id_operadora',$this->id_operadora);
		$criteria->compare('alfanumerico',$this->alfanumerico);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$id_clientes_sms = "-1";

		if ($this->buscar != "")
		{
			$sql = "SELECT GROUP_CONCAT(id_cliente) AS id_clientes_sms FROM cliente WHERE Des_cliente LIKE '%".$this->buscar."%'";
			$id_clientes_sms = Yii::app()->db_sms->createCommand($sql)->queryRow($sql);
			$id_clientes_sms = ($id_clientes_sms["id_clientes_sms"] == "") ? "-1" : $id_clientes_sms["id_clientes_sms"];
		}

		$criteria=new CDbCriteria;

		//$criteria->select = "t.id_cliente_sms, GROUP_CONCAT(DISTINCT c.sc SEPARATOR ', ') AS sc";
		$criteria->select = "t.id_cliente_sms, REPLACE(TRIM(BOTH ',' FROM REGEXP_REPLACE(GROUP_CONCAT(DISTINCT CASE c.onoff WHEN 0 THEN '' ELSE c.sc END), ',{2,}', ',')), ',', ', ') AS sc";
		$criteria->join = "INNER JOIN cliente c ON t.id_cliente_bcp = c.id";
		$criteria->condition = "(c.sc != '') ";
		$criteria->group = "t.id_cliente_sms";
		$criteria->having = "sc LIKE '%".$this->buscar."%' OR t.id_cliente_sms IN (".$id_clientes_sms.")";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id_cliente_sms DESC',
        		'attributes'=>array(
             		'id_clientes_sms', 'sc'
        		),
    		),
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_insignia_alarmas;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientesBcp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
