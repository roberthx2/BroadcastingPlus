<?php

$mensaje = "No hay cupo disponible para la hora seleccionada<br>Puede crear la promocion para estas horas:";

foreach ($_SESSION["timeslot"] as $value)
{
    $mensaje .= "<br>".$value["nombre"]." - Total SMS(".$value["cantidad_total"].")<br>";
    $i = 1;

    foreach ($value["resultado"] as $key)
    {
        $mensaje .= "<br>Promo #".$i." SMS(".$key["total"]."): Hora: ".date_create($key["hora_ini"])->format('h:i a')." / ".date_create($key["hora_fin"])->format('h:i a');
        $i++;
    }
}

echo $mensaje;

print_r("<br><br>");
?>

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
