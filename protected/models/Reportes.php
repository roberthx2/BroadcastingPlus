<?php

class Reportes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	/*public $anio;
	public $mes;
	public $fecha_ini;
	public $fecha_fin;
	/*public $sc;
	public $id_cliente_bcnl;
	public $cantidad;
	public $operadora;*/
	public $year;
	public $month;
	public $fecha;
	public $fecha_ini;
	public $fecha_fin;
	public $tipo_busqueda; //1. Mes / 2.Periodo / 3. Dia

	private $tableName = 'resumen_bcp_mensual'; // <=default value
    private static $_models=array();
    private $_md;

    public function __construct($scenario=null, $tableName = null)
    {
    	/*print_r($scenario."<br>");
    	print_r($tableName."<br>");
    	print_r($this->tableName."<br>");*/

        if($this->tableName === 'resumen_bcp_mensual' && $tableName !== null){
            $this->tableName = $tableName;
        }

        //print_r($this->tableName."<br>");

        parent::__construct($scenario, $tableName);

        //print_r($this->tableName."<br>");
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
    public function getMetaData()
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
    }

	/*public function tableName()
	{
		return 'broadcasting_modulos';
	}*/

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
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
		);
	}

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

	public function searchSmsPorCodigo()
	{
		/*if ($this->mes == "")
			$this->mes = date("m");

		if ($this->anio == "")
			$this->anio = date("Y");*/

		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(CONCAT('IFNULL(GROUP_CONCAT((SELECT t.cantd_msj FROM operadoras_activas o WHERE t.operadora = ', id_operadora, ' AND o.id_operadora = t.operadora )), 0) AS ', descripcion) SEPARATOR ', ') AS descripcion";
		$cond_oper = OperadorasActivas::model()->find($criteria);

		$sql = "SELECT id_mensual AS id, sc, $cond_oper->descripcion FROM (
					SELECT id_mensual, r.sc, r.operadora, SUM(r.cantd_msj) AS cantd_msj FROM resumen_bcp_mensual r 
						WHERE year = 2017 AND month = 4 GROUP BY r.sc, r.operadora) AS t 
				GROUP BY sc";

		$criteria=Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

		return new CArrayDataProvider($criteria, array(
			'id'=>'t.id_mensual',
			'sort'=>array(
				'defaultOrder'=>'sc DESC',
        		'attributes'=>array(
             		'sc',
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
	/*public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}*/
}
