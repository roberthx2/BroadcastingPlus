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
                'actions' => array('smsPorCodigo', 'smsPeriodoResumen', 'smsPorClienteBcp', 'smsPorClienteResumen', 'smsEnviadosBcp', 'smsEnviadosBcpResumen'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        ));
    }

    public function actionSmsPorCodigo()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if(isset($_GET['Reportes']))
            {
                if ($_GET['Reportes']["tipo_busqueda"] == 1) //Mes
                {
                    $model = new ResumenBcpMensual();
                    $model->year=$_GET['Reportes']["year"];
                    $model->month=$_GET['Reportes']["month"];

                    $_SESSION["objeto"]["year"]=$_GET['Reportes']["year"];
                    $_SESSION["objeto"]["month"]=$_GET['Reportes']["month"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 2) //Periodo
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha_ini=$_GET['Reportes']["fecha_ini"];
                    $model->fecha_fin=$_GET['Reportes']["fecha_fin"];

                    $_SESSION["objeto"]["fecha_ini"]=$_GET['Reportes']["fecha_ini"];
                    $_SESSION["objeto"]["fecha_fin"]=$_GET['Reportes']["fecha_fin"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 3) //Dia
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha=$_GET['Reportes']["fecha"];

                    $_SESSION["objeto"]["fecha"]=$_GET['Reportes']["fecha"];
                }

                $_SESSION["objeto"]["tipo_busqueda"]=$_GET['Reportes']["tipo_busqueda"]; 
            }
            else
            {
                if ($_SESSION["objeto"]["tipo_busqueda"] == 1)//Mes
                {
                    $model = new ResumenBcpMensual();
                    $model->year=$_SESSION["objeto"]["year"];
                    $model->month=$_SESSION["objeto"]["month"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 2) //Periodo
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha_ini=$_SESSION["objeto"]["fecha_ini"];
                    $model->fecha_fin=$_SESSION["objeto"]["fecha_fin"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 3) //Dia
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha=$_SESSION["objeto"]["fecha"];
                }
            }
        }
        else
        {
            unset($_SESSION["objeto"]);
            $model = new Reportes();
            $model->unsetAttributes();
        }

        $this->render('smsPorCodigoBCP', array('model'=>$model));
    }

    public function actionSmsPeriodoResumen()
    {
        $tipo_busqueda = $_POST['Reportes']["tipo_busqueda"];

        $criteria = new CDbCriteria;
        $criteria->select = "SUM(cantd_msj) AS cantd_msj, operadora, descripcion AS sc";
        $criteria->join = "INNER JOIN operadoras_activas o ON t.operadora = o.id_operadora";
        $criteria->group = "operadora";
        
        if ($tipo_busqueda == 1) //Mensual
        {
            $criteria->compare("year", $_POST["Reportes"]["year"]);
            $criteria->compare("month", $_POST["Reportes"]["month"]);
            $model=ResumenBcpMensual::model()->findAll($criteria);
            $periodo = Yii::app()->Funciones->getNombreMes($_POST["Reportes"]["month"]).", ".$_POST["Reportes"]["year"];
        }
        else if ($tipo_busqueda == 2) //Periodo
        {
            $criteria->addBetweenCondition("fecha", $_POST["Reportes"]["fecha_ini"], $_POST["Reportes"]["fecha_fin"]);
            $model=ResumenBcpDiario::model()->findAll($criteria);
            $periodo = $_POST["Reportes"]["fecha_ini"]." / ".$_POST["Reportes"]["fecha_fin"];
        }
        else if ($tipo_busqueda == 3) //Dia
        {
            $criteria->compare("fecha", $_POST["Reportes"]["fecha"]);
            $model=ResumenBcpDiario::model()->findAll($criteria);
            $periodo = $_POST["Reportes"]["fecha"];
        }

        $total = 0;
        $data = array();

        foreach ($model as $value)
        {
            $data[] = '<li class="list-group-item">'.
                        $this->widget(
                            'booster.widgets.TbBadge',
                            array(
                                'label' => number_format($value["cantd_msj"], 0, '', '.'),
                                'htmlOptions' => array('id'=>'detalleEnviadosBCP', 'style' => 'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($value["operadora"]).'; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
                            ), true
                        ).'<strong class="">'.ucfirst(strtolower($value["sc"])).'</strong></li>';

            $total += $value["cantd_msj"];
        }

        $objeto = array(
                'total' => number_format($total, 0, '', '.'),
                'data' => implode(" ", $data),
                'periodo' => $periodo,
            );

        echo CJSON::encode(array('objeto'=>$objeto));

        Yii::app()->end();   
    }

    public function actionSmsPorClienteBcp()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if(isset($_GET['Reportes']))
            {
                if ($_GET['Reportes']["tipo_busqueda"] == 1) //Mes
                {
                    $model = new ResumenBcpMensual();
                    $model->year=$_GET['Reportes']["year"];
                    $model->month=$_GET['Reportes']["month"];

                    $_SESSION["objeto"]["year"]=$_GET['Reportes']["year"];
                    $_SESSION["objeto"]["month"]=$_GET['Reportes']["month"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 2) //Periodo
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha_ini=$_GET['Reportes']["fecha_ini"];
                    $model->fecha_fin=$_GET['Reportes']["fecha_fin"];

                    $_SESSION["objeto"]["fecha_ini"]=$_GET['Reportes']["fecha_ini"];
                    $_SESSION["objeto"]["fecha_fin"]=$_GET['Reportes']["fecha_fin"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 3) //Dia
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha=$_GET['Reportes']["fecha"];

                    $_SESSION["objeto"]["fecha"]=$_GET['Reportes']["fecha"];
                }

                $_SESSION["objeto"]["tipo_busqueda"]=$_GET['Reportes']["tipo_busqueda"]; 
            }
            else
            {
                if ($_SESSION["objeto"]["tipo_busqueda"] == 1)//Mes
                {
                    $model = new ResumenBcpMensual();
                    $model->year=$_SESSION["objeto"]["year"];
                    $model->month=$_SESSION["objeto"]["month"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 2) //Periodo
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha_ini=$_SESSION["objeto"]["fecha_ini"];
                    $model->fecha_fin=$_SESSION["objeto"]["fecha_fin"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 3) //Dia
                {
                    $model = new ResumenBcpDiario();
                    $model->fecha=$_SESSION["objeto"]["fecha"];
                }
            }
        }
        else
        {
            unset($_SESSION["objeto"]);
            $model = new Reportes();
            $model->unsetAttributes();
        }

        $this->render('smsPorClienteBCP', array('model'=>$model));
    }

    public function actionCreateColumnasOper()
    {
        $model_oper=OperadorasActivas::model()->findAll();
        $data_arr=array();

        foreach ($model_oper as $value)
        {
            $data_arr[] = array(
                    'name' => $value["descripcion"],
                    'header' => ucfirst(strtolower($value["descripcion"])),
                    'type' => 'number',
                    'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                    'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
                );

            $total[] = "\$data['".$value["descripcion"]."']";
        }

        $total = implode(" + ", $total);

        $data_arr[] = array(
                'header' => 'Total',
                'type' => 'number',
                'value' =>$total,
                'htmlOptions' => array('style' => 'text-align: center;', 'class'=>'trOverFlow'),
                'headerHtmlOptions' => array('class'=>'tableHover hrefHover'),
            );

        return $data_arr;
    }

    public function actionSmsEnviadosBcp()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = new ResumenBcpPromocion();

            if(isset($_GET['Reportes']))
            {
                if ($_GET['Reportes']["tipo_busqueda"] == 1) //Mes
                {
                    $model->year=$_GET['Reportes']["year"];
                    $model->month=$_GET['Reportes']["month"];

                    $_SESSION["objeto"]["year"]=$_GET['Reportes']["year"];
                    $_SESSION["objeto"]["month"]=$_GET['Reportes']["month"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 2) //Periodo
                {
                    $model->fecha_ini=$_GET['Reportes']["fecha_ini"];
                    $model->fecha_fin=$_GET['Reportes']["fecha_fin"];

                    $_SESSION["objeto"]["fecha_ini"]=$_GET['Reportes']["fecha_ini"];
                    $_SESSION["objeto"]["fecha_fin"]=$_GET['Reportes']["fecha_fin"];
                }
                else if ($_GET['Reportes']["tipo_busqueda"] == 3) //Dia
                {
                    $model->fecha=$_GET['Reportes']["fecha"];

                    $_SESSION["objeto"]["fecha"]=$_GET['Reportes']["fecha"];
                }

                $model->id_cliente_bcnl = $_GET['Reportes']["id_cliente_bcnl"];

                $_SESSION["objeto"]["tipo_busqueda"]=$_GET['Reportes']["tipo_busqueda"];
                $_SESSION["objeto"]["id_cliente_bcnl"]=$_GET['Reportes']["id_cliente_bcnl"];  
            }
            else
            {
                if ($_SESSION["objeto"]["tipo_busqueda"] == 1)//Mes
                {
                    $model->year=$_SESSION["objeto"]["year"];
                    $model->month=$_SESSION["objeto"]["month"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 2) //Periodo
                {
                    $model->fecha_ini=$_SESSION["objeto"]["fecha_ini"];
                    $model->fecha_fin=$_SESSION["objeto"]["fecha_fin"];
                }
                else if ($_SESSION["objeto"]["tipo_busqueda"] == 3) //Dia
                {
                    $model->fecha=$_SESSION["objeto"]["fecha"];
                }

                $model->id_cliente_bcnl = $_SESSION["objeto"]["id_cliente_bcnl"];
            }
        }
        else
        {
            unset($_SESSION["objeto"]);
            $_SESSION["objeto"]["show_cliente"] = true;
            $model = new Reportes();
            $model->unsetAttributes();
        }

        $this->render('smsEnviadosBcp', array('model'=>$model));
    }

    public function actionSmsEnviadosBcpResumen()
    {
        $tipo_busqueda = $_POST['Reportes']["tipo_busqueda"];
        $id_cliente_bcnl = $_POST['Reportes']["id_cliente_bcnl"];

        $criteria = new CDbCriteria;
        $criteria->select = "SUM(cantd_msj) AS cantd_msj, operadora, descripcion AS sc";
        $criteria->join = "INNER JOIN operadoras_activas o ON t.operadora = o.id_operadora";
        $criteria->group = "operadora";
        
        if ($tipo_busqueda == 1) //Mensual
        {
            $fecha_ini = $_POST["Reportes"]["year"]."-".$_POST["Reportes"]["month"]."-01";
            $fecha_fin = Yii::app()->Funciones->getUltimoDiaMes($_POST["Reportes"]["year"], $_POST["Reportes"]["month"]);
            $criteria->addBetweenCondition("fecha", $fecha_ini, $fecha_fin);
            $periodo = Yii::app()->Funciones->getNombreMes($_POST["Reportes"]["month"]).", ".$_POST["Reportes"]["year"];
        }
        else if ($tipo_busqueda == 2) //Periodo
        { 
            $criteria->addBetweenCondition("fecha", $_POST["Reportes"]["fecha_ini"], $_POST["Reportes"]["fecha_fin"]);
            $periodo = $_POST["Reportes"]["fecha_ini"]." / ".$_POST["Reportes"]["fecha_fin"];
        }
        else if ($tipo_busqueda == 3) //Dia
        {
            $criteria->compare("fecha", $_POST["Reportes"]["fecha"]);
            $periodo = $_POST["Reportes"]["fecha"];
        }

        $criteria->compare("id_cliente_bcnl", $id_cliente_bcnl);

        $model=ResumenBcpPromocion::model()->findAll($criteria);

        $total = 0;
        $data = array();

        foreach ($model as $value)
        {
            $data[] = '<li class="list-group-item">'.
                        $this->widget(
                            'booster.widgets.TbBadge',
                            array(
                                'label' => number_format($value["cantd_msj"], 0, '', '.'),
                                'htmlOptions' => array('id'=>'detalleEnviadosBCP', 'style' => 'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($value["operadora"]).'; color: white', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
                            ), true
                        ).'<strong class="">'.ucfirst(strtolower($value["sc"])).'</strong></li>';

            $total += $value["cantd_msj"];
        }

        $cliente = '<li class="list-group-item">'.
                        $this->widget(
                            'booster.widgets.TbBadge',
                            array(
                                'label' => $this->actionGetDescripcionClienteBCNL($id_cliente_bcnl),
                                'htmlOptions' => array('style' => 'background-color: white; color: black;', 'class'=>'trOverFlow', 'title'=>'', 'data-tooltip'=>'tooltip'),
                            ), true
                        ).'<strong class="">Cliente</strong></li>';

        $objeto = array(
                'total' => number_format($total, 0, '', '.'),
                'data' => implode(" ", $data),
                'periodo' => $periodo,
                'cliente' => $cliente
            );

        echo CJSON::encode(array('objeto'=>$objeto));

        Yii::app()->end();   
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
}

?>