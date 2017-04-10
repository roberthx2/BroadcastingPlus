<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="panel panel-default">
  <!-- Default panel contents -->
    <div class="panel-heading"><center><strong>Estimado asociado por exigencias de las operadoras existe una configuración para el envio de mensajería por cada hora del día, a continuación distribución de su promoción según disponibilidad: </strong></center></div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr><td colspan='4'></td></tr>
                <?php

                $mensaje = "No hay cupo disponible para la hora seleccionada<br>Puede crear la promocion para estas horas:";

                foreach ($_SESSION["timeslot"] as $value)
                {
                    $i = 1;
                    echo "<tr style='color: white; background-color: ".Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]).";'>";
                    echo    "<th colspan='4'><center>".$value["nombre"]." - Total SMS(".$value["cantidad_total"].")</center></th>";
                    echo "</tr>";
                    /*echo "<tr>";
                    echo    "<th colspan='4'><center>"
                         .$this->widget(
                        'booster.widgets.TbLabel',
                        array(
                            'context' => '',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => $value["nombre"],
                            'htmlOptions'=>array('style'=>'background-color: '.Yii::app()->Funciones->getColorOperadoraBCNL($value["id_operadora"]).';'),    
                        ), true
                    )." - Total SMS ".$this->widget('booster.widgets.TbBadge', array(
        'context' => 'success',
        // 'default', 'success', 'info', 'warning', 'danger'
        'label' => $value["cantidad_total"],
    ), true)."</center></th>";*/
                    echo "</tr>";
                    echo "<tr style='background-color:#E6E9ED;'>";
                    echo    "<th>#</th>";
                    echo    "<th>Inicio</th>";
                    echo    "<th>Fin</th>";
                    echo    "<th>SMS</th>";
                    echo "<tr>";

                    foreach ($value["resultado"] as $key)
                    {
                        echo "<tr>";
                        echo    "<td>".$i."</td>";
                        echo    "<td>".date_create($key["hora_ini"])->format('h:i a')."</td>";
                        echo    "<td>".date_create($key["hora_fin"])->format('h:i a')."</td>";
                        echo    "<td>".$key["total"]."</td>";
                        $i++;
                    }
                }

                //echo $mensaje;

                //print_r("<br><br>");
                ?>
            </table>
    </div>
</div>
</div>
<center>
<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Volver',
        'url' => Yii::app()->createUrl($this->route),
        //'onclick' => "history.go(-1)"
    )
); ?>

<?php $this->widget(
    'booster.widgets.TbButton',
    array(
        'context' => 'success',
        'label' => 'Crear Promoción',
        'buttonType' =>'link',
        'icon' => 'glyphicon glyphicon-ok',
        'url' => Yii::app()->controller->createUrl("promocion/generarPromocionBCP", array("id_proceso"=>$id_proceso, "timeslot"=>$timeslot)),
    )
); ?>
</center>

        
    