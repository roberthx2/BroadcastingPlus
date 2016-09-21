<?php

class HomeController extends Controller
{
	public $layout="//layouts/home";

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPromocionesBCP()
	{
		$model=new PromocionesPremium('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PromocionesPremium']))
			$model->attributes=$_GET['PromocionesPremium'];

		$this->renderPartial('promocionesBCP',array(
			'model'=>$model,
		));
	}

	public function actionPromocionesBNL()
	{
		$this->renderPartial('promocionesBNL');
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