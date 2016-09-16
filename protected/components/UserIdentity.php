<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_accesosBCNL;
	private $_accesosBCP;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users = UsuarioSms::model()->find("LOWER(login)=?", array(strtolower($this->username)));

		if($users===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(md5($this->password)!==$users->pwd)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$users->id_usuario;
			$this->_accesosBCNL = Accesos::model()->findByPk($this->_id)->attributes;
			$this->_accesosBCP = AccesosBcp::model()->findByPk($this->_id);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}