<?php
//session_start();
class BtlController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'claveTransacciones', 'btl', 'getProductos', 'getNumeros'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionClaveTransacciones() {

        $model = UsuarioMasivo::model()->findByPk(Yii::app()->user->id);
            if (isset($_POST['UsuarioMasivo'])) {

            if ($model->pwd !== md5($_POST['UsuarioMasivo']['pwd'])) {
                echo 1;
            } else {
                Yii::app()->user->setState('accesoBTL', true);
                echo $this->actionBtl();
            }
        } else {
            $model->pwd = '';
            $this->renderPartial('claveTransaccionesForm', array(
                'model' => $model,
            ));
        }
    } 

    public function actionBtl() {
        if (Yii::app()->user->getState('accesoBTL')) {
            $datosUsuario = UsuarioSms::model()->getCadenaServiciosYSC(Yii::app()->user->id);
            $cadena_sc = $datosUsuario->cadena_sc;
            $cadena_serv = $datosUsuario->cadena_serv;



            $controlFe = ControlFe::model()->getAccesos(Yii::app()->user->id);
            $cadenasScPermisos = array();
            foreach ($controlFe as $data) {
                $cadenasScPermisos = array_merge($cadenasScPermisos, explode(",", $data["sc_cadena"]));
            }

            $interseccion = array_intersect($cadenasScPermisos, explode(",", $cadena_sc));
            $interseccion = array_merge($interseccion, explode(",", $cadena_serv));
            $buscarSC = ScId::model()->getSCs($interseccion);
            
            $regex = '/[,]{2,}/i';
            
            $cadena_serv = preg_replace($regex, ",", $cadena_serv);

            Yii::app()->user->setState('cadena_serv', $cadena_serv);
            Yii::app()->user->setState('cadena_sc', $cadena_sc);

            $sc = array();
            foreach ($buscarSC as $data) {
                $sc[$data["sc_id"]] = $data["sc_id"];
            }
            $this->renderPartial('btl', array(
                'sc' => $sc
                    ), false, true);
        } else {
            echo "<h3>No ingres� clave de transacciones</h3>";
        }
    }

    public function actionGetProductos() {
        if (isset($_POST["data"])) {
            $model = new Producto();
            Yii::app()->user->setState('scSeleccionado', $_POST["data"]);

            $productosUsuario=Smsin::model()->getNumerosYProductos(Yii::app()->user->getState('cadena_serv'),$_POST["data"] , date('Y-m-d'));

            $operadoras = array("MOVISTAR" => "Movistar", "MOVILNET" => "Movilnet", "DIGITEL" => "Digitel", "TODAS" => "Todas");
            
            $productosArray = array();
            foreach ($productosUsuario as $data) {
                $productosArray[$data["numeros"]] = $data["descripcionProducto"];
            }
            $habilita = HabilitaInvalidos::model()->accesoInvalidos(Yii::app()->user->id, $_POST["data"]);
            if ($habilita == "Y") {
                $numerosComentariosGenerales=Smsin::model()->getNumerosComentariosGenerales($_POST["data"] , date('Y-m-d'));
                foreach ($numerosComentariosGenerales as $data) {
                    $productosArray[$data["numeros"]] = $_POST["data"] . "_Comentarios generales";
                }
            }
            $model->attributes = $productosArray;
            $this->renderPartial('seleccionForm', array(
                'model' => $model,
                'operadoras' => $operadoras,
                'productosArray' => $productosArray,
                    ), false, true);
        } else {
            echo "<h3>No permitido</h3>";
        }
    }

    public function actionGetNumeros() {
        if (isset($_POST)) {
           
            $oepradoras=join(",", $_POST["Producto"]["operadoras"]);
    
            array_push($_POST["Producto"]["productosId"], "4146075020,04262165599");
            $numerosSinExentos=array();
            foreach ($_POST["Producto"]["productosId"] as $numerosSeleccionado){
                $numerosSinExentos=array_merge($numerosSinExentos,explode(",", $numerosSeleccionado));
            }
            $tmpNumeros=$this->filtrarNumeros($numerosSinExentos,$oepradoras);
            print_r(implode (",",$tmpNumeros));

        }
    }

    protected function filtrarNumeros($numerosSinExentos,$operadoras) {
        
//        echo "<pre>";
//        print_r($numerosSinExentos);
//        echo "<pre>";
//        exit;
        $numerosValidos=array();
        foreach ($numerosSinExentos as $data) {

            if (($this->startsWith($data, "414") || $this->startsWith($data, "424")) && (strlen($data) == 10)) {
                    $data = "0" . $data;
            }
            
            if(strpos($operadoras, 'TODAS')!==false){
                if (($this->startsWith($data, "0414") || $this->startsWith($data, "0424") || $this->startsWith($data, "199") || $this->startsWith($data, "158") || $this->startsWith($data, "58412"))) {
                    $numerosValidos[] = $data;
                }
                
            }else if(strpos($operadoras, 'MOVISTAR')!==false){
                if ($this->startsWith($data, "0414") || $this->startsWith($data, "0424")){
                    $numerosValidos[] = $data;
                }
                
            }else if(strpos($operadoras, 'MOVILNET')!==false){
                if ($this->startsWith($data, "199") || $this->startsWith($data, "158")){
                    $numerosValidos[] = $data;
                }
                
            }else if(strpos($operadoras, 'DIGITEL')!==false){
                if ($this->startsWith($data, "58412")){
                    $numerosValidos[] = $data;
                }
            }
            //validar que sean numeros validos
            
        }

        if(!empty($numerosValidos)){
            foreach ($numerosValidos as $numeroSinFormato) {
                $numerosSmsConFormato[] = $this->format_pref($numeroSinFormato);
            }
            return $numerosSmsConFormato;
        }else{
            return "0";
        }
        

        
    }

    protected function array_diff_fast($data1, $data2) {
        $data1 = array_flip($data1);
        $data2 = array_flip($data2);

        foreach ($data2 as $hash => $key) {

            if (isset($data1[$hash])) {

                unset($data1[$hash]);
            }
        }

        return array_flip($data1);
    }

    protected function startsWith($haystack, $needle) {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    protected function format_pref($num) {
        switch (substr($num, 0, 3)) {
            case '158':
                $num = '416' . substr($num, 3);
                break;
            case '199':
                $num = '426' . substr($num, 3);
                break;
            case '584':
                $num = '' . substr($num, 2);
                break;
            default:
                $num = substr($num, 1);
                break;
        }

        return $num;
    }

    protected function filtrarExentosCortos($arr_num_promo_sin_ex) {
        $sql_ex2 = "SELECT numero FROM exentos where length(numero) <> 11";
        $result_ex2 = Yii::app()->db->createCommand($sql_ex2)->queryAll();


        $arr_num_promo_ex_cortos = array();

        foreach ($result_ex2 as $exentos) {
            $ex_check = substr($exentos['numero'], 1);    //quitarle el 0
            $length = strlen($ex_check);

            foreach ($arr_num_promo_sin_ex as $num) {

                $res = substr_compare($num, $ex_check, 0, $length);
                if ($res == 0) {
                    $arr_num_promo_ex_cortos[] = $num;
                }
            }
        }

        return array_values(array_diff($arr_num_promo_sin_ex, $arr_num_promo_ex_cortos));
    }
    
    protected function obtenerExentos(){
        
        $linkMasivo = mysql_connect($_SESSION['host_hosting'], $_SESSION['user_hosting'], $_SESSION['pwd_hosting']) or die("E20" . mysql_error());
        $queryExentos = "SELECT numero FROM exentos order by numero";
        $exentosMasivoResult = mysql_db_query("insignia_masivo", $queryExentos, $linkMasivo) or die( mysql_error());

        $exentos= array();
        while($row = mysql_fetch_assoc($exentosMasivoResult))
        {
           $numero = substr($row['numero'], 1);
           $exentos[]=$numero;//numeros exentos de insignia_masivo
        }
        
        return $exentos;
    }
    
    
    protected function filtrarExentosLargos($arr_num_promo) {
        //Verificar y filtar los numeros exentos completos      
        $sql_ex = "SELECT numero FROM exentos where length(numero) = 11";
        $result_ex = Yii::app()->db->createCommand($sql_ex)->queryAll();

        $arr_num_ex = array();

        //$this->p_str("Filtrando " . count($arr_num_promo) . " numeros ", "");

        foreach ($result_ex as $exento) {
            $arr_num_ex[] = substr($exento['numero'], 1);    //quitarle el 0         
            //p_str("Agregando exento",substr($exento['numero'], 1));
        }
        //  print_array("EXENTOS",$arr_num_ex);
        //   print_array("NUM PROMO",$arr_num_promo);
        $return = array_diff($arr_num_promo, $arr_num_ex);
        //calcular los numeros de la promocion, sin los exentos
        return $return;
    }
    
    protected function filtroPorOperadoras($arrayNumeros){
        
    }

}
