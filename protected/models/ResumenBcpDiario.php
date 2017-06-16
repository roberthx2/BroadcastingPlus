<?php

/**
 * This is the model class for table "resumen_bcp_diario".
 *
 * The followings are the available columns in table 'resumen_bcp_diario':
 * @property integer $id_diario
 * @property integer $id_cliente_bcnl
 * @property integer $id_cliente_bcp
 * @property string $fecha
 * @property integer $cantd_msj
 * @property integer $operadora
 * @property string $sc
 */
class ResumenBcpDiario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $id;
	public $fecha_ini;
	public $fecha_fin;
	
	public function tableName()
	{
		return 'resumen_bcp_diario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cliente_bcnl, id_cliente_bcp, fecha, cantd_msj, operadora, sc', 'required'),
			array('id_cliente_bcnl, id_cliente_bcp, cantd_msj, operadora', 'numerical', 'integerOnly'=>true),
			array('sc', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_diario, id_cliente_bcnl, id_cliente_bcp, fecha, cantd_msj, operadora, sc', 'safe', 'on'=>'search'),
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
			'id_diario' => 'Id Diario',
			'id_cliente_bcnl' => 'Id Cliente Bcnl',
			'id_cliente_bcp' => 'Id Cliente Bcp',
			'fecha' => 'Fecha',
			'cantd_msj' => 'Cantd Msj',
			'operadora' => 'Operadora',
			'sc' => 'Sc',
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

		$criteria->compare('id_diario',$this->id_diario);
		$criteria->compare('id_cliente_bcnl',$this->id_cliente_bcnl);
		$criteria->compare('id_cliente_bcp',$this->id_cliente_bcp);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('cantd_msj',$this->cantd_msj);
		$criteria->compare('operadora',$this->operadora);
		$criteria->compare('sc',$this->sc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchSmsPorCodigo()
	{
		if ($_SESSION["objeto"]["tipo_busqueda"] == 2) //Periodo
		{
			$condicion = "fecha BETWEEN '".$this->fecha_ini."' AND '".$this->fecha_fin."'";
		}
		else if ($_SESSION["objeto"]["tipo_busqueda"] == 3) //Dia
		{
			$condicion = "fecha = '".$this->fecha."'";
		}

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT sc AS id, sc, $cond_oper->descripcion FROM (
					SELECT r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_diario r 
						WHERE ".$condicion." GROUP BY r.sc, r.operadora) AS t 
				GROUP BY sc";
				print_r($sql);

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.sc',
			'pagination'=>array(
				'pageSize'=>10,
		        'route'=>'reportes/mensualSmsPorCodigo',
		    ),
			'sort'=>array(
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
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
	 * @return ResumenBcpDiario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
