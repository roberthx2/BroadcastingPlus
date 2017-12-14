<?php

Yii::import('application.extensions.PdfReporteMtMo', true);
ini_set("max_execution_time",0);

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
                'actions' => array('smsPorCodigo', 'smsPeriodoResumen', 'smsPorClienteBcp', 'smsPorClienteResumen', 'smsEnviadosBcp', 'smsEnviadosBcpResumen', 'smsPorCodigoCliente', 'reporteMTMO', 'generarReporteMTMO'),
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

    public function actionSmsPorCodigoCliente()
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

        $this->render('smsPorCodigoClienteBCP', array('model'=>$model));
    }

    public function actionReporteMTMO()
    {
        $sql = "SELECT id_fecha as id FROM reporte_fecha WHERE fecha = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')";
        $id_fecha = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();
        
        if (!isset($id_fecha["id"]))
        {
            $transaction = Yii::app()->db_masivo_premium->beginTransaction();

            try
            {
                $periodo =  $this->getPeriodo();

                $fecha_ini = date('Y-m-01',strtotime('-1 month', strtotime(date('Y-m-01'))));
                $fecha_fin = $this->getUltimoDiaMes($fecha_ini);

                $criteria = new CDbCriteria;
                $criteria->compare('estado', 1);
                $model = ReporteDestinatarios::model()->findAll($criteria);

                $correos = array();
                $numeros = array();

                //print_r("Correos a los que sera enviado el reporte: \n");

                foreach ($model as $value)
                { 
                    $correos[] = $value["correo"];

                    if ($value["numero"] != "" && $value["numero"] != "0")
                    {
                        $mensaje = "Reporte MTs Cliente - Periodo: ".$periodo["mes"]." ".$periodo["ano"]." disponible en su correo electronico ".$value["correo"];

                        $numeros[] = "('".$value["numero"]."', '".$mensaje."', '".date("Y-m-d")."', '07:30:00', 2909, 1, ".$value["id_operadora"].")";
                    }
                }

                $model_fecha = new ReporteFecha;
                $model_fecha->fecha = $fecha_ini;
                $model_fecha->save();

                $criteria = new CDbCriteria;
                $criteria->select = "GROUP_CONCAT(id_promo) AS id_promo";
                $criteria->addBetweenCondition("fecha", $fecha_ini, $fecha_fin);
                $total_promo = PromocionesPremium::model()->find($criteria);

                $total_promo = $total_promo->id_promo == "" ? 0 : (substr_count($total_promo->id_promo, ",")+1);

                $sql = "SELECT cliente, GROUP_CONCAT(t.cantidades ORDER BY t.operadora ASC) AS cantidades, GROUP_CONCAT(t.operadora ORDER BY t.operadora ASC) AS operadoras FROM (
                    SELECT id_cliente_bcp AS cliente, SUM(cantd_msj) AS cantidades, operadora 
                    FROM resumen_bcp_diario 
                    WHERE fecha BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'  GROUP BY id_cliente_bcp, operadora
                    order by id_cliente_bcp ASC
                    ) t
                GROUP BY t.cliente";

                $resultado = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();
                $insert = array();

                foreach ($resultado as $value)
                {
                        $operadoras = array(2=>0, 3=>0, 4=>0);

                        $oper = explode(",", $value["operadoras"]);
                        $cant = explode(",", $value["cantidades"]);

                        for ($i=0; $i < count($oper); $i++)
                        { 
                                $operadoras[$oper[$i]] = $cant[$i]; 
                        }

                        $insert[] = "(".$id_fecha["id"].", ".$value["cliente"].", ".$operadoras[2].", ".$operadoras[3].", ".$operadoras[4].", 1)";
                }

                $sql = "SELECT cliente, GROUP_CONCAT(t.cantd_env ORDER BY t.op ASC) AS cantidades, GROUP_CONCAT(t.op ORDER BY t.op ASC) AS operadoras
                    FROM (SELECT cliente, COUNT(*) AS cantd_env, IF(operadora IN (1 , 2), 2, IF(operadora IN (3 , 4), 3, 4)) AS op 
                        FROM outgoing o
                        WHERE fecha_in BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' AND status = 1 AND sdr IS NULL   
                        GROUP BY cliente , op ORDER BY cliente ASC) t
                    GROUP BY t.cliente";

                $resultado = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryAll();

                foreach ($resultado as $value)
                {
                        $operadoras = array(2=>0, 3=>0, 4=>0);

                        $oper = explode(",", $value["operadoras"]);
                        $cant = explode(",", $value["cantidades"]);

                        for ($i=0; $i < count($oper); $i++)
                        { 
                                $operadoras[$oper[$i]] = $cant[$i]; 
                        }

                        $insert[] = "(".$id_fecha["id"].", ".$value["cliente"].", ".$operadoras[2].", ".$operadoras[3].", ".$operadoras[4].", 2)";
                }

                $sql = "INSERT INTO reporte_detalles_mt (id_fecha, id_cliente, movistar, movilnet, digitel, tipo) VALUES ".implode(",", $insert);
                Yii::app()->db_insignia_alarmas->createCommand($sql)->execute();

                $sql = "UPDATE reporte_detalles_mt r 
                                INNER JOIN cliente c ON r.id_cliente = c.id 
                                SET r.descripcion = REPLACE(c.descripcion, '@', ''),
                                r.sc = c.sc 
                                WHERE r.id_fecha = ".$id_fecha["id"];

                Yii::app()->db_insignia_alarmas->createCommand($sql)->execute();

                $sql = "INSERT INTO reporte_detalles_mo (id_fecha, id_cliente, descripcion, sc) 
                    SELECT ".$id_fecha["id"].", id, REPLACE(descripcion, '@', '') AS descripcion, sc FROM cliente WHERE sc REGEXP '^[0-9]+$'";

                Yii::app()->db_insignia_alarmas->createCommand($sql)->execute();

                $sql = "SELECT GROUP_CONCAT(DISTINCT sc) AS sc FROM reporte_detalles_mo WHERE id_fecha = ".$id_fecha["id"];
                $resultado = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();

                $sql = "SELECT sc, COUNT(id_sms) AS total FROM smsin 
                                        WHERE data_arrive BETWEEN '".$fecha_ini."' AND '".$fecha_fin."' 
                                                        AND sc IN(".$resultado["sc"].") 
                                                        GROUP BY sc";

                $resultado = Yii::app()->db_sms->createCommand($sql)->queryAll();

                foreach ($resultado as $value)
                {
                        $sql = "UPDATE reporte_detalles_mo SET total = ".$value["total"]." WHERE id_fecha = ".$id_fecha["id"]." AND sc = ".$value["sc"];
                        Yii::app()->db_insignia_alarmas->createCommand($sql)->execute();
                }

                generarPDF($conexion_alarmas, $id_fecha);

                $transaction->commit();

            } catch (Exception $e)
                {
                    print_r($e);
                    $transaction->rollBack();
                }
        }
        else
        {
            $this->actionGenerarReporteMTMO($id_fecha["id"]);
        }

    }

    public function actionGenerarReporteMTMO($id_fecha)
    {
        $periodo = $this->getPeriodo();

        $pdf = new PDF('L','mm','A4');
        $pdf->AliasNbPages();

        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10, "Reporte MT's Clientes",0,0,"L");

        $pdf->Ln(6);

        $pdf->Cell(40,10,'Periodo: '.$periodo["mes"]." ".$periodo["ano"],0,0,'L');
        $pdf->Ln(15);
        $pdf->Cell(0,10,'1. Reporte MT BCP',0,0,'L');
        $pdf->Ln(10);

        //Reporte BCP
        $data = $pdf->LoadDataMT($id_fecha, 1);
        $pdf->FancyTableMT($data);
        
        //Reporte Hostgator
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'2. Reporte MT Hostgator',0,0,'L');
        $pdf->Ln(10);

        $data = $pdf->LoadDataMT($id_fecha, 2);
        $pdf->FancyTableMT($data);

        //Reporte MO
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,10,'3. Reporte MO',0,0,'L');
        $pdf->Ln(10);

        $data = $pdf->LoadDataMO($id_fecha);
        $pdf->FancyTableMO($data);

        $pdf->Output();
    }

    private function getPeriodo()
    {
        $mes = date('m',strtotime('-1 month', strtotime(date('Y-m-01'))));
        $ano = date('Y',strtotime('-1 month', strtotime(date('Y-m-01'))));
        //Nunca quiso hacer la traduccion del mes por eso utilice un arreglo
        $meses = array('01'=>'Enero', 
                       '02'=>'Febrero', 
                       '03'=>'Marzo', 
                       '04'=>'Abril', 
                       '05'=>'Mayo', 
                       '06'=>'Junio', 
                       '07'=>'Julio',
                       '08'=>'Agosto',
                       '09'=>'Septiembre',
                       '10'=>'Octubre',
                       '11'=>'Noviembre',
                       '12'=>'Diciembre');

        return array("ano"=>$ano, "mes"=>$meses[$mes]);
    }

    private function getUltimoDiaMes($fecha_ini)
    {
        $aux = explode("-", $fecha_ini);
        $month = date($aux[1]);
        $year = date($aux[0]);

        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }
}

?>