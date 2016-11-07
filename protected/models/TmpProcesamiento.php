<?php

/**
 * This is the model class for table "tmp_procesamiento".
 *
 * The followings are the available columns in table 'tmp_procesamiento':
 * @property integer $id
 * @property integer $id_proceso
 * @property string $numero
 * @property integer $id_operadora
 * @property integer $estado
 * @property integer $id_promo
 * @property string $mensaje
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $hora_inicio
 * @property string $hora_fin
 *
 * The followings are the available model relations:
 * @property ProcesosActivos $idProceso
 */
class TmpProcesamiento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $buscar;
	public $descripcion_oper;
	public $descripcion_estado;

	public function tableName()
	{
		return 'tmp_procesamiento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_proceso, numero', 'required'),
			array('id_proceso, id_operadora, estado, id_promo', 'numerical', 'integerOnly'=>true),
			array('numero', 'length', 'max'=>10),
			array('mensaje', 'length', 'max'=>160),
			array('fecha_inicio, fecha_fin, hora_inicio, hora_fin', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_proceso, numero, id_operadora, estado, id_promo, mensaje, fecha_inicio, fecha_fin, hora_inicio, hora_fin', 'safe', 'on'=>'search'),
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
			'idProceso' => array(self::BELONGS_TO, 'ProcesosActivos', 'id_proceso'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_proceso' => 'Id Proceso',
			'numero' => 'Numero',
			'id_operadora' => 'Id Operadora',
			'estado' => 'Estado',
			'id_promo' => 'Id Promo',
			'mensaje' => 'Mensaje',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_proceso',$this->id_proceso);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('id_operadora',$this->id_operadora);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('id_promo',$this->id_promo);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('hora_inicio',$this->hora_inicio,true);
		$criteria->compare('hora_fin',$this->hora_fin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchReporteLista($id_proceso)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_proceso, t.numero, t.id_operadora, (CASE WHEN o.descripcion != '' THEN o.descripcion ELSE 'INVALIDO' END) AS descripcion_oper, t.estado, e.descripcion AS descripcion_estado";
		$criteria->condition = "(id_proceso = ".$id_proceso.") AND ";
		$this->numero = $this->buscar;
		$this->descripcion_oper = $this->buscar;
		$this->descripcion_estado = $this->buscar;
		$criteria->condition .= "(numero LIKE '%".$this->numero."%' OR ";
		$criteria->condition .= "o.descripcion LIKE '%".$this->descripcion_oper."%' OR ";
		$criteria->condition .= "e.descripcion LIKE '%".$this->descripcion_estado."%')";
		$criteria->join = "LEFT JOIN tmp_procesamiento_estado e ON t.estado = e.id_estado 
						   LEFT JOIN (SELECT id_operadora_bcnl, descripcion from operadoras_relacion group by id_operadora_bcnl) as o ON t.id_operadora = o.id_operadora_bcnl";
		//$criteria->group = "o.id_operadora_bcnl";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'numero', 'o.descripcion', 'e.descripcion'
        		),
    		),
		));
	}

	public function searchReporteBCNL($id_proceso)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_proceso, t.numero, t.id_operadora, (CASE WHEN o.descripcion != '' THEN o.descripcion ELSE 'INVALIDO' END) AS descripcion_oper, t.estado, e.descripcion AS descripcion_estado";
		$criteria->condition = "(id_proceso = ".$id_proceso.") AND ";
		$this->numero = $this->buscar;
		$this->descripcion_oper = $this->buscar;
		$this->descripcion_estado = $this->buscar;
		$criteria->condition .= "(numero LIKE '%".$this->numero."%' OR ";
		$criteria->condition .= "o.descripcion LIKE '%".$this->descripcion_oper."%' OR ";
		$criteria->condition .= "e.descripcion LIKE '%".$this->descripcion_estado."%')";
		$criteria->join = "LEFT JOIN tmp_procesamiento_estado e ON t.estado = e.id_estado 
						   LEFT JOIN (SELECT id_operadora_bcnl, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl) AS o ON t.id_operadora = o.id_operadora_bcnl";
		//$criteria->group = "o.id_operadora_bcnl";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'numero', 'o.descripcion', 'e.descripcion'
        		),
    		),
		));
	}

	public function searchReporteBCP($id_proceso)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_proceso, t.numero, t.id_operadora, (CASE WHEN o.descripcion != '' THEN o.descripcion ELSE 'INVALIDO' END) AS descripcion_oper, t.estado, e.descripcion AS descripcion_estado";
		$criteria->condition = "(id_proceso = ".$id_proceso.") AND ";
		$this->numero = $this->buscar;
		$this->descripcion_oper = $this->buscar;
		$this->descripcion_estado = $this->buscar;
		$criteria->condition .= "(numero LIKE '%".$this->numero."%' OR ";
		$criteria->condition .= "o.descripcion LIKE '%".$this->descripcion_oper."%' OR ";
		$criteria->condition .= "e.descripcion LIKE '%".$this->descripcion_estado."%')";
		$criteria->join = "LEFT JOIN tmp_procesamiento_estado e ON t.estado = e.id_estado 
						   LEFT JOIN (SELECT id_operadora_bcp, descripcion from operadoras_relacion) as o ON t.id_operadora = o.id_operadora_bcp";
		//$criteria->group = "o.id_operadora_bcnl";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'numero', 'o.descripcion', 'e.descripcion'
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
	 * @return TmpProcesamiento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
