<?php

class WebUser extends CWebUser
{
    // Store model to not repeat query.
    private $_model;

    // Return first name.
    // accesdemos al Cus

    protected function loadUser($usuario_id=null)
    {
         if($this->_model===null)
         {
              if($usuario_id!==null)
                   $this->_model = UsuarioSms::model()->findByPk($usuario_id);
         }

         return $this->_model;
    }

    function getIdCustomer()
    {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user;
    }

    public function getIdCliente()
    {
        $user = UsuarioSms::model()->findByPk(Yii::app()->user->id);
        return $user->id_cliente;
    }

    public function getlogin()
    {
        $record=Usuario::model()->findByAttributes(array('login'=>$this->username));
        $this->_login=$record->login;
        return $this->_login;
    }
    public function getPassword()
    {
        $record=Usuario::model()->findByAttributes(array('login'=>$this->username));
        $this->_password=$record->pwd;
        return $this->_password;
    }

    public function getScCadena()
    {
        $record=Usuario::model()->findByAttributes(array('login'=>$this->username));
        $this->_scCadena=$record->cadena_sc;
        return $this->_scCadena;
    }

    public function getAccesos()
    {
        $record=Accesos::model()->findByPk(Yii::app()->user->id);
        return $record;
    }     
}

?>