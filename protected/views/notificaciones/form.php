
<div id="page-content-wrapper">

    <div class="form col-xs-12 col-sm-12 col-md-12 col-lg-12" >

    <?php 

    $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id' => 'lista-form',
            'type' => 'vertical',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('class' => 'well'),
        )
    ); ?>

    <fieldset>
     
        <legend>Crear Notificación</legend>


    <?php if (!Yii::app()->user->isAdmin()){ ?>
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
                    'hint' => 'En caso de <em>NO</em> seleccionar un usuario, la notificación sera enviada a todos los usuarios.',
                )
            ); ?>
        </div>
    <?php } 
        else
        {
            echo "Al crear una notificación esta sera enviada al area encargada de <em><strong>Insignia Mobile Communications, C.A.</strong></em> <br><br>";
        }
    ?>

    <?php 

    echo $form->html5EditorGroup(
            $model,
            'mensaje',
             array(
                'widgetOptions' => array(
                    'editorOptions' => array(
                        'class' => 'span4',
                        'rows' => 5,
                        'options' => array('color' => true),
                    ),
                    'height' => '50%',
                    'width' => '100%',
                    'htmlOptions'=>array('id'=>'mensaje'),
                ),
            )
        ); 
    ?>

    <?php /*echo $form->textAreaGroup(
        $model,
        'mensaje',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-12 col-md-12 col-lg-12',
            ),
            'widgetOptions' => array(
                'htmlOptions' => array('rows' => 5, 'maxlength' => 1000, 'style'=> 'resize:none;','onMouseDown' => 'contarCaracterRestantes(this,1000)', 'onChange' => 'contarCaracterRestantes(this,1000)', 'onBlur' => 'contarCaracterRestantes(this,1000)','onKeyDown' => 'contarCaracterRestantes(this,1000)','onFocus' => 'contarCaracterRestantes(this,1000)','onKeyUp' => 'contarCaracterRestantes(this,1000)'),
            ),
            'prepend' => '<i class="glyphicon glyphicon-envelope"></i>'
        )
    );*/ ?>

    <div style="float: right; font: bold 13px Arial;"><strong>Caracteres restantes:</strong>
                <?php echo CHTML::textField('caracteres',1000,array('size'=>2 ,'style'=>'align:right; margin-left:10px; border:0;', 'readonly' => true)); ?></div>

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
                            'label' => 'Enviar notificación',
                        )
                    ); ?>
            </div>
        </div>
    </div><!-- form -->
    <?php $this->endWidget(); ?>
<div>

<script type="text/javascript">
    function contar()
    {
        var caracter;

        caracter = new String(document.crearP.contenido.value);

        if(caracter.length>158)
        {
            crearP.contenido.value = caracter.substring(0, 158);
        } else
            {
                crearP.caracteres.value = (158-caracter.length);
            }
    }
</script>
