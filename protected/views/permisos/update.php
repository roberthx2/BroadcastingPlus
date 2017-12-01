<?php
/* @var $this PermisosController */
/* @var $model Permisos */
?>

<?php
    $flashMessages = Yii::app()->user->getFlashes();
    if ($flashMessages) {
        echo '<br><div class="container-fluid">';
        foreach($flashMessages as $key => $message) {
            echo '<div class="alert alert-'.$key.'">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<span class="glyphicon glyphicon-'. (($key == "success") ? "ok":"ban-circle").'"></span> '.$message;
        }
        echo '</div></div>';
    }
?>

<?php
	$form = $this->beginWidget(
	    'booster.widgets.TbActiveForm',
	    array(
	        'id' => 'clienteBcp-form',
	        'type' => 'vertical',
	        'enableAjaxValidation'=>false,
	        'enableClientValidation'=>true,
	        'clientOptions' => array(
	            'validateOnSubmit'=>true,
	            'validateOnChange'=>false,
	            //'afterValidate'=>'js:validarDatos'
	        ),
	    )
	);
?>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" align="left"><img class="img" src="<?php echo Yii::app()->request->baseUrl; ?>/img/user.png" align="middle" width="28" height="28"> &nbsp;&nbsp;<b> <?php echo UsuarioSmsController::actionGetLogin($model->id_usuario); ?></b></div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><b style="font-size: 17px;"> Acceso al Sistema &nbsp;&nbsp;
<?php
	Controller::widget(
		    'booster.widgets.TbSwitch',
		    array(
		        'name' => 'acceso_sistema',
			    'value' => $model->acceso_sistema,
			    'options' => array(
					'onColor'=>'success', 
					'offColor'=>'danger',
			    )
		    )
		);
?>

</b></div>
<br><HR width=100% align="center">

<div class="panel-group col-md-4" id="modulo">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-list-alt"></span> Modulos
      		</h4>
    	</div>
  		<div class="panel-body list-group">
  				<a href="#" class="list-group-item modulo active" id="promocion"> Promoción </a>
  				<a href="#" class="list-group-item modulo" id="listas"> Listas </a>
  				<a href="#" class="list-group-item modulo" id="cupo"> Cupo </a>
  				<a href="#" class="list-group-item modulo" id="reportes"> Reportes </a>
  				<a href="#" class="list-group-item modulo" id="herramientas"> Herramientas </a>
  				<a href="#" class="list-group-item modulo" id="btl"> Btl </a>
  				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
  					<a href="#" class="list-group-item modulo" id="administracion"> Administración </a> <?php } ?> 
   		</div>
  	</div>
</div>

<!--Promoción -->

<div class="accion panel-group col-md-7" id="act_promocion" style="display:block;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_promocion',
							    'value' => $model->modulo_promocion,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body modulo_promocion" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Crear BNCL
	  				<div style="float: right; align: middle;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_promo_bcnl',
								    'value' => $model->crear_promo_bcnl,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
  				<li class="list-group-item">Crear CPEI
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'broadcasting_cpei',
								    'value' => $model->broadcasting_cpei,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
  				<li class="list-group-item">Crear BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_promo_bcp',
								    'value' => $model->crear_promo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Crear Personalizada BNCL
	  				<div style="float: right; align: middle;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_promo_personalizada_bcnl',
								    'value' => $model->crear_promo_personalizada_bcnl,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Crear Personalizada BCP
	  				<div style="float: right; align: middle;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_promo_personalizada_bcp',
								    'value' => $model->crear_promo_personalizada_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
  				<li class="list-group-item">Ver detalles BCNL
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'detalles_promo_bcnl',
								    'value' => $model->detalles_promo_bcnl,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
  				<li class="list-group-item">Ver detalles BCP 
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'detalles_promo_bcp',
								    'value' => $model->detalles_promo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_promocion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
   		</div>	
  	</div>
</div>


<!--Listas -->

<div class="accion panel-group col-md-7" id="act_listas" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_listas',
							    'value' => $model->modulo_listas,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body modulo_listas" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Crear
	  				<div style="float: right; align: middle;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_listas',
								    'value' => $model->crear_listas,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_listas");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
  				<li class="list-group-item">Administrar
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'administrar_listas',
								    'value' => $model->administrar_listas,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_listas");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
   		</div>	
  	</div>
</div>

<!--Cupo -->

<div class="accion panel-group col-md-7" id="act_cupo" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_cupo',
							    'value' => $model->modulo_cupo,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body modulo_cupo" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Recarga BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'recargar_cupo_bcp',
								    'value' => $model->recargar_cupo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_cupo");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Histórico BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'historico_cupo_bcp',
								    'value' => $model->historico_cupo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_cupo");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
				<li class="list-group-item">Administrar Cupo BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'administrar_cupo_bcp',
								    'value' => $model->administrar_cupo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_cupo");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php } ?>
    		</ul>
   		</div>	
  	</div>
</div>

<!--Reportes -->

<div class="accion panel-group col-md-7" id="act_reportes" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_reportes',
							    'value' => $model->modulo_reportes,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body modulo_reportes" style="align:middle;">
  			<ul class="list-group">
  				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
  				<li class="list-group-item">SMS por Cliente BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'reporte_sms_por_cliente_bcp',
								    'value' => $model->reporte_sms_por_cliente_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_reportes");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php } ?>
				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
				<li class="list-group-item">SMS por código
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'reporte_sms_por_codigo_bcp',
								    'value' => $model->reporte_sms_por_codigo_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_reportes");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php } ?>
				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
				<li class="list-group-item">SMS por código / cliente
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'reporte_sms_por_codigo_cliente_bcp',
								    'value' => $model->reporte_sms_por_codigo_cliente_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_reportes");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php } ?>
				<?php if (UsuarioSmsController::actionIsAdmin($model->id_usuario)) { ?>
				<li class="list-group-item">Generar Reporte MT/MO
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'reporte_generar_mt_mo',
								    'value' => $model->reporte_generar_mt_mo,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_reportes");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<?php } ?>
				<li class="list-group-item">SMS Enviados BCP
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'reporte_sms_enviados_bcp',
								    'value' => $model->reporte_sms_enviados_bcp,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_reportes");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
   		</div>
  	</div>
</div>

<!--Herramientas -->

<div class="accion panel-group col-md-7" id="act_herramientas" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_herramientas',
							    'value' => $model->modulo_herramientas,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body modulo_herramientas" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Administrar Prefijos
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'administrar_prefijo',
								    'value' => $model->administrar_prefijo,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_herramientas");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
    		<ul class="list-group">
  				<li class="list-group-item">Administrar Exentos
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'modulo_exentos',
								    'value' => $model->modulo_exentos,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_herramientas");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
   		</div>	
  	</div>
</div>

<!--BTL -->

<div class="accion panel-group col-md-7" id="act_btl" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_btl',
							    'value' => $model->modulo_btl,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
  	</div>
</div>

<!--Administración -->

<div class="accion panel-group col-md-7" id="act_administracion" style="display:none;">
  	<div class="panel panel-grey">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_administracion',
							    'value' => $model->modulo_administracion,
							    'events' => array(
							        'switchChange' => 'js:function(event, state){
										unCheckAccion($(this).attr("name"), state);
							        }'
							    ),
							    'options' => array(
							    	'onColor'=>'success', 
										'offColor'=>'danger',
							    )
						    )
						);
				?></div>
      		</h4>
    	</div>
    	<div class="panel-body modulo_administracion" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Configurar Sistema
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'configurar_sistema',
								    'value' => $model->configurar_sistema,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Configurar SMS por día
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'configurar_sms_por_dia',
								    'value' => $model->configurar_sms_por_dia,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Configurar rervación por día
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'configurar_reservacion_por_dia',
								    'value' => $model->configurar_reservacion_por_dia,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Configurar reservación por operadora
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'configurar_reservacion_por_operadora',
								    'value' => $model->configurar_reservacion_por_operadora,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Configurar recarga BCP por día
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'configurar_recarga_cupo_bcp_por_dia',
								    'value' => $model->configurar_recarga_cupo_bcp_por_dia,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Administrar clientes
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'administrar_clientes',
								    'value' => $model->administrar_clientes,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Administrar usuarios
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'administrar_usuarios',
								    'value' => $model->administrar_usuarios,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
				<li class="list-group-item">Supervisar Log
	  				<div style="float: right;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'supervisar_log',
								    'value' => $model->supervisar_log,
								    'events' => array(
								        'switchChange' => 'js:function(event, state){
											unCheckModulo("modulo_administracion");
								        }'
								    ),
								    'options' => array(
								    	'onColor'=>'success', 
										'offColor'=>'danger',
								    )
							    )
							);
					?></div>
				</li>
    		</ul>
   		</div>
  	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">	
		<br><br>
		<input type="hidden" name="bandera" id="bandera" value="1">
	<?php
		echo CHtml::submitButton('Guardar Cambios', array('id' => 'bontonCrear', 'class'=>'btn btn-success'));
		$this->endWidget();
	    unset($form);
	?>
</div>


<style type="text/css">
	.list-group a
	{
		text-decoration: none;
	}

	.accion .list-group-item
	{
		height: 52px;
	}
	.accion .panel-title
	{
		height: 30px;
	}

</style>

<script type="text/javascript">

	function unCheckAccion(id, value)
	{
		$("." + id).find('input:checkbox').each(function(){
			$(this).each(function(){
				if ($(this).prop("checked") != value)
					$(this).bootstrapSwitch('state', value, true);
		    });
		});
	}

	function unCheckModulo(modulo)
	{
		var count = 0;

		$("." + modulo).find('input:checkbox').each(function(){
			$(this).each(function(){
				if ($(this).prop("checked"))
					count++;
		    });
		});

		if (count == 0 && $("#" + modulo).prop("checked"))
		{
			$("#" + modulo).bootstrapSwitch('state', false);	
		}
		else if (count > 0 && !$("#" + modulo).prop("checked"))
		{
			$("#" + modulo).bootstrapSwitch('state', true, true);
		}
	}

	$(document).ready(function() 
	{
		$(".modulo").click(function(){
			$(".accion").hide();
			$("#act_" + $(this).attr("id")).show();
			$(".modulo").removeClass("active");
			$("#" + $(this).attr("id")).addClass("active");
		});
	});

</script>