<?php

/**
 * This is the model class for table "lista".
 *
 * The followings are the available columns in table 'lista':
 * @property integer $id_lista
 * @property integer $id_usuario
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property ListaDestinatarios[] $listaDestinatarioses
 */
class Lista extends CActiveRecord
{
	public $total;
	public $buscar;
	public $login;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, nombre', 'required','message'=>'{attribute} requerido'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>30),
			array("nombre","filter","filter"=>array($this, "limpiarNombre")),
			array("nombre", "ext.ValidarNombre"), //Valida los caracteres
			//array("nombre", "existe", "usuario"=>$this->id_usuario)
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_lista, id_usuario, nombre, numero, id_operadora', 'safe', 'on'=>'search'),
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
			'listaDestinatarioses' => array(self::HAS_MANY, 'ListaDestinatarios', 'id_lista'),
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
		);
	}

	public function existe($attribute,$params)
	{
		if ($this->id_usuario == "")
			$id_usuario = Yii::app()->user->id;
		else
			$id_usuario = $this->id_usuario;

		$model = Lista::model()->find("id_usuario =? AND LOWER(nombre) =?", array($id_usuario, $this->$attribute));
		
		if($model != null)
			$this->addError($attribute, "El nombre de la lista ya existe");	
	}

	public function limpiarNombre($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
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
	public function searchOriginal()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('id_lista',$this->id_lista);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search($id_usuario)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$post_table = ListaDestinatarios::model()->tableName();
        $post_count_sql = "(select count(id_lista) from $post_table pt where pt.id_lista = 67)";

        $criteria->select = array("t.id_usuario", "t.nombre", $post_count_sql." AS total");

        $criteria->with = array("listaDestinatarioses"=>array('condition' => 'listaDestinatarioses.id_lista = t.id_lista'));
	
		if ($id_usuario != null)
			$criteria->compare('t.id_usuario',$id_usuario);
		$criteria->compare('t.id_lista',67);
		$criteria->compare('t.nombre',$this->nombre,true);
		

		print_r($criteria);
		//exit;

		$var =  new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		print_r($var->getData());
		exit;
	}

	public function search2($id_usuario)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.


		$criteria=new CDbCriteria;
		$criteria->select = "u.login AS id_usuario, t.nombre";

		if ($id_usuario != null)
			$criteria->condition = "(id_usuario = ".$id_usuario.") AND ";
		$criteria->with = array("listaDestinatarioses");
		$criteria->condition .= "(nombre LIKE '%".$this->buscar."%' ) ";
		$criteria->join = "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario";
		//$criteria->with = array("listaDestinatarioses"=>array("select"=>"id_operadora", "on"=>"t.id_lista = listaDestinatarioses.id_lista")); 
		//$criteria->group = "listaDestinatarioses.id_lista";
		$criteria->order = "u.login, t.nombre";
		$criteria->together = true;

		print_r($criteria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchTmp($id_usuario)
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.id_lista, t.nombre, t.id_usuario, u.login AS login, COUNT(ld.id_lista) AS total ";
		$criteria->join = "INNER JOIN lista_destinatarios ld ON t.id_lista = ld.id_lista ";
		$criteria->join .= "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario ";

		if ($id_usuario != null) //NO es admin
			$criteria->condition = "(t.id_usuario = ".$id_usuario.") AND ";
		else  $criteria->condition = "(u.login LIKE '%".$this->buscar."%') OR "; //SI es admin

		$criteria->condition .= "(t.nombre LIKE '%".$this->buscar."%')";
		//$criteria->having = "(total LIKE '%".$this->buscar."%' ) ";
		$criteria->group = "ld.id_lista";
		//$criteria->order = "u.login, t.nombre";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'login ASC',
        		'attributes'=>array(
             		'u.login','nombre'
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
	 * @return Lista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
