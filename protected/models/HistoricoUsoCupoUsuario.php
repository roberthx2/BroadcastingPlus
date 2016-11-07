<?php

/**
 * This is the model class for table "historico_uso_cupo_usuario".
 *
 * The followings are the available columns in table 'historico_uso_cupo_usuario':
 * @property integer $id
 * @property integer $id_transaccion
 * @property integer $id_control_cupo_usuario
 * @property string $accion
 * @property integer $cupo_consumido_antes
 * @property integer $cupo_consumido_despues
 * @property string $fecha
 * @property string $entidad
 */
class HistoricoUsoCupoUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'historico_uso_cupo_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_transaccion, id_control_cupo_usuario, accion, cupo_consumido_antes, cupo_consumido_despues, fecha, entidad', 'required'),
			array('id_transaccion, id_control_cupo_usuario, cupo_consumido_antes, cupo_consumido_despues', 'numerical', 'integerOnly'=>true),
			array('accion', 'length', 'max'=>255),
			array('entidad', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_transaccion, id_control_cupo_usuario, accion, cupo_consumido_antes, cupo_consumido_despues, fecha, entidad', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'id_transaccion' => 'Id Transaccion',
			'id_control_cupo_usuario' => 'Id Control Cupo Usuario',
			'accion' => 'Accion',
			'cupo_consumido_antes' => 'Cupo Consumido Antes',
			'cupo_consumido_despues' => 'Cupo Consumido Despues',
			'fecha' => 'Fecha',
			'entidad' => 'Entidad',
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
		$criteria->compare('id_transaccion',$this->id_transaccion);
		$criteria->compare('id_control_cupo_usuario',$this->id_control_cupo_usuario);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('cupo_consumido_antes',$this->cupo_consumido_antes);
		$criteria->compare('cupo_consumido_despues',$this->cupo_consumido_despues);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('entidad',$this->entidad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistoricoUsoCupoUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
