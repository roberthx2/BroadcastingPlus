<?php
/* @var $this PermisosController */
/* @var $model Permisos */
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
		    )
		);
?>

</b></div>
<br><HR width=100% align="center">

<div class="panel-group col-md-4" id="modulo">
  	<div class="panel panel-black">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-list-alt"></span> Modulos
      		</h4>
    	</div>
  		<div class="panel-body list-group">
  				<a href="#" class="list-group-item modulo" id="promocion"> Promoción </a>
  				<a href="#" class="list-group-item modulo" id="listas"> Listas </a>
  				<a href="#" class="list-group-item modulo" id="cupo"> Cupo </a>
  				<a href="#" class="list-group-item modulo" id="reportes"> Reportes </a>
  				<a href="#" class="list-group-item modulo" id="herramientas"> Herramientas </a>
  				<a href="#" class="list-group-item modulo" id="btl"> Btl </a>
  				<a href="#" class="list-group-item modulo" id="administracion"> Administración </a>
   		</div>
  	</div>
</div>

<!--Promoción -->

<div class="accion panel-group col-md-7" id="act_promocion" style="display:none;">
  	<div class="panel panel-black">
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
  	<div class="panel panel-black">
    	<div class="panel-heading">
      		<h4 class="panel-title">
          		<span class="glyphicon glyphicon-eye-open"></span> Acciones
          		<div style="float: right; align: middle;"><?php
					Controller::widget(
						    'booster.widgets.TbSwitch',
						    array(
						        'name' => 'modulo_listas',
							    'value' => $model->modulo_listas,
						    )
						);
				?></div>
      		</h4>
    	</div>
  		<div class="panel-body" style="align:middle;">
  			<ul class="list-group">
  				<li class="list-group-item">Crear
	  				<div style="float: right; align: middle;"><?php
						Controller::widget(
							    'booster.widgets.TbSwitch',
							    array(
							        'name' => 'crear_listas',
								    'value' => $model->crear_listas,
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
	
	function showAction(object)
	{
		console.log(object);
	}

	function unCheckAccion(id, value)
	{
		$("." + id).find('input:checkbox').each(function(){
			$(this).each(function(){
				if ($(this).prop("checked") != value)
					$(this).click();
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

		console.log(count);

		if (count == 0 && $("#" + modulo).prop("checked"))
		{
			$("#" + modulo).click();	
		}
		else if (count > 0 && !$("#" + modulo).prop("checked"))
		{
			$("#" + modulo).click();	
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