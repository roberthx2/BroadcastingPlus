<?php

/**
 * This is the model class for table "lista_destinatarios".
 *
 * The followings are the available columns in table 'lista_destinatarios':
 * @property integer $id_lista
 * @property string $numero
 * @property integer $id_operadora
 *
 * The followings are the available model relations:
 * @property Lista $idLista
 */
class ListaDestinatarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $buscar;
	public $descripcion_oper;
	public $estado_lista;
	//public $id;

	public function tableName()
	{
		return 'lista_destinatarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_lista, numero, id_operadora', 'required'),
			array('id_lista, id_operadora', 'numerical', 'integerOnly'=>true),
			array('numero', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_lista, numero, id_operadora', 'safe', 'on'=>'search'),
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
			'idLista' => array(self::BELONGS_TO, 'Lista', 'id_lista'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_lista' => 'Id Lista',
			'numero' => 'Numero',
			'id_operadora' => 'Id Operadora',
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

		$criteria->compare('id_lista',$this->id_lista);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('id_operadora',$this->id_operadora);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*public function searchViewUpdate($id_lista)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_lista',$id_lista);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('id_operadora',$this->id_operadora);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function searchViewUpdate($id_lista)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$model_lista = Lista::model()->findByPk($id_lista);

		$criteria=new CDbCriteria;
		$criteria->select = "t.id_lista, t.numero, t.id_operadora, t.estado, o.descripcion AS descripcion_oper, ".$model_lista->estado." AS estado_lista";
		$criteria->condition = "(t.id_lista = ".$id_lista.") AND ";
		$criteria->condition .= "(numero LIKE '%". $this->buscar."%' OR ";
		$criteria->condition .= "o.descripcion LIKE '%". $this->buscar."%')";
		$criteria->join = "LEFT JOIN (SELECT id_operadora_bcnl, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl) AS o ON t.id_operadora = o.id_operadora_bcnl";
		//$criteria->group = "o.id_operadora_bcnl";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
        		'attributes'=>array(
             		'numero', 'o.descripcion',
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
	 * @return ListaDestinatarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
