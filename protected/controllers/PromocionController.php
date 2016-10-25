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
                'actions' => array('create', 'getCliente'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='promocion-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCreate()
    {
        $model = new PromocionForm;
        $listas = array();
        $dataTipo = array();

        $this->performAjaxValidation($model);

        if(isset($_POST['PromocionForm']))
        {
            $model->attributes=$_POST['PromocionForm'];

            if ($model->validate())
            {
                $this->redirect(array("lista/admin"));
                //print_r($model);
                //exit;
            }
            //$this->redirect(array("lista/admin"));
        }

        if (Yii::app()->user->getPermisos()->broadcasting && Yii::app()->user->getPermisos()->crear_promo_bcnl)
            $dataTipo[1] = "BCNL";
        if (Yii::app()->user->getPermisos()->broadcasting_cpei)
            $dataTipo[2] = "CPEI";
        if (Yii::app()->user->getPermisos()->broadcasting_premium && Yii::app()->user->getPermisos()->crear_promo_bcp)
            $dataTipo[3] = "BCP";

        if (Yii::app()->user->getPermisos()->modulo_listas)
        {
            $model_lista = Lista::model()->findAll("id_usuario = ".Yii::app()->user->id);
            
            foreach ($model_lista as $value)
            {
                $listas[$value["id_lista"]] = $value["nombre"];
            }
        }

        $this->render("create", array('model' => $model, 'dataTipo' => $dataTipo, 'listas' => $listas));
    }

    public function actionGetCliente()
    {
        $tipo = Yii::app()->request->getParam('tipo');
        if (Yii::app()->request->isAjaxRequest)
        {
            if ($tipo == '') {
                echo CJSON::encode(array(
                    'error' => 'true',
                    'status' => 'Tipo de promoción invalida'
                ));
                Yii::app()->end();
            } else {   
                if ($tipo == 1 || $tipo == 2) //BCNL o CPEI
                {
                    $data = Yii::app()->Procedimientos->getClientesBCNL(Yii::app()->user->id);
                    $cupo = 0;
                }
                else if ($tipo == 3) //BCP
                {
                    $data = Yii::app()->Procedimientos->getClientesBCP(Yii::app()->user->id);
                    $model_cupo = UsuarioCupoPremium::model()->findByPk(Yii::app()->user->id);
                    $cupo = 0;
                    
                    if ($model_cupo)
                    {
                        $cupo = $model_cupo->disponible;
                    }
                }

                if($data) {
                    echo CJSON::encode(array(
                                            'error' => 'false',
                                            'status' => 'Clientes obtenidos correctamente',
                                            'data' => $data,
                                            'cupo' => $cupo
                                       )                                
                         );
                    Yii::app()->end();
                } else {
                    echo CJSON::encode(array(
                        'error' => 'true',
                        'status' => 'No posee cliente asociado'
                    ));
                    Yii::app()->end();
                }
            }
            
        }
        
    }
}

?>