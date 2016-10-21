<?php

/**
 * This is the model class for table "promociones".
 *
 * The followings are the available columns in table 'promociones':
 * @property string $id_promo
 * @property string $nombrePromo
 * @property string $cadena_usuarios
 * @property string $estado
 * @property string $contenido
 * @property string $fecha
 * @property string $hora
 * @property string $cliente
 * @property integer $verificado
 * @property integer $total_dest_aceptados
 * @property integer $total_dest_rechazados
 * @property integer $total_dest_cargados
 */
class Promociones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promociones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrePromo, cadena_usuarios, contenido', 'required'),
			array('verificado, total_dest_aceptados, total_dest_rechazados, total_dest_cargados', 'numerical', 'integerOnly'=>true),
			array('nombrePromo', 'length', 'max'=>45),
			array('estado, cliente', 'length', 'max'=>10),
			array('contenido', 'length', 'max'=>255),
			array('fecha, hora', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_promo, nombrePromo, cadena_usuarios, estado, contenido, fecha, hora, cliente, verificado, total_dest_aceptados, total_dest_rechazados, total_dest_cargados', 'safe', 'on'=>'search'),
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
			'nombrePromo' => 'Nombre Promo',
			'cadena_usuarios' => 'Cadena Usuarios',
			'estado' => 'Estado',
			'contenido' => 'Contenido',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'cliente' => 'Cliente',
			'verificado' => 'Verificado',
			'total_dest_aceptados' => 'Total Dest Aceptados',
			'total_dest_rechazados' => 'Total Dest Rechazados',
			'total_dest_cargados' => 'Total Dest Cargados',
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
		$criteria->compare('cadena_usuarios',$this->cadena_usuarios,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('cliente',$this->cliente,true);
		$criteria->compare('verificado',$this->verificado);
		$criteria->compare('total_dest_aceptados',$this->total_dest_aceptados);
		$criteria->compare('total_dest_rechazados',$this->total_dest_rechazados);
		$criteria->compare('total_dest_cargados',$this->total_dest_cargados);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promociones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
