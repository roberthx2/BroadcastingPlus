<?php
/* @var $this PermisosController */
/* @var $data Permisos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_usuario), array('view', 'id'=>$data->id_usuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_sistema')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_sistema); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting_premium')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting_cpei')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting_cpei); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_promocion')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_promocion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_bcnl); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalles_promo_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->detalles_promo_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detalles_promo_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->detalles_promo_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_listas')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_listas')); ?>:</b>
	<?php echo CHtml::encode($data->crear_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_listas')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_listas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_cupo')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_cupo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recargar_cupo_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->recargar_cupo_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recargar_cupo_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->recargar_cupo_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('historico_cupo_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->historico_cupo_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('historico_cupo_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->historico_cupo_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_exentos')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_exentos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agregar_exentos')); ?>:</b>
	<?php echo CHtml::encode($data->agregar_exentos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_exentos')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_exentos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_reportes')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_reportes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_sms_programados_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_sms_programados_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_sms_programados_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_sms_programados_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_mensual_sms_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_mensual_sms_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_mensual_sms_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_mensual_sms_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_mensual_sms_por_cliente_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_mensual_sms_por_cliente_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_mensual_sms_por_cliente_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_mensual_sms_por_cliente_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_mensual_sms_por_codigo_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_mensual_sms_por_codigo_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_sms_recibidos_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_sms_recibidos_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_sms_recibidos_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_sms_recibidos_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_vigilancia_bcnl')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_vigilancia_bcnl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reporte_vigilancia_bcp')); ?>:</b>
	<?php echo CHtml::encode($data->reporte_vigilancia_bcp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_administracion')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_administracion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_btl')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_btl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modulo_herramientas')); ?>:</b>
	<?php echo CHtml::encode($data->modulo_herramientas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_prefijo')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_prefijo); ?>
	<br />

	*/ ?>

</div>