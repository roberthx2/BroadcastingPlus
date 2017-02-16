<?php

/**
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property integer $id_producto
 * @property string $id_sc
 * @property string $desc_producto
 * @property string $alias_producto
 * @property string $id_aplicacion
 * @property string $cliente
 * @property string $usuario
 * @property string $estado
 * @property string $diccionario
 * @property string $tipo_objeto
 * @property string $mnemonico
 * @property string $categoría
 */
class Producto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sc, tipo_objeto', 'length', 'max'=>4),
			array('desc_producto', 'length', 'max'=>250),
			array('alias_producto', 'length', 'max'=>12),
			array('id_aplicacion', 'length', 'max'=>3),
			array('cliente, usuario, mnemonico, categoría', 'length', 'max'=>20),
			array('estado, diccionario', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_producto, id_sc, desc_producto, alias_producto, id_aplicacion, cliente, usuario, estado, diccionario, tipo_objeto, mnemonico, categoría', 'safe', 'on'=>'search'),
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
			'id_producto' => 'Id Producto',
			'id_sc' => 'Id Sc',
			'desc_producto' => 'Desc Producto',
			'alias_producto' => 'Alias Producto',
			'id_aplicacion' => 'Id Aplicacion',
			'cliente' => 'Cliente',
			'usuario' => 'Usuario',
			'estado' => 'Estado',
			'diccionario' => 'Diccionario',
			'tipo_objeto' => 'Tipo Objeto',
			'mnemonico' => 'Mnemonico',
			'categoría' => 'Categoría',
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

		$criteria->compare('id_producto',$this->id_producto);
		$criteria->compare('id_sc',$this->id_sc,true);
		$criteria->compare('desc_producto',$this->desc_producto,true);
		$criteria->compare('alias_producto',$this->alias_producto,true);
		$criteria->compare('id_aplicacion',$this->id_aplicacion,true);
		$criteria->compare('cliente',$this->cliente,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('diccionario',$this->diccionario,true);
		$criteria->compare('tipo_objeto',$this->tipo_objeto,true);
		$criteria->compare('mnemonico',$this->mnemonico,true);
		$criteria->compare('categoría',$this->categoría,true);

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
	 * @return Producto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
