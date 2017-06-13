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
			'sc' => 'Short Code',
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
		$this->tipo_busqueda = (isset($_SESSION["tipo_busqueda"]) == true) ? $_SESSION["tipo_busqueda"] : null;

		if ($this->tipo_busqueda == 1) //Mes
		{
			$condicion = "year = ".$_SESSION["year"]." AND month = ".$_SESSION["month"];
		}
		else if ($this->tipo_busqueda == 2) //Periodo
		{
			$condicion = "fecha BETWEEN '".$_SESSION["fecha_ini"]."' AND '".$_SESSION["fecha_fin"]."'";
		}
		else if ($this->tipo_busqueda == 3) //Dia
		{
			$condicion = "fecha = '".$_SESSION["fecha"]."'";
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
		/*$this->tipo_busqueda = (isset($_SESSION["objeto"]["tipo_busqueda"]) == true) ? $_SESSION["objeto"]["tipo_busqueda"] : null;
		$this->table = (isset($_SESSION["objeto"]["table"]) == true) ? $_SESSION["objeto"]["table"] : "resumen_bcp_mensual";

		if ($this->tipo_busqueda == 1) //Mes
		{
			$condicion = "year = ".$_SESSION["objeto"]["year"]." AND month = ".$_SESSION["objeto"]["month"];
			//$condicion = "year = 2017 AND month = 5";
		}
		else if ($this->tipo_busqueda == 2) //Periodo
		{
			$condicion = "fecha BETWEEN '".$_SESSION["objeto"]["fecha_ini"]."' AND '".$_SESSION["objeto"]["fecha_fin"]."'";
		}
		else if ($this->tipo_busqueda == 3) //Dia
		{
			$condicion = "fecha = '".$_SESSION["objeto"]["fecha"]."'";
		}
		else
		{*/
			$condicion = "false";
		//}

		/*print_r($_SESSION["objeto"]["table"]."<br>");
		print_r($_SESSION["objeto"]["year"]."<br>");
		print_r($_SESSION["objeto"]["month"]."<br>");
		print_r($_SESSION["objeto"]["fecha_ini"]."<br>");
		print_r($_SESSION["objeto"]["fecha_fin"]."<br>");
		print_r($_SESSION["objeto"]["fecha"]."<br>");
		print_r($_SESSION["objeto"]["tipo_busqueda"]."<br>");*/

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT sc AS id, sc, $cond_oper->descripcion FROM (
					SELECT r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE ".$condicion." GROUP BY r.sc, r.operadora) AS t 
				GROUP BY sc";

		/*$criteria = new CDbCriteria;
		$criteria->select = "sc, $cond_oper->descripcion "*/

		/*$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.sc',
			'pagination'=>array(
		        //'route'=>Yii::app()->createUrl('reportes/mensualSmsPorCodigo', array( 'Agent' => 'asas' ) ),
				 'pageSize'=>10,
		        //'params'=>array("asd"=>"sss"),
		    ),
			'sort'=>array(
				//'route'=>Yii::app()->createUrl('reportes/mensualSmsPorCodigo', array( 'Agent' => 'asas' ) ),
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
        		),
    		),
		));*/

		$count=Yii::app()->db_masivo_premium->createCommand("SELECT COUNT(*) FROM (".$sql.") AS tabla")->queryScalar();
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
		        //'route'=>Yii::app()->createUrl('reportes/mensualSmsPorCodigo', array("asddd"=>"asas")),
		        //'params'=>array("asd"=>"sss"),
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
