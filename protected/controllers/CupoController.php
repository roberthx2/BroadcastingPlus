<?php

class CupoController extends Controller
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
                'actions' => array('historico', 'recarga', 'getInfoCupoBcp'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionHistorico()
    {
        $this->render("historico");
    }

    public function actionRecarga()
    {
        $this->render("recarga");
    }

    public function actionGetInfoCupoBcp()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if (isset($_POST['id_usuario']) && $_POST['id_usuario'] !== "")
                $id_usuario = $_POST['id_usuario'];
            else 
                $id_usuario = Yii::app()->user->id;

            $cupo = UsuarioCupoPremium::model()->find("id_usuario = ".$id_usuario);

            $criteria = new CDbcriteria;
            $criteria->select = "ejecutado_por, MAX(fecha) AS fecha";
            $criteria->compare("id_usuario", $id_usuario);
            $criteria->compare("tipo_operacion", 1);

            $historico = UsuarioCupoHistoricoPremium::model()->find($criteria);
            
            $ejecutado_por = "";
            $fecha = "-";

            if ($historico)
            {
                $ejecutado_por = ($historico->ejecutado_por != 0) ? UsuarioSmsController::actionGetLogin($historico->ejecutado_por) : 'NO EXISTE';
                $fecha = $historico->fecha;
            }

            echo CJSON::encode(array(
                        'cupo_disponible'=>$cupo->disponible,
                        'login' => UsuarioSmsController::actionGetLogin($id_usuario),
                        'ejecutado_por' => $ejecutado_por,
                        'fecha' => $fecha
                    ));

            Yii::app()->end();
        }
    }
}
?>
