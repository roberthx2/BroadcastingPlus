<?php
/* @var $this AccesosController */
/* @var $data Accesos */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_usuario), array('view', 'id'=>$data->id_usuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_conciliacion')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_conciliacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_CRS')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_CRS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_detalles')); ?>:</b>
	<?php echo CHtml::encode($data->ver_detalles); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_destinatarios')); ?>:</b>
	<?php echo CHtml::encode($data->ver_destinatarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_enviados')); ?>:</b>
	<?php echo CHtml::encode($data->sms_enviados); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_lista')); ?>:</b>
	<?php echo CHtml::encode($data->crear_lista); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_lista')); ?>:</b>
	<?php echo CHtml::encode($data->ver_lista); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editar_lista')); ?>:</b>
	<?php echo CHtml::encode($data->editar_lista); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editar_detalles')); ?>:</b>
	<?php echo CHtml::encode($data->editar_detalles); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('editar_destinatarios')); ?>:</b>
	<?php echo CHtml::encode($data->editar_destinatarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_prog')); ?>:</b>
	<?php echo CHtml::encode($data->sms_prog); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_not')); ?>:</b>
	<?php echo CHtml::encode($data->crear_not); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_not')); ?>:</b>
	<?php echo CHtml::encode($data->ver_not); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agregar_exen')); ?>:</b>
	<?php echo CHtml::encode($data->agregar_exen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_exen')); ?>:</b>
	<?php echo CHtml::encode($data->ver_exen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eliminar_exen')); ?>:</b>
	<?php echo CHtml::encode($data->eliminar_exen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num_cruzados')); ?>:</b>
	<?php echo CHtml::encode($data->num_cruzados); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_accesos')); ?>:</b>
	<?php echo CHtml::encode($data->admin_accesos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_puertos_usuario')); ?>:</b>
	<?php echo CHtml::encode($data->admin_puertos_usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_puertos_ver')); ?>:</b>
	<?php echo CHtml::encode($data->admin_puertos_ver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_puertos_crear')); ?>:</b>
	<?php echo CHtml::encode($data->admin_puertos_crear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_puertos_editar')); ?>:</b>
	<?php echo CHtml::encode($data->admin_puertos_editar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_puertos_eliminar')); ?>:</b>
	<?php echo CHtml::encode($data->admin_puertos_eliminar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_cupo')); ?>:</b>
	<?php echo CHtml::encode($data->admin_cupo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_prefijos_ver')); ?>:</b>
	<?php echo CHtml::encode($data->admin_prefijos_ver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_prefijos_editar')); ?>:</b>
	<?php echo CHtml::encode($data->admin_prefijos_editar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_prefijos_eliminar')); ?>:</b>
	<?php echo CHtml::encode($data->admin_prefijos_eliminar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_recibidos')); ?>:</b>
	<?php echo CHtml::encode($data->sms_recibidos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_exentos_propuestos')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_exentos_propuestos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_enviados_por_cliente')); ?>:</b>
	<?php echo CHtml::encode($data->sms_enviados_por_cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_personalizada')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_personalizada); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_pruebas_modems')); ?>:</b>
	<?php echo CHtml::encode($data->admin_pruebas_modems); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_modem_sin_saldo')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_modem_sin_saldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_reasignar_puertos_por_promo')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_reasignar_puertos_por_promo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_reporte_vigilancia')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_reporte_vigilancia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_terminos_condiciones')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_terminos_condiciones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_aprobar_promocion')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_aprobar_promocion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administrar_operadoras')); ?>:</b>
	<?php echo CHtml::encode($data->administrar_operadoras); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('habilitar_modem_inactivos')); ?>:</b>
	<?php echo CHtml::encode($data->habilitar_modem_inactivos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generar_reporte_sms_recibidos')); ?>:</b>
	<?php echo CHtml::encode($data->generar_reporte_sms_recibidos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting_premium')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_premium')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_detalles_premium')); ?>:</b>
	<?php echo CHtml::encode($data->ver_detalles_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ver_reporte_premium')); ?>:</b>
	<?php echo CHtml::encode($data->ver_reporte_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generar_reporte_sms_recibidos_premium')); ?>:</b>
	<?php echo CHtml::encode($data->generar_reporte_sms_recibidos_premium); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broadcasting_lite')); ?>:</b>
	<?php echo CHtml::encode($data->broadcasting_lite); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crear_promo_lite')); ?>:</b>
	<?php echo CHtml::encode($data->crear_promo_lite); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reactivar_promo')); ?>:</b>
	<?php echo CHtml::encode($data->reactivar_promo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acceso_en_suspension')); ?>:</b>
	<?php echo CHtml::encode($data->acceso_en_suspension); ?>
	<br />

	*/ ?>

</div>