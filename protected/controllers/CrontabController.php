<?php

class CrontabController extends Controller
{
    //public $layout="//layouts/menuApp";

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {

        return (array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(''),
                'users' => array('*'),
            ),

            /*array('deny', // deny all users
                'users' => array('*'),
            ),*/
        ));
    }

    private function ultimoDiaMes()
    {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }

    //Sirve la información del cupo de cada usuario de BCNL
    public function actionServirCupoBCNL()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."<br>");

        $sql = "SELECT u.id_usuario FROM usuario u 
                INNER JOIN insignia_masivo_premium.permisos p ON u.id_usuario = p.id_usuario 
                WHERE p.acceso_sistema = 1 AND p.broadcasting = 1";

        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

        if ($resultado)
        {
            foreach ($resultado as $value)
            {
                $usuarios_masivos[] = $value["id_usuario"];
            }

            $criteria = new CDbCriteria;
            $criteria->addInCondition("id_usuario", $usuarios_masivos);
            $usuarios_sms = UsuarioSms::model()->findAll($criteria);

            $ultimoDiaMes = $this->ultimoDiaMes();
            $fecha = date("Y-m-d");
            $registros_insert = array();
            $contador = 0;

            print_r("Analizando información de los usuarios<br>");

            $transaction = Yii::app()->db->beginTransaction();

            print_r("Insertando registros<br>");

            try
            {
                foreach ($usuarios_sms as $value)
                {
                    $sql = "SELECT COUNT(o.id_sms) AS total FROM outgoing o FORCE INDEX (indice_cupo) 
                            INNER JOIN promociones p ON o.id_promo = p.id_promo 
                            WHERE p.fecha BETWEEN '".date("Y-m-01")."' AND '".$ultimoDiaMes."' 
                                AND p.cliente = ".$value["id_cliente"]." 
                                AND o.status = 3";

                    $sms_enviados_mes = Yii::app()->db->createCommand($sql)->queryRow();

                    $sql = "SELECT id_usuario, 
                            IFNULL(SUM(c.cupo_asignado), 0) AS cupo_asignado, 
                            IFNULL(SUM(c.cupo_consumido), 0) AS cupo_consumido, 
                            IFNULL(SUM(c.cupo_asignado-c.cupo_consumido), 0) AS cupo_disponible
                            FROM control_cupo_usuario c
                            WHERE c.id_usuario = ".$value["id_usuario"]."  
                            AND id >= (SELECT MAX(cc.id) FROM control_cupo_usuario cc 
                                        WHERE cc.id_usuario=c.id_usuario AND cc.inicio_cupo = 1) 
                            AND (DATE(c.fecha_vencimiento) >= '".$fecha."' ) 
                            AND c.cupo_consumido < c.cupo_asignado 
                            GROUP BY c.id_usuario 
                            ORDER BY c.id_usuario";

                    $cupo = Yii::app()->db->createCommand($sql)->queryRow();

                    if ($sms_enviados_mes["total"])
                        $enviados_mes = $sms_enviados_mes["total"];
                    else
                        $enviados_mes = 0;

                    if ($cupo["cupo_asignado"])
                        $asignado = $cupo["cupo_asignado"];
                    else
                        $asignado = 0;

                    if ($cupo["cupo_consumido"])
                        $consumido = $cupo["cupo_consumido"];
                    else
                        $consumido = 0;

                    if ($cupo["cupo_disponible"])
                        $disponible = $cupo["cupo_disponible"];
                    else
                        $disponible = 0;

                    $registros_insert = "(".$value["id_usuario"].", ".$asignado.", ".$consumido.", ".$disponible.", ".$enviados_mes.", '".$fecha."', '".date("H:i:s")."')";

                    //print_r("id_cliente: ".$value["id_cliente"]." id_usuario: ".$value["id_usuario"]." cupo_asignado: ".$asignado." cupo_consumido: ".$consumido." cupo_disponible: ".$disponible." sms_enviados_mes: ".$enviados_mes."<br>");

                    $sql = "INSERT INTO login_cupo(id_usuario, asignado, consumido, disponible, sms_por_mes, fecha, hora) VALUES ".$registros_insert." ON DUPLICATE KEY UPDATE asignado = ".$asignado.", consumido = ".$consumido.", disponible = ".$disponible.", sms_por_mes = ".$enviados_mes.", fecha = '".$fecha."', hora = '".date("H:i:s")."'";

                    Yii::app()->db->createCommand($sql)->execute();

                    $contador++;
                }

                $transaction->commit();

                print_r("Registros insertados: ".$contador."<br>");

             } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos<br>");
                    $transaction->rollBack();
                }

            print_r("Hora de finalización: ".date("H:i:s"));
        }
        else
        {
            print_r("No existen usuarios con acceso al sistema <br>");
        }

        print_r("<br>------------------------------------------------------------<br>");
    }
}

?>