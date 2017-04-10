<?php

class WebUser extends CWebUser
{
    // Store model to not repeat query.
    private $_model;
    private $_admin;

    // Return first name.
    // accesdemos al Cus

    /*protected function loadUser($usuario_id=null)
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
    }*/

    public function modelSMS()
    {
        $this->_model = UsuarioSms::model()->findByPk(Yii::app()->user->id);
        return $this->_model;
    }

    public function getPermisos()
    {
        $this->_model = Permisos::model()->findByPk(Yii::app()->user->id);
        return $this->_model;
    }

    public function getCadenaSc()
    {
        $model = $this->modelSMS();
        return Yii::app()->Funciones->limpiarNumerosTexarea($model->cadena_sc);
    }

    public function getCadenaServicios()
    {
        $model = $this->modelSMS();
        return Yii::app()->Funciones->limpiarNumerosTexarea($model->cadena_serv);
    }

    /*public function getAccesosBCP()
    {
        $this->_model = AccesosBcp::model()->findByPk(Yii::app()->user->id);
        return $this->_model;
    }*/

    public function isAdmin()
    {
        $model = $this->modelSMS();

        if ($model->id_perfil == 2 || $model->id_perfil == 1)
            return true;
        return false;
    }

    public function isMaster()
    {
        $model = ConfiguracionSistema::model()->find("propiedad=:propiedad", array(":propiedad"=>"usuarios_master"));
        $array = explode(",", $model->valor);

        if (in_array(Yii::app()->user->id, $array) || Yii::app()->user->id == 1)
        {
            return true;
        }
        else return false;
    }      
}

?>