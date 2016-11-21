<?php

class Promociones extends CActiveRecord
{
	public $id_cliente;
	public $mes;
	public $ano;

	public function rules()
	{
		return array(
			)
	}

	public function attributeLabels()
	{
		return array(
			'id_cliente' => 'Cliente',
			'mes' => 'Mes',
			'ano' => 'Año',
		);
	}

	public function search()
	{
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

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}