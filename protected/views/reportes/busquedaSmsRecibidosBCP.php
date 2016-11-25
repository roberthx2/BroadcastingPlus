
<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordionBCP">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title">
	        	<a data-toggle="collapse" data-parent="#accordionBCP" href="#collapseBCP">
	          		<span class="glyphicon glyphicon-search"></span> Consultar
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseBCP" class="panel-collapse collapse in">
	      	<div class="panel-body">
				<?php 
					$form = $this->beginWidget(
					'booster.widgets.TbActiveForm',
					array(
						//'id' => 'lista-form',
						'action'=>Yii::app()->createUrl($this->route/*, array("id_proceso"=>$id_proceso)*/),
						'method'=>'get',
						'type' => 'vertical',
						//'enableAjaxValidation'=>true,
						//'enableAjaxValidation'=>false,
					)
				);
				?>
				<div class="form-group">

					<?php 
						$sql = "SELECT GROUP_CONCAT(id_cliente) AS ids FROM usuario_cliente_operadora WHERE id_usuario = ".Yii::app()->user->id;
						$id_clientes = Yii::app()->db_insignia_alarmas->createCommand($sql)->queryRow();
						$id_clientes = $id_clientes["ids"];

						if ($id_clientes == "")
							$id_clientes = "null";

						echo $form->dropDownListGroup(
						$model,
						'id_cliente',
						array(
							'wrapperHtmlOptions' => array(
								//'class' => 'col-sm-5',
							),
							'widgetOptions' => array(
								'data' => CHtml::listData(ClienteAlarmas::model()->findAll(array("select"=>"id, REPLACE(descripcion, '@', '') AS descripcion", "condition"=>"id IN(".$id_clientes.")", "order"=>"descripcion")), 'id', 'descripcion'),
							),
							'prepend' => '<i class="glyphicon glyphicon-user"></i>',
						)
					); ?>

					<?php echo $form->dropDownListGroup(
						$model,
						'mes',
						array(
							'wrapperHtmlOptions' => array(
								//'class' => 'col-sm-5',
							),
							'widgetOptions' => array(
								'data' => array("01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril", "05"=>"Mayo", "06"=>"Junio", "07"=>"Julio", "08"=>"Agosto", "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre"),
								'htmlOptions' => array('options'=>array(date("m")=>array('selected'=>true))),
							),
							'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
						)
					); ?>

					<?php echo $form->dropDownListGroup(
						$model,
						'id_promo',
						array(
							'wrapperHtmlOptions' => array(
								'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
								'style'=>'display: none;',
							),
							'widgetOptions' => array(
								'htmlOptions' => array('prompt' => 'Seleccionar...',), //col-xs-12 col-sm-4 col-md-4 col-lg-4
							),
							'prepend' => '<i class="glyphicon glyphicon-user"></i>',
						)
					); ?>

				  	<?php $this->widget(
				    'booster.widgets.TbButton',
				        array(
				            'context' => 'primary',
				            'label' => 'Consultar',
				            'buttonType' =>'submit',
				            'icon' => 'glyphicon glyphicon-search',
				            'htmlOptions' => array("style"=>"float:right;"),
				        )
				    ); ?>
				</div><!-- /.col-lg-6 -->
				<?php $this->endWidget(); ?>
				</div><!-- Search-form -->
			</div>
	    </div>
	</div>

<?php $this->endWidget(); ?>

