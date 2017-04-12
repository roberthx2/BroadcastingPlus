
<div id="page-content-wrapper">

    <div class="form col-xs-12 col-sm-12 col-md-12 col-lg-12" >

    <?php 

    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'lista-form',
            'type' => 'horizontal',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('class' => 'well'),
        )
    ); ?>

    <fieldset>
     
        <legend>Crear Notificación</legend>

    <?php if (Yii::app()->user->isAdmin()){ ?>
        <div>
            <?php echo $form->dropDownListGroup(
                $model,
                'id_usuario',
                array(
                    'wrapperHtmlOptions' => array(
                        //'class' => 'col-sm-5',
                    ),
                    'widgetOptions' => array(
                        'data' => CHtml::listData(UsuarioMasivo::model()->findAll(array("order"=>"login")), 'id_usuario', 'login'),
                        'htmlOptions' => array('prompt' => 'Seleccionar...'),
                    ),
                    'prepend' => '<i class="glyphicon glyphicon-user"></i>',
                    'hint' => 'En caso de no selecciionar un usuario, la notificación sera enviada a todos los usuarios.',
                )
            ); ?>
        </div>
    <?php } ?>

    <?php echo $form->html5EditorGroup(
            $model,
            'mensaje',
             array(
                'widgetOptions' => array(
                    'editorOptions' => array(
                        'class' => 'span4',
                        'rows' => 5,
                        'height' => '150',
                        'options' => array('color' => true)
                    ),
                )
            )
        ); 
    ?>
    </fieldset>
        <br><br>
        <div>
            <div class="col-xs-offset-4 col-sm-offset-10 col-md-offset-10 col-lg-offset-10">
            <?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
                <?php $this->widget(
                        'booster.widgets.TbButton',
                        array(
                            'buttonType' => 'submit',
                            'context' => 'success',
                            'label' => 'Crear notificación',
                        )
                    ); ?>
            </div>
        </div>
    </div><!-- form -->
    <?php $this->endWidget(); ?>
<div>

