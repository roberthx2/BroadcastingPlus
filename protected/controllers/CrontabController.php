<?php
ini_set("max_execution_time",0);
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
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        print_r("Buscando usuarios con acceso al sistema...\n");
        $criteria = new CDbCriteria;
        $criteria->select = "GROUP_CONCAT(p.id_usuario) AS id_usuario";
        $criteria->join = "INNER JOIN insignia_masivo_premium.permisos p ON t.id_usuario = p.id_usuario";
        $criteria->compare("p.acceso_sistema", 1);
        $criteria->compare("p.broadcasting", 1);
        print_r($criteria);
        print_r("\n");
        $usuarios_masivos = UsuarioMasivo::model()->find($criteria);

        if ($usuarios_masivos->id_usuario != "")
        {
            print_r("Obteniendo informacion de usuarios con acceso al sistema...\n");
            $criteria = new CDbCriteria;
            $criteria->addInCondition("id_usuario", explode(",", $usuarios_masivos->id_usuario));
            print_r($criteria);
            print_r("\n");
            $usuarios_sms = UsuarioSms::model()->findAll($criteria);

            $ultimoDiaMes = $this->ultimoDiaMes();
            $fecha = date("Y-m-d");
            $registros_insert = array();
            $contador = 0;

            //print_r("Analizando información de los usuarios\n");
            print_r("Inicia la transaction...\n");

            $transaction = Yii::app()->db->beginTransaction();

            ///print_r("Insertando registros\n");

            try
            {
                print_r("Consultando los mensajes enviados por cliente sms...\n");

                foreach ($usuarios_sms as $value)
                {
                    $sql = "SELECT COUNT(o.id_sms) AS total FROM outgoing o FORCE INDEX (indice_cupo) 
                            INNER JOIN promociones p ON o.id_promo = p.id_promo 
                            WHERE p.fecha BETWEEN '".date("Y-m-01")."' AND '".$ultimoDiaMes."' 
                                AND p.cliente = ".$value["id_cliente"]." 
                                AND o.status = 3";
                    print_r($sql."...\n");

                    $sms_enviados_mes = Yii::app()->db->createCommand($sql)->queryRow();

                    print_r("Consulta el control de cupo por usuario...\n");
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
                    print_r($sql."...\n");

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

                    //print_r("id_cliente: ".$value["id_cliente"]." id_usuario: ".$value["id_usuario"]." cupo_asignado: ".$asignado." cupo_consumido: ".$consumido." cupo_disponible: ".$disponible." sms_enviados_mes: ".$enviados_mes."\n");

                    $sql = "INSERT INTO login_cupo(id_usuario, asignado, consumido, disponible, sms_por_mes, fecha, hora) VALUES ".$registros_insert." ON DUPLICATE KEY UPDATE asignado = ".$asignado.", consumido = ".$consumido.", disponible = ".$disponible.", sms_por_mes = ".$enviados_mes.", fecha = '".$fecha."', hora = '".date("H:i:s")."'";

                    print_r("Innsertando/Actualizando datos del usuario...\n");
                    print_r($sql."...\n");

                    Yii::app()->db->createCommand($sql)->execute();

                    $contador++;
                }

                print_r("Aplicando commit a la transaction...\n");
                $transaction->commit();

                print_r("Registros insertados / actualizados: ".$contador."\n");

             } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos\n");
                    $transaction->rollBack();
                }
        }
        else
        {
            print_r("No existen usuarios con acceso al sistema \n");
        }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n------------------------------------------------------------\n");
    }

    //Corre cada 5 minutos todos los dias
    //Sirve la información de los puertos de cada usuario de BCNL
    public function actionServirPuertosBCNL()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        print_r("Inicia la transaction1...\n");
        $transaction = Yii::app()->db->beginTransaction();
        print_r("Inicia la transaction2...\n");
        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            print_r("Borrando tabla temporal insignia_masivo.tmp_usuario_puerto\n");

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
                    print_r("Cantidad máxima de días sin enviar para inhabilitar el puerto: ".$value["valor"]."\n");
                }
                
                if ($value["propiedad"] == "puerto_dias_warning")
                {
                    $dias_warning = $value["valor"];
                    print_r("Cantidad máxima de días sin enviar para mostrar el warning por próxima inhabilitación: ".$value["valor"]."\n");
                }
            }

            //Calcular la fecha que representa ese dia inactivo
            $date_inactivo = date("Y-m-d", strtotime(-$dias_inhabilitado.' day', strtotime(date('Y-m-d'))));
            print_r("Máxima fecha de envió para inhabilitar el puerto: ".$date_inactivo."\n");

            $date_warning = date("Y-m-d", strtotime(-$dias_warning.' day', strtotime(date('Y-m-d'))));
            print_r("Máxima fecha de envió para mostar el mensaje de warning: ".$date_warning."\n");

            print_r("Obtener todos los puertos que deben ser inhabilitados por desuso\n");
            $sql = "SELECT GROUP_CONCAT(id_modem) AS ids FROM control_envios_modems WHERE fecha <= '".$date_inactivo."'";
            print_r($sql."\n");            
            $puertos_inhabilitar = Yii::app()->db_supervision_modems->createCommand($sql)->queryRow();

            print_r("Obtener todos los puertos que estan próximos a inhabilitar\n");
            $sql = "SELECT GROUP_CONCAT(id_modem) AS ids FROM control_envios_modems WHERE fecha = '".$date_warning."'";            
            print_r($sql."\n");
            $puertos_warning = Yii::app()->db_supervision_modems->createCommand($sql)->queryRow();

            if ($puertos_inhabilitar["ids"] != "" || $puertos_warning["ids"] != "")
            {
                print_r("Buscando usuarios con acceso al sistema\n");

                $sql = "SELECT u.id_usuario FROM usuario u 
                    INNER JOIN insignia_masivo_premium.permisos p ON u.id_usuario = p.id_usuario 
                    WHERE p.acceso_sistema = 1 AND p.broadcasting = 1";
                print_r($sql."\n");

                $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                if ($resultado)
                {
                    foreach ($resultado as $value)
                    {
                        $usuarios_masivos[] = $value["id_usuario"];
                    }

                    print_r("Cantidad de usuarios: ".COUNT($usuarios_masivos)."\n");

                    print_r("Usuarios que serán procesados: ".implode(",", $usuarios_masivos)."\n");

                    $sql = "SELECT id_usuario, puertos, puertos_de_respaldo FROM usuario WHERE id_usuario IN (".implode(",", $usuarios_masivos).")";
                    print_r($sql."\n");
                    $usuarios = Yii::app()->db->createCommand($sql)->queryAll();

                    print_r("Insertando los puertos principales y de respaldo de todos los usuarios en la tabla temporal\n");

                    foreach ($usuarios as $value)
                    {
                        $puertos_principales = $this->actionConstruirInsertTmp($value["id_usuario"], $value["puertos"], 0);
                        $puertos_respaldo = $this->actionConstruirInsertTmp($value["id_usuario"], $value["puertos_de_respaldo"], 1);

                        if (COUNT($puertos_principales) > 0)
                        {
                            $sql = "INSERT INTO tmp_usuario_puerto (id_usuario, id_puerto, tipo, fecha, hora) VALUES ".implode(",", $puertos_principales);
                            print_r($sql."\n");
                            Yii::app()->db->createCommand($sql)->execute();
                        }

                        if (COUNT($puertos_respaldo) > 0)
                        {
                            $sql = "INSERT INTO tmp_usuario_puerto (id_usuario, id_puerto, tipo, fecha, hora) VALUES ".implode(",", $puertos_respaldo);
                            print_r($sql."\n");
                            Yii::app()->db->createCommand($sql)->execute();
                        }
                    }

                    $criteria = new CDbCriteria;
                    $criteria->select = "GROUP_CONCAT(id_usuario) AS id_usuario";
                    $criteria->addInCondition("id_perfil", array(1,2));
                    $usuarios_adm = UsuarioSms::model()->find($criteria);
                    $usuarios_adm = ($usuarios_adm["id_usuario"] == "") ? "null":$usuarios_adm["id_usuario"];

                    print_r("Usuarios administrativos que no seran procesados: ".$usuarios_adm."\n");

                    //Si existen puertos por inhabilitar
                    if ($puertos_inhabilitar["ids"] != "")
                    {
                        print_r("Puertos que serán inhabilitados por desuso: ".$puertos_inhabilitar["ids"]."\n");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos, tipo FROM tmp_usuario_puerto 
                                WHERE id_puerto IN(".$puertos_inhabilitar["ids"].") AND id_usuario NOT IN (".$usuarios_adm.") 
                                GROUP BY id_usuario, tipo";
                        print_r($sql."\n");
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Buscando los usuarios que poseen puertos que deben ser inhabilitados para insertarlos en la tabla insignia_masivo.puertos_inhabilitados\n");

                        foreach ($resultado as $value)
                        {
                            $values = $this->actionConstruirInsertPuertosInhabilitados($value["id_usuario"], $value["puertos"], $value["tipo"]);
                            
                            $sql = "INSERT INTO puertos_inhabilitados (id_usuario, puerto, razon_de_inhabilitacion, usuario_notificado, es_puerto_respaldo) VALUES ".implode(",", $values);
                            print_r($sql."\n");
                            Yii::app()->db->createCommand($sql)->execute();

                            $asunto = "INHABILITACION DE PUERTOS";

                            $mensaje = "<br>El sistema ha inhabilitado los siguientes puertos: ";
                            $mensaje .= "<br><ul><li> Por inactividad: <b>".$value["puertos"]."</b></li>";
                            $mensaje .= "</ul><b>Nota:</b></b><ul><li>Puertos inhabilitados <b>NO</b> pueden ser usados para enviar promociones</li><li>Puertos inhabilitados <b>solo seran rehabilitados por un administrador del sistema</b></li></ul>";

                            print_r("Enviando notificacion al usuario: ".$value["id_usuario"]."\n");
                            Yii::app()->Procedimientos->setNotificacion($value["id_usuario"], 0, $asunto, $mensaje);   
                        }

                        print_r("Actulizando en vacio la cadena de puertos de cada usuario\n");

                        $sql = "UPDATE usuario SET puertos = '', puertos_de_respaldo = '' WHERE id_usuario IN (".implode(",", $usuarios_masivos).")";
                        print_r($sql."\n");
                        Yii::app()->db->createCommand($sql)->execute();

                        print_r("Buscando los puertos que tendra disponible cada usuario\n");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos, tipo FROM tmp_usuario_puerto 
                                WHERE id_puerto NOT IN(".$puertos_inhabilitar["ids"].") 
                                GROUP BY id_usuario, tipo";
                        print_r($sql."\n");
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Actualizando las cadenas de puertos de los usuarios\n");

                        foreach ($resultado as $value)
                        {
                            if ($value["tipo"] == 0) //Puertos principales
                            {
                                $sql = "UPDATE usuario SET puertos = '".$value["puertos"]."' WHERE id_usuario = ".$value["id_usuario"];
                                print_r($sql."\n");
                            }

                            if ($value["tipo"] == 1) //Puertos de respaldo
                            {
                                $sql = "UPDATE usuario SET puertos_de_respaldo = '".$value["puertos"]."' WHERE id_usuario = ".$value["id_usuario"]; 
                                print_r($sql."\n");   
                            }

                            Yii::app()->db->createCommand($sql)->execute();
                        }
                    }

                    //Si existen puertos proximos a inhabilitar
                    if ($puertos_warning["ids"] != "")
                    {
                        print_r("Buscando los puertos que están próximos a inhabilitación de cada usuario\n");

                        $sql = "SELECT id_usuario, GROUP_CONCAT(id_puerto) AS puertos FROM tmp_usuario_puerto 
                                WHERE id_puerto NOT IN(".$puertos_inhabilitar["ids"].") AND id_usuario NOT IN (".$usuarios_adm.") 
                                AND id_puerto IN(".$puertos_warning["ids"].")
                                AND tipo = 1 
                                GROUP BY id_usuario";
                        print_r($sql."\n");
                        $resultado = Yii::app()->db->createCommand($sql)->queryAll();

                        print_r("Creando mensajes de alerta para cada usuario que lo requiera\n");

                        foreach ($resultado as $value)
                        {
                            $asunto = "ALERTA DE SUSPENSION DE PUERTOS";
                            $aux = $dias_inhabilitado - $dias_warning;

                            $mensaje = "Los siguientes puertos presentan poco uso y <b>están próximos a ser inhabilitados</b>, para evitar esta acción <b>deberá hacer uso de ellos</b>.<ul><li>El/los puerto(s): <b>".$value["puertos"]."</b> están a <b>".$aux."</b> día(s) de ser inhabilitados (Ultima vez usado ".$date_warning.")</ul>";
                            print_r("Enviando notificacion al usuario: ".$value["id_usuario"]."\n");
                            Yii::app()->Procedimientos->setNotificacion($value["id_usuario"], 0, $asunto, $mensaje);   
                        }
                    }
                }
                else
                {
                    print_r("No existen usuarios con acceso al sistema \n");
                }
            }
            else
            {
                print_r("No existen puertos para inhabilitar o próximos a inhabilitar\n");
            }


            $transaction->commit();
            print_r("Aplicando commit a la transaction1...\n");
            $transaction2->commit();
            print_r("Aplicando commit a la transaction2...\n");

        } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos\n");
                    print_r($e);
                    $transaction->rollBack();
                    $transaction2->rollBack();
                }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n----------------------------------------------------------------------------------------------------------------------<br>");
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

    //Se ejecuta todos los dias a media noche luego de llenar la tabla original de smsxnumeros de insingia_masivo
    public function actionServirTablaTmpSmsXnumero()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $criteria = new CDbCriteria;
            $criteria->select = "valor";
            $criteria->compare("propiedad", 'cant_min_smsxnumero');
            $cant_min_smsxnumero = ConfiguracionSistema::model()->find($criteria);

            printf("Cantidad de sms mínimos enviados para el filtro de smsxnumero = ".$cant_min_smsxnumero->valor."\n");

            print_r("Obteniendo números de la tabla insignia_masivo.smsxnumeros\n");

            $sql = "SELECT AES_DECRYPT(telefono, concat('''', CURDATE(), '''')) AS telefonos FROM smsxnumeros WHERE sms_enviados >= ".$cant_min_smsxnumero->valor;
            print_r($sql."\n");
            $sql = Yii::app()->db->createCommand($sql)->queryAll();

            if ($sql)
            {
                print_r("Guardando los números en un array temporal\n");

                foreach ($sql as $value)
                {
                    $cadena_numeros[] = $value["telefonos"];
                }

                print_r("Borrando la tabla insignia_masivo_premium.tmp_smsxnumero\n");

                $sql = "TRUNCATE tmp_smsxnumero";
                print_r($sql."\n");

                Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                printf("Limpiando cadena para realizar el insert en insignia_masivo_premium.tmp_smsxnumero\n");

                foreach ($cadena_numeros as $value)
                {
                    //Luego limpio las doble,triples,etc comas
                    $numeros = trim(preg_replace('/,{2,}/', ",", $value), ",");
                    //Armo el super insert
                    $numeros = "('".str_replace(",", "'),('", $numeros)."')";

                    $sql = "INSERT INTO tmp_smsxnumero (numero) VALUES ".$numeros;
                    //print_r($sql."\n");
                
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();
                }

                /*printf("Limpiando cadena para realizar el insert en insignia_masivo_premium.tmp_smsxnumero\n");
                //Concateno la cadena por coma (,)
                $cadena_numeros = implode(",", $cadena_numeros);
                //Luego limpio las doble,triples,etc comas
                $cadena_numeros = trim(preg_replace('/,{2,}/', ",", $cadena_numeros), ",");
                //Armo el super insert
                $cadena_numeros = "('".str_replace(",", "'),('", $cadena_numeros)."')";

                print_r("Borrando la tabla insignia_masivo_premium.tmp_smsxnumero\n");

                $sql = "TRUNCATE tmp_smsxnumero";
                print_r($sql."\n");

                Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                print_r("Insertando registros en la tabla insignia_masivo_premium.tmp_smsxnumero\n");

                $sql = "INSERT INTO tmp_smsxnumero (numero) VALUES ".$cadena_numeros;
                //print_r($sql."\n");
                
                Yii::app()->db_masivo_premium->createCommand($sql)->execute();*/

                print_r("Asignando los prefijos de las operadoras correspondientes\n");

                $sql = "SELECT id_operadora_bcnl, CONCAT('^',GROUP_CONCAT(DISTINCT prefijo SEPARATOR '|^')) AS prefijo, GROUP_CONCAT(DISTINCT prefijo SEPARATOR ' | ') AS prefijo_print, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl";
                print_r($sql."\n");
                $operadoras = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

                foreach ($operadoras as $value)
                {
                    print_r("Asignado prefijo para la operadora ".$value["descripcion"]." (".$value["prefijo_print"].")\n");

                    $sql = "UPDATE tmp_smsxnumero SET id_operadora = ".$value["id_operadora_bcnl"]." WHERE numero REGEXP '".$value["prefijo"]."'";
                    print_r($sql."\n");
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();
                }

                print_r("Eliminando de la tabla insignia_masivo_premium.tmp_smsxnumero todos los números que no posean una operadora valida\n");

                $sql = "DELETE FROM tmp_smsxnumero where id_operadora = 0";
                print_r($sql."\n");
                Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                $sql = "SELECT COUNT(id) AS total FROM tmp_smsxnumero";
                print_r($sql."\n");
                $total = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

                print_r("Cantidad de registros insertados en la tabla insignia_masivo_premium.tmp_smsxnumero: ".$total["total"]."\n");
            }
            else
            {
                print_r("No hay registros en la tabla insignia_masivo.smsxnumeros\n");
            }

            print_r("Aplicando commit a la transaction...\n");
            $transaction->commit();

        } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos\n");
                    print_r($e);
                    $transaction->rollBack();
                }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n----------------------------------------------------------------------------------------------------------------------\n");
    }

    //Se ejecuta todos los dias cada 15 minutos, verifica todas las promociones BCP que finalizaron y verifica cuantos sms no fuerón enviados para realizar el reintegro de cupo al usuario que creo la promoción
    public function actionReintegroCupoBCP()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        print_r("Inicia la transaction...\n");
        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");

            print_r("Buscando promociones finalizadas para realizar el reintegro de cupo\n");

            $sql = "SELECT p.id_promo, p.nombrePromo, p.loaded_by FROM promociones_premium p 
                    INNER JOIN deadline_outgoing_premium d ON p.id_promo = d.id_promo 
                    WHERE p.fecha = '".$fecha."' AND p.verificada = 0 AND d.hora_limite < '".$hora."'";
            print_r($sql."\n");
            $sql = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

            if ($sql)
            {
                foreach ($sql as $value)
                {   
                    print_r("Consultando información del usuario: ".$value["loaded_by"]." \n");

                    $usuario = "SELECT id_cliente, login FROM usuario WHERE id_usuario = ".$value["loaded_by"];
                    print_r($usuario."\n");
                    $usuario = Yii::app()->db_sms->createCommand($usuario)->queryRow();

                    print_r("Contando mensajes de outgoing_premium_diario...\n");
                    $sql2 = "SELECT
                            (SELECT COUNT(id) FROM outgoing_premium_diario WHERE id_promo = ".$value["id_promo"].") AS total,
                            (SELECT COUNT(id) FROM outgoing_premium_diario WHERE id_promo = ".$value["id_promo"]." AND status = 1) AS enviados,
                            (SELECT COUNT(id) FROM outgoing_premium_diario WHERE id_promo = ".$value["id_promo"]." AND status != 1) AS no_enviados";
                    print_r($sql2."\n");

                    $total = Yii::app()->db_masivo_premium->createCommand($sql2)->queryRow();

                    printf("* Promocion con id_promo: ".$value["id_promo"]." | usuario: ".$usuario["login"]." |  ");

                    print_r("Total: ".$total["total"]." | Enviados: ".$total["enviados"]." | No enviados: ".$total["no_enviados"]);

                    if ($total["no_enviados"] > 0)
                    {
                        print_r(" | Si aplica para reintegro de cupo\n");

                        print_r("Reintegrando cupo al usuario: ".$usuario["login"]." con id: ".$value["loaded_by"]."\n");

                        $model_cupo = UsuarioCupoPremium::model()->findByPk($value["loaded_by"]);
                        $model_cupo->disponible = $model_cupo->disponible + $total["no_enviados"];
                        $model_cupo->save();

                        print_r("Guardando el historial correspondiente\n");

                        $descripcion_historial = "REINTEGRO - El sistema reintegro (".$total["no_enviados"].") SMS por la promoción BCP: ".$value["nombrePromo"];

                        $model_cupo_historial = new UsuarioCupoHistoricoPremium;
                        $model_cupo_historial->id_usuario = $value["loaded_by"];
                        $model_cupo_historial->id_cliente = $usuario["id_cliente"];
                        $model_cupo_historial->ejecutado_por = 0;
                        $model_cupo_historial->cantidad = $total["no_enviados"];
                        $model_cupo_historial->descripcion = $descripcion_historial;
                        $model_cupo_historial->fecha = date("Y-m-d");
                        $model_cupo_historial->hora = date("H:i:s");
                        $model_cupo_historial->tipo_operacion = 2; //Reintegro
                        $model_cupo_historial->save();

                        $descripcion_historial = "REINTEGRO - El sistema reintegro <strong>(".$total["no_enviados"].") SMS</strong> por la promoción BCP: <strong>".$value["nombrePromo"]."</strong>";

                        $asunto = "REINTEGRO DE CUPO BCP";
                        Yii::app()->Procedimientos->setNotificacion($value["loaded_by"], 0, $asunto, $descripcion_historial);

                        $log = 'REINTEGRO - El sistema reintegro ('.$total["no_enviados"].') SMS al usuario '.$usuario["login"].' (id='.$value["loaded_by"].') por la promocion BCP (id_promo = '.$value["id_promo"].')';

                        Yii::app()->Procedimientos->setLog($log);                      
                    }   
                    else
                    {
                        print_r(" | No aplica para reintegro de cupo\n");
                    }

                    print_r("Marcando promoción como verificada\n");
                    $sql_verificada = "UPDATE promociones_premium SET verificada = 1 WHERE id_promo = ".$value["id_promo"];
                    print_r($sql_verificada."\n");
                    Yii::app()->db_masivo_premium->createCommand($sql_verificada)->execute();  
                }
            }
            else
            {
                print_r("No hay promociones por analizar\n");
            }

            print_r("Aplicando commit a la transaction...\n");
            $transaction->commit();

        } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos\n");
                    print_r($e);
                    $transaction->rollBack();
                }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n----------------------------------------------------------------------------------------------------------------------\n");
    }

    public function actionReintegroCupoBCNL()
    {
        //NO ES MI CULPA QUE ESTA BROMA QUEDARA ASI DE FEA, SOLO SEGUI LA LOGICA EN QUE HICIERON EL MANEJO DEL CUPO BCNL
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        print_r("Inicia la transaction1...\n");
        $transaction = Yii::app()->db->beginTransaction();
        print_r("Inicia la transaction2...\n");
        $transaction2 = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");

            print_r("Buscando promociones finalizadas para realizar el reintegro de cupo\n");

            $sql = "SELECT p.id_promo, p.nombrePromo, p.cadena_usuarios FROM promociones p 
                    INNER JOIN deadline_outgoing d ON p.id_promo = d.id_promo 
                    WHERE p.fecha = '".$fecha."' AND p.verificado = 0 AND d.hora_limite < '".$hora."'";
            print_r($sql."\n");
            $sql = Yii::app()->db->createCommand($sql)->queryAll();

            if($sql)
            {
                foreach ($sql as $value)
                {
                    $usuario = "SELECT id_cliente, login FROM usuario WHERE id_usuario = ".$value["cadena_usuarios"];
                    print_r($usuario."\n");
                    $usuario = Yii::app()->db_sms->createCommand($usuario)->queryRow();

                    print_r("Contando mensajes de outgoing...\n");
                    $sql2 = "SELECT
                            (SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = ".$value["id_promo"].") AS total,
                            (SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = ".$value["id_promo"]." AND status = 3) AS enviados,
                            (SELECT COUNT(id_sms) FROM outgoing WHERE id_promo = ".$value["id_promo"]." AND status != 3) AS no_enviados";
                    print_r($sql2."\n");

                    $total = Yii::app()->db->createCommand($sql2)->queryRow();

                    print_r("* Promocion con id_promo: ".$value["id_promo"]." | usuario: ".$usuario["login"]." |  ");

                    print_r("Total: ".$total["total"]." | Enviados: ".$total["enviados"]." | No enviados: ".$total["no_enviados"]);

                    if ($total["no_enviados"] > 0)
                    {
                        print_r(" | Si aplica para reintegro de cupo\n");

                        print_r("Reintegrando cupo al usuario: ".$usuario["login"]." con id: ".$value["cadena_usuarios"]."\n");

                        $sql3 = "SELECT IFNULL(MAX(id_transaccion),0)+1 AS id FROM historico_uso_cupo_usuario";
                        print_r($sql3."\n");
                        $id_transaccion = Yii::app()->db->createCommand($sql3)->queryRow();

                        $sql4 = "SELECT id, fecha_vencimiento, cupo_asignado, cupo_consumido 
                                    FROM control_cupo_usuario 
                                    WHERE id_usuario = ".$value["cadena_usuarios"]." 
                                    AND (DATE(fecha_vencimiento) >='".$fecha."')
                                    AND id>=(SELECT id FROM control_cupo_usuario WHERE id_usuario = ".$value["cadena_usuarios"]." AND inicio_cupo=1 ORDER BY id desc LIMIT 1)
                                    AND cupo_consumido <> 0 
                                    ORDER BY fecha_asignacion DESC";
                        print_r($sql4."\n");
                        $resultado = Yii::app()->db->createCommand($sql4)->queryAll();
                        $cupo_consumido_nuevo = $total["no_enviados"];

                        print_r("Guardando el historial correspondiente\n");

                        foreach ($resultado as $key)
                        {
                            $cupo_consumido_nuevo = $key['cupo_consumido'] - $cupo_consumido_nuevo;

                            //Update la linea del cupo
                            $aux = ($cupo_consumido_nuevo < 0 ? 0 : $cupo_consumido_nuevo);
                            $model_cupo = ControlCupoUsuario::model()->findByPk($key["id"]);
                            $model_cupo->cupo_consumido = $aux;
                            $model_cupo->save();

                            //Insertar log de transaccion en historico_uso_cupo_usuario

                            $model_cupo_historial = new HistoricoUsoCupoUsuario;
                            $model_cupo_historial->id_transaccion = $id_transaccion["id"];
                            $model_cupo_historial->id_control_cupo_usuario = $key['id'];
                            $model_cupo_historial->accion = 'REINTEGRAR - El sistema reintegro '.$total["no_enviados"].' SMS a usuario '.$usuario["login"].' (id='.$value["cadena_usuarios"].') por las promociones ('.$value["id_promo"].'). Reintegro '.($key['cupo_consumido'] - $aux).' a este cupo.';
                            $model_cupo_historial->cupo_consumido_antes = $key['cupo_consumido'];
                            $model_cupo_historial->cupo_consumido_despues = $aux;
                            $model_cupo_historial->fecha = date("Y-m-d H:i:s");
                            $model_cupo_historial->entidad = 'SISTEMA';
                            $model_cupo_historial->save();

                            if ($cupo_consumido_nuevo < 0)
                                $cupo_consumido_nuevo = abs($cupo_consumido_nuevo);
                            else
                                break;  //si ya no queda cupo por reintegrar ($cupo_consumido_nuevo >= 0), break
                        }
                        
                        $descripcion_historial = "REINTEGRO - El sistema reintegro <strong>(".$total["no_enviados"].") SMS</strong> por la promoción BCNL: <strong>".$value["nombrePromo"]."</strong>";

                        $asunto = "REINTEGRO DE CUPO BCNL";
                        Yii::app()->Procedimientos->setNotificacion($value["cadena_usuarios"], 0, $asunto, $descripcion_historial);

                        $log = 'REINTEGRO - El sistema reintegro ('.$total["no_enviados"].') SMS al usuario '.$usuario["login"].' (id='.$value["cadena_usuarios"].') por la promocion BCNL (id_promo = '.$value["id_promo"].')';

                        Yii::app()->Procedimientos->setLog($log);                      
                    }   
                    else
                    { 
                        print_r(" | No aplica para reintegro de cupo\n");
                    }

                    print_r("Marcando promoción como verificada\n");
                    $sql_verificada = "UPDATE promociones SET verificado = 1 WHERE id_promo = ".$value["id_promo"];
                    print_r($sql_verificada."\n");
                    Yii::app()->db->createCommand($sql_verificada)->execute();  
                }
            }
            else
            {
                print_r("No hay promociones por analizar\n");
            }

            $transaction->commit();
            print_r("Aplicando commit a la transaction1...\n");
            $transaction2->commit();
            print_r("Aplicando commit a la transaction2...\n");

        } catch (Exception $e)
            {
                print_r("Ocurrio un error al procesar los datos\n");
                print_r($e);
                $transaction->rollBack();
                $transaction2->rollBack();
            }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n----------------------------------------------------------------------------------------------------------------------\n");
    }

    //Se ejecuta todos los dias a media noche para llenar la tabla servida de exentos
    public function actionServirTablaTmpExentos()
    {
        printf("Hora inicio: ".date("Y-m-d H:i:s")."\n");

        $transaction = Yii::app()->db_masivo_premium->beginTransaction();

        try
        {
            print_r("Obteniendo números de la tabla insignia_masivo.exentos\n");

            $sql = "SELECT DISTINCT numero FROm exentos";
            $sql = Yii::app()->db->createCommand($sql)->queryAll();

            if ($sql)
            {
                print_r("Borrando la tabla insignia_masivo_premium.tmp_exentos\n");

                $sql2 = "TRUNCATE tmp_exentos";
                print_r($sql2."\n");

                Yii::app()->db_masivo_premium->createCommand($sql2)->execute();

                print_r("Insertando registros en la tabla tmp_exentos\n");

                $i = 0;

                foreach ($sql as $value)
                {
                    $cadena_numeros[] = "('".substr($value["numero"], 1)."')";
                    $i++;

                    if ($i == 5000)
                    {
                        $sql_insert = "INSERT INTO tmp_exentos (numero) VALUES ".implode(",", $cadena_numeros);
                        Yii::app()->db_masivo_premium->createCommand($sql_insert)->execute();
                        $cadena_numeros = array();
                    }
                }

                if (COUNT($cadena_numeros) > 0)
                {
                    $sql = "INSERT INTO tmp_exentos (numero) VALUES ".implode(",", $cadena_numeros);
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();
                }

                print_r("Asignando los prefijos de las operadoras correspondientes\n");

                $sql = "SELECT id_operadora_bcnl, CONCAT('^',GROUP_CONCAT(DISTINCT prefijo SEPARATOR '|^')) AS prefijo, GROUP_CONCAT(DISTINCT prefijo SEPARATOR ' | ') AS prefijo_print, descripcion FROM operadoras_relacion GROUP BY id_operadora_bcnl";
                print_r($sql."\n");
                $operadoras = Yii::app()->db_masivo_premium->createCommand($sql)->queryAll();

                foreach ($operadoras as $value)
                {
                    print_r("Asignado prefijo para la operadora ".$value["descripcion"]." (".$value["prefijo_print"].")\n");

                    $sql = "UPDATE tmp_exentos SET id_operadora = ".$value["id_operadora_bcnl"]." WHERE numero REGEXP '".$value["prefijo"]."'";
                    print_r($sql."\n");
                    Yii::app()->db_masivo_premium->createCommand($sql)->execute();
                }

                print_r("Eliminando de la tabla insignia_masivo_premium.tmp_exentos todos los números que no posean una operadora valida\n");

                $sql = "DELETE FROM tmp_exentos WHERE id_operadora = 0";
                print_r($sql."\n");
                Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                print_r("Actualizando la columna tipo=2 a los numeros exentos cortos...\n");
                
                $sql = "UPDATE tmp_exentos SET tipo = 2 WHERE LENGTH(numero) < 10";
                print_r($sql."\n");
                Yii::app()->db_masivo_premium->createCommand($sql)->execute();

                $sql = "SELECT COUNT(id) AS total FROM tmp_exentos";
                print_r($sql."\n");
                $total = Yii::app()->db_masivo_premium->createCommand($sql)->queryRow();

                print_r("Cantidad de registros insertados en la tabla insignia_masivo_premium.tmp_exentos: ".$total["total"]."\n");
            }
            else
            {
                print_r("No hay registros en la tabla insignia_masivo.exentos\n");
            }

            print_r("Aplicando commit a la transaction...\n");
            $transaction->commit();

        } catch (Exception $e)
                {
                    print_r("Ocurrio un error al procesar los datos\n");
                    print_r($e);
                    $transaction->rollBack();
                }

        print_r("Hora de finalización: ".date("Y-m-d H:i:s"));

        print_r("\n----------------------------------------------------------------------------------------------------------------------\n");
    }
}

?>