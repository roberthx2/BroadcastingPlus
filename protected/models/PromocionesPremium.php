<?php

/**
 * This is the model class for table "promociones_premium".
 *
 * The followings are the available columns in table 'promociones_premium':
 * @property string $id_promo
 * @property string $nombrePromo
 * @property string $id_cliente
 * @property string $sc
 * @property string $estado
 * @property string $fecha
 * @property string $hora
 * @property string $loaded_by
 * @property string $contenido
 * @property string $fecha_cargada
 * @property string $hora_cargada
 * @property integer $verificada
 * @property integer $total_sms
 * @property integer $id_operadora
 */
class PromocionesPremium extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fecha_limite;
	public $hora_limite;
	public $total;
	public $enviados;
	public $login;
	public $buscar;
	public $mes;
	public $ano;
	public $id;
	public $pageSize;

	public function tableName()
	{
		return 'promociones_premium';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrePromo, id_cliente, estado, fecha, hora, loaded_by, contenido, fecha_cargada, hora_cargada', 'required'),
			array('verificada, total_sms, id_operadora', 'numerical', 'integerOnly'=>true),
			array('nombrePromo', 'length', 'max'=>100),
			array('id_cliente', 'length', 'max'=>45),
			array('sc, estado, loaded_by', 'length', 'max'=>10),
			array('contenido', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_promo, nombrePromo, id_cliente, sc, estado, fecha, hora, loaded_by, contenido, fecha_cargada, hora_cargada', 'safe', 'on'=>'searchHome'),
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
			'id_promo' => 'Id Promo',
			'nombrePromo' => 'Nombre',
			'id_cliente' => 'Cliente',
			'sc' => 'Sc',
			'estado' => 'Estado',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'loaded_by' => 'Loaded By',
			'contenido' => 'Contenido',
			'fecha_cargada' => 'Fecha Cargada',
			'hora_cargada' => 'Hora Cargada',
			'verificada' => 'Verificada',
			'ano' => 'Año',
			'total_sms' => 'Total Sms',
			'id_operadora' => 'Id Operadora',
			'pageSize' => 'Mostrar'
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

		$criteria->compare('id_promo',$this->id_promo,true);
		$criteria->compare('nombrePromo',$this->nombrePromo,true);
		$criteria->compare('id_cliente',$this->id_cliente,true);
		$criteria->compare('sc',$this->sc,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('loaded_by',$this->loaded_by,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('fecha_cargada',$this->fecha_cargada,true);
		$criteria->compare('hora_cargada',$this->hora_cargada,true);
		$criteria->compare('verificada',$this->verificada);
		$criteria->compare('total_sms',$this->total_sms);
		$criteria->compare('id_operadora',$this->id_operadora);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function searchHome2()
	{
		$sql = "SELECT GROUP_CONCAT(id_cliente) AS id_clientes FROM usuario_cliente_operadora WHERE id_usuario = ".Yii::app()->user->id;
		$id_clientes = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

		$sql = "SELECT p.id_promo AS id, u.login, p.loaded_by, p.nombrePromo, p.id_cliente, p.estado,  p.fecha, p.hora, p.contenido, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo) AS total,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo AND status = 1) AS enviados,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = CURDATE() AND id_promo = p.id_promo AND status != 1) AS no_enviados
			FROM promociones_premium AS p, deadline_outgoing_premium AS d_o, insignia_masivo.usuario AS u
			WHERE p.id_promo IN (SELECT id_promo FROM promociones_premium WHERE id_cliente IN(".$id_clientes["id_clientes"].")) AND p.fecha = CURDATE() AND p.id_promo = d_o.id_promo AND p.loaded_by = u.id_usuario
			ORDER BY p.fecha, p.id_promo DESC";

		$total = "SELECT COUNT(*) AS total FROM (".$sql.") AS TABLA";
		$total = Yii::app()->db_masivo_premium->createCommand($total)->queryRow();

		$model = new CSqlDataProvider($sql, array(
			'db'=>Yii::app()->db_masivo_premium, 
			'totalItemCount'=>$total["total"],
			'sort'=>array(
        		'attributes'=>array(
             		'fecha', 'id_promo',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
    	));

		return $model;
	}*/

	public function searchHome()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_promo, u.login, t.nombrePromo, t.estado, t.fecha, t.hora, t.contenido, d_o.fecha_limite, d_o.hora_limite, total_sms AS total,
			(SELECT COUNT(id) FROM outgoing_premium_diario WHERE fecha_in = '".date("Y-m-d")."' AND id_promo = t.id_promo AND status = 1) AS enviados";
		$criteria->join = "INNER JOIN deadline_outgoing_premium d_o ON t.id_promo = d_o.id_promo ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->condition = "t.fecha = '".date("Y-m-d")."'";

		if (!Yii::app()->user->isAdmin())
		{
			$id_cliente = Yii::app()->Procedimientos->getClienteBCPHostgator();
			$criteria->addInCondition("t.id_cliente", explode(",", $id_cliente));
		}

		$criteria->condition .= " AND (t.id_promo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.nombrePromo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "u.login LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.hora LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "d_o.hora_limite LIKE '%".$this->buscar."%')";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id_promo DESC',
				'route'=>'home/index',
        		'attributes'=>array(
             		'id_promo', 'fecha', 'nombrePromo', 'u.login', 'hora', 'd_o.hora_limite'
        		),
    		),
    		'pagination' => array(
    			//'pageSize' =>10,
    			'pageSize' =>($this->pageSize == "") ? Yii::app()->params['defaultPageSize'] : $this->pageSize,
    			'route'=>'home/index',
				//'pageSize' => (isset($_SESSION["pageSize"]) == true) ? $_SESSION["pageSize"] : Yii::app()->params['defaultPageSize']
				//Yii::app()->user->getState( 'pageSize', Yii::app()->params[ 'defaultPageSize' ] ),
			),
		));
	}

	public function searchVerDetalles()
	{
		//$sql = "SELECT GROUP_CONCAT(id_cliente) AS id_clientes FROM usuario_cliente_operadora WHERE id_usuario = ".Yii::app()->user->id;
		//$id_clientes = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

		$fecha_min = Yii::app()->Procedimientos->getMinDateHistorial();
		$fecha_max = date("Y-m-d");

		$id_clientes = Yii::app()->Procedimientos->getClienteBCPHostgator();

		$criteria=new CDbCriteria;
		//$criteria->select = "t.id_promo, t.nombrePromo, t.fecha, u.login AS login, total_sms";
		$criteria->select = "t.id_promo, u.login, t.loaded_by, t.nombrePromo, t.id_cliente, t.estado, t.fecha, t.hora, t.total_sms, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo AND status = 1) AS enviados";
		$criteria->join = "INNER JOIN deadline_outgoing_premium d_o ON t.id_promo = d_o.id_promo ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->addBetweenCondition("t.fecha", $fecha_min, $fecha_max);
		$criteria->addInCondition("t.id_cliente", explode(",", $id_clientes));
		$criteria->condition .= " AND (t.id_promo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.nombrePromo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.fecha LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "u.login LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.total_sms LIKE '%".$this->buscar."%')";
		//$criteria->order = "id_promo DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id_promo DESC',
        		'attributes'=>array(
             		'id_promo', 'fecha', 'nombrePromo', 'u.login', 'total_sms'
        		),
    		),
		));
	}

	public function searchMensualSms()
	{
		if ($this->mes == "")
			$this->mes = date("m");

		if ($this->ano == "")
			$this->ano = date("Y");

		if ($this->id_cliente == "")
		{
			$model = Yii::app()->Procedimientos->getClientesBCP(Yii::app()->user->id);

			//Obtengo el primer cliente para la busqueda automatica al ingresar por primera vez al modulo
			foreach ($model as $value)
			{
				$this->id_cliente = $value["id_cliente"];
				break;
			}
		}

		$id_clientes = Yii::app()->Procedimientos->getClienteBCPHostgatorForClienteSMS($this->id_cliente);

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_cliente,t.nombrePromo, t.fecha, total_sms,
			(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo AND status = 1) AS enviados";
		$criteria->addBetweenCondition("fecha", date($this->ano."-".$this->mes."-01"), Yii::app()->Funciones->getUltimoDiaMes($this->ano, $this->mes));
		$criteria->addInCondition("id_cliente", explode(",", $id_clientes));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id_promo DESC',
        		'attributes'=>array(
             		'nombrePromo', 'fecha', 'total_sms'
        		),
    		),
		));
	}

	public function searchMensualSmsPorCodigo()
	{
		if ($this->mes == "")
			$this->mes = date("m");

		if ($this->ano == "")
			$this->ano = date("Y");

		$ids_promo = "null";

		$criteria=new CDbCriteria;

		$sql = "SELECT GROUP_CONCAT(id_promo) AS id FROM promociones_premium WHERE fecha BETWEEN '".date($this->ano."-".$this->mes."-01")."' AND '".Yii::app()->Funciones->getUltimoDiaMes($this->ano, $this->mes)."'";
		$id_promo = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

		if ($id_promo["id"] != "")
			$ids_promo = $id_promo["id"];

		$sql = "SELECT id AS id, sc, SUM(total) AS total, SUM(enviados) AS enviados FROM (
					SELECT p.sc, p.id_promo AS id,
					total_sms AS total, 
					(SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = p.id_promo AND status = 1) AS enviados
					FROM promociones_premium p
					WHERE p.id_promo IN(".$ids_promo.")  
					GROUP BY p.sc, p.id_promo) AS tabla
					GROUP BY sc";
		
		$model =PromocionesPremium::model()->findAllBySql($sql);

		$model = new CArrayDataProvider($model, array(

			'sort'=>array(
        		'attributes'=>array(
             		'sc', 'total',
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
    		),
    	));

    	return $model;

		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id_promo DESC',
        		'attributes'=>array(
             		'nombrePromo'
        		),
    		),
		));*/
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
	 * @return PromocionesPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
