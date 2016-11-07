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

    //Corre cada minuto todos los dias
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
        }
        else
        {
            print_r("No existen usuarios con acceso al sistema <br>");
        }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("<br>------------------------------------------------------------<br>");
    }

    //Corre cada 5 minutos todos los dias
    //Sirve la información de los puertos de cada usuario de BCNL
    public function actionServirPuertosBCNL()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."<br>");

        $transaction = Yii::app()->db->beginTransaction();
        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            print_r("Borrando tabla temporal insignia_masivo.tmp_usuario_puerto<br>");

            TmpUsuarioPuerto::model()->deleteAll();

            $criteria = new CDbCriteria;
            $criteria->select = "propiedad, valor";
            $criteria->addInCondition("propiedad", array('puerto_dias_inhabilitado', 'puerto_dias_warning'));
            $dias = ConfiguracionSistema::model()->findAll($criteria);

            foreach ($dias as $value)
            {
                if ($value["propiedad"] == "puerto_dias_inhabilitado")
                {
                    $dias_inhabilitado = $value["valor"];
                    print_r("Cantidad máxima de días sin enviar para inhabilitar el puerto: ".$value["valor"]."<br>");
                }
                
                if ($value["propiedad"] == "puerto_dias_warning")
                {
                    $dias_warning = $value["valor"];
                    print_r("Cantidad máxima de días sin enviar para mostrar el warning por próxima inhabilitación: ".$value["valor"]."<br>");
                }
            }

            //Calcular la fecha que representa ese dia inactivo
            $date_inactivo = date("Y-m-d", strtotime(-$dias_inhabilitado.' day', strtotime(date('Y-m-d'))));
            print_r("Máxima fecha de envió para inhabilitar el puerto: ".$date_inactivo."<br>");

            $date_warning = date("Y-m-d", strtotime(-$dias_warning.' day', strtotime(date('Y-m-d'))));
            print_r("Máxima fecha de envió para mostar el mensaje de warnign: ".$date_warning."<br>");

            print_r("Obtener todos los puertos que deben ser inhabilitados por desuso o próximos a inhabilitar<br>");
            
            $sql = "SELECT GROUP_CONCAT(id_modem) AS ids FROM control_envios_modems WHERE fecha <= '".$date_inactivo."'";            
            $puertos_inhabilitar = Yii::app()->db_supervision_modems->createCommand($sql)->queryRow();

            $sql = "SELECT GROUP_CONCAT(id_modem) AS ids FROM control_envios_modems WHERE fecha = '".$date_warning."'";            
            $puertos_warning = Yii::app()->db_supervision_modems->createCommand($sql)->queryRow();

            if ($puertos_inhabilitar["ids"] != "" || $puertos_warning["ids"] != "")
            {
                print_r("Buscando usuarios con acceso al sistema<br>");

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

                    print_r("Cantidad de usuarios: ".COUNT($usuarios_masivos)."<br>");
                    print_r("Usuarios que serán procesados: ".implode(",", $usuarios_masivos)."<br>");

                    $sql = "SELECT id_usuario, puertos, puertos_de_respaldo FROM usuario WHERE id_usuario IN (".implode(",", $usuarios_masivos).")";
                    $usuarios = Yii::app()->db->createCommand($sql)->queryAll();

                    print_r("Insertando los puertos principales y de respaldo de todos los usuarios en la tabla temporal<br>");

                    foreach ($usuarios as $value)
                    {
                        $puertos_principales = $this->actionConstruirInsertTmp($value["id_usuario"], $value["puertos"], 0);
                        $puertos_respaldo = $this->actionConstruirInsertTmp($value["id_usuario"], $value["puertos_de_respaldo"], 1);

                        if (COUNT($puertos_principales) > 0)
                        {
                            $sql = "INSERT INTO tmp_usuario_puerto (id_usuario, id_puerto, tipo, fecha, hora) VALUES ".implode(",", $puertos_principales);
                            Yii::app()->db->createCommand($sql)->execute();
                        }

                        if (COUNT($puertos_respaldo) > 0)
                        {
                            $sql = "INSERT INTO tmp_usuario_puerto (id_usuario, id_puerto, tipo, fecha, hora) VALUES ".implode(",", $puertos_respaldo);
                            Yii::app()->db->createCommand($sql)->execute();
                        }
                    }

                    //Si existen puertos por inhabilitar
                    if ($puertos_inhabilitar["ids"] != "")
                    {
                        print_r("Puertos que serán inhabilitados por desuso: ".$puertos_inhabilitar["ids"]."<br>");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos, tipo FROM tmp_usuario_puerto 
                                WHERE id_puerto IN(".$puertos_inhabilitar["ids"].") 
                                GROUP BY id_usuario, tipo";
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Buscando los usuarios que poseen puertos que deben ser inhabilitados para insertarlos en la tabla insignia_masivo.puertos_inhabilitados<br>");

                        foreach ($resultado as $value)
                        {
                            $values = $this->actionConstruirInsertPuertosInhabilitados($value["id_usuario"], $value["puertos"], $value["tipo"]);
                            
                            $sql = "INSERT INTO puertos_inhabilitados (id_usuario, puerto, razon_de_inhabilitacion, usuario_notificado, es_puerto_respaldo) VALUES ".implode(",", $values);
                            Yii::app()->db->createCommand($sql)->execute();

                            $asunto = "INHABILITACION DE PUERTOS";

                            $mensaje = "<br>El sistema ha inhabilitado los siguientes puertos: ";
                            $mensaje .= "<br><ul><li> Por inactividad: <b>".$value["puertos"]."</b></li>";
                            $mensaje .= "</ul><b>Nota:</b></b><ul><li>Puertos inhabilitados <b>NO</b> pueden ser usados para enviar promociones</li><li>Puertos inhabilitados <b>solo seran rehabilitados por un administrador del sistema</b></li></ul>";

                            Yii::app()->Procedimientos->setNotificacion($value["id_usuario"], $asunto, $mensaje);   
                        }

                        print_r("Actulizando en vacio la cadena de puertos de cada usuario<br>");

                        $sql = "UPDATE usuario SET puertos = '', puertos_de_respaldo = '' WHERE id_usuario IN (".implode(",", $usuarios_masivos).")";
                        Yii::app()->db->createCommand($sql)->execute();

                        print_r("Buscando los puertos que tendra disponible cada usuario<br>");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos, tipo FROM tmp_usuario_puerto 
                                WHERE id_puerto NOT IN(".$puertos_inhabilitar["ids"].") 
                                GROUP BY id_usuario, tipo";
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Actualizando las cadenas de puertos de los usuarios<br>");

                        foreach ($resultado as $value)
                        {
                            if ($value["tipo"] == 0) //Puertos principales
                            {
                                $sql = "UPDATE usuario SET puertos = '".$value["puertos"]."' WHERE id_usuario = ".$value["id_usuario"];
                            }

                            if ($value["tipo"] == 1) //Puertos de respaldo
                            {
                                $sql = "UPDATE usuario SET puertos_de_respaldo = '".$value["puertos"]."' WHERE id_usuario = ".$value["id_usuario"];    
                            }

                            Yii::app()->db->createCommand($sql)->execute();
                        }
                    }

                    //Si existen puertos proximos a inhabilitar
                    if ($puertos_warning["ids"] != "")
                    {
                        print_r("Buscando los puertos que están próximos a inhabilitación de cada usuario<br>");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos FROM tmp_usuario_puerto 
                                WHERE id_puerto NOT IN(".$puertos_inhabilitar["ids"].") 
                                AND id_puerto IN(".$puertos_warning["ids"].")
                                AND tipo = 1 
                                GROUP BY id_usuario";
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Creando mensajes de alerta para cada usuario que lo requiera<br>");

                        foreach ($resultado as $value)
                        {
                            $asunto = "ALERTA DE SUSPENSION DE PUERTOS";
                            $aux = $dias_inhabilitado - $dias_warning;

                            $mensaje = "Los siguientes puertos presentan poco uso y <b>están próximos a ser inhabilitados</b>, para evitar esta acción <b>deberá hacer uso de ellos</b>.<ul><li>El/los puerto(s): <b>".$value["puertos"]."</b> están a <b>".$aux."</b> día(s) de ser inhabilitados (Ultima vez usado ".$date_warning.")</ul>";
                            
                            Yii::app()->Procedimientos->setNotificacion($value["id_usuario"], $asunto, $mensaje);   
                        }
                    }
                }
                else
                {
                    print_r("No existen usuarios con acceso al sistema <br>");
                }
            }
            else
            {
                print_r("No existen puertos para inhabilitar o próximos a inhabilitar<br>");
            }

            $transaction->commit();
            $transaction2->commit();

        } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos<br>");
                    $transaction->rollBack();
                    $transaction2->rollBack();
                }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("<br>----------------------------------------------------------------------------------------------------------------------<br>");
    }

    private function actionConstruirInsertTmp($id_usuario, $cadena_puertos, $tipo)
    {
        $arreglo = array();
        
        if ($cadena_puertos != "")
        {
            //Limpiar comas y espacios de la cadena de puertos
            $puertos = Yii::app()->Funciones->limpiarNumerosTexarea($cadena_puertos);
            $puertos = explode(",", $puertos);
            
            //Si existen puertos construir el insert
            foreach ($puertos as $value)
            {
                $arreglo[] = "(".$id_usuario.", ".$value.", ".$tipo.", '".date("Y-m-d")."', '".date("H:i:s")."')";
            }
        }   

        return $arreglo;
    }

    private function actionConstruirInsertPuertosInhabilitados($id_usuario, $cadena_puertos, $tipo)
    {
        $arreglo = array();
        $puertos = explode(",", $cadena_puertos);

        foreach ($puertos as $value)
        {
            $arreglo[] = "(".$id_usuario.", ".$value.", 'Inhabilitado por inactividad el ".date("Y-m-d H:i:s")."', 0, ".$tipo.")"; 
        }

        return $arreglo;
    }
}

?>