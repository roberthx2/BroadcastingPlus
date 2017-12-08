<?php

/**
 * This is the model class for table "resumen_bcp_mensual".
 *
 * The followings are the available columns in table 'resumen_bcp_mensual':
 * @property integer $id_mensual
 * @property integer $id_cliente_bcnl
 * @property integer $id_cliente_bcp
 * @property integer $year
 * @property integer $month
 * @property integer $cantd_msj
 * @property integer $operadora
 * @property string $sc
 */
class ResumenBcpMensual extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id;
	
	public function tableName()
	{
		return 'resumen_bcp_mensual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cliente_bcnl, id_cliente_bcp, year, month, cantd_msj, operadora, sc', 'required'),
			array('id_cliente_bcnl, id_cliente_bcp, year, month, cantd_msj, operadora', 'numerical', 'integerOnly'=>true),
			array('sc', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_mensual, id_cliente_bcnl, id_cliente_bcp, year, month, cantd_msj, operadora, sc', 'safe', 'on'=>'search'),
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
			'id_mensual' => 'Id Mensual',
			'id_cliente_bcnl' => 'Id Cliente Bcnl',
			'id_cliente_bcp' => 'Id Cliente Bcp',
			'year' => 'Year',
			'month' => 'Month',
			'cantd_msj' => 'Cantd Msj',
			'operadora' => 'Operadora',
			'Sc' => 'Sc',
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

		$criteria->compare('id_mensual',$this->id_mensual);
		$criteria->compare('id_cliente_bcnl',$this->id_cliente_bcnl);
		$criteria->compare('id_cliente_bcp',$this->id_cliente_bcp);
		$criteria->compare('year',$this->year);
		$criteria->compare('month',$this->month);
		$criteria->compare('cantd_msj',$this->cantd_msj);
		$criteria->compare('operadora',$this->operadora);
		$criteria->compare('sc',$this->sc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchSmsPorCodigo()
	{
		$condicion = "year = ".$this->year." AND month = ".$this->month;

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT sc AS id, sc, $cond_oper->descripcion FROM (
					SELECT r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.sc, r.operadora) AS t 
				GROUP BY sc";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.sc',
			'pagination'=>array(
				'pageSize'=>10,
		        'route'=>'reportes/smsPorCodigo',
		    ),
			'sort'=>array(
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
        		),
    		),
		));
	}

	public function searchSmsPorCliente()
	{
		$condicion = "year = ".$this->year." AND month = ".$this->month;

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_cliente_bcnl AS id, id_cliente_bcnl, $cond_oper->descripcion FROM (
					SELECT r.id_cliente_bcnl, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.id_cliente_bcnl, r.operadora) AS t 
				GROUP BY id_cliente_bcnl";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		foreach ($criteria as $key => $value) {
			$criteria[$key]["id_cliente_bcnl"]=ReportesController::actionGetDescripcionClienteBCNL($value["id_cliente_bcnl"]);
		}

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_cliente_bcnl',
			'pagination'=>array(
				'pageSize'=>10,
		        'route'=>'reportes/smsPorClienteBcp',
		    ),
			'sort'=>array(
				'defaultOrder'=>'id_cliente_bcnl ASC',
        		'attributes'=>array(
             		'id_cliente_bcnl',
        		),
    		),
		));
	}

	public function searchSmsPorCodigoCliente()
	{
		$condicion = "year = ".$this->year." AND month = ".$this->month;

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_cliente_bcp AS id, id_cliente_bcnl, sc, $cond_oper->descripcion FROM (
					SELECT r.id_cliente_bcp, r.id_cliente_bcnl, r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.id_cliente_bcnl, r.sc, r.operadora) AS t 
				GROUP BY id_cliente_bcnl, sc";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_cliente_bcp',
			'pagination'=>array(
				'pageSize'=>10,
		        'route'=>'reportes/smsPorCodigoCliente',
		    ),
			'sort'=>array(
				'defaultOrder'=>'id DESC',
        		'attributes'=>array(
             		'id',
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
	 * @return ResumenBcpMensual the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
