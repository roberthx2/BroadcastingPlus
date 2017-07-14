<?php

/**
 * This is the model class for table "prefijo_promocion".
 *
 * The followings are the available columns in table 'prefijo_promocion':
 * @property integer $id
 * @property integer $id_usuario
 * @property string $prefijo
 */
class PrefijoPromocion extends CActiveRecord
{
	public $buscar;
	public $login;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prefijo_promocion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prefijo', 'required', 'message'=>'{attribute} requerido'),
			array('id_usuario', 'numerical', 'integerOnly'=>true),
			array('prefijo', 'length', 'max'=>10),
			
			array("prefijo","filter","filter"=>array($this, "limpiarPrefijo")),
			array("prefijo", "ext.validator.Nombre"), //Valida los caracteres
			array("prefijo", "existe"), //Valida si existe el nombre de la promoción segun su tipo
			array("prefijo", "palabrasObscenas"), //Valida si el mensaje contiuene palabras obscenas 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usuario, prefijo', 'safe', 'on'=>'search'),
		);
	}

	public function limpiarPrefijo($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
	}

	public function existe($attribute, $params)
	{
		$model = PrefijoPromocion::model()->find("id_usuario =? AND prefijo =?", array(Yii::app()->user->id, $this->$attribute));

		if ($model)
		{
			$this->addError($attribute, "EL prefijo ya existe");
		}
	}

	public function palabrasObscenas($attribute, $params)
	{
		$sql = "SELECT group_concat(palabra separator '|') AS palabras FROM palabras_obscenas";
        $sql = Yii::app()->db->createCommand($sql)->queryRow();

        $palabras = strtolower($sql["palabras"]);

        $contenido = strtolower($this->$attribute);

        preg_match_all('('.$palabras.')', $contenido, $palabras_obscenas);
        
        if (count($palabras_obscenas[0]) > 0)
        {
            $palabras_obscenas = "<br>(".implode(",",$palabras_obscenas[0]).")";
            $this->addError($attribute, "El prefijo contiene palabras obscenas debe corregirlo para continuar ".$palabras_obscenas);
        }
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
			'id' => 'ID',
			'id_usuario' => 'Id Usuario',
			'prefijo' => 'Prefijo',
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
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('prefijo',$this->prefijo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrefijo($id_usuario)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.id, t.prefijo, t.id_usuario, u.login";
		$criteria->join = "INNER JOIN insignia_masivo.usuario u ON t.id_usuario = u.id_usuario";

		if ($id_usuario != null) //NO es admin
			$criteria->condition = "(t.id_usuario = ".$id_usuario.") AND ";
		else  $criteria->condition = "(u.login LIKE '%".$this->buscar."%') OR "; //SI es admin

		$criteria->condition .= "prefijo LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'login ASC',
        		'attributes'=>array(
             		'u.login','prefijo'
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
	 * @return PrefijoPromocion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
