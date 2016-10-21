<?php

class PromocionController extends Controller
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
                'actions' => array('create'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionCreate()
    {
        $model = new PromocionForm;
        $model_lista = array();
        $dataTipo = array();

        if (Yii::app()->user->getPermisos()->broadcasting && Yii::app()->user->getPermisos()->crear_promo_bcnl)
            array_push($dataTipo, "BCNL");
        if (Yii::app()->user->getPermisos()->broadcasting_premium && Yii::app()->user->getPermisos()->crear_promo_bcp)
            array_push($dataTipo, "BCP");
        if (Yii::app()->user->getPermisos()->broadcasting_cpei)
            array_push($dataTipo, "CPEI");

        if (Yii::app()->user->getPermisos()->modulo_listas)
        {
            $model_lista = Lista::model()->findAll("id_usuario = ".Yii::app()->user->id);
            $listas = array();
            foreach ($model_lista as $value)
            {

                $listas[$value["id_lista"]] = $value["nombre"];
                //$listas[] = $value["nombre"];
            }

            //$model->listas = $listas;
        }

        $this->render("create", array('model' => $model, 'dataTipo' => $dataTipo, 'listas' => $listas));
    }
}

?>