<?php

class ReportesController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
	public $layout="//layouts/menuApp";

    /**
     * @return array action filters
     */
	public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
	public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'mensualSms', 'mensualSmsBCP', 'mensualSmsPorCliente', 'mensualSmsPorCodigo', 'smsRecibidos'),
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

    public function actionSmsRecibidos()
    {
        $this->render("smsRecibidos");
    }

    public function actionGetDescripcionClienteBCP($id_cliente)
    {
        $sql = "SELECT descripcion FROM cliente WHERE id = ".$id_cliente;
        $sql = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

        if ($sql)
            return str_replace("@", "", $sql["descripcion"]);
        else return "NO EXISTE";
    }

    public function actionGetDescripcionClienteBCNL($id_cliente)
    {
        $sql = "SELECT Des_cliente FROM cliente WHERE id_cliente = ".$id_cliente;
        $sql = Yii::app()->db_sms->createCommand($sql)->queryRow();

        if ($sql)
            return $sql["Des_cliente"];
        else return "NO EXISTE";
    }

    public function actionMensualSmsBCP()
    {
        $id_cliente = 102;//$_POST['PromocionesPremium']["id_cliente"];
        $mes = 11;//$_POST['PromocionesPremium']["mes"];
        $ano = 2016;//$_POST['PromocionesPremium']["ano"];
        $fecha_ini = date($ano."-".$mes."-01");
        $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($ano, $mes);

        $sql = "SELECT IFNULL(SUM(total),0) AS total, IFNULL(SUM(enviados),0) AS enviados FROM 
                (SELECT  
                    (SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo) AS total,
                    (SELECT COUNT(id) FROM outgoing_premium WHERE id_promo = t.id_promo AND status = 1) AS enviados
                    FROM promociones_premium t
                    WHERE t.id_cliente = :id_cliente AND t.fecha BETWEEN :fecha_ini AND :fecha_fin
                ) AS tabla";

        $sql = Yii::app()->db_masivo_premium->createCommand($sql);
        $sql->bindParam(":id_cliente", $id_cliente, PDO::PARAM_INT);
        $sql->bindParam(":fecha_ini", $fecha_ini, PDO::PARAM_STR);
        $sql->bindParam(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
        $sql = $sql->queryRow();

        $enviados = 0;
        $no_enviados = 0;

        if ($sql["total"] > 0)
        {
            $enviados = floor(($sql["enviados"] * 100) / $sql["total"]);
            $enviados = number_format($enviados, 1, '.', '.');

            $no_enviados = floor((($sql["total"] - $sql["enviados"]) * 100) / $sql["total"]);
            $no_enviados = number_format($no_enviados, 1, '.', '.');
        }

        $total = number_format($sql["total"], 0, '', '.');

        $objeto = array(
                'total' => $total,
                'enviados_title' => $enviados." %",
                'enviados_label' => number_format($sql["enviados"], 0, '', '.'),
                'no_enviados_title' => $no_enviados." %",
                'no_enviados' => number_format(($sql["total"] - $sql["enviados"]), 0, '', '.'),
                'periodo' => $fecha_ini." / ".$fecha_fin,
            );


        echo CJSON::encode(array(
            'objeto'=>$objeto,
        ));

        Yii::app()->end();
    }
}

?>|