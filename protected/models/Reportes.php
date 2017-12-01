<?php
 
class Reportes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $year;
	public $month;
	public $fecha;
	public $fecha_ini;
	public $fecha_fin;
	public $tipo_busqueda; //1. Mes / 2.Periodo / 3. Dia
	public $table;
	public $total;
	public $id_cliente_bcnl;

	//private $tableName = 'resumen_bcp_mensual'; // <=default value
    //private static $_models=array();
    //private $_md;

    /*public function __construct($scenario=null, $tableName = null)
    {

        if($this->tableName === 'resumen_bcp_mensual' && $tableName !== null){
            $this->tableName = $tableName;
        }

        parent::__construct($scenario, $tableName);
    }

    public static function model($tableName = false, $className=__CLASS__)
    {
        if($tableName === null) $className=null; // this string will save internal CActiveRecord functionality
        if(!$tableName)
            return parent::model($className);

        if(isset(self::$_models[$tableName.$className]))
            return self::$_models[$tableName.$className];
        else
        {
            $model=self::$_models[$tableName.$className]=new $className(null);
            $model->tableName = $tableName;

            $model->_md=new CActiveRecordMetaData($model);
            $model->attachBehaviors($model->behaviors());

            return $model;
        }
    }

    public function tableName()
    {
        return $this->tableName;
    }

    /**
     * Returns the meta-data for this AR
     * @return CActiveRecordMetaData the meta for this AR class.
     */
   /* public function getMetaData()
    {
        if($this->_md!==null)
            return $this->_md;
        else
            return $this->_md=static::model($this->tableName())->_md;
    }

    public function refreshMetaData()
    {
        $finder=static::model($this->tableName());
        $finder->_md=new CActiveRecordMetaData($finder);
        if($this!==$finder)
            $this->_md=$finder->_md;
    }*/

	public function tableName()
	{
		return 'resumen_bcp_mensual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	/*public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('id_modulo, descripcion_corta, descripcion_larga', 'required'),
			array('id_modulo, estado', 'numerical', 'integerOnly'=>true),
			array('descripcion_corta', 'length', 'max'=>10),
			array('descripcion_larga', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_modulo, descripcion_corta, descripcion_larga, estado', 'safe', 'on'=>'search'),*/
		/*);
	}*/

	public function attributeLabels()
	{
		return array(
			'year' => 'Año',
			'month' => 'Mes',
			'fecha_ini' => 'Inicio',
			'fecha_fin' => 'Fin',
			'Sc' => 'Short Code',
			'operadora' => 'Operadora',
			'cantidad' => 'Total',
			'id_cliente_bcnl' => 'Cliente',
		);
	}

	public function getDbConnection()
	{
		return Yii::app()->db_masivo_premium;
	}

	/*public function searchSmsPorCodigo()
	{
		if ($this->tipo_busqueda == 1) //Mes
		{
			$condicion = "year = ".$this->year." AND month = ".$this->month;
		}
		else if ($this->tipo_busqueda == 2) //Periodo
		{
			$condicion = "fecha BETWEEN '".$this->fecha_ini."' AND '".$this->fecha_fin."'";
		}
		else if ($this->tipo_busqueda == 3) //Dia
		{
			$condicion = "fecha = '".$this->fecha."'";
		}
		else
		{
			$condicion = "false";
		}

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT sc AS id, sc, $cond_oper->descripcion FROM (
					SELECT r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM ".$this->scenario." r 
						WHERE ".$condicion." GROUP BY r.sc, r.operadora) AS t 
				GROUP BY sc";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.sc',
			'sort'=>array(
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
        		),
    		),
		));

/*		$count=Yii::app()->db_masivo_premium->createCommand("SELECT COUNT(*) FROM (".$sql.") AS tabla")->queryScalar();
		//$sql='SELECT * FROM tbl_user';
		return new CSqlDataProvider($sql, array(
			'db'=>Yii::app()->db_masivo_premium,
		    'totalItemCount'=>$count,
		    'sort'=>array(
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
        		),
    		),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));*/
	//}

	public function searchSmsPorCodigo()
	{
		//Consulta por defecto, no traee ningun resultado solo es para que se muestre la data table
		$condicion = "false";

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
		        'route'=>'reportes/smsPorCodigo',
				'pageSize'=>10,
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
		//Consulta por defecto, no traee ningun resultado solo es para que se muestre la data table
		$condicion = "false";

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_cliente_bcnl AS id, id_cliente_bcnl, $cond_oper->descripcion FROM (
					SELECT r.id_cliente_bcnl, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.id_cliente_bcnl, r.operadora) AS t 
				GROUP BY id_cliente_bcnl";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_cliente_bcnl',
			'pagination'=>array(
		        'route'=>'reportes/smsPorClienteBcp',
				'pageSize'=>10,
		    ),
			'sort'=>array(
				'defaultOrder'=>'id_cliente_bcnl DESC',
        		'attributes'=>array(
             		'id_cliente_bcnl',
        		),
    		),
		));
	}

	public function searchEnviadosBCP()
	{
		//Consulta por defecto, no traee ningun resultado solo es para que se muestre la data table
		$condicion = "false";

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_promo AS id, sc, fecha, nombrePromo, $cond_oper->descripcion FROM (
					SELECT r.id_promo, r.sc, r.operadora, r.fecha, r.nombrePromo, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_promocion r 
						WHERE ".$condicion." GROUP BY r.id_promo, r.operadora) AS t 
				GROUP BY id_promo";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_promo',
			'pagination'=>array(
		        'route'=>'reportes/smsEnviadosBcp',
				'pageSize'=>10,
		    ),
			'sort'=>array(
				'defaultOrder'=>'fecha DESC',
        		'attributes'=>array(
             		'fecha', 'nombrePromo', 'sc'
        		),
    		),
		));
	}

	public function searchSmsPorCodigoCliente()
	{
		//Consulta por defecto, no traee ningun resultado solo es para que se muestre la data table
		$condicion = "false";

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_cliente_bcnl AS id, sc, $cond_oper->descripcion FROM (
					SELECT r.id_cliente_bcnl, r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.id_cliente_bcnl, r.sc, r.operadora) AS t 
				GROUP BY id_cliente_bcnl, sc";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_cliente_bcnl',
			'pagination'=>array(
		        'route'=>'reportes/smsPorCodigoCliente',
				'pageSize'=>10,
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BroadcastingModulos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
