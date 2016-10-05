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

		$criteria->condition = "(id_proceso = ".$id_proceso.") AND ";
		$this->numero = $this->buscar;
		$this->id_operadora = $this->buscar;
		$criteria->condition .= "(numero LIKE '%".$this->numero."%' OR ";
		$criteria->condition .= "id_operadora LIKE '%".$this->id_operadora."%')";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchReporte($id_proceso)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->condition = 'id_proceso = '.$id_proceso;
		//$criteria->compare('numero',$this->numero,true,'AND', 'ILIKE');
		$criteria->condition = "numero LIKE '%".$this->numero."%' AND id_proceso = ".$id_proceso;
		$criteria->addCondition("id_operadora LIKE '%".$this->id_operadora."%' AND id_proceso = ".$id_proceso,"OR");
		
		//print_r($criteria); exit;
		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        		'pageSize'=>10,
    		),
		));

		return $dataProvider;
	}

	public function searchTmp($id_proceso)
	{
		$criteria=new CDbCriteria;

		//if (isset($_GET['buscar'])) {
  print_r($this->numero);
  exit;
            $criteria->condition = "id_proceso = ".$id_proceso;
            $criteria->compare('numero',$this->buscar,true,'ILIKE');
            $criteria->compare('id_operadora', $this->buscar,true,'OR','ILIKE');
        //}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
