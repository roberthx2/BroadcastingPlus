<?php

class ReportesController extends Controller
{
	public $layout="//layouts/menuApp";

	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'mensualSms', 'mensualSmsPorCliente', 'mensualSmsPorCodigo'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionIndex()
    {
        $this->render("index");
    }

    public function actionMensualSms()
    {
        $this->render("mensualSms");
    }

    public function actionMensualSmsPorCliente()
    {
        $this->render("mensualSmsPorCliente");
    }

    public function actionMensualSmsPorCodigo()
    {
        $this->render("mensualSmsPorCodigo");
    }

    public function actionGetDescripcionClienteBCP($id_cliente)
    {
        $sql = "SELECT descripcion FROM cliente WHERE id = ".$id_cliente;
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

        if ($sql)
            return str_replace("@", "", $sql["descripcion"]);
        else return "NO EXISTE";
    }
}

?>|