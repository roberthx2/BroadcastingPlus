<?php

/**
 * This is the model class for table "lista_exentos".
 *
 * The followings are the available columns in table 'lista_exentos':
 * @property integer $id_lista
 * @property integer $id_usuario
 * @property string $nombre
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property ListaExentosDestinatarios[] $listaExentosDestinatarioses
 */
class ListaExentos extends CActiveRecord
{
	public $buscar;
	public $total;
	public $login;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lista_exentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, nombre, fecha', 'required'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_lista, id_usuario, nombre, fecha', 'safe', 'on'=>'search'),
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
			'listaExentosDestinatarioses' => array(self::HAS_MANY, 'ListaExentosDestinatarios', 'id_lista'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_lista' => 'Id Lista',
			'id_usuario' => 'Id Usuario',
			'nombre' => 'Nombre',
			'fecha' => 'Fecha',
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
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_lista, t.fecha, u.login AS login, (SELECT COUNT(ld.id_lista) FROM lista_exentos_destinatarios ld WHERE ld.id_lista = t.id_lista) AS total";
		$criteria->join = "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario ";

		$criteria->condition = "(t.fecha LIKE '%".$this->buscar."%') OR ";
		$criteria->condition .= "(u.login LIKE '%".$this->buscar."%')";
		//$criteria->having = "(total LIKE '%".$this->buscar."%' ) ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'login ASC',
        		'attributes'=>array(
             		'u.login', 'fecha'
        		),
    		),
    		'pagination'=>array(
        		'pageSize'=>10,
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
	 * @return ListaExentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
