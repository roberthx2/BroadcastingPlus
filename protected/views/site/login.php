<div  id="page-content-wrapper">
<?php 
	if($error == true ): ?>
		
	    <div class="container-fluid">
	      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        <div class="alert alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          <span class="glyphicon glyphicon-ban-circle"></span> <?php echo "Acceso Denegado"; ?>
	        </div>
	      </div>
	    </div>
	  
	 <?php endif; ?>
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
?>
	<div class="form col-xs-12 col-sm-4 col-md-4 col-lg-3" >
		<h2>Login</h2>
		<?php 

		$form = $this->beginWidget(
			'booster.widgets.TbActiveForm',
			array(
				'id' => 'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				//'type' => 'horizontal',
				//'htmlOptions' => array('style'=>'aling:center'),
				//'htmlOptions' => array('class' => 'well'),
			)
		);

		?>	
	
		<div >
				<?php echo $form->textFieldGroup($model,'username',array(
					'prepend' => '<i class="glyphicon glyphicon-user"></i>',
					'widgetOptions' => array(
					)
				)); ?>
		</div>

		<div>
			<?php echo $form->passwordFieldGroup($model,'password',array(
					'prepend' => '<i class="glyphicon glyphicon-pencil"></i>',
					'widgetOptions' => array(
					)
				)); ?>
		</div>

		<div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<?php echo $form->checkboxGroup(
				$model,
				'rememberMe',
				array(
				)
			); ?>
			<?php echo $form->error($model,'rememberMe'); ?></div><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

			<?php $this->widget(
					'booster.widgets.TbButton',
					array(
						'buttonType' => 'submit',
						'context' => 'success',
						'label' => 'Iniciar Session',
					)
				); ?></div>
		</div>

	</div><!-- form -->
<?php $this->endWidget(); ?>
</div>