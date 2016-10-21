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
        $dataTipo = array();

        if (Yii::app()->user->getPermisos()->broadcasting && Yii::app()->user->getPermisos()->crear_promo_bcnl)
            array_push($dataTipo, "BCNL");
        if (Yii::app()->user->getPermisos()->broadcasting_premium && Yii::app()->user->getPermisos()->crear_promo_bcp)
            array_push($dataTipo, "BCP");
        if (Yii::app()->user->getPermisos()->broadcasting_cpei)
            array_push($dataTipo, "CPEI");

        $this->render("create", array('model' => $model, 'dataTipo' => $dataTipo));
    }
}

?>