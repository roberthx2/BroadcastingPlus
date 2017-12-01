<?php

/**
 * This is the model class for table "palabras_obscenas".
 *
 * The followings are the available columns in table 'palabras_obscenas':
 * @property string $id
 * @property string $palabra
 */
class PalabrasObscenas extends CActiveRecord
{
	public $buscar;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'palabras_obscenas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('palabra', 'required','message'=>'{attribute} requerido'),
			array('palabra', 'length', 'max'=>45),

			array("palabra","filter","filter"=>array($this, "limpiarPalabra")),
			array("palabra", "ext.validator.Nombre"), //Valida los caracteres
			array("palabra", "existe"), //Valida si existe el nombre de la promoción segun su tipo
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, palabra', 'safe', 'on'=>'search'),
		);
	}

	public function limpiarPalabra($cadena)
	{
		return Yii::app()->Funciones->limpiarNombre($cadena);
	}

	public function existe($attribute, $params)
	{
		$model = PalabrasObscenas::model()->find("palabra =?", array($this->$attribute));

		if ($model)
		{
			$this->addError($attribute, "La palabra ya existe");
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
			'palabra' => 'Palabra',
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
	/*public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('palabra',$this->palabra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->select = "t.id, t.prefijo, t.id_usuario, u.login";
		$criteria->condition = "palabra LIKE '%".$this->buscar."%'";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'palabra ASC',
        		'attributes'=>array(
             		'palabra'
        		),
    		),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PalabrasObscenas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
