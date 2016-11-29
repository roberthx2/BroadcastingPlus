<?php

/**
 * This is the model class for table "smsin".
 *
 * The followings are the available columns in table 'smsin':
 * @property string $id_sms
 * @property string $origen
 * @property string $sc
 * @property string $contenido
 * @property string $estado
 * @property string $data_arrive
 * @property string $time_arrive
 * @property string $desp_op
 * @property integer $id_producto
 */
class Smsin extends CActiveRecord
{
	public $mes;
	public $id_cliente;
	public $id_promo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'smsin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contenido', 'required'),
			array('id_producto', 'numerical', 'integerOnly'=>true),
			array('id_sms', 'length', 'max'=>150),
			array('origen', 'length', 'max'=>50),
			array('sc, desp_op', 'length', 'max'=>20),
			array('contenido', 'length', 'max'=>255),
			array('estado', 'length', 'max'=>300),
			array('data_arrive, time_arrive', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sms, origen, sc, contenido, estado, data_arrive, time_arrive, desp_op, id_producto', 'safe', 'on'=>'search'),
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
			'origen' => 'Origen',
			'sc' => 'Sc',
			'contenido' => 'Contenido',
			'estado' => 'Estado',
			'data_arrive' => 'Data Arrive',
			'time_arrive' => 'Time Arrive',
			'desp_op' => 'Desp Op',
			'id_producto' => 'Id Producto',
			'id_promo' => 'Promoción',
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
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('sc',$this->sc,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('data_arrive',$this->data_arrive,true);
		$criteria->compare('time_arrive',$this->time_arrive,true);
		$criteria->compare('desp_op',$this->desp_op,true);
		$criteria->compare('id_producto',$this->id_producto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchSmsRecibidosBCP()
	{
		$id_usuario = Yii::app()->user->id;

		$sql = "SELECT sc FROM cliente WHERE id = :id_cliente";
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql);
		$sql->bindParam(":id_cliente", $this->id_cliente, PDO::PARAM_INT);
        $sql = $sql->queryRow();

        if ($sql)
        	$sc = $sql["sc"];
        else $sc = "NULL";

        $cadena_serv = Yii::app()->user->modelSMS()->cadena_serv;
       	$cadena_serv = trim(preg_replace('/,{2,}/', ",", $cadena_serv), ",");
       	$cadena_serv = explode(",", $cadena_serv);

       	$sql = "SELECT ver_invalido FROM habilita_invalidos WHERE id_usuario = ".$id_usuario." AND sc_id = ".$sc;
        $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();

        if (isset($sql) && $sql["ver_invalido"] == "Y")
        {
        	array_push($cadena_serv, 0); 
        }

        $sql = "SELECT fecha, fecha_limite, hora, hora_limite FROM promociones_premium p 
        		INNER JOIN deadline_outgoing_premium d ON p.id_promo = d.id_promo 
        		WHERE p.id_promo = :id_promo";
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
		$sql->bindParam(":id_promo", $this->id_promo, PDO::PARAM_INT);
        $promo = $sql->queryRow();

        if (Yii::app()->user->isAdmin())
        {
            $fecha_consulta = $promo["fecha"];
        }
        else
        {
        	$sql = "SELECT fecha_init_sc, CASE fecha_fin_sc WHEN '0000-00-00' THEN CURDATE() ELSE fecha_fin_sc END AS fecha_fin_sc FROM fecha_init_rep 
        			WHERE id_sc = ".$sc." AND id_usuario = ".$id_usuario." 
        			ORDER BY id_registro 
        			DESC LIMIT 1";
            $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();

            $fecha_ini = $sql["fecha_init_sc"];
            $fecha_fin = $sql["fecha_fin_sc"];

            //Determinar la fecha inicio del reporte
	        if ($promo["fecha"] >= $fecha_ini && $promo["fecha"] <= $fecha_fin)
	        {
	            $fecha_consulta = $promo["fecha"];
	        } 
	        else if ($promo["fecha"] < $fecha_ini || $promo["fecha"] > $fecha_fin)
	        {
	            $fecha_consulta = "0000-00-00";
	        }
        }

        $sql = "SELECT GROUP_CONCAT(descripcion) AS oper_activas FROM operadoras_activas_bcp WHERE estatus = 1";
        $operadoras_activas = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

        $sql = "SELECT GROUP_CONCAT(destinatario) AS numeros FROM outgoing_premium WHERE id_promo = :id_promo";
        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
		$sql->bindParam(":id_promo", $this->id_promo, PDO::PARAM_INT);
        $outgoing_premium = $sql->queryRow();

		$criteria=new CDbCriteria;

		$criteria->select = "(CASE WHEN origen REGEXP '^0414|^0424' THEN origen 
			WHEN origen REGEXP '^0416' THEN origen 
			WHEN origen REGEXP '^158' THEN CONCAT('0416', SUBSTRING(origen,-7)) 
			WHEN origen REGEXP '^0412' THEN origen 
			WHEN origen REGEXP '^58412' THEN CONCAT('0412', SUBSTRING(origen,-7)) 
			END) AS origen, contenido, time_arrive";

		$criteria->compare("data_arrive", $fecha_consulta);
		$criteria->addBetweenCondition("time_arrive", $promo["hora"], $promo["hora_limite"]);
		$criteria->compare("sc", $sc);
		$criteria->addInCondition("desp_op", explode(",", $operadoras_activas["oper_activas"]));
		$criteria->addInCondition("id_producto", $cadena_serv);
		$criteria->addInCondition("desp_op", explode(",", $operadoras_activas["oper_activas"]));
		$criteria->addInCondition("SUBSTRING(origen,-7)", explode(",", $outgoing_premium["numeros"]));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_sms;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Smsin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
