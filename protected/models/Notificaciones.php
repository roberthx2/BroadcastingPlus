<?php

/**
 * This is the model class for table "notificaciones".
 *
 * The followings are the available columns in table 'notificaciones':
 * @property integer $id_notificacion
 * @property integer $id_usuario
 * @property integer $id_usuario_creador
 * @property string $asunto
 * @property string $mensaje
 * @property string $fecha
 * @property string $hora
 * @property integer $estado
 */
class Notificaciones extends CActiveRecord
{
	public $buscar;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notificaciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mensaje', 'required', 'message'=>'{attribute} requerido'),
			array('id_usuario, id_usuario_creador', 'numerical', 'integerOnly'=>true),
			//array('mensaje', 'length', 'max'=>1000),
			//array("mensaje","filter","filter"=>array($this, "limpiarMensaje")),
			//array("mensaje", "palabrasObscenas"), //Valida si el mensaje contiuene palabras obscenas
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_notificacion, id_usuario, id_usuario_creador, asunto, mensaje, fecha, hora, estado', 'safe', 'on'=>'search'),
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
			'id_notificacion' => 'Id Notificacion',
			'id_usuario' => 'Usuario',
			'id_usuario_creador' => 'Id Usuario Creador',
			'asunto' => 'Asunto',
			'mensaje' => 'Mensaje',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
			'estado' => 'Estado',
		);
	}

	public function limpiarMensaje($cadena)
	{
		return Yii::app()->Funciones->limpiarMensajeNotificacion($cadena);
	}

	public function palabrasObscenas($attribute, $params)
	{
		if ($this->scenario != "update")
		{
			$sql = "SELECT group_concat(palabra separator '|') AS palabras FROM palabras_obscenas";
	        $sql = Yii::app()->db->createCommand($sql)->queryRow();

	        $palabras = strtolower($sql["palabras"]);

	        $contenido = strtolower($this->$attribute);

	        preg_match_all('('.$palabras.')', $contenido, $palabras_obscenas);
	        
	        if (count($palabras_obscenas[0]) > 0)
	        {
	            $palabras_obscenas = "<br>(".implode(",",$palabras_obscenas[0]).")";
	            $this->addError($attribute, "El mensaje contiene palabras obscenas debe corregirlo para continuar ".$palabras_obscenas);
	        }
	    }
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

		$criteria->compare('id_notificacion',$this->id_notificacion);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_usuario_creador',$this->id_usuario_creador);
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('mensaje',$this->mensaje,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search_usuario($id_usuario)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$id_usuarios = "-1";

		if ($this->buscar != "")
		{
			$sql = "SELECT GROUP_CONCAT(id_usuario) AS id_usuarios FROM usuario WHERE login LIKE '%".$this->buscar."%'";
			$id_usuarios = Yii::app()->db_sms->createCommand($sql)->queryRow($sql);
			$id_usuarios = ($id_usuarios["id_usuarios"] == "") ? "-1" : $id_usuarios["id_usuarios"];

			if (Yii::app()->Funciones->like_match($this->buscar, 'SISTEMA'))
				$id_usuarios .= ",0";

			if (!Yii::app()->user->isAdmin() && Yii::app()->Funciones->like_match($this->buscar, 'EQUIPO TECNICO'))
			{
				$criteria = new CDbCriteria;
                $criteria->select = "GROUP_CONCAT(id_usuario) AS id_usuario";
                $criteria->addInCondition("id_perfil", array(1,2));
                $usuarios = UsuarioSms::model()->find($criteria);
                $usuarios = ($usuarios["id_usuario"] == "") ? "null":$usuarios["id_usuario"];

                $id_usuarios .= ",".$usuarios;
			}
		}

		$criteria=new CDbCriteria;

		
		$criteria->condition = "(fecha BETWEEN '".date('Y-m-d' , strtotime('-1 month', strtotime(date("Y-m-d"))))."' AND '".date("Y-m-d")."') AND (";
		$criteria->condition .= "id_usuario = ".$id_usuario.") AND (";
		$criteria->condition .= "asunto LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "fecha LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "hora LIKE '%".$this->buscar."%' OR ";
		$criteria->condition .= "t.id_usuario_creador IN (".$id_usuarios.") )";


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'fecha DESC, hora DESC',
        		'attributes'=>array(
             		'fecha', 'hora'
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
	 * @return Notificaciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
