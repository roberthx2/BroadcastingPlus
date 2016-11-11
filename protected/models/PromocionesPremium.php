<?php

/**
 * This is the model class for table "promociones_premium".
 *
 * The followings are the available columns in table 'promociones_premium':
 * @property string $id_promo
 * @property string $nombrePromo
 * @property string $id_cliente
 * @property string $estado
 * @property string $fecha
 * @property string $hora
 * @property string $loaded_by
 * @property string $contenido
 * @property string $fecha_cargada
 * @property string $hora_cargada
 * @property integer $verificada
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
	public $no_enviados;
	public $id;
	public $login;
	public $buscar;

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
			array('verificada', 'numerical', 'integerOnly'=>true),
			array('nombrePromo', 'length', 'max'=>100),
			array('id_cliente', 'length', 'max'=>45),
			array('estado, loaded_by', 'length', 'max'=>10),
			array('contenido', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_promo, nombrePromo, id_cliente, fecha, hora, contenido, fecha_cargada, hora_cargada', 'safe', 'on'=>'searchHome'),
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
			'id_cliente' => 'Id Cliente',
			'estado' => 'Estado',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'loaded_by' => 'Loaded By',
			'contenido' => 'Contenido',
			'fecha_cargada' => 'Fecha Cargada',
			'hora_cargada' => 'Hora Cargada',
			'verificada' => 'Verificada',
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
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('loaded_by',$this->loaded_by,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('fecha_cargada',$this->fecha_cargada,true);
		$criteria->compare('hora_cargada',$this->hora_cargada,true);
		$criteria->compare('verificada',$this->verificada);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchHome()
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
	}

	public function searchVerDetalles()
	{
		$sql = "SELECT GROUP_CONCAT(id_cliente) AS id_clientes FROM usuario_cliente_operadora WHERE id_usuario = ".Yii::app()->user->id;
		$id_clientes = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_promo, t.nombrePromo, t.fecha, u.login AS login, (SELECT COUNT(*) FROM outgoing_premium o WHERE o.id_promo = t.id_promo) AS total";
		$criteria->join = "INNER JOIN insignia_masivo.usuario u ON t.loaded_by = u.id_usuario";
		$criteria->addInCondition("t.id_cliente", explode(",", $id_clientes["id_clientes"]));
		$criteria->condition .= " AND (t.id_promo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.nombrePromo LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.fecha LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "u.login LIKE '%".$this->buscar."%')";
		$criteria->order = "id_promo DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'id_promo', 'fecha', 'nombrePromo', 'u.login'
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
	 * @return PromocionesPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
