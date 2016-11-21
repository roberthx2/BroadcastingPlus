
<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	      	<h4 class="panel-title">
	        	<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
	          		<span class="glyphicon glyphicon-search"></span> Consultar
	        	</a>
	      	</h4>
	    </div>
	    <div id="collapseOne" class="panel-collapse collapse in">
	      	<div class="panel-body">
				<?php 
					$form = $this->beginWidget(
					'booster.widgets.TbActiveForm',
					array(
						//'id' => 'lista-form',
						'action'=>Yii::app()->createUrl($this->route/*, array("id_proceso"=>$id_proceso)*/),
						'method'=>'get',
						'type' => 'vertical',
						//'enableAjaxValidation'=>false,
					)
				);
				?>
				<div class="form-group">
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
						'ano',
						array(
							'wrapperHtmlOptions' => array(
								//'class' => 'col-sm-5',
							),
							'widgetOptions' => array(
								'data' => array(
									//date('Y',strtotime('-2 year', strtotime(date('Y'))))=>date('Y',strtotime('-2 year', strtotime(date('Y')))), 
									date('Y',strtotime('-1 year', strtotime(date('Y'))))=>date('Y',strtotime('-1 year', strtotime(date('Y')))),
									date('Y')=>date('Y'),
									),
								'htmlOptions' => array('options'=>array(date("Y")=>array('selected'=>true))),	
							),
							'prepend' => '<i class="glyphicon glyphicon-calendar"></i>',
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