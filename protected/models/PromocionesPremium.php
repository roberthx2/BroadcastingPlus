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
			array('id_promo, nombrePromo, id_cliente, estado, fecha, hora, loaded_by, contenido, fecha_cargada, hora_cargada, verificada', 'safe', 'on'=>'searchHome'),
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

		$sql = "SELECT p.id_promo AS id, u.login, p.loaded_by, p.nombrePromo, p.id_cliente, p.estado, p.hora, p.contenido, d_o.fecha_limite, d_o.hora_limite,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = '2016-09-06' AND id_promo = p.id_promo) AS total,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = '2016-09-06' AND id_promo = p.id_promo AND status = 1) AS enviados,
			(SELECT COUNT(id) FROM outgoing_premium WHERE fecha_in = '2016-09-06' AND id_promo = p.id_promo AND status != 1) AS no_enviados
			FROM promociones_premium AS p, deadline_outgoing_premium AS d_o, insignia_masivo.usuario AS u
			WHERE p.id_promo IN (SELECT id_promo FROM promociones_premium WHERE id_cliente IN(1,3,33,36,40,42,43,44,47,49,51,53,57,59,61,63,65,67,69,73,78,80,82,84,86,88,90,92,94,96,98,100,102,104,106,108,117,119,121,123,125,127,131,136,138,140,149,151,153,155,168,170,172,176,178,180,182,184,186,190,192,194,196,198,200,202,204,206,211,213,215,217,219,222,224,226,228,230,232,234,236,238,240,242,244,246,248,250,252,258,260,262,264,266,270,273,274,276,278,280,282,284,286,290)) AND p.fecha = '2016-09-06' AND p.id_promo = d_o.id_promo AND p.loaded_by = u.id_usuario
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
