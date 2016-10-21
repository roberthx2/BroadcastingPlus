<?php

class HomeController extends Controller
{
	public $layout="//layouts/column2";

	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

	public function actionIndex()
	{
		$modelBCNL = array();
		$modelBCP = array();

		if (Yii::app()->user->getPermisos()->broadcasting || Yii::app()->user->getPermisos()->broadcasting_cpei)
		{
			$modelBCNL = new Promociones('search');
			$modelBCNL->unsetAttributes();
			if(isset($_GET['Promociones']))
				$modelBCNL->attributes=$_GET['Promociones'];
		}

		if (Yii::app()->user->getPermisos()->broadcasting_premium)
		{
			$modelBCP = new PromocionesPremium('searchHome');
			$modelBCP->unsetAttributes();
			if(isset($_GET['PromocionesPremium']))
				$modelBCP->attributes=$_GET['PromocionesPremium'];
		}

		$this->render('index', array('modelBCNL'=> $modelBCNL,'modelBCP'=>$modelBCP));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}